<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $casts = [
        'top_destination' => 'boolean'
    ];

    public function country(){
        return $this->belongsTo('App/Country');
    }
}
