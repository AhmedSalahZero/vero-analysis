

<div class="modal fade " id="<?php echo e($currency); ?>-past-due-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
								
                                <th class="text-center  text-capitalize th-main-color"><?php echo e(__('Date')); ?></th>
                                <th class="text-center  text-capitalize th-main-color"><?php echo e(__('Schedule Payment')); ?></th>
                                <th class="text-center text-capitalize th-main-color"> <?php echo __('Past Due'); ?> </th>
								
							
                            
                            </tr>
                        </thead>
                        <tbody>
						
							<?php
								$total = 0 ;
								
								
							?>
                            <?php $__currentLoopData = $detailItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							
                       
                            <tr>
                               
					
                                <td >
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="<?php echo e(\Carbon\Carbon::make($detailItem['date'])->format('d-m-Y')); ?>">
                                        </div>
                                    </div>
                                </td>
								
								 <td >
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($detailItem['schedule_payment'])); ?>">
                                        </div>
                                    </div>
                                </td>
								

                                <td >
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($detailItem['remaining'])); ?>">
											<?php
											//	$total +=$detailItem['amount'];
											?>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/details-loan-past-dues-modal.blade.php ENDPATH**/ ?>