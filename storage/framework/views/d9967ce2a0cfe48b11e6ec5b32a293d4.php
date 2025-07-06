<?php if (isset($component)) { $__componentOriginal6ed24e5f4f3da15044ad6432ae5960ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ed24e5f4f3da15044ad6432ae5960ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.author-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('author-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('heading', null, []); ?> 
        My Manuscripts
     <?php $__env->endSlot(); ?>

    <!-- Page Description -->
    <div class="mb-8">
        <p class="text-gray-600 mt-2">Track the status of your submitted manuscripts and manage your submissions</p>
    </div>

    <!-- Action Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Manuscript Collection</h2>
                <p class="text-gray-600 mt-1">Manage all your submitted manuscripts</p>
            </div>
            <div>
                <a href="<?php echo e(route('author.manuscripts.create')); ?>"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Submit New Manuscript
                </a>
            </div>
        </div>
    </div>

    <!-- Manuscripts List -->
    <?php if($manuscripts->count() > 0): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">All Manuscripts (<?php echo e($manuscripts->total()); ?>)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title & Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $manuscripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manuscript): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <?php if($manuscript->cover_image): ?>
                                            <img src="<?php echo e(asset('storage/' . $manuscript->cover_image)); ?>"
                                                 alt="Cover"
                                                 class="w-12 h-16 object-cover rounded mr-4 flex-shrink-0">
                                        <?php else: ?>
                                            <div class="w-12 h-16 bg-gray-200 rounded mr-4 flex-shrink-0 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($manuscript->title); ?></p>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo e(Str::limit($manuscript->description, 80)); ?></p>
                                            <?php if($manuscript->pages): ?>
                                                <p class="text-xs text-gray-400 mt-1"><?php echo e($manuscript->pages); ?> pages</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?php echo e($manuscript->genre); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'under_review' => 'bg-blue-100 text-blue-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'published' => 'bg-purple-100 text-purple-800',
                                        ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $manuscript->status))); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($manuscript->submitted_at ? $manuscript->submitted_at->format('M d, Y') : 'Draft'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php if($manuscript->suggested_price): ?>
                                        $<?php echo e(number_format($manuscript->suggested_price, 2)); ?>

                                    <?php else: ?>
                                        <span class="text-gray-400">Not set</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="<?php echo e(route('author.manuscripts.show', $manuscript->id)); ?>"
                                           class="text-blue-600 hover:text-blue-900 transition duration-200">
                                            View
                                        </a>
                                        <?php if($manuscript->status === 'pending' || $manuscript->status === 'rejected'): ?>
                                            <a href="<?php echo e(route('author.manuscripts.edit', $manuscript->id)); ?>"
                                               class="text-green-600 hover:text-green-900 transition duration-200">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($manuscripts->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($manuscripts->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-100 mb-6">
                <svg class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No manuscripts yet</h3>
            <p class="text-gray-500 mb-6">You haven't submitted any manuscripts yet. Start by submitting your first manuscript for review.</p>
            <a href="<?php echo e(route('author.manuscripts.create')); ?>"
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Submit Your First Manuscript
            </a>
        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ed24e5f4f3da15044ad6432ae5960ac)): ?>
<?php $attributes = $__attributesOriginal6ed24e5f4f3da15044ad6432ae5960ac; ?>
<?php unset($__attributesOriginal6ed24e5f4f3da15044ad6432ae5960ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ed24e5f4f3da15044ad6432ae5960ac)): ?>
<?php $component = $__componentOriginal6ed24e5f4f3da15044ad6432ae5960ac; ?>
<?php unset($__componentOriginal6ed24e5f4f3da15044ad6432ae5960ac); ?>
<?php endif; ?>
<?php /**PATH D:\Projects\ims-web\resources\views/author/manuscripts.blade.php ENDPATH**/ ?>