@extends('layouts.app')

@section('title', 'All Transactions')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Stok</h1>

    <div class="mb-3">
        <a href="{{ route('transactions.export') }}" class="btn btn-success">Export</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tipe</th>
                        <th>Serial Number</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Penanggung Jawab</th>
                        <th>Catatan</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->serial->serial_number ?? 'N/A' }}</td>
                            <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->note ?? '-' }}</td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
