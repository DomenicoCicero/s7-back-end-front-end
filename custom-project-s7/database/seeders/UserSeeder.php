<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degree_ids = Degree::all()->pluck('id')->all(); 
        
        User::factory()->create([
            'name' => 'asdf Professor',
            'email' => 'asdf@asdf.asdf',
            'profile_img' => null,
            'role' => 'professor',
            'degree_id'=> null,
        ]);

        User::factory()->create([
            'name' => 'Qwer User',
            'email' => 'qwer@qwer.qwer',
            'profile_img' => null,
            'role' => 'student',
            'degree_id'=> 1,
        ]);

        // User::factory(10)->create();

        // creaiamo le tabelle ponte in relazione con users
        // le creiamo qui perchè è l'ultimo seeder che viene eseguito
        // controlliamo se lo $user ha la proprietà degree_id, se ce l'ha è uno student altrimenti professor
        // il metodo attach crea una nuova riga tra la variabile su cui viene invocato il metodo e la classe 
        // in relazione che viene specificata subito dopo (cioè il metodo che viene creato nei Model per le relazioni -> exams(), courses())
        // l'array associativo finale serve a specificare un campo extra da inserire
        $users = User::all()->all();
        $exam_ids = Exam::all()->pluck('id')->all(); 
        $course_ids = Course::all()->pluck('id')->all(); 

        foreach ($users as $user) {
            if($user->degree_id) {
                // di default il secondo argomento di randomElements è 1 che rappresenta quanti elementi selezionare, con null sarà a caso
                $exams_for_student = fake()->randomElements($exam_ids, null);
                foreach($exams_for_student as $exam_id) {
                    $user->exams()->attach($exam_id, ['mark' => rand(0, 31) ]);
                }
            } else {
                $courses_for_professor = fake()->randomElements($course_ids, null);
                foreach ($courses_for_professor as $course_id) {
                    // $user rappresenta l'oggetto utente che abbiamo preso da db
                    // courses() è il metodo dichiarato in UserModel che prende tutti i corsi associati allo user dalla tabella courses
                    // il metodo attach l'abbiamo a disposizione perchè laravel sa che c'è una tabella ponte per come l'abbiamo dichiarato il metodo
                    // questo metodo associa allo user preso dal db l'id del corso 
                    // in più aggiunge l'altro campo dichiarato nel secondo parametro
                    // se non avessimo l'altro campo bastava passare solo l'id del corso
                    // $user->courses()->detach($course_id); 
                    // questo metodo cancella la relazione; l'opposto di attach
                    // $user->courses()->sync([8,9,11]); esegue il metodo attach per più corsi direttamente
                    // se rieseguiamo questo metodo una seconda volta con dati diversi cancellerà i dati che non trova più ed aggiungerà quelli nuovi
                    $user->courses()->attach($course_id, ['salary' => rand(10000, 25000) ]);
                }
            }
        }
    }
}
