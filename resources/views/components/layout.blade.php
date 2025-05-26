<!doctype html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'IMS' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-gray-100">
<div class="min-h-full">
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
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
