<?php

namespace App\Http\Controllers\API;

use App\AccommodationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccommodationRequestController extends Controller
{
    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        if (!$request->isJson()) {
            abort(400);
        }
        $request->validate([
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
            'destination' => 'required|integer',
            'place' => 'nullable|string|max:500',
            'note' => 'nullable|string|max:1000',
            'hotel' => 'nullable|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'array',
            'rooms.*.children_ages.*' => 'integer|min:0|max:12',
            'rooms.*.adults' => 'required|integer|min:1|max:3',
        ]);
        $this->validateRoomAdultChildMatching($request);
        $data = $request->all();
        $data['destination_id'] = $data['destination'];
        AccommodationRequest::create($data);
    }

    /**
     * @param Request $request
     */
    protected function validateRoomAdultChildMatching(Request $request)
    {
        foreach ($request->rooms as $roomIndex => $room) {
            switch ($room['adults']) {
                case 1:
                    $request->validate([
                        "rooms.{$roomIndex}.children_ages" => 'array|max:3',
                    ]);
                    break;
                case 2:
                    $request->validate([
                        "rooms.{$roomIndex}.children_ages" => 'array|max:2',
                    ]);
                    break;
                case 3:
                    $request->validate([
                        "rooms.{$roomIndex}.children_ages" => 'array|max:0',
                    ]);
                    break;
            }

        }
    }
}
