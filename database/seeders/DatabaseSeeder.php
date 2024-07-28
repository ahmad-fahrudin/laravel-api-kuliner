<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'kode' => 'k-' . $i,
                'nama' => 'nama barang ' . $i,
                'harga' => 200 . $i,
                'is_ready' => 'true',
                'bestseller' => 'true',
                'gambar' =>  $i . '.jpg'
            ]);
        }
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'kode' => 'k-' . $i,
                'nama' => 'nama barang ' . $i,
                'harga' => 200 . $i,
                'is_ready' => 'true',
                'bestseller' => 'false',
                'gambar' =>  $i . '.jpg'
            ]);
        }

        for ($p = 1; $p <= 100; $p++) {
            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'kode' => 'k-' . $i,
                    'nama' => 'nama barang ' . $i,
                    'harga' => 200 . $i,
                    'is_ready' => 'false',
                    'bestseller' => 'false',
                    'gambar' =>  $i . '.jpg'
                ]);
            }
        }
        User::create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password')
        ]);
        User::create([
            'name'      => 'dimmas',
            'email'     => 'dimmas@gmail.com',
            'password'  => bcrypt('password')
        ]);
    }
}
