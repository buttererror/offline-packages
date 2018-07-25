<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable =[
        'name',
        'email',
        'mobile',
        'country_id',
        'address',
        'gender',
        'age'
    ];

    public function packages(){
        return $this->hasMany('App/Package');
    }
}
