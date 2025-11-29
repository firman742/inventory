@extends('Layouts.app')

@section('title', 'Edit Jenis Produk')

@section('content')
<div class="row ms-lg-3 me-lg-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold mb-0">Edit Jenis Produk</h5>
            </div>

            <form action="{{ route('product-types.update', $productType) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Jenis Produk</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $productType->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3">{{ old('description', $productType->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Status (is_active) --}}
                <div class="mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <select name="is_active" id="is_active"
                        class="form-select @error('is_active') is-invalid @enderror">
                        
                        <option value="1" {{ old('is_active', $productType->is_active) == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0" {{ old('is_active', $productType->is_active) == 0 ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>

                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('product-types.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
@endsection
