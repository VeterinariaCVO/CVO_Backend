<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::insert([
            ['name' => 'consultation','description' => 'Consulta general', 'active' => true],
            ['name' => 'vaccination','description' => 'Aplicación de vacuna', 'active' => true],
            ['name' => 'surgery','description' => 'Procedimiento quirúrgico', 'active' => true],
            ['name' => 'grooming','description' => 'Estética y baño', 'active' => true],
        ]);
    }
}
