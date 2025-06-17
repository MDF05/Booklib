<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user has borrowed and returned the book
        $hasBorrowed = $book->bookLoans()
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->exists();

        if (!$hasBorrowed) {
            return redirect()->back()
                ->with('error', 'You can only rate books that you have borrowed and returned.');
        }

        // Check if user has already rated this book
        $existingRating = $book->ratings()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRating) {
            $existingRating->update($validated);
            $message = 'Rating updated successfully.';
        } else {
            $book->ratings()->create([
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);
            $message = 'Rating submitted successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating->update($validated);

        return redirect()->back()
            ->with('success', 'Rating updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $this->authorize('delete', $rating);
        
        $rating->delete();

        return redirect()->back()
            ->with('success', 'Rating deleted successfully.');
    }
}
