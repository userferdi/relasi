<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = ['id','name','price','image','brand_id','category_id'];
    public function brand(){
    	return $this->belongsTo('App\Brand');
    }
    public function category(){
    	return $this->belongsTo('App\Category');
    }
    public function details(){
    	return $this->hasOne('App\Details');
    }
}