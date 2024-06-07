<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'name' => 'Aceites',
            'image' => 'categories/aceites.png'
        ]);

        Category::create([
            'name' => 'LLaves',
            'image' => 'categories/llaves.png'
        ]);
        Category::create([
            'name' => 'LLantas',
            'image' => 'categories/LLantas.png'
        ]);
        Category::create([
            'name' => 'Liquidos de freno',
            'image' => 'categories/frenos.png'
        ]);
    }
}
