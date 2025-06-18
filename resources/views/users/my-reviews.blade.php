@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto" >
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-star text-yellow-400 mr-2"></i> My Reviews
            </h1>
            @if($reviews->count())
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 rounded-lg p-6 flex flex-col sm:flex-row gap-6 items-start shadow hover:bg-gray-100 transition">
                            <div class="flex-shrink-0 w-20 h-28 rounded-lg overflow-hidden bg-gray-200 flex items-center justify-center">
                                @if($review->book->cover_image)
                                    <img src="{{ asset('storage/cover/' . $review->book->cover_image) }}" alt="{{ $review->book->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-book text-3xl text-indigo-300"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <a href="{{ route('books.show', $review->book) }}" class="text-lg font-semibold text-indigo-700 hover:underline">{{ $review->book->title }}</a>
                                    <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                                <div class="text-gray-700">{{ $review->comment }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <i class="fas fa-star text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">You haven't written any reviews yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
