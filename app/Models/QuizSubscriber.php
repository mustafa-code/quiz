<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuizSubscriber extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = [
        'quiz_id',
        'tenant_user_id',
        'attend_time',
        'event_id',
        'reminder_sent',
        'quiz_link',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function tenantUser()
    {
        return $this->belongsTo(TenantUser::class);
    }

    // Add a function to check if the quiz should start or attend time not passed yet.
    public function shouldStart()
    {
        return now()->greaterThan($this->attend_time);
    }

}
