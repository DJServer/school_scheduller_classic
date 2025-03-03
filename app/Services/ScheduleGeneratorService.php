<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Day;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Bell;
use Illuminate\Support\Facades\Log;

class ScheduleGeneratorService
{
    private int $minLessonsPerDay = 2;
    private int $maxLessonsPerDay = 6;

    private array $teacherSchedule = [];
    private array $classSchedule = [];
    private array $usedSubjects = [];

    public function generate(): void
    {
        // Очистка расписания перед генерацией
        Schedule::truncate();

        $days = Day::all();
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        $bells = Bell::where('is_break', false)->orderBy('start_time')->get();

        foreach ($days as $day) {
            $this->teacherSchedule[$day->id] = [];
            $this->classSchedule[$day->id] = [];
            $this->usedSubjects[$day->id] = [];

            foreach ($classes as $class) {
                $lessonCount = rand($this->minLessonsPerDay, $this->maxLessonsPerDay);
                $availableBells = $bells->slice(0, $lessonCount);

                foreach ($availableBells as $bell) {
                    $subject = $this->getAvailableSubject($day->id, $class->id, $subjects);
                    if (!$subject) continue;

                    $teacher = $this->getAvailableTeacher($day->id, $bell->id, $subject, $teachers);
                    if (!$teacher) {
                        Log::warning("Нет свободного учителя для {$subject->name} в {$class->name}");
                        continue;
                    }

                    if ($this->isClassBusy($day->id, $bell->id, $class->id)) {
                        Log::warning("Класс {$class->name} уже занят в звонке {$bell->id}");
                        continue;
                    }

                    Schedule::create([
                        'day_id' => $day->id,
                        'bell_id' => $bell->id,
                        'class_id' => $class->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                    ]);

                    $this->teacherSchedule[$day->id][$bell->id] = $teacher->id;
                    $this->classSchedule[$day->id][$bell->id] = $class->id;
                    $this->usedSubjects[$day->id][$class->id][] = $subject->id;
                }
            }
        }
    }

    private function getAvailableSubject(int $dayId, int $classId, $subjects)
    {
        $availableSubjects = $subjects->filter(fn($s) => !in_array($s->id, $this->usedSubjects[$dayId][$classId] ?? []));
        return $availableSubjects->isNotEmpty() ? $availableSubjects->random() : null;
    }

    private function getAvailableTeacher(int $dayId, int $bellId, $subject, $teachers)
    {
        $availableTeachers = $teachers->filter(fn($teacher) =>
            $teacher->subjects->contains($subject->id) &&
            !$this->isTeacherBusy($dayId, $bellId, $teacher->id) &&
            !$this->isTeacherAlreadyScheduled($dayId, $bellId, $teacher->id)
        );

        return $availableTeachers->isNotEmpty() ? $availableTeachers->random() : null;
    }

    private function isTeacherBusy(int $dayId, int $bellId, int $teacherId): bool
    {
        return isset($this->teacherSchedule[$dayId][$bellId]) && $this->teacherSchedule[$dayId][$bellId] === $teacherId;
    }

    private function isTeacherAlreadyScheduled(int $dayId, int $bellId, int $teacherId): bool
    {
        return Schedule::where('day_id', $dayId)
            ->where('bell_id', $bellId)
            ->where('teacher_id', $teacherId)
            ->exists();
    }

    private function isClassBusy(int $dayId, int $bellId, int $classId): bool
    {
        return isset($this->classSchedule[$dayId][$bellId]) && $this->classSchedule[$dayId][$bellId] === $classId;
    }
}
