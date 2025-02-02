<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;

    // un exam è relazionato con un solo course (scritta al singolare)
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // più exams sono relazionati con più users (scritta al plurale) 
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('mark');
    }
}
