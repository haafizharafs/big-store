<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Truncate the table to remove existing records
        DB::table('users')->truncate();

        // Insert new records
        $users = [
            [
                'id' => '1',
                'name' => 'Admin Serdam',
                'email' => 'big-serdam@gmail.com',
                'password' => bcrypt('busa1234'),
            ],
            [
                'id' => '2',
                'name' => 'Admin 28',
                'email' => 'big-28@gmail.com',
                'password' => bcrypt('busa1234'),
            ],
            [
                'id' => '3',
                'name' => 'Superadmin',
                'email' => 'big-super@gmail.com',
                'password' => bcrypt('busa1234'),
            ],
        ];

        User::insert($users);
    }
}
