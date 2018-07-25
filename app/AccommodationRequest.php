<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccommodationRequest extends Model
{
    protected $fillable = [
        'checkin',
        'checkout',
        'destination_id',
        'place',
        'rooms',
        'stars',
        'hotel',
        'note',
    ];

    protected $casts = [
        'rooms' => 'array'
    ];

    public function setRoomsAttribute($value)
    {
        $this->attributes['rooms'] = json_encode($value);
    }

    public function package()
    {
        return $this->belongsTo('App/Package');
    }
}


