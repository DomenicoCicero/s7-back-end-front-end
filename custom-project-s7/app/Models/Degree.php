<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Degree extends Model
{
    use HasFactory;

    public $timestamps = false;

    // una degree è relazionata con una sola faculty (scritta al singolare)  // BelongsTo->AppartieneA
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    // una degree è relazionata con più subjects (scritta al plurale) 
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    // una degree è relazionata con più users (scritta al plurale) 
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


}
