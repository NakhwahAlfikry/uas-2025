<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'type',
        'quantity',
        'description',
    ];

    // Relasi: Transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi milik satu item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
