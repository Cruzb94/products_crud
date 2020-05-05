<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
   protected $table = 'documents';
   protected $fillable = [
   		'id', 
   		'name', 
   		'description', 
   		'file',
      'reminder_date',
      'expiration_date',
   		'client_id',
      'user_id',
   		'created_at',
   		'updated_at'
   	];
   	
    public function client()
    {
        return $this->belongsTo('App\Client', 'documents', 'client_id');
    }
}
