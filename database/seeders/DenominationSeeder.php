<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Denomination::create([
            'type' => 'Bill',
            'value' => 10,
            'image' => 'denominations/10.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 50,
            'image' => 'denominations/50.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 1.00,
            'image' => 'denominations/1.00.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 100,
            'image' => 'denominations/100.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 50,
            'image' => 'denominations/50.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 20,
            'image' => 'denominations/20.jpg'
        ]);
    }
}
