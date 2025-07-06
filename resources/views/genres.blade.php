@php
    use App\Models\Book;
    $genres = Book::genres();
@endphp

<x-auth-layout>
    <x-slot:heading>
        Genres
    </x-slot:heading>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @foreach($genres as $genre)
            <a href="{{ url('/genre/' . urlencode($genre)) }}" class="relative group bg-white rounded-lg shadow p-4 flex flex-col items-center hover:shadow-lg transition-shadow">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-2 group-hover:bg-blue-200 transition-colors">
                    <span class="text-2xl text-blue-700">📚</span>
                </div>
                <span class="font-medium text-gray-700 text-center group-hover:text-blue-700 transition-colors">{{ $genre }}</span>
                <div class="absolute inset-0 bg-blue-600 bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200"></div>
            </a>
        @endforeach
    </div>
</x-auth-layout>
