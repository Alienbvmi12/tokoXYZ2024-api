<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nama' => 'Alien',
            'username' => 'alien_bvmi12',
            'password' => Hash::make("123456"),
            'alamat' => "Jl. Raja Agung"
        ]);

        Barang::factory(15)->create();
    }
}
