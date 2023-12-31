<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Choice extends Model
{
    use BelongsToTenant;

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
