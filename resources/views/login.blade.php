<x-layout>
    <div class="max-w-md mx-auto">
        <!-- Success Message -->
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

        <!-- Login Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                <p class="text-gray-600">Sign in to your account</p>
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

            <!-- Demo Credentials Display -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-blue-800">Demo Credentials</h3>
                    <button type="button" id="use-demo-btn" class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                        Use Demo
                    </button>
                </div>
                <div class="text-sm text-blue-700">
                    <p><strong>Email:</strong> test@email.tld</p>
                    <p><strong>Password:</strong> test1234</p>
                </div>
            </div>

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf

                <!-- Hidden field to track user type -->
                <input type="hidden" name="user_type" id="user_type" value="customer">

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
                           placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-semibold transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Sign In
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">Create Account</a>
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

            customerTab.addEventListener('click', function() {
                // Switch to customer
                customerTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                customerTab.classList.remove('text-gray-600');
                authorTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                authorTab.classList.add('text-gray-600');
                userTypeInput.value = 'customer';
            });

            authorTab.addEventListener('click', function() {
                // Switch to author
                authorTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                authorTab.classList.remove('text-gray-600');
                customerTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                customerTab.classList.add('text-gray-600');
                userTypeInput.value = 'author';
            });

            // Demo button functionality
            document.getElementById('use-demo-btn').addEventListener('click', function() {
                // Set demo credentials
                document.getElementById('email').value = 'test@email.tld';
                document.getElementById('password').value = 'test1234';
            });
        });
    </script>
</x-layout>
