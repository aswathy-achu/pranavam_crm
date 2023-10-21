<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    public function students()
    {
        return $this->hasMany(Student::class);
    }
   
}
