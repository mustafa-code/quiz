<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;
use App\Models\Question;

class AttemptQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('view', $this->quizSubscriber);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => 'required|array',
            'question.*' => 'required|exists:choices,id',
            'quiz_attempt_id' => 'required|exists:quiz_attempts,id',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $questionIds = array_keys($this->input('question', []));
            if (Question::whereIn('id', $questionIds)->count() !== count($questionIds)) {
                $validator->errors()->add('question', 'One or more questions are invalid.');
            }
        });
    }

}
