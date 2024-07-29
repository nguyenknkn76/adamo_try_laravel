<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return Course::with('students')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $course = Course::create($validated);

        if ($request->has('students')) {
            $course->students()->attach($request->students);
        }

        return response()->json($course->load('students'), 201);
    }

    public function show($id)
    {
        return Course::with('students')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $course->update($validated);

        if ($request->has('students')) {
            $course->students()->sync($request->students);
        }

        return response()->json($course->load('students'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(null, 204);
    }
}

