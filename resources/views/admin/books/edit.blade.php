<x-admin-layout>
    <x-slot:heading>
        Edit Book
    </x-slot:heading>

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Edit Book</h2>
        <p class="text-gray-600">Update book information</p>
    </div>

    <!-- Book Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.books.update', $book->book_id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Name -->
                <div>
                    <label for="book_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Book Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="book_name" id="book_name" value="{{ old('book_name', $book->book_name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_name') border-red-500 @enderror"
                           placeholder="Enter book title">
                    @error('book_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author -->
                <div>
                    <label for="book_author" class="block text-sm font-medium text-gray-700 mb-2">
                        Author <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="book_author" id="book_author" value="{{ old('book_author', $book->book_author) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_author') border-red-500 @enderror"
                           placeholder="Enter author name">
                    @error('book_author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publisher -->
                <div>
                    <label for="book_publisher" class="block text-sm font-medium text-gray-700 mb-2">
                        Publisher <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="book_publisher" id="book_publisher" value="{{ old('book_publisher', $book->book_publisher) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_publisher') border-red-500 @enderror"
                           placeholder="Enter publisher name">
                    @error('book_publisher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="book_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price (৳) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="book_price" id="book_price" step="0.01" min="0" value="{{ old('book_price', $book->book_price) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_price') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('book_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Genre -->
                <div>
                    <label for="book_genre" class="block text-sm font-medium text-gray-700 mb-2">
                        Genre <span class="text-red-500">*</span>
                    </label>
                    <select name="book_genre" id="book_genre" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_genre') border-red-500 @enderror">
                        <option value="">Select a genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ (old('book_genre', $book->book_genre) === $genre) ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_genre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pages -->
                <div>
                    <label for="book_pages" class="block text-sm font-medium text-gray-700 mb-2">
                        Number of Pages
                    </label>
                    <input type="number" name="book_pages" id="book_pages" min="1" value="{{ old('book_pages', $book->book_pages) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_pages') border-red-500 @enderror"
                           placeholder="e.g., 250">
                    @error('book_pages')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cover Image URL -->
            <div>
                <label for="book_cover_link" class="block text-sm font-medium text-gray-700 mb-2">
                    Cover Image URL
                </label>
                <input type="url" name="book_cover_link" id="book_cover_link" value="{{ old('book_cover_link', $book->book_cover_link) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_cover_link') border-red-500 @enderror"
                       placeholder="https://example.com/book-cover.jpg">
                @error('book_cover_link')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($book->book_cover_link)
                    <div class="mt-2 flex items-center">
                        <img src="{{ $book->book_cover_link }}" alt="Current cover" class="w-16 h-20 object-cover rounded mr-2">
                        <span class="text-sm text-gray-500">Current cover image</span>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ISBN 10 -->
                <div>
                    <label for="book_isbn_10" class="block text-sm font-medium text-gray-700 mb-2">
                        ISBN-10
                    </label>
                    <input type="text" name="book_isbn_10" id="book_isbn_10" value="{{ old('book_isbn_10', $book->book_isbn_10) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_isbn_10') border-red-500 @enderror"
                           placeholder="e.g., 0123456789">
                    @error('book_isbn_10')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN 13 -->
                <div>
                    <label for="book_isbn_13" class="block text-sm font-medium text-gray-700 mb-2">
                        ISBN-13
                    </label>
                    <input type="text" name="book_isbn_13" id="book_isbn_13" value="{{ old('book_isbn_13', $book->book_isbn_13) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_isbn_13') border-red-500 @enderror"
                           placeholder="e.g., 978-0123456789">
                    @error('book_isbn_13')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Publication Date -->
            <div>
                <label for="book_publication_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Publication Date
                </label>
                <input type="date" name="book_publication_date" id="book_publication_date" value="{{ old('book_publication_date', $book->book_publication_date) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('book_publication_date') border-red-500 @enderror">
                @error('book_publication_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.books.index') }}"
                   class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
