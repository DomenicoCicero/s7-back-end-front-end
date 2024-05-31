<?php

use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// esempi: 
// rotta accessibile da localhost:800/api/hello
Route::get('/hello', function () {
    return 'ciao a tutti';
});

// rotta accessibile da localhost:800/api/array un array verrà convertito automaticamente in json
Route::get('/array', function () {
    return ['ciao a tutti', 'convertito', 'in  json'];
});

// di default non le prefissa automaticamente con api. quindi se volessimo tutte le rotte con questo prefisso utilizziamo il metodo group()
// Route::get('faculties', [FacultyController::class, 'index'])->name('api.faculties.index');

// il metodo prefix() prefissa automaticamente il percorso /faculties
Route::name('api.v1.')->prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // http://localhost:8000/api/v1/faculties
    Route::get('/faculties', [FacultyController::class, 'index'])->name('faculties.index');
    // http://localhost:8000/api/v1/faculties/{id}
    Route::get('/faculties/{faculty}', [FacultyController::class, 'show'])->name('faculties.show');
    // http://localhost:8000/api/v1/transcript
    Route::get('/transcript', [StudentController::class, 'transcript'])->name('student.transcript');
});
