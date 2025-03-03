<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Day;

class DaySeeder extends Seeder
{
    public function run(): void
    {
        $days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница'];

        foreach ($days as $day) {
            Day::create(['name' => $day]);
        }
    }
}
