<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:40',
            'email' => 'required|string|email|max:40|unique:users',
            'password' => 'required|string|min:8',
            'role_user' => 'required|in:Admin,manager,user',
        ];
    }
    protected function failedValidation(\Illuminate\contracts\Validation\Validator $validator) 
    { 
    throw new HttpResponseException(response()->json([ 
    'status'=>'error', 
    'message'=>'Please check the input', 
    'errors'=>$validator->errors(), 
    ])); 
    } 
    public function attributes()
{
    return [
        'name' => 'الاسم',
        'email' => 'البريد الالكتروني',
    ];
}
public function messages()
{
    return [
        'name.required' => 'يرجى إدخال :attribute.',
        'email.required' => 'يرجى ادخال :attribute.',
    ];
}
    }

