<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable=[ 'name', 'description', 'quantity','image','code', 'wholesale_price', 'price'];

}
