<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['approve', 'reject']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Auth::user()->role === 'admin' 
            ? BookLoan::with(['user', 'book'])->latest()->paginate(10)
            : Auth::user()->bookLoans()->with('book')->latest()->paginate(10);
        
        return view('book-loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        if ($book->quantity <= 0) {
            return redirect()->back()->with('error', 'Book is not available for loan.');
        }
        return view('book-loans.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        if ($book->quantity <= 0) {
            return redirect()->back()->with('error', 'Book is not available for loan.');
        }

        $loan = BookLoan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'loan_date' => now(),
            'status' => 'pending'
        ]);

        return redirect()->route('book-loans.show', $loan)
            ->with('success', 'Loan request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookLoan $bookLoan)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $bookLoan->user_id) {
            abort(403, 'This action is unauthorized.');
        }
        return view('book-loans.show', compact('bookLoan'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(BookLoan $bookLoan)
    {
        if ($bookLoan->book->quantity <= 0) {
            return redirect()->back()->with('error', 'Book is not available for loan.');
        }

        $bookLoan->update(['status' => 'approved']);
        $bookLoan->book->decrement('quantity');

        return redirect()->route('book-loans.index')
            ->with('success', 'Loan request approved successfully.');
    }

    public function reject(BookLoan $bookLoan)
    {
        $bookLoan->update(['status' => 'rejected']);
        return redirect()->route('book-loans.index')
            ->with('success', 'Loan request rejected successfully.');
    }

    public function return(BookLoan $bookLoan)
    {
        if (auth()->id() !== $bookLoan->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        $bookLoan->update([
            'status' => 'return_pending',
            'return_date' => null
        ]);

        return redirect()->route('book-loans.index')
            ->with('success', 'Return request submitted. Waiting for admin approval.');
    }
}
