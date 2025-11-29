@extends('Layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="row ms-lg-3 me-lg-3">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold mb-0">Edit Produk</h5>
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Jenis Produk --}}
                <div class="mb-3">
                    <label for="product_type_id" class="form-label">Jenis Produk</label>
                    <select class="form-select @error('product_type_id') is-invalid @enderror"
                        id="product_type_id" name="product_type_id" required>

                        <option value="">-- Pilih Jenis Produk --</option>

                        @foreach ($productTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('product_type_id', $product->product_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Produk --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SKU --}}
                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                        id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga Default --}}
                <div class="mb-3">
                    <label for="default_price" class="form-label">Harga</label>
                    <input type="number" class="form-control @error('default_price') is-invalid @enderror"
                        id="default_price" name="default_price" value="{{ old('default_price', $product->default_price) }}" required>
                    @error('default_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>

            </form>

        </div>
    </div>
</div>
@endsection
