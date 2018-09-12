<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'user_id',
        'nights',
        'start_date',
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
    public function savePackageDetails($data){
        $this->client_id=$data['client_id'];
        $this->title=$data['title'];
        $this->nights=$data['nights'];
        $this->start_date=$data['start_date'];
        $this->start_place=$data['start_place'];
        $this->adults=$data['adults'];
        $this->children_count=$data['children_count'];
        $this->number_of_destinations=$data['number_of_destinations'];
        $this->countries=$data['countries'];
        $this->children=$data['children'];
        $this->transfer=$data['transfer'];
        $this->children=$data['children'];
        $this->status=$data['status'];
        $this->note=$data['note'];
        $this->save();

        $this->accommodationRequests->insert([
            'accommodation_type'=>$data['accommodation_type'],
            'rooms'=>$data['rooms'],
            'checkin'=>$data['checkin'],
            'checkout'=>$data['checkout'],
            'nights'=>$data['nights'],
            'hotel_name'=>$data['hotel_name'],
            'area_name'=>$data['area'],
            'room_type'=>$data['room_type'],
            'room_view'=>$data['room_view'],
            'stars'=>$data['stars'],
            'note'=>$data['note'],
        ]);

    }
}

