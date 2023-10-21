<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';
    public function staff()
{
    return $this->belongsToMany(Staff::class, 'user_id');
}
}
