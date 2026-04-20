<?php

namespace App\Http\Controllers;


use App\Models\Note;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('notes.index', [
            'notes' => Note::orderBy('is_pinned', 'desc')
            ->latest()
            ->paginate(10),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        $note = Note::create($request->validated());

        return redirect()->route('notes.show', ['note' => $note->id])
        ->with('success', 'Note created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('notes.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return redirect()->route('notes.show', ['note' => $note->id])
        ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with("success", 'Note: '. $note->title  . ' deleted successfully!');
    }

    public function togglePinned(Note $note)
    {

        $note->togglePinned();
        return redirect()->back()->with('success', 'Note pin updated.');
    }
}
