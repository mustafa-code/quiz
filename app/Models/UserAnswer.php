<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_attempt_id', 'question_id', 'choice_id'];

    public function quizAttempt() : BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function choice() : BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }

    public function getIsCorrectAttribute()
    {
        return $this->choice->is_correct;
    }

}
