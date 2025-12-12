<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Passenger Moon',
            'email' => 'passenger@moon.ru',
            'password' => Hash::make('P@rtyAstr0nauts'),
        ]);

        User::factory()->create([
            'name' => 'Passenger Mars',
            'email' => 'passenger@mars.ru',
            'password' => Hash::make('QwertyP@rtyAstr0nauts'),
        ]);
    }
}
