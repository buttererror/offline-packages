<?php

namespace App\Http\Controllers;

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
    public function store(Request $request):JsonResponse
    {
        //validate request
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails() || !$this->validateChildrenCount($request)){
            //gets any error message from the validator
            $errors = $validator->errors()->toArray();
            if(!$this->validateChildrenCount($request)){
                //add error message for the children_count field
                $errors['children_count'] = ['children_count must equal to the children'];
            }
            //return response with the errors messages
            return response()->json([
                'errors' => $errors
            ]);
        }
        //store the the package
        $package = Package::create([
            'user_id' => auth()->user()->id,
            'client_id'=>$request->client_id,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'nights' => $this->nights($request),
            'title'=>$request->title,
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
        //return response when successfully stored a package 
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

    /**
     * Get the validation rules
     *
     * @return array
     */
    private function rules():array
    {
        return [
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
        ];
    }

    /**
     * Validate the children count
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function validateChildrenCount(Request $request):bool
    {
        return $request->children_count == count($request->children);
    }

    /**
     * Calculate the package nights
     *
     * @param \Illuminate\Http\Request $request
     * @return int
     */
    private function nights(Request $request):int
    {
        $start = (new Carbon($request->start_date))->startOfDay();
        $end = (new Carbon($request->end_date))->startOfDay();
        return $start->diffInDays($end);
    }
}
