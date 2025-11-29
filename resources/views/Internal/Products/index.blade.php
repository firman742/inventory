@extends('Layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="row ms-lg-3 me-lg-3">
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Error / Failed --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert dari validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    • {{ $error }} <br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Produk</h5>

                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Buat
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Deskripsi</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">SKU</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Harga</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Jenis</h6>
                                </th>
                                <th class="text-end">
                                    <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    {{-- Nama --}}
                                    <td>
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $item->name }}</h6>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td>
                                        <p class="mb-0 fw-normal">{{ $item->description ?? '-' }}</p>
                                    </td>

                                    {{-- SKU --}}
                                    <td>
                                        <p class="mb-0 fw-normal">{{ $item->sku }}</p>
                                    </td>

                                    {{-- Harga --}}
                                    <td>
                                        <p class="mb-0 fw-normal">Rp {{ number_format($item->default_price, 0, ',', '.') }}
                                        </p>
                                    </td>

                                    {{-- Jenis Produk --}}
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $item->productType?->name ?? 'Tidak ada' }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="text-end">
                                        <div class="dropdown dropstart">
                                            <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">

                                                {{-- Edit --}}
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('products.edit', $item->id) }}">
                                                        <i class="fs-4 ti ti-edit"></i>Edit
                                                    </a>
                                                </li>

                                                {{-- Delete --}}
                                                <li>
                                                    <form action="{{ route('products.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="dropdown-item d-flex align-items-center gap-3 text-danger"
                                                            onclick="return confirm('Yakin ingin menghapus produk ini?')">
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
