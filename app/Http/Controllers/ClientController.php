<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
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

   public  function store(ClientRequest $request){

       $data=$request->all();
       $data['age']=Client::getAge($data['birthDate']);
       $client = Client::create($data);
       $client->refresh();
       return response()->json([
           'client'=>$client
       ]);
   }







}
