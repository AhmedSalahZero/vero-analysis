<div class="modal fade " id="<?php echo e($currentModalId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">


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


                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('Expense Name')); ?></th>
                             
							
								<?php $__currentLoopData = $yearWithItsIndexes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentYearIndex=> $monthInfos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<th class="text-center 
								
								 text-capitalize th-main-color">
								<?php echo e($yearIndexWithYear[$currentYearIndex]); ?>

								</th>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								
								


                            </tr>
                        </thead>
                        <tbody>

						
                            <?php $__currentLoopData = $modalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expenseName => $expenseWithYearIndexAndValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($expenseName == 'total'): ?>
							<?php continue; ?>;
							<?php endif; ?> 
                            <tr>
                                <td class="w-20-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" step="0.1" class="form-control ignore-global-style" value="<?php echo e($expenseName); ?>">
                                        </div>
                                    </div>
                                </td>
						
							<?php $__currentLoopData = $yearWithItsIndexes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentYearIndex => $monthInfos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$currentExpenseValue = $expenseWithYearIndexAndValue[$currentYearIndex]??0 ;
								$currentSalesRevenue = $formattedResult['sales_revenue'][$currentYearIndex]??0;
								$currentPercentageOfSales = $currentSalesRevenue ?  $currentExpenseValue /  $currentSalesRevenue * 100 : 0;
							?>
                                <td class="
								
								">
                                    <div class="d-flex align-items-center ">
									<div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($currentExpenseValue/1000000,2)); ?>">
                                        </div>
                                    </div>
									
									 <div class="kt-input-icon ml-2 ">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($currentPercentageOfSales,2) . ' %'); ?>">
                                        </div>
                                    </div>
									</div>
									
                                </td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
		


                              

                            </tr>
							
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
							
					
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary 
				
				" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/dashboard/_expense-modal.blade.php ENDPATH**/ ?>