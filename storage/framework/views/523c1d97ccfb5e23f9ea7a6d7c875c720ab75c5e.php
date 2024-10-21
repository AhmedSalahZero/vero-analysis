<?php $__env->startSection('css'); ?>
<?php
use App\Models\CashExpense;
$selectedBanks = [];
$banks = [];
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
th:not(.bank-max-width),
	td:not(.bank-max-width){
		text-wrap:nowrap !important;
	}
td{
	vertical-align:middle !important;
}

.color-green{
	color:white !important;
	background-color:green !important;
}
    button[type="submit"],
    button[type="button"] {
        font-size: 1rem !important;

    }

    button[type="submit"] {
        background-color: green !important;
        border: 1px solid green !important;
    }

    .kt-portlet__body {
        padding-top: 0 !important;
    }

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

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Cash Expense')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == CashExpense::PAYABLE_CHEQUE ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e(__('Payable Cheques')); ?>

                    </a>
                </li>
                
                
                


                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == CashExpense::OUTGOING_TRANSFER ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i><?php echo e(__('Outgoing Transfer')); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request('active') == CashExpense::CASH_PAYMENT ? 'active':''); ?>" data-toggle="tab" href="#<?php echo e(CashExpense::CASH_PAYMENT); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i><?php echo e(__('Cash Payment')); ?>

                    </a>
                </li>

                

            </ul>
