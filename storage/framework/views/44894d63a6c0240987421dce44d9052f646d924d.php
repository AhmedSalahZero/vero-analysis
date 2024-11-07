<?php $__env->startSection('css'); ?>
<?php
use App\Models\MoneyPayment ;
use App\Models\SupplierInvoice;
$banks =[];
$selectedBanks = [];
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    label {
        text-align: left !important;
    }

    .width-8 {
        max-width: initial !important;
        width: 8% !important;
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
<?php echo e(__('Money Payment Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        
<form method="post" action="<?php echo e(isset($model) ?  route('update.money.payment',['company'=>$company->id,'moneyPayment'=>$model->id]) :route('store.money.payment',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">

    <input id="is-down-payment-id" type="hidden" name="is_down_payment" value="1">
    <input type="hidden" name="current_cheque_id" value="<?php echo e(isset($model) && $model->payableCheque ? $model->payableCheque->id : 0); ?>">
    <input id="js-money-payment-id" type="hidden" name="money_received_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
    <input type="hidden" id="ajax-invoice-item" data-single-model="<?php echo e($singleModel ? 1 : 0); ?>" value="<?php echo e($singleModel ? $singleModel : 0); ?>">
    <input id="js-down-payment-id" type="hidden" name="down_payment_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
    <?php echo csrf_field(); ?>
    <?php if(isset($model)): ?>
    <?php echo method_field('put'); ?>
    <?php endif; ?>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Money Payment [ DownPayment ]')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
            
			
			   <div class="col-md-2 ">
                    <label><?php echo e(__('Payment Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="delivery_date" value="<?php echo e(isset($model) ? formatDateForDatePicker($model->getDeliveryDate()) : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_max_date_is_today" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
				
				
                <div class="col-md-2">
                    <label><?php echo e(__('Contract Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select id="invoice-currency-id" name="currency" class="form-control 
							currency-class
							currency-for-contracts
							invoice-currency-class
					
							
							ajax-get-contracts-for-supplier  ajax-get-purchases-orders-for-contract
							current-invoice-currency
							 ajax-get-invoice-numbers
							 
							 ">

                                <?php $__currentLoopData = isset($currencies) ? $currencies : getBanksCurrencies (); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $selected = isset($model) ? $model->getCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                $selected = $selected ? 'selected':'';
                                ?>
                                <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">

                    <label><?php echo e(__('Supplier Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                    <div class="kt-input-icon">
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getName() : ''); ?>" data-live-search="true" data-actions-box="true" id="supplier_name" name="supplier_id" class="form-control select2-select  
					ajax-get-invoice-numbers
					
					 ajax-get-contracts-for-supplier ajax-get-purchases-orders-for-contract">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                    
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplierId => $supplierName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($singleModel): ?> selected <?php endif; ?> <?php if(isset($model) && $model->getSupplierName() == $supplierName ): ?> selected <?php endif; ?> value="<?php echo e($supplierId); ?>"><?php echo e($supplierName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-md-2 ">
                    <label><?php echo e(__('Payment Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select id="receiving-currency-id" when-change-trigger-account-type-change name="payment_currency" class="form-control 
							current-currency
							currency-class
							receiving-currency-class
							
							ajax-get-contracts-for-supplier  ajax-get-purchases-orders-for-contract ajax-get-invoice-numbers
					
							">

                                <?php $__currentLoopData = isset($currencies) ? $currencies : getBanksCurrencies (); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $selected = isset($model) ? $model->getPaymentCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                $selected = $selected ? 'selected':'';
                                ?>
                                <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>




                <div class="col-md-3">
                    <label><?php echo e(__('Contract Name')); ?>

                        <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </label>
                    <div class="kt-input-icon">
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getContractId() : 0); ?>" id="contract-id" name="contract_id" class="form-control down-payment-contract-class ajax-get-invoice-numbers ajax-get-purchases-orders-for-contract">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if(isset($model) && $model->getContractId() == $contract->id ): ?> selected <?php endif; ?> value="<?php echo e($contract->id); ?>"><?php echo e($contract->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

<div class="col-md-2 mt-4">
                    <label><?php echo e(__('Money Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select required name="type" id="type" class="form-control">
                                <option value="" selected><?php echo e(__('Select')); ?></option>

                                <option <?php if(isset($model) && $model->isCashPayment() ): ?> selected <?php endif; ?> value="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>"><?php echo e(__('Cash Payment')); ?></option>
                                <option <?php if(isset($model) && $model->isPayableCheque() ): ?> selected <?php endif; ?> value="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>"><?php echo e(__('Payable Cheques')); ?></option>
                                <option <?php if(isset($model) && $model->isOutgoingTransfer()): ?> selected <?php endif; ?> value="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>"><?php echo e(__('Outgoing Transfer')); ?></option>
                            </select>
                        </div>
                    </div>




                    <div class="modal fade" id="js-choose-delivery-branch-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Branch')); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="js-delivery-branch-names" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                    <button id="js-append-delivery-branch-name-if-not-exist" type="button" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
				
             
            </div>
        </div>
    </div>

    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Cash Payment Information')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45 ">
                        <label><?php echo e(__('Select Delivery Branch')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="delivery_branch_id" class="form-control">
                                    <option value="-1"><?php echo e(__('Select Branch')); ?></option>
                                    <?php $__currentLoopData = $selectedBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchId=>$branchName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branchId); ?>" <?php echo e(isset($model) && $model->getCashPaymentBranchId() == $branchId ? 'selected' : ''); ?>><?php echo e($branchName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button id="js-delivery-branch" class="btn btn-sm btn-primary"><?php echo e(__('Add New Branch')); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 closest-parent">
                        <label><?php echo e(__('Received Amount')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount() :0); ?>" name="paid_amount[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::CASH_PAYMENT.'-received-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>" placeholder="<?php echo e(__('Received Amount')); ?>">
                             <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label><?php echo e(__('Receipt Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number" value="<?php echo e(isset($model) ?  $model->getCashPaymentReceiptNumber()  : ''); ?>" class="form-control" placeholder="<?php echo e(__('Receipt Number')); ?>">
                             <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                    </div>
                    <div class="col-md-3 width-12 show-only-when-invoice-currency-not-equal-receiving-currency">
                        <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden closest-parent">
                        <label><?php echo e(__('Amount In Contract Currency')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_invoice_currency[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control  amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Payable Cheque Information')); ?>

                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label><?php echo e(__('Select Payment Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control ">
                                    <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getPayableChequePaymentBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                    <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getOutgoingTransferAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getOutgoingTransferAccountNumber() : 0); ?>" name="account_number[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12 closest-parent">
                        <label><?php echo e(__('Cheque Amount')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="<?php echo e(isset($model) ? $model->getPaidAmount() : 0); ?>" placeholder="<?php echo e(__('Please insert the cheque amount')); ?>" type="text" name="paid_amount[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::PAYABLE_CHEQUE .'-paid-amount'); ?>">
                        </div>
                    </div>



                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Due Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" value="<?php echo e(isset($model) && $model->payableCheque ? formatDateForDatePicker($model->payableCheque->getDueDate()):formatDateForDatePicker(now()->format('Y-m-d'))); ?>" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2 width-12 mt-4">
                        <label><?php echo e(__('Cheque Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" value="<?php echo e(isset($model) && $model->payableCheque ? $model->payableCheque->getChequeNumber() : 0); ?>" class="form-control" placeholder="<?php echo e(__('Cheque Number')); ?>">
                        </div>
                    </div>

                    <div class="col-md-2 width-12 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency">
                        <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden closest-parent">
                        <label><?php echo e(__('Amount In Contract Currency')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_invoice_currency[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control  amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>

    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Outgoing Transfer Information')); ?>

                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label><?php echo e(__('Select Payment Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control ">
                                    <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getOutgoingTransferDeliveryBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 closest-parent">
                        <label><?php echo e(__('Outgoing Transfer Amount')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount():0); ?>" name="paid_amount[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::OUTGOING_TRANSFER .'-received-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>" placeholder="<?php echo e(__('Insert Amount')); ?>">
                        </div>
                    </div>



                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                    <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getOutgoingTransferAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getOutgoingTransferAccountNumber() : 0); ?>" name="account_number[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1 show-only-when-invoice-currency-not-equal-receiving-currency">
                        <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden closest-parent">
                        <label><?php echo e(__('Amount In Contract Currency')); ?> <span class="currency-span"></span> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_invoice_currency[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control  amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
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

            <div class="js-append-down-payment-to">
                <div class="col-md-12 js-duplicate-node">

                </div>
            </div>




            <div class="js-down-payment-template hidden">
                <div class="col-md-12 js-duplicate-node">
                    <div class=" kt-margin-b-10 border-class">
                        <?php echo $__env->make('reports.moneyPayments._down-payments-purchase-orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>


        </div>
    </div>







    <?php if(isset($model)): ?>
    <div class="kt-portlet" id="settlement-card-id">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Settlement Information')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">

            <div class="js-append-to">
            </div>
            <div class="js-template hidden">
                <div class="col-md-12 js-duplicate-node">
                    <?php echo SupplierInvoice::getSettlementsTemplate(); ?>

                </div>
            </div>

            <hr>



            <div class="row">
                <div class="col-md-1 width-10"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12">
                    <label class="label"><?php echo e(__('Unapplied Amount')); ?></label>
                    <input id="remaining-settlement-js" class="form-control" placeholder="<?php echo e(__('Unapplied Amount')); ?>" type="text" name="unapplied_amount" value="0">
                </div>

            </div>
        </div>
    </div>
    <?php endif; ?>


     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.submitting-by-ajax','data' => []]); ?>
<?php $component->withName('submitting-by-ajax'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
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

    $(document).on('change', 'select.currency-class', function() {
        const invoiceCurrency = $('select#invoice-currency-id').val();
        const receivingCurrency = $('select#receiving-currency-id').val();
        const moneyType = $('select#type').val();

        $('.main-amount-class').closest('.closest-parent').find('.currency-span').html(" [ " + receivingCurrency + " ]")
        $('.amount-after-exchange-rate-class').closest('.closest-parent').find('.currency-span').html(" [ " + invoiceCurrency + " ]")


        if (invoiceCurrency != receivingCurrency && invoiceCurrency && receivingCurrency) {
            $('.show-only-when-invoice-currency-not-equal-receiving-currency').removeClass('hidden')

        } else {
            // hide 

            $('.show-only-when-invoice-currency-not-equal-receiving-currency').addClass('hidden')
        }

    })
    $(document).on('change', '.recalculate-amount-class', function() {
        const moneyType = $(this).attr('data-type')
        const amount = number_unformat($('.main-amount-class[data-type="' + moneyType + '"]').val());
        const exchangeRate = number_unformat($('.exchange-rate-class[data-type="' + moneyType + '"]').val());
        const amountAfterExchangeRate = amount / exchangeRate;
        $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').val(number_format(amountAfterExchangeRate)).trigger('change')
        $('.js-settlement-amount:eq(0)').trigger('change')
    })
    $(document).on('change', 'select[when-change-trigger-account-type-change]', function(e) {
        $('select.js-update-account-number-based-on-account-type').trigger('change')
    });

</script>
<script src="/custom/money-payment.js">

</script>

<script>
    $(document).on('change', '.settlement-amount-class', function() {

    })
    $(function() {
        $('#type').trigger('change');
    })

</script>


<script>
    $(document).on('change', '.ajax-get-contracts-for-supplier', function(e) {
        e.preventDefault()
        const supplierId = $('#supplier_name').val()
        const currency = $('select.currency-for-contracts').val()
        const contractId = $('select#contract-id').attr('data-current-selected');
        if (supplierId && currency) {
            $.ajax({
                url: "<?php echo e(route('get.contracts.for.supplier',['company'=>$company->id])); ?>"
                , data: {
                    supplierId
                    , currency
                }
                , success: function(res) {
                    let options = '';
                    for (id in res.contracts) {
                        options += `<option value="${id}" ${contractId == id ? 'selected' : ''} >${res.contracts[id]}</option>`
                    }
                    $('select#contract-id').empty().append(options)
                    $('select#contract-id').trigger('change')
                }
            })
        }
    })

</script>
<script>
    $(function() {
        $('select#supplier_name').trigger('change')
        //$('select.currency-class').trigger('change')
        //$('.recalculate-amount-class').trigger('change')
    })
    $()

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyPayments/down-payments-form.blade.php ENDPATH**/ ?>