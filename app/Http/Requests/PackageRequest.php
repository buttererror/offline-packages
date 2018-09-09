<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'client_id' => 'required|integer',
            'start_date' => 'required|date',
            'title' => 'nullable|string',
            'end_date' => 'required|date|after:start_date',
            'number_of_destinations' => 'required|integer|min:1',
            'transfer' => 'boolean',
            'status' => [
                Rule::in('s1','s2','s3','s4','s5','s6')
            ],
            'start_place' => 'nullable|string',
            'note' => 'nullable|string',
            'countries' => 'required|array|min:1',
            'countries.*' => 'exists:countries,id',
            'adults' => 'required|integer|min:1',
            'children_count' => 'nullable|integer',
            'children' => 'nullable|array',
            'children.*' => 'min:0|max:11|integer'
        ];
    }
}
