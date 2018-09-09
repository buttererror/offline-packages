<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\PackageRequest;
use App\Package;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PackageRequest $request):JsonResponse
    {
        //validate request
        if(!$this->validateChildrenCount($request)){
            //add error message for the children_count field
            $errors['children_count'] = ['children_count must equal to the children'];
        }
        //store the the package
        $package = Package::create([
            'user_id' => auth()->user()->id,
            'client_id' => $request->client_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nights' => $this->nights($request),
            'title' => $request->title,
            'number_of_destinations' => $request->number_of_destinations,
            'transfer' => $request->transfer,
            'status' => $request->status,
            'start_place' => $request->start_place,
            'note' => $request->note,
            'countries' => $request->countries,
            'adults' => $request->adults,
            'children_count' => $request->children_count,
            'children' => $request->children,
        ]);
        //return response when successfully stored a package
        return response()->json([
            'package' => $package
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

    public function destroy(Package $package)
    {
        //
    }

    private function validateChildrenCount(Request $request):bool
    {
        return $request->children_count == count($request->children);
    }

    private function nights(Request $request):int
    {
        $start = (new Carbon($request->start_date))->startOfDay();
        $end = (new Carbon($request->end_date))->startOfDay();
        return $start->diffInDays($end);
    }
    public  function showCities(Request $request){
        return response()->json([
            'cities'=>City::search($request->searchToken)->get()
        ]);
    }
}
