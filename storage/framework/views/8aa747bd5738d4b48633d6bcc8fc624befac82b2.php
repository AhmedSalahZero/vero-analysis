
					
					
						<tr class="edit-info-row add-sub maintable-1-row-class<?php echo e($rowIndex); ?> is-sub-row d-none">
                                            <td class=" reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize is-close "></td>
                                            <td class="sub-text-bg max-w-classes-name is-name-cell ">
											<div class="ml-son">
											<?php echo e($currentSubRowKeyName); ?>

											</div>
											
											
											</td>
                                            <td class="sub-text-bg"></td>
                                            
                                             <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekAndYear => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											 <?php
											 	$currentValue = $result[$mainReportKey][$parentKeyName][$currentSubRowKeyName]['weeks'][$weekAndYear] ?? 0;
												if($currentSubRowKeyName == 'Suppliers Past Due Invoices' )
												{
													$startDate = $dates[$weekAndYear]['start_date'] ;
													$currentRow = $supplierDueInvoices->where('week_start_date',$startDate)->first() ;
													$currentValue =$currentRow ?  $currentRow->amount : 0;
												}
											 ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentValue)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php
												$currentSubTotal = $result[$mainReportKey][$parentKeyName][$currentSubRowKeyName]['total'] ?? 0 ;
												$currentSubTotal = is_array($currentSubTotal) ? 0 : $currentSubTotal;
											?>
                                    <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentSubTotal)); ?></td>
											
                                        
                        </tr>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/cash-flow-sub-row.blade.php ENDPATH**/ ?>