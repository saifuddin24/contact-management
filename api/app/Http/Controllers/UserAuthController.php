<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{

    public function create(Request $request)
    {
        $fields = $request->validate([
            'name'      => 'required|string',
            'email'      => 'required|email|string|unique:users,email',
            'phone'     => 'required|string|unique:users,phone',
            'password'  => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'      => $fields['name'],
            'phone'     => $fields['phone'],
            'email'     => $fields['email'],
            'password'  => bcrypt($fields['password']),
        ]);

        $token = $user->createToken(Request()->ip())->plainTextToken;

        return response([
            'user'      => $user,
            'token'     => $token,
            'success'   => true,
            'message'   => 'Registration successfull!',
        ], 201);
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'     => 'required|string',
            'password'  => 'required|string|min:6',
        ]);

        // Checking email
        $user = User::where('email', $fields['email'] )->first();

        // Checking password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Phone or Password wrong!',
            ], 401 );
        }

        $token = $user->createToken(Request()->ip())->plainTextToken;

        return response([
            'user'  => $user,
            'token' => $token
        ], 201);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();

        return response([
            'message'   => 'Logged Out'
        ], 200);
    }

}
