<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StudentController extends Controller
{
    public function index()
    {
        return Student::with('courses')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);

        if ($request->has('courses')) {
            $student->courses()->attach($request->courses);
        }

        return response()->json($student->load('courses'), 201);
    }

    public function show($id)
    {  
        return Student::with('courses')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $student->update($validated);

        if ($request->has('courses')) {
            $student->courses()->sync($request->courses);
        }

        return response()->json($student->load('courses'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204);
    }
}
