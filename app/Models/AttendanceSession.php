<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = [
        'class_id',
        'dosen_id',
        'session_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Company::class, 'class_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
