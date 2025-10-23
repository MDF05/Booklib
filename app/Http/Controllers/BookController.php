<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book-loans.create');
    }


    // ! create multipie books
    public function storeMultiple(Request $request)
{
    $validated = $request->validate([
        'books' => 'required|array',
        'books.*.title' => 'required|string|max:255',
        'books.*.author' => 'required|string|max:255',
        'books.*.description' => 'nullable|string',
        'books.*.quantity' => 'required|integer|min:0',
        'books.*.published_date' => 'nullable|date',
        'books.*.cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $savedBooks = [];

    foreach ($validated['books'] as $bookData) {
        // upload cover jika ada
        if (isset($bookData['cover_image'])) {
            $coverPath = $bookData['cover_image']->store('cover', 'public');
            $bookData['cover_image'] = str_replace('cover/', '', $coverPath);
        }

        $savedBooks[] = Book::create($bookData);
    }

    response()->json([
        'success' => true,
        'message' => 'Books successfully saved',
        'data' => $savedBooks
    ]);

    return redirect('/books');

}


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $user = auth()->user();
        $hasBorrowed = false;

        if ($user) {
            $hasBorrowed = $book->bookLoans()
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->exists();
        }

        $ratings = $book->ratings()->with('user')->latest()->get();
        $comments = $book->comments()->with('user')->latest()->get();
        return view('books.show', compact('book', 'ratings', 'comments', 'hasBorrowed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'published_date' => 'nullable|date',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
