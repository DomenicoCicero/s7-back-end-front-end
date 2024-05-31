<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    public $timestamps = false;

    // una faculty è relazionata con molti degrees (scritto al plurale)
    // se eseguiamo questo metodo su una faculty (Faculty::find(1)->degrees) ci tornerà praticamente 
    // tutte le degrees associate con quella Factory senza bisogno di fare la join, facendola automaticamente
    // su questa funzione si possono poi fare query più avanzate. Ad esempio: 
    // Faculty::find(1)->degrees()->where('type', 'M')->get()  // per ottenere tutte le degrees associate con type = 'M'
    // questo metodo va chiamato senza parentesi Faculty::find(1)->degrees
    // oppure Faculty::find(1)->degrees()->get();
    public function degrees(): HasMany
    {
        return $this->hasMany(Degree::class);
    }
}
