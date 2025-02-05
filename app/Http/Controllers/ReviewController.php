<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Reviews = Reviews::all();

        return response()->json([
            'status' => 200,
            'message' => 'Users retrieved successfully.',
            'data' => $Reviews
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id'    => 'required|integer',
            'user_id'    => 'required|integer',
            'rating'     => 'required|integer|min:1|max:5', 
            'comment'    => 'required|string|max:500',  
        ]);
        
        
        Log::info('Request data:', $request->all());
        
        try {
            $Reviews = Reviews::create($request->all());
        
            return response()->json([
                'status' => 201,
                'message' => 'User created successfully.',
                'data' => $Reviews
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
        $Reviews = Reviews::find($id);

        if (!$Reviews) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User retrieved successfully.',
            'data' => $Reviews
        ], 200);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Reviews = Reviews::find($id);

        if (!$Reviews) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found.',
            ], 404);
        }

        $request->validate([
            'book_id'    => 'required|integer',
            'user_id'    => 'required|integer',
            'rating'     => 'required|integer|min:1|max:5', 
            'comment'    => 'required|string|max:500',
        ]);
        $Reviews->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully.',
            'data' => $Reviews
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Reviews = Reviews::find($id);

        if (!$Reviews) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found.',
            ], 404);
        }

        $Reviews->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully.',
        ], 200);
    }
}