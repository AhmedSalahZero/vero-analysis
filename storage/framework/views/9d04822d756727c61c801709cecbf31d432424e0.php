<?php $__env->startSection('css'); ?>
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
<?php echo e(__('Letter Of Credit Facility Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        
<form method="post" action="<?php echo e(isset($model) ?  route('update.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'letterOfCreditFacility'=>$model->id]) :route('store.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])); ?>" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
    <input id="js-money-received-id" type="hidden" name="id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
    <input type="hidden" name="financial_institution_id" value="<?php echo e($financialInstitution->id); ?>">
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
                            <?php echo e(__((isset($model) ? 'Edit' : 'Add') . ' Letter Of Credit')); ?>

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
                                <?php echo e(__('Contract Main Information')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">


                        <div class="form-group row">
                            <div class="col-md-4 ">
                                <label><?php echo e(__('Financial Institution Name')); ?> </label>
                                <div class="kt-input-icon">
                                    <input disabled value="<?php echo e($financialInstitution->getName()); ?>" type="text" class="form-control" placeholder="<?php echo e(__('Financial Institution Name')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('Name'),'type' => 'text','placeholder' => __('Name'),'name' => 'name','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Name')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Name')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('name'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                            <div class="col-md-2">

                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Contract Start Date'),'required' => true,'model' => $model??null,'name' => 'contract_start_date','placeholder' => __('Select Contract Start Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contract Start Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('contract_start_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Contract Start Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                            <div class="col-md-2">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Contract End Date'),'required' => true,'model' => $model??null,'name' => 'contract_end_date','placeholder' => __('Select Contract End Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Contract End Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('contract_end_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Contract End Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
							
							  <div class="col-md-2">
                                <label><?php echo e(__('Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="input-group">
                                    <select  name="type" class="form-control " id="type">
                                        <?php $__currentLoopData = $letterOfCreditFacilitiesTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type); ?>" <?php if(isset($model) && $model->getType() == $type ): ?> selected <?php endif; ?> > <?php echo e($title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 " id="limit-div-id"> 
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('Limit'),'type' => 'text','placeholder' => __('Limit'),'name' => 'limit','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Limit')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Limit')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('limit'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>

                            <div class="col-md-2">
                                <label><?php echo e(__('Select Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="input-group">
                                    <select name="currency" class="form-control repeater-select">
                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getCurrency() == $currencyName ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>


                          

                           




                        </div>
                    </div>
                </div>
				
				
				 <div class="kt-portlet" id="show-only-fully-secured-div-id" style="display:none">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        <?php echo e(__('CD Or TD Information')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">

                                    <div class="col-md-2">
                                        <label><?php echo e(__('Select Currency')); ?> 
										
										<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										</label>
                                        <div class="input-group">
                                            <select name="cd_or_td_currency" class="form-control repeater-select current-currency " js-when-change-trigger-change-account-type>
                                                
                                                <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getCurrency() == $currencyName ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="financial_institution_id" data-financial-institution-id value="<?php echo e($financialInstitution->id); ?>">
                                    <div class="col-md-2">
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

                                    <div class="col-md-2">
                                        <label><?php echo e(__('Account Number')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select js-cd-or-td-account-number data-current-selected="<?php echo e(isset($model) ? $model->getCdOrTdId(): 0); ?>" name="cd_or_td_id" class="form-control js-account-number">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'cd-or-td-amount-id','readonly' => true,'defaultValue' => 0,'model' => $model??null,'label' => __('Amount'),'type' => 'text','placeholder' => '','name' => 'cd_or_td_amount','class' => 'recalculate-limit-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd-or-td-amount-id'),'readonly' => true,'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd_or_td_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalculate-limit-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'cd-or-td-interest-rate-id','readonly' => true,'defaultValue' => 0,'model' => $model??null,'label' => __('CD Or TD Interest Rate'),'type' => 'text','placeholder' => '','name' => 'cd_or_td_interest','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd-or-td-interest-rate-id'),'readonly' => true,'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('CD Or TD Interest Rate')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd_or_td_interest'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-2 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'cd-or-td-lending-percentage-id','readonly' => false,'defaultValue' => 0,'model' => $model??null,'label' => __('CD Or TD Lending Percentage'),'type' => 'text','placeholder' => '','name' => 'cd_or_td_lending_percentage','class' => 'only-percentage-allowed recalculate-limit-js','required' => false]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd-or-td-lending-percentage-id'),'readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('CD Or TD Lending Percentage')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cd_or_td_lending_percentage'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed recalculate-limit-js'),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									
									<div class="col-md-2 ">	
										<input id="limit-id" type="hidden" name="cd_or_td_limit" value="<?php echo e(isset($model) ? $model->limit : 0); ?>">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'limit-formatted-id','readonly' => true,'model' => $model??null,'label' => __('Limit'),'type' => 'text','placeholder' => __('Limit'),'name' => 'limit_formatted','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('limit-formatted-id'),'readonly' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Limit')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Limit')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('limit_formatted'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
									



                                </div>
                            </div>
                        </div>

                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                <?php echo e(__('Terms & Conditions')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <?php
                        $index = 0 ;
                        ?>

                        <?php $__currentLoopData = getLcTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $termAndCondition = isset($model) && isset($model->termAndConditions[$index]) ? $model->termAndConditions[$index] : null;
                        ?>
                        <div class="form-group row" style="flex:1;">

                            <div class="col-md-4">
                                <label class="label"><?php echo __('LC <br> Type'); ?></label>
                                <input class="form-control" type="hidden" readonly value="<?php echo e($name); ?>" name="termAndConditions[<?php echo e($index); ?>][lc_type]">
                                <input class="form-control" type="text" readonly value="<?php echo e($nameFormatted); ?>">
                            </div>



                            






                <div class="col-1">
                    <label class="form-label font-weight-bold text-center">
                        <?php echo __('Cash <br> Cover (%)'); ?>

                        <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </label>
                    <div class="kt-input-icon">
                        <div class="input-group">
                            <input name="termAndConditions[<?php echo e($index); ?>][cash_cover_rate]" type="text" class="form-control cash-cover-class only-percentage-allowed
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->cash_cover_rate : old('cash_cover_rate',0))); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-1">
                    <label class="form-label font-weight-bold text-center ">
                        <?php echo __('Commission <br> Rate (%)'); ?>

                        <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </label>
                    <div class="kt-input-icon">
                        <div class="input-group">
                            <input name="termAndConditions[<?php echo e($index); ?>][commission_rate]" type="text" class="form-control only-percentage-allowed
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->commission_rate : old('commission_rate',0))); ?>">
                        </div>
                    </div>
                </div>





                <div class="col-2">
                    <label class="form-label font-weight-bold"> <?php echo __('Min Commissions <br> Fees Amount'); ?>


                    </label>
                    <div class="kt-input-icon">
                        <div class="input-group">
                            <input name="termAndConditions[<?php echo e($index); ?>][min_commission_fees]" type="text" class="form-control only-greater-than-or-equal-zero-allowed
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->min_commission_fees : old('min_commission_fees',0))); ?>">
                        </div>
                    </div>
                </div>


                <div class="col-2">
                    <label class="form-label font-weight-bold"><?php echo __('Issuance <br> Fees Amount'); ?>


                    </label>
                    <div class="kt-input-icon">
                        <div class="input-group">
                            <input name="termAndConditions[<?php echo e($index); ?>][issuance_fees]" type="text" class="form-control only-greater-than-or-equal-zero-allowed
								" value="<?php echo e((isset($termAndCondition) ? $termAndCondition->issuance_fees : old('issuance_fees',0))); ?>">
                        </div>
                    </div>
                </div>





        </div>
        <?php
        $index = $index + 1 ;
        ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





    </div>
    </div>


    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Financing Terms & Conditions')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">


                <div class="col-md-2 ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'borrowing-rate-id','model' => $model??null,'class' => 'only-percentage-allowed','label' => __('Borrowing Rate (%)'),'type' => 'text','placeholder' => __('Borrowing Rate (%)'),'name' => 'borrowing_rate','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('borrowing-rate-id'),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Borrowing Rate (%)')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Borrowing Rate (%)')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('borrowing_rate'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>

                <div class="col-md-2 ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'class' => 'only-percentage-allowed','label' => __('Bank Margin Rate (%)'),'placeholder' => __('Bank Margin Rate (%)'),'name' => 'bank_margin_rate','required' => true,'type' => 'text']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Bank Margin Rate (%)')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Bank Margin Rate (%)')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('bank_margin_rate'),'required' => true,'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>

                <div class="col-md-2 ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'class' => 'only-percentage-allowed','label' => __('Interest Rate (%)'),'placeholder' => __('Interest Rate (%)'),'name' => 'interest_rate','required' => true,'type' => 'text']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Interest Rate (%)')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Interest Rate (%)')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('interest_rate'),'required' => true,'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>

                <div class="col-md-2 ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'class' => 'only-percentage-allowed','label' => __('Min Intrest Rate (%)'),'placeholder' => __('Min Intrest Rate (%)'),'name' => 'min_interest_rate','required' => true,'type' => 'text']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min Intrest Rate (%)')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min Intrest Rate (%)')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('min_interest_rate'),'required' => true,'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>
                <div class="col-md-2 ">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'class' => 'only-percentage-allowed','label' => __('Highest Debt Balance Rate (%)'),'placeholder' => __('Highest Debt Balance Rate (%)'),'name' => 'highest_debt_balance_rate','required' => true,'type' => 'text']]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-percentage-allowed'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Highest Debt Balance Rate (%)')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Highest Debt Balance Rate (%)')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('highest_debt_balance_rate'),'required' => true,'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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

