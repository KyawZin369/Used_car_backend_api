<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function index()
    {

        $user = User::all();

        return response()->json(['user' => $user], 200);
    }

    public function show($request){
        $user = User::findOrFail($request);

        return response()->json(['user' => $user], 200);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('authToken')->plainTextToken;
            $user = Auth::user();
            $isAdmin = $user->is_admin;
            return response()->json(['token' => $token, 'user' => $user, 'is_admin' => $isAdmin], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->update($request->only('name', 'email', 'profile_details'));

        return response()->json(['user' => $user], 200);
    }
}
