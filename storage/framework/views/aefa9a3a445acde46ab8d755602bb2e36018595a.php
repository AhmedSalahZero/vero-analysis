                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>


                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                                <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="opening[0][id]" <?php endif; ?> value="<?php echo e(isset($receivable_and_payment) ? $receivable_and_payment->getId() : 0); ?>">



                    <div class="col-2">
                        <label class="form-label font-weight-bold "><?php echo e(__('Name')); ?>

                            
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control  exclude-text" <?php if($isRepeater): ?> name="receivable_name" <?php else: ?> name="opening[0][receivable_name]" <?php endif; ?> value="<?php echo e(isset($receivable_and_payment) ? $receivable_and_payment->getName() : old('receivable_name')); ?>">
                                <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="old_receivable_name" <?php else: ?> name="opening[0][old_receivable_name]" <?php endif; ?> value="<?php echo e(isset($receivable_and_payment) ? $receivable_and_payment->getName() : old('old_receivable_name')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <label class="form-label font-weight-bold"><?php echo e(__('Balance')); ?>

                            
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater"  value="<?php echo e(number_format(isset($receivable_and_payment) ? $receivable_and_payment->getBalanceAmount() : old('balance_amount',0))); ?>">
								<input type="hidden" value="<?php echo e((isset($receivable_and_payment) ? $receivable_and_payment->getBalanceAmount() : old('balance_amount',0))); ?>" <?php if($isRepeater): ?> name="balance_amount" <?php else: ?> name="opening[0][balance_amount]" <?php endif; ?>>
                            </div>
                        </div>
                    </div>
				
                    <?php $__currentLoopData = $datesFormatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex => $dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<input type="hidden" name="dates" value="<?php echo e($dateAsIndex); ?>">
                    <div class="col-1 text-center">
                        <label class="form-label font-weight-bold"><?php echo e(formatDateForView($dateAsString)); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed date-value-element trigger-change-repeater"  value="<?php echo e(number_format(isset($receivable_and_payment) ? $receivable_and_payment->getReceivableValueAtDate($dateAsIndex) : old('payload',0) )); ?>" step="0.5">
								<input class="date-value-element-hidden" type="hidden" <?php if($isRepeater): ?> name="payload[<?php echo e($dateAsIndex); ?>]" <?php else: ?> name="opening[0][payload][<?php echo e($dateAsIndex); ?>]" <?php endif; ?> value="<?php echo e((isset($receivable_and_payment) ? $receivable_and_payment->getReceivableValueAtDate($dateAsIndex) : old('balance_amount',0))); ?>" >
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-1 text-center receivable_total_parent">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input readonly type="text" class="form-control date-element-total-input only-greater-than-or-equal-zero-allowed trigger-change-repeater" <?php if($isRepeater): ?> name="receivable_total" <?php else: ?> name="opening[0][receivable_total]" <?php endif; ?> value="0" step="0.5">
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/cash-flow-statement/cash-opening-balance/repeater.blade.php ENDPATH**/ ?>