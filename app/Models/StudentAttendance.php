<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{	
    protected $fillable = array('student_id', 'class_id', 'section_id', 'date', 'attendance');
}
