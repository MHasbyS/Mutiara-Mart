@extends('v1.layout')

@section('title', 'Toko')

@section('content')

{{-- Search & Filter --}}
<form method="GET" action="{{ route('shop.index') }}" class="row g-2 mb-4">
    <div class="col-md-6">
        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="category" class="form-select">
            <option value="">-- Semua Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Cari</button>
    </div>
</form>

{{-- Grid Produk --}}
@if($products->isEmpty())
    <div class="text-center text-muted py-5">
        <i class="bi bi-box-seam" style="font-size:3rem;"></i>
        <p class="mt-2">Produk tidak ditemukan</p>
    </div>
@else
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
    @foreach($products as $product)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            {{-- Foto --}}
            @if($product->img)
                <img src="{{ asset('storage/'.$product->img) }}" class="card-img-top" style="height:180px; object-fit:cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                    <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                </div>
            @endif

            <div class="card-body">
                <p class="text-muted small mb-1">{{ $product->category->nama_kategori ?? '-' }}</p>
                <h6 class="card-title mb-1">{{ $product->nama_produk }}</h6>
                <p class="fw-bold text-primary mb-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                @if($product->stok == 0)
                    <span class="badge bg-danger">Habis</span>
                @elseif($product->stok <= 5)
                    <span class="badge bg-warning text-dark">Stok Menipis</span>
                @else
                    <span class="badge bg-success">Tersedia</span>
                @endif
            </div>

            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('shop.show', $product->id) }}" class="btn btn-outline-primary btn-sm w-100">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection