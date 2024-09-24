<?php $__env->startSection('css'); ?>
<?php
use App\Models\BuyOrSellCurrency ;
$bankToBankConst = BuyOrSellCurrency::BANK_TO_BANK;
$bankToSafeConst = BuyOrSellCurrency::BANK_TO_SAFE;
$safeToBankConst = BuyOrSellCurrency::SAFE_TO_BANK;
$safeToSafeConst = BuyOrSellCurrency::SAFE_TO_SAFE;

?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
    }

    label {
        white-space: nowrap !important
    }

    [class*="col"] {
        margin-bottom: 1.5rem !important;
    }

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
        width: 13.5% !important;
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

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="<?php echo e(isset($model) ?  route('buy-or-sell-currencies.update',['company'=>$company->id,'buy_or_sell_currency'=>$model->id]) :route('buy-or-sell-currencies.store',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
            <input type="hidden" name="id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
            <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">

            <?php if(isset($model)): ?>
            <input type="hidden" name="updated_by" value="<?php echo e(auth()->user()->id); ?>">
            <?php else: ?>
            <input type="hidden" name="created_by" value="<?php echo e(auth()->user()->id); ?>">

            <?php endif; ?>
            
            <?php echo csrf_field(); ?>
            <?php if(isset($model)): ?>
            <?php echo method_field('put'); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __((isset($model) ? 'Edit' : 'Add') . ' '  . __('Buy Or Sell Currencies') )]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__((isset($model) ? 'Edit' : 'Add') . ' '  . __('Buy Or Sell Currencies') ))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right">
                        <div class="kt-portlet">


                            <div class="kt-portlet ">
                                <div class="kt-portlet__head">
                                    
                                </div>

                                <div class="kt-portlet__body">
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <label><?php echo e(__('Type')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="input-group">
                                                    <select name="type" class="form-control type">
                                                        <?php $__currentLoopData = BuyOrSellCurrency::getAllTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>" <?php if(isset($model) && $model->getType() == $key ): ?> selected <?php endif; ?> > <?php echo e($title); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Transaction Date'),'required' => true,'model' => $model??null,'name' => 'transaction_date','placeholder' => __('Select Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('transaction_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                            </div>


                                            <div class="col-md-3">
                                                <label><?php echo e(__('Currency To Sell')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="input-group">
                                                    <select js-from-when-change-trigger-change-account-type name="currency_to_sell" class="form-control current-from-currency" js-from-when-change-trigger-change-account-type>
                                                        <option selected><?php echo e(__('Select')); ?></option>
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getCurrencyToSell() == $currencyName ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label><?php echo e(__('Currency To Buy')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="input-group">
                                                    <select js-from-when-change-trigger-change-account-type name="currency_to_buy" class="form-control current-to-currency" js-to-when-change-trigger-change-account-type>
                                                        <option selected><?php echo e(__('Select')); ?></option>
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getCurrencyToBuy() == $currencyName ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-3 ">
                                                <label><?php echo e(__('Currency To Sell Amount')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input type="text" value="<?php echo e(isset($model) ? $model->getAmountToSell():0); ?>" name="currency_to_sell_amount" class="form-control recalculate-amount-in-main-currency amount-js greater-than-or-equal-zero-allowed " placeholder="<?php echo e(__('Insert Amount')); ?>">
                                                </div>
                                            </div>


                                         


                                            <div class="col-md-3 ">
                                                <label><?php echo e(__('Exchange Rate')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input type="text" value="<?php echo e(isset($model) ? $model->getExchangeRate():0); ?>" name="exchange_rate" class="form-control exchange-rate-js recalculate-amount-in-main-currency " placeholder="<?php echo e(__('Exchange Rate')); ?>">
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-3 ">
                                                <label><?php echo e(__('Currency To Buy Amount')); ?>

                                                    
                                                </label>
                                                <div class="kt-input-icon">
													<input type="hidden" class="amount-in-main-currency-js-hidden" name="currency_to_buy_amount" value="<?php echo e(isset($model) ? $model->getAmountToBuy():0); ?>">
                                                    <input readonly type="text" value="<?php echo e(isset($model) ? $model->getAmountToBuy():0); ?>" class="form-control greater-than-or-equal-zero-allowed amount-in-main-currency-js" placeholder="<?php echo e(__('Insert Amount')); ?>">
                                                </div>
                                            </div>










                                            

                                            <div class="col-md-6 show-only-if" data-type="<?php echo e($bankToBankConst.','.$bankToSafeConst); ?>">
                                                <label><?php echo e(__('From Bank')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required js-from-when-change-trigger-change-account-type data-from-financial-institution-id name="from_bank_id" class="form-control ">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getFromBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>




                                            <div data-type="<?php echo e($bankToBankConst.','.$bankToSafeConst); ?>" class="col-md-3 show-only-if">
                                                <label><?php echo e(__('From Account Type')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required required name="from_account_type_id" class="form-control js-from-update-account-number-based-on-account-type">
                                                            
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getFromAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3  show-only-if" data-type="<?php echo e($bankToBankConst.','.$bankToSafeConst); ?>">
                                                <label><?php echo e(__('From Account Number')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required data-from-current-selected="<?php echo e(isset($model) ? $model->getFromAccountNumber(): 0); ?>" name="from_account_number" class="form-control js-from-account-number">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div data-type="<?php echo e($bankToBankConst); ?>" class="col-md-6 show-only-if">
                                                <label><?php echo e(__('To Bank')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">

                                                        <select required js-to-when-change-trigger-change-account-type data-to-financial-institution-id name="to_bank_id" class="form-control ">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getFromBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div data-type="<?php echo e($bankToBankConst); ?>" class="col-md-3 show-only-if ">
                                                <label><?php echo e(__('To Account Type')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required name="to_account_type_id" class="form-control js-to-update-account-number-based-on-account-type">
                                                            
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getToAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div data-type="<?php echo e($bankToBankConst); ?>" class="col-md-3 show-only-if ">
                                                <label><?php echo e(__('To Account Number')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required data-current-selected="<?php echo e(isset($model) ? $model->getToAccountNumber(): 0); ?>" name="to_account_number" class="form-control js-to-account-number">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



 
                                            <div data-type="<?php echo e($safeToBankConst.','.$safeToSafeConst); ?>" class="col-md-2 mb-4 show-only-if">
                                                <label><?php echo e(__('From Branch')); ?> <span class="multi_selection"></span> </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-live-search="true" data-actions-box="true" name="from_branch_id" required class="form-control customers-js kt-bootstrap-select select2-select kt_bootstrap_select ">
                                                            <?php $__currentLoopData = $selectedBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option  <?php if(isset($model) && $id == $model->getToBranchId()): ?>  selected <?php endif; ?>  value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
											

										  
                                            <div data-type="<?php echo e($safeToSafeConst.','.$bankToSafeConst); ?>" class="col-md-2 mb-4 show-only-if">
                                                <label><?php echo e(__('To Branch')); ?> <span class="multi_selection"></span> </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-live-search="true" data-actions-box="true" name="to_branch_id" required class="form-control customers-js kt-bootstrap-select select2-select kt_bootstrap_select ">
                                                            <?php $__currentLoopData = $selectedBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option  <?php if(isset($model) && $id == $model->getToBranchId()): ?>  selected <?php endif; ?> value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
											
											
											
											
											
											
											  <div class="col-md-6 show-only-if" data-type="<?php echo e($safeToBankConst); ?>">
                                                <label><?php echo e(__('To Bank')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">

                                                        <select required js-to-when-change-trigger-change-account-type data-to-financial-institution-id name="to_bank_id" class="form-control ">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getFromBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 show-only-if " data-type="<?php echo e($safeToBankConst); ?>">
                                                <label><?php echo e(__('To Account Type')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required name="to_account_type_id" class="form-control js-to-update-account-number-based-on-account-type">
                                                            
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getToAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 show-only-if" data-type="<?php echo e($safeToBankConst); ?>">
                                                <label><?php echo e(__('To Account Number')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required data-current-selected="<?php echo e(isset($model) ? $model->getToAccountNumber(): 0); ?>" name="to_account_number" class="form-control js-to-account-number">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
											
											





                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <!--end::Form-->

                        <!--end::Portlet-->
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
            $(document).find('.datepicker-input').datepicker({
                dateFormat: 'mm-dd-yy'
                , autoclose: true
            })
            $('#m_repeater_0').repeater({
                initEmpty: false
                , isFirstItemUndeletable: true
                , defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                    $('input.trigger-change-repeater').trigger('change')
                    $(document).find('.datepicker-input').datepicker({
                        dateFormat: 'mm-dd-yy'
                        , autoclose: true
                    })
                    $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                        reinitalizeMonthYearInput(dateInput)
                    });
                    $('input:not([type="hidden"])').trigger('change');
                    $(this).find('.dropdown-toggle').remove();
                    $(this).find('select.repeater-select').selectpicker("refresh");

                },

                hide: function(deleteElement) {
                    if ($('#first-loading').length) {
                        $(this).slideUp(deleteElement, function() {

                            deleteElement();
                            //   $('select.main-service-item').trigger('change');
                        });
                    } else {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement, function() {

                                deleteElement();
                                $('input.trigger-change-repeater').trigger('change')

                            });
                        }
                    }
                }
            });

        </script>

        <script>
            let oldValForInputNumber = 0;
            $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('focus', function() {
                oldValForInputNumber = $(this).val();
                $(this).val('')
            })
            $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('blur', function() {

                if ($(this).val() == '') {
                    $(this).val(oldValForInputNumber)
                }
            })

            $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
                if (!$(this).hasClass('exclude-text')) {
                    let val = $(this).val()
                    val = number_unformat(val)
                    $(this).parent().find('input[type="hidden"]').val(val)

                }
            })

        </script>

    
        <script>
            $(document).on('change', '.js-from-update-account-number-based-on-account-type', function() {
                const val = $(this).val()
                const lang = $('body').attr('data-lang')
                const companyId = $('body').attr('data-current-company-id')
                const repeaterParentIfExists = $(this).closest('[data-repeater-item]')
                const parent = repeaterParentIfExists.length ? repeaterParentIfExists : $(this).closest('.kt-portlet__body')
                const data = []
                let currency = $(this).closest('form').find('select.current-from-currency').val()
                let financialInstitutionBankId = parent.find('[data-from-financial-institution-id]').val()
                financialInstitutionBankId = typeof financialInstitutionBankId !== 'undefined' ? financialInstitutionBankId : $('[data-financial-institution-id]').val()
                if (!val || !currency || !financialInstitutionBankId) {
                    return
                }
                const url = '/' + lang + '/' + companyId + '/money-received/get-account-numbers-based-on-account-type/' + val + '/' + currency + '/' + financialInstitutionBankId
                $.ajax({
                    url
                    , data
                    , success: function(res) {
                        options = ''
                        var selectToAppendInto = $(parent).find('.js-from-account-number[name]')

                        for (key in res.data) {
                            var val = res.data[key]
                            var selected = $(selectToAppendInto).attr('data-current-selected') == val ? 'selected' : ''
                            options += '<option ' + selected + '  value="' + val + '">' + val + '</option>'
                        }

                        selectToAppendInto.empty().append(options)
                    }
                })






            })
            $(document).on('change', '[js-from-when-change-trigger-change-account-type]', function() {
				if($(this).attr('name')){
	                $(this).closest('.kt-portlet__body').find('.js-from-update-account-number-based-on-account-type').trigger('change')
				}
            })
            $(function() {
                $('.js-from-update-account-number-based-on-account-type[name]').trigger('change')
            })


            $(document).on('change', '.js-to-update-account-number-based-on-account-type', function() {
				if(!$(this).attr('name')){
					return
				}
                const val = $(this).val()
                const lang = $('body').attr('data-lang')
                const companyId = $('body').attr('data-current-company-id')
                const repeaterParentIfExists = $(this).closest('[data-repeater-item]')
                const parent = repeaterParentIfExists.length ? repeaterParentIfExists : $(this).closest('.kt-portlet__body')
                const data = []
                let currency = $(this).closest('form').find('select.current-to-currency').val()
                let financialInstitutionBankId = parent.find('[data-to-financial-institution-id]').val()
                financialInstitutionBankId = typeof financialInstitutionBankId !== 'undefined' ? financialInstitutionBankId : $('[data-financial-institution-id]').val()
                if (!val || !currency || !financialInstitutionBankId) {
                    return
                }
                const url = '/' + lang + '/' + companyId + '/money-received/get-account-numbers-based-on-account-type/' + val + '/' + currency + '/' + financialInstitutionBankId
                $.ajax({
                    url
                    , data
                    , success: function(res) {
                        options = ''
                        var selectToAppendInto = $(parent).find('.js-to-account-number[name]')
                        for (key in res.data) {
                            var val = res.data[key]
                            var selected = $(selectToAppendInto).attr('data-current-selected') == val ? 'selected' : ''
                            options += '<option ' + selected + '  value="' + val + '">' + val + '</option>'
                        }

                        selectToAppendInto.empty().append(options)
                    }
                })






            })
            $(document).on('change', '[js-to-when-change-trigger-change-account-type]', function() {

                $(this).closest('.kt-portlet__body').find('.js-to-update-account-number-based-on-account-type').trigger('change')
            })
            $(function() {
                $('.js-to-update-account-number-based-on-account-type').trigger('change')
            })

        </script>
		
		<script>
		$(document).on('change','.recalculate-amount-in-main-currency',function(){
		const parent = $(this).closest('.kt-portlet__body');
		const amount = parseFloat($(parent).find('.amount-js').val()	)
		const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
		const amountInMainCurrency = parseFloat(amount * exchangeRate) ;
		$(parent).find('.amount-in-main-currency-js-hidden').val( amountInMainCurrency)
		$(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
	})
$(document).on('change','.type',function(e){
	const type = $(this).val()
	$('.show-only-if').addClass('hidden');
	$('.show-only-if [name]').each(function(index,element){
		$(element).attr('data-name',$(element).attr('name'))
	})

	$('.show-only-if input , .show-only-if select').each(function(index,element){
		$(element).removeAttr('name')
	})
	$('.show-only-if[data-type*="'+type+'"]').removeClass('hidden')
	$('.show-only-if[data-type*="'+type+'"] input,.show-only-if[data-type*="'+type+'"] select').each(function(index,element){
		$(element).attr('name',$(element).attr('data-name'))
	})
	
	$('div.show-only-if.hidden input,div.show-only-if.hidden select').removeAttr('required')
	$('div.show-only-if:not(.hidden) input,div.show-only-if.hidden select').removeAttr('required')
})
	
$('.type').trigger('change')	
		</script>


        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/buy-or-sell-currency/form.blade.php ENDPATH**/ ?>