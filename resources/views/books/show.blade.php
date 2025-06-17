@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('books.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Books
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Book Cover -->
            <div class="lg:w-1/3">
                <div class="aspect-w-2 aspect-h-3 rounded-lg overflow-hidden shadow-lg relative group">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/cover/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <i class="fas fa-book text-6xl text-indigo-400"></i>
                        </div>
                    @endif
                    @if($book->quantity > 0)
                        <div class="absolute top-4 right-4 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            Available
                        </div>
                    @else
                        <div class="absolute top-4 right-4 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                            Unavailable
                        </div>
                    @endif
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:w-2/3">
                <div class="flex flex-col h-full">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mb-6 flex items-center">
                            <i class="fas fa-user-edit mr-2 text-indigo-500"></i>
                            {{ $book->author }}
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">ISBN</p>
                                <p class="text-gray-900 font-medium">{{ $book->isbn }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Published Year</p>
                                <p class="text-gray-900 font-medium">{{ $book->published_year }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Available Copies</p>
                                <p class="text-gray-900 font-medium flex items-center">
                                    <i class="fas fa-book-open mr-2 text-indigo-500"></i>
                                    {{ $book->quantity }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Rating</p>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($book->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-gray-900 font-medium">{{ number_format($book->average_rating, 1) }}</span>
                                    <span class="ml-1 text-gray-500">({{ $book->ratings_count }} ratings)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-align-left mr-2 text-indigo-500"></i>
                                Description
                            </h2>
                            <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @if($book->quantity > 0 && auth()->check())
                            <a href="{{ route('book-loans.create', $book) }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-book-reader mr-2"></i>
                                Ajukan Pinjaman
                            </a>
                        @endif
                        <a href="{{ route('books.index') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Books
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-comments mr-2 text-indigo-500"></i>
                Comments
            </h2>
            
            @auth
                @if($hasBorrowed)
                    <form action="{{ route('comments.store', $book) }}" method="POST" class="mb-8 bg-gray-50 p-6 rounded-lg">
                        @csrf
                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors duration-200" onclick="setRating({{ $i }})">
                                        ★
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" value="0">
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                            <textarea name="comment" id="comment" rows="3" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="Share your thoughts about this book..."></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Review
                        </button>
                    </form>
                @endif
            @endauth

            <div class="space-y-6">
                @forelse($book->comments as $comment)
                    <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold mr-3">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $comment->user->name }}</div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600">{{ $comment->comment }}</p>
                        @if(auth()->check() && auth()->id() === $comment->user_id)
                            <div class="mt-4 flex gap-4">
                                <button onclick="editComment({{ $comment->id }})" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </button>
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center text-sm text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this comment?')">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <i class="fas fa-comments text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No comments yet.</p>
                        @auth
                            @if($hasBorrowed)
                                <p class="text-gray-400 text-sm mt-2">Be the first to share your thoughts!</p>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setRating(rating) {
    document.getElementById('rating').value = rating;
    const stars = document.querySelectorAll('button[type="button"]');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < rating);
        star.classList.toggle('text-gray-300', index >= rating);
    });
}

function editComment(commentId) {
    // Implement edit functionality
}
</script>
@endpush
@endsection 