<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
  
        protected $fillable = ['product_name', 'description', 'product_buy_price', 'product_selling_price', 'product_image'];

}
