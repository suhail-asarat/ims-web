<?php if (isset($component)) { $__componentOriginal03b6c44728e100ba2673d02906458342 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03b6c44728e100ba2673d02906458342 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('heading', null, []); ?> 
        My Orders
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto">
        <?php if($orders->count() > 0): ?>
            <!-- Orders List -->
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Order #<?php echo e($order->transaction_id); ?></h3>
                                    <p class="text-sm text-gray-600">Placed on <?php echo e($order->created_at->format('M d, Y')); ?></p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        <?php if($order->status === 'paid'): ?> bg-green-100 text-green-800
                                        <?php elseif($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($order->status === 'failed'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                    <p class="text-lg font-bold text-gray-900 mt-1"><?php echo e($order->formatted_amount); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-4">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Items Ordered:</h4>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="flex-1">
                                            <h5 class="font-medium text-gray-900"><?php echo e($product['book_name']); ?></h5>
                                            <p class="text-sm text-gray-600">Quantity: <?php echo e($product['quantity']); ?></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900">৳<?php echo e(number_format($product['total'], 2)); ?></p>
                                            <p class="text-sm text-gray-600">৳<?php echo e(number_format($product['price'], 2)); ?> each</p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="bg-gray-50 px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">Customer Name:</p>
                                    <p class="font-medium"><?php echo e($order->customer_name); ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Email:</p>
                                    <p class="font-medium"><?php echo e($order->customer_email); ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Phone:</p>
                                    <p class="font-medium"><?php echo e($order->customer_phone); ?></p>
                                </div>
                                <?php if($order->payment_method): ?>
                                <div>
                                    <p class="text-gray-600">Payment Method:</p>
                                    <p class="font-medium"><?php echo e($order->payment_method); ?></p>
                                </div>
                                <?php endif; ?>
                                <div class="md:col-span-2">
                                    <p class="text-gray-600">Delivery Address:</p>
                                    <p class="font-medium"><?php echo e($order->customer_address); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Orders Summary -->
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600"><?php echo e($orders->count()); ?></div>
                        <div class="text-sm text-gray-600">Total Orders</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600"><?php echo e($orders->where('status', 'paid')->count()); ?></div>
                        <div class="text-sm text-gray-600">Completed</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo e($orders->where('status', 'pending')->count()); ?></div>
                        <div class="text-sm text-gray-600">Pending</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-gray-600">৳<?php echo e(number_format($orders->where('status', 'paid')->sum('total_amount'), 2)); ?></div>
                        <div class="text-sm text-gray-600">Total Spent</div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- No Orders -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">No Orders Yet</h2>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="<?php echo e(url('/books')); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03b6c44728e100ba2673d02906458342)): ?>
<?php $attributes = $__attributesOriginal03b6c44728e100ba2673d02906458342; ?>
<?php unset($__attributesOriginal03b6c44728e100ba2673d02906458342); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03b6c44728e100ba2673d02906458342)): ?>
<?php $component = $__componentOriginal03b6c44728e100ba2673d02906458342; ?>
<?php unset($__componentOriginal03b6c44728e100ba2673d02906458342); ?>
<?php endif; ?>
<?php /**PATH D:\Projects\ims-web\resources\views/customer/orders.blade.php ENDPATH**/ ?>