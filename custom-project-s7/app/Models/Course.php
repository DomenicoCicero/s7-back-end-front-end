<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    // un subject è relazionato con una sola degree (scritta al singolare)
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    // un subject è relazionato con molti exams (scritta al plurale)
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    // più users sono relazionati con più courses (scritta al plurale) 
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('salary');
    }
}
