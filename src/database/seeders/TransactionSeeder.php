<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Transaksi masuk
        Transaction::create([
            'item_id' => 1,
            'user_id' => 2, // Petugas
            'type' => 'masuk',
            'quantity' => 5,
            'description' => 'Penambahan stok awal printer'
        ]);

        // Transaksi keluar
        Transaction::create([
            'item_id' => 2,
            'user_id' => 2,
            'type' => 'keluar',
            'quantity' => 20,
            'description' => 'Pengambilan kertas untuk kebutuhan kantor'
        ]);
    }
}
