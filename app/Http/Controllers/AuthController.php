<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            if(!Auth::attempt($validated)) {
                return response()->json([
                    'message' => 'Login Information invalid.'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login Information invalid.'
            ], 401);
        }

        $user = User::where('email', $validated)->first();

        $data = new UserResource($user);
        $data['access_token'] = $user->createToken('api_token')->accessToken;
        $data['token_type'] = 'Bearer';
        return response()->json([
            'data' => $data
        ]);
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed:min:6'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        //Assigning Roles
        // $role = Role::where('name', 'user')->first();

        // $user->roles()->attach($role);

        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('api_token')->accessToken,
            'token_type' => 'Bearer'
        ]);
    }
}
