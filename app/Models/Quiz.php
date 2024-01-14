<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Quiz extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'title',
        'slug',
        'description',
        'quiz_type',
        'start_time',
        'end_time',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getQuizTypeNameAttribute()
    {
        return $this->quiz_type === 'in-time' ? 'In Time' : 'Out of Time';
    }

    // Check if the quiz can be started.
    public function canStart(): bool
    {
        if ($this->quiz_type === 'out-of-time') {
            return true;
        }

        $now = now();
        return $now->between($this->start_time, $this->end_time);
    }
}
