<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'id_kategori_produk',
        'stok',
        'harga_produk',
        'foto_produk'
    ];

    public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori_produk');
    }
}