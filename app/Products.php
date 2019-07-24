<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
   protected $table = 'products';
   protected $fillable = [
   		'id', 
   		'name', 
   		'stock', 
   		'imagen',
   		'id_user',
   		'created_at',
   		'updated_at'
   	];
   	
    public function userProducts()
    {
        return $this->belongsTo('App\User', 'products', 'id_user');
    }
}
