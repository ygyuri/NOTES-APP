<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    // Create a new note
    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'content' => 'required']); // Validate request data

        $note = Note::create(['user_id' => auth()->user()->id, 'title' => $request->title, 'content' => $request->content]); // Create note

        return response()->json($note, 201); // Return created note
    }

    // Get all notes
    public function index()
    {
        $notes = Note::with('creator')->get(); // Retrieve all notes with creator relationship

        return response()->json($notes); // Return retrieved notes
    }

    // Get a single note
    public function show(Note $note)
    {
        return response()->json($note); // Return requested note
    }

    // Update a note
    public function update(Request $request, Note $note)
    {
        $request->validate(['title' => 'required', 'content' => 'required']); // Validate request data

        $note->update(['title' => $request->title, 'content' => $request->content]); // Update note

        return response()->json($note); // Return updated note
    }

    // Delete a note
    public function destroy(Note $note)
    {
        $note->delete(); // Delete note

        return response()->json(null, 204); // Return null response
    }
}