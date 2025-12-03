@extends('layouts.app')

@section('title', 'Confirm Stock Out Creation')

@section('content')
<div class="container">
    <h1 class="mb-4">Confirm Stock Out Creation</h1>
    <p>Serial number has been validated. Please fill in the details below to create the stock out.</p>

    {{-- Display Serial Info --}}
    @if($serial)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Scanned Serial Details</h5>
                <p><strong>Serial Number:</strong> {{ $serial->serial_number }}</p>
                <p><strong>Product:</strong> {{ $serial->product->name ?? 'N/A' }}</p>
                <p><strong>Unit Price:</strong> Rp {{ number_format($serial->unit_price, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $serial->status }}</p>
            </div>
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success/Error Flash Messages --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('stock-out.store') }}" method="POST">  {{-- Diubah ke stock-out.store --}}
                @csrf

                <div class="mb-3">
                    <label for="reference" class="form-label">Reference <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}" required>
                    @error('reference')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="processed_by" class="form-label">Processed By <span class="text-danger">*</span></label>
                    <select class="form-select" id="processed_by" name="processed_by" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('processed_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('processed_by')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="total_value" class="form-label">Selling Price (Total Value) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="total_value" name="total_value" value="{{ old('total_value') }}" required min="0">
                    @error('total_value')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Stock Out</button>
                <a href="{{ route('stock-out.store') }}" class="btn btn-secondary">Back to Scan</a>  {{-- Diubah ke stock-out.create --}}
            </form>
        </div>
    </div>
</div>
@endsection