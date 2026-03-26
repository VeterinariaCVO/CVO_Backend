<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        Pet::insert([
            [
                'name' => 'Max',
                'species' => 'Perro',
                'breed' => 'Labrador',
                'color' => 'Dorado',
                'special_marks' => 'Mancha blanca en el pecho',
                'weight' => 25.5,
                'sex' => 'male',
                'age' => 4,
                'owner_id' => 3,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luna',
                'species' => 'Gato',
                'breed' => 'Siames',
                'color' => 'Blanco con café',
                'special_marks' => 'Ojos azules',
                'weight' => 4.2,
                'sex' => 'female',
                'age' => 2,
                'owner_id' => 3,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rocky',
                'species' => 'Perro',
                'breed' => 'Bulldog',
                'color' => 'Blanco y café',
                'special_marks' => 'Nariz negra',
                'weight' => 18.0,
                'sex' => 'male',
                'age' => 5,
                'owner_id' => 3,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
