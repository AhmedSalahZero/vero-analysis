                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>


                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="accounts[0][id]" <?php endif; ?> value="<?php echo e(isset($accountInterest) ? $accountInterest->getId() : 0); ?>">












  					 <div class="col-md-2">
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['classes' => $index == 0 ? 'first-interest-rate-js':'','value' => $accountInterest->getStartDateForSelect(),'label' => __('Interest Calculation Start Date'),'id' => 'start_date','name' => 'start_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index == 0 ? 'first-interest-rate-js':''),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountInterest->getStartDateForSelect()),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Interest Calculation Start Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date'),'name' => 'start_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>




                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Interest Rate')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="interest_rate" <?php else: ?> name="accounts[0][interest_rate]" <?php endif; ?> type="text" class="form-control " value="<?php echo e(number_format(isset($accountInterest) ? $accountInterest->getInterestRate() : old('interest_rate',0))); ?>">
                            </div>
                        </div>
                    </div>


                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Min Balance')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="<?php echo e(number_format(isset($accountInterest) ? $accountInterest->getMinBalance() : old('min_balance',0))); ?>">
                                <input type="hidden" value="<?php echo e((isset($accountInterest) ? $accountInterest->getMinBalance() : old('min_balance',0))); ?>" <?php if($isRepeater): ?> name="min_balance" <?php else: ?> name="accounts[0][min_balance]" <?php endif; ?>>
                            </div>
                        </div>
                    </div>

                 


                    <?php if($isRepeater): ?>
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                    <?php endif; ?>


                </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/financial-institution-account/repeater.blade.php ENDPATH**/ ?>