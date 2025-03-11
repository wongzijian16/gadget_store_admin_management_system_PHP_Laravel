<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Hash;

class AuthController extends Controller {

    public function login(Request $request)
    {
		$user = User::where('email', '=', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
			return $this->respondWithToken($user);
        }
        return $this->respondWithMessage();
    }

    protected function respondWithToken($user)
    {
        return response()->json([
            'info' => $user,
        ]);
    }
    protected function respondWithMessage()
    {
        return response()->json([
            'message' =>"Unauthorize",
        ]);
    }
}