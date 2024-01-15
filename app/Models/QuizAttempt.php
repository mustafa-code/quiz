<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'tenant_user_id', 'started_at', 'completed_at', 'score'];

    public function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function tenantUser() : BelongsTo
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function userAnswers()
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

    
}
