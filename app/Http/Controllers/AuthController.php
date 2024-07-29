<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $user->update(['remember_token' => $token]);

        return response()->json( [
                'token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
        ]);
    }

    public function logout(Request $request)
    {
        // Lấy user hiện tại đã xác thực
        $user = $request->user();

        // Hủy token xác thực của user
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
