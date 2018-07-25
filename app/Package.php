<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    public function accommodationRequests(){
        return $this->hasMany('App/AccommodationReuests');
    }

    public function transferRequests(){
        return $this->hasMany('App/TransferRequest');
    }

    public function client(){
        return $this->belongsTo('App/Client');
    }
}

