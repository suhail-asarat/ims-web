<x-layout>
    <x-slot:heading>
        Books
    </x-slot:heading>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($books as $book)
            <a href="{{ url('/book/'.$book->book_id) }}" class="bg-white rounded-lg shadow p-4 flex flex-col hover:shadow-lg transition">
                <img src="{{ $book->book_cover_link }}" alt="{{ $book->book_name }}" class="mb-3 rounded h-48 object-cover">
                <h3 class="font-bold text-lg mb-1">{{ $book->book_name }}</h3>
                <p class="text-gray-600 mb-2">{{ $book->book_author }}</p>
                <span class="text-blue-700 font-semibold mb-2">৳ {{ $book->book_price }}</span>
                <span class="text-xs text-gray-400 mb-2">{{ $book->book_genre }}</span>
                <button class="mt-auto bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">View Details</button>
            </a>
        @endforeach
    </div>
</x-layout>
