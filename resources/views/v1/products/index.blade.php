@extends('v1.layout')

@section('title', 'Data Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#1a237e; color:white;">
                <tr>
                    <th class="py-3 px-4">No</th>
                    <th class="py-3">Gambar</th>
                    <th class="py-3">Nama Produk</th>
                    <th class="py-3">Kategori</th>
                    <th class="py-3">Harga</th>
                    <th class="py-3">Stok</th>
                    <th class="py-3">Satuan</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $product)
                <tr>
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="py-3">
                        @if($product->img)
                            <img src="{{ asset('storage/' . $product->img) }}"
                                 alt="{{ $product->nama_produk }}"
                                 style="width: 60px; height: 80px; object-fit: contain; border-radius: 8px; border: 1px solid #eee; padding: 4px;">
                        @else
                            <div style="width:60px; height:60px; background:#f5f5f5; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                <i class="bi bi-image text-secondary"></i>
                            </div>
                        @endif
                    </td>
                    <td class="py-3">{{ $product->nama_produk }}</td>
                    <td class="py-3">{{ $product->category->nama_kategori ?? '-' }}</td>
                    <td class="py-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="py-3">{{ $product->stok }}</td>
                    <td class="py-3">
                        @if($product->satuan == 'pcs')
                            <span class="badge bg-primary">Pcs</span>
                        @elseif($product->satuan == 'pack')
                            <span class="badge bg-info text-dark">Pack</span>
                        @elseif($product->satuan == 'karton')
                            <span class="badge bg-secondary">Karton</span>
                        @else
                            <span class="badge bg-light text-dark">-</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($product->stok == 0)
                            <span class="badge bg-danger">Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="badge bg-warning text-dark">Menipis</span>
                        @else
                            <span class="badge bg-success">Aman</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection