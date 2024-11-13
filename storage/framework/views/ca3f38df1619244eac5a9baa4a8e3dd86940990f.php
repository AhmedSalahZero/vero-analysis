<?php $__env->startSection('css'); ?>
<?php
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived ;

?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
.width-17{
        max-width: initial !important;
        width: 17% !important;
        flex: initial !important;
    }
	
    label {
        text-align: left !important;
    }

 
    .width-8 {
        max-width: initial !important;
        width: 8% !important;
        flex: initial !important;
    }
.width-9 {
        max-width: initial !important;
        width: 9% !important;
        flex: initial !important;
    }
    .width-10 {
        max-width: initial !important;
        width: 10% !important;
        flex: initial !important;
    }

    .width-12 {
        max-width: initial !important;
        width: 12.5% !important;
        flex: initial !important;
    }

    .width-45 {
        max-width: initial !important;
        width: 45% !important;
        flex: initial !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php if($contract): ?>

 <?php echo e(__('Settlement Using Contract Down Payment')); ?>

							[<?php echo e($contract->getName()); ?>]
							<?php else: ?>
 <?php echo e(__('Settlement Using Down Payment')); ?>

							
							<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form method="post" action="<?php echo e(route('store.down.payment.settlement',['company'=>$company->id,'downPaymentId'=>$downPayment->id,'partnerId'=>$partnerId,'modelType'=>$modelType])); ?>" class="kt-form kt-form--label-right">
							
			<input type="hidden" name="model_type" value="<?php echo e($modelType); ?>" > 
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($downPayment) ? 1 : 0); ?>">
            <input id="js-money-received-id" type="hidden" name="down_payment_id" value="<?php echo e(isset($downPayment) ? $downPayment->id : 0); ?>">
            <input id="js-money-payment-id" type="hidden" name="down_payment_id" value="<?php echo e(isset($downPayment) ? $downPayment->id : 0); ?>">
			                           

            
            <?php echo csrf_field(); ?>
            
            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
						<?php if($contract): ?>
                            <?php echo e(__('Settlement Using Contract Down Payment')); ?>

							[<?php echo e($contract->getName()); ?>]
							<?php else: ?>
                            <?php echo e(__('Settlement Using Down Payment')); ?>

							
							<?php endif; ?> 
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">


                        <div class="col-md-5">
                            <label><?php echo e($customerNameText); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select disabled id="<?php echo e($customerNameColumnName); ?>" name="<?php echo e($customerIdColumnName); ?>" class="form-control ajax-get-invoice-numbers">
                                            
                                            <option selected value="<?php echo e($partnerId); ?>"><?php echo e($partnerName); ?></option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
						
						 <div class="col-md-2">
                            <label>  <?php echo e(__('Down Payment Amount')); ?> </label>
							<div class="form-group">
							 <input data-max-cheque-value="0" disabled type="text" value="<?php echo e($downPaymentAmount); ?>" name="received_amount" class="form-control only-greater-than-or-equal-zero-allowed   main-amount-class recalculate-amount-class" placeholder="<?php echo e(__('Received Amount')); ?>">
							 
							</div>

                        </div>

                        <div class="col-md-2">
                            <label><?php echo e(__('Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select disabled name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                                        
                                        <?php $__currentLoopData = isset($currencies) ? $currencies : getBanksCurrencies (); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										
										<?php
								$selected = isset($downPayment) ?  $downPayment->getCurrency()  == $currencyId  :  $currentName == $company->getMainFunctionalCurrency() ;
									$selected = $selected ? 'selected':'';
							   ?>
							   
                                        <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?php echo e(__('Settlement Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input  type="text" name="settlement_date"  value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Settlement Information')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <div class="js-append-to">
                        <div class="col-md-12 js-duplicate-node">

                        </div>
                    </div>

                    <div class="js-template ">
					     <div class="col-md-12 js-duplicate-node">
                          
						  <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  
						  <div class=" kt-margin-b-10 border-class">
			<div class="form-group row align-items-end">
			
				<?php if($hasProjectNameColumn): ?>
				<div class="col-md-1 width-17 ">
					<label> <?php echo e(__('Project Name')); ?> </label>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
								<input readonly class="form-control js-project-name" name="settlements['.$invoiceNumber.'][project_name]" value="<?php echo e($invoice->getProjectName()); ?>">
							</div>
						</div>
					</div>
				</div>
				
				<?php endif; ?>
				<?php
					$totalSettlementAmount  = $downPayment->sumSettlementsForInvoice($invoice->id,$partnerId,$isDownPaymentFromMoneyPayment);
					$totalWithholdAmount = $downPayment->sumWithholdAmountForInvoice($invoice->id,$partnerId,$isDownPaymentFromMoneyPayment);
				?>
				<div class="col-md-1 width-10 ">
					<label> <?php echo e(__('Invoice Number')); ?> </label>
					<div class="kt-input-icon">
						<div class="kt-input-icon">
							<div class="input-group date">
								<input type="hidden" name="settlements[<?php echo e($index); ?>][invoice_id]" value="<?php echo e($invoice->id); ?>" class="js-invoice-id">
								<input readonly class="form-control" name="settlements[<?php echo e($index); ?>][invoice_number]" value="<?php echo e($invoice->getInvoiceNumber()); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1 width-9 ">
					<label><?php echo e(__('Invoice Date')); ?></label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements[<?php echo e($index); ?>][invoice_date]" type="text" class="form-control " value="<?php echo e($invoice->getInvoiceDateFormatted()); ?>" disabled />
						</div>
					</div>
				</div>
				<div class="col-md-1 width-9 ">
					<label><?php echo e(__('Due Date')); ?></label>
					<div class="kt-input-icon">
						<div class="input-group date">
							<input name="settlements[<?php echo e($index); ?>][invoice_due_date]" type="text" class="form-control" value="<?php echo e($invoice->getInvoiceDueDateFormatted()); ?>" disabled />
						</div>
					</div>
				</div>
				
				
				
				<div class="col-md-2 width-12 ">
					<label> <?php echo e(__('Invoice Amount') . ' [ ' . $invoice->getCurrency() .' ]'); ?> </label>
					<div class="kt-input-icon">
						<input name="settlements[<?php echo e($index); ?>][net_invoice_amount]" type="text" disabled class="form-control" value="<?php echo e($invoice->getNetInvoiceAmountFormatted()); ?>">
					</div>
				</div>
				
				<div class="col-md-2 width-12 ">
					<label> <?php echo e(__('Collected Amount')); ?> </label>
					<div class="kt-input-icon">
						<input name="settlements[<?php echo e($index); ?>][collected_amount]" type="text" disabled class="form-control" value="<?php echo e(number_format($invoice->getCollectedOrPaidInEditModeForDownPayment(true,$totalSettlementAmount) ,0)); ?>">
					</div>
				</div>
		
				<div class="col-md-2 width-12 ">
					<label> <?php echo e(__('Net Balance')); ?> </label>
					<div class="kt-input-icon">
						<input name="settlements[<?php echo e($index); ?>][net_balance]" type="text" disabled class="form-control " value="<?php echo e(number_format($invoice->calculateNetBalanceInEditMode(true,$totalSettlementAmount , $totalWithholdAmount) ,0)); ?>">
					</div>
				</div>
				<div class="col-md-1 width-9.5 ">
					<label> <?php echo e(__('Settlement Amount')); ?>  <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input value="<?php echo e($totalSettlementAmount); ?>" name="settlements[<?php echo e($index); ?>][settlement_amount]" placeholder="<?php echo e(__("Settlement Amount")); ?>" type="text" class="form-control  only-greater-than-or-equal-zero-allowed settlement-amount-class">
					</div>
				</div>
				<div class="col-md-1 width-9.5 ">
					<label> <?php echo e(__('Withhold Amount')); ?> <span class="text-danger ">*</span> </label>
					<div class="kt-input-icon">
						<input value="<?php echo e($totalWithholdAmount); ?>" name="settlements[<?php echo e($index); ?>][withhold_amount]" placeholder="<?php echo e(__('Withhold Amount')); ?>" type="text" class="form-control  only-greater-than-or-equal-zero-allowed ">
					</div>
				</div>
		
			</div>
		
		</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
						  </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        
                </div>
            </div>
    </div>

     <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

    </form>
    <!--end::Form-->

    <!--end::Portlet-->
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
<script>

</script>
<script>
    $('#type').change(function() {
        selected = $(this).val();
        $('.js-section-parent').addClass('hidden');
        if (selected) {
            $('#' + selected).removeClass('hidden');

        }


    });
    $('#type').trigger('change')

</script>


<script>
    $(document).on('change', '.settlement-amount-class', function() {

    })
    $(function() {
        $('#type').trigger('change');
    })

</script>



<script>
$(function(){

	$('select.ajax-get-invoice-numbers').trigger('change')
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/contracts-down-payment/settlement_form.blade.php ENDPATH**/ ?>