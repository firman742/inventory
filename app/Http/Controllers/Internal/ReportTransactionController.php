<?php
namespace App\Http\Controllers\Internal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportTransactionController extends Controller
{
    // Show all transactions
    public function index()
    {
        $transactions = Transaction::with(['serial', 'product', 'user'])->paginate(10);
        return view('Internal.ReportTransactions.index', compact('transactions'));
    }
    // Export to Excel
    public function export()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }
}