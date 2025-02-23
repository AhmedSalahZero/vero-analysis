<?php $attributes = $attributes->exceptProps([
'saveAndReturn'=>false
]); ?>
<?php foreach (array_filter(([
'saveAndReturn'=>false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="kt-portlet">
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-6">
                    
                </div>
					<div class="col-lg-6 kt-align-right">
						<button type="submit" class="btn active-style save-form"><?php echo e(__('Save')); ?></button>
					</div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/submitting.blade.php ENDPATH**/ ?>