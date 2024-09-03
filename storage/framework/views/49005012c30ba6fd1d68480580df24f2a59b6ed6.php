<?php $__env->startSection('css'); ?>
<?php
use App\Models\CashExpense ;
use App\Models\SupplierInvoice;
$banks =[];
$selectedBanks = [];
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
	.custom-contract-amount-css,
	.max-w-12
	{
		 max-width: initial !important;
		width: 12% !important;
		flex: initial !important;
			
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
<?php echo e(__('Cash Expense Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        
<form method="post" action="<?php echo e(isset($model) ?  route('update.cash.expense',['company'=>$company->id,'cashExpense'=>$model->id]) :route('store.cash.expense',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
    <input id="js-money-payment-id" type="hidden" name="cash_expense_id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
    <input type="hidden" id="ajax-invoice-item" data-single-model="<?php echo e($singleModel ? 1 : 0); ?>" value="<?php echo e($singleModel ? $invoiceNumber : 0); ?>">
    <?php echo csrf_field(); ?>
    <?php if(isset($model)): ?>
    <?php echo method_field('put'); ?>
    <?php endif; ?>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Cash Expense')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-md-3">
                    <label><?php echo e(__('Payment Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="payment_date" value="<?php echo e(isset($model) ? formatDateForDatePicker($model->getPaymentDate()) : formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                
            


        <div class="col-md-2 mb-4">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'CashExpenseCategory','addNewModalModalTitle' => __('Expense Category'),'options' => $cashExpenseCategories,'addNew' => false,'label' => __('Expense Category'),'class' => 'select2-select expense_category  ','dataUpdateCategoryNameBasedOnCategory' => true,'dataFilterType' => ''.e('create').'','all' => false,'name' => 'expense_category_id','id' => 'expense_category_id','selectedValue' => isset($model) ? $model->getExpenseCategoryId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CashExpenseCategory'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Category')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cashExpenseCategories),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expense Category')),'class' => 'select2-select expense_category  ','data-update-category-name-based-on-category' => true,'data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'expense_category_id','id' => 'expense_category_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getExpenseCategoryId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>


        <div class="col-md-2 mb-4">
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'CashExpenseCategoryName','addNewModalModalTitle' => __('Category Name'),'previousSelectNameInDB' => 'cash_expense_category_id','previousSelectMustBeSelected' => true,'previousSelectSelector' => 'select.expense_category','previousSelectTitle' => __('Category Name'),'options' => [],'addNew' => false,'label' => __('Category Name'),'class' => 'select2-select category_name  ','dataFilterType' => ''.e('create').'','all' => false,'name' => 'cash_expense_category_name_id','id' => ''.e('cash_expense_category_name_id').'','selectedValue' => isset($model) ? $model->getCashExpenseCategoryNameId() : 0,'dataCurrentSelected' => ''.e(isset($model) ? $model->getCashExpenseCategoryNameId() : 0).'']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CashExpenseCategoryName'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Category Name')),'previous-select-name-in-dB' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cash_expense_category_id'),'previous-select-must-be-selected' => true,'previous-select-selector' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('select.expense_category'),'previous-select-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Category Name')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Category Name')),'class' => 'select2-select category_name  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'cash_expense_category_name_id','id' => ''.e('cash_expense_category_name_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getCashExpenseCategoryNameId() : 0),'data-current-selected' => ''.e(isset($model) ? $model->getCashExpenseCategoryNameId() : 0).'']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>

        <div class="col-md-2">
            <label><?php echo e(__('Select Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>

            <div class="kt-input-icon">
                <div class="input-group date">
                    <select when-change-trigger-account-type-change name="currency" class="form-control
							
							currency-class
							receiving-currency-class
							
							 current-currency">
                        
                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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


        <div class="col-md-2">
            <label><?php echo e(__('Select Payment Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
            <div class="kt-input-icon">
                <div class="input-group date">
                    <select required name="type" id="type" class="form-control">
                        <option value="" selected><?php echo e(__('Select')); ?></option>
                        <option <?php if(isset($model) && $model->isCashPayment() ): ?> selected <?php endif; ?> value="<?php echo e(CashExpense::CASH_PAYMENT); ?>"><?php echo e(__('Cash Payment')); ?></option>
                        <option <?php if(isset($model) && $model->isPayableCheque() ): ?> selected <?php endif; ?> value="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>"><?php echo e(__('Payable Cheques')); ?></option>
                        <option <?php if(isset($model) && $model->isOutgoingTransfer()): ?> selected <?php endif; ?> value="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>"><?php echo e(__('Outgoing Transfer')); ?></option>
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

    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(CashExpense::CASH_PAYMENT); ?>">
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
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount() :0); ?>" name="paid_amount[<?php echo e(CashExpense::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. CashExpense::CASH_PAYMENT.'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(CashExpense::CASH_PAYMENT); ?>" placeholder="<?php echo e(__('Paid Amount')); ?>">
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
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(CashExpense::CASH_PAYMENT); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(CashExpense::CASH_PAYMENT); ?>">
                        </div>
                    </div>

                    <div class="col-md-2 max-w-12 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="0" type="text" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(CashExpense::CASH_PAYMENT); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





















    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>">
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

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>]" class="form-control financial-institution-id">
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
                                <select name="account_type[<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>]" class="form-control js-update-account-number-based-on-account-type">
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
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getPayableChequeAccountNumber() : 0); ?>" name="account_number[<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label><?php echo e(__('Cheque Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="<?php echo e(isset($model) ? $model->getPaidAmount() : 0); ?>" placeholder="<?php echo e(__('Please insert the cheque amount')); ?>" type="text" name="paid_amount[<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed <?php echo e('js-'. CashExpense::PAYABLE_CHEQUE .'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>">
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
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>

                    <div class="col-md-1  show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(CashExpense::PAYABLE_CHEQUE); ?>">
                        </div>
                    </div>



                    
            </div>
        </div>

    </div>
    </div>

    
    <div class="kt-portlet js-section-parent hidden" id="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>">
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

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>]" class="form-control financial-institution-id">
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
                            <input data-max-cheque-value="0" type="text" value="<?php echo e(isset($model) ? $model->getPaidAmount():0); ?>" name="paid_amount[<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>]" class="form-control greater-than-or-equal-zero-allowed <?php echo e('js-'. CashExpense::OUTGOING_TRANSFER .'-paid-amount'); ?>  main-amount-class recalculate-amount-class" data-type="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>" placeholder="<?php echo e(__('Insert Amount')); ?>">
                        </div>
                    </div>



                    <div class="col-md-3">
                        <label> <?php echo __('Account <br> Type'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>]" class="form-control js-update-account-number-based-on-account-type">
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
                                <select data-current-selected="<?php echo e(isset($model) ? $model->getOutgoingTransferAccountNumber() : 0); ?>" name="account_number[<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>]" class="form-control js-account-number">
                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1 max-w-6">
                        <label><?php echo __('Exchange <br> Rate'); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input value="<?php echo e(isset($model) ? $model->getExchangeRate() : 1); ?>" placeholder="<?php echo e(__('Exchange Rate')); ?>" type="text" name="exchange_rate[<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label><?php echo e(__('Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                        <div class="kt-input-icon">
                            <input readonly value="<?php echo e(0); ?>" type="text"  class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="<?php echo e(CashExpense::OUTGOING_TRANSFER); ?>">
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>






    
    <div class="kt-portlet" id="connecting">

                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Allocating With Customer Contracts')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">


                    <div class="form-group row justify-content-center">
                        <?php
                        $index = 0 ;
                        ?>

                        
                        <?php
                        $tableId = $contractsRelationName;

                        $repeaterId = 'm_repeater_7';

                        ?>
                        
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'show-class-js','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                             <?php $__env->slot('ths'); ?> 
                                <?php $__currentLoopData = [
                                __('Customer')=>'col-md-3',
                                __('Contract Name')=>'col-md-3',
                                __('Contract Code')=>'col-md-2',
                                __('Contract Amount')=>'col-md-2 custom-contract-amount-css',
                                __('Allocate Amount')=>'col-md-2 custom-contract-amount-css',
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
                                $rows = isset($model) ? $model->contracts :[-1] ;
						
                                ?>
                                <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentContract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
								$fullPath  = new \App\Models\Contract ;
                                if( !($currentContract instanceof $fullPath) ){
                                unset($currentContract);
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['pleaseSelect' => true,'selectedValue' => isset($currentContract) && $currentContract->client ? $currentContract->client->id : '','options' => formatOptionsForSelect($clientsWithContracts),'addNew' => false,'class' => 'select2-select suppliers-or-customers-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => '@if($isRepeater) partner_id @else '.e($tableId).'[0][partner_id] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['pleaseSelect' => true,'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($currentContract) && $currentContract->client ? $currentContract->client->id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatOptionsForSelect($clientsWithContracts)),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select suppliers-or-customers-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) partner_id @else '.e($tableId).'[0][partner_id] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </td>

                                    <td>
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['pleaseSelect' => true,'dataCurrentSelected' => ''.e(isset($currentContract) ? $currentContract->id : '').'','selectedValue' => isset($currentContract) ? $currentContract->id : '','options' => [],'addNew' => false,'class' => 'select2-select  contracts-js repeater-select  ','dataFilterType' => ''.e('create').'','all' => false,'name' => '@if($isRepeater) contract_id @else '.e($tableId).'[0][contract_id] @endif']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['pleaseSelect' => true,'data-current-selected' => ''.e(isset($currentContract) ? $currentContract->id : '').'','selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($currentContract) ? $currentContract->id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'select2-select  contracts-js repeater-select  ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => '@if($isRepeater) contract_id @else '.e($tableId).'[0][contract_id] @endif']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </td>

                                    <td>
                                        <div class="kt-input-icon">
                                            <div class="input-group">
                                                <input disabled type="text" class="form-control contract-code" value="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="kt-input-icon ">
                                            <div class="input-group">
                                                <input disabled type="text" class="form-control contract-amount" value="0">
                                            </div>
                                        </div>
                                    </td>
                                  

  										<td>
                                        <div class="kt-input-icon ">
                                            <div class="input-group">
                                                <input  type="text" name="amount" class="form-control " value="<?php echo e(isset($currentContract) ? $currentContract->pivot->amount : 0); ?>">
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
        $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').val(number_format(amountAfterExchangeRate)).trigger('change')
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
	
        $(document).on('click', '.trigger-add-new-modal', function() {
            var additionalName = '';
            if ($(this).attr('data-previous-must-be-opened')) {
                const previosSelectorQuery = $(this).attr('data-previous-select-selector');
                const previousSelectorValue = $(previosSelectorQuery).val()
                const previousSelectorTitle = $(this).attr('data-previous-select-title');
                if (!previousSelectorValue) {
                    Swal.fire({
                        text: "<?php echo e(__('Please Select')); ?>" + ' ' + previousSelectorTitle
                        , icon: 'warning'
                    })
                    return;
                }
                const previousSelectorVal = $(previosSelectorQuery).val();
                const previousSelectorHtml = $(previosSelectorQuery).find('option[value="' + previousSelectorVal + '"]').html();
                additionalName = "<?php echo e(' '. __('For')); ?>  [" + previousSelectorHtml + ' ]'
            }
            const parent = $(this).closest('label').parent();
            parent.find('select');
            const type = $(this).attr('data-modal-title')
            const name = $(this).attr('data-modal-name')
            $('.modal-title-add-new-modal-' + name).html("<?php echo e(__('Add New ')); ?>" + type + additionalName);
            parent.find('.modal').modal('show')
        })
        $(document).on('click', '.store-new-add-modal', function() {
            const that = $(this);
            $(this).attr('disabled', true);
            const modalName = $(this).attr('data-modal-name');
            const modalType = $(this).attr('data-modal-type');
            const modal = $(this).closest('.modal');
            const value = modal.find('input.name-class-js').val();
            const previousSelectorSelector = $(this).attr('data-previous-select-selector');
            const previousSelectorValue = previousSelectorSelector ? $(previousSelectorSelector).val() : null;
            const previousSelectorNameInDb = $(this).attr('data-previous-select-name-in-db');

            $.ajax({
                url: "<?php echo e(route('admin.store.new.modal',['company'=>$company->id ?? 0  ])); ?>"
                , data: {
                    "_token": "<?php echo e(csrf_token()); ?>"
                    , "modalName": modalName
                    , "modalType": modalType
                    , "value": value
                    , "previousSelectorNameInDb": previousSelectorNameInDb
                    , "previousSelectorValue": previousSelectorValue
                }
                , type: "POST"
                , success: function(response) {
                    $(that).attr('disabled', false);
                    modal.find('input').val('');
                    $('.modal').modal('hide')
                    if (response.status) {
                        const allSelect = $('select[data-modal-name="' + modalName + '"][data-modal-type="' + modalType + '"]');
                        const allSelectLength = allSelect.length;
                        allSelect.each(function(index, select) {
                            var isSelected = '';
                            if (index == (allSelectLength - 1)) {
                                isSelected = 'selected';
                            }
                            $(select).append(`<option ` + isSelected + ` value="` + response.id + `">` + response.value + `</option>`).selectpicker('refresh').trigger('change')
                        })

                    }
                }
                , error: function(response) {}
            });
        })
		
		
		
    $(function() {
        $('select.currency-class').trigger('change')
        $('.recalculate-amount-class').trigger('change')
    })
	

</script>

       <script>
                $(document).on('change', '[data-update-category-name-based-on-category]', function(e) {
                    const expenseCategoryId = $('select.expense_category').val()
                    if (!expenseCategoryId) {
                        return;
                    }
                    $.ajax({
                        url: "<?php echo e(route('update.expense.category.name.based.on.category',['company'=>$company->id])); ?>"
                        , data: {
                            expenseCategoryId
                        , }
                        , type: "GET"
                        , success: function(res) {
                            var options = '';
                            var currentSelectedId = $('select.category_name').attr('data-current-selected')
                            for (var categoryNameId in res.categoryNames) {
                                var categoryName = res.categoryNames[categoryNameId];
                                options += `<option ${currentSelectedId == categoryNameId ? 'selected' : '' } value="${categoryNameId}"> ${categoryName}  </option> `;
                            }
                            $('select.category_name').empty().append(options).selectpicker("refresh");
                            $('select.category_name').trigger('change')
                        }
                    })
                })
                $('[data-update-category-name-based-on-category]').trigger('change')

            </script>

<script>
$(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('tr')
        const code = $(this).find('option:selected').data('code')
        const amount = $(this).find('option:selected').data('amount')
        const currency = $(this).find('option:selected').data('currency').toUpperCase()
        $(parent).find('.contract-code').val(code)
        $(parent).find('.contract-amount').val(number_format(amount) + ' '  + currency )
        // $(parent).find('.contract-currency').val(currency)

    })
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
            }
        })
    })
    $(function() {
        $('select.suppliers-or-customers-js').trigger('change')
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/cashExpenses/form.blade.php ENDPATH**/ ?>