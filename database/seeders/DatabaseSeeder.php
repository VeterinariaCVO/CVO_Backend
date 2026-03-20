<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\CalendarSeeder;
use Database\Seeders\WorkingDaySeeder;
use Database\Seeders\TimeSlotSeeder;
use Database\Seeders\AppointmentSeeder;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    $this->call([
        RoleSeeder::class,
        UserSeeder::class,
        ServiceSeeder::class,
        CalendarSeeder::class,
        WorkingDaySeeder::class,
        TimeSlotSeeder::class,
        AppointmentSeeder::class,
    ]);
}
}
