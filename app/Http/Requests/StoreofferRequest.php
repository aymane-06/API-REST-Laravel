<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreofferRequest extends FormRequest
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
            // 'title' => 'required|string|max:255',
            // 'description' => 'required|string',
            // 'location' => 'required|string|max:255',
            // 'company_name' => 'required|string|max:255',
            // 'salary' => 'nullable|numeric',
            // 'job_type' => 'required|string|in:full-time,part-time,contract,freelance,internship',
            // 'experience_level' => 'nullable|string|in:entry,junior,mid,senior,executive',
            // 'skills' => 'nullable|array',
            // 'application_deadline' => 'nullable|date',
            // 'is_active' => 'nullable|boolean',
        ];
    }
}
