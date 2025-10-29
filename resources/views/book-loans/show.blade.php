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
                                @if ($bookLoan->book->cover_image)
                                    <img src="{{ asset('images/cover/' . $bookLoan->book->cover_image) }}"
                                        alt="{{ $bookLoan->book->title }}" class="w-full h-full object-cover">
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
                                    @if ($bookLoan->loan_date)
                                        {{ $bookLoan->loan_date->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Expected Return Date</p>
                                <div class="text-sm text-gray-900">
                                    @if ($bookLoan->return_date)
                                        {{ $bookLoan->return_date->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $bookLoan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $bookLoan->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $bookLoan->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $bookLoan->status === 'returned' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ ucfirst($bookLoan->status) }}
                                </span>
                            </div>
                            @if ($bookLoan->returned_at)
                                <div>
                                    <p class="text-sm text-gray-500">Actual Return Date</p>
                                    <p class="text-gray-900">{{ $bookLoan->returned_at->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>

                        @if ($bookLoan->notes)
                            <div class="mt-6">
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="text-gray-900">{{ $bookLoan->notes }}</p>
                            </div>
                        @endif

                        @if ($bookLoan->status === 'approved' && !$bookLoan->returned_at)
                            <div class="mt-6">
                                <button type="button"
                                    onclick="openReviewModal({{ $bookLoan->id }}, '{{ $bookLoan->book->title }}')"
                                    class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Mark as Returned
                                </button>
                            </div>
                        @elseif($bookLoan->status === 'returned' || $bookLoan->status === 'return_pending')
                            <div class="mt-6">
                                <button type="button"
                                    onclick="openReviewModal({{ $bookLoan->id }}, '{{ $bookLoan->book->title }}')"
                                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    <i class="fas fa-star mr-2"></i>Add Review
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('book-loans.index') }}"
                        class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Back to Loans
                    </a>
                    <a href="{{ route('books.show', $bookLoan->book) }}"
                        class="flex-1 text-center px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        View Book Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Rate This Book</h3>
                    <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Book Title -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600">You are about to return:</p>
                    <p class="font-semibold text-gray-900" id="modalBookTitle"></p>
                </div>

                <!-- Review Form -->
                <form id="reviewForm" method="POST">
                    @csrf
                    <input type="hidden" id="bookLoanId" name="book_loan_id">

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center space-x-1" id="ratingStars">
                            <i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                data-rating="1"></i>
                            <i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                data-rating="2"></i>
                            <i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                data-rating="3"></i>
                            <i class="fas fa-star text-2xl text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                data-rating="4"></i>
                            <i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                data-rating="5"></i>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <p class="text-xs text-gray-500 mt-1">Click on the stars to rate</p>
                    </div>

                    <!-- Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment
                            (Optional)</label>
                        <textarea id="comment" name="comment" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                            placeholder="Share your thoughts about this book..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeReviewModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                            Cancel
                        </button>
                        <button type="submit" id="submitReviewBtn"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                            Submit Review & Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedRating = 0;

        function openReviewModal(bookLoanId, bookTitle) {
            document.getElementById('modalBookTitle').textContent = bookTitle;
            document.getElementById('bookLoanId').value = bookLoanId;
            document.getElementById('reviewModal').classList.remove('hidden');

            // Reset form
            selectedRating = 0;
            document.getElementById('rating').value = 0;
            document.getElementById('comment').value = '';
            updateStars(0);
            updateSubmitButton();

            // Check if this is a return action or just adding review
            const buttonText = event.target.textContent.trim();
            const isReturnAction = buttonText === 'Mark as Returned';

            // Store the action type for form submission
            document.getElementById('reviewForm').setAttribute('data-action', isReturnAction ? 'return' : 'review');

            // Update modal title and button text based on action
            const modalTitle = document.querySelector('#reviewModal h3');
            const submitBtn = document.getElementById('submitReviewBtn');

            if (isReturnAction) {
                modalTitle.textContent = 'Rate This Book';
                submitBtn.textContent = 'Submit Review & Return';
            } else {
                modalTitle.textContent = 'Add Your Review';
                submitBtn.textContent = 'Submit Review';
            }
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        function updateStars(rating) {
            const stars = document.querySelectorAll('#ratingStars i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitReviewBtn');
            if (selectedRating > 0) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Review & Return';
            } else {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Please select a rating';
            }
        }

        // Star click handlers
        document.querySelectorAll('#ratingStars i').forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.getAttribute('data-rating'));
                document.getElementById('rating').value = selectedRating;
                updateStars(selectedRating);
                updateSubmitButton();
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStars(rating);
            });
        });

        document.getElementById('ratingStars').addEventListener('mouseleave', function() {
            updateStars(selectedRating);
        });

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedRating === 0) {
                alert('Please select a rating before submitting.');
                return;
            }

            const formData = new FormData(this);
            const bookLoanId = formData.get('book_loan_id');
            const action = this.getAttribute('data-action');

            // Submit the review first
            fetch('{{ route('reviews.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (action === 'return') {
                            // Submit the return request only if this is a return action
                            const returnFormData = new FormData();
                            returnFormData.append('_token', document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'));

                            fetch(`/book-loans/${bookLoanId}/return`, {
                                    method: 'POST',
                                    body: returnFormData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        closeReviewModal();
                                        // Show success message and reload
                                        alert('Review submitted and return request sent successfully!');
                                        window.location.reload();
                                    } else {
                                        throw new Error('Failed to submit return request');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert(
                                        'Review submitted, but there was an error processing your return request. Please try again.'
                                        );
                                });
                        } else {
                            // Just review submission
                            closeReviewModal();
                            alert('Review submitted successfully!');
                            window.location.reload();
                        }
                    } else {
                        throw new Error(data.message || 'Failed to submit review');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error submitting your review. Please try again.');
                });
        });

        // Close modal when clicking outside
        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });
    </script>
@endpush
