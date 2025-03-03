<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Day;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Services\ScheduleGeneratorService;

class ScheduleTable extends Component
{
    public $selectedDay;
    public $selectedClass;
    public $selectedTeacher;
    private ScheduleGeneratorService $scheduleGeneratorService;

    public function __construct()
    {
        $this->scheduleGeneratorService = app(ScheduleGeneratorService::class);
    }

    public function generateSchedule()
    {
        if (!$this->scheduleGeneratorService) {
            throw new \Exception("ScheduleGeneratorService is not initialized");
        }
        $this->scheduleGeneratorService->generate();
        $this->dispatch('schedule-generated');
    }

    public function render()
    {
        $query = Schedule::with(['day', 'bell', 'class', 'subject', 'teacher']);

        if ($this->selectedDay) {
            $query->where('day_id', $this->selectedDay);
        }

        if ($this->selectedClass) {
            $query->where('class_id', $this->selectedClass);
        }

        if ($this->selectedTeacher) {
            $query->where('teacher_id', $this->selectedTeacher);
        }

        return view('livewire.schedule-table', [
            'schedule' => $query->get(),
            'days' => Day::all(),
            'classes' => ClassRoom::all(),
            'teachers' => Teacher::all(),
        ]);
    }
}
