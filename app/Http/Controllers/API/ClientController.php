<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ClientController extends Controller
{
    public function search(Request $request)
    {
        if (!$request->searchText) {
            return [];
        }
        return Client::search($request->searchText)->take(7)->get();
    }

    public function store(Request $request)
    {
        if (!$request->isJson()) {
            abort(400);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'mobile' => 'required|unique:clients,mobile',
            'country_id' => 'required|integer',
            'address' => 'nullable|string|max:500',
            'gender' => 'required|string|in:male,female',
            'age' => 'nullable|integer|min:0|max:100',
        ]);
        $client = Client::create($request->all());
        $client->refresh();
        return response()->json([
            'client' => $client
        ], 201);

    }

    public function isMobileUnique(Request $request)
    {
        $request->validate([
            'mobile' => 'required'
        ]);
        $count = Client::where('mobile', $request->mobile)->count();
        return response()->json([
            'unique' => $count == 0
        ]);
    }

    public function isEmailUnique(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $count = Client::where('email', $request->email)->count();
        return response()->json([
            'unique' => $count == 0
        ]);
    }
}
