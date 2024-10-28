<?php $__env->startSection('css'); ?>
<?php
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived ;
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
.width-17{
        max-width: initial !important;
        width: 17% !important;
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
<?php echo e(__('Money Received Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="<?php echo e(isset($model) ?  route('update.money.receive',['company'=>$company->id,'moneyReceived'=>$model->id]) :route('store.money.receive',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
            <input type="hidden" name="current_cheque_id" value="<?php echo e(isset($model) && $model->cheque ? $model->cheque->id : 0); ?>">
            <input type="hidden" name="current_branch" value="<?php echo e(isset($model) && $model->cashInSafe ? $model->cashInSafe->receiving_branch_id : 0); ?>">
            <input id="js-money-received-id" type="hidden" name="money_received_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
			
            <input type="hidden" id="ajax-invoice-item" data-single-model="<?php echo e($singleModel ? 1 : 0); ?>" value="<?php echo e($singleModel ? $invoiceNumber : 0); ?>">
            <input id="js-down-payment-id" type="hidden" name="down_payment_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
			
            <?php echo csrf_field(); ?>
            <?php if(isset($model)): ?>
            <?php echo method_field('put'); ?>
            <?php endif; ?>
            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Money Received')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-2 mb-3">
                            <label><?php echo e(__('Receiving Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="text" name="receiving_date" max-date="<?php echo e(formatDateForDatePicker(now())); ?>" value="<?php echo e(isset($model) ? formatDateForDatePicker($model->getReceivingDate()) : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control is-date-css exchange-rate-date update-exchange-rate" readonly placeholder="Select date" id="kt_datepicker_max_date_is_today" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						 <div class="col-md-2">
                            <label><?php echo e(__('Partner Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required name="partner_type" id="partner_type" class="form-control">
										<?php $__currentLoopData = ['is_customer'=>__('Customer'),'is_subsidiary_company'=>__('Subsidiary Company') , 'is_shareholder'=>__('Shareholder') , 'is_employee'=>__('Employee')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type =>$title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 	       <option  <?php if(isset($model) && $model->isUserType($type) ): ?> selected <?php endif; ?> value="<?php echo e($type); ?>"><?php echo e($title); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                            </div>
							
						

                        <div class="col-md-1" id="invoice-currency-div-id">
                            <label class="text-nowrap"><?php echo e(__('Invoice Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select id="invoice-currency-id" name="currency" class="form-control 
							currency-class
							contract-currency
							ajax-update-contracts
							<?php if(!$singleModel && !isset($model)): ?>
							invoice-currency-class 
							<?php endif; ?>
							update-exchange-rate
							current-invoice-currency
							
							 ajax-get-invoice-numbers">
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

                            <label><?php echo e(__('Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select data-current-selected="<?php echo e(isset($model) ? $model->getCustomerName() : ''); ?>" data-live-search="true" data-actions-box="true" id="customer_name" name="customer_id" class="form-control select2-select ajax-get-invoice-numbers  ajax-update-contracts customer-select">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerId => $customerName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($singleModel): ?> selected <?php endif; ?> <?php if(isset($model) && $model->getCustomerName() == $customerName ): ?> selected <?php endif; ?> value="<?php echo e($customerId); ?>"><?php echo e($customerName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-2 ">
                            <label class="text-nowrap"><?php echo e(__('Receiving Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select id="receiving-currency-id" when-change-trigger-account-type-change name="receiving_currency" class="form-control 
							current-currency
							currency-class
							receiving-currency-class update-exchange-rate
							
							">
                                        
                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $selected = isset($model) ? $model->getReceivingCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                        $selected = isset($singleModel) && in_array($currentName,$currencies) ? 'selected':$selected;
										$selected = $selected ? 'selected':'';
										
                                        ?>
                                        <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label><?php echo e(__('Money Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required name="type" id="type" class="form-control">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>

                                        <option <?php if(isset($model) && $model->isCashInSafe() ): ?> selected <?php endif; ?> value="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>"><?php echo e(__('Cash In Safe')); ?></option>
                                        <option <?php if(isset($model) && $model->isCashInBank() ): ?> selected <?php endif; ?> value="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>"><?php echo e(__('Bank Deposit')); ?></option>
                                        <option <?php if(isset($model) && $model->isCheque() ): ?> selected <?php endif; ?> value="<?php echo e(MoneyReceived::CHEQUE); ?>"><?php echo e(__('Cheque')); ?></option>
                                        <option <?php if(isset($model) && $model->isIncomingTransfer()): ?> selected <?php endif; ?> value="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>"><?php echo e(__('Incoming Transfer')); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal fade" id="js-choose-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Select Bank')); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <select id="js-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId => $bankEnAndAr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option data-name="<?php echo e($bankEnAndAr); ?>" value="<?php echo e($bankId); ?>"><?php echo e($bankEnAndAr); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                            <button id="js-append-bank-name-if-not-exist" type="button" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>







                            <div class="modal fade" id="js-choose-receiving-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Select receiving Bank')); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select id="js-receiving-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId => $bankEnAndAr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option data-name="<?php echo e($bankEnAndAr); ?>" value="<?php echo e($bankId); ?>"><?php echo e($bankEnAndAr); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                            <button id="js-append-receiving-bank-name-if-not-exist" type="button" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            <div class="modal fade" id="js-choose-receiving-branch-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Branch')); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="js-receiving-branch-names" class="form-control">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                            <button id="js-append-receiving-branch-name-if-not-exist" type="button" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                    </div>
                </div>
            </div>

            
            <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Cash Information')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5 width-45 ">
                                <label><?php echo e(__('Select Receiving Branch')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="receiving_branch_id" class="form-control">
                                            <option value="-1"><?php echo e(__('Select Branch')); ?></option>
                                            <?php $__currentLoopData = $selectedBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchId=>$branchName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($branchId); ?>" <?php echo e(isset($model) && $model->getCashInSafeReceivingBranchId() == $branchId ? 'selected' : ''); ?>><?php echo e($branchName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button id="js-receiving-branch" class="btn btn-sm btn-primary"><?php echo e(__('Add New Branch')); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label><?php echo e(__('Received Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getReceivedAmount() :0); ?>" name="received_amount[<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyReceived::CASH_IN_SAFE .'-received-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>" placeholder="<?php echo e(__('Received Amount')); ?>">
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
                                    <input type="text" name="receipt_number" value="<?php echo e(isset($model) ?  $model->getCashInSafeReceiptNumber()  : ''); ?>" class="form-control" placeholder="<?php echo e(__('Receipt Number')); ?>">
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
                                    <input data-current-value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>">
                                </div>
                            </div>

                            <div class="col-md-2 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                                <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_receiving_currency[<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyReceived::CASH_IN_SAFE); ?>">
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>


            
            
            <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Bank Deposit Information')); ?>

                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5 width-45">
                                <label><?php echo e(__('Select Receiving Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">

                                        <select js-when-change-trigger-change-account-type data-financial-institution-id name="receiving_bank_id[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control ">
                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getCashInBankReceivingBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <label><?php echo e(__('Deposit Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getReceivedAmount():0); ?>" name="received_amount[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyReceived::CASH_IN_BANK .'-received-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>" placeholder="<?php echo e(__('Insert Amount')); ?>">
                                </div>
                            </div>



                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="account_type[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select data-current-selected="<?php echo e(isset($model) ? $model->getCashInBankAccountNumber(): 0); ?>" name="account_number[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control js-account-number">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1">
                                <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-current-value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>">
                                </div>
                            </div>

                            <div class="col-md-2 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                                <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_receiving_currency[<?php echo e(MoneyReceived::CASH_IN_BANK); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyReceived::CASH_IN_BANK); ?>">
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>




















            
            <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyReceived::CHEQUE); ?>">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Cheque Information')); ?>

                        </h3>
                    </div>
                </div>



                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5 width-45">
                                <label><?php echo e(__('Select Drawee Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        
                                        <select name="drawee_bank_id" class="form-control ">
                                            <?php $__currentLoopData = $selectedBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId=>$bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bankId); ?>" <?php echo e(isset($model) && $model->cheque && $model->cheque->getDraweeBankId() == $bankId ? 'selected':''); ?>><?php echo e($bankName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button id="js-drawee-bank" class="btn btn-sm btn-primary"><?php echo e(__('Add New Bank')); ?></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Cheque Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" value="<?php echo e(isset($model) ? $model->getReceivedAmount() : 0); ?>" placeholder="<?php echo e(__('Please insert the cheque amount')); ?>" type="text" name="received_amount[<?php echo e(MoneyReceived::CHEQUE); ?>] " class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyReceived::CHEQUE .'-received-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CHEQUE); ?>">
                                </div>
                            </div>




                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Due Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="text" value="<?php echo e(isset($model) && $model->cheque ? formatDateForDatePicker($model->cheque->getDueDate()):formatDateForDatePicker(now()->format('Y-m-d'))); ?>" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Cheque Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="cheque_number" value="<?php echo e(isset($model) && $model->cheque ? $model->cheque->getChequeNumber() : 0); ?>" class="form-control" placeholder="<?php echo e(__('Cheque Number')); ?>">
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-current-value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyReceived::CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::CHEQUE); ?>">
                                </div>
                            </div>

                            <div class="col-md-2 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                                <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_receiving_currency[<?php echo e(MoneyReceived::CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyReceived::CHEQUE); ?>">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            
            <div class="kt-portlet js-section-parent hidden" id="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Incoming Transfer Information')); ?>

                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5 width-45">
                                <label><?php echo e(__('Select Receiving Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">

                                        <select js-when-change-trigger-change-account-type data-financial-institution-id name="receiving_bank_id[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control ">
                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getIncomingTransferReceivingBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <label><?php echo e(__('Incoming Transfer Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getReceivedAmount():0); ?>" name="received_amount[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control greater-than-or-equal-zero-allowed <?php echo e('js-'. MoneyReceived::INCOMING_TRANSFER .'-received-amount'); ?> main-amount-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>" placeholder="<?php echo e(__('Insert Amount')); ?>">
                                </div>
                            </div>



                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="account_type[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getIncomingTransferAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select data-current-selected="<?php echo e(isset($model) ? $model->getIncomingTransferAccountNumber() : 0); ?>" name="account_number[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control js-account-number">
                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1">
                                <label><?php echo e(__('Exchange Rate')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-current-value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>">
                                </div>
                            </div>

                            <div class="col-md-2 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                                <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input readonly value="<?php echo e(0); ?>" type="text" name="amount_in_receiving_currency[<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(MoneyReceived::INCOMING_TRANSFER); ?>">
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
            </div>






            
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
                            <?php echo CustomerInvoice::getSettlementsTemplate(); ?>

                        </div>
                    </div>

                    <hr>
                    <?php echo $__env->make('reports.moneyReceived.unapplied-contract', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					
					
					
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

</script>
<script src="/custom/money-receive.js">

</script>

<script>


    $(function() {
        $('#type').trigger('change');
    })
  
    $(document).on('change', 'select.currency-class', function() {
        const invoiceCurrency = $('select#invoice-currency-id').val();
        const receivingCurrency = $('select#receiving-currency-id').val();
        const moneyType = $('select#type').val();
		const partnerType = $('select#partner_type').val();
		if(partnerType && partnerType != 'is_customer'){
			  $('.show-only-when-invoice-currency-not-equal-receiving-currency').addClass('hidden')
			  return ;
		}
        if (invoiceCurrency != receivingCurrency && invoiceCurrency && receivingCurrency) {
            $('.show-only-when-invoice-currency-not-equal-receiving-currency').removeClass('hidden')
        } else {
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
    $(function() {
        $('select.currency-class').trigger('change')
        $('.recalculate-amount-class').trigger('change')
    })




    $(document).on('change', '.ajax-update-contracts', function(e) {
        e.preventDefault()
        const customerId = $('select.customer-select').val()
        const currency = $('select.contract-currency').val()

        if (customerId && currency) {
            $.ajax({
                url: "<?php echo e(route('get.contracts.for.customer',['company'=>$company->id])); ?>"
                , data: {
                    customerId
                    , currency
                }
                , success: function(res) {
                    let options = '';
                    let selectedContractId = $('#contract-id').attr('data-current-selected')
                    for (id in res.contracts) {
                        options += `<option ${selectedContractId == id ? 'selected' :''} value="${id}">${res.contracts[id]}</option>`
                    }
                    $('select#contract-id').empty().append(options);
                    $('select#contract-id').trigger('change')
                }
            })
        }
    })

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyReceived/form.blade.php ENDPATH**/ ?>