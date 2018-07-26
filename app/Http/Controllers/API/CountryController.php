<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        return Country::all();
    }
}
