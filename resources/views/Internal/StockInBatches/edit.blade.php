@extends('Layouts.app')

@section('title', 'Edit Stok Masuk')

@section('content')
    <div class="row ms-lg-3 me-lg-3">

        {{-- Alert dari validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                @foreach ($errors->all() as $error)
                    • {{ $error }} <br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-semibold mb-0">Edit Stok Masuk</h4>
                    <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('stock-in.update', $stockInBatch) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Reference (Opsional)</label>
                        <input type="text" name="reference" class="form-control"
                            value="{{ old('reference', $stockInBatch->reference) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Source / Sumber (Opsional)</label>
                        <input type="text" name="source" class="form-control"
                            value="{{ old('source', $stockInBatch->source) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Awal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="original_price" class="form-control"
                                value="{{ old('original_price', $stockInBatch->original_price) }}" required min="0"
                                step="0.01">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Update
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection
