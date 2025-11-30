<?php

namespace App\Http\Controllers\Internal;

use App\Models\Serial;
use App\Models\StockInBatch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class StockInBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockInBatches = StockInBatch::with('receiver')->get();
        return view('Internal.StockInBatches.index', compact('stockInBatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stockInBatch = StockInBatch::all();
        return view('Internal.StockInBatches.create', compact('stockInBatch'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'original_price' => 'required|numeric|min:0',
        ]);

        $validated['in_items'] = 0;
        $validated['remaining_items'] = 0;
        $validated['out_items'] = 0;
        $validated['received_by'] = session('user')->id;

        StockInBatch::create($validated);

        return redirect()->route('stock-in.index')->with('success', 'Stock In Batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockInBatch $stockInBatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockInBatch $stock_in)
    {
        return view('Internal.StockInBatches.edit', [
            'stockInBatch' => $stock_in
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockInBatch $stock_in)
    {
        $validated = $request->validate([
            'reference' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'original_price' => 'required|numeric|min:0',
        ]);

        $stock_in->update($validated);

        return redirect()->route('stock-in.index')->with('success', 'Stock In Batch updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockInBatch $stockInBatch)
    {
        $stockInBatch->delete();
        return redirect()->route("stock-in.index")->with('success', 'Stock In Batch deleted successfully.');
    }

    /**
     * Undocumented function
     *
     * @param StockInBatch $stock_in
     * @return void
     */
    public function serials(StockInBatch $stock_in)
    {
        $products = Product::all();
        $serials = $stock_in->serials()->with('product', 'addedBy')->get();
        return view('Internal.StockInBatches.scanning', [
            'products' => [],
            'stockInBatch' => $stock_in,
            'serials' => $serials
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param StockInBatch $stock_in
     * @return void
     */
    public function storeSerial(Request $request, StockInBatch $stock_in)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|max:255|unique:serials,serial_number',
            'product_id' => 'required|uuid|exists:products,id',
            'unit_price' => 'required|numeric|min:0'
        ]);

        $validated['stock_in_batch_id'] = $stock_in->id;
        $validated['status'] = 'in_stock';
        $validated['added_by'] = session('user')->id;

        // 1. Insert serial
        Serial::create($validated);

        // 2. Update counters
        $stock_in->increment('in_items');
        $stock_in->increment('remaining_items');

        return back()->with('success', 'Serial berhasil ditambahkan.');
    }
}
