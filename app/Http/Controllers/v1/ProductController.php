<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::with('category')->get();
        return view('v1.products.index', compact('products'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('v1.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'img'         => 'nullable|image|max:5000',
        ]); 
        
        $data = $request->all();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }


    public function show(string $id)
    {
        return view('v1.products.show', compact('product'));
    }

    
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('v1.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'img'         => 'nullable|image|max:5000', 
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            //Hapus gambar lama sebelum simpan yang baru
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }


    public function destroy(Product $product)
    {
        //Hapus gambar saat produk dihapus
        if ($product->img) {
            Storage::disk('public')->delete($product->img);
        }
        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}