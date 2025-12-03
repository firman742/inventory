<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $counter = 1;
        return Transaction::with(['serial', 'product', 'user'])->get()->map(function ($transaction) use (&$counter) {
            return [
                'No.' => $counter++,
                'Type' => $transaction->type,
                'Serial Number' => $transaction->serial->serial_number ?? 'N/A',
                'Product' => $transaction->product->name ?? 'N/A',
                'Price' => $transaction->price,
                'User' => $transaction->user->name ?? 'N/A',
                'Note' => $transaction->note ?? '-',
                'Created At' => $transaction->created_at->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe',
            'Serial Number',
            'Produk',
            'Harga',
            'Penanggung Jawab',
            'Catatan',
            'Dibuat Pada',
        ];
    }
}
