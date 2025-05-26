<x-layout>
    <x-slot:heading>
        {{ $book->book_name }}
    </x-slot:heading>

    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 flex flex-col md:flex-row gap-8">
        <div class="flex-shrink-0">
            <img src="{{ $book->book_cover_link }}" alt="{{ $book->book_name }}" class="rounded w-48 h-64 object-cover">
        </div>
        <div class="flex-1 flex flex-col">
            <h2 class="text-2xl font-bold mb-2">{{ $book->book_name }}</h2>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Author:</span> {{ $book->book_author }}</p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Genre:</span> {{ $book->book_genre ?? $book->book_category }}</p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Price:</span> <span class="text-blue-700 font-semibold">৳ {{ $book->book_price }}</span></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Pages:</span> {{ $book->book_pages }}</p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">ISBN-10:</span> {{ $book->book_isbn_10 }}</p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">ISBN-13:</span> {{ $book->book_isbn_13 }}</p>
            <p class="text-gray-700 mb-4"><span class="font-semibold">Published:</span> {{ $book->book_publication_date }}</p>
            <div class="mt-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
            </div>
        </div>
    </div>
</x-layout>
