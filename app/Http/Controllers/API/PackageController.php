<?php

namespace App\Http\Controllers\API;

use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

    public function index(){

        return view('home');
    }
    public function store(Request $request)
    {

        $data = $request->all();
        $package = new Package();
        $package->savePackageDetails($data);


        return response()->json([
            'success' => "package Request saved successfully"
        ], 200);
    }
}
