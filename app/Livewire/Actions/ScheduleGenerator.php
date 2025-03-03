<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use App\Services\ScheduleGeneratorService;
use App\Models\Schedule;

class ScheduleGenerator extends Component
{
    private ScheduleGeneratorService $scheduleGeneratorService;
    private Schedule $schedule;

    public function __construct()
    {
        $this->scheduleGeneratorService = app(ScheduleGeneratorService::class);
        $this->schedule = app(Schedule::class);
    }

    public function generate()
    {
        $this->scheduleGeneratorService->generate();
    }

    public function render()
    {
        return view('livewire.schedule-generator', [
            'schedule' => $this->schedule->getAll()
        ]);
    }
}
