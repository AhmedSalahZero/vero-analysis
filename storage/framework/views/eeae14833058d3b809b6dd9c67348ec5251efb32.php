<style>
@media (min-width: 1400px) {
    .modal-dialog.modal-xl {
        max-width: 1499px;
    }
	}
</style>

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
								
                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Name')); ?></th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('Total')); ?></th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('% Of Total')); ?></th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('% Of Sales')); ?></th>
								
                            
                            </tr>
                        </thead>
                        <tbody>
						
							<?php
								$total = 0 ;
								
								
							?>
						
                            <?php $__currentLoopData = $subItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemName => $itemArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($subItemName == 'Total' || $subItemName == 'Growth Rate %'): ?>
							<?php continue; ?>
							<?php endif; ?> 
							
							
                       
                            <tr>
                               
					
                                <td class="w-40-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="<?php echo e($subItemName); ?>">
                                        </div>
                                    </div>
                                </td>
								
								<?php
									$currentTotal = array_sum($itemArr['Avg. Prices'] ?? []);
									$percentageOfTotal = $cardTotal ? $currentTotal / $cardTotal * 100  : 0 ; 
									$percentageOfSales = $totalSales ? $currentTotal / $totalSales * 100  : 0 ; 
									$chartData['pie'][$name][] = ['name'=>$subItemName , 'value'=>$currentTotal];
								?>
								 <td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($currentTotal)); ?>">
                                        </div>
                                    </div>
                                </td>
								
								
								<td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($percentageOfTotal,2) . ' %'); ?>">
                                        </div>
                                    </div>
                                </td>
								
								
								<td class="w-20-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($percentageOfSales,2) . ' %'); ?>">
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/expense_modal.blade.php ENDPATH**/ ?>