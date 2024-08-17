<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::insert(
            [
                [
                    'nama'=>'unit',
                ],
                [
                    'nama'=>'pcs',
                ],
            ]
        );
    }
}
