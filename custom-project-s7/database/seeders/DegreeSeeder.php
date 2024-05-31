<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // metodo pluck() estrae dal db una lista della colonna indicata e ci torna una Collection
        // metodo all() per convertire la Collection in un Array
        // php artisan tinker (per aprire la console per testare il codice)
        $faculty_ids = Faculty::all()->pluck('id')->all(); 

        Degree::create([
            'name' => 'Corso di Laurea in Ingegneria Industriale',
            'type' => 'T',
            'duration' => 3,
            'faculty_id' => fake()->randomElement($faculty_ids), // metodo per selezionare un elemento random da una lista
        ]);

        Degree::create([
            'name' => 'Corso di Laurea in Ingegneria Meccanica',
            'type' => 'M',
            'duration' => 2,
            'faculty_id' => fake()->randomElement($faculty_ids),
        ]);

        Degree::create([
            'name' => 'Corso di Laurea in Ingegneria Informatica',
            'type' => 'T',
            'duration' => 3,
            'faculty_id' => fake()->randomElement($faculty_ids),
        ]);

        Degree::create([
            'name' => 'Corso di Laurea in Lingue Moderne',
            'type' => 'M',
            'duration' => 2,
            'faculty_id' => fake()->randomElement($faculty_ids),
        ]);

        Degree::create([
            'name' => 'Corso di Laurea in Matematica',
            'type' => 'T',
            'duration' => 3,
            'faculty_id' => fake()->randomElement($faculty_ids),
        ]);

        // in questo modo richiamo la factory creando il numero di elementi inseriti
        Degree::factory(20)->create();
    }
}
