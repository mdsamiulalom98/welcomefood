<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodVariable extends Model
{
    use HasFactory;
    public function food(){
        return $this->belongsTo(Product::class, 'food_id')->select('id','name','stock','stock_alert','new_price');
    }
    public function image()
    {
        return $this->belongsTo(Foodimage::class, 'food_id')->select('id', 'image', 'food_id')->latest();
    }
}
