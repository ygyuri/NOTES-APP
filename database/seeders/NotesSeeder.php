<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::create([
            'title' => 'Sample Note 1',
            'content' => 'This is the content of sample note 1.',
            'user_id' => 1 // Assuming user with ID 1 exists
        ]);

        Note::create([
            'title' => 'Sample Note 2',
            'content' => 'This is the content of sample note 2.',
            'user_id' => 1 // Assuming user with ID 1 exists
        ]);

        // Add more sample notes if needed
    }
}