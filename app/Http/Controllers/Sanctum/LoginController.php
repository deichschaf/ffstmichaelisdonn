<?php

namespace App\Http\Controllers\Sanctum;

use App\Http\Controllers\GroundController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends GroundController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|string', 'password' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'fix errors', 'errors' => $validator->errors()], 401);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            #return response()->json(['status' => true, 'user' => Auth::user()]);
            #$user = Auth::user();
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['status' => true, 'user' => $user, 'token' => ['access_token' => $token, 'token_type' => 'Bearer']]);
        }
        return response()->json(['status' => false, 'message' => 'invalid username or password'], 401);
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['status' => true, 'message' => 'logged out']);
    }

    public function me()
    {
        return response()->json(['status' => true, 'user' => Auth::user()]);
    }
}
