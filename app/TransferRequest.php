<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    protected $fillable = [
        'from',
        'to',
        'date',
        'time',
        'number_of_adults',
        'number_of_children',
        'quality'
    ] ;

    public function package(){
        return $this->belongsTo('App/Package');
    }
}
