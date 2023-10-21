<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'id',
        'batch_id',
        'profile_image',
        'name',
        'name',
        'gender',
        'course_id',
        'date_of_birth',
        'date_of_birth',
        'email',
        'phone',
        'fees',
        'product_purchased',
        'student_performance',
        'progress_track',

    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
   
    public function attendence()
    {
        return $this->belongsTo(Attendence::class, 'stud_id');
    }
   

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'stud_id', 'id');
    }
}
