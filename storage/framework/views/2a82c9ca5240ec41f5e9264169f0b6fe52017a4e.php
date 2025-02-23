<div class="col-md-3">
                                                
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => 'direct-manpower-expense','addNewModalModalName' => 'Position','addNewModalModalTitle' => __('Position'),'isSelect2' => false,'options' => $positions,'addNew' => false,'label' => __('Position'),'class' => '','dataFilterType' => ''.e($type).'','all' => false,'name' => 'manpower_expense_position_id','id' => ''.e($type.'_'.'manpower_expense_position_id').'','selectedValue' => isset($directManpowerExpense) ? $directManpowerExpense->getPositionId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('direct-manpower-expense'),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Position'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position')),'is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($positions),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position')),'class' => '','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'manpower_expense_position_id','id' => ''.e($type.'_'.'manpower_expense_position_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($directManpowerExpense) ? $directManpowerExpense->getPositionId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                                <div class="d-md-none m--margin-bottom-10"></div>
                                            </div>
                                           <div class="col-md-3">
                                               <label><?php echo e(__('Working Days')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control only-greater-than-zero-allowed total-cost-calculations-class working-days" name="manpower_expense_working_days" value="<?php echo e(isset($directManpowerExpense) ? $directManpowerExpense->getWorkingDays() : old('manpower_expense_working_days')); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-md-3">
                                                      <label><?php echo e(__('Cost Per Day')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control only-greater-than-zero-allowed total-cost-calculations-class cost-per-day" name="manpower_expense_cost_per_day" value="<?php echo e(isset($directManpowerExpense) ? $directManpowerExpense->getCostPerDay() : old('manpower_expense_cost_per_day')); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 



                                                   <div class="col-md-3">
                                                      <label><?php echo e(__('Total Cost')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input  readonly  class="form-control disabled-custom total-cost-summation" name="manpower_expense_total_cost" value="<?php echo e(isset($directManpowerExpense) ? $directManpowerExpense->getTotalCost() : old('manpower_expense_total_cost')); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/quick-pricing-calculator/form/direct-manpower-expenses.blade.php ENDPATH**/ ?>