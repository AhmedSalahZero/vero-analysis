<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<style>
    .ui-datepicker-calendar {
        display: none;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($title); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($model) ? route('update.study',[$company->id , $model->id]) : $storeRoute); ?>">
            <?php echo csrf_field(); ?>
            <?php if(isset($model)): ?>
            <?php echo method_field('put'); ?>
            <?php endif; ?>
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e(__('Study Main Information')); ?> </h3>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>

                    <div class="form-group  mt-3">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Study Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="<?php echo e(__('Please Enter Study Name')); ?>" name="study_name" value="<?php echo e(isset($model) ? $model->getName() : null); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $mainCurrencies[] = $currencies[0]??[];
                            ?>
                            <div class="col-md-2 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['isSelect2' => false,'isRequired' => true,'options' => [['title'=>__($company->getMainFunctionalCurrency()) , 'value'=>$company->getMainFunctionalCurrency()]],'addNew' => false,'label' => __('Main Functional Currency'),'class' => ' main_functional_currency','all' => false,'name' => 'main_functional_currency','selectedValue' => isset($model) ? $model->getMainFunctionalCurrency() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-required' => true,'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['title'=>__($company->getMainFunctionalCurrency()) , 'value'=>$company->getMainFunctionalCurrency()]]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Main Functional Currency')),'class' => ' main_functional_currency','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'main_functional_currency','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getMainFunctionalCurrency() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                            <div class="col-md-2 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['isSelect2' => false,'isRequired' => true,'options' => [['title'=>__('Existing Company' ) , 'value'=>'existing'] , ['title'=>__('New Company') ,'value'=>'new']],'addNew' => false,'label' => __('Company Nature'),'class' => ' ','all' => false,'name' => 'company_nature','selectedValue' => isset($model) ? $model->getCompanyNature() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-required' => true,'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['title'=>__('Existing Company' ) , 'value'=>'existing'] , ['title'=>__('New Company') ,'value'=>'new']]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Company Nature')),'class' => ' ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'company_nature','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getCompanyNature() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>

                            <div class="col-md-4 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => [
																	
																	  ],'addNew' => false,'isRequired' => false,'label' => __('To Be Consolidated To Financial Plan: (Optional)'),'class' => 'select2-select   ','all' => false,'name' => 'to_be_consolidated_from_study_id','selectedValue' => isset($model) ? $model->getPropertyStatus() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
																	
																	  ]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('To Be Consolidated To Financial Plan: (Optional)')),'class' => 'select2-select   ','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'to_be_consolidated_from_study_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getPropertyStatus() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>




                            <div class="col-md-4 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['class' => 'label','id' => 'test-id']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-id')]); ?><?php echo e(__('Study Start Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input id="study-start-date" type="text" name="study_start_date" class="only-month-year-picker date-input form-control recalc-study-end-date study-start-date recalate-development-start-date recalate-operation-start-date" readonly value="<?php echo e(isset($model) ? $model->getStudyStartDate() : getCurrentDateForFormDate('date')); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-4 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => [
																		1=>['title'=>1 ,'value'=>'1'],
																		66=>['title'=>1.5 ,'value'=>'1.5'],
																		2=>['title'=>2 ,'value'=>'2'],
																		3=>['title'=>3 ,'value'=>'3'],
																		4=>['title'=>4 ,'value'=>'4'],
																		5=>['title'=>5 ,'value'=>'5'],
																		6=>['title'=>6 ,'value'=>'6'],
																		7=>['title'=>7 ,'value'=>'7'],
																		
																	  
																	  ],'addNew' => false,'isRequired' => true,'label' => __('Study Duration In Years'),'class' => 'select2-select recalc-study-end-date study-duration','all' => false,'name' => 'duration_in_years','selectedValue' => isset($model) ? $model->getDurationInYears() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
																		1=>['title'=>1 ,'value'=>'1'],
																		66=>['title'=>1.5 ,'value'=>'1.5'],
																		2=>['title'=>2 ,'value'=>'2'],
																		3=>['title'=>3 ,'value'=>'3'],
																		4=>['title'=>4 ,'value'=>'4'],
																		5=>['title'=>5 ,'value'=>'5'],
																		6=>['title'=>6 ,'value'=>'6'],
																		7=>['title'=>7 ,'value'=>'7'],
																		
																	  
																	  ]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-required' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Study Duration In Years')),'class' => 'select2-select recalc-study-end-date study-duration','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'duration_in_years','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getDurationInYears() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>





                            <div class="col-md-4 ">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['class' => 'label','id' => 'test-id']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-id')]); ?><?php echo e(__('Study End Date')); ?>  <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input id="study-end-date" type="hidden" name="study_end_date" class=" form-control" readonly value="<?php echo e(isset($model) ? $model->getStudyEndDate() : getCurrentDateForFormDate('date')); ?>" />
                                        <input id="study-end-date-text" type="text" class=" form-control" readonly value="<?php echo e(isset($model) ? $model->getStudyEndDate() : getCurrentDateForFormDate('date')); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Operation Will Start After (Months)')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input id="property-will-start-after" type="number" class="form-control only-greater-than-or-equal-zero-allowed recalate-operation-start-date" name="operation_start_month" value="<?php echo e(isset($model) ? $model->getOperationStartMonth() : 0); ?>">
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 mb-4">

                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['class' => 'label','id' => 'test-id']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-id')]); ?><?php echo e(__('Operation Start Date')); ?>  <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input id="operation-start-date" readonly type="text" name="operation_start_date" class="form-control" readonly value="<?php echo e(isset($model) ? $model->getOperationStartDate() : getCurrentDateForFormDate('date')); ?>" max="<?php echo e(date('m-d-Y')); ?>" id="kt_datepicker_3" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="col-md-4 mb-4">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['isSelect2' => false,'isRequired' => true,'options' => getFinancialMonthsForSelect(),'addNew' => false,'label' => __('Financial Year Start Month'),'class' => '','all' => false,'name' => 'financial_year_start_month','selectedValue' => isset($model) ? $model->financialYearStartMonth() : 'january']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'is-required' => true,'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getFinancialMonthsForSelect()),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Financial Year Start Month')),'class' => '','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'financial_year_start_month','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->financialYearStartMonth() : 'january')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>


                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Corporate Taxes Rate %')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="corporate_taxes_rate" value="<?php echo e(isset($model) ? $model->getCorporateTaxesRate() : 0); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Salary Taxes Rate %')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="salary_taxes_rate" value="<?php echo e(isset($model) ? $model->getSalaryTaxesRate() : 0); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Social Insurance Rate %')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="social_insurance_rate" value="<?php echo e(isset($model) ? $model->getSocialInsuranceRate() : 0); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Revenues Multiplier')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="investment_return_rate" value="<?php echo e(isset($model) ? $model->getInvestmentReturnRate() : 1); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('EBITDA Multiplier')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="perpetual_growth_rate" value="<?php echo e(isset($model) ? $model->getPerpetualGrowthRate() : 0); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Shareholder Equity Multiplier')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="shareholder_equity_multiplier" value="<?php echo e(isset($model) ? $model->getShareholderEquityMultiplier() : 0); ?>" step="0.1">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <br>
                        <hr>

                    </div>
                </div>
            </div>












            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e(__('Revenue Stream Types')); ?> </h3>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row">

                        <div class="form-group row" style="flex:1;">
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-12 mb-0 mt-4 text-left">
                                        <div class="form-group d-inline-block">
                                            <div class="kt-radio-inline">
                                                <label class="mr-3">

                                                </label>
                                                <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_leasing" <?php if(isset($model) && $model->hasLeasing()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Leasing')); ?>

                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_direct_factoring" <?php if(isset($model) && $model->hasDirectFactoring()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Direct Factoring')); ?>

                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--primary text-black font-size-18px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_reverse_factoring" <?php if(isset($model) && $model->hasReverseFactoring()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Reverse Factoring')); ?>

                                                    <span></span>
                                                </label>






                                                <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_ijara_mortgage" <?php if(isset($model) && $model->hasIjaraMortgage()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Ijara Mortgage')); ?>

                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_portfolio_mortgage" <?php if(isset($model) && $model->hasPortfolioMortgage()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Portfolio Mortgage')); ?>

                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--primary text-black font-size-18px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_micro_finance" <?php if(isset($model) && $model->hasMicroFinance()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Micro Finance')); ?>

                                                    <span></span>
                                                </label>



                                                <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_securitization" <?php if(isset($model) && $model->hasSecuritization()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Securitization')); ?>

                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_consumer_finance" <?php if(isset($model) && $model->hasConsumerFinance()): ?> checked <?php endif; ?>
                                                    > <?php echo e(__('Consumer Finance')); ?>

                                                    <span></span>
                                                </label>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
			
			
			
			<div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e(__('Existing Branches Info')); ?> </h3>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row">

                        <div class="form-group row" style="flex:1;">
                           	 <div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Microfinance Branches Count')); ?>  </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="microfinance_branches_count" value="<?php echo e(isset($model) ? $model->getMicrofinanceBranchesCount() : 0); ?>" step="1">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Microfinance Loan Officer Count')); ?>  </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="microfinance_loan_officer_count" value="<?php echo e(isset($model) ? $model->getMicrofinanceLoanOfficerCount() : 0); ?>" step="1">
                                    </div>
                                </div>
                            </div>
							
							 <div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Consumer Finance Branches Count')); ?>  </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="consumerfinance_branches_count" value="<?php echo e(isset($model) ? $model->getConsumerfinanceBranchesCount() : 0); ?>" step="1">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-3 mb-4">
                                <label class="form-label font-weight-bold"><?php echo e(__('Consumer Finance Loan Officer Count')); ?>  </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="consumerfinance_loan_officer_count" value="<?php echo e(isset($model) ? $model->getConsumerfinanceLoanOfficerCount() : 0); ?>" step="1">
                                    </div>
                                </div>
                            </div>
							
							
                        </div>
                    </div>

                </div>
            </div>
			



            <div class="kt-portlet">
                <div class="kt-portlet__body">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.save-or-back','data' => ['btnText' => __('Create')]]); ?>
