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
} 