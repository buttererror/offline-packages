<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country ;

class CountriesController extends Controller
{
    public function index(){
        return response()->json([
            'countries'=> Country::all()
        ]);
    }
}
