@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Loan Details</h1>
                <p class="text-gray-600">View the details of your book loan request.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="sm:w-1/3">
                        <div class="aspect-w-2 aspect-h-3 rounded-lg overflow-hidden shadow-lg">
                            @if($bookLoan->book->cover_image)
                                <img src="{{ asset('storage/cover/' . $bookLoan->book->cover_image) }}" alt="{{ $bookLoan->book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No cover</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:w-2/3">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $bookLoan->book->title }}</h2>
                        <p class="text-gray-600 mb-4">By {{ $bookLoan->book->author }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">ISBN</p>
                                <p class="text-gray-900">{{ $bookLoan->book->isbn }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Published Year</p>
                                <p class="text-gray-900">{{ $bookLoan->book->published_year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Loan Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Loan Date</p>
                            <div class="text-sm text-gray-900">
                                @if($bookLoan->loan_date)
                                    {{ $bookLoan->loan_date->format('M d, Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Expected Return Date</p>
                            <div class="text-sm text-gray-900">
                                @if($bookLoan->return_date)
                                    {{ $bookLoan->return_date->format('M d, Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $bookLoan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $bookLoan->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $bookLoan->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $bookLoan->status === 'returned' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst($bookLoan->status) }}
                            </span>
                        </div>
                        @if($bookLoan->returned_at)
                            <div>
                                <p class="text-sm text-gray-500">Actual Return Date</p>
                                <p class="text-gray-900">{{ $bookLoan->returned_at->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>

                    @if($bookLoan->notes)
                        <div class="mt-6">
                            <p class="text-sm text-gray-500">Notes</p>
                            <p class="text-gray-900">{{ $bookLoan->notes }}</p>
                        </div>
                    @endif

                    @if($bookLoan->status === 'approved' && !$bookLoan->returned_at)
                        <div class="mt-6">
                            <form action="{{ route('book-loans.return', $bookLoan) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to mark this book as returned?')">
                                    Mark as Returned
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('book-loans.index') }}" class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back to Loans
                </a>
                <a href="{{ route('books.show', $bookLoan->book) }}" class="flex-1 text-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    View Book Details
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 