<?php $attributes = $attributes->exceptProps([
	'filterDate'
]); ?>
<?php foreach (array_filter(([
	'filterDate'
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
                                <i class="kt-font-secondary btn-outline-hover-danger text-main-color fa fa-layer-group"></i>
                            </span>
                            <label class="kt-portlet__head-title  text-main-color" style="font-size:20px !important; ">
                                <?php echo e(__('Date')); ?>

                            </label>

                        </div>

                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.filter-by-single-date','data' => ['filterDate' => $filterDate]]); ?>
<?php $component->withName('filter-by-single-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['filter-date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDate)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/table-title/with-one-date.blade.php ENDPATH**/ ?>