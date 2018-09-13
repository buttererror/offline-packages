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

    public static  function getCities($country_id,$top_destinations){
        $data=[];
        if($top_destinations){

            $recomended_cities=City::whereIn('country_id',$country_id)
                ->where('top_destination','1')->get()
                ->toArray();
            $citiesObj=new \stdClass();
            $citiesObj->target="recomended";
            $citiesObj->cities=$recomended_cities;
            $data[]=$citiesObj;

            $remaining_cities=City::whereIn('country_id',$country_id)
                ->where('top_destination','0')->get()
                ->toArray();
            $citiesObj=new \stdClass();
            $citiesObj->target="remaining";
            $citiesObj->cities=$remaining_cities;
            $data[]=$citiesObj;
        }
        else{
            $data=City::whereIn('country_id',$country_id)->orderBy('top_destination','asc')->get();
        }

        return $data;
    }
}
