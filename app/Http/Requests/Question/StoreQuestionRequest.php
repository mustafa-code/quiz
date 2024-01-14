<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
            'tenant_id' => ['required', 'exists:tenants,id'],
            'quiz_id' => ['required', 'exists:quizzes,id'],
            'question' => ['required', 'string', 'max:255'],
            "slug" => [
                "required",
                "string",
                "max:255",
                Rule::unique('questions', 'slug')->where('tenant_id', $this->tenant_id),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
