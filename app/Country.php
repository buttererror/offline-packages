<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function clients(){
        return $this->hasMany('App/Client');
    }
    public function cities(){
        return $this->hasMany("App/City");
    }
}
