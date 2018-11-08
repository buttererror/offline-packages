<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\PackageRequest;
use App\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{

    public function index($category)
    {
        $data = [];
        if ($category == "all") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->paginate(5);
        } else if ($category == "new") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'new')->paginate(5);
        }
        else if ($category == "received") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'received')->paginate(5);
        }
        else if ($category == "workingon") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'workingon')->paginate(5);
            $data['role'] = \Auth::user()->role->name;
        }
        else if ($category == "failed") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'failed')->paginate(5);
        }
        else if ($category == "done") {
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'done')->paginate(5);
        }
        else if ($category == "me"){
            $data['requests'] = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('user_id', Auth::id())->paginate(5); //category here is employee id
        }

        $data['category']=$category;
        $data['role'] = \Auth::user()->role->name;
        return view('requests', $data);
    }

    public function getRequests($category)
    {

        if ($category == "all") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->paginate(5);
        } else if ($category == "new") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'new')->paginate(5);
        }
        else if ($category == "received") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'received')->paginate(5);
        }
        else if ($category == "workingon") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'workingon')->paginate(5);
        }
        else if ($category == "failed") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'failed')->paginate(5);
        }
        else if ($category == "done") {
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('status', 'done')->paginate(5);
        }
        else if ($category == "me"){
            $requests = Package::with(['accommodationRequests','client','accommodationRequests.country','accommodationRequests.city'])->where('user_id', Auth::id())->paginate(5); //category here is employee id
        }
        return response()->json(['requests' => $requests]);


    }

    public function changeRequestStatus(Request $request){
        $request_id=$request->id;
        $request_status=$request->status;
        Package::where('id',$request_id)->update(['status'=>$request_status]);
    }

    public function searchRequest(Request $request){
        $data=$request->all();
        if($data['category']=="all"){
            $requests=Package::where('title','LIKE',$data['query'].'%')->paginate(5);
        }
        else{
            $requests=Package::where('title','LIKE',$data['query'].'%')->where('status',$data['category'])->paginate(5);

        }
        return response()->json(['requests' => $requests]);
    }



    public function create()
    {
        //
    }


    public function store(PackageRequest $request): JsonResponse
    {
        //validate request
        if (!$this->validateChildrenCount($request)) {
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


    public function show(Package $package)
    {
        //
    }

    public function edit(Package $package)
    {
        //
    }


    public function update(Request $request, Package $package)
    {
        //
    }

    public function destroy(Package $package)
    {
        //
    }

    private function validateChildrenCount(Request $request): bool
    {
        return $request->children_count == count($request->children);
    }

    private function nights(Request $request): int
    {
        $start = (new Carbon($request->start_date))->startOfDay();
        $end = (new Carbon($request->end_date))->startOfDay();
        return $start->diffInDays($end);
    }

    public function showCities(Request $request)
    {
        return response()->json([
            'cities' => City::search($request->searchToken)->get()
        ]);
    }
}
