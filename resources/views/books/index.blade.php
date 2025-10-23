@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Books</h2>
                    <p class="text-sm text-gray-600 mt-1">Discover and borrow books from our collection</p>
                </div>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Book
                    </a>
                @endif

            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('books.index') }}" method="GET" class="mb-8 bg-gray-50 p-4 rounded-lg">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-search text-gray-400 mr-2"></i>
                            <label for="search" class="text-sm font-medium text-gray-700">Search Books</label>
                        </div>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, author, or ISBN..."
                                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                        @if (request('search'))
                            <a href="{{ route('books.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
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
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                        <div class="w-full aspect-w-2 aspect-h-3 bg-gray-100 flex items-center justify-center relative"
                            style="min-height: 240px; max-height: 320px;">
                            @if ($book->cover_image)
                                <img src="{{ asset('storage/cover/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                    class="object-cover w-full h-full" style="max-height: 320px; min-height: 240px;"
                                    loading="lazy">
                            @else
                                <div class="flex flex-col items-center justify-center w-full h-full">
                                    <i class="fas fa-book text-6xl text-indigo-200 mb-2"></i>
                                    <span class="text-gray-400">No cover</span>
                                </div>
                            @endif
                            @if ($book->quantity > 0)
                                <div class="absolute top-2 right-2 text-white text-xs px-3 py-1 rounded-full font-bold border border-white shadow z-10"
                                    style="background-color: #16a34a;">
                                    Available
                                </div>
                            @else
                                <div class="absolute top-2 right-2 text-white text-xs px-3 py-1 rounded-full font-bold border border-white shadow z-10"
                                    style="background-color: #dc2626;">
                                    Unavailable
                                </div>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-user-edit mr-2 text-indigo-500"></i>
                                {{ $book->author }}
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-book-open mr-1 text-indigo-500"></i>
                                    {{ $book->quantity }} available
                                </span>
                            </div>
                            <div class="flex gap-2 mt-auto">
                                <a href="{{ route('books.show', $book) }}"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Details
                                </a>
                                @if ($book->quantity > 0)
                                    <a href="{{ route('book-loans.create', $book) }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
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
                            @if (request('search'))
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
