<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Bookshop IMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-gradient-to-br from-gray-100 to-gray-200">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Admin Access</h2>
                    <p class="text-gray-600 mt-2">Please sign in to access the admin panel</p>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.authenticate') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('email') border-red-500 @enderror"
                               placeholder="Enter your admin email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('password') border-red-500 @enderror"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Sign in to Admin Panel
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-gray-600 hover:text-red-600 transition">
                        ← Back to Main Site
                    </a>
                </div>
            </div>

            <!-- Demo Credentials Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="text-center mb-4">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">🔑 Demo Credentials</h3>
                    <p class="text-sm text-blue-700">Use these credentials to access the admin panel for demo purposes</p>
                </div>

                <div class="space-y-4">
                    <!-- Super Admin -->
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Super Admin
                            </span>
                            <button onclick="copyCredentials('superadmin@bookshop.com', 'admin123')"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                Click to Copy
                            </button>
                        </div>
                        <div class="text-sm space-y-1">
                            <div><strong>Email:</strong> <span class="font-mono text-gray-700">superadmin@bookshop.com</span></div>
                            <div><strong>Password:</strong> <span class="font-mono text-gray-700">admin123</span></div>
                        </div>
                    </div>

                    <!-- Admin -->
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Admin
                            </span>
                            <button onclick="copyCredentials('admin@bookshop.com', 'admin123')"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                Click to Copy
                            </button>
                        </div>
                        <div class="text-sm space-y-1">
                            <div><strong>Email:</strong> <span class="font-mono text-gray-700">admin@bookshop.com</span></div>
                            <div><strong>Password:</strong> <span class="font-mono text-gray-700">admin123</span></div>
                        </div>
                    </div>

                    <!-- Moderator -->
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Moderator
                            </span>
                            <button onclick="copyCredentials('moderator@bookshop.com', 'admin123')"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                Click to Copy
                            </button>
                        </div>
                        <div class="text-sm space-y-1">
                            <div><strong>Email:</strong> <span class="font-mono text-gray-700">moderator@bookshop.com</span></div>
                            <div><strong>Password:</strong> <span class="font-mono text-gray-700">admin123</span></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-xs text-blue-600">
                        💡 Click "Click to Copy" to automatically fill the login form
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyCredentials(email, password) {
            // Fill the form fields
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Add visual feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('text-green-600');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('text-green-600');
            }, 1500);
        }
    </script>
</body>
</html>
