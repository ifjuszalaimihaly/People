<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
   protected $table ="people";

   public function subalterns(){
   		$people = $this->hasMany(Person::class, 'boss_id', null);
   		return $people;
   }

   public function boss(){
   		$people = $this->belongsTo(Person::class, 'boss_id', null);
   		return $people;
   }
    
}
