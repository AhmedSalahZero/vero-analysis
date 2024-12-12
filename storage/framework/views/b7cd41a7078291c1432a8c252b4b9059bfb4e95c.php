<div class="modal fade " id="<?php echo e('forecast-'.convertStringToClass($type)); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">


            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"> <?php echo e(__(ucwords(str_replace('_',' ',$type)))  . ' ' . __('- Next Three Months Forecast')); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
						
                            <tr>


                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Item Name')); ?></th>
                                
								<?php
									$index = 0 ;
								?>
								<?php $__currentLoopData = $simpleLinearRegressionDatesForAllTypes[$type]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $simpleLinearRegressionDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="text-center w-15-percentage text-capitalize th-main-color"> <?php echo e(\Carbon\Carbon::make($simpleLinearRegressionDate)->format('d-m-Y')); ?> 
								<br>
								<?php if($index==0): ?>
								<?php echo e(__('Actual')); ?>

								<?php else: ?>
								<?php echo e(__('Forecast')); ?>

								
								<?php endif; ?> 
								</th>
						
						<?php
							$index++ ;
						?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								
								


                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $total = 0 ;
							$totalInMainFunctionalCurrency = 0 ;

                            ?>
                            <?php $__currentLoopData = $simpleLinearRegressionForAllTypes[$type]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameAndValues): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($name != 'total'): ?>
                            <tr>
                                <td class="w-40-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" step="0.1" class="form-control ignore-global-style" value="<?php echo e($name); ?>">
                                        </div>
                                    </div>
                                </td>
							
							<?php $__currentLoopData = $simpleLinearRegressionDatesForAllTypes[$type]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$value = $simpleLinearRegressionForAllTypes[$type][$name][$date] ?? 0 ;
							?>
                                <td class="w-10-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
										
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(is_numeric($value) ?  number_format($value) : $value); ?>">
                                        </div>
                                    </div>
                                </td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 


                              

                            </tr>
							<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
					
                        <tr>
                                <td>
								<?php echo e(__('Total')); ?>

                                </td>

							<?php $__currentLoopData = $simpleLinearRegressionDatesForAllTypes[$type]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
								<?php echo e(number_format($simpleLinearRegressionForAllTypes[$type]['total'][$date]??0)); ?>

                                </td>
								
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


								
								
							
							
                              


                            </tr>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/home_dashboard/_forecast-modal.blade.php ENDPATH**/ ?>