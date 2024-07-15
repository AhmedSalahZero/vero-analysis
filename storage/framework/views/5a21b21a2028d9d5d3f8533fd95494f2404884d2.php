

<div class="modal fade " id="<?php echo e($modalId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">
		
								
		<?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"> <?php echo e($title); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
							
								
                                <th class="text-center w-60-percentage"><?php echo e(__('Financial Insitution / Branch Name')); ?></th>
                                <th class="text-center w-20-percentage"><?php echo e(__('Account Number')); ?></th>
                                <th class="text-center w-20-percentage"> <?php echo __('Amount'); ?> </th>
								
							
                            
                            </tr>
                        </thead>
                        <tbody>
						
							<?php
								$total = 0 ;
								
								
							?>
                            <?php $__currentLoopData = $detailItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							
                       
                            <tr>
                               
					
                                <td class="w-60-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left" value="<?php echo e(isset($detailItem['branch_name']) ? $detailItem['branch_name'] : $detailItem['financial_institution_name']); ?>">
                                        </div>
                                    </div>
                                </td>
								
								 <td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="<?php echo e($detailItem['account_number'] ?? '-'); ?>">
                                        </div>
                                    </div>
                                </td>
								

                                <td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="<?php echo e(number_format($detailItem['amount'])); ?>">
											<?php
												$total +=$detailItem['amount'];
											?>
                                        </div>
                                    </div>
                                </td>

                              
								
								
								    
								

                            

                            </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 <tr>
						 	<td>
							
							</td>
							
							
							<td>
							
							</td>
							<td class="text-center">
							
							<?php echo e(number_format($total)); ?>

							</td>
						
							
						 </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary 
				
				"
				 data-dismiss="modal"
				 
				 ><?php echo e(__('Close')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\veroo\resources\views/admin/dashboard/details_cash_in_safe_modal.blade.php ENDPATH**/ ?>