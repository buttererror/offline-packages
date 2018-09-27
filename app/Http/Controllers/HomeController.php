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
    public function index()
    {
        return view('home');
    }

    public function changeLocal(){
        if(app()->getLocale() == 'en'){
            app()->setLocale('ar');
            session()->put('current_locale','ar') ;
        }else{
            app()->setLocale('en');
            session()->put('current_locale','en');
        }
        if(! request()->ajax()){
            return redirect()->back();
        }
    }

    public function setLocal($lang){
        session()->put('current_locale',$lang) ;
        return redirect()->route('home');
    }

    public function getTranslations(){
        $en_file = json_decode(File::get(storage_path('app/translations/en.json')));
        $ar_file = json_decode(File::get(storage_path('app/translations/ar.json')));
        return response()->json(['en'=>$en_file,'ar'=>$ar_file]);
    }
}
