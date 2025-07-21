<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        
        Transaction::create([
            'item_id' => 1,
            'user_id' => 2,
            'type' => 'masuk',
            'quantity' => 5,
            'description' => 'Penambahan stok awal printer'
        ]);

   
        Transaction::create([
            'item_id' => 2,
            'user_id' => 2,
            'type' => 'keluar',
            'quantity' => 20,
            'description' => 'Pengambilan kertas untuk kebutuhan kantor'
        ]);
    }
}
