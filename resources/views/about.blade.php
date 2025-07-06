<x-auth-layout>
    <x-slot:heading>
        About Us
    </x-slot:heading>

    <div class="max-w-4xl mx-auto">
        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M2 6.5A2.5 2.5 0 0 1 4.5 4H12v16H4.5A2.5 2.5 0 0 1 2 17.5v-11z" fill="#3B82F6" stroke="#1E40AF" stroke-width="1.5"/>
                        <path d="M22 6.5A2.5 2.5 0 0 0 19.5 4H12v16h7.5a2.5 2.5 0 0 0 2.5-2.5v-11z" fill="#fff" stroke="#1E40AF" stroke-width="1.5"/>
                        <path d="M12 4v16" stroke="#1E40AF" stroke-width="1.5"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Our Bookshop</h2>
                <p class="text-xl text-gray-600">Your gateway to endless knowledge and imagination</p>
            </div>
        </div>

        <!-- Our Story Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Story</h3>
            <div class="prose prose-lg text-gray-700">
                <p class="mb-4">
                    Founded with a passion for books and learning, our bookshop has been serving readers and book enthusiasts for years. We believe that books have the power to transform lives, spark imagination, and build bridges between cultures and communities.
                </p>
                <p class="mb-4">
                    Our carefully curated collection spans across multiple genres - from timeless classics to contemporary bestsellers, from academic texts to leisure reading. Whether you're looking for the latest novel, a comprehensive textbook, or a rare find, we're here to help you discover your next great read.
                </p>
                <p>
                    We pride ourselves on creating a welcoming environment where every reader feels at home, regardless of their reading preferences or experience level.
                </p>
            </div>
        </div>

        <!-- What We Offer Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">What We Offer</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Diverse Collection</h4>
                        <p class="text-gray-600">From novels and science books to self-help and programming guides, we have something for every reader.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Fast Service</h4>
                        <p class="text-gray-600">Quick and efficient service to get your favorite books to you as soon as possible.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Quality Assurance</h4>
                        <p class="text-gray-600">We ensure all our books are in excellent condition and from reputable publishers.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Customer Support</h4>
                        <p class="text-gray-600">Our friendly team is always ready to help you find the perfect book or answer any questions.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Mission Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Mission</h3>
            <div class="bg-blue-50 rounded-lg p-6">
                <p class="text-lg text-gray-700 italic text-center">
                    "To make quality books accessible to everyone, fostering a love for reading and learning that enriches lives and builds stronger communities."
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">By the Numbers</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="p-4">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\Book::count() }}+</div>
                    <p class="text-gray-600">Books Available</p>
                </div>
                <div class="p-4">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ count(\App\Models\Book::genres()) }}+</div>
                    <p class="text-gray-600">Genres Covered</p>
                </div>
                <div class="p-4">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ count(\App\Models\Book::authors()) }}+</div>
                    <p class="text-gray-600">Authors Featured</p>
                </div>
            </div>
        </div>

        <!-- Contact CTA Section -->
        <div class="bg-blue-600 rounded-lg shadow-lg p-8 text-center text-white">
            <h3 class="text-2xl font-bold mb-4">Ready to Start Your Reading Journey?</h3>
            <p class="text-blue-100 mb-6">Browse our collection or get in touch with us for personalized recommendations.</p>
            <div class="space-x-4">
                <a href="{{ url('/books') }}" class="inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Browse Books
                </a>
                <a href="{{ url('/contact') }}" class="inline-block border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</x-auth-layout>
