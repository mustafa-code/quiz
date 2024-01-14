<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuizRequest extends FormRequest
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
            "tenant_id" => "required|exists:tenants,id",
            "title" => "required|string|max:255",
            "slug" => [
                "required",
                "string",
                "max:255",
                Rule::unique('quizzes', 'slug')->where('tenant_id', $this->tenant_id),
            ],
            "description" => "nullable|string|max:255",

            'quiz_type' => 'required|in:in-time,out-of-time',
            'start_time' => 'nullable|required_if:quiz_type,in-time|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|required_if:quiz_type,in-time|date_format:Y-m-d\TH:i|after_or_equal:start_time',
    
        ];
    }
}
