<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::create([
            'name' => 'Facoltà di Scienze Naturali',
            'address' => 'Via Roma, 21550',
            'telephone' => '123456789',
        ]);

        Faculty::create([
            'name' => 'Facoltà di Ingegneria',
            'address' => 'Via Leopardi, 23750',
            'telephone' => '123646789',
        ]);
        
        Faculty::create([
            'name' => 'Facoltà di Studi Umanistici',
            'address' => 'Via Palermo, 45850',
            'telephone' => '483456789',
        ]);

        Faculty::factory(5)->create();
    }
}
