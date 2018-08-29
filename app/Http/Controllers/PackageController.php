<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'client_id'=>'required|integer',
            'start_date'=>'required|date',
            'title'=>'nullable|string',
            'end_date'=>'required|date|after:start_date',
            'number_of_destinations'=>'required|integer|min:1',
            'transfer'=>'boolean',
            'status'=>[Rule::in('s1','s2','s3','s4','s5','s6')],
            'start_place'=>'nullable|string',
            'note'=>'nullable|string',
            'countries'=>'required|array|min:1',
            'countries.*'=> 'exists:countries,id',
            'adults'=>'required|integer|min:1',
            'children_count'=>'nullable|integer',
            'children'=>'nullable|array',
            'children.*'=>'min:0|max:11|integer'
        ]) ;

        $package = Package::create([
            'client_id'=>$request->client_id,
            'start_date'=>$request->start_date,
            'title'=>$request->title,
            'end_date'=>$request->end_date,
            'number_of_destinations'=>$request->number_of_destinations,
            'transfer'=>$request->transfer,
            'status'=>$request->status,
            'start_place'=>$request->start_place,
            'note'=>$request->note,
            'countries'=>$request->countries,
            'adults'=>$request->adults,
            'children_count'=>$request->children_count,
            'children'=>$request->children,
        ]);

        return response()->json([
            'package'=>$package
        ]);
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
