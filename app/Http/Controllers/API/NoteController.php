<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use App\Http\Controllers\API\Controller;
use App\Models\User;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    // Create a new note
    public function store(Request $request)
    {
        // Sanitize input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Additional validation if needed
        // Example: Ensure unique title
        $existingNote = Note::where('title', $validatedData['title'])->first();
        if ($existingNote) {
            return response()->json(['error' => 'Note with this title already exists.'], 400);
        }

        // Database transaction to ensure data consistency
        try {
            DB::beginTransaction();

            // Create note
            $note = Note::create([
                'user_id' => auth()->user()->id,
                'title' => $validatedData['title'],
                'content' => $validatedData['content']
            ]);

            // Commit transaction
            DB::commit();

            // Return success response
            return response()->json($note, 201);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log error
            \Log::error('Error creating note: ' . $e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to create note. Please try again.'], 500);
        }
    }

    // Get all notes
    public function index()
    {
        try {
            // Retrieve all notes with creator relationship
            $notes = Note::with('creator')->get();

            // Return retrieved notes
            return response()->json($notes);
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error fetching notes: ' . $e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to fetch notes. Please try again.'], 500);
        }
    }

    //show notes by id
    public function show($id)
{
    try {
        // Find the note by ID
        $note = Note::find($id);

        // Check if the note exists
        if (!$note) {
            return response()->json(['error' => 'Note not found.'], 404);
        }

        // Return requested note
        return response()->json($note);
    } catch (\Exception $e) {
        // Log error
        \Log::error('Error fetching note: ' . $e->getMessage());

        // Return error response
        return response()->json(['error' => 'Failed to fetch note. Please try again.'], 500);
    }
}
// Update a note
public function update(Request $request, $id)
{
    try {
        // Start a database transaction
        DB::beginTransaction();

        // Find the note by ID
        $note = Note::findOrFail($id);

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Sanitize input data
        $validatedData['title'] = trim($validatedData['title']);
        $validatedData['content'] = trim($validatedData['content']);

        // Update note
        $note->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content']
        ]);

        // Commit the transaction
        DB::commit();

        // Return updated note
        return response()->json($note);
    } catch (\Exception $e) {
        // Rollback the transaction on error
        DB::rollBack();

        // Log error
        \Log::error('Error updating note: ' . $e->getMessage());

        // Return error response
        return response()->json(['error' => 'Failed to update note. Please try again.'], 500);
    }
}

// Delete a note
public function destroy($id)
{
    try {
        // Start a database transaction
        DB::beginTransaction();

        // Find the note by ID
        $note = Note::findOrFail($id);

        // Delete note
        $note->delete();

        // Commit the transaction
        DB::commit();

        // Return null response with status code 204 (No Content)
        return response()->json(null, 204);
    } catch (\Exception $e) {
        // Rollback the transaction on error
        DB::rollBack();

        // Log error
        \Log::error('Error deleting note: ' . $e->getMessage());

        // Return error response
        return response()->json(['error' => 'Failed to delete note. Please try again.'], 500);
    }
}

}