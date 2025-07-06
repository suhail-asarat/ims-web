<x-auth-layout>
    <x-slot:heading>
        Shopping Cart
    </x-slot:heading>

    <div class="max-w-4xl mx-auto">
        <!-- Success/Info Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Cart Header -->
                <div class="bg-blue-600 text-white px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Your Cart ({{ $cartCount }} items)</h2>
                        <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Are you sure you want to clear your entire cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm transition">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <div class="p-6 flex items-center space-x-6">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            @if($item->book->book_cover_link)
                                <img src="{{ $item->book->book_cover_link }}" alt="{{ $item->book->book_name }}" class="w-20 h-28 object-cover rounded">
                            @else
                                <div class="w-20 h-28 bg-blue-100 rounded flex items-center justify-center">
                                    <span class="text-blue-700 text-xs text-center p-1">{{ $item->book->book_name }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->book->book_name }}</h3>
                            <p class="text-gray-600">by {{ $item->book->book_author }}</p>
                            <p class="text-gray-500 text-sm">{{ $item->book->book_genre }}</p>
                            <p class="text-blue-600 font-semibold mt-1">৳{{ number_format($item->price, 2) }} each</p>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-3">
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <label for="quantity_{{ $item->id }}" class="text-sm font-medium text-gray-700">Qty:</label>
                                <input type="number"
                                       name="quantity"
                                       id="quantity_{{ $item->id }}"
                                       value="{{ $item->quantity }}"
                                       min="1"
                                       max="10"
                                       class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                    Update
                                </button>
                            </form>
                        </div>

                        <!-- Item Total & Remove -->
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-900">৳{{ number_format($item->total, 2) }}</p>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm transition">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold text-gray-900">Total: ৳{{ number_format($cartTotal, 2) }}</p>
                            <p class="text-sm text-gray-600">{{ $cartCount }} item(s) in cart</p>
                        </div>
                        <div class="space-x-4">
                            <a href="{{ url('/books') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition">
                                Continue Shopping
                            </a>
                            <button class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                Proceed to Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m7 4v6m0 0l-3-3m3 3l3-3" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Cart is Empty</h2>
                <p class="text-gray-600 mb-6">Looks like you haven't added any books to your cart yet.</p>
                <a href="{{ url('/books') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</x-auth-layout>
