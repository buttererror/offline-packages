<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Package extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'user_id',
        'nights',
        'start_date',
        'end_date',
        'start_place',
        'adults',
        'children_count',
        'number_of_destinations',
        'countries',
        'children',
        'transfer',
        'status',
        'note'
    ];

    protected $casts = [
        'countries' => 'collection',
        'children' => 'collection',
        'transfer' => 'boolean'
    ];

    public function accommodationRequests(){
        return $this->hasMany('App/AccommodationRequest');
    }

    public function transferRequests(){
        return $this->hasMany('App/TransferRequest');
    }

    public function client(){
        return $this->belongsTo('App/Client');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsToMany(Country::class,'country_package','country_id','package_id');
    }

    public function savePackageDetails($data){

        $packageCountries=[];
        $this->start_date=Carbon::parse($data['package_details']['tripStartAt']);
        $this->end_date=Carbon::parse($data['package_details']['tripEndAt']);
        $this->start_place=$data['package_details']['startPlace'];
        $this->adults=$data['package_details']['adultsNum'];
        $this->children_count=$data['package_details']['childrenNumber'];
        $this->number_of_destinations=$data['package_details']['placesNum'];
        $this->transfer=$data['package_details']['transfer'];
        $this->note=$data['note'];
        $this->children=json_encode($data['package_details']['childrenAges']);
        $this->client_id=$data['client_details']['id'];
        $this->user_id=$data['user_id'];
        $this->save();
        foreach($data['package_details']['selectedCountries'] as $selectedCountry){
            array_push($packageCountries,$selectedCountry['id']);
        }

        $this->country()->attach($packageCountries);
//        $this->accommodationRequests->insert([
//            'accommodation_type'=>$data['accommodation_type'],
//            'rooms'=>$data['rooms'],
//            'checkin'=>$data['checkin'],
//            'checkout'=>$data['checkout'],
//            'nights'=>$data['nights'],
//            'hotel_name'=>$data['hotel_name'],
//            'area_name'=>$data['area'],
//            'room_type'=>$data['room_type'],
//            'room_view'=>$data['room_view'],
//            'stars'=>$data['stars'],
//            'note'=>$data['note'],
//        ]);

    }
}

