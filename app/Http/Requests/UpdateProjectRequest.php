<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name' => 'nullable|string|max:50',
            'description' => 'nullable|string',  
            'user_id' => 'nullable |array',
            'user_id.*' => 'integer|exists:users,id',
            'role' => 'nullable |array|max:40',
            'role.*' => 'string',
            'contribution_hours' => 'nullable|integer',
            
            


        
        ];
    }
}
