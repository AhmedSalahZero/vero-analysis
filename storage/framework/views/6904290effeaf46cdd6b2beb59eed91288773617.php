

<div class="modal fade " id="<?php echo e($modalId.$currency); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
								
                                <th class="text-center w-50-percentage text-capitalize th-main-color"><?php echo e(__('Financial Institution')); ?></th>
                           
                                <th class="text-center  text-capitalize th-main-color"> <?php echo __('Limit'); ?> </th>
                                <th class="text-center  text-capitalize th-main-color"> <?php echo __('Outstanding'); ?> </th>
                                <th class="text-center  text-capitalize th-main-color"> <?php echo __('Room'); ?> </th>
                                <th class="text-center  text-capitalize th-main-color"> <?php echo __('Cash Cover'); ?> </th>
								
							
                            
                            </tr>
                        </thead>
                        <tbody>
						
							<?php
								$totals = [] ;
								
							?>
                            <?php $__currentLoopData = $detailItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							
                       
                            <tr>
                               
					
                                <td class="w-50-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="<?php echo e(isset($detailItem['branch_name']) ? $detailItem['branch_name'] : $detailItem['financial_institution_name']); ?>">
                                        </div>
                                    </div>
                                </td>
								<?php $__currentLoopData = ['limit','outstanding_balance','room','cash_cover']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td >
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($detailItem[$colName])); ?>">
											<?php
												$totals[$colName]= isset($totals[$colName]) ? $totals[$colName] +  $detailItem[$colName] : $detailItem[$colName] ;
											?>
                                        </div>
                                    </div>
                                </td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                              
								
								
								    
								

                            

                            </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 <tr>
						 	<td>
							
							</td>
							
							
							
							<?php $__currentLoopData = ['limit','outstanding_balance','room','cash_cover']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<td class="text-center">
							
							<?php echo e(number_format($totals[$colName])); ?>

							</td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
							
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/lg-lc-details.blade.php ENDPATH**/ ?>