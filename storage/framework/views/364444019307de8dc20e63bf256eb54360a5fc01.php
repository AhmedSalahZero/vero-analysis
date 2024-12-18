<?php $__env->startSection('css'); ?>
<?php
use App\Models\LetterOfCreditIssuance;
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
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
<?php $__env->startSection('sub-header'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form method="post" action="<?php echo e(isset($model) ?  route('update.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$source]) :route('store.letter.of.credit.issuance',['company'=>$company->id,'source'=>$source])); ?>" class="kt-form kt-form--label-right">
            <input type="hidden" name="id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
            <input type="hidden" name="created_by" value="<?php echo e(auth()->user()->id); ?>">
            <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
            <input type="hidden" name="source" value="<?php echo e($source); ?>">
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
                                    <?php echo e(__((isset($model) ? 'Edit' : 'Add') . ' Against Time Of Deposit Letter Of Credit Issuance')); ?>

                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        <?php echo e(__('Letter Of Credit Type')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">
								
								 <div class="col-md-2">
                                        <label><?php echo e(__('Issuance Type')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
                                            <select name="category_name" required class="form-control repeater-select">
												<option value=""><?php echo e(__('Select')); ?></option>
                                                <?php $__currentLoopData = LetterOfCreditIssuance::getCategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if(isset($model) && $model->getCategoryName() == $key ): ?> selected <?php endif; ?> > <?php echo e($title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                    </div>
									
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('Transaction Name'),'type' => 'text','placeholder' => __('Transaction Name'),'name' => 'transaction_name','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Name')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Name')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('transaction_name'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									
									 <div class="col-md-1">
                                        <label><?php echo e(__('LC Currency')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
                                            <select name="lc_currency" class="form-control current-currency" js-when-change-trigger-change-account-type>
                                                <option selected><?php echo e(__('Select')); ?></option>
                                                <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getLcCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
									

                                    <div class="col-md-6">
                                        <label> <?php echo e(__('Financial Bank')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <select id="financial-instutition-id" js-update-outstanding-balance-and-limits js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control">
                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getFinancialInstitutionBankId() == $financialInstitutionBank->id ? 'selected':''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
									
									
                                    <div class="col-md-2">
                                        <label><?php echo e(__('TD Currency')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
                                            <select name="td_currency" class="form-control current-currency" js-when-change-trigger-change-account-type>
                                                <option selected><?php echo e(__('Select')); ?></option>
                                                <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $tdOrCdCurrencyName == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <label><?php echo e(__('Account Type')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select id="account_type_id" name="cd_or_td_account_type_id" class="form-control js-update-account-id-based-on-account-type">
                                                    <?php $__currentLoopData = $cdOrTdAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(isset($model) && ($accountType->id == $model->getCdOrTdAccountTypeId()) ): ?> selected <?php endif; ?> value="<?php echo e($accountType->id); ?>"><?php echo e($accountType->getName()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									

                                    <div class="col-md-3">
                                        <label><?php echo e(__('Account Number')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select js-cd-or-td-account-number js-update-outstanding-balance-and-limits data-current-selected="<?php echo e(isset($model) ? $model->getCdOrTdId(): 0); ?>" name="cd_or_td_id" class="form-control js-account-number">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-2 ">


                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'cd-or-td-amount-id','readonly' => true,'defaultValue' => 0,'model' => $model??null,'label' => __('Amount'),'type' => 'text','placeholder' => '','name' => 'amount','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd-or-td-amount-id'),'readonly' => true,'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>
									
									
									<div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'current-lc-outstanding-balance-id','defaultValue' => 0,'model' => $model??null,'label' => __('LC Outstanding Balance'),'type' => 'text','placeholder' => __('LC Outstanding Balance'),'class' => 'recalculate-cd-or-td-free-to-use','required' => false]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('current-lc-outstanding-balance-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Outstanding Balance')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Outstanding Balance')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalculate-cd-or-td-free-to-use'),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

									
									
									
									 <div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'against-cash-cover-amount-id','defaultValue' => 0,'model' => $model??null,'label' => __('Against Cash Cover'),'type' => 'text','placeholder' => __('Against Cash Cover'),'class' => 'recalculate-cd-or-td-free-to-use','required' => false]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('against-cash-cover-amount-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Against Cash Cover')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Against Cash Cover')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalculate-cd-or-td-free-to-use'),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									
									<div class="col-md-3 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'cd-or-td-free-to-use-amount-id','defaultValue' => 0,'model' => $model??null,'label' => __('CD Free To Use'),'type' => 'text','placeholder' => __(''),'class' => '','required' => false]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd-or-td-free-to-use-amount-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('CD Free To Use')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									


                                    <div class="col-md-2">
                                        <label> <?php echo e(__('LC Type')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>

                                        <select js-update-outstanding-balance-and-limits id="lc-type" name="lc_type" class="form-control js-toggle-bond">
                                            
                                            <?php $__currentLoopData = getLcTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($name); ?>" <?php if(isset($model) && $model->getLcType() == $name ): ?> selected <?php endif; ?> > <?php echo e($nameFormatted); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'current-lc-type-outstanding-balance-id','defaultValue' => 0,'model' => $model??null,'label' => __('LC Type Outstanding Balance'),'type' => 'text','placeholder' => __('LC Type Outstanding Balance'),'name' => 'lc_type_outstanding_balance','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('current-lc-type-outstanding-balance-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Type Outstanding Balance')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Type Outstanding Balance')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_type_outstanding_balance'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-2">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('LC Code'),'type' => 'text','placeholder' => __('LC Code'),'name' => 'lc_code','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Code')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Code')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_code'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                </div>
                            </div>
                        </div>







                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        <?php echo e(__('Beneficiary Information')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">


                                    <div class="col-md-5">

                                        <label><?php echo e(__('Beneficiary Name')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="kt-input-icon">
                                                <div class="input-group date">
                                                    <select required data-current-selected="<?php echo e(isset($model) ? $model->getBeneficiaryId():0); ?>" js-update-contracts-based-on-customers data-live-search="true" data-actions-box="true" id="customer_name" name="partner_id" class="form-control select2-select">
                                                        
                                                        <?php $__currentLoopData = $beneficiaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if(isset($model) && $model->getBeneficiaryId() == $customer->getId() ): ?> selected <?php endif; ?> value="<?php echo e($customer->getId()); ?>"><?php echo e($customer->getName()); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="col-md-1 hidden show-only-bond">
                                        <label style="visibility:hidden !important;"> *</label>
                                        <button type="button" class="add-new btn btn-primary d-block" data-toggle="modal" data-target="#add-new-customer-modal">
                                            <?php echo e(__('Add New')); ?>

                                        </button>
                                    </div>
                                    <div class="modal fade" id="add-new-customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Add New Customer')); ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <input value="" class="form-control" name="new_customer_name" id="new_customer_name" placeholder="<?php echo e(__('Enter New Customer Name')); ?>">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                    <button type="button" class="btn btn-primary js-add-new-customer-if-not-exist"><?php echo e(__('Save')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-3 hidden show-only-bond">


                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 1,'model' => $model??null,'label' => __('Transaction Reference'),'type' => 'text','placeholder' => __('Transaction Reference'),'name' => 'transaction_reference','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 1,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Reference')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Reference')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('transaction_reference'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                    </div>

                                   <?php echo $__env->make('reports/LetterOfCreditIssuance/_contract-inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								   
                                    <div class="col-md-3 hidden show-only-bond">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Transaction Date'),'required' => true,'model' => $model??null,'name' => 'transaction_date','placeholder' => __('Select Transaction Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Transaction Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('transaction_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Transaction Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        <?php echo e(__('Letter Of Credit Information')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">

                                    <div class="col-md-3">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['classes' => 'recalc-due-date issuance-date-js update-exchange-rate exchange-rate-date','label' => __('Issuance Date'),'required' => true,'model' => $model??null,'name' => 'issuance_date','placeholder' => __('Select Purchase Order Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalc-due-date issuance-date-js update-exchange-rate exchange-rate-date'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Issuance Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('issuance_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Purchase Order Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 1,'model' => $model??null,'label' => __('LC Duration Months'),'type' => 'numeric','placeholder' => __('LC Duration Months'),'name' => 'lc_duration_months','class' => 'recalc-due-date lc-duration-months-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 1,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Duration Months')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('numeric'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Duration Months')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_duration_months'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalc-due-date lc-duration-months-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['classes' => 'due-date-js','readonly' => true,'label' => __('Due Date'),'required' => true,'model' => $model??null,'name' => 'due_date','placeholder' => __('Select Due Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('due-date-js'),'readonly' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Due Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('due_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Due Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                     <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 0,'model' => $model??null,'label' => __('LC Amount'),'type' => 'text','placeholder' => __('LC Amount'),'name' => 'lc_amount','class' => 'only-greater-than-zero-allowed amount-js  recalculate-amount-in-main-currency recalculate-cash-cover-amount-js recalculate-lc-commission-amount-js lc-amount-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed amount-js  recalculate-amount-in-main-currency recalculate-cash-cover-amount-js recalculate-lc-commission-amount-js lc-amount-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
										<input type="hidden" value="<?php echo e($company->getMainFunctionalCurrency()); ?>" class="to-currency">
                                  


                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['readonly' => false,'defaultValue' => 1,'model' => $model??null,'label' => __('Exchange Rate'),'type' => 'text','placeholder' => __('Exchange Rate'),'name' => 'exchange_rate','class' => 'recalculate-amount-in-main-currency exchange-rate-js only-greater-than-or-equal-zero-allowed exchange-rate-class','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'default-value' => 1,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Exchange Rate')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Exchange Rate')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exchange_rate'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalculate-amount-in-main-currency exchange-rate-js only-greater-than-or-equal-zero-allowed exchange-rate-class'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									<div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['readonly' => true,'defaultValue' => 0,'model' => $model??null,'label' => __('Amount In Main Currency'),'type' => 'text','placeholder' => __('Amount In Main Currency'),'name' => 'amount_in_main_currency','class' => 'amount-in-main-currency-js-hidden recalculate-cash-cover-amount-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['readonly' => true,'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount In Main Currency')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount In Main Currency')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('amount_in_main_currency'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('amount-in-main-currency-js-hidden recalculate-cash-cover-amount-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'lc_commission_rate-id','defaultValue' => 0,'model' => $model??null,'label' => __('LC Commission Rate %'),'type' => 'text','placeholder' => __('LC Commission Rate %'),'name' => 'lc_commission_rate','class' => 'only-greater-than-or-equal-zero-allowed recalculate-lc-commission-amount-js lc-commission-rate-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_commission_rate-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Commission Rate %')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Commission Rate %')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_commission_rate'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed recalculate-lc-commission-amount-js lc-commission-rate-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 0,'readonly' => true,'model' => $model??null,'label' => __('LC Commission Amount'),'type' => 'text','placeholder' => __('LC Commission Amount'),'name' => 'lc_commission_amount','class' => 'only-greater-than-or-equal-zero-allowed lc-commission-amount-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 0,'readonly' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Commission Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Commission Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_commission_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed lc-commission-amount-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'min_lc_commission_fees_id','defaultValue' => 0,'readonly' => false,'model' => $model??null,'label' => __('Min LC Commission Fees'),'type' => 'text','placeholder' => __('Min LC Commission Fees'),'name' => 'min_lc_commission_fees','class' => 'only-greater-than-or-equal-zero-allowed ','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('min_lc_commission_fees_id'),'default-value' => 0,'readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min LC Commission Fees')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min LC Commission Fees')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('min_lc_commission_fees'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'issuance_fees_id','defaultValue' => 0,'readonly' => false,'model' => $model??null,'label' => __('Issuance Fees'),'type' => 'text','placeholder' => __('Issuance Fees'),'name' => 'issuance_fees','class' => 'only-greater-than-or-equal-zero-allowed ','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('issuance_fees_id'),'default-value' => 0,'readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Issuance Fees')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Issuance Fees')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('issuance_fees'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>



                                    



                                <div class="col-md-3">
                                    <label><?php echo e(__('Account Type')); ?>

                                        <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <select name="cash_cover_deducted_from_account_type" class="form-control js-update-account-id-based-on-account-type">
                                                
                                                <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashCoverDeductedFromAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label><?php echo e(__('Deducted From Account # (Fees & Commission)')); ?>

                                        <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <select data-current-selected="<?php echo e(isset($model) ? $model->getFeesAndCommissionAccountId(): 0); ?>" name="lc_fees_and_commission_account_id" class="form-control js-account-number">
                                                <option value="" selected><?php echo e(__('Select')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 ">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('Financing Duration'),'type' => 'text','placeholder' => __('Financing Duration'),'name' => 'financing_duration','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Financing Duration')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Financing Duration')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('financing_duration'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
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




    $(document).on('click', '.js-add-new-customer-if-not-exist', function(e) {
        const customerName = $('#new_customer_name').val()
        const url = "<?php echo e(route('add.new.partner',['company'=>$company->id,'type'=>'Customer'])); ?>"
        if (customerName) {
            $.ajax({
                url
                , data: {
                    customerName
                }
                , type: "post"
                , success: function(response) {
                    if (response.status) {
                        $('select#customer_name').append('<option selected value="' + response.customer.id + '"> ' + customerName + ' </option>  ')
                        $('#add-new-customer-modal').modal('hide')
                    } else {
                        Swal.fire({
                            icon: "error"
                            , title: response.message
                        })
                    }
                }
            })
        }
    })

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

<script src="/custom/money-receive.js">

</script>
<script>
	
    $(document).on('change', '.recalculate-amount-in-main-currency', function() {
        const parent = $(this).closest('.kt-portlet__body');
        const amount = parseFloat($(parent).find('.amount-js').val())
        const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
        const amountInMainCurrency = parseFloat(amount * exchangeRate);
	
        $(parent).find('.amount-in-main-currency-js-hidden').val(amountInMainCurrency).trigger('change')
        $(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
    })

</script>
<script>
    $(document).on('change', '.recalc-due-date', function(e) {
        e.preventDefault()
        let date = $('.issuance-date-js').val();
        date = date.replaceAll('-', '/')

        const issuanceDate = new Date(date);
        const duration = $('.lc-duration-months-js').val();
        if (issuanceDate || duration == '0') {
            const numberOfMonths = duration

            let dueDate = issuanceDate.addMonths(numberOfMonths)

            dueDate = formatDateForSelect2(dueDate)
            $('.due-date-js').val(dueDate).trigger('change')
        }

    })
    

    $(document).on('change', '.recalculate-lc-commission-amount-js', function() {
        const lcAmount = number_unformat($('.lc-amount-js').val())
        const rate = number_unformat($('.lc-commission-rate-js').val()) / 100
        const lcCommissionAmount = lcAmount * rate
        $('.lc-commission-amount-js').val(toFixed(lcCommissionAmount))
    })

    $('.recalc-due-date').trigger('change')
    $('.recalculate-cash-cover-amount-js').trigger('change')
    $('.recalculate-lc-commission-amount-js').trigger('change')

</script>
<script>
    $(document).on('change', '.js-toggle-bond', function() {
        const isBond = $(this).val() == 'bid-bond'
        if (isBond) {
            $('.show-only-bond').removeClass('hidden')
            $('.hide-only-bond').addClass('hidden')
        } else {
            $('.hide-only-bond').removeClass('hidden')
            $('.show-only-bond').addClass('hidden')
        }
    })
     $(function(){
					$('.js-toggle-bond').trigger('change')
				})

</script>
<?php echo $__env->make('reports.LetterOfCreditIssuance.commonJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>			
<script>
    $(document).on('change', '[js-update-outstanding-balance-and-limits]', function(e) {
        e.preventDefault()
        const financialInstitutionId = $('select#financial-instutition-id').val()
        const lcType = $('select#lc-type').val()
        const accountTypeId = $('select#account_type_id').val()
        const accountId = $('[js-cd-or-td-account-number]').val()
		const lcIssuanceId = "<?php echo e(isset($model) ? $model->id : 0); ?>" 
		const cdOrTdAccountId = $('select[name="cd_or_td_id"]').val()
		const source = "<?php echo e($source); ?>"
        $.ajax({
            url: "<?php echo e(route('update.letter.of.credit.outstanding.balance.and.limit',['company'=>$company->id])); ?>"
            , data: {
                financialInstitutionId,
				lcIssuanceId,
				cdOrTdAccountId
                , lcType,
				source
                , accountTypeId
                , accountId
            }
            , type: "GET"
            , success: function(res) {
								$('#input[name="lc_currency"]').val(res.currency_name)

                $('#limit-id').val(res.limit).prop('readonly', true)
                $('#total-lc-for-all-types-id').val(res.total_lc_outstanding_balance).prop('readonly', true)
                $('#total-room-id').val(res.total_room).prop('readonly', true)
								$('#current-lc-outstanding-balance-id').val(res.total_lc_outstanding_balance).prop('readonly', true).trigger('change')
                $('#current-lc-type-outstanding-balance-id').val(res.current_lc_type_outstanding_balance).prop('readonly', true)
                $('#min_lc_commission_fees_id').val(res.min_lc_commission_rate).trigger('change');
								$('#against-cash-cover-amount-id').val(res.total_cash_cover_statement_debit).prop('readonly', true).trigger('change')

                //        $('#lc_commission_rate-id').val(res.lc_commission_rate).trigger('change');
                $('#issuance_fees_id').val(res.min_lc_issuance_fees_for_current_lc_type).trigger('change');
                $('#cash-cover-rate-id').val(res.min_lc_cash_cover_rate_for_current_lc_type).trigger('change');
                $('[js-update-contracts-based-on-customers]').trigger('change')
            }
        })
    })

</script>
<?php if(!isset($model)): ?>
<script>
    $('[js-update-outstanding-balance-and-limits]').trigger('change')

</script>
<?php endif; ?>






<script>
    $(document).on('change', '[js-cd-or-td-account-number]', function() {
        const parent = $(this).closest('.kt-portlet__body');
        const accountType = parent.find('.js-update-account-id-based-on-account-type').val()
        const accountId = parent.find('[js-cd-or-td-account-number]').val();

					const financialInstitutionId = $('select#financial-instutition-id').val();
                    let url = "<?php echo e(route('get.account.amount.based.on.account.id',['company'=>$company->id , 'accountType'=>'replace_account_type' , 'accountId'=>'replace_account_id','financialInstitutionId'=>'replace_financial_institution_id' ])); ?>";
					
                    url = url.replace('replace_account_type', accountType);
                    url = url.replace('replace_account_id', accountId);
					url = url.replace('replace_financial_institution_id', financialInstitutionId);
                    
		if(accountType &&accountId &&financialInstitutionId){
			 $.ajax({
            url
            , success: function(res) {
                parent.find('#cd-or-td-amount-id').attr('data-value',res.amount).val(number_format(res.amount) + ' ' + res.currencyName ).trigger('change')
            }
        });
		}else{
                parent.find('#cd-or-td-amount-id').attr('data-value',0).val(0 ).trigger('change')
			
		}
       
    })
	


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditIssuance/against-td-form.blade.php ENDPATH**/ ?>