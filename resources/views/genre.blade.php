<x-layout>
    <x-slot:heading>
        {{ $genre }} Books
    </x-slot:heading>

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No books found</h3>
            <p class="text-gray-500">We don't have any books in the "{{ $genre }}" genre yet.</p>
            <a href="{{ url('/books') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Browse All Books
            </a>
        </div>
    @endif
</x-layout>
