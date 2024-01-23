<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Trait AdminTrait
 * @package App\Http\Traits
 */
trait AdminTrait
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function makeAcpLogin(Request $request): JsonResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        dd($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            //$user = Auth::user();
            $token = Auth::getSession()->getId();
            return response()->json(['success' => true, 'token' => $token]);
        }
        return response()->json([
            'errors' => [
                'email' => 'The provided credentials do not match our records.',
            ]
        ], 422);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function makeAcpLogout(Request $request): JsonResponse
    {
        Auth::logout();
        return response()->json('', 200);
    }

    public function makeCheckAcpRights(Request $request): JsonResponse
    {
        $token = $request->get('token');
        if (!Auth::check()) {
            return response()->json('', 422);
        }
    }
}
