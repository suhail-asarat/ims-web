@php
    use App\Models\Book;
    $books = Book::limit(8)->get();
    $genres = Book::genres();
    $authors = Book::authors();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Bookshop' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 flex items-center justify-between">
            <!-- Left: Logo -->
            <span class="text-4xl text-blue-700 mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block align-middle" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M2 6.5A2.5 2.5 0 0 1 4.5 4H12v16H4.5A2.5 2.5 0 0 1 2 17.5v-11z" fill="#3B82F6" stroke="#1E40AF" stroke-width="1.5"/>
                    <path d="M22 6.5A2.5 2.5 0 0 0 19.5 4H12v16h7.5a2.5 2.5 0 0 0 2.5-2.5v-11z" fill="#fff" stroke="#1E40AF" stroke-width="1.5"/>
                    <path d="M12 4v16" stroke="#1E40AF" stroke-width="1.5"/>
                </svg>
            </span>
            <!-- Center: Navigation -->
            @include('components.nav-link')
            <!-- Right: Cart and Sign In -->
            <div class="flex items-center space-x-4">
                <a href="/cart"
                          class="relative px-4 py-2 rounded-full font-medium transition
                                 text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                               <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                               <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                           </svg>
                           <span>Cart</span>
                       </a>
                <a href="/login"
                   class="relative px-4 py-2 rounded-full font-medium transition
                          text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                    Sign In
                </a>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Featured Books</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                <a href="{{ url('/book/'.$book->book_id) }}" class="bg-white rounded-lg shadow p-4 flex flex-col hover:shadow-lg transition">
                    <img src="{{ $book->book_cover_link }}" alt="{{ $book->book_name }}" class="mb-3 rounded h-48 object-cover">
                    <h3 class="font-bold text-lg mb-1">{{ $book->book_name }}</h3>
                    <p class="text-gray-600 mb-2">{{ $book->book_author }}</p>
                    <span class="text-blue-700 font-semibold mb-2">৳ {{ $book->book_price }}</span>
                    <button class="mt-auto bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">View Details</button>
                </a>
                @endforeach
            </div>
        </section>
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Genres</h2>
            <div class="overflow-x-auto">
                <div class="flex gap-4 min-w-max">
                    @foreach($genres as $genre)
                    <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center min-w-[140px]">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                            <span class="text-2xl text-blue-700">📚</span>
                        </div>
                        <span class="font-medium text-gray-700">{{ $genre }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Popular Authors</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($authors as $author)
                <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($author) }}&background=0D8ABC&color=fff" alt="{{ $author }}" class="rounded-full w-16 h-16 mb-2">
                    <span class="font-medium text-gray-700 text-center">{{ $author }}</span>
                </div>
                @endforeach
            </div>
        </section>
        <section>
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Top Publishers</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach(['Prothoma','Ananya','Mawla Brothers','Agamee Prakashani','Bangla Academy','Sheba Prokashoni'] as $publisher)
                <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                    <div class="bg-gray-200 rounded w-16 h-16 flex items-center justify-center mb-2">
                        <span class="text-lg text-gray-700">{{ $publisher[0] }}</span>
                    </div>
                    <span class="font-medium text-gray-700 text-center">{{ $publisher }}</span>
                </div>
                @endforeach
            </div>
        </section>
    </main>
    <footer class="bg-white border-t mt-12 py-4 text-center text-gray-500">
        &copy; {{ date('Y') }} Bookshop IMS. All rights reserved.
    </footer>
</body>
</html>
