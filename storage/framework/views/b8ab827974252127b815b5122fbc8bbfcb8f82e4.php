<?php $attributes = $attributes->exceptProps([
	'title'
]); ?>
<?php foreach (array_filter(([
	'title'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<style>
.text-black{
	color:#0741A5 !important;
}
</style>
                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e($title); ?></h3>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/sectionTitle.blade.php ENDPATH**/ ?>