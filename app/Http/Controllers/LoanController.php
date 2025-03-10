<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'status' => 200,
            'message' => 'Loans retrieved successfully.',
            'data' => $loans
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|string'
        ]);

        $loan = Loan::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Loan created successfully.',
            'data' => $loan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Loan retrieved successfully.',
            'data' => $loan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
            ], 404);
        }

        $request->validate([
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
            'status' => 'required|string'
        ]);

        $loan->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Loan updated successfully.',
            'data' => $loan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status' => 404,
                'message' => 'Loan not found.',
            ], 404);
        }

        $loan->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Loan deleted successfully.',
        ], 200);
    }
}
