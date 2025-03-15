<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function image()
    {
        return $this->hasOne(Foodimage::class, 'food_id')->select('id', 'image', 'food_id');
    }
    public function images()
    {
        return $this->hasMany(Foodimage::class, 'food_id')->select('id', 'image', 'food_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'food_id')->select('id', 'ratting', 'food_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->select('id', 'name', 'slug');
    }
    public function subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id')->select('id', 'name', 'slug');
    }

    public function variable(){
        return $this->hasOne('App\Models\FoodVariable');
    }
    public function variables()
    {
        return $this->hasMany('App\Models\FoodVariable');
    }

    public function start_price()
    {
        return $this->hasOne(FoodVariable::class, 'food_id')->select('id','new_price','old_price','food_id')->orderBy('id','desc');
    }
    public function end_price()
    {
        return $this->hasOne(FoodVariable::class, 'food_id')->select('id','new_price','food_id')->orderBy('id','asc');
    }
}
