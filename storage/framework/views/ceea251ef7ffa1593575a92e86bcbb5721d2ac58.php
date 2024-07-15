<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 200px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Letter Of Credit Facility ['. $financialInstitution->getName() . ' ]')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lc nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == 'letter-of-credit-facilities' ?'active':''); ?>" data-toggle="tab" href="#letter-of-credit-facilities" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Letter Of Credit Facility Table')); ?>

                    </a>
                </li>

            </ul>

            <div class="flex-tabs">
                <a href="<?php echo e(route('create.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])); ?>" class="btn  active-style btn-icon-sm align-self-center">
                    <i class="fas fa-plus"></i>
                    <?php echo e(__('New Record')); ?>

                </a>

            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == 'letter-of-credit-facilities' ?'active':''); ?>" id="bank" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lc p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                <?php echo e(__('Letter Of Credit Facility Table')); ?>

                            </h3>
                        </div>
                        
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-letter-of-credit-facility','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields,'moneyReceivedType' => 'letter-of-credit-facilities','hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('create.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-letter-of-credit-facility'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('letter-of-credit-facilities'),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('create.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Limit')); ?></th>
                                    <th><?php echo e(__('Outstanding Amount')); ?></th>
                                    <th><?php echo e(__('Terms')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $letterOfCreditFacilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$letterOfCreditFacility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td class="text-nowrap"><?php echo e($letterOfCreditFacility->getContractStartDateFormatted()); ?></td>
                                    <td class="text-nowrap"><?php echo e($letterOfCreditFacility->getContractEndDateFormatted()); ?></td>
                                    <td class="text-uppercase"><?php echo e($letterOfCreditFacility->getCurrency()); ?></td>
                                    <td class="text-transform"><?php echo e($letterOfCreditFacility->getLimitFormatted()); ?></td>
                                    <td class="text-transform"><?php echo e($letterOfCreditFacility->getOutstandingAmountFormatted()); ?>



                                    </td>
                                    <td>
									
									
									
									
									
									
									
									
									
									<button data-toggle="modal" data-target="#letter_of_credit_terms_and_conditions<?php echo e($letterOfCreditFacility->id); ?>" type="button" class="btn btn-outline-brand btn-elevate btn-pill"><i class="fa fa-tag"></i> Click Here</button>

                                        <div class="modal fade " id="letter_of_credit_terms_and_conditions<?php echo e($letterOfCreditFacility->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                <form action="#" class="modal-content" method="post">


                                                    <?php echo csrf_field(); ?>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color:#0741A5 !important"><?php echo e(__('LCs Terms And Conditions')); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="customize-elements">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center"><?php echo __('LC Type'); ?> </th>
                                                                        <th class="text-center"><?php echo __('Cash Cover'); ?> </th>
                                                                        <th class="text-center"> <?php echo __('Commission %'); ?> </th>
                                                                        <th class="text-center"><?php echo e(__('Commission Interval')); ?></th>
                                                                        <th class="text-center"> <?php echo __('Min Commission Fees'); ?> </th>
                                                                        <th class="text-center"> <?php echo __('Issuance Fees'); ?> </th>
																		
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    <?php $__currentLoopData = $letterOfCreditFacility->termAndConditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termAndCondition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" step="0.1" class="form-control" value="<?php echo e($termAndCondition->getLcTypeFormatted()); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="<?php echo e($termAndCondition->getCashCoverRate() . ' %'); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>


                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="<?php echo e($termAndCondition->getCommissionRate() . ' %'); ?>">

                                                                                </div>
                                                                            </div>
                                                                        </td>


                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center text-capitalize" value="<?php echo e($termAndCondition->getCommissionInterval()); ?>">

                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="<?php echo e(number_format($termAndCondition->getMinCommissionFees())); ?>">

                                                                                </div>
                                                                            </div>
                                                                        </td>


                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="<?php echo e(number_format($termAndCondition->getIssuanceFees())); ?>">
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
                                                        <button type="button" class="btn btn-primary " data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </td>

                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
										
										
										<a data-toggle="modal" data-target="#apply-expense-<?php echo e($letterOfCreditFacility->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Amount To Be Decreased')); ?>" href="#"><i class=" fa fa-balance-scale"></i></a>
 <div class="modal fade" id="apply-expense-<?php echo e($letterOfCreditFacility->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('apply.lc.expense',['company'=>$company->id,'letterOfCreditFacility'=>$letterOfCreditFacility->id])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Apply Expenses' )); ?></h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         
						 
						  <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Date')); ?></label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
						 

                         <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Amount')); ?> </label>
                             <div class="kt-input-icon">
							
                                 <input name="amount"  value="0" type="text" class="form-control recalculate-amount-in-main-currency amount-js only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>
						 
						 
						 
						 <div class="col-md-3 mb-4">
                            <label><?php echo e(__('Select Currency')); ?>   </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="currency" required class="form-control currency-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name ajax-refresh-customers" >
										<?php $__currentLoopData = getBanksCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($currencyName); ?>"><?php echo e(touppercase($currencyName)); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
						
						 <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Exchange Rate')); ?> </label>
                             <div class="kt-input-icon">
                                 <input name="exchange_rate"  value="0" type="text" class="form-control recalculate-amount-in-main-currency exchange-rate-js only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>
						 
						 
						 <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Amount In Main Currency')); ?> </label>
                             <div class="kt-input-icon">
							 	<input type="hidden" name="amount_in_main_currency" class="amount-in-main-currency-js-hidden" value="0" type="text"  >
                                 <input disabled   value="0" type="text" class="form-control amount-in-main-currency-js only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>
						 
						 
						
                        

                        

                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th><?php echo e(__('#')); ?></th>
                                             <th><?php echo e(__('Date')); ?></th>
                                             <th><?php echo e(__('Amount')); ?></th>
                                             <th><?php echo e(__('Actions')); ?></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $__currentLoopData = $letterOfCreditFacility->expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                             <td> <?php echo e(++$index); ?> </td>
                                             <td class="text-nowrap"><?php echo e($expense->getDateFormatted()); ?></td>
                                             <td> <?php echo e($expense->getAmountFormatted()); ?> </td>
                                             <td>
                                                 <a data-toggle="modal" data-target="#edit-advanced-payment-lg-<?php echo e($expense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" 
												 
												 ><i class="fa fa-pen-alt"></i></a>



                                                 <div class="modal fade" id="edit-advanced-payment-lg-<?php echo e($expense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                         <div class="modal-content">
                                                             <form action="<?php echo e(route('advanced.lg.payment.edit.amount.to.be.decreased',['company'=>$company->id,'lgAdvancedPaymentHistory'=>$expense->id ])); ?>" method="post">
                                                                 <?php echo csrf_field(); ?>
                                                                 <div class="modal-header">
                                                                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Amount To Be Decreased To' )); ?></h5>
                                                                     <button data-dismiss="modal2" type="button" class="close" aria-label="Close">
                                                                         <span aria-hidden="true">&times;</span>
                                                                     </button>
                                                                 </div>


                                                                 <div class="modal-body">
                                                                     <div class="row mb-3">

                                                                         <div class="col-md-6 mb-4">
                                                                             <label><?php echo e(__('Bank Name')); ?> </label>
                                                                             <div class="kt-input-icon">
                                                                                 <input disabled value="<?php echo e($letterOfCreditFacility->getFinancialInstitutionBankName()); ?>" type="text" class="form-control">
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-2 mb-4">
                                                                             <label><?php echo e(__('LG Amount')); ?> </label>
                                                                             <div class="kt-input-icon">
                                                                                 <input disabled value="<?php echo e($letterOfCreditFacility->getLgAmount()); ?>" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-2 mb-4">
                                                                             <label><?php echo e(__('Date')); ?></label>
                                                                             <div class="kt-input-icon">
                                                                                 <div class="input-group date">
                                                                                     <input required type="text" name="decrease_date" value="<?php echo e($expense ?formatDateForDatePicker($expense->getDate()) : null); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                                                     <div class="input-group-append">
                                                                                         <span class="input-group-text">
                                                                                             <i class="la la-calendar-check-o"></i>
                                                                                         </span>
                                                                                     </div>
                                                                                 </div>
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-2 mb-4">
                                                                             <label><?php echo e(__('Amount To Be Decreased')); ?> </label>
                                                                             <div class="kt-input-icon">
                                                                                 <input name="amount_to_be_decreased" value="<?php echo e($expense->getAmount()); ?>" type="text" class="form-control only-greater-than-zero-allowed">
                                                                             </div>
                                                                         </div>



                                                                     </div>
                                                                 </div>


                                                                 <div class="modal-footer">
                                                                     <button type="button" class="btn btn-secondary" data-dismiss="modal2"><?php echo e(__('Close')); ?></button>
                                                                     <button type="submit" class="btn btn-primary submit-form-btn"><?php echo e(__('Confirm')); ?></button>
                                                                 </div>

                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>








                                                 <a data-toggle="modal" data-target="#delete-advanced-payment-lg-<?php echo e($expense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                                 <div class="modal fade" id="delete-advanced-payment-lg-<?php echo e($expense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                                         <div class="modal-content">
                                                             <form action="" method="post">
                                                                 <?php echo csrf_field(); ?>
                                                                 <?php echo method_field('delete'); ?>
                                                                 <div class="modal-header">
                                                                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                     <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                                                                         <span aria-hidden="true">&times;</span>
                                                                     </button>
                                                                 </div>
                                                                 <div class="modal-footer">
                                                                     <button type="button" class="btn btn-secondary" data-dismiss="modal2"><?php echo e(__('Close')); ?></button>

                                                                     <a href="<?php echo e(route('delete.lg.advanced.payment',['company'=>$company->id,'lgAdvancedPaymentHistory'=>$expense->id])); ?>" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></a>
                                                                 </div>

                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>

                                             </td>
                                         </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>

                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     <button type="submit" class="btn btn-primary"><?php echo e(__('Confirm')); ?></button>
                 </div>

             </form>
         </div>
     </div>
 </div>
 
 
										
										
										
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'letterOfCreditFacility'=>$letterOfCreditFacility->id])); ?>"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($letterOfCreditFacility->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($letterOfCreditFacility->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'letterOfCreditFacility'=>$letterOfCreditFacility])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>










            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
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


</script>







<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'contract_start_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script>
	$(document).on('change','.recalculate-amount-in-main-currency',function(){
		const parent = $(this).closest('.modal-body');
		const amount = parseFloat($(parent).find('.amount-js').val()	)
		const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
		const amountInMainCurrency = parseFloat(amount * exchangeRate) ;
		$(parent).find('.amount-in-main-currency-js-hidden').val( amountInMainCurrency)
		$(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
	})
	
	
</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/reports/LetterOfCreditFacility/index.blade.php ENDPATH**/ ?>