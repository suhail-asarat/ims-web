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
        Edit Manuscript: <?php echo e($manuscript->title); ?>

     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navigation Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="<?php echo e(route('author.manuscripts')); ?>" class="text-blue-600 hover:text-blue-800">My Manuscripts</a>
                    <svg class="fill-current w-3 h-3 mx-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.476 239.03c9.373 9.372 9.373 24.568 0 33.941z"/>
                    </svg>
                </li>
                <li class="text-gray-500">Edit Manuscript</li>
            </ol>
        </nav>

        <!-- Admin Feedback (if available) -->
        <?php if($manuscript->admin_notes): ?>
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-amber-900">
                            <?php if($manuscript->status === 'rejected'): ?>
                                📝 Reviewer Feedback - Revision Required
                            <?php elseif($manuscript->status === 'under_review'): ?>
                                🔄 Changes Requested
                            <?php endif; ?>
                        </h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <p class="whitespace-pre-wrap"><?php echo e($manuscript->admin_notes); ?></p>
                        </div>
                        <?php if($manuscript->reviewed_at): ?>
                            <div class="mt-2 text-xs text-amber-600">
                                Reviewed <?php echo e($manuscript->reviewed_at->diffForHumans()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Edit Your Manuscript</h2>
                <p class="text-gray-600 mt-2">
                    <?php if($manuscript->status === 'rejected'): ?>
                        Address the reviewer's feedback and resubmit your manuscript.
                    <?php elseif($manuscript->status === 'under_review'): ?>
                        Make the requested changes and resubmit for final review.
                    <?php else: ?>
                        Update your manuscript details and resubmit for review.
                    <?php endif; ?>
                </p>
                <div class="mt-3 flex items-center text-sm">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($manuscript->getStatusBadgeClass()); ?>">
                        Current Status: <?php echo e($manuscript->formatted_status); ?>

                    </span>
                    <span class="ml-4 text-gray-500">
                        Originally submitted <?php echo e($manuscript->created_at->format('M j, Y')); ?>

                    </span>
                </div>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('author.manuscripts.update', $manuscript->id)); ?>" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Book Title *
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="<?php echo e(old('title', $manuscript->title)); ?>"
                            required
                            placeholder="Enter your book title"
                        >
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">
                            Genre *
                        </label>
                        <select
                            id="genre"
                            name="genre"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">Select a genre</option>
                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($genre); ?>" <?php echo e(old('genre', $manuscript->genre) === $genre ? 'selected' : ''); ?>>
                                    <?php echo e($genre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            Language *
                        </label>
                        <select
                            id="language"
                            name="language"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="English" <?php echo e(old('language', $manuscript->language) === 'English' ? 'selected' : ''); ?>>English</option>
                            <option value="Spanish" <?php echo e(old('language', $manuscript->language) === 'Spanish' ? 'selected' : ''); ?>>Spanish</option>
                            <option value="French" <?php echo e(old('language', $manuscript->language) === 'French' ? 'selected' : ''); ?>>French</option>
                            <option value="German" <?php echo e(old('language', $manuscript->language) === 'German' ? 'selected' : ''); ?>>German</option>
                            <option value="Italian" <?php echo e(old('language', $manuscript->language) === 'Italian' ? 'selected' : ''); ?>>Italian</option>
                            <option value="Portuguese" <?php echo e(old('language', $manuscript->language) === 'Portuguese' ? 'selected' : ''); ?>>Portuguese</option>
                            <option value="Other" <?php echo e(old('language', $manuscript->language) === 'Other' ? 'selected' : ''); ?>>Other</option>
                        </select>
                    </div>

                    <!-- Pages -->
                    <div>
                        <label for="pages" class="block text-sm font-medium text-gray-700 mb-2">
                            Number of Pages
                        </label>
                        <input
                            type="number"
                            id="pages"
                            name="pages"
                            min="1"
                            max="10000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="<?php echo e(old('pages', $manuscript->pages)); ?>"
                            placeholder="e.g., 250"
                        >
                    </div>

                    <!-- Suggested Price -->
                    <div>
                        <label for="suggested_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Suggested Price ($)
                        </label>
                        <input
                            type="number"
                            id="suggested_price"
                            name="suggested_price"
                            min="0"
                            max="999.99"
                            step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="<?php echo e(old('suggested_price', $manuscript->suggested_price)); ?>"
                            placeholder="e.g., 19.99"
                        >
                        <p class="mt-1 text-sm text-gray-500">Optional: Your suggested retail price for the book</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Book Description *
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                        placeholder="Provide a compelling description of your book. This will be used for marketing and to help readers understand what your book is about."
                    ><?php echo e(old('description', $manuscript->description)); ?></textarea>
                    <p class="mt-1 text-sm text-gray-500">Write a compelling description that will attract readers (minimum 50 characters)</p>
                </div>

                <!-- File Uploads -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Manuscript File -->
                    <div>
                        <label for="manuscript_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Manuscript File
                        </label>
                        <?php if($manuscript->manuscript_file): ?>
                            <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-green-800">Current file uploaded</span>
                                    <a href="<?php echo e(asset('storage/' . $manuscript->manuscript_file)); ?>"
                                       target="_blank"
                                       class="ml-2 text-sm text-green-600 hover:text-green-800 underline">
                                        Download
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <input
                            type="file"
                            id="manuscript_file"
                            name="manuscript_file"
                            accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                        <p class="mt-1 text-sm text-gray-500">
                            <?php if($manuscript->manuscript_file): ?>
                                Upload a new file to replace the current one.
                            <?php endif; ?>
                            Accepted formats: PDF, DOC, DOCX (Max: 10MB)
                        </p>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Cover Image
                        </label>
                        <?php if($manuscript->cover_image): ?>
                            <div class="mb-3">
                                <img src="<?php echo e(asset('storage/' . $manuscript->cover_image)); ?>"
                                     alt="Current cover"
                                     class="w-24 h-32 object-cover rounded border">
                                <p class="text-sm text-green-800 mt-1">Current cover image</p>
                            </div>
                        <?php endif; ?>
                        <input
                            type="file"
                            id="cover_image"
                            name="cover_image"
                            accept="image/jpeg,image/png,image/jpg"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                        <p class="mt-1 text-sm text-gray-500">
                            <?php if($manuscript->cover_image): ?>
                                Upload a new image to replace the current cover.
                            <?php endif; ?>
                            Accepted formats: JPEG, PNG, JPG (Max: 5MB)
                        </p>
                    </div>
                </div>

                <!-- Submission Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Important Notes:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-700">
                                <li>After submitting changes, your manuscript status will be reset to "Pending" for re-review</li>
                                <li>Please address all feedback points mentioned by the reviewer</li>
                                <li>Our editorial team will review your revised manuscript within 5-7 business days</li>
                                <li>You can edit your manuscript multiple times until it's approved</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <a href="<?php echo e(route('author.manuscripts')); ?>"
                           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                            Cancel
                        </a>
                        <a href="<?php echo e(route('author.manuscripts.show', $manuscript->id)); ?>"
                           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                            View Details
                        </a>
                    </div>
                    <button
                        type="submit"
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium"
                    >
                        Update & Resubmit Manuscript
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File upload validation
        document.getElementById('manuscript_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.size > 10 * 1024 * 1024) { // 10MB
                alert('Manuscript file size should not exceed 10MB');
                e.target.value = '';
            }
        });

        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.size > 5 * 1024 * 1024) { // 5MB
                alert('Cover image size should not exceed 5MB');
                e.target.value = '';
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const description = document.getElementById('description').value;
            if (description.length < 50) {
                alert('Please provide a description of at least 50 characters');
                e.preventDefault();
                return false;
            }
        });
    </script>
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
<?php /**PATH D:\Projects\ims-web\resources\views/author/edit-manuscript.blade.php ENDPATH**/ ?>