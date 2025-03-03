<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bell extends Model
{
    use HasFactory;

    protected $table = 'bells';
    protected $fillable = ['name', 'start_time', 'end_time', 'is_break'];
}
