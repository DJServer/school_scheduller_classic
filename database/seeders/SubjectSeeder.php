<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['Математика', 'История', 'Литература', 'Физика', 'Химия', 'Биология', 'География'];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
