@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Books</h2>
                    <p class="text-sm text-gray-600 mt-1">Discover and borrow books from our collection</p>
                </div>
                @if (auth()->user()->role === 'admin')
                    <!-- Trigger button -->
                    <button type="button" data-modal-target="addMultipleBooksModal" data-modal-toggle="addMultipleBooksModal"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition">
                        <i class="fas fa-plus mr-2"></i> Add Multiple Books
                    </button>
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



            <!-- Modal Add Multiple Books -->
            <div id="addMultipleBooksModal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-4xl p-6 animate-fade-in-up">
                    <div class="flex justify-between items-center border-b pb-3 mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-layer-group text-indigo-600"></i> Add Multiple Books
                        </h3>
                        <button type="button" data-modal-hide="addMultipleBooksModal"
                            class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form action="{{ route('books.storeMultiple') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <div id="books-container" class="space-y-6">
                            <div class="book-item bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="books[0][title]"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Author</label>
                                        <input type="text" name="books[0][author]"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                            required>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="books[0][description]" rows="2"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="books[0][quantity]" min="0" value="0"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Published Date</label>
                                        <input type="date" name="books[0][published_date]"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                                        <input type="file" name="books[0][cover_image]" accept="image/*"
                                            class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                        <img class="img-preview mt-2 rounded-lg shadow-md hidden"
                                            style="max-width: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="button" id="addBookBtn"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                                <i class="fas fa-plus mr-2"></i> Add Another Book
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition">
                                <i class="fas fa-save mr-2"></i> Save All
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                let bookIndex = 1;

                document.getElementById('addBookBtn').addEventListener('click', () => {
                    const container = document.getElementById('books-container');
                    const firstBook = container.firstElementChild.cloneNode(true);

                    firstBook.querySelectorAll('input, textarea').forEach((el) => {
                        const name = el.getAttribute('name');
                        el.setAttribute('name', name.replace(/\d+/, bookIndex));
                        el.value = '';
                        if (el.type === 'file') el.value = null;
                    });

                    firstBook.querySelector('.img-preview').classList.add('hidden');
                    container.appendChild(firstBook);
                    bookIndex++;
                });

                // Preview Gambar
                document.addEventListener('change', function(e) {
                    if (e.target.matches('input[type="file"][name*="[cover_image]"]')) {
                        const file = e.target.files[0];
                        const preview = e.target.closest('.book-item').querySelector('.img-preview');
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = ev => {
                                preview.src = ev.target.result;
                                preview.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.classList.add('hidden');
                        }
                    }
                });
            </script>
        @endsection
