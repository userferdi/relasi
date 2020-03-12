<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "brand";
    protected $fillable = ['id','name'];
    public function product(){
    	return $this->hasMany('App\Product');
    }
}
