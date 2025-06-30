<x-layout>
    <x-slot:heading>
        Authors
    </x-slot:heading>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @foreach($authors as $author)
            <a href="{{ url('/author/' . urlencode($author)) }}" class="relative group bg-white rounded-lg shadow p-4 flex flex-col items-center hover:shadow-lg transition-shadow">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($author) }}&background=0D8ABC&color=fff" alt="{{ $author }}" class="rounded-full w-16 h-16 mb-2 group-hover:scale-110 transition-transform">
                <span class="font-medium text-gray-700 text-center group-hover:text-blue-700 transition-colors">{{ $author }}</span>
                <div class="absolute inset-0 bg-blue-600 bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200"></div>
            </a>
        @endforeach
    </div>
</x-layout>
