<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($title ?? 'Bookshop'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Customer Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 flex items-center justify-between">
            <!-- Left: Logo -->
            <a href="/" class="text-4xl text-blue-700 mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block align-middle" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M2 6.5A2.5 2.5 0 0 1 4.5 4H12v16H4.5A2.5 2.5 0 0 1 2 17.5v-11z" fill="#3B82F6" stroke="#1E40AF" stroke-width="1.5"/>
                    <path d="M22 6.5A2.5 2.5 0 0 0 19.5 4H12v16h7.5a2.5 2.5 0 0 0 2.5-2.5v-11z" fill="#fff" stroke="#1E40AF" stroke-width="1.5"/>
                    <path d="M12 4v16" stroke="#1E40AF" stroke-width="1.5"/>
                </svg>
            </a>

            <!-- Center: Customer Navigation -->
            <?php echo $__env->make('components.nav-link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Right: Cart and Customer User Menu -->
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard('customer')->check()): ?>
                    <?php
                        $cartCount = \App\Models\Cart::getCartCount(Auth::guard('customer')->user()->id);
                    ?>
                    <a href="<?php echo e(route('cart.index')); ?>"
                              class="relative px-4 py-2 rounded-full font-medium transition
                                     text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                   <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                                   <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                               </svg>
                               <span>Cart</span>
                               <?php if($cartCount > 0): ?>
                                   <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                       <?php echo e($cartCount > 99 ? '99+' : $cartCount); ?>

                                   </span>
                               <?php endif; ?>
                           </a>
                <?php else: ?>
                    <a href="<?php echo e(route('cart.index')); ?>"
                              class="relative px-4 py-2 rounded-full font-medium transition
                                     text-gray-700 hover:bg-blue-50 hover:text-blue-700 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                   <circle cx="9" cy="21" r="1" fill="#1E40AF"/>
                                   <circle cx="19" cy="21" r="1" fill="#1E40AF"/>
                               </svg>
                               <span>Cart</span>
                           </a>
                <?php endif; ?>

                <?php if(auth()->guard('customer')->check()): ?>
                    <!-- Customer Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center px-4 py-2 rounded-full font-medium transition text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span><?php echo e(Auth::guard('customer')->user()->name); ?></span>
                            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Customer Dropdown Menu Items -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="<?php echo e(route('customer.dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Edit Profile
                            </a>
                            <a href="<?php echo e(route('customer.orders')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                My Orders
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest User - Sign In Link -->
                    <a href="<?php echo e(route('login')); ?>"
                       class="relative px-4 py-2 rounded-full font-medium transition
                              text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                        Sign In
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow max-w-7xl mx-auto py-8 px-4 w-full">
        <?php if(isset($heading)): ?>
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900"><?php echo e($heading); ?></h1>
            </div>
        <?php endif; ?>

        <?php echo e($slot); ?>

    </main>

    <!-- Customer Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">&copy; <?php echo e(date('Y')); ?> Bookshop IMS. All rights reserved.</p>
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
<?php /**PATH D:\Projects\ims-web\resources\views/components/auth-layout.blade.php ENDPATH**/ ?>