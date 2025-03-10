<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'status' => 200,
            'message' => 'Books retrieved successfully.',
            'data' => $books
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'category_id' => 'required|integer',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        try {
            $book = Book::create($request->all());

            return response()->json([
                'status' => 201,
                'message' => 'Book created successfully.',
                'data' => $book
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error creating book.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Book retrieved successfully.',
            'data' => $book
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
            ], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'category_id' => 'required|integer',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $book->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Book updated successfully.',
            'data' => $book
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found.',
            ], 404);
        }

        $book->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Book deleted successfully.',
        ], 200);
    }
}
