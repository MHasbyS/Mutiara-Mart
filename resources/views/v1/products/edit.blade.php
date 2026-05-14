@extends('v1.layout')

@section('title', 'Edit Produk')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $product->nama_produk) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $product->harga) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', $product->stok) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Satuan</label>
                <select name="satuan" class="form-select">
                    <option value="">-- Pilih Satuan --</option>
                    <option value="pcs" {{ old('satuan', $product->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="pack" {{ old('satuan', $product->satuan) == 'pack' ? 'selected' : '' }}>Pack</option>
                    <option value="karton" {{ old('satuan', $product->satuan) == 'karton' ? 'selected' : '' }}>Karton</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Foto Produk</label>
                @if($product->img)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$product->img) }}" width="80" class="rounded">
                        <small class="text-muted ms-2">Foto saat ini</small>
                    </div>
                @endif
                <input type="file" name="img" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection