<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'stock',
        'description',
    ];

    // Relasi: Item milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Item punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
