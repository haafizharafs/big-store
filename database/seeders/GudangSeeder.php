<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gudang;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gudang::insert(
            [
                [
                    'nama'=>'Serdam',
                    'alamat'=>'Jln. Sungai Raya Dalam Gg. Bali',
                ],
                [
                    'nama'=>'28',
                    'alamat'=>'Jln. 28 Oktober',
                ],
            ]
        );
    }
}
