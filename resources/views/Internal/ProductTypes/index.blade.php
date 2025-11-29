@extends('Layouts.app')

@section('title', 'Jenis Produk')

@section('content')
    <div class="row ms-lg-3 me-lg-3">
        <div class="card">
            <div class="card-body">
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
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Jenis Produk</h5>

                    <a href="{{ route('product-types.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Buat
                    </a>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Nama Jenis</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Deskripsi</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                                </th>
                                <th class="text-end">
                                    <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productTypes as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <h6 class="fs-4 fw-semibold mb-0">{{ $item->name }}</h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="mb-0 fw-normal">
                                            {{ $item->description ?? '-' }}
                                        </p>
                                    </td>

                                    <td>
                                        @if ($item->is_active)
                                            <span class="badge bg-success-subtle text-success">active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="dropdown dropstart">
                                            <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('product-types.edit', $item->id) }}">
                                                        <i class="fs-4 ti ti-edit"></i>Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('product-types.destroy', $item->id) }}"
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
