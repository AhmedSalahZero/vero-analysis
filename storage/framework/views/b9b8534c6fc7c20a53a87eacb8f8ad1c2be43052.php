                <?php
                $isRepeater = !(isset($removeRepeater) && $removeRepeater) ;
                $type = 'create';
                ?>


                <div style="flex-wrap:nowrap;" <?php if($isRepeater): ?> data-repeater-item <?php endif; ?> class="form-group date-element-parent m-form__group row align-items-center 
                                         <?php if($isRepeater): ?>
                                         repeater_item
                                         <?php endif; ?> 
				                         ">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="infos[0][id]" <?php endif; ?> value="<?php echo e(isset($infos) ? $infos->getId() : 0); ?>">
                    <input type="hidden" class="form-control " <?php if($isRepeater): ?> name="id" <?php else: ?> name="infos[0][company_id]" <?php endif; ?> value="<?php echo e($company->id); ?>">
		


				 

                   



                   

                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Commercial Papers Due Within')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="for_commercial_papers_due_within_days" <?php else: ?> name="infos[0][for_commercial_papers_due_within_days]" <?php endif; ?> type="text" class="form-control 
								
								" value="<?php echo e((isset($infos) ? $infos->for_commercial_papers_due_within_days : old('for_commercial_papers_due_within_days',0))); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <label class="form-label font-weight-bold"><?php echo e(__('Lending Rate (%) *')); ?>

                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input <?php if($isRepeater): ?> name="lending_rate" <?php else: ?> name="infos[0][lending_rate]" <?php endif; ?> type="text" class="form-control only-percentage-allowed
						
								" value="<?php echo e((isset($infos) ? $infos->lending_rate : old('lending_rate',0))); ?>">
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
<?php /**PATH C:\laragon\www\veroo\resources\views/reports/overdraft-against-commercial-paper/repeater.blade.php ENDPATH**/ ?>