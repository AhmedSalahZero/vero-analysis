<?php $attributes = $attributes->exceptProps([
'id',
'pastDueCustomerInvoices',
'weeks',
'dates',
'currentInvoiceType',
'reportInterval'
]); ?>
<?php foreach (array_filter(([
'id',
'pastDueCustomerInvoices',
'weeks',
'dates',
'currentInvoiceType',
'reportInterval'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>


<div class="modal fade modal-item-js" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="<?php echo e(route('adjust.customer.dues.invoices',['company'=>$company->id])); ?>" class="modal-content" method="post">
		
								
		<?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"><?php echo e($currentInvoiceType == 'CustomerInvoice' ?  __('Customer Past Due Invoices') :  __('Supplier Past Due Invoices')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo e($currentInvoiceType == 'CustomerInvoice' ? __('Customer Name') : __('Supplier Name')); ?></th>
                                <th class="text-center"><?php echo e(__('Invoice No.')); ?></th>
                                <th class="text-center"> <?php echo __('Net <br> Balance'); ?> </th>
                                <th class="text-center"><?php echo e(__('Due Date')); ?></th>
                                <th class="text-center"> <?php echo __('Collection <br> Percentage'); ?> </th>
                                <th class="text-center"> <?php echo __('Collection <br> Date'); ?> </th>
                            </tr>
                        </thead>
                        <tbody>
						
							<?php
								$totalNetBalance = 0 ;
								
								$allIds = $pastDueCustomerInvoices->pluck('id')->toArray() ;
								$dueInvoiceRow = \DB::table('weekly_cashflow_custom_due_invoices')->where('invoice_type',$currentInvoiceType)->where('company_id',$company->id)->whereIn('invoice_id',$allIds)->get();
								
							?>
                            <?php $__currentLoopData = $pastDueCustomerInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pastDueCustomerInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								if($pastDueCustomerInvoice->net_balance_until_date <= 0 ){
									continue;
								}
								$row = $dueInvoiceRow->where('invoice_id',$pastDueCustomerInvoice->id)->first();
								
							?>
                            <input type="hidden" name="customer_invoice_id[]" value="<?php echo e($pastDueCustomerInvoice->id); ?>">
											<input type="hidden" name="invoice_amount[<?php echo e($pastDueCustomerInvoice->id); ?>]"  value="<?php echo e($pastDueCustomerInvoice->net_balance_until_date); ?>">
											<input type="hidden" name="invoiceType" value="<?php echo e($currentInvoiceType); ?>">

                            <tr>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="numeric" step="0.1" class="form-control" value="<?php echo e($pastDueCustomerInvoice->getName()); ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="<?php echo e($pastDueCustomerInvoice->invoice_number); ?>">
                                        </div>
                                    </div>
                                </td>


                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="<?php echo e(number_format($pastDueCustomerInvoice->net_balance_until_date)); ?>">
											<?php
												$totalNetBalance +=$pastDueCustomerInvoice->net_balance_until_date; 
											?>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="<?php echo e($pastDueCustomerInvoice->invoice_due_date); ?>">
                                        </div>
                                    </div>
                                </td>
								
								
								            <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="text" name="percentage[<?php echo e($pastDueCustomerInvoice->id); ?>]" class="form-control text-center only-percentage-allowed" value="<?php echo e($row ? $row->percentage : 100); ?>">
                                        </div>
                                    </div>
                                </td>
								

                                <td>
                                    <select class="form-control" name="week_start_date[<?php echo e($pastDueCustomerInvoice->id); ?>]">
									
                                      <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekDate => $weekNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <?php
										$startDate = $dates[$weekDate]['start_date'] ;
									 	$title = __('Week ') . ' ' . $weekNo  . ' ( ' . $dates[$weekDate]['start_date'] . ' - ' . $dates[$weekDate]['end_date'] . ' )';
										if($reportInterval == 'daily'){
											$title  = $dates[$weekDate]['start_date'] ;
										}
										elseif($reportInterval == 'monthly'){
											$title = $dates[$weekDate]['end_date'] ;
										}
									  ?>
									
									  <option <?php if($row && $row->week_start_date == $startDate ): ?> selected <?php endif; ?>  class="text-center" value="<?php echo e($startDate); ?>"> <?php echo e($title); ?>   </option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </td>

                            </tr>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 <tr>
						 	<td>
							
							</td>
							
							<td>
								<?php echo e(__('Total Past Dues')); ?>

							</td>
							<td>
							
							<?php echo e(number_format($totalNetBalance)); ?>

							</td>
							<td>
							</td>
							
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
                <button type="button" class="btn btn-primary submit-form-btn"
				 
				 
				 ><?php echo e(__('Save')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/modal/due-invoices.blade.php ENDPATH**/ ?>