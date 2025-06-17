<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Debug route
Route::get('/debug', function () {
    $data = [
        'user' => auth()->user(),
        'is_authenticated' => auth()->check(),
        'role' => auth()->check() ? auth()->user()->role : null,
        'session' => session()->all(),
        'request' => request()->all()
    ];
    Log::info('Debug route accessed', $data);
    return response()->json($data);
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['web', 'auth'])->group(function () {
    // Book routes
    Route::resource('books', BookController::class);
    
    // Book loan routes
    Route::get('books/{book}/loan', [BookLoanController::class, 'create'])->name('book-loans.create');
    Route::post('books/{book}/loan', [BookLoanController::class, 'store'])->name('book-loans.store');
    Route::get('book-loans', [BookLoanController::class, 'index'])->name('book-loans.index');
    Route::get('book-loans/{bookLoan}', [BookLoanController::class, 'show'])->name('book-loans.show');
    
    // Rating routes
    Route::post('books/{book}/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::put('ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
    
    // Comment routes
    Route::post('books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // User book loan actions
    Route::post('book-loans/{bookLoan}/return', [BookLoanController::class, 'return'])->name('book-loans.return');
});

// Admin Routes
Route::middleware(['web', 'auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/loans', [AdminController::class, 'loans'])->name('loans');
    Route::post('/book-loans/{bookLoan}/approve', [BookLoanController::class, 'approve'])->name('book-loans.approve');
    Route::post('/book-loans/{bookLoan}/reject', [BookLoanController::class, 'reject'])->name('book-loans.reject');
});
