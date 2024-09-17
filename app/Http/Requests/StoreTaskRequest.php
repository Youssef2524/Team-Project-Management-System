<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'project_id' => 'required|exists:projects,id',
            // 'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:new,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'start_task' => 'nullable|date',
            'finsh_task' => 'nullable|date',
            'commint' => 'nullable|string',
            // 'user_id' => 'required|exists:users,id',
            // 'role' => 'required|string|max:255',
            
        ];
    }
}
