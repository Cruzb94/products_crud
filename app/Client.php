<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   protected $table = 'clients';
   protected $fillable = [
		'id', 
		'name', 
		'email', 
		'phone',
		'rfc',
      'curp',
      'business_name',
      'address',
      'turn',
      'type_person',
      'user_id',
		'created_at',
		'updated_at'
   	];
   	
}
