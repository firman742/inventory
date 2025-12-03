<?php

namespace App\Http\Controllers\Internal;

use App\Models\User;
use App\Models\Serial;
use App\Models\StockOut;
use App\Models\Transaction;
use App\Models\StockInBatch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\TypeTransaction;
use Illuminate\Support\Facades\Log;

class StockOutController extends Controller
{
    // List semua StockOut
    public function index()
    {
        $stockOuts = StockOut::with('processor')->paginate(10);
        return view('Internal.StockOuts.index', compact('stockOuts'));
    }

    // Form create StockOut (halaman scanning untuk pilih serial)
    public function create()
    {
        $users = User::all();
        return view('Internal.StockOuts.create', compact('users'));
    }

    // API untuk validasi scan di create (cek serial valid)
    public function validateScan(Request $request): JsonResponse
    {
        $request->validate([
            'serial_number' => 'required|string',
        ]);

        $serial = Serial::where('serial_number', $request->serial_number)->first();

        if (!$serial) {
            return response()->json([
                'success' => false,
                'message' => 'Serial tidak ditemukan di database.',
            ]);
        }

        if ($serial->status !== 'in_stock') {
            return response()->json([
                'success' => false,
                'message' => 'Serial sudah out atau lost. Status: ' . $serial->status,
            ]);
        }

        session(['pending_stock_out_serial' => $serial->id]);

        return response()->json([
            'success' => true,
            'message' => 'Serial valid. Lanjutkan ke input harga jual.',
            'serial' => $serial,
        ]);
    }

    // Form input total_value setelah scan valid
    public function confirmCreate()
    {
        $serialId = session('pending_stock_out_serial');
        if (!$serialId) {
            return redirect()->route('stock-out.create')->with('error', 'Silakan scan serial terlebih dahulu.');
        }

        $serial = Serial::find($serialId);
        $users = User::all();
        return view('Internal.StockOuts.confirm', compact('serial', 'users'));
    }

    // Store StockOut baru setelah input total_value
    public function store(Request $request)
    {
        $serialId = session('pending_stock_out_serial');
        if (!$serialId) {
            return redirect()->route('stock-out.create')->with('error', 'Session expired. Silakan scan ulang.');
        }

        $request->validate([
            'reference' => 'required|string|unique:stock_outs',
            'processed_by' => 'required|exists:users,id',
            'total_value' => 'required|numeric|min:0',
        ]);

        $serial = Serial::find($serialId);
        if (!$serial || $serial->status !== 'in_stock') {
            session()->forget('pending_stock_out_serial');
            return redirect()->route('stock-out.create')->with('error', 'Serial tidak valid atau sudah diproses.');
        }

        // Update serial status
        $serial->update(['status' => 'out']);

        // Update StockInBatch
        $batch = StockInBatch::find($serial->stock_in_batch_id);
        if ($batch) {
            $batch->increment('out_items');
            $batch->decrement('in_items');
            $batch->update(['remaining_items' => $batch->in_items - $batch->out_items]);
        }

        // Create Transaction
        Transaction::create([
            'type' => TypeTransaction::STOCK_OUT->value,
            'serial_id' => $serial->id,
            'product_id' => $serial->product_id,
            'user_id' => $request->processed_by,
            'qty' => 1,
            'price' => $request->total_value,
            'note' => 'Stock out via create with scan',
        ]);

        // Create StockOut
        StockOut::create([
            'reference' => $request->reference,
            'processed_by' => $request->processed_by,
            'total_items' => 1,
            'total_value' => $request->total_value,
        ]);

        session()->forget('pending_stock_out_serial');

        return redirect()->route('stock-out.index')->with('success', 'Stock Out berhasil dibuat.');
    }
}
