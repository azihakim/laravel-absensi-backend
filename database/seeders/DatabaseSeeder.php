<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'mhs',
            'email' => 'mhs@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'mahasiswa',
        ]);
        User::factory()->create([
            'name' => 'Dosen 1',
            'email' => 'dosen@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'dosen',
        ]);

        // data dummy for company
        \App\Models\Company::create([
            'name' => 'PT. FIC16',
            // 'email' => 'office@gmail.com',
            'address' => 'Jl. Raya Kedung Turi No. 20, Palembang',
            'latitude' => '-3.00254',
            'longitude' => '104.7249473',
            'radius_km' => '0.5',
        ]);

        // $this->call([
        //     AttendanceSeeder::class,
        //     PermissionSeeder::class,
        // ]);
    }
}
