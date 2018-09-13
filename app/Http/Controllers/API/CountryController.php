<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        return Country::select('id','en_short_name')->get();
    }

    public function searchCountry(Request $request){
        $data=$request->all();
       $countries= Country::where('en_short_name','LIKE', $data['query'].'%')->select('id','en_short_name')->get();
       return $countries;


    }
    public function cities(Request $request){
        $country_ids=$request->country_ids;
        $top_destinations=$request->top_destination;
        return response()->json(['cities'=>Country::getCities($country_ids,$top_destinations)]);
    }

}
