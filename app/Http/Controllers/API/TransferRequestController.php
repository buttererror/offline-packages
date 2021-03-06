<?php

namespace App\Http\Controllers\API;

use App\Package;
use App\TransferRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferRequestController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->isJson()) {
            abort(400);
        }
        $request->validate([
            'package_id' => 'required|integer|exists:packages,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'date' => 'required|date|date_format:Y-m-d|after:today',
            'time' => 'nullable|date_format:H:i',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'nullable|integer|min:0',
            'quality' => 'nullable|string|max:255|in:economical|medium|luxory',
        ]);
        $transferRequest = TransferRequest::create($request->all());
        $transferRequest->refresh();
        return response()->json([
            'transfer_request' => $transferRequest
        ], 201);
    }
}
