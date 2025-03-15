<?php $attributes = $attributes->exceptProps([
	'filterDate'=>'',
]); ?>
<?php foreach (array_filter(([
	'filterDate'=>'',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
    <form class="search-bar d-flex grow align-items-center ml-3	mr-auto">
                            <div class="form-group mr-3">
                                <label class="label visibility-hidden"><?php echo e(__('Date')); ?></label>
                                <input value="<?php echo e($filterDate); ?>" name="filter_date" type="date" class="form-control">
                            </div>
                      
                            <button type="submit" class="btn btn-primary "><?php echo e(__('Filter')); ?></button>
                        </form>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/filter-by-single-date.blade.php ENDPATH**/ ?>