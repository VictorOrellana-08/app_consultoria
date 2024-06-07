<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
            'name' => 'Aceite 
            Supergard 20w50 gl',
            'cost' => 15,
            'price' => 35,
            'barcode' => '750213211',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1
        ]);
        Product::create([
            'name' => 'LLave 15',
            'cost' => 6,
            'price' => 12,
            'barcode' => '750213212',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2
        ]);
        Product::create([
            'name' => 'LLanta',
            'cost' => 30,
            'price' => 80,
            'barcode' => '750213213',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3
        ]);
        Product::create([
            'name' => 'Liquido de freno 90',
            'cost' => 70,
            'price' => 110,
            'barcode' => '750213214',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4
        ]);
    }
}
