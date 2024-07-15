<?php $attributes = $attributes->exceptProps([
'id',
'tableId',
'isRepeater',
'subModel'
]); ?>
<?php foreach (array_filter(([
'id',
'tableId',
'isRepeater',
'subModel'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
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
                                <th class="text-center"><?php echo e(__('Payment Rate %')); ?></th>
                                <th class="text-center"><?php echo e(__('Due In Days')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($rateIndex= 0 ;$rateIndex<6 ; $rateIndex++): ?> <tr>
                                <td>
                                    <input class="form-control only-percentage-allowed rate-element" value="<?php echo e(isset($subModel) ? $subModel->getPaymentRate($rateIndex) :  0); ?>" placeholder="<?php echo e(__('Rate') .  ' ' . $rateIndex); ?>">
                                    <input multiple class="rate-element-hidden" type="hidden" value="<?php echo e((isset($subModel) ? $subModel->getPaymentRate($rateIndex) : 0)); ?>" name="<?php if($isRepeater): ?>payment_rate <?php else: ?> <?php echo e($tableId); ?>[0][payment_rate] <?php endif; ?>">
                                </td>
                                <td>
								<div class="max-w-selector-popup">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['maxOptions' => 1,'multiple' => true,'selectedValue' => isset($subModel) ? $subModel->getPaymentRateAtDueInDays($rateIndex) : '' ,'options' => dueInDays(),'addNew' => false,'class' => 'select2-select  js-due_in_days repeater-select','all' => false,'name' => '@if($isRepeater) due_days @else '.e($tableId).'[0][due_days] @endif','id' => ''.e($tableId.'-'.'dueInDays').'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['maxOptions' => 1,'multiple' => true,'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($subModel) ? $subModel->getPaymentRateAtDueInDays($rateIndex) : '' ),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(dueInDays()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  js-due_in_days repeater-select','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) due_days @else '.e($tableId).'[0][due_days] @endif','id' => ''.e($tableId.'-'.'dueInDays').'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
								</div>
                                </td>
                                </tr>
                                <?php endfor; ?>
								<tr style="border-top:1px solid gray;padding-top:5px;text-align:center">
									<td class="td-for-total-payment-rate">
										0
									</td>
									<td>-</td>
								</tr>
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
<?php /**PATH C:\laragon\www\veroo\resources\views/components/modal/custom-collection.blade.php ENDPATH**/ ?>