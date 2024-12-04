<?php $attributes = $attributes->exceptProps([
	'createRoute',
	'createPermissionName'
]); ?>
<?php foreach (array_filter(([
	'createRoute',
	'createPermissionName'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == 'bank-accounts' ?'active':''); ?>" href="<?php echo e(route('view.financial.institutions',['company'=>$company->id])); ?>" role="tab">
                        <i class="fa fa-arrow-left"></i> <?php echo e(__('Back To Banks Table')); ?>

                    </a>
                </li>

            </ul>
			
			<?php if($createRoute && $createPermissionName): ?>
			<?php if(hasAuthFor($createPermissionName)): ?>
            <div class="flex-tabs">
                <a href="
				<?php echo e($createRoute); ?>

				" class="btn  active-style btn-icon-sm align-self-center">
                    <i class="fas fa-plus"></i>
                    <?php echo e(__('New Record')); ?>

                </a>
            </div>
			<?php endif; ?>
			<?php endif; ?> 
			

        </div>
    </div>
	<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/back-to-bank-header-btn.blade.php ENDPATH**/ ?>