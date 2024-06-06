<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use App\Http\Controllers\API\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

        try {
            // Start database transaction
            DB::beginTransaction();

            // Create note
            $note = new Note();
            $note->title = $validatedData['title'];
            $note->content = $validatedData['content'];
            $note->user_id = $request->user()->id; // Assign the authenticated user's ID

            // Save the note
            $note->save();

            // Commit transaction
            DB::commit();

            // Return success response
            return response()->json($note, 201);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log error
            Log::error('Error creating note: ' . $e->getMessage());

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
            Log::error('Error fetching notes: ' . $e->getMessage());

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
            Log::error('Error fetching note: ' . $e->getMessage());

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
            Log::error('Error updating note: ' . $e->getMessage());

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
            Log::error('Error deleting note: ' . $e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to delete note. Please try again.'], 500);
        }
    }
    // Update a note by a particular user
    public function updateNoteByUser(Request $request, $userId, $noteId)
    {
        try {
            // Ensure the authenticated user is the one being queried or is an admin (if applicable)
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            // Start a database transaction
            DB::beginTransaction();

            // Find the note by ID and ensure it belongs to the given user ID
            $note = Note::where('user_id', $userId)->findOrFail($noteId);

            // Validate request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Update note
            $note->update($validatedData);

            // Commit the transaction
            DB::commit();

            // Return updated note
            return response()->json($note);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating note: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update note. Please try again.'], 500);
        }
    }

    // Delete a note by a particular user
    public function deleteNoteByUser($userId, $noteId)
    {
        try {
            // Ensure the authenticated user is the one being queried
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }
            // Start a database transaction
            DB::beginTransaction();

            // Find the note by ID and ensure it belongs to the given user ID
            $note = Note::where('user_id', $userId)->findOrFail($noteId);

            // Delete note
            $note->delete();

            // Commit the transaction
            DB::commit();

            // Return null response with status code 204 (No Content)
            return response()->json("Note was successfully deleted", 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting note: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete note. Please try again.'], 500);
        }
    }
    public function getNotesByUser($userId)
    {
        try {
            // Ensure the authenticated user is authorized to fetch notes
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            // Retrieve notes by the given user ID
            $notes = Note::where('user_id', $userId)->get();

            // Return retrieved notes
            return response()->json($notes);
        } catch (\Exception $e) {
            Log::error('Error fetching notes by user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch notes. Please try again.'], 500);
        }
    }
}
