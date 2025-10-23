<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        Log::info('AdminController@dashboard: Accessing dashboard', [
            'user' => auth()->user(),
            'is_authenticated' => auth()->check(),
            'role' => auth()->check() ? auth()->user()->role : null
        ]);

        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalLoans = BookLoan::count();
        $pendingLoans = BookLoan::where('status', 'pending')->count();
        $activeLoans = BookLoan::where('status', 'approved')->count();

        $recentLoans = BookLoan::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockBooks = Book::where('quantity', '<', 5)
            ->orderBy('quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'pendingLoans',
            'activeLoans',
            'recentLoans',
            'lowStockBooks'
        ));
    }

    public function users()
    {
        Log::info('AdminController@users: Accessing users page', [
            'user' => auth()->user(),
            'is_authenticated' => auth()->check(),
            'role' => auth()->check() ? auth()->user()->role : null
        ]);

        $users = User::where('role', 'user')
            ->withCount(['bookLoans', 'ratings', 'comments'])
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function loans()
    {
        $bookLoans = BookLoan::with(['user', 'book'])->latest()->paginate(10);
        return view('admin.loans.index', compact('bookLoans'));
    }


}
