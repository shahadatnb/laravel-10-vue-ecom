<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //'amount'=>'required',
            'name'=>'required|max:50',
            'address'=>'required|max:150',
            'email'=>'required|email|max:50',
            'city'=>'required|max:50',
            'country'=>'nullable|max:50',
            'phone'=>'required|digits:11',
            'products' => 'required',
            'postalCode' => 'nullable|max:5',
        ];
    }

    public function messages()
    {
        return [
            'products.required' => 'Please add to cart at least one product',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
