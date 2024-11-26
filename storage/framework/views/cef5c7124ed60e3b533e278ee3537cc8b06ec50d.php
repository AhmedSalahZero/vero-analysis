<?php $attributes = $attributes->exceptProps([
    'title' , 
    'tableId',
    'type',
    'exportRoute'
]); ?>
<?php foreach (array_filter(([
    'title' , 
    'tableId',
    'type',
    'exportRoute'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<form <?php echo e($attributes->merge(['class'=>'position-absolute custom-export px-3 rounded close-when-clickaway d-none'])); ?> id="<?php echo e($type); ?>_form-for-<?php echo e($tableId); ?>" >
            <div class="pb-3 pt-4 mb-3 px-1 border-bottom">
                <h5 class="text-dark"> <?php echo e($title); ?> </h5>
            </div>
            <?php echo e($slot); ?>

</form><?php /**PATH E:\projects\veroo\resources\views/components/form/modal.blade.php ENDPATH**/ ?>