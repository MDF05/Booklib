<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_loan_id' => 'required|exists:book_loans,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Get the book loan
        $bookLoan = BookLoan::findOrFail($validated['book_loan_id']);

        // Check if user owns this loan
        if ($bookLoan->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Check if user has already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
            ->where('book_id', $bookLoan->book_id)
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);
        } else {
            // Create new review
            Review::create([
                'user_id' => Auth::id(),
                'book_id' => $bookLoan->book_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.'
        ]);
    }
}
