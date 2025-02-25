<div class="modal fade " id="<?php echo e($currentModalId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="<?php echo e(route('calculate.spread.rate.sensitivity',['company'=>$company->id,'study'=>$study->id])); ?>" class="modal-content" method="post">


            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"> <?php echo e($currentModalTitle); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center w-30-percentage text-capitalize th-main-color align-middle"><?php echo e(__('Revenue Stream')); ?></th>
                                <th class="text-center w-50-percentage text-capitalize th-main-color align-middle"><?php echo e(__('Name')); ?></th>
                                <th class="text-center w-10-percentage text-capitalize th-main-color align-middle"><?php echo e(__('Spread Rate')); ?></th>
                                <th class="text-center w-10-percentage text-capitalize th-main-color align-middle"><?php echo e(__('Sensitivity Spread Rate')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

							<?php $__currentLoopData = ['leasingRevenueStreamBreakdown','reverseFactoringBreakdowns','ijaraMortgageBreakdowns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relationName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$revenueStreamTitle = \App\Models\NonBankingService\Study::getTitleForBreakdown($relationName);
							?>
							<?php $__currentLoopData = $study->{$relationName}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$currentLeasingRevenueStreamBreakdown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$name = $currentLeasingRevenueStreamBreakdown->getReviewForTable();
								$id = $currentLeasingRevenueStreamBreakdown->id ;
								$marginRate = $currentLeasingRevenueStreamBreakdown->getMarginRate() ;
								$sensitivityMarginRate = $currentLeasingRevenueStreamBreakdown->getSensitivityMarginRate() ;
								$isMarginRateEqualToSensitivityMarginRate = $marginRate == $sensitivityMarginRate ;
							?>
                            <tr>
                                <td class="w-30-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" step="0.1" class="form-control ignore-global-style" value="<?php echo e($revenueStreamTitle); ?>">
                                        </div>
                                    </div>
                                </td> <td class="w-50-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" step="0.1" class="form-control ignore-global-style
											
											<?php if(!$isMarginRateEqualToSensitivityMarginRate): ?>
												bg-green text-white												
												<?php endif; ?> 
												
											" value="<?php echo e($name); ?>">
                                        </div>
                                    </div>
                                </td>

                                     
                                <td class="w-10-percentage">
                                    <div class="d-flex align-items-center ">
                                        <div class="kt-input-icon ml-2 ">
                                            <div class="input-group">
                                                <input readonly type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($marginRate,2) . ' %'); ?>">
                                            </div>
                                        </div>
                                    </div>

                                </td>
								
								<td class="w-10-percentage">
                                    <div class="d-flex align-items-center ">
                                        <div class="kt-input-icon ml-2 ">
                                            <div class="input-group">
                                                <input name="sensitivity_margin_rate[<?php echo e($relationName); ?>][<?php echo e($id); ?>]" type="text" class="form-control text-center ignore-global-style
												
												" value="<?php echo e(number_format($sensitivityMarginRate,2)); ?>">
                                            </div>
                                        </div>
                                    </div>

                                </td>





                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary 
				
				" 
				
				><?php echo e(__('Calculate')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/_spread-rate-sensitivity-modal.blade.php ENDPATH**/ ?>