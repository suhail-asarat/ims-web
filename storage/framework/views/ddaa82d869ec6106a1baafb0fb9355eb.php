<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('heading', null, []); ?> 
        Order Details
     <?php $__env->endSlot(); ?>

    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="<?php echo e(route('admin.orders.index')); ?>"
                   class="text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="text-xl font-semibold text-gray-900">Order #<?php echo e($order->transaction_id); ?></h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    <?php if($order->status === 'paid'): ?> bg-green-100 text-green-800
                    <?php elseif($order->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                    <?php elseif($order->status === 'failed'): ?> bg-red-100 text-red-800
                    <?php else: ?> bg-gray-100 text-gray-800
                    <?php endif; ?>">
                    <?php echo e(ucfirst($order->status)); ?>

                </span>
            </div>
            <p class="text-gray-600">Order placed on <?php echo e($order->created_at->format('F d, Y \a\t H:i')); ?></p>
        </div>
        <div class="text-right">
            <div class="text-2xl font-bold text-gray-900">৳<?php echo e(number_format($order->total_amount, 2)); ?></div>
            <?php if($order->payment_method): ?>
                <div class="text-sm text-gray-500">via <?php echo e(ucfirst($order->payment_method)); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="p-6">
                    <?php if($order->products && is_array($order->products)): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center space-x-4 py-4 border-b border-gray-100 last:border-b-0">
                                    <div class="flex-shrink-0 w-16 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <?php if(isset($product['book_cover_link']) && $product['book_cover_link']): ?>
                                            <img src="<?php echo e($product['book_cover_link']); ?>"
                                                 alt="<?php echo e($product['book_name'] ?? 'Book Cover'); ?>"
                                                 class="w-full h-full object-cover rounded-lg">
                                        <?php else: ?>
                                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900"><?php echo e($product['book_name'] ?? 'Unknown Book'); ?></h4>
                                        <?php if(isset($product['book_author'])): ?>
                                            <p class="text-sm text-gray-500">by <?php echo e($product['book_author']); ?></p>
                                        <?php endif; ?>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-sm text-gray-600">Quantity: <?php echo e($product['quantity'] ?? 1); ?></span>
                                            <span class="text-sm font-medium text-gray-900">৳<?php echo e(number_format($product['book_price'] ?? 0, 2)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Order Total -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900">Total Amount</span>
                                <span class="text-lg font-bold text-gray-900">৳<?php echo e(number_format($order->total_amount, 2)); ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-gray-500">No items found in this order</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Transaction ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono"><?php echo e($order->transaction_id); ?></dd>
                        </div>
                        <?php if($order->bank_tran_id): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Bank Transaction ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono"><?php echo e($order->bank_tran_id); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if($order->payment_method): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst($order->payment_method)); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if($order->card_type): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Card Type</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst($order->card_type)); ?></dd>
                            </div>
                        <?php endif; ?>
                        <?php if($order->store_amount): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Store Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900">৳<?php echo e(number_format($order->store_amount, 2)); ?></dd>
                            </div>
                        <?php endif; ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Currency</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e(strtoupper($order->currency ?? 'BDT')); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?php echo e($order->customer_name); ?></div>
                            <?php if($order->customer): ?>
                                <div class="text-sm text-gray-500">Customer ID: <?php echo e($order->customer->id); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:<?php echo e($order->customer_email); ?>" class="text-blue-600 hover:text-blue-900">
                                    <?php echo e($order->customer_email); ?>

                                </a>
                            </dd>
                        </div>
                        <?php if($order->customer_phone): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:<?php echo e($order->customer_phone); ?>" class="text-blue-600 hover:text-blue-900">
                                        <?php echo e($order->customer_phone); ?>

                                    </a>
                                </dd>
                            </div>
                        <?php endif; ?>
                        <?php if($order->customer_address): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($order->customer_address); ?></dd>
                            </div>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="space-y-6">
                            <!-- Order Created - Always shown -->
                            <li>
                                <div class="relative flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Order Created</p>
                                            <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->created_at->format('M d, Y \a\t H:i')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Payment Received - Show if order has been paid or beyond -->
                            <?php if(in_array($order->status, ['paid', 'confirmed', 'processing', 'completed'])): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Payment Received</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Order Confirmed - Show if order has been confirmed or beyond -->
                            <?php if(in_array($order->status, ['confirmed', 'processing', 'completed'])): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Order Confirmed</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->confirmed_at ? $order->confirmed_at->format('M d, Y \a\t H:i') : $order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Processing - Show if order is processing or completed -->
                            <?php if(in_array($order->status, ['processing', 'completed'])): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Processing Order</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Completed - Show only if order is completed -->
                            <?php if($order->status === 'completed'): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-emerald-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Order Completed</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Failed Status - Show only if payment failed -->
                            <?php if($order->status === 'failed'): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Payment Failed</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Cancelled Status - Show only if order was cancelled -->
                            <?php if($order->status === 'cancelled'): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-gray-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Order Cancelled</p>
                                                <p class="mt-0.5 text-xs text-gray-500"><?php echo e($order->confirmed_at ? $order->confirmed_at->format('M d, Y \a\t H:i') : $order->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                                <?php if($order->admin_notes): ?>
                                                    <p class="mt-1 text-xs text-red-600"><?php echo e($order->admin_notes); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Pending Status Indicator - Show only if still pending -->
                            <?php if($order->status === 'pending'): ?>
                                <li>
                                    <div class="relative flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Awaiting Payment</p>
                                                <p class="mt-0.5 text-xs text-gray-500">Payment pending...</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Admin Actions</h3>
                </div>
                <div class="p-6">
                    <?php if(session('success')): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Quick Confirm/Reject Buttons -->
                    <?php if(in_array($order->status, ['paid'])): ?>
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Quick Actions</h4>
                            <div class="flex space-x-3">
                                <form action="<?php echo e(route('admin.orders.confirm', $order->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Confirm Order
                                    </button>
                                </form>

                                <button onclick="showRejectModal()"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reject Order
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Advanced Status Update -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Update Order Status</h4>
                        <form action="<?php echo e(route('admin.orders.update-status', $order->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending Payment</option>
                                        <option value="paid" <?php echo e($order->status === 'paid' ? 'selected' : ''); ?>>Payment Received</option>
                                        <option value="confirmed" <?php echo e($order->status === 'confirmed' ? 'selected' : ''); ?>>Order Confirmed</option>
                                        <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                                        <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                        <option value="failed" <?php echo e($order->status === 'failed' ? 'selected' : ''); ?>>Payment Failed</option>
                                        <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                                    <textarea name="admin_notes" id="admin_notes" rows="3"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Add notes about this status change..."><?php echo e($order->admin_notes); ?></textarea>
                                </div>

                                <div>
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Admin Notes Display -->
                    <?php if($order->admin_notes): ?>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Current Admin Notes</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-800"><?php echo e($order->admin_notes); ?></p>
                                <?php if($order->confirmed_at): ?>
                                    <p class="text-xs text-gray-500 mt-2">Last updated: <?php echo e($order->confirmed_at->format('M d, Y \a\t H:i')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>

<!-- Reject Order Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Reject Order</h3>
                <button onclick="hideRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="<?php echo e(route('admin.orders.reject', $order->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for rejection <span class="text-red-500">*</span>
                    </label>
                    <textarea name="admin_notes" id="reject_notes" rows="4" required
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                              placeholder="Please provide a reason for rejecting this order..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                        Reject Order
                    </button>
                    <button type="button" onclick="hideRejectModal()"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reject_notes').value = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
<?php /**PATH D:\Projects\ims-web\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>