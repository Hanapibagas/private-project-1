<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'phone' => '123456789',
            'avatar' => 'default.jpg',
            'password' => bcrypt('12345678')
        ]);
        User::create([
            'name' => 'suplier',
            'email' => 'suplier@admin.com',
            'role' => 'suplier',
            'phone' => '123456789',
            'avatar' => 'default.jpg',  
            'password' => bcrypt('12345678')
        ]);
        User::create([
            'name' => 'gudang',
            'email' => 'gudang@admin.com',
            'role' => 'gudang',
            'phone' => '123456789',
            'avatar' => 'default.jpg',
            'password' => bcrypt('12345678')
        ]);
    }
}
