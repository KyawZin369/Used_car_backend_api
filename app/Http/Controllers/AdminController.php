<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $admin = Admin::create($validated);

        return response()->json(['admin' => $admin], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('AdminToken')->plainTextToken;

            return response()->json([
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }


    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function updateProfile(Request $request)
    {
        $admin = $request->user();
        $admin->update($request->only('name', 'email', 'profile_details'));

        return response()->json(['admin' => $admin], 200);
    }
}
