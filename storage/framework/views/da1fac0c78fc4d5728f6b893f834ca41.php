<?php if (isset($component)) { $__componentOriginal93babf7de187df73d56674b5d2537927 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93babf7de187df73d56674b5d2537927 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93babf7de187df73d56674b5d2537927)): ?>
<?php $attributes = $__attributesOriginal93babf7de187df73d56674b5d2537927; ?>
<?php unset($__attributesOriginal93babf7de187df73d56674b5d2537927); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93babf7de187df73d56674b5d2537927)): ?>
<?php $component = $__componentOriginal93babf7de187df73d56674b5d2537927; ?>
<?php unset($__componentOriginal93babf7de187df73d56674b5d2537927); ?>
<?php endif; ?>
<?php /**PATH D:\Projects\ims-web\resources\views/home.blade.php ENDPATH**/ ?>