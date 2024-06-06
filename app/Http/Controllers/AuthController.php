<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data['password'] = bcrypt($data['password']);
        unset($data['password_confirmation']);
        $user = User::create($data);

        $token = $user->createToken('api_token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response([
                'error_message' => 'Invalid email or password !'
            ])->statusCode(400);
        }

        $token = auth()->user()->createToken('api_token')->accessToken;

        return  response()->json([
            'user' => auth()->user(),
            'token' => $token
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return  response()->noContent();
    }
}
