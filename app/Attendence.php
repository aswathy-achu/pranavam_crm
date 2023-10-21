<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $table = 'attendence';
    protected $fillable = [
        'id',
        'batch_id',
        'stud_id',
        'course_id',
        'attendence_mark',

    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function getDayAttribute(){
        return (int)date('d', strtotime($this->date));// (int) string to intiger
    }
    protected $appends = ['day'];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}

