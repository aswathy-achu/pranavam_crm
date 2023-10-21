<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'student_batch';

    protected $fillable = [
        'id',
        'batch_day',
        'occupy_students',
        'from_time',
        'to_time',

    ];
    public function batchdayslist()
{
    return $this->belongsTo(Batchdayslist::class, 'id');
}
public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendence::class);
    }
    
}
