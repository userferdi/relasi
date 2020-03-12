<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    protected $table = "details";
    protected $fillable = ['id','product_id','details_1','details_2'];
    public function product(){
    	return $this->belongsTo('App\Product');
    }
}
