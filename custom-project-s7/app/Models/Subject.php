<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    public $timestamps = false;

        // un subject è relazionato con una sola degree (scritta al singolare)
        public function degree(): BelongsTo
        {
            return $this->belongsTo(Degree::class);
        }

        // un subjects è ralazionato con molti courses (scritta al plurale)
        public function courses(): HasMany
        {
            return $this->hasMany(Course::class);
        }
}
