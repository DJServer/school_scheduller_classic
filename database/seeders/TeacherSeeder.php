<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = ['Иван Петров', 'Ольга Смирнова', 'Алексей Сидоров', 'Мария Иванова', 'Григорий Коваленко', 'Светлана Синица', 'Анна Линько',];

        foreach ($teachers as $teacher) {
            Teacher::create(['name' => $teacher]);
        }
    }
}
