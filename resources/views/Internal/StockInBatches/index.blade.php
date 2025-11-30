@extends('Layouts.app')

@section('title', 'Stok Masuk')

@section('content')
    <div class="row ms-lg-3 me-lg-3">

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    • {{ $error }} <br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Stok Masuk</h5>

                    <a href="{{ route('stock-in.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Buat
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">No</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Referensi</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Sumber</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Diterima Oleh</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Barang Masuk</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Barang Keluar</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Sisa</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Harga Awal</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Jumlah Serial</h6>
                                </th>
                                <th class="text-end">
                                    <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stockInBatches as $batch)
                                <tr>
                                    <td>
                                        <h6 class="fs-4 fw-semibold mb-0">
                                            {{ $loop->iteration }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="fs-4 fw-semibold mb-0">
                                            {{ $batch->reference }}
                                        </h6>
                                    </td>

                                    <td>{{ $batch->source ?? '-' }}</td>

                                    <td>{{ $batch->receiver->name ?? 'Tidak Ada' }}</td>

                                    <td>{{ $batch->in_items }}</td>
                                    <td>{{ $batch->out_items }}</td>
                                    <td>{{ $batch->remaining_items }}</td>

                                    <td>Rp {{ number_format($batch->original_price, 0, ',', '.') }}</td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $batch->serials->count() }} item
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>

                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('stock-in.serials.show', $batch->id) }}">
                                                        <i class="fs-4 ti ti-eye"></i>Detail
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('stock-in.edit', $batch->id) }}">
                                                        <i class="fs-4 ti ti-edit"></i>Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('stock-in.destroy', $batch->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="dropdown-item d-flex align-items-center gap-3 text-danger"
                                                            onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fs-4 ti ti-trash"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
