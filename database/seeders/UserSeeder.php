<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [

                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('1234'),
                'role_id' => 1,
            ],
            [
                'name' => 'Natalia Diaz',
                'email' => 'natalia@example.com',
                'password' => Hash::make("1234"),
                'role_id' => 2,
            ],
            [
                'name' => 'Emiliane Berlange',
                'email' => 'emiliane@example.com',
                'password' => Hash::make("1234"),
                'role_id' => 3,
            ],
            [
                'name' => 'Brandon Diz',
                'email' => 'brandon@example.com',
                'password' => Hash::make("1234"),
                'role_id' => 2,
            ],



        ]);


    }
}
