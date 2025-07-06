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
        <?php echo e($book->book_name); ?>

     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 flex flex-col md:flex-row gap-8">
        <div class="flex-shrink-0">
            <img src="<?php echo e($book->book_cover_link); ?>" alt="<?php echo e($book->book_name); ?>" class="rounded w-48 h-64 object-cover">
        </div>
        <div class="flex-1 flex flex-col">
            <h2 class="text-2xl font-bold mb-2"><?php echo e($book->book_name); ?></h2>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Author:</span> <?php echo e($book->book_author); ?></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Publisher:</span> <?php echo e($book->book_publisher); ?></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Genre:</span> <?php echo e($book->book_genre); ?></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Price:</span> <span class="text-blue-700 font-semibold">৳ <?php echo e($book->book_price); ?></span></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">Pages:</span> <?php echo e($book->book_pages); ?></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">ISBN-10:</span> <?php echo e($book->book_isbn_10); ?></p>
            <p class="text-gray-700 mb-1"><span class="font-semibold">ISBN-13:</span> <?php echo e($book->book_isbn_13); ?></p>
            <p class="text-gray-700 mb-4"><span class="font-semibold">Published:</span> <?php echo e($book->book_publication_date); ?></p>
            <div class="mt-4">
                <?php if(auth()->guard('customer')->check()): ?>
                    <!-- User is logged in as customer - show add to cart form -->
                    <form action="<?php echo e(route('cart.add', $book->book_id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add to Cart
                        </button>
                    </form>
                <?php else: ?>
                    <!-- User is not logged in - redirect to login -->
                    <a href="<?php echo e(route('login')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">
                        Add to Cart
                    </a>
                    <p class="text-sm text-gray-500 mt-2">Please log in to add items to your cart</p>
                <?php endif; ?>
            </div>
        </div>
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
<?php /**PATH D:\Projects\ims-web\resources\views/book.blade.php ENDPATH**/ ?>