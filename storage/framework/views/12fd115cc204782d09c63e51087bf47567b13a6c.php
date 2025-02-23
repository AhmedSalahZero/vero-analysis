<?php $attributes = $attributes->exceptProps([
	'query'
]); ?>
<?php foreach (array_filter(([
	'query'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
 <div class="btn show-hide-style show-hide-repeater" data-query="<?php echo e($query); ?>"><?php echo e(__('Show/Hide')); ?></div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/show-hide-btn.blade.php ENDPATH**/ ?>