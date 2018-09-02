<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client ;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
   public function show(Request $request){
       return response()->json([
           'clients'=>Client::search($request->searchToken)->get() ,
       ]);
   }

   public  function store(Request $request){
       $validationRequest = $this->validateRules();
       $request->validate($validationRequest);
       $client = new Client();
       $client->name = $request->name ;
       $client->email = $request->email ;
       $client->mobile = $request->mobile ;
       $client->country_id = $request->country_id;
       $client->address = $request->address;
       $client->passport_no=$request->passport_no;
       $client->age = $request->age;
       $client->save();
       return response()->json([
           'client'=>$client
       ]);
   }

   public function validateRules(){
       return [
           'name'=>'required|string',
           'email'=>'nullable|email',
           'mobile'=>'required|unique:clients,mobile|integer',
           'country_id'=>'required|exists:countries,id',
           'address'=>'nullable|string',
           'gender'=>'required', Rule::in(['male','female']),
           'passport_no'=>'nullable|string',
           'age'=>'nullable|integer'
       ] ;
   }



}
