<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public function items(){
    	return $this->hasMany(Item::class);
    }
}
