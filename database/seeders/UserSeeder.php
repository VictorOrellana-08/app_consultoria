<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Nes GC',
            'username' => 'Nes GC',
            'phone' => '2333035355',
            'email' => 'nesgc@gmail.com',
            'profile' => 'super-admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin'),
            'image' => 'users/mapache.jpg'
        ]);
        User::create([
            'name' => 'Bryan11',
            'username' => 'Bryan11',
            'phone' => '2333035355',
            'email' => 'bryan11@gmail.com',
            'profile' => 'super-admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin'),
            'image' => 'users/mapache.jpg'
        ]);
        User::create([
            'name' => 'Kevin Mad',
            'username' => 'Kevin',
            'phone' => '785035355',
            'email' => 'kevin@gmail.com',
            'profile' => 'Super-Admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin')
        ]);

        User::create([
            'name' => 'Manuel Espinas',
            'username' => 'Manuel',
            'phone' => '7850353552',
            'email' => 'manuel@gmail.com',
            'profile' => 'Super-Admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin')
        ]);
        User::create([
            'name' => 'Marcos Angel',
            'username' => 'Marcos',
            'phone' => '7850353551',
            'email' => 'marcos@gmail.com',
            'profile' => 'Super-Admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin')
        ]);
        User::create([
            'name' => 'Melisa Hall',
            'username' => 'Melisa',
            'phone' => '785035355',
            'email' => 'melisah@gmail.com',
            'profile' => 'Employee',
            'status' => 'LOCKED',
            'password' => bcrypt('admin')
        ]);
    }
}
