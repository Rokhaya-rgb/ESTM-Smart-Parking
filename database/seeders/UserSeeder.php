<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'first_name' => 'Rokhaya',
            'last_name' => 'Yade',
            'email' => 'kyarokhaya@gmail.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\User::create([
            'first_name' => 'Nancy',
            'last_name' => 'Diop',
            'email' => 'diopnancy@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
