<?php $attributes = $attributes->exceptProps([
    'datatableId'=>$datatableId ,
    'btnTitle'=>__('Apply'),
    'type'
]); ?>
<?php foreach (array_filter(([
    'datatableId'=>$datatableId ,
    'btnTitle'=>__('Apply'),
    'type'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="text-center mt-4">
                   <button type="reset" class="btn  btn-light btn-submit  <?php echo e($type); ?>-btn-class "><?php echo e(__('Reset')); ?></button>
                   <button data-datatable-id="<?php echo e($datatableId); ?>" class="btn btn-submit btn-primary <?php echo e($type); ?>-btn-class "><?php echo e($btnTitle); ?></button>
               </div>
               <?php /**PATH E:\projects\veroo\resources\views/components/form/filter-btn.blade.php ENDPATH**/ ?>