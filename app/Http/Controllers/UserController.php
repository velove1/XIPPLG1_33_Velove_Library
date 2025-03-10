<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Users = User::all();

        return response()->json([
            'status' => 200,
            'message' => 'Users retrieved successfully.',
            'data' => $Users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);
        
        Log::info('Request data:', $request->all());
        
        try {
            $User = User::create($request->all());
        
            return response()->json([
                'status' => 201,
                'message' => 'User created successfully.',
                'data' => $User
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
        
            return response()->json([
                'status' => 500,
                'message' => 'Error creating user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User retrieved successfully.',
            'data' => $User
        ], 200);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        $request->validate(['name' => 'required|string']);

        $User->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully.',
            'data' => $User
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        $User->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully.',
        ], 200);
    }
}
