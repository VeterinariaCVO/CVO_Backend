<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingDay;
use Carbon\Carbon;

class WorkingDaySeeder extends Seeder
{
    public function run(): void
    {

        $start = Carbon::create(2026, 3, 1);
        $end = Carbon::create(2026, 3, 31);

        while ($start <= $end) {

            $isWeekend = $start->isSaturday() || $start->isSunday();

            WorkingDay::create([
                'date' => $start->format('Y-m-d'),
                'is_open' => !$isWeekend
            ]);

            $start->addDay();
        }

    }
}