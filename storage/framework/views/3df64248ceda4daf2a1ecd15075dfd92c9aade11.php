                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>


                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="accounts[0][id]" <?php endif; ?> value="<?php echo e(isset($account) ? $account->getId() : 0); ?>">



                    <div class="col-2">
                        <label class="form-label font-weight-bold "><?php echo e(__('Account Number')); ?>

						<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input required placeholder="<?php echo e(__('Account Number')); ?>" type="text" class="form-control  exclude-text" <?php if($isRepeater): ?> name="account_number" <?php else: ?> name="accounts[0][account_number]" <?php endif; ?> value="<?php echo e(isset($account) ? $account->getAccountNumber() : old('account_number')); ?>">
                            </div>
                        </div>
                    </div>

                   

                    <div 
					 
					
					class="col-2"
			
					>
                        <label class="form-label font-weight-bold"><?php echo e(__('IBAN')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="iban" <?php else: ?> name="accounts[0][iban]" <?php endif; ?> type="text" class="form-control " value="<?php echo e(isset($account) ? $account->getIban() : old('iban','')); ?>">
                            </div>
                        </div>
                    </div>



                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Balance Amount')); ?>

						<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="<?php echo e(number_format(isset($account) ? $account->getBalanceAmount() : old('balance_amount',0))); ?>">
                                <input type="hidden" value="<?php echo e((isset($account) ? $account->getBalanceAmount() : old('balance_amount',0))); ?>" <?php if($isRepeater): ?> name="balance_amount" <?php else: ?> name="accounts[0][balance_amount]" <?php endif; ?>>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-1">
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['value' => isset($model) ? $model->getBalanceDate() : null,'label' => __('Balance Date'),'id' => 'balance_date','name' => 'balance_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getBalanceDate() : null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Balance Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('balance_date'),'name' => 'balance_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>
					
					
					
		
								


                    <div class="col-1">
                        <label><?php echo e(__('Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                        <div class="input-group">
                            <select required <?php if($isRepeater): ?> name="currency" <?php else: ?> name="accounts[0][currency]" <?php endif; ?> class="form-control repeater-select">
                                <option selected><?php echo e(__('Select')); ?></option>
                                <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($currencyName); ?>" <?php if(isset($account) && $account->getCurrency() == $currencyName ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-1">
                        <label class="form-label font-weight-bold"><?php echo e(__('Exchange Rate')); ?>

						<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="exchange_rate" <?php else: ?> name="accounts[0][exchange_rate]" <?php endif; ?> type="text" class="form-control " value="<?php echo e(number_format(isset($account) ? $account->getExchangeRate() : old('exchange_rate',1))); ?>">
                            </div>
                        </div>
                    </div>




                    <div class="col-1">
                        <label class="form-label font-weight-bold"><?php echo e(__('Interest Rate')); ?>

						<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="interest_rate" <?php else: ?> name="accounts[0][interest_rate]" <?php endif; ?> type="text" class="form-control " value="<?php echo e(number_format(isset($account) ? $account->getInterestRate() : old('interest_rate',0))); ?>">
                            </div>
                        </div>
                    </div>


                    <div class="col-1">
                        <label class="form-label font-weight-bold"><?php echo e(__('Min Balance')); ?>

						
						<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="<?php echo e(number_format(isset($account) ? $account->getMinBalance() : old('min_balance',0))); ?>">
                                <input type="hidden" value="<?php echo e((isset($account) ? $account->getMinBalance() : old('min_balance',0))); ?>" <?php if($isRepeater): ?> name="min_balance" <?php else: ?> name="accounts[0][min_balance]" <?php endif; ?>>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/financial-institution/repeater.blade.php ENDPATH**/ ?>