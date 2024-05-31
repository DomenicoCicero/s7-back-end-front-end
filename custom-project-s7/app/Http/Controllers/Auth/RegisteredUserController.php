<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            // le chiavi corrispondono ai nomi che abbiamo passato nel form
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_img' => ['nullable', 'image', 'max:1024'], // size in kilobytes
        ]);

        // per prima cosa salviamo l'immagine
        // il metodo put() accetta come primo argomento il percorso di dove salvarlo e come secondo il contenuto
        // questo metodo ci restituisce il percorso di dove l'ha salvato
        // questo percorso che ritorna è la stringa che andremo a salvare nel db
        // per poter accedere poi dal browser a questo indirizzo modifichiamo
        // in .env FILESYSTEM_DISK da local a public

        // adesso l'immagine viene salvata in storage/app/public ma questa cartella non è accessibile da internet
        // solo la cartella database/public è accessibile da internet
        // quindi il database/public creaiamo un percorso che punti a storage/app/public
        // digitando php artisan storage:link
        $file_path = Storage::put('', $request['profile_img']);

        // in questo modo mettiamo nel db dei valori in massa
        // questo è possibile perchè nel model abbiamo inserito $fillable
        $user = User::create([
            // le chiavi corrispondono alle colonne della tabella nel db
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'role' => 'student',
            'profile_img' => $file_path,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
