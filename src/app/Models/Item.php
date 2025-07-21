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

 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function getStockAttribute()
{
    $masuk = $this->transactions()->where('type', 'masuk')->sum('quantity');
    $keluar = $this->transactions()->where('type', 'keluar')->sum('quantity');
    return max(0, $masuk - $keluar);
}
}
