<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class BookLoanController extends Controller
{
    public function index()
    {
        $bookLoans = BookLoan::with(['user', 'book'])->latest()->paginate(10);
        return view('admin.loans.index', compact('bookLoans'));
    }

    public function show(BookLoan $bookLoan)
    {
        return view('admin.loans.show', compact('bookLoan'));
    }

    public function approve(BookLoan $bookLoan)
    {
        $bookLoan->update([
            'status' => 'approved',
            'loan_date' => now(),
            'return_date' => now()->addDays(7)
        ]);

        return redirect()->route('admin.loans.show', $bookLoan)
            ->with('success', 'Book loan has been approved.');
    }

    public function reject(BookLoan $bookLoan)
    {
        $bookLoan->update([
            'status' => 'rejected'
        ]);

        return redirect()->route('admin.loans.show', $bookLoan)
            ->with('success', 'Book loan has been rejected.');
    }
} 