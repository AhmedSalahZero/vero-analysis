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
    input,
    select,
    .dropdown-toggle.bs-placeholder {
        border: 1px solid #CCE2FD !important
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f7f8fa;
        opacity: 1;
    }

    .action-class {
        color: white !important;
        background-color: #0742A6 !important;
    }

    label {
        text-align: left !important;
    }

    .max-w-6 {
        max-width: initial !important;
        width: 6% !important;
        flex: initial !important;
    }

    .max-w-11 {
        max-width: initial !important;
        width: 11% !important;
        flex: initial !important;
    }

    .width-8 {
        max-width: initial !important;
        width: 8% !important;
        flex: initial !important;
    }
.width-9-5 {
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
<?php echo e(__('Supplier Payment Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        
<form method="post" action="<?php echo e(isset($model) ?  route('update.money.payment',['company'=>$company->id,'moneyPayment'=>$model->id]) :route('store.money.payment',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
    <input id="js-money-payment-id" type="hidden" name="money_payment_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
    <input type="hidden" id="ajax-invoice-item" data-single-model="<?php echo e($singleModel ? 1 : 0); ?>" value="<?php echo e($singleModel ? $invoiceNumber : 0); ?>">
    <?php echo csrf_field(); ?>
    <?php if(isset($model)): ?>
    <?php echo method_field('put'); ?>
    <?php endif; ?>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Supplier Payment')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-md-3">
                    <label><?php echo e(__('Payment Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="delivery_date" value="<?php echo e(isset($model) ? formatDateForDatePicker($model->getDeliveryDate()) : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control exchange-rate-date update-exchange-rate is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $currentPaymentCurrency = null ;
                ?>

                <div class="col-md-2">
                    <label><?php echo e(__('Select Invoice Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="currency" class="form-control
							
							invoice-currency-class
							currency-class update-exchange-rate 
							 current-invoice-currency  ajax-get-invoice-numbers">
                                
                                <?php $__currentLoopData = isset($currencies) ? $currencies : getBanksCurrencies (); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $selected = isset($model) ? $model->getCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                $selected = $selected ? 'selected':'';
                                if($selected || (isset($singleModel) && $singleModel) ){
                                $currentPaymentCurrency = $currencyId ;
                                }
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
                                <select data-live-search="true" data-actions-box="true" id="supplier_name" name="supplier_id" class="form-control select2-select ajax-get-invoice-numbers">
                                    
                                    
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplierId => $supplierName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($singleModel): ?> selected <?php endif; ?> <?php if(isset($model) && $model->getSupplierName() == $supplierName ): ?> selected <?php endif; ?> value="<?php echo e($supplierId); ?>"><?php echo e($supplierName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="col-md-2">
                    <label><?php echo e(__('Select Payment Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select when-change-trigger-account-type-change name="payment_currency" class="form-control
							
							currency-class
							receiving-currency-class
							update-exchange-rate
							 current-currency">
                                
                                <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $selected = isset($model) ? $model->getPaymentCurrency() == $currencyId : false;
                                $selected = $selected ? 'selected':'';
                                if(!$selected && $currentPaymentCurrency == $currencyId){
                                $selected = 'selected';
                                }
                                ?>
                                <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-2">
                    <label><?php echo e(__('Select Money Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
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
                        <label><?php echo e(__('Paying Branch')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="delivery_branch_id" class="form-control">
                                    <option value="-1"><?php echo e(__('New Branch')); ?></option>
                                    <?php $__currentLoopData = $selectedBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchId=>$branchName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branchId); ?>" <?php echo e(isset($model) && $model->getCashPaymentBranchId() == $branchId ? 'selected' : ''); ?>><?php echo e($branchName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button id="js-delivery-branch" class="btn btn-sm btn-primary"><?php echo e(__('Add New Branch')); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo e(__('Paid Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount() :0); ?>" name="paid_amount[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::CASH_PAYMENT.'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>" placeholder="<?php echo e(__('Paid Amount')); ?>">
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
                    <div class="col-md-3 width-12">
                        <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_paying_currency[<?php echo e(MoneyPayment::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::CASH_PAYMENT); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





















    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label flex-1">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Payable Cheque Information')); ?>

                </h3>
                <div class=" flex-1 d-flex justify-content-end pt-3">
                    <div class="col-md-3 mb-3">
                        <label><?php echo e(__('Balance')); ?> <span class="balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control balance-js" placeholder="<?php echo e(__('Account Balance')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label><?php echo e(__('Net Balance')); ?> <span class="net-balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control net-balance-js" placeholder="<?php echo e(__('Net Balance')); ?>">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6  mb-3">
                        <label> <?php echo __('Payment Bank'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control financial-institution-id">
                                    <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getPayableChequePaymentBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label> <?php echo __('Account Type'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                    <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getPayableChequeAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2 width-12">
                        <label> <?php echo __('Account Number'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getPayableChequeAccountNumber() : 0); ?>" name="account_number[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label><?php echo e(__('Cheque Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="<?php echo e(isset($model) ? $model->getPaidAmount() : 0); ?>" placeholder="<?php echo e(__('Please insert the cheque amount')); ?>" type="text" name="paid_amount[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::PAYABLE_CHEQUE .'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>



                    <div class="col-md-3">
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


                    <div class="col-md-3">
                        <label><?php echo e(__('Cheque Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" value="<?php echo e(isset($model) && $model->payableCheque ? $model->payableCheque->getChequeNumber() : 0); ?>" class="form-control" placeholder="<?php echo e(__('Cheque Number')); ?>">
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_paying_currency[<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>



                    
            </div>
        </div>

    </div>
    </div>

    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label flex-1">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Outgoing Transfer Information')); ?>

                </h3>

                <div class=" flex-1 d-flex justify-content-end pt-3">
                    <div class="col-md-3 mb-3">
                        <label><?php echo e(__('Balance')); ?> <span class="balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control balance-js" placeholder="<?php echo e(__('Account Balance')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label><?php echo e(__('Net Balance')); ?> <span class="net-balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control net-balance-js" placeholder="<?php echo e(__('Net Balance')); ?>">
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label> <?php echo __('Payment <br> Bank'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control financial-institution-id">
                                    <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getOutgoingTransferDeliveryBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 max-w-11">
                        <label> <?php echo __('Outgoing <br> Transfer Amount'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount():0); ?>" name="paid_amount[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyPayment::OUTGOING_TRANSFER .'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>" placeholder="<?php echo e(__('Insert Amount')); ?>">
                        </div>
                    </div>



                    <div class="col-md-3">
                        <label> <?php echo __('Account <br> Type'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
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
                        <label> <?php echo __('Account <br> Number'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getOutgoingTransferAccountNumber() : 0); ?>" name="account_number[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1 max-w-6">
                        <label><?php echo __('Exchange <br> Rate'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_paying_currency[<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyPayment::OUTGOING_TRANSFER); ?>">
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


            <div class="js-template hidden">
                <div class="col-md-12 js-duplicate-node">

                    <div class=" kt-margin-b-10 border-class">
                        <div class="form-group row align-items-end settlement-row-parent">

                            <div class="col-md-1 width-10">
                                <label> <?php echo e(__('Invoice Number')); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <input readonly class="form-control js-invoice-number" name="settlements[][invoice_number]" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 width-9">
                                <label> <?php echo e(__('Invoice Date')); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 width-9">
                                <label> <?php echo e(__('Due Date')); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input name="settlements[][invoice_due_date]" type="text" class="form-control js-invoice-due-date" disabled />

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 width-8">
                                <label> <?php echo e(__('Currency')); ?> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][currency]" type="text" disabled class="form-control js-currency">
                                </div>
                            </div>

                            <div class="col-md-1 width-12">
                                <label> <?php echo e(__('Net Invoice Amount')); ?> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][net_invoice_amount]" type="text" disabled class="form-control js-net-invoice-amount">
                                </div>
                            </div>


                            <div class="col-md-2 width-12">
                                <label> <?php echo e(__('Paid Amount')); ?> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][paid_amount]" type="text" disabled class="form-control js-paid-amount">
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label> <?php echo e(__('Net Balance')); ?> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][net_balance]" type="text" readonly class="form-control js-net-balance">
                                </div>
                            </div>



                            <div class="col-md-1 width-9-5">
                                <label> <?php echo e(__('Settlement Amount')); ?> <span class="text-danger ">*</span></label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][settlement_amount]" placeholder="" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
                                </div>
                            </div>
                            <div class="col-md-1 width-9-5">
                                <label> <?php echo e(__('Withhold Amount')); ?> <span class="text-danger ">*</span> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][withhold_amount]" placeholder="" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="add-new btn btn-primary d-block" data-toggle="modal" data-target="#add-new-customer-modal--0">
                                    <?php echo e(__('Allocate')); ?>

                                </button>

                                <div class="modal fade modal-class-js allocate-modal-class" id="add-new-customer-modal--0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Allocate')); ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group row justify-content-center">
                                                    <?php
                                                    $index = 0 ;
                                                    ?>

                                                    
                                                    <?php
                                                    $tableId = 'allocations';

                                                    $repeaterId = 'm_repeater--0';

                                                    ?>
                                                    
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['initialJs' => false,'repeaterWithSelect2' => true,'parentClass' => 'show-class-js','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                                         <?php $__env->slot('ths'); ?> 
                                                            <?php $__currentLoopData = [
                                                            __('Customer')=>'th-main-color',
                                                            __('Contract Name')=>'th-main-color',
                                                            __('Contract Code')=>'th-main-color',
                                                            __('Contract Amount')=>'th-main-color',
                                                            __('Allocate Amount')=>'th-main-color',
                                                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title=>$classes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ''.e($classes).'','title' => $title]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ''.e($classes).'','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         <?php $__env->endSlot(); ?>
                                                         <?php $__env->slot('trs'); ?> 
                                                            <?php
                                                            $rows = [-1] ;
                                                            /// $rows = isset($model) ? $model->settlementAllocations :[-1] ;

                                                            ?>
                                                            <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlementAllocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                            $fullPath = new \App\Models\SettlementAllocation;
                                                            if( !($settlementAllocation instanceof $fullPath) ){
                                                            unset($settlementAllocation);
                                                            }
                                                            ?>
                                                            <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>

                                                                <td class="text-center">
                                                                    <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
                                                                    <div class="">
                                                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                                        </i>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['insideModalWithJs' => true,'selectedValue' => isset($settlementAllocation) && $settlementAllocation->partner_id ? $settlementAllocation->partner_id : '','options' => formatOptionsForSelect($clientsWithContracts),'addNew' => false,'class' => ' suppliers-or-customers-js custom-w-25','dataFilterType' => ''.e('create').'','all' => false,'dataName' => 'partner_id','name' => 'partner_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['insideModalWithJs' => true,'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($settlementAllocation) && $settlementAllocation->partner_id ? $settlementAllocation->partner_id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatOptionsForSelect($clientsWithContracts)),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => ' suppliers-or-customers-js custom-w-25','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-name' => 'partner_id','name' => 'partner_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                                </td>

                                                                <td>
                                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['insideModalWithJs' => true,'dataCurrentSelected' => ''.e(isset($settlementAllocation) ? $settlementAllocation->id : '').'','selectedValue' => isset($settlementAllocation) ? $settlementAllocation->contract_id : '','options' => [],'addNew' => false,'class' => ' contracts-js   custom-w-25','dataFilterType' => ''.e('create').'','all' => false,'dataName' => 'contract_id','name' => 'contract_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['insideModalWithJs' => true,'data-current-selected' => ''.e(isset($settlementAllocation) ? $settlementAllocation->id : '').'','selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($settlementAllocation) ? $settlementAllocation->contract_id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => ' contracts-js   custom-w-25','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-name' => 'contract_id','name' => 'contract_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                                </td>

                                                                <td>
                                                                    <div class="kt-input-icon custom-w-20">
                                                                        <div class="input-group">
                                                                            <input disabled type="text" class="form-control contract-code " value="">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="kt-input-icon custom-w-15">
                                                                        <div class="input-group">
                                                                            <input disabled type="text" class="form-control contract-amount" value="0">
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                                <td>
                                                                    <div class="kt-input-icon custom-w-15">
                                                                        <div class="input-group">
                                                                            <input type="text" data-name="allocation_amount" name="allocation_amount" class="form-control allocation-amount-class" value="<?php echo e(isset($settlementAllocation) ? $settlementAllocation->getAmount(): 0); ?>">
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>



                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                         <?php $__env->endSlot(); ?>




                                                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    















































































                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


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
<script src="/custom/money-payment.js">

</script>

<script>
    $(document).on('change', '.settlement-amount-class', function() {

    })
    $(function() {
        $('#type').trigger('change');
    })

    $(document).on('change', 'select#type', function(e) {
        const moneyType = $(this).val();
        const activeClass = 'js-' + moneyType + '-received-amount';
        const invoiceCurrency = $('select.invoice-currency-class').val();
        const receivingCurrency = $('select.receiving-currency-class').val();
        //  if (invoiceCurrency != receivingCurrency) {
        //      $('.main-amount-class[data-type="' + moneyType + '"]').removeClass(activeClass)
        //      $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').addClass(activeClass)
        //  } else {
        //      $('.main-amount-class[data-type="' + moneyType + '"]').addClass(activeClass)
        //      $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').removeClass(activeClass)
        //  }
    })
    $(document).on('change', 'select.currency-class', function() {
        const invoiceCurrency = $('select.invoice-currency-class').val();
        const receivingCurrency = $('select.receiving-currency-class').val();
        const moneyType = $('select#type').val();
        if (invoiceCurrency != receivingCurrency) {
            $('.show-only-when-invoice-currency-not-equal-receiving-currency').removeClass('hidden')

        } else {
            // hide 

            $('.show-only-when-invoice-currency-not-equal-receiving-currency').addClass('hidden')
        }

    })
    $(document).on('change', '.recalculate-amount-class', function() {
        const moneyType = $(this).attr('data-type')
        const amount = $('.main-amount-class[data-type="' + moneyType + '"]').val();
        const exchangeRate = $('.exchange-rate-class[data-type="' + moneyType + '"]').val();
        const amountAfterExchangeRate = amount * exchangeRate;
        $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').val(amountAfterExchangeRate).trigger('change')
        $('.js-settlement-amount:eq(0)').trigger('change')
    })
    $(document).on('change', 'select[when-change-trigger-account-type-change]', function(e) {
        $('select.js-update-account-number-based-on-account-type').trigger('change')
    });

</script>
<script>
    $(document).on('change', '.js-account-number', function() {
        const parent = $(this).closest('.js-section-parent');
        const financialInstitutionId = parent.find('select.financial-institution-id').val()
        const accountNumber = $(this).val();
        const accountType = parent.find('select.js-update-account-number-based-on-account-type').val();
        $.ajax({
            url: "<?php echo e(route('update.balance.and.net.balance.based.on.account.number',['company'=>$company->id])); ?>"
            , data: {
                accountNumber
                , accountType
                , financialInstitutionId
            }
            , type: "get"
            , success: function(res) {
                if (res.balance_date) {
                    $(parent).find('.balance-date-js').html('[ ' + res.balance_date + ' ]')
                }
                if (res.net_balance_date) {
                    $(parent).find('.net-balance-date-js').html('[ ' + res.net_balance_date + ' ]')
                }
                $(parent).find('.net-balance-js').val(number_format(res.net_balance))
                $(parent).find('.balance-js').val(number_format(res.balance))

            }
        })
    })
    $(function() {
        $('select.currency-class').trigger('change')
        $('.recalculate-amount-class').trigger('change')
    })

</script>


<script>
    $(document).on('change', 'select.suppliers-or-customers-js', function() {
        const parent = $(this).closest('tr')
        const partnerId = parseInt($(this).val())
        const model = $('#model_type').val()
        let inEditMode = "<?php echo e($inEditMode ?? 0); ?>";

        $.ajax({
            url: "<?php echo e(route('get.contracts.for.customer.or.supplier',['company'=>$company->id])); ?>"
            , data: {
                partnerId
                , model
                , inEditMode
            }
            , type: "get"
            , success: function(res) {
                let contracts = '';
                const currentSelected = $(parent).find('select.contracts-js').data('current-selected')
                for (var contract of res.contracts) {
                    contracts += `<option ${currentSelected ==contract.id ? 'selected' :'' } value="${contract.id}" data-code="${contract.code}" data-amount="${contract.amount}" data-currency="${contract.currency}" >${contract.name}</option>`;
                }
                parent.find('select.contracts-js').empty().append(contracts).trigger('change')
            	  parent.find('select.contracts-js').selectpicker("refresh")
            }
        })
    })
    $(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('tr')
        const code = $(this).find('option:selected').data('code')
        const amount = $(this).find('option:selected').data('amount')
        const currency = $(this).find('option:selected').data('currency').toUpperCase()
        $(parent).find('.contract-code').val(code)
        $(parent).find('.contract-amount').val(number_format(amount) + ' ' + currency)

    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyPayments/form.blade.php ENDPATH**/ ?>