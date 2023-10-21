<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    
    
    protected $fillable = ['date','invoice_no', 'batch_id', 'course_id','received_from','amount_in_word','fees','product_id','from_date','to_date','paid_by','account_amt','email','phone','stud_id','paid_amount','balance_amount'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'id'); // Use the correct foreign key
    }
}
