@php
    use App\Models\Book;
    $books = Book::limit(8)->get();
    $genres = Book::genres();
    $authors = Book::authors();
    $publishers = Book::publishers();
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Bookshop' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
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
            <!-- Right: Cart and User Menu -->
            <div class="flex items-center space-x-4">
                @auth('customer')
                    @php
                        $cartCount = \App\Models\Cart::getCartCount(Auth::guard('customer')->user()->id);
                    @endphp
                    <a href="{{ route('cart.index') }}"
                              class="relative px-4 py-2 rounded-full font-medium transition
                                     text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                   <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                                   <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                               </svg>
                               <span>Cart</span>
                               @if($cartCount > 0)
                                   <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                       {{ $cartCount > 99 ? '99+' : $cartCount }}
                                   </span>
                               @endif
                           </a>

                    <!-- Customer Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center px-4 py-2 rounded-full font-medium transition text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ Auth::guard('customer')->user()->name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Edit Profile
                            </a>
                            <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                My Orders
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @elseauth('author')
                    <a href="{{ route('cart.index') }}"
                              class="relative px-4 py-2 rounded-full font-medium transition
                                     text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                   <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                                   <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                               </svg>
                               <span>Cart</span>
                           </a>

                    <!-- Author Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center px-4 py-2 rounded-full font-medium transition text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                            </svg>
                            <span>{{ Auth::guard('author')->user()->name }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('author.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('author.manuscripts') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                My Manuscripts
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('cart.index') }}"
                              class="relative px-4 py-2 rounded-full font-medium transition
                                     text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                   <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                                   <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                               </svg>
                               <span>Cart</span>
                           </a>

                    <!-- Guest User - Sign In Link -->
                    <a href="{{ route('login') }}"
                       class="relative px-4 py-2 rounded-full font-medium transition
                              text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>
    <main class="flex-grow max-w-7xl mx-auto py-8 px-4 w-full">
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Featured Books</h2>
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
        </section>
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Genres</h2>
            <div class="overflow-x-auto">
                <div class="flex gap-4 min-w-max">
                    @foreach($genres as $genre)
                    <a href="{{ url('/genre/' . urlencode($genre)) }}" class="bg-white rounded-lg shadow p-4 flex flex-col items-center min-w-[140px] hover:shadow-lg transition-shadow">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mb-2">
                            <span class="text-2xl text-blue-700">📚</span>
                        </div>
                        <span class="font-medium text-gray-700">{{ $genre }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Popular Authors</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($authors as $author)
                <a href="{{ url('/author/' . urlencode($author)) }}" class="bg-white rounded-lg shadow p-4 flex flex-col items-center hover:shadow-lg transition-shadow group">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($author) }}&background=0D8ABC&color=fff" alt="{{ $author }}" class="rounded-full w-16 h-16 mb-2 group-hover:scale-110 transition-transform">
                    <span class="font-medium text-gray-700 text-center group-hover:text-blue-700 transition-colors">{{ $author }}</span>
                </a>
                @endforeach
            </div>
        </section>
        <section>
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Top Publishers</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @foreach($publishers as $publisher)
                <a href="{{ url('/publisher/' . urlencode($publisher)) }}" class="bg-white rounded-lg shadow p-4 flex flex-col items-center hover:shadow-lg transition-shadow group">
                    <div class="bg-gray-200 rounded w-16 h-16 flex items-center justify-center mb-2 group-hover:bg-gray-300 transition-colors">
                        <span class="text-lg text-gray-700 font-bold">{{ substr($publisher, 0, 1) }}</span>
                    </div>
                    <span class="font-medium text-gray-700 text-center group-hover:text-blue-700 transition-colors">{{ $publisher }}</span>
                </a>
                @endforeach
            </div>
        </section>
    </main>
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">&copy; {{ date('Y') }} Bookshop IMS. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="/about" class="text-gray-600 hover:text-blue-600 transition">About</a>
                    <a href="/contact" class="text-gray-600 hover:text-blue-600 transition">Contact</a>
                    <a href="/blog" class="text-gray-600 hover:text-blue-600 transition">Blog</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
