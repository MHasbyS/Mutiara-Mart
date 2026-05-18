<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoryContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $gambarPath = null;
            if ($request->hasFile('img')) {
                $gambarPath = $request->file('img')->store('categories', 'public');
            }

            Category::create([
                'nama_kategori' => $request->nama_kategori,
                'img' => $gambarPath,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal Store Kategori: '.$e->getMessage());

            return redirect()->back()->with('error', 'terjadi kesalahan sistem.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except('img');

            if ($request->hasFile('img')) {
                if ($category->img && Storage::disk('public')->exists($category->img)) {
                    Storage::disk('public')->delete($category->img);
                }

                // Simpan gambar baru
                $data['img'] = $request->file('img')->store('category', 'public');
            }

            // Update data harus di luar blok IF gambar agar nama/deskripsi tetap terupdate
            $category->update($data);

            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal Mengubah Kategori: '.$e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            if ($category->img && Storage::disk('public')->exists($category->img)) {
                Storage::disk('public')->delete($category->img);
            }

            // $namaKategori = $category->nama_kategori;
            $category->delete();

            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal destroy kategori: '.$e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.')->withInput();
        }
    }
}
