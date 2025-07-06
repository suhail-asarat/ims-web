<?php
    $navLinks = [
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Books', 'href' => '/books'],
        ['label' => 'Genres', 'href' => '/genres'],
        ['label' => 'Authors', 'href' => '/authors'],
        ['label' => 'Publishers', 'href' => '/publishers'],
        ['label' => 'Blog', 'href' => '/blog'],
        ['label' => 'About', 'href' => '/about'],
        ['label' => 'Contact', 'href' => '/contact'],
    ];
?>
<nav class="flex-1 flex justify-center space-x-2">
    <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $active = request()->is(ltrim($link['href'], '/')) || ($link['href'] === '/' && request()->path() === '/');
        ?>
        <a href="<?php echo e($link['href']); ?>"
           class="relative px-4 py-2 rounded-full font-medium transition
                  <?php echo e($active ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'); ?>">
            <?php echo e($link['label']); ?>

            <?php if($active): ?>
                <span class="absolute left-1/2 -bottom-1.5 -translate-x-1/2 w-2 h-2 bg-blue-400 rounded-full"></span>
            <?php endif; ?>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH D:\Projects\ims-web\resources\views/components/nav-link.blade.php ENDPATH**/ ?>