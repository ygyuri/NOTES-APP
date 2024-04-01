<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'notes' table
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            // Title of the note
            $table->string('title');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Content of the note
            $table->text('content');

            // Timestamps for record creation and updates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
}
