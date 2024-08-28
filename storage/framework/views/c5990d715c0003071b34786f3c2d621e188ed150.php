
					
					 <tr class=" <?php if($customerName == __('Total Cash Inflow') || $customerName == __('Total Cash Outflow') ||  $customerName == __('Total Cash')): ?> bg-lighter <?php else: ?>  <?php endif; ?>  parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   " data-model-id="<?php echo e($rowIndex); ?>">
                                    <td class="red reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize main-tr is-close"> <?php if($hasSubRows): ?> + <?php endif; ?>  </td>
                                    <td class="sub-text-bg   editable-text  max-w-classes-name is-name-cell "><?php echo e($customerName); ?></td>
                                    <td class="  sub-numeric-bg text-center editable-date"> 
										<?php if($customerName == __('Customers Past Due Invoices')): ?>
										<button   class="btn btn-sm btn-warning text-white js-show-customer-due-invoices-modal"><?php echo e(__('View')); ?></button>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.due-invoices','data' => ['reportInterval' => $reportInterval,'currentInvoiceType' => 'CustomerInvoice','dates' => $dates,'weeks' => $weeks,'pastDueCustomerInvoices' => $pastDueCustomerInvoices,'id' => 'test-modal-id']]); ?>
<?php $component->withName('modal.due-invoices'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['report-interval' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($reportInterval),'currentInvoiceType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CustomerInvoice'),'dates' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dates),'weeks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($weeks),'pastDueCustomerInvoices' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pastDueCustomerInvoices),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
										
										<?php endif; ?> 
										
											
										
										
									
									 </td>
									 <?php
											$customerPastDueInvoicesTotal=0; 
									 ?>
                                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekAndYear => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
								
									$year = explode('-',$weekAndYear)[1];
									
                                    $currentValue = 0 ;
										$currentMainRowTotal = $result[$mainReportKey][$parentKeyName]['total']['total_of_total']??0;
									if(isset($result[$mainReportKey][$parentKeyName]['weeks'][$weekAndYear]))
									{
										$currentValue = $result[$mainReportKey][$parentKeyName]['weeks'][$weekAndYear];
									}
									if(isset($isTotalRow) && isset($result[$mainReportKey][$parentKeyName]['total'][$weekAndYear])){
										$currentValue = $result[$mainReportKey][$parentKeyName]['total'][$weekAndYear];
									}
									if($customerName == __('Customers Past Due Invoices') )
									{
										$startDate = $dates[$weekAndYear]['start_date'] ;
										$currentRow = $customerDueInvoices->where('week_start_date',$startDate)->first() ;
										$currentValue =$currentRow ?  $currentRow->amount : 0;
										$customerPastDueInvoicesTotal +=$currentValue; 
									
									}
                                    ?>
									
                                    <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentValue,0)); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									
                                   
                                    <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format(  $currentMainRowTotal )); ?>  </td>

                                </tr>
								
				
					
					<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/cash-flow-main-row.blade.php ENDPATH**/ ?>