<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'nama_produk',
        'harga',
        'stok',
        'img',
        'status',
        'sku',
        'satuan',


    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
