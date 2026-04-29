<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            [
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567890',
                'email' => 'budi@gmail.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'nomor_hp' => '082345678901',
                'email' => 'siti@gmail.com',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
