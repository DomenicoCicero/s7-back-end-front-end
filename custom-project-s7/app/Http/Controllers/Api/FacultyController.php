<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;

class FacultyController extends Controller
{

    public function index()
    {
        // $faculties = Faculty::all(); // per ottenere tutte le righe dalla tabella faculty
        // $faculties = Faculty::with('degrees')->get(); // per ottenere tutte le righe della tabella faculty con tutte le degree associate
        $faculties = Faculty::with('degrees')->get(); // per ottenere tutte le righe della tabella faculty con tutte le degree associate e tutte le subject associate a degrees
        return $faculties;
    }

    /**
     * il metodo show scritto così ci torna direttamente l'oggetto che vogliamo
     * in questo moto tramite la dependency injection fa una query per trovarci l'oggetto
     */
    // public function show(Faculty $faculty)
    // {
    //     // in questo caso basta solo fare return perchè tramite la dependency injection la trova automaticamente
    //     // ma in questo modo non avremo anche le degrees associate
    //     return $faculty;
    // }

        /**
     * in questo modo invece ci torna anche le degrees associate
     * e non vale la pena fare la dependency injection perchè altrimenti poi farebbe 2 query
     * allora come parametro passiamo solo $id
     * usiamo il metodo find() al posto di findOrFail() in modo da gestirci l'errore
     */
    public function show($id)
    {
        $faculty = Faculty::with('degrees', 'degrees.subjects')->find($id);
        if(!$faculty) {
            // metodo response accetta come primo argomento il content e come secondo lo status
            return response(['message' => 'Not found'], 404);
        } else {
            return [
                'data' => $faculty
            ];
        }
    }
}
