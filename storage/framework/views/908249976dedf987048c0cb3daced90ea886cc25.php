<?php $attributes = $attributes->exceptProps([
'id',
'tableId',
'isRepeater',
'subModel',
'salesOrder'=> $subModel
]); ?>
<?php foreach (array_filter(([
'id',
'tableId',
'isRepeater',
'subModel',
'salesOrder'=> $subModel
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="modal fade modal-item-js" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Custom Collection')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo e(__('Execution Percentage %')); ?></th>
                                <th class="text-center"><?php echo e(__('Amount')); ?></th>
                                <th class="text-center"><?php echo e(__('Start Date')); ?></th>
                                <th class="text-center"><?php echo e(__('Execution Days')); ?></th>
                                <th class="text-center"><?php echo e(__('End Date')); ?></th>
                                <th class="text-center"><?php echo e(__('Collection Days')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 1 ; $i <= 5 ; $i++): ?> <tr>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input name="execution_percentage_<?php echo e($i); ?>" type="numeric" step="0.1" class="form-control execution-percentage-js" value="<?php echo e(isset($salesOrder) ? $salesOrder->getExecutionPercentage($i) : old('salesOrders.execution_percentage_'.$i,0)); ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input readonly type="text" class="form-control amount-js" value="<?php echo e(isset($salesOrder) ? $salesOrder->getActualAmount($i) : old('salesOrders.execution_percentage_'.$i,0)); ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['type' => 'text','classes' => 'datepicker-input recalc-end-date-2 start-date-2','defaultValue' => formatDateForDatePicker(isset($salesOrder)  ? $salesOrder->getStartDate($i) : now()),'model' => $salesOrder??null,'label' => '','placeholder' => __(''),'name' => 'start_date_'.$i,'required' => true]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('datepicker-input recalc-end-date-2 start-date-2'),'default-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatDateForDatePicker(isset($salesOrder)  ? $salesOrder->getStartDate($i) : now())),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($salesOrder??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date_'.$i),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>

                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input name="execution_days_<?php echo e($i); ?>" type="numeric" step="1" class="form-control duration-2 recalc-end-date-2" value="<?php echo e(isset($salesOrder) ? $salesOrder->getExecutionDays($i) : old('salesOrders.execution_days_'.$i,0)); ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['type' => 'text','classes' => 'datepicker-input  end-date-2','defaultValue' => formatDateForDatePicker(isset($salesOrder)  ? $salesOrder->getEndDate($i) : now()),'model' => $salesOrder??null,'label' => '','placeholder' => __(''),'name' => 'end_date_'.$i,'required' => true]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('datepicker-input  end-date-2'),'default-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatDateForDatePicker(isset($salesOrder)  ? $salesOrder->getEndDate($i) : now())),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($salesOrder??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('end_date_'.$i),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </td>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input name="collection_days_<?php echo e($i); ?>" type="numeric" step="1" class="form-control " value="<?php echo e(isset($salesOrder) ? $salesOrder->getCollectionDays($i) : old('salesOrders.collection_days_'.$i,0)); ?>">
                                        </div>
                                    </div>
                                </td>




                                </tr>
                                <?php endfor; ?>
                                
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(__('Save')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/components/modal/execution-percentage.blade.php ENDPATH**/ ?>