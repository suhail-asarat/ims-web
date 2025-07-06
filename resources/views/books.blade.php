<x-auth-layout>
    <x-slot:heading>
        Books
    </x-slot:heading>

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
</x-auth-layout>
