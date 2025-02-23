
                                            <div class="col-md-4">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => 'freelancer-expenses','addNewModalModalName' => 'Position','addNewModalModalTitle' => __('Position'),'isSelect2' => false,'options' => $positions,'addNew' => false,'label' => __('Position'),'class' => '\'\'','dataFilterType' => ''.e($type).'','all' => false,'name' => 'freelancer_position_id','id' => ''.e($type.'_'.'freelancer_position_id').'','selectedValue' => isset($freelancerExpense) ? $freelancerExpense->getPositionId(): 0 ]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('freelancer-expenses'),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Position'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position')),'is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($positions),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Position')),'class' => '\'\'','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'freelancer_position_id','id' => ''.e($type.'_'.'freelancer_position_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($freelancerExpense) ? $freelancerExpense->getPositionId(): 0 )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                            </div>
                                           <div class="col-md-2">
                                               <label class="form-label font-weight-bold"><?php echo e(__('As % Of Price')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control only-percentage-allowed freelancer-total-cost-calculations-class percentage-summation" name="freelancer_percentage" value="<?php echo e(isset($freelancerExpense) ? $freelancerExpense->getFreelancerPercentageOfPrice() : old('freelancer_percentage',0)); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 

                                           <div class="col-md-2">
                                               <label class="form-label font-weight-bold"><?php echo e(__('Working Days')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control only-greater-than-zero-allowed freelancer-total-cost-calculations-class " name="freelancer_working_days" value="<?php echo e(isset($freelancerExpense) ? $freelancerExpense->getWorkingDays() : old('freelancer_working_days',0)); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 

                                                 <div class="col-md-2">
                                                      <label class="form-label font-weight-bold"><?php echo e(__('Cost Per Day')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control only-greater-than-zero-allowed freelancer-total-cost-calculations-class " name="freelancer_cost_per_day" value="<?php echo e(isset($freelancerExpense) ? $freelancerExpense->getCostPerDay() : old('freelancer_cost_per_day',0)); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 



                                                   <div class="col-md-2">
                                                      <label class="form-label font-weight-bold"><?php echo e(__('Total Cost')); ?> </label>
                                                    <div class="kt-input-icon">
                                                        <div class="input-group">
                                                            <input id="tetsid" readonly  class="form-control disabled-custom total-cost-summation" name="freelancer_total_cost" value="<?php echo e(isset($freelancerExpense) ? $freelancerExpense->getTotalCost() : old('freelancer_total_cost',0)); ?>"  step="any" >
                                                        </div>
                                                    </div>
                                                </div> 
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/quick-pricing-calculator/form/freelancer-expense.blade.php ENDPATH**/ ?>