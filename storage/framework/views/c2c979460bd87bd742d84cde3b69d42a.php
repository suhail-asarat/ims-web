<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('heading', null, []); ?> 
        Shopping Cart
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('debug')): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                <strong>Debug Info:</strong> <?php echo e(session('debug')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        <?php if(isset($isGuest) && $isGuest): ?>
            <!-- Guest User Cart -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Please sign in to view your cart or start shopping.</p>
                <div class="space-x-4">
                    <a href="<?php echo e(route('login')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold transition duration-200">
                        Sign In
                    </a>
                    <a href="/books" class="bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700 font-semibold transition duration-200">
                        Browse Books
                    </a>
                </div>
            </div>
        <?php elseif($cartItems->count() > 0): ?>
            <!-- Cart with Items -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        Your Cart (<?php echo e($cartCount); ?> <?php echo e($cartCount == 1 ? 'item' : 'items'); ?>)
                    </h2>
                </div>

                <div class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-6 flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-24 bg-gray-200 rounded-md flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e($item->book->book_name); ?></h3>
                                <p class="text-sm text-gray-500">by <?php echo e($item->book->book_author); ?></p>
                                <p class="text-sm text-gray-500">৳<?php echo e(number_format($item->price, 2)); ?> each</p>
                            </div>

                            <div class="flex items-center space-x-2">
                                <form method="POST" action="<?php echo e(route('cart.update', $item->id)); ?>" class="flex items-center">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <label for="quantity-<?php echo e($item->id); ?>" class="sr-only">Quantity</label>
                                    <select name="quantity" id="quantity-<?php echo e($item->id); ?>"
                                            class="border border-gray-300 rounded-md px-3 py-1 text-sm"
                                            onchange="this.form.submit()">
                                        <?php for($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?php echo e($i); ?>" <?php echo e($item->quantity == $i ? 'selected' : ''); ?>>
                                                <?php echo e($i); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </div>

                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">
                                    ৳<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

                                </p>
                                <form method="POST" action="<?php echo e(route('cart.remove', $item->id)); ?>" class="mt-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Cart Summary -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-900">Total:</span>
                        <span class="text-2xl font-bold text-gray-900">৳<?php echo e(number_format($cartTotal, 2)); ?></span>
                    </div>

                    <div class="flex space-x-4">
                        <form method="POST" action="<?php echo e(route('cart.clear')); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="w-full bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-700 font-semibold transition duration-200"
                                    onclick="return confirm('Are you sure you want to clear your cart?')">
                                Clear Cart
                            </button>
                        </form>

                        <button onclick="showCheckoutForm()" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-semibold transition duration-200">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Checkout Form Modal -->
            <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg max-w-md w-full p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Checkout Information</h3>
                            <button onclick="hideCheckoutForm()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form method="POST" action="<?php echo e(route('checkout')); ?>" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="customer_name" id="customer_name" required
                                       value="<?php echo e(Auth::guard('customer')->user()->name ?? ''); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="customer_email" id="customer_email" required
                                       value="<?php echo e(Auth::guard('customer')->user()->email ?? ''); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="customer_phone" id="customer_phone" required
                                       value="<?php echo e(Auth::guard('customer')->user()->phone ?? ''); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                                <textarea name="customer_address" id="customer_address" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(Auth::guard('customer')->user()->address ?? ''); ?></textarea>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg font-semibold">Total Amount:</span>
                                    <span class="text-xl font-bold text-blue-600">৳<?php echo e(number_format($cartTotal, 2)); ?></span>
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <button type="button" onclick="hideCheckoutForm()"
                                        class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-700 font-semibold transition duration-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-semibold transition duration-200">
                                    Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function showCheckoutForm() {
                    document.getElementById('checkoutModal').classList.remove('hidden');
                }

                function hideCheckoutForm() {
                    document.getElementById('checkoutModal').classList.add('hidden');
                }
            </script>
        <?php else: ?>
            <!-- Empty Cart for Logged in User -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Start shopping to add items to your cart.</p>
                <a href="/books" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold transition duration-200">
                    Browse Books
                </a>
            </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH D:\Projects\ims-web\resources\views/cart.blade.php ENDPATH**/ ?>