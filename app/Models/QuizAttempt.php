<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'tenant_user_id', 'started_at', 'completed_at', 'score'];

    protected $dates = ['started_at', 'completed_at'];
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function tenantUser() : BelongsTo
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function userAnswers() : HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function getIsCompletedAttribute()
    {
        return $this->completed_at !== null;
    }

    public function getIsStartedAttribute()
    {
        return $this->started_at !== null;
    }

    // calculateScore
    public function calculateScore()
    {
        $score = 0;
        foreach ($this->userAnswers as $userAnswer) {
            if ($userAnswer->is_correct) {
                $score++;
            }
        }
        $this->score = $score;
        $this->save();
    }
    
    // Percentage
    public function getPercentageAttribute()
    {
        return round(($this->score / $this->quiz->questions->count()) * 100, 2);
    }

    public function getDurationAttribute()
    {
        return $this->started_at->diffInSeconds($this->completed_at);
    }
}
