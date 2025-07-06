<x-layout>
    <div class="max-w-md mx-auto">
        <!-- Registration Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Join Us</h2>
                <p class="text-gray-600">Create your account</p>
            </div>

            <!-- User Type Toggle -->
            <div class="mb-6">
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button type="button" id="customer-tab" class="flex-1 text-center py-2 rounded-md font-medium transition bg-white text-blue-600 shadow-sm">
                        Customer
                    </button>
                    <button type="button" id="author-tab" class="flex-1 text-center py-2 rounded-md font-medium transition text-gray-600 hover:text-gray-900">
                        Author
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-6">
                @csrf

                <!-- Hidden field to track user type -->
                <input type="hidden" name="user_type" id="user_type" value="customer">

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter your full name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                           placeholder="Enter your email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                           placeholder="Enter a secure password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Confirm your password">
                </div>

                <!-- Customer-specific fields -->
                <div id="customer-fields">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone (Optional)</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your phone number">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address (Optional)</label>
                        <textarea name="address" id="address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Enter your address">{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- Author-specific fields -->
                <div id="author-fields" style="display: none;">
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio (Optional)</label>
                        <textarea name="bio" id="bio" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Tell us about yourself as an author">{{ old('bio') }}</textarea>
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website (Optional)</label>
                        <input type="url" name="website" id="website" value="{{ old('website') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://your-website.com">
                    </div>
                    <div>
                        <label for="author_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone (Optional)</label>
                        <input type="text" name="phone" id="author_phone" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your phone number">
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-semibold transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create Account
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">Sign In</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript for tab switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerTab = document.getElementById('customer-tab');
            const authorTab = document.getElementById('author-tab');
            const userTypeInput = document.getElementById('user_type');
            const customerFields = document.getElementById('customer-fields');
            const authorFields = document.getElementById('author-fields');

            customerTab.addEventListener('click', function() {
                // Switch to customer
                customerTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                customerTab.classList.remove('text-gray-600');
                authorTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                authorTab.classList.add('text-gray-600');
                userTypeInput.value = 'customer';
                customerFields.style.display = 'block';
                authorFields.style.display = 'none';
            });

            authorTab.addEventListener('click', function() {
                // Switch to author
                authorTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                authorTab.classList.remove('text-gray-600');
                customerTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                customerTab.classList.add('text-gray-600');
                userTypeInput.value = 'author';
                customerFields.style.display = 'none';
                authorFields.style.display = 'block';
            });
        });
    </script>
</x-layout>
