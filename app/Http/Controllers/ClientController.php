<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client ;

class ClientController extends Controller
{
   public function show(Request $request){
       return response()->json([
           'clients'=>Client::search($request->searchToken)->get() ,
       ]);
   }

   public  function store(Request $request){

   }


}
