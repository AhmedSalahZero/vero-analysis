                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>


                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="termAndConditions[0][id]" <?php endif; ?> value="<?php echo e(isset($termAndCondition) ? $termAndCondition->id : 0); ?>">



					
                    <div class="col-lg-2">
                        <label><?php echo e(__('Select LG Type')); ?> <span class="required">*</span></label>
                        <div class="input-group">
                            <select <?php if($isRepeater): ?> name="lg_type" <?php else: ?> name="termAndConditions[0][lg_type]" <?php endif; ?> class="form-control repeater-select">
                                <option selected><?php echo e(__('Select')); ?></option>
                                <?php $__currentLoopData = getLgTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($name); ?>" <?php if(isset($termAndCondition) && $termAndCondition->getLgType() == $name ): ?> selected <?php endif; ?> > <?php echo e($nameFormatted); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>



                    <div class="col-2">
                        <label class="form-label font-weight-bold "><?php echo e(__('Outstanding Balance')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input placeholder="<?php echo e(__('Outstanding Balance')); ?>" type="text" class="form-control only-greater-than-zero-allowed" <?php if($isRepeater): ?> name="outstanding_balance" <?php else: ?> name="termAndConditions[0][outstanding_balance]" <?php endif; ?> value="<?php echo e(isset($termAndCondition) ? $termAndCondition->getOutstandingBalance() : old('outstanding_balance')); ?>">
                            </div>
                        </div>
                    </div>
					
						  <div class="col-md-2">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Outstanding Date'),'required' => true,'model' => $termAndCondition??null,'name' => 'outstanding_date','placeholder' => __('Select Outstanding Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Outstanding Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($termAndCondition??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('outstanding_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Outstanding Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>



                
                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Cash Cover Rate (%) *')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="cash_cover_rate" <?php else: ?> name="termAndConditions[0][cash_cover_rate]" <?php endif; ?> type="text" class="form-control only-percentage-allowed
								
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->cash_cover_rate : old('cash_cover_rate',0))); ?>">
                            </div>
                        </div>
                    </div>
					
					  <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Commission Rate (%) *')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="commission_rate" <?php else: ?> name="termAndConditions[0][commission_rate]" <?php endif; ?> type="text" class="form-control only-percentage-allowed
								
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->commission_rate : old('commission_rate',0))); ?>">
                            </div>
                        </div>
                    </div>



					  <div class="col-lg-2">
                        <label><?php echo e(__('Commission Interval')); ?> <span class="required">*</span></label>
                        <div class="input-group">
                            <select <?php if($isRepeater): ?> name="commission_interval" <?php else: ?> name="termAndConditions[0][commission_interval]" <?php endif; ?> class="form-control repeater-select">
                                <option selected><?php echo e(__('Select')); ?></option>
                                <?php $__currentLoopData = getCommissionInterval(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($name); ?>" <?php if(isset($termAndCondition) && $termAndCondition->getCommissionInterval() == $name ): ?> selected <?php endif; ?> > <?php echo e($nameFormatted); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

















                    <?php if($isRepeater): ?>
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                    <?php endif; ?>


                </div>
<?php /**PATH C:\laragon\www\veroo\resources\views/reports/LetterOfCreditFacility/repeater.blade.php ENDPATH**/ ?>