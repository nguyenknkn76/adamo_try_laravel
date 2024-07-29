<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:profiles,user_id',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        $profile = Profile::create($validated);

        return response()->json($profile, 201);
    }

    public function show($id)
    {
        return Profile::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $validated = $request->validate([
            'address' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:15',
        ]);

        $profile->update($validated);

        return response()->json($profile);
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return response()->json(null, 204);
    }
}
