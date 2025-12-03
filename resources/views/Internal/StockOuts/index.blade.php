@extends('layouts.app')

@section('title', 'Stock Out List')

@section('content')
<div class="container">
    <h1 class="mb-4">Stock Out List</h1>

    <div class="mb-3">
        <a href="{{ route('stock-out.create') }}" class="btn btn-primary">Create New Stock Out</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Reference</th>
                        <th>Processed By</th>
                        <th>Total Items</th>
                        <th>Total Value</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stockOuts as $stockOut)
                        <tr>
                            <td>{{ $stockOut->reference }}</td>
                            <td>{{ $stockOut->processor->name ?? '-' }}</td>
                            <td>{{ $stockOut->total_items }}</td>
                            <td>Rp {{ number_format($stockOut->total_value, 0, ',', '.') }}</td>
                            <td>{{ $stockOut->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <!-- Tambahkan actions jika perlu, misal view detail -->
                                <a href="#" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No stock outs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $stockOuts->links() }}
        </div>
    </div>
</div>
@endsection