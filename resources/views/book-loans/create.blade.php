@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Borrow Book</h1>
                <p class="text-gray-600">Please fill in the details below to borrow this book.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="sm:w-1/3">
                        <div class="aspect-w-2 aspect-h-3 rounded-lg overflow-hidden shadow-lg">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/cover/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No cover</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:w-2/3">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $book->title }}</h2>
                        <p class="text-gray-600 mb-4">By {{ $book->author }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Available Copies</p>
                                <p class="text-gray-900">{{ $book->available_copies }} of {{ $book->total_copies }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rating</p>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 text-gray-900">{{ number_format($book->average_rating, 1) }}</span>
                                    <span class="ml-1 text-gray-500">({{ $book->ratings_count }} ratings)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('book-loans.store', $book) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="loan_date" class="block text-sm font-medium text-gray-700 mb-2">Loan Date</label>
                        <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('loan_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Return Date</label>
                        <input type="date" name="return_date" id="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+14 days'))) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('return_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Submit Loan Request
                        </button>
                        <a href="{{ route('books.show', $book) }}" class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 