<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageAccommodation extends Model
{
    protected $table = 'package_accommodations';

    protected $fillable=['package_id','city_id','country_id',
        'accommodation_type','rooms','checkin','checkout','nights',
        'hotel_name','area_name','room_type','room_view','stars','other_services'];


    public function country(){
        return $this->belongsTo('App\Country','country_id');
    }
    public function city(){
        return $this->belongsTo('App\City','city_id');
    }

}
