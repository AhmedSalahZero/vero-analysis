                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>

                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="outstandingBreakdowns[0][id]" <?php endif; ?> value="<?php echo e(isset($outstandingBreakdown) ? $outstandingBreakdown->getId() : 0); ?>">
                    <div class="col-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Amount')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="amount" <?php else: ?> name="outstandingBreakdowns[0][amount]" <?php endif; ?> type="text" class="form-control " value="<?php echo e(number_format(isset($outstandingBreakdown) ? $outstandingBreakdown->getAmount() : old('amount',0))); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($outstandingBreakdown)?$outstandingBreakdown->getSettlementDateForSelect():'','label' => __('Settlement Date'),'id' => 'settlement_date','name' => 'settlement_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($outstandingBreakdown)?$outstandingBreakdown->getSettlementDateForSelect():''),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Settlement Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('settlement_date'),'name' => 'settlement_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>






                    <?php if($isRepeater): ?>
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                    <?php endif; ?>


                </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/outstanding-breakdown/repeater.blade.php ENDPATH**/ ?>