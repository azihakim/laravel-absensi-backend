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
        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'admin',
        // ]);
        // User::factory()->create([
        //     'name' => 'mhs',
        //     'email' => 'mhs@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'mahasiswa',
        // ]);
        // User::factory()->create([
        //     'name' => 'Dosen 1',
        //     'email' => 'dosen@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'dosen',
        // ]);

        // data dummy for company
        // \App\Models\Company::create([
        //     'name' => 'Ruang 603',
        //     // 'email' => 'office@gmail.com',
        //     'address' => 'Jl. Raya Kedung Turi No. 20, Palembang',
        //     'latitude' => '-3.00254',
        //     'longitude' => '104.7249473',
        //     'radius_km' => '0.5',
        // ]);

        // $this->call([
        //     AttendanceSeeder::class,
        //     PermissionSeeder::class,
        // ]);

        $users = [
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "083122070069",
                "role" => "admin"
            ],
            [
                "name" => "Andriansyah",
                "email" => "andriansyah@unsigma.id",
                "password" => Hash::make("123"),
                "phone" => "082177335790",
                "role" => "dosen"
            ],
            [
                "name" => "Jony",
                "email" => "jony@unsigma.id",
                "password" => Hash::make("123"),
                "phone" => "082161402106",
                "role" => "dosen"
            ],
            [
                "name" => "Desi",
                "email" => "desi@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0822112001",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Yuni Safitri",
                "email" => "yunisafitri@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0822112002",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Nur Aziza",
                "email" => "nuraziza@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0822112003",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Muhammad Rasyid A",
                "email" => "rasyid@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0822112004",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Rahmat Agus Sandika",
                "email" => "rahmadagus@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "082411102013",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Hendra",
                "email" => "hendra@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "082311102001",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Deby Okta Agustian",
                "email" => "debyoktaagustian@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0824001",
                "role" => "mahasiswa"
            ],
            [
                "name" => "Nadya",
                "email" => "nadya@gmail.com",
                "password" => Hash::make("123"),
                "phone" => "0824002",
                "role" => "mahasiswa"
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }

        $companies = [
            [
                "name" => "Pemrograman Web (R101)",
                "address" => "Jl Perintis Kemerdekaan No 62",
                "latitude" => "-3",
                "longitude" => "104.7788614",
                "radius_km" => "0.5",
                "attendance_type" => ""
            ],
            [
                "name" => "Konsep SI (R203)",
                "address" => "Jl Perintis Kemerdekaan No 62",
                "latitude" => "-3",
                "longitude" => "104.7788614",
                "radius_km" => "0.5",
                "attendance_type" => ""
            ],
            [
                "name" => "Sistem Pendukung Keputusan (R202)",
                "address" => "Jl Perintis Kemerdekaan No 62",
                "latitude" => "-3",
                "longitude" => "104.7788614",
                "radius_km" => "0.5",
                "attendance_type" => ""
            ],
            [
                "name" => "Keamanan Jaringan (R301)",
                "address" => "Jl Perintis Kemerdekaan No 62",
                "latitude" => "-3",
                "longitude" => "104.7788614",
                "radius_km" => "0.5",
                "attendance_type" => ""
            ]
        ];

        foreach ($companies as $company) {
            \App\Models\Company::create($company);
        }
    }
}
