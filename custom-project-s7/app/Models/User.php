<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_img',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // uno user è relazionato con una sola degree (scritta al singolare) 
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    // più users sono relazionati con più exams (scritta al plurale) 
    // ->withPivot('mark') rappresenta il campo extra da importare dato che il metodo BelongsToMany prende solo le chiavi esterne
    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class)->withPivot('mark');
    }

    // più users sono relazionati con più courses (scritta al plurale) 
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withPivot('salary');
    }
}
