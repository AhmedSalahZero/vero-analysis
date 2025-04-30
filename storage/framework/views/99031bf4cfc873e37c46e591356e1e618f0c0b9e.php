<?php
	use App\Helpers\HMath;
	use App\Helpers\HArr;
	use MathPHP\Statistics\Average;

?>
<style>
@media (min-width: 1400px) {
    .modal-dialog.modal-xl {
        max-width: 1499px;
    }
	}
</style>
<?php
								$salesChange = count($monthlySalesForSalesGathering) ?  Average::mean($monthlySalesForSalesGathering) : 0;
							?>
<div class="modal fade " id="<?php echo e($modalId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">
		
								
		<?php echo csrf_field(); ?>
            <div class="modal-header">
				<div class="d-flex flex-column " >
				
                <h5 class="modal-title mb-3" style="color:#0741A5 !important" id="exampleModalLongTitle"> <?php echo e($title); ?> <br> </h5> 
								 <h5 class="modal-title text-left" style="color:red !important" id="exampleModalLongTitle"> <?php echo e(__('For Each Incremental Sales Of '.number_format($salesChange))); ?></h5>
				</div>

				

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
								
                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Name')); ?> </th>
								
                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Fixed / Variable')); ?></th>
                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Expense Change Value')); ?></th>
							
                            
                            </tr>
                        </thead>
                        <tbody>
							<?php
								$currentSubItemsAndExpenseChange =[];
							?>
							<?php $__currentLoopData = $detailItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSubItemName => $coefficientCorrelationValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$expenseItemsValues = $result['report_data'][$mainCategoriesName][$currentSubItemName]['Avg. Prices'] ?? [];
								$currentTextBasedOnCorrelationValue = HMath::generateTextBasedOnCoefficientCorrelationValue($coefficientCorrelationValue);
								
								$expenseChange = count($monthlySalesForSalesGathering) ? HMath::calculateIncreaseInExpensePerSalesValue($coefficientCorrelationValue,$expenseItemsValues,$monthlySalesForSalesGathering,$salesChange) : 0;
								if(HMath::isFixedExpense($coefficientCorrelationValue)){
									$expenseChange = Average::mean($expenseItemsValues);
								}
								$currentSubItemsAndExpenseChange[$currentSubItemName] = [
									'value'=>$expenseChange ,
									'text'=>$currentTextBasedOnCorrelationValue
								] ;
							?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
							<?php
							$currentSubItemsAndExpenseChange = HArr::sortTwoDimArrayAndPreserveKeyNameBasedOnKeyDesc($currentSubItemsAndExpenseChange,'value');
								
							?>
                            <?php $__currentLoopData = $currentSubItemsAndExpenseChange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSubItemName => $expenseChangeTextAndValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$currentTextBasedOnCorrelationValue = $expenseChangeTextAndValue['text'];
							$expenseChange = $expenseChangeTextAndValue['value'];
						?>
                            <tr>
                                <td class="w-40-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-left ignore-global-style" value="<?php echo e($currentSubItemName); ?>">
                                        </div>
                                    </div>
                                </td>
						
                                <td class="w-15-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control ignore-global-style text-left" value="<?php echo e($currentTextBasedOnCorrelationValue); ?>">
                                        </div>
                                    </div>
                                </td>
								
								
								  <td class="w-15-percentage">
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($expenseChange)); ?>">
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/modals/r-modals.blade.php ENDPATH**/ ?>