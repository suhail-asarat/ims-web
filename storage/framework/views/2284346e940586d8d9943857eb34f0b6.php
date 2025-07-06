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
        Review Manuscript: <?php echo e($manuscript->title); ?>

     <?php $__env->endSlot(); ?>

    <!-- Navigation Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="<?php echo e(route('admin.manuscripts.index')); ?>" class="text-blue-600 hover:text-blue-800">Manuscripts</a>
                <svg class="fill-current w-3 h-3 mx-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.476 239.03c9.373 9.372 9.373 24.568 0 33.941z"/>
                </svg>
            </li>
            <li class="text-gray-500"><?php echo e($manuscript->title); ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Manuscript Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($manuscript->title); ?></h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span>by <?php echo e($manuscript->author->name); ?></span>
                            <span>•</span>
                            <span><?php echo e($manuscript->genre); ?></span>
                            <span>•</span>
                            <span><?php echo e($manuscript->pages ? number_format($manuscript->pages) . ' pages' : 'Pages not specified'); ?></span>
                            <span>•</span>
                            <span><?php echo e($manuscript->language ?? 'English'); ?></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?php echo e($manuscript->getStatusBadgeClass()); ?>">
                            <?php echo e($manuscript->formatted_status); ?>

                        </span>
                        <?php if($manuscript->suggested_price): ?>
                            <div class="text-sm text-green-600 mt-2">
                                Suggested Price: $<?php echo e(number_format($manuscript->suggested_price, 2)); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Cover Image and Description -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-1">
                        <?php if($manuscript->cover_image): ?>
                            <img src="<?php echo e(asset('storage/' . $manuscript->cover_image)); ?>"
                                 alt="Cover Image"
                                 class="w-full max-w-sm mx-auto rounded-lg shadow-md">
                        <?php else: ?>
                            <div class="w-full max-w-sm mx-auto bg-gray-200 rounded-lg shadow-md aspect-[2/3] flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                                    </svg>
                                    <p>No Cover Image</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                        <?php if($manuscript->description): ?>
                            <div class="prose prose-sm max-w-none text-gray-700">
                                <?php echo e($manuscript->description); ?>

                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 italic">No description provided.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- File Downloads -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Files</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if($manuscript->manuscript_file): ?>
                            <a href="<?php echo e(asset('storage/' . $manuscript->manuscript_file)); ?>"
                               target="_blank"
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium text-gray-900">Manuscript File</div>
                                    <div class="text-sm text-gray-500">Click to download and review</div>
                                </div>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium text-gray-500">No manuscript file uploaded</div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($manuscript->cover_image): ?>
                            <a href="<?php echo e(asset('storage/' . $manuscript->cover_image)); ?>"
                               target="_blank"
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition">
                                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium text-gray-900">Cover Image</div>
                                    <div class="text-sm text-gray-500">View full size</div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <?php if(!$manuscript->isPublished()): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Manuscript</h3>

                    <form action="<?php echo e(route('admin.manuscripts.review', $manuscript->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-4">
                            <!-- Review Action -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Review Decision</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-green-300 hover:bg-green-50">
                                        <input type="radio" name="action" value="approve" class="sr-only peer">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-gray-900">Approve</div>
                                                <div class="text-sm text-gray-500">Ready for publication</div>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-green-600 rounded-lg hidden peer-checked:block"></div>
                                    </label>

                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-yellow-300 hover:bg-yellow-50">
                                        <input type="radio" name="action" value="request_changes" class="sr-only peer">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 14.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-gray-900">Request Changes</div>
                                                <div class="text-sm text-gray-500">Needs revisions</div>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-yellow-600 rounded-lg hidden peer-checked:block"></div>
                                    </label>

                                    <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50">
                                        <input type="radio" name="action" value="reject" class="sr-only peer">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <div class="font-medium text-gray-900">Reject</div>
                                                <div class="text-sm text-gray-500">Not suitable for publication</div>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-red-600 rounded-lg hidden peer-checked:block"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Suggested Price (for approvals) -->
                            <div id="suggested-price-field" class="hidden">
                                <label for="suggested_price" class="block text-sm font-medium text-gray-700">Suggested Price ($)</label>
                                <input type="number" name="suggested_price" id="suggested_price" step="0.01" min="0"
                                       value="<?php echo e($manuscript->suggested_price); ?>"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Set the recommended retail price for this book.</p>
                            </div>

                            <!-- Review Notes -->
                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700">Review Notes</label>
                                <textarea name="admin_notes" id="admin_notes" rows="5" required
                                          placeholder="Provide detailed feedback about the manuscript..."
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('admin_notes', $manuscript->admin_notes)); ?></textarea>
                                <p class="mt-1 text-sm text-gray-500">This feedback will be visible to the author.</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Submit Review
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Quick Publish (for approved manuscripts) -->
            <?php if($manuscript->isApproved()): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <span class="text-green-600">✓</span> Ready to Publish
                    </h3>
                    <p class="text-gray-600 mb-4">This manuscript has been approved and is ready to be published as a book.</p>

                    <button type="button"
                            onclick="showPublishModal('<?php echo e($manuscript->id); ?>', '<?php echo e($manuscript->title); ?>')"
                            class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Publish as Book
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Author Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Author Information</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Name</div>
                        <div class="text-gray-900"><?php echo e($manuscript->author->name); ?></div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Email</div>
                        <div class="text-gray-900">
                            <a href="mailto:<?php echo e($manuscript->author->email); ?>" class="text-blue-600 hover:text-blue-800">
                                <?php echo e($manuscript->author->email); ?>

                            </a>
                        </div>
                    </div>
                    <?php if($manuscript->author->phone): ?>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Phone</div>
                            <div class="text-gray-900"><?php echo e($manuscript->author->phone); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if($manuscript->author->website): ?>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Website</div>
                            <div class="text-gray-900">
                                <a href="<?php echo e($manuscript->author->website); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    <?php echo e($manuscript->author->website); ?>

                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($manuscript->author->bio): ?>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Bio</div>
                            <div class="text-gray-900 text-sm"><?php echo e(Str::limit($manuscript->author->bio, 200)); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <a href="<?php echo e(route('admin.authors.show', $manuscript->author->id)); ?>"
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View Author Profile →
                    </a>
                </div>
            </div>

            <!-- Manuscript Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Manuscript Details</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Submitted</span>
                        <span class="text-sm text-gray-900"><?php echo e($manuscript->created_at->format('M j, Y g:i A')); ?></span>
                    </div>
                    <?php if($manuscript->reviewed_at): ?>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Last Reviewed</span>
                            <span class="text-sm text-gray-900"><?php echo e($manuscript->reviewed_at->format('M j, Y g:i A')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($manuscript->reviewer): ?>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Reviewed By</span>
                            <span class="text-sm text-gray-900"><?php echo e($manuscript->reviewer->name ?? 'Admin'); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Language</span>
                        <span class="text-sm text-gray-900"><?php echo e($manuscript->language ?? 'English'); ?></span>
                    </div>
                    <?php if($manuscript->pages): ?>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500">Pages</span>
                            <span class="text-sm text-gray-900"><?php echo e(number_format($manuscript->pages)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Current Review Notes -->
            <?php if($manuscript->admin_notes): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Review Notes</h3>
                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-lg">
                        <?php echo e($manuscript->admin_notes); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <?php if($manuscript->manuscript_file): ?>
                        <a href="<?php echo e(asset('storage/' . $manuscript->manuscript_file)); ?>"
                           target="_blank"
                           class="block w-full px-4 py-2 text-center text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100">
                            Download Manuscript
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.authors.show', $manuscript->author->id)); ?>"
                       class="block w-full px-4 py-2 text-center text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100">
                        View Author Profile
                    </a>

                    <a href="<?php echo e(route('admin.manuscripts.index', ['status' => $manuscript->status])); ?>"
                       class="block w-full px-4 py-2 text-center text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100">
                        View Similar Status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the same publish modal from index page -->
    <div id="publish-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <form id="publish-form" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Publish Manuscript</h3>
                        <p class="text-sm text-gray-600 mb-4">Ready to publish "<span id="manuscript-title"></span>" as a book?</p>

                        <div class="space-y-4">
                            <div>
                                <label for="book_price" class="block text-sm font-medium text-gray-700">Book Price ($)</label>
                                <input type="number" name="book_price" id="book_price" step="0.01" min="0" required
                                       value="<?php echo e($manuscript->suggested_price); ?>"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="book_publisher" class="block text-sm font-medium text-gray-700">Publisher</label>
                                <input type="text" name="book_publisher" id="book_publisher" value="IMS Publishing House"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="book_cover_link" class="block text-sm font-medium text-gray-700">Cover Image URL (optional)</label>
                                <input type="url" name="book_cover_link" id="book_cover_link"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="book_isbn_10" class="block text-sm font-medium text-gray-700">ISBN-10 (optional)</label>
                                    <input type="text" name="book_isbn_10" id="book_isbn_10"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="book_isbn_13" class="block text-sm font-medium text-gray-700">ISBN-13 (optional)</label>
                                    <input type="text" name="book_isbn_13" id="book_isbn_13"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-2">
                        <button type="button" onclick="hidePublishModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                            Publish Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show/hide suggested price field based on action
        document.addEventListener('DOMContentLoaded', function() {
            const actionRadios = document.querySelectorAll('input[name="action"]');
            const suggestedPriceField = document.getElementById('suggested-price-field');

            actionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'approve') {
                        suggestedPriceField.classList.remove('hidden');
                    } else {
                        suggestedPriceField.classList.add('hidden');
                    }
                });
            });
        });

        function showPublishModal(manuscriptId, title) {
            document.getElementById('manuscript-title').textContent = title;
            document.getElementById('publish-form').action = `/admin/manuscripts/${manuscriptId}/publish`;
            document.getElementById('publish-modal').classList.remove('hidden');
        }

        function hidePublishModal() {
            document.getElementById('publish-modal').classList.add('hidden');
            document.getElementById('publish-form').reset();
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const publishModal = document.getElementById('publish-modal');
            if (event.target === publishModal) {
                hidePublishModal();
            }
        });
    </script>
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
<?php /**PATH D:\Projects\ims-web\resources\views/admin/manuscripts/show.blade.php ENDPATH**/ ?>