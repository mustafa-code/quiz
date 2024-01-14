<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Choice extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'question_id',
        'title',
        'is_correct',
        'order',
        'description',
        'explanation',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->is_correct) {
                $model->question->choices()->where("id", "!=", $model->id)->update([
                    "is_correct" => false,
                ]);
            }
        });
        static::updating(function ($model) {
            if ($model->is_correct) {
                $model->question->choices()->where("id", "!=", $model->id)->update([
                    "is_correct" => false,
                ]);
            }
        });
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
