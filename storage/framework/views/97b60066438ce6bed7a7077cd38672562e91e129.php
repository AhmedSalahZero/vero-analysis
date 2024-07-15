                    
					<?php $attributes = $attributes->exceptProps([
						'menuArr'
					]); ?>
<?php foreach (array_filter(([
						'menuArr'
					]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>	
						<?php if($menuArr['show']): ?>
						<li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo e($menuArr['link']); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text"><?php echo e($menuArr['title']); ?></span></a></li>
						<?php endif; ?>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/nav-menu/single-submenu.blade.php ENDPATH**/ ?>