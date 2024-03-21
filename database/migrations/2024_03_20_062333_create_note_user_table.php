<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'note_user' pivot table for collaborated notes
        Schema::create('note_user', function (Blueprint $table) {
            // Foreign key reference for the note
            $table->foreignId('note_id');
            // Foreign key reference for the user collaborating on the note
            $table->foreignId('user_id');

            // Timestamps for record creation and updates
            $table->timestamps();

            // Ensure the combination of note_id and user_id is unique
            $table->unique(['note_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_user');
    }
}