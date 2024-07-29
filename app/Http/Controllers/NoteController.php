<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Rules\ValidNote;
use App\Rules\ValidNoteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TryRule;

class NoteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note::all();
        // return Note::where('user_id', Auth::id())->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', new ValidNote],
            'important' => 'boolean',
            'user_id' => 'required'
        ],
        [
            'content.required' => new JsonResponse(["message" =>'content must no be empty' ]),
            'content.string' => new JsonResponse(["message" =>'content must be string' ]),
        ]);

        // $note = Note::create($validated);
        $note  = Note::create([
            'content' => $request->content,
            'important' => $request->important,
            'user_id' => $request->user_id,
        ]);
        return response()->json($note, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $note = Note::findOrFail($id);
        $note = Note::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id);
        // $note = Note::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'important' => 'boolean',
        ]);
        $note->update($validated);
        
        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        // $note = Note::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        // $note = Note::where('id',$id) -> where('user_id', $id);
        $note->delete();
        return response()->json(null,204);
        // return response()->json(['message' => 'Invalid or expired OTP.'], 400);

    }
}
