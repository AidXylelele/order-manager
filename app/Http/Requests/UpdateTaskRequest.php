<?php

namespace App\Http\Requests;

use App\Rules\RequiredTime;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Assuming you want to authorize all users to update tasks
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:3000', // Use nullable for optional fields
            'file' => 'nullable|mimes:pdf,jpg,png,docx,doc|max:16384', // Use nullable for optional file upload
            'required_time' => ['required', 'string', new RequiredTime()], // Assuming RequiredTime is a custom rule
            'deadline_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field must not exceed 255 characters.',
            'description.string' => 'The description field must be a string.',
            'description.max' => 'The description field must not exceed 3000 characters.',
            'deadline_date.required' => 'The deadline date is required.',
            'deadline_date.date_format' => 'The deadline date should be in format: Y-m-d.',
            'required_time.required' => 'The required time is required',
            'required_time.string' => 'The required time should be a string.',
            'file.mimes' => 'Uploaded file should be jpg,png',
            'file.max' => 'The file size must not exceed 16384 bytes.'
        ];
    }
}