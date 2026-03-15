<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingDay;
use App\Models\TimeSlot;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $days = WorkingDay::where('is_open', true)->get();

        foreach ($days as $day) {
            $start = strtotime("09:00");
            $end = strtotime("17:00");

            while ($start < $end) {
                TimeSlot::create([
                    'working_day_id' => $day->id,
                    'start_time' => date("H:i", $start),
                    'end_time' => date("H:i", $start + 1800),
                    'status' => 'available'
                ]);
                $start += 1800;
            }
        }
    }
}