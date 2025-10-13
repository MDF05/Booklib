@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Review Details</h1>
                        <p class="text-gray-600 mt-1">Detailed view of user review</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.reviews.index') }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
                        </a>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" 
                              class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                <i class="fas fa-trash mr-2"></i>Delete Review
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <!-- Book Information -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Book Information</h2>
                        <div class="flex items-start space-x-4">
                            @if($review->book->cover_image)
                                <img src="{{ asset('storage/' . $review->book->cover_image) }}" 
                                     alt="{{ $review->book->title }}" 
                                     class="w-20 h-28 object-cover rounded-md shadow-sm">
                            @else
                                <div class="w-20 h-28 bg-gray-200 rounded-md flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('books.show', $review->book) }}" class="hover:text-indigo-600 transition-colors">
                                        {{ $review->book->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-1">by {{ $review->book->author }}</p>
                                <p class="text-sm text-gray-500">
                                    ISBN: {{ $review->book->isbn ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Published: {{ $review->book->published_year ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Reviewer Information</h2>
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $review->user->name }}</h3>
                                <p class="text-gray-600">{{ $review->user->email }}</p>
                                <p class="text-sm text-gray-500">
                                    Member since {{ $review->user->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Rating</h2>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-yellow-400 text-2xl"></i>
                                @else
                                    <i class="far fa-star text-gray-300 text-2xl"></i>
                                @endif
                            @endfor
                            <span class="ml-3 text-xl font-semibold text-gray-900">
                                {{ $review->rating }}/5
                            </span>
                        </div>
                    </div>

                    <!-- Comment -->
                    @if($review->comment)
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Comment</h2>
                            <div class="bg-white p-4 rounded-md border border-gray-200">
                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Review Metadata -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Review Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created</label>
                                <p class="text-gray-900">{{ $review->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="text-gray-900">{{ $review->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
