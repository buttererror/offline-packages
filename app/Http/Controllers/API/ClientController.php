<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->isJson()){
            abort(400);
        }
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'nullable|email|unique:clients,email',
            'mobile'=>'required|unique:clients,mobile',
            'country_id'=>'required|integer',
            'address'=>'nullable|string|max:500',
            'gender'=>'required|string|in:male,female',
            'age'=>'nullable|integer|min:0|max:100',
        ]);
        $data = $request->all();
        Client::create($data);

    }
}
