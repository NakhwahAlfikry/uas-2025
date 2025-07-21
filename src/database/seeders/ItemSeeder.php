<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create([
            'name' => 'Printer Epson L3110',
            'sku' => 'PR-EPS-L3110',
            'category_id' => 1,
            'stock' => 10,
            'description' => 'Printer multifungsi dengan tinta isi ulang.'
        ]);

        Item::create([
            'name' => 'Kertas A4 80gsm',
            'sku' => 'KR-A4-80G',
            'category_id' => 2,
            'stock' => 100,
            'description' => 'Kertas ukuran A4 untuk printer dan fotokopi.'
        ]);
    }
}