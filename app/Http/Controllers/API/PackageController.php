<?php

namespace App\Http\Controllers\API;

use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    public function index(){

        return view('home');
    }
    public function store(Request $request)
    {

//        $request->validate([
//            'client_id' => 'required|integer|exists:clients,id',
//            'title' => 'nullable|string|max:255',
//            'start_date' => 'nullable|date_format:Y-m-d|after:yesterday',
//            'star_place' => 'nullable|string|max:255',
//            'note' => 'nullable|string|max:500'
//        ]);
        $data = $request->all();
        $package = new Package();
        $package->savePackageDetails($data);


        return response()->json([
            'package' => $package
        ], 201);
    }
}
