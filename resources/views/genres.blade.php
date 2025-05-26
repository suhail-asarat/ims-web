@php
    use App\Models\Book;
    $genres = Book::genres();
@endphp

<x-layout>
    <x-slot:heading>
        Genres
    </x-slot:heading>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @foreach($genres as $genre)
            <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                    <span class="text-2xl text-blue-700">📚</span>
                </div>
                <span class="font-medium text-gray-700 text-center">{{ $genre }}</span>
            </div>
        @endforeach
    </div>
</x-layout>
