<?php

namespace App\Http\Requests;

use App\Rules\RequiredTime;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string|max:3000',
            'file' => 'mimes:pdf,jpg,png,docx,doc|max:16384',
            'required_time' => ['required', 'string', new RequiredTime()],
            'deadline_date' => 'required|date_format:Y-m-d'
        ];
    }

    public function messages()
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