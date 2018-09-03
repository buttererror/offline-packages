<?php

namespace App\Http\Requests;

use App\Rules\AgeValidate;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'mobile' => 'required|unique:clients,mobile',
            'country_id' => 'required|integer',
            'address' => 'nullable|string|max:500',
            'gender' => 'required|string|in:male,female',
            'age' => ['nullable',new AgeValidate],
        ];
    }
}
