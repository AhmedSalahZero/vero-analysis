 <div class="col-md-3 mb-4">
           <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalName' => 'PricingExpense','addNewModalModalType' => 'other-direct-manpower-expense','addNewModalModalTitle' => __('Other Direct Manpower Expense'),'isSelect2' => false,'options' => $otherVariableManpowerExpenses??[],'addNew' => false,'label' => __('Other Direct Manpower Expense'),'class' => '','dataFilterType' => ''.e($type).'','all' => false,'name' => 'expense_id','id' => ''.e($type.'_'.'name').'','selectedValue' => isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getName() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('PricingExpense'),'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('other-direct-manpower-expense'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Other Direct Manpower Expense')),'is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($otherVariableManpowerExpenses??[]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Other Direct Manpower Expense')),'class' => '','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'expense_id','id' => ''.e($type.'_'.'name').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getName() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                <div class="d-md-none m--margin-bottom-10"></div>

     
 </div>
 
 <div class="col-md-2 mb-4">

     <label class="form-label font-weight-bold"><?php echo e(__('As Percentage Of Price %')); ?> </label>
     <div class="kt-input-icon">
         <div class="input-group">
             <input type="number" class="form-control only-percentage-allowed percentage-summation " name="variable_mp_expense_percentage" value="<?php echo e(isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getPercentageOfPrice() : old('variable_mp_expense_percentage',0)); ?>" step="any">
         </div>
     </div>
 </div>


 <div class="col-md-2 mb-4">
     <label class="form-label font-weight-bold"><?php echo e(__('Cost Per Unit')); ?> </label>
     <div class="kt-input-icon">
         <div class="input-group">
             <input type="number" class="form-control only-greater-than-or-equal-zero-allowed  mp-total-cost-class" name="mp_cost_per_unit" value="<?php echo e(isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getCostPerUnit() : old('mp_cost_per_unit',0)); ?>" step="any">
         </div>
     </div>
 </div>

 <div class="col-md-2 mb-4">
     <label class="form-label font-weight-bold"><?php echo e(__('Units Count')); ?> </label>
     <div class="kt-input-icon">
         <div class="input-group">
             <input type="number" class="form-control only-greater-than-or-equal-zero-allowed mp-total-cost-class" name="mp_units_count" value="<?php echo e(isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getUnitCost() : old('mp_units_count',0)); ?>" step="any">
         </div>
     </div>
 </div>


 <div class="col-md-3 mb-4">
     <label class="form-label font-weight-bold"><?php echo e(__('Total Cost')); ?> </label>
     <div class="kt-input-icon">
         <div class="input-group">
             <input type="text" readonly class="form-control  disabled-custom total-cost-summation" name="mp_total_cost" value="<?php echo e(isset($otherVariableManpowerExpense) ? $otherVariableManpowerExpense->getTotalCost() : old('mp_total_cost',0)); ?>" step="any">
         </div>
     </div>
 </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/quick-pricing-calculator/form/other-variable-manpower-expense.blade.php ENDPATH**/ ?>