<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batchdayslist extends Model
{
    protected $table = 'batch_dayslist';
    public function batches()
    {
        return $this->hasMany(Batch::class, 'id');
    }
    
}
