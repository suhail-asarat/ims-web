<x-layout>
    <x-slot:heading>
        Search Results
        @if($searchParams['query'])
            for "{{ $searchParams['query'] }}"
        @endif
    </x-slot:heading>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ url('/search') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Query -->
                <div>
                    <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Search Books</label>
                    <input type="text" name="q" id="q" value="{{ $searchParams['query'] ?? '' }}"
                           placeholder="Book title or author..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Author Filter -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" name="author" id="author" value="{{ $searchParams['author'] ?? '' }}"
                           placeholder="Author name..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Genre Filter -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select name="genre" id="genre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Genres</option>
                        @foreach(\App\Models\Book::genres() as $genre)
                            <option value="{{ $genre }}" {{ ($searchParams['genre'] ?? '') === $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Options -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" id="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="name" {{ ($searchParams['sort'] ?? 'name') === 'name' ? 'selected' : '' }}>Book Name</option>
                        <option value="author" {{ ($searchParams['sort'] ?? '') === 'author' ? 'selected' : '' }}>Author</option>
                        <option value="price_low" {{ ($searchParams['sort'] ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ ($searchParams['sort'] ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Search
                </button>
                <a href="{{ url('/search') }}" class="text-gray-500 hover:text-gray-700">Clear All</a>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if($totalResults > 0)
        <p class="text-gray-600 mb-4">Found {{ $totalResults }} {{ $totalResults === 1 ? 'book' : 'books' }}</p>
    @endif

    <!-- Search Results -->
    @if($books->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div class="relative group bg-white rounded-lg shadow overflow-hidden flex flex-col items-center justify-center h-64">
                @if($book->book_cover_link)
                    <img src="{{ $book->book_cover_link }}" alt="{{ $book->book_name }}" class="object-cover w-full h-full">
                @else
                    <div class="flex items-center justify-center w-full h-full bg-blue-100">
                        <span class="text-blue-700 text-center font-semibold p-4">{{ $book->book_name }}</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ url('/book/'.$book->book_id) }}" class="mb-2 bg-white text-blue-700 px-4 py-2 rounded shadow hover:bg-blue-700 hover:text-white font-semibold transition">View</a>
                    <form action="{{ url('/cart/add/'.$book->book_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-800 font-semibold transition">Add to Cart</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No books found</h3>
            <p class="text-gray-500">Try adjusting your search criteria or browse all books.</p>
            <a href="{{ url('/books') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Browse All Books
            </a>
        </div>
    @endif
</x-layout>
