<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// questo controller è stato creato per accedere agli esami superati dello studente loggato
class StudentController extends Controller
{
    // lista esami superati dallo studente loggato
    public function transcript() {
        // seleziona l'id dello studente loggato
        $student_id = Auth::user()->id;
        // $student_id = 2;

        // metodo with() espande i campi di user con la tabella associata exams
        $passed_exams = User::with('exams', 'exams.course', 'exams.course.subject')->find($student_id); // ->exams()->where('mark', '>=', 18)->orderBy('date')->get();
        return [
            'success' => true,
            'data' => $passed_exams,
        ];
    }
}
