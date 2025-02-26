<?php $attributes = $attributes->exceptProps([
	'title',
	'icon'=>'fa-layer-group'
]); ?>
<?php foreach (array_filter(([
	'title',
	'icon'=>'fa-layer-group'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label ml-4">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger text-main-color fa <?php echo e($icon); ?>"></i>
                            </span>
                            <label class="kt-portlet__head-title  text-main-color" style="font-size:20px !important; ">
                                <?php echo e($title); ?>

                            </label>

                        </div>
<?php echo e($slot); ?>						
                    </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/table-title/title.blade.php ENDPATH**/ ?>