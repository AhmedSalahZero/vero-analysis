<?php $attributes = $attributes->exceptProps([
'subItems'
]); ?>
<?php foreach (array_filter(([
'subItems'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>


<?php $__currentLoopData = $subItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php if(isset($menuArr['submenu'])&&count($menuArr['submenu'])): ?>
<?php if($menuArr['show']): ?>

<li

 class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="#" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"><?php echo e($menuArr['title']); ?></span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
        <ul class="kt-menu__subnav">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-menu.multi-submenu','data' => ['subItems' => $menuArr['submenu']]]); ?>
<?php $component->withName('nav-menu.multi-submenu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subItems' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menuArr['submenu'])]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </ul>
    </div>
</li>
<?php endif; ?> 
<?php else: ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-menu.single-submenu','data' => ['menuArr' => $menuArr]]); ?>
<?php $component->withName('nav-menu.single-submenu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['menuArr' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menuArr)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\projects\veroo\resources\views/components/nav-menu/multi-submenu.blade.php ENDPATH**/ ?>