<?php $component->withName('save-or-back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['btn-text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Create'))]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>
            </div>




            <!--end::Form-->

            <!--end::Portlet-->
    </div>


</div>

</div>




</div>









</div>
</div>
</form>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<script src="/custom/js/non-banking-services/common.js"></script>
<script>
    $(document).on('change', '.recalc-study-end-date', function(e) {
        e.preventDefault()
        const studyStartDate = new Date($('.study-start-date').val());
        const studyDuration = parseFloat($('.study-duration option:selected').attr('value'));
        if (studyDuration || studyDuration == '0') {
            const numberOfMonths = (studyDuration * 12) - 1
            let studyEndDate = studyStartDate.addMonths(numberOfMonths)
            let dateFormattedForView = new Date(studyEndDate.getFullYear(), studyEndDate.getMonth() + 1, 0)
            $('#study-end-date-text').val(convertDateToDefaultDateFormat(formatDate(dateFormattedForView)))
            studyEndDate = convertDateToDefaultDateFormat(formatDate(studyEndDate))
            $('#study-end-date').val(studyEndDate).trigger('change')

        }

    })
    $(document).on('change', '.recalate-operation-start-date', function() {
        const studyStartDate = new Date($('.study-start-date').val());
        const propertyWillStartAfter = parseFloat($('#property-will-start-after').val())
        if (propertyWillStartAfter || propertyWillStartAfter == '0') {
            const developmentStartDate = convertDateToDefaultDateFormat(formatDate(new Date($('.study-start-date').val()).addMonths(propertyWillStartAfter)))
            $('#operation-start-date').val(developmentStartDate)
        }
    })
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {
            let form = document.getElementById('form-id');
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);

            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {
                    $('.save-form').prop('disabled', false);
                    $('.submit-form-btn-new').prop('disabled', false)
                    Swal.fire({
                        icon: 'error'
                        , title: res.responseJSON.message
                    , });
                }
            });
        }
    })

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/study/form.blade.php ENDPATH**/ ?>