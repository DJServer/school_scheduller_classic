<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';
    protected $fillable = ['day_id', 'bell_id', 'class_id', 'subject_id', 'teacher_id'];

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }

    public function bell()
    {
        return $this->belongsTo(Bell::class, 'bell_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function clear(): void
    {
        Schedule::truncate();
    }

}