<?php if(auth()->user()->can('create cash expenses')): ?>
            <div class="flex-tabs">
			<a href="<?php echo e(route('create.cash.expense',['company'=>$company->id])); ?>" class="btn  btn-sm active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                <?php echo e(__('Cash Expense')); ?>

            </a>
			
			  
			</div>
			<?php endif; ?> 

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == CashExpense::PAYABLE_CHEQUE ?'active':''); ?>" id="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => CashExpense::PAYABLE_CHEQUE,'title' => __('Payable Cheques'),'startDate' => $filterDates[CashExpense::PAYABLE_CHEQUE]['startDate']??'','endDate' => $filterDates[CashExpense::PAYABLE_CHEQUE]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::PAYABLE_CHEQUE),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Payable Cheques')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::PAYABLE_CHEQUE]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::PAYABLE_CHEQUE]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-cash-expense','data' => ['routeRedirect' => route('view.cash.expense',['company'=>$company->id]),'routeAction' => route('cash.expense.payable.cheque.mark.as.paid',['company'=>$company->id]),'popupTitle' => __('Do You Want To Mark This Cheque / Cheques As Paid ?'),'accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $payableChequesTableSearchFields,'cashExpenseType' => CashExpense::PAYABLE_CHEQUE,'hasSearch' => 1,'hasBatchCollection' => 1,'banks' => $banks??[],'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-cash-expense'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['route-redirect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.cash.expense',['company'=>$company->id])),'route-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('cash.expense.payable.cheque.mark.as.paid',['company'=>$company->id])),'popup-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Do You Want To Mark This Cheque / Cheques As Paid ?')),'account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($payableChequesTableSearchFields),'cash-expense-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::PAYABLE_CHEQUE),'has-search' => 1,'has-batch-collection' => 1,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks??[]),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                    <div class="kt-portlet__body">

                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="align-middle"><?php echo e(__('Select')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Type')); ?></th>
                                    
                                    
                                    <th class="align-middle"><?php echo __('Category <br> Name'); ?></th>
                                    <th class="align-middle"><?php echo __('Expense <br> Name'); ?></th>
                                    <th class="align-middle"><?php echo __('Payment <br> Date'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque<br>Number'); ?></th>
                                    <th class="align-middle"><?php echo __('Cheque<br>Amount'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Currency')); ?></th>
                                    <th class="align-middle bank-max-width "><?php echo e(__('Payment Bank')); ?></th>
                                    <th class="align-middle bank-max-width"><?php echo e(__('Account Type')); ?></th>
                                    <th class="align-middle"><?php echo e(__('Account No')); ?></th>
                                    <th class="align-middle"><?php echo __('Due<br>Date'); ?></th>
                                    
                                    <th class="align-middle"><?php echo __('Status'); ?></th>
                                    <th class="align-middle"><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $payableCheques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cashExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input style="max-height:25px;" id="cash-send-to-collection<?php echo e($cashExpense->id); ?>" type="checkbox" name="second_to_collection[]" value="<?php echo e($cashExpense->id); ?>" data-money-type="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>" class="form-control checkbox js-send-to-collection">
                                    </td>
                                    <td class="bank-max-width <?php if($cashExpense->payableCheque->getStatus() == 'paid'): ?> exclude-td font-weight-bold text-success color-green <?php endif; ?> "><?php echo e($cashExpense->payableCheque->getStatusFormatted()); ?></td>
                                    
                                    
                                    <td class="text-nowrap"><?php echo e($cashExpense->getExpenseCategoryName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($cashExpense->getExpenseName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($cashExpense->getPaymentDateFormatted()); ?></td>
                                    <td><?php echo e($cashExpense->payableCheque->getChequeNumber()); ?></td>
                                    <td><?php echo e($cashExpense->getPaidAmountFormatted()); ?></td>
                                    <td class="text-transform" data-currency="<?php echo e($cashExpense->getCurrency()); ?>"><?php echo e($cashExpense->getCurrencyToPaymentCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width "><?php echo e($cashExpense->payableCheque->getPaymentBankName()); ?></td>
                                    
                                    <td class="bank-max-width"><?php echo e($cashExpense->payableCheque->getAccountTypeName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($cashExpense->payableCheque->getAccountNumber()); ?></td>
                                    <td class="text-nowrap"><?php echo e($cashExpense->payableCheque->getDueDateFormatted()); ?></td>
                                    
									<?php
										$dueStatus = $cashExpense->payableCheque->getDueStatusFormatted() ;
									?>
									
                                    <td class="font-weight-bold bank-max-width" style="color:<?php echo e($dueStatus['color']); ?>!important">
									<?php if($cashExpense->payableCheque->getStatus() == 'paid'): ?> 
									-
									<?php else: ?>  
									<?php echo e($dueStatus['status']); ?>

									<?php endif; ?>
									</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											<?php if(auth()->user()->can('update cash expenses')): ?>
											<?php echo $__env->make('reports._review_modal',['model'=>$cashExpense], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.cash.expense',['company'=>$company->id,'cashExpense'=>$cashExpense->id])); ?>"><i class="fa fa-pen-alt"></i></a>
									<?php endif; ?> 
                                            <a data-id="<?php echo e($cashExpense->id); ?>" data-type="single" data-currency="<?php echo e($cashExpense->getCurrency()); ?>" data-money-type="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>" data-toggle="modal" data-target="#send-to-under-collection-modal<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-primary btn-icon" title="<?php echo e(__('Mark As Paid')); ?>" href=""><i class="fa fa-money-bill"></i></a>
								
											<?php if(!$cashExpense->isOpenBalance()): ?>
                                            <a data-toggle="modal" data-target="#delete-cheque-id-<?php echo e($cashExpense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-<?php echo e($cashExpense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.cash.expense',['company'=>$company->id,'cashExpense'=>$cashExpense->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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

            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == CashExpense::OUTGOING_TRANSFER ? 'active':''); ?>" id="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => CashExpense::OUTGOING_TRANSFER,'title' => __('Outgoing Transfer'),'startDate' => $filterDates[CashExpense::OUTGOING_TRANSFER]['startDate']??'','endDate' => $filterDates[CashExpense::OUTGOING_TRANSFER]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::OUTGOING_TRANSFER),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Outgoing Transfer')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::OUTGOING_TRANSFER]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::OUTGOING_TRANSFER]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-cash-expense','data' => ['routeRedirect' => route('view.cash.expense',['company'=>$company->id]),'routeAction' => route('cash.expense.outgoing.transfer.mark.as.paid',['company'=>$company->id]),'popupTitle' => __('Do You Want To Mark This Outcoming Transfer/s As Paid ?'),'accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $outgoingTransferTableSearchFields,'cashExpenseType' => CashExpense::OUTGOING_TRANSFER,'hasSearch' => 1,'hasBatchCollection' => 1,'banks' => $banks??[],'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-cash-expense'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['route-redirect' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.cash.expense',['company'=>$company->id])),'route-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('cash.expense.outgoing.transfer.mark.as.paid',['company'=>$company->id])),'popup-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Do You Want To Mark This Outcoming Transfer/s As Paid ?')),'account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($outgoingTransferTableSearchFields),'cash-expense-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::OUTGOING_TRANSFER),'has-search' => 1,'has-batch-collection' => 1,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks??[]),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
					
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="align-middle"><?php echo e(__('Select')); ?></th>
								 	<th class="align-middle"><?php echo __('Category <br> Name'); ?></th>
                                    <th class="align-middle"><?php echo __('Expense <br> Name'); ?></th>
                                    
                                    
                                    <th><?php echo e(__('Payment Date')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Payment Bank')); ?></th>
                                    <th><?php echo e(__('Transfer Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th class="bank-max-width"><?php echo e(__('Account Type')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $__currentLoopData = $outgoingTransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $money): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
								<td>
                                        <input style="max-height:25px;" id="cash-send-to-collection<?php echo e($money->id); ?>" type="checkbox" name="second_to_collection[]" value="<?php echo e($money->id); ?>" data-money-type="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>" class="form-control checkbox js-send-to-collection">
                                    </td>
								   
                                    
									   <td class="text-nowrap"><?php echo e($money->getExpenseCategoryName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($money->getExpenseName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($money->getPaymentDateFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getOutgoingTransferDeliveryBankName()); ?></td>
                                    <td><?php echo e($money->getPaidAmountFormatted()); ?></td>
                                    <td data-currency="<?php echo e($money->getCurrency()); ?>"> <?php echo e($money->getCurrencyToPaymentCurrencyFormatted()); ?></td>
                                    <td class="bank-max-width"><?php echo e($money->getOutgoingTransferAccountTypeName()); ?></td>
                                    <td><?php echo e($money->getOutgoingTransferAccountNumber()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$money->isOpenBalance()): ?>
										<?php if(auth()->user()->can('update cash expenses')): ?>
										<?php echo $__env->make('reports._review_modal',['model'=>$money], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.cash.expense',['company'=>$company->id,'cashExpense'=>$money->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
										<?php endif; ?> 
										<?php if(!$money->isOpenBalance()): ?>
                                            <a data-toggle="modal" data-target="#delete-transfer-id-<?php echo e($money->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-<?php echo e($money->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.cash.expense',['company'=>$company->id,'cashExpense'=>$money->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
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


            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(Request('active') == CashExpense::CASH_PAYMENT ? 'active':''); ?>" id="<?php echo e(CashExpense::CASH_PAYMENT); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => CashExpense::CASH_PAYMENT,'title' => __('Cash Payment'),'startDate' => $filterDates[CashExpense::CASH_PAYMENT]['startDate']??'','endDate' => $filterDates[CashExpense::CASH_PAYMENT]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::CASH_PAYMENT),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Payment')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::CASH_PAYMENT]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[CashExpense::CASH_PAYMENT]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-cash-expense','data' => ['accountTypes' => $accountTypes,'financialInstitutionBanks' => $financialInstitutionBanks,'searchFields' => $payableCashTableSearchFields,'cashExpenseType' => CashExpense::CASH_PAYMENT,'hasSearch' => 1,'hasBatchCollection' => 0,'banks' => $banks??[],'selectedBanks' => $selectedBanks,'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']]); ?>
<?php $component->withName('export-cash-expense'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['account-types' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($accountTypes),'financialInstitutionBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitutionBanks),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($payableCashTableSearchFields),'cash-expense-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(CashExpense::CASH_PAYMENT),'has-search' => 1,'has-batch-collection' => 0,'banks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banks??[]),'selectedBanks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedBanks),'href' => ''.e(route('create.cash.expense',['company'=>$company->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    
                                    <th class="align-middle"><?php echo e(__('Select')); ?></th>
									
                                    
									<th class="align-middle"><?php echo __('Category <br> Name'); ?></th>
                                    <th class="align-middle"><?php echo __('Expense <br> Name'); ?></th>
                                    <th><?php echo e(__('Payment Date')); ?></th>
                                    <th><?php echo e(__('Branch')); ?></th>
                                    <th><?php echo e(__('Payment Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Receipt Number')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cashPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cashExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
									
								<td>
                                        <input style="max-height:25px;" id="cash-send-to-collection<?php echo e($cashExpense->id); ?>" type="checkbox" name="second_to_collection[]" value="<?php echo e($cashExpense->id); ?>" data-money-type="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>" class="form-control checkbox js-send-to-collection">
                                    </td>
									       <td class="text-nowrap"><?php echo e($cashExpense->getExpenseCategoryName()); ?></td>
                                    <td class="text-nowrap"><?php echo e($cashExpense->getExpenseName()); ?></td>
                            
                                    
                                    
									
                                    <td class="text-nowrap"><?php echo e($cashExpense->getPaymentDateFormatted()); ?></td>
									
                                    <td><?php echo e($cashExpense->getCashPaymentBranchName()); ?></td>
                                    <td><?php echo e($cashExpense->getPaidAmountFormatted()); ?></td>
                                    <td data-currency="<?php echo e($cashExpense->getCurrency()); ?>"><?php echo e($cashExpense->getCurrencyToPaymentCurrencyFormatted()); ?></td>
                                    <td><?php echo e($cashExpense->getCashPaymentReceiptNumber()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(!$cashExpense->isOpenBalance()): ?>
										<?php if(auth()->user()->can('update cash expenses')): ?>
										<?php echo $__env->make('reports._review_modal',['model'=>$cashExpense], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.cash.expense',['company'=>$company->id,'cashExpense'=>$cashExpense->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php if(auth()->user()->can('delete cash expenses')): ?>
                                            <a data-toggle="modal" data-target="#delete-transfer-id-<?php echo e($cashExpense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-<?php echo e($cashExpense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.cash.expense',['company'=>$company->id,'cashExpense'=>$cashExpense->id])); ?>" method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('delete'); ?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											<?php endif; ?> 
<?php endif; ?> 
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


<script src="/custom/money-receive.js">

</script>

<script>
    $(document).on('click', '.js-can-trigger-cheque-under-collection-modal', function(e) {
        e.preventDefault();
        const moneyType = $(this).attr('data-money-type')
        const type = $(this).attr('data-type') // single or multi
        $('#single-or-multi' + moneyType).val(type);
        if (type == 'single') {
            $('#current-single-item' + moneyType).val($(this).attr('data-id'));
            $('#current-currency' + moneyType).val($(this).attr('data-currency'));
        }
    })
    $(document).on('submit', '.ajax-send-cheques-to-collection', function(e) {
        e.preventDefault();
        const url = $(this).attr('action');
        const moneyType = $(this).attr('data-money-type')
        const type = $('#single-or-multi' + moneyType).val();
        const singleId = parseInt($('#current-single-item' + moneyType).val());
        let checked = [];
        $('.js-send-to-collection[data-money-type="' + moneyType + '"]:checked').each(function(index, element) {
            checked.push(parseInt($(element).val()));
        });

        const checkedItems = type == 'multi' ? checked : [singleId];
        let form = document.getElementById('ajax-send-cheques-to-collection-id' + moneyType);
        let formData = new FormData(form);
        formData.append('cheques', checkedItems);
        $('button').prop('disabled', true)
        $.ajax({
            cache: false
            , contentType: false
            , processData: false
            , url: url
            , data: formData
            , type: "post"
        }).then(function(res) {
            Swal.fire({
                text: 'Done'
                , icon: 'success'
                , timer: 2000
            }).then(function() {
                window.location.href = res.pageLink;
            });
        })
    });

</script>
<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })
    $(document).on('click', '#js-drawee-bank', function(e) {
        e.preventDefault();
        $('#js-choose-bank-id').modal('show');
    })

    $(document).on('click', '#js-append-bank-name-if-not-exist', function() {
        const receivingBank = document.getElementById('js-drawee-bank').parentElement;
        const newBankId = $('#js-bank-names').val();
        const newBankName = $('#js-bank-names option:selected').attr('data-name');
        const isBankExist = $(receivingBank).find('select.js-drawl-bank').find('option[value="' + newBankId + '"]').length;
        if (!isBankExist) {
            const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
            $('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
        }
        $('#js-choose-bank-id').modal('hide');
    });

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'due_date') {
            $('.data-type-span').html('[ <?php echo e(__("Due Date")); ?> ]')
            modal.find(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName == 'receiving_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ <?php echo e(__("Payment Date")); ?> ]')
        } else if (searchFieldName == 'payment_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ <?php echo e(__("Payment Date")); ?> ]')
        } else {
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/cashExpenses/index.blade.php ENDPATH**/ ?>