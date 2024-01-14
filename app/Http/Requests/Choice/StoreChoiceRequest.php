<?php

namespace App\Http\Requests\Choice;

use Illuminate\Foundation\Http\FormRequest;

class StoreChoiceRequest extends FormRequest
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
        // title	is_correct	order	description	explanation
        return [
            'title' => 'required|string|max:255',
            'is_correct' => 'nullable|boolean',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'explanation' => 'nullable|string',
        ];
    }
}