</script>

 <script src="/custom/money-receive.js">

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
            $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)

        }
    })

</script>
<script>
    $('input[name="borrowing_rate"],input[name="bank_margin_rate"]').on('change', function() {
        let borrowingRate = $('input[name="borrowing_rate"]').val();
        borrowingRate = borrowingRate ? parseFloat(borrowingRate) : 0;
        let bankMaringRate = $('input[name="bank_margin_rate"]').val();
        bankMaringRate = bankMaringRate ? parseFloat(bankMaringRate) : 0;
        const interestRate = borrowingRate + bankMaringRate;
        $('input[name="interest_rate"]').attr('readonly', true).val(interestRate);
    })
    $('input[name="borrowing_rate"]').trigger('change');

</script>
<script>
$('select#type').on('change',function(){
	const val = $(this).val();
	if(val =='fully-secured'){
		$('#show-only-fully-secured-div-id').show();
		$('.cash-cover-class').val(0).prop('readonly',true)
		$('#limit-div-id').hide();
	}else{
		$('#limit-div-id').show();
		$('.cash-cover-class').prop('readonly',false)
		$('#show-only-fully-secured-div-id').hide();
	}
})
$('select#type').trigger('change')

$(document).on('change','.recalculate-limit-js',function(e){
			let amount = number_unformat($('#cd-or-td-amount-id').val());
			let lendingPercentage = number_unformat($('#cd-or-td-lending-percentage-id').val());
			let limit = amount * lendingPercentage / 100 ;
			$('#limit-id').val(limit)
			$('#limit-formatted-id').val(number_format(limit))
		})
		$('.recalculate-limit-js:eq(0)').trigger('change')

