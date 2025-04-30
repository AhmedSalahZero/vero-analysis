<style>
@media (min-width: 1400px) {
    .modal-dialog.modal-xl {
        max-width: 1499px;
    }
	}
</style>

<div class="modal fade " id="<?php echo e($modalId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
								
                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Date')); ?>

								<?php echo e(count($detailItems['dates'])); ?>

								
								</th>
					
                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('Value')); ?></th>
								
                            
                            </tr>
                        </thead>
                        <tbody>
						
							
							
							
										
                            <?php $__currentLoopData = $detailItems['dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
                       
                            <tr>
                                <td class="w-40-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="<?php echo e($date); ?>">
                                        </div>
                                    </div>
                                </td>
						
                                <td class="w-15-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($value)); ?>">
                                        </div>
                                    </div>
                                </td>
						

                            </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/modals/avg-min-max-outliers-date-value-modals.blade.php ENDPATH**/ ?>