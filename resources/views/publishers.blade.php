<x-auth-layout>
    <x-slot:heading>
        Publishers
    </x-slot:heading>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @foreach($publishers as $publisher)
            <a href="{{ url('/publisher/' . urlencode($publisher)) }}" class="relative group bg-white rounded-lg shadow p-4 flex flex-col items-center hover:shadow-lg transition-shadow">
                <div class="bg-gray-200 rounded w-16 h-16 flex items-center justify-center mb-2 group-hover:bg-gray-300 transition-colors">
                    <span class="text-lg text-gray-700 font-bold">{{ substr($publisher, 0, 1) }}</span>
                </div>
                <span class="font-medium text-gray-700 text-center group-hover:text-blue-700 transition-colors">{{ $publisher }}</span>
                <div class="absolute inset-0 bg-blue-600 bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200"></div>
            </a>
        @endforeach
    </div>
</x-auth-layout>
