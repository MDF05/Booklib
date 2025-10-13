@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">All Reviews</h1>
                        <p class="text-gray-600 mt-1">Manage and view all user reviews</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            Total: {{ $reviews->total() }} reviews
                        </span>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Book Title Filter -->
                        <div>
                            <label for="book_title" class="block text-sm font-medium text-gray-700 mb-1">Book Title</label>
                            <input type="text" 
                                   id="book_title" 
                                   name="book_title" 
                                   value="{{ request('book_title') }}"
                                   placeholder="Search by book title..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>

                        <!-- Rating Filter -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <select id="rating" 
                                    name="rating" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">All Ratings</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Sort Filter -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <select id="sort" 
                                    name="sort" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest Rating</option>
                                <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
                            </select>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="flex items-end space-x-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.reviews.index') }}" 
                               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Reviews List -->
                @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <!-- Book and User Info -->
                                        <div class="flex items-center space-x-4 mb-3">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    <a href="{{ route('books.show', $review->book) }}" class="hover:text-indigo-600 transition-colors">
                                                        {{ $review->book->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-gray-600">
                                                    by <span class="font-medium">{{ $review->user->name }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Rating -->
                                        <div class="flex items-center mb-2">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star text-yellow-400"></i>
                                                    @else
                                                        <i class="far fa-star text-gray-300"></i>
                                                    @endif
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600">
                                                    {{ $review->rating }}/5
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Comment -->
                                        @if($review->comment)
                                            <div class="bg-gray-50 p-3 rounded-md mb-3">
                                                <p class="text-gray-700">{{ $review->comment }}</p>
                                            </div>
                                        @endif

                                        <!-- Date -->
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $review->created_at->format('M d, Y \a\t h:i A') }}
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('admin.reviews.show', $review) }}" 
                                           class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" 
                                              class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this review?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors text-sm">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $reviews->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-star text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews found</h3>
                        <p class="text-gray-500">
                            @if(request()->hasAny(['book_title', 'rating', 'sort']))
                                Try adjusting your filters to see more results.
                            @else
                                There are no reviews in the system yet.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