$(document).on('change', '[js-cd-or-td-account-number]', function() {
                const parent = $(this).closest('.kt-portlet__body');
                const accountType = parent.find('.js-update-account-id-based-on-account-type').val()
                const accountId = parent.find('[js-cd-or-td-account-number]').val();
               	const financialInstitutionId = "<?php echo e($financialInstitution->id); ?>";
                    let url = "<?php echo e(route('get.account.amount.based.on.account.id',['company'=>$company->id , 'accountType'=>'replace_account_type' , 'accountId'=>'replace_account_id','financialInstitutionId'=>'replace_financial_institution_id' ])); ?>";
					
                    url = url.replace('replace_account_type', accountType);
                    url = url.replace('replace_account_id', accountId);
					url = url.replace('replace_financial_institution_id', financialInstitutionId);
					
					if(accountType &&accountId &&financialInstitutionId){
						$.ajax({
                    url
                    , success: function(res) {
                        parent.find('#cd-or-td-amount-id').val(number_format(res.amount)).trigger('change')
						parent.find('#cd-or-td-interest-rate-id').val(number_format(res.interest_rate,2))
						
						$('#borrowing-rate-id').val(number_format(res.interest_rate,2)).trigger('change')
                    }
                });
					}
                
            })
            $('[js-cd-or-td-account-number]').trigger('change')
					
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditFacility/form.blade.php ENDPATH**/ ?>