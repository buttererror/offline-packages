<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($language)
    {
        $data['language']=$language;
        return view('home',$data);
    }

    public function getTranslations(){
        $en_file = json_decode(File::get(storage_path('app/translations/en.json')));
        $ar_file = json_decode(File::get(storage_path('app/translations/ar.json')));
        return response()->json(['en'=>$en_file,'ar'=>$ar_file]);
    }
}
