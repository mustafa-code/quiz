<?php

namespace App\Http\Requests\Quiz;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['subscribe', 'isSubscribable'], $this->quiz);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attend_time' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $currentTime = Carbon::now();
                    $valueTime = Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    if ($valueTime < $currentTime) {
                        $fail("The {$attribute} must be a future time.");
                    }
                    if ($this->quiz->quiz_type === 'in-time') {
                        $startTime = $this->quiz->start_time;
                        $endTime = $this->quiz->end_time;
        
                        if ($value < $startTime) {
                            $fail($attribute . ' must be equal to or after the quiz start time.');
                        }
        
                        if ($value > $endTime) {
                            $fail($attribute . ' must be equal to or before the quiz end time.');
                        }
                    }
                },
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->with('quiz_id', $this->quiz->id)
            ->withInput($this->input())
            ->withErrors($validator->errors(), 'quizSubscription')
        );
    }

}
