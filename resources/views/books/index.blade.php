@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Books</h2>
                <p class="text-sm text-gray-600 mt-1">Discover and borrow books from our collection</p>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Book
                </a>
            @endif
        </div>

        <!-- Search and Filter Form -->
        <form action="{{ route('books.index') }}" method="GET" class="mb-8 bg-gray-50 p-4 rounded-lg">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Books</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                            placeholder="Search by title, author, or ISBN..." 
                            class="pl-10 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="aspect-w-2 aspect-h-3 relative">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                <i class="fas fa-book text-4xl text-indigo-400"></i>
                            </div>
                        @endif
                        @if($book->available_copies > 0)
                            <div class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                Available
                            </div>
                        @else
                            <div class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                Unavailable
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                            <i class="fas fa-user-edit mr-2 text-indigo-500"></i>
                            {{ $book->author }}
                        </p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-book-open mr-1 text-indigo-500"></i>
                                {{ $book->available_copies }} available
                            </span>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($book->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                                <span class="ml-1 text-sm text-gray-600">({{ number_format($book->average_rating, 1) }})</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('books.show', $book) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-info-circle mr-2"></i>
                                Details
                            </a>
                            @if($book->available_copies > 0)
                                <a href="{{ route('book-loans.create', $book) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                    <i class="fas fa-book-reader mr-2"></i>
                                    Borrow
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-gray-50 rounded-lg p-8">
                        <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No books found.</p>
                        @if(request('search'))
                            <p class="text-gray-400 text-sm mt-2">Try adjusting your search criteria</p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection 