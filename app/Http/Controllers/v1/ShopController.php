<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')
            ->when(request('search'), fn($q) => $q->where('nama_produk', 'like', '%'.request('search').'%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->get();

        return view('v1.shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('v1.shop.show', compact('product'));
    }
}

