
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Quick Pricing Calculator')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form id="quick-pricing-calculator-form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($disabled) && $disabled ? '#' : (isset($model) ? route('admin.update.quick.pricing.calculator',[$company->id , $model->id]) : $storeRoute)); ?>">

            <?php echo csrf_field(); ?>
            <input type="hidden" id="current_state_id" name="current_state_id" data-state-id="<?php echo e(isset($model) ? $model->getStateId() : 0); ?>">
            <input type="hidden" id="current_service_item_id" name="current_service_item_id" data-value="<?php echo e(isset($model) ? $model->getServiceItemId() : 0); ?>">
            <input type="hidden" id="current_service_category_id" name="current_service_category_id" data-value="<?php echo e(isset($model) ? $model->getServiceCategoryId() : 0); ?>">
            <input type="hidden" id="name-for-calculator" name="name">
            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <h2 for="" class="d-bloxk"><?php echo e(__('Offered Service Section')); ?></h2>



                    <div class="form-group row">
                        <div class="col-md-4 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => $pricingPlans,'addNew' => false,'label' => __('Choose Pricing Plan (Optional)'),'class' => 'select2-select   ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'pricing_plan_id','pleaseSelect' => 'true','id' => ''.e($type.'_'.'pricing_plan_id').'','selectedValue' => isset($pricingPlanId)  ? $pricingPlanId :  (isset($model) ? $model->getPricingPlanId() : 0) ]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pricingPlans),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Choose Pricing Plan (Optional)')),'class' => 'select2-select   ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'pricing_plan_id','please-select' => 'true','id' => ''.e($type.'_'.'pricing_plan_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($pricingPlanId)  ? $pricingPlanId :  (isset($model) ? $model->getPricingPlanId() : 0) )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-id')]); ?><?php echo e(__('Date')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="text" name="date" class="form-control" readonly value="<?php echo e(isset($model) ? $model->getDate() : getCurrentDateForFormDate('date')); ?>" max="<?php echo e(date('m-d-Y')); ?>" id="kt_datepicker_3" />
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'RevenueBusinessLine','addNewModalModalTitle' => __('Revenue Business Line'),'options' => $revenueBusinessLines,'addNew' => false,'label' => __('Revenue Business Line'),'class' => 'select2-select revenue_business_line_class  ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'revenue_business_line_id','id' => ''.e($type.'_'.'revenue_business_line_id').'','selectedValue' => isset($model) ? $model->getRevenueBusinessLineId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('RevenueBusinessLine'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue Business Line')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($revenueBusinessLines),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue Business Line')),'class' => 'select2-select revenue_business_line_class  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'revenue_business_line_id','id' => ''.e($type.'_'.'revenue_business_line_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getRevenueBusinessLineId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>


                        <div class="col-md-4 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'ServiceCategory','addNewModalModalTitle' => __('Service Category'),'previousSelectNameInDB' => 'revenue_business_line_id','previousSelectMustBeSelected' => true,'previousSelectSelector' => 'select.revenue_business_line_class','previousSelectTitle' => __('Revenue Bussiness Line'),'options' => $serviceCategories,'addNew' => false,'label' => __('Service Category'),'class' => 'select2-select service_category_class  ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'service_category_id','id' => ''.e($type.'_'.'service_category_id').'','selectedValue' => isset($model) ? $model->getServiceCategoryId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('ServiceCategory'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Category')),'previous-select-name-in-dB' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('revenue_business_line_id'),'previous-select-must-be-selected' => true,'previous-select-selector' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('select.revenue_business_line_class'),'previous-select-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Revenue Bussiness Line')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($serviceCategories),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Category')),'class' => 'select2-select service_category_class  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'service_category_id','id' => ''.e($type.'_'.'service_category_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getServiceCategoryId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>

                        <div class="col-md-4 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'ServiceItem','addNewModalModalTitle' => __('Service Item'),'previousSelectNameInDB' => 'service_category_id','previousSelectMustBeSelected' => true,'previousSelectSelector' => 'select.service_category_class','previousSelectTitle' => __('Service Category'),'options' => $serviceItems,'addNew' => false,'label' => __('Service Item'),'class' => 'select2-select service_item_class  ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'service_item_id','id' => ''.e($type.'_'.'service_item_id').'','selectedValue' => isset($model) ? $model->getServiceItemId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('ServiceItem'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Item')),'previous-select-name-in-dB' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('service_category_id'),'previous-select-must-be-selected' => true,'previous-select-selector' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('select.service_category_class'),'previous-select-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Category')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($serviceItems),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Item')),'class' => 'select2-select service_item_class  ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'service_item_id','id' => ''.e($type.'_'.'service_item_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getServiceItemId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>
                        <div class="col-md-4 mb-4">

                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => $serviceNatures,'addNew' => false,'label' => __('Service Nature'),'class' => 'select2-select   ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'service_nature_id','id' => ''.e($type.'_'.'service_nature_id').'','selectedValue' => isset($model) ? $model->getServiceNatureId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($serviceNatures),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Service Nature')),'class' => 'select2-select   ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'service_nature_id','id' => ''.e($type.'_'.'service_nature_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getServiceNatureId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>




                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Delivered Service (Count Or Days)')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group">
                                    <input id="delivery-days" type="number" class="form-control only-greater-than-zero-allowed" name="delivery_days" value="<?php echo e(isset($model) ? $model->getDeliveryDays() : old('delivery_days',1)); ?>" step="any">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Select Country')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group ">
                                    <select id="country_id" data-live-search="true" name="country_id" required class="form-control  form-select form-select-2 form-select-solid fw-bolder">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        <?php $__currentLoopData = getCountries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php if(isset($model) && $model->getCountryId() == $value ): ?> selected <?php endif; ?>> <?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Select state')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select id="state_id" data-live-search="true" name="state_id" required class="form-control  form-select form-select-2 form-select-solid fw-bolder  ">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        <?php $__currentLoopData = []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php if(isset($model) && $model->getStateId() == $value ): ?> selected <?php endif; ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['isSelect2' => false,'options' => $currencies,'addNew' => false,'label' => __('Currency'),'class' => '','dataFilterType' => ''.e($type).'','all' => false,'name' => 'currency_id','id' => ''.e($type.'_'.'currency_id').'','selectedValue' => isset($model) ? $model->getCurrencyId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['is-select2' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currencies),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Currency')),'class' => '','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'currency_id','id' => ''.e($type.'_'.'currency_id').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getCurrencyId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


                        </div>


                        <br>
                        <hr>

                    </div>
                </div>
            </div>
            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">

                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('Direct Manpower Expenses')); ?></h2>
                            <div id="m_repeater_2">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="manpower_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->directManpowerExpenses->count() ): ?>
                                            <?php $__currentLoopData = $model->directManpowerExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $directManpowerExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.direct-manpower-expenses' , [
                                            'positions'=>$directManpowerExpensePositions ?? [] ,
                                            'directManpowerExpense'=>$directManpowerExpense
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.direct-manpower-expenses' , [
                                            'positions'=>$directManpowerExpensePositions
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php endif; ?>





                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">

                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('Other Variable Direct Manpower Expense')); ?></h2>
                            <div id="m_repeater_7">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="other_variable_direct_operation_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->otherVariableManpowerExpenses->count()): ?>
                                            <?php $__currentLoopData = $model->otherVariableManpowerExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherVariableManpowerExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.other-variable-manpower-expense',[
                                            'otherVariableManpowerExpense'=>$otherVariableManpowerExpense??[]
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.other-variable-manpower-expense', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php endif; ?>

                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">

                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>




                    </div>





                </div>

            </div>



            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">

                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('Freelancers Expenses')); ?></h2>
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-6">

                                        <div class="form-group">
                                            <div class="kt-radio-inline">
                                                <label class="mr-3">
                                                    <?php echo e(__('Do You Use Freelancer')); ?>

                                                </label>

                                                <label class="kt-radio kt-radio--success ">
                                                    <input type="radio" value="1" name="use_freelancer" class="use-freelancer" <?php if(isset($model) && $model->isUseFreelancer()): ?> checked <?php endif; ?>> <?php echo e(__('Yes')); ?>

                                                    <span></span>
                                                </label>
                                                <label class="kt-radio kt-radio--danger ">
                                                    <input type="radio" value="0" name="use_freelancer" class="use-freelancer" <?php if(!isset($model) || !$model->isUseFreelancer()): ?> checked <?php endif; ?>> <?php echo e(__('No')); ?>

                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="m_repeater_3" class="use-freelancer-repeater">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="freelancer_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->freelancerExpenses->count() ): ?>
                                            <?php $__currentLoopData = $model->freelancerExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $freelancerExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.freelancer-expense' , [
                                            'positions'=>$freelancerExpensePositions??[] ,
                                            'freelancerExpense'=>$freelancerExpense
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.freelancer-expense' , [
                                            'positions'=>$freelancerExpensePositions
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php endif; ?>




                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>



            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">


                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('Other Direct Opertions Expenses')); ?></h2>
                            <div id="m_repeater_6">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="other_direct_operation_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->otherDirectOperationExpenses->count()): ?>
                                            <?php $__currentLoopData = $model->otherDirectOperationExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherDirectOperationExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.other-direct-operations-expenses',[
                                            'otherDirectOperationExpense'=>$otherDirectOperationExpense
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.other-direct-operations-expenses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php endif; ?>

                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">

                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>













                    </div>

                </div>

            </div>




            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">


                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('Sales & Marketing Expenses')); ?></h2>
                            <div id="m_repeater_4">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="sales_and_marketing_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->salesAndMarketingExpenses->count()): ?>
                                            <?php $__currentLoopData = $model->salesAndMarketingExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesAndMarketingExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.sales-and-marketing-expenses',[
                                            'salesAndMarketingExpense'=>$salesAndMarketingExpense
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.sales-and-marketing-expenses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php endif; ?>

                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">

                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">

                        <div class="col-md-12">
                            <h2 for="" class="d-bloxk"><?php echo e(__('General & Administrative Expenses')); ?></h2>
                            <div id="m_repeater_5">
                                <div class="form-group  m-form__group row">
                                    <div data-repeater-list="general_expenses" class="col-lg-12">
                                        <div data-repeater-item class="form-group m-form__group row align-items-center repeater_item">
                                            <?php if(isset($model) && $model->generalExpenses->count()): ?>
                                            <?php $__currentLoopData = $model->generalExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $generalExpense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.general-expenses',[
                                            'generalExpense'=>$generalExpense??[]
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <?php echo $__env->make('admin.quick-pricing-calculator.form.general-expenses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                            <?php if(! isset($disabled) || ! $disabled): ?>
                                            <div class="">
                                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">

                                                </i>
                                            </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">

                                    <?php if(! isset($disabled) || ! $disabled): ?>
                                    <div class="col-lg-6">
                                        <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                            <span>
                                                <i class="fa fa-plus"> </i>
                                                <span>
                                                    <?php echo e(__('Add')); ?>

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>










                    </div>

                </div>

            </div>













            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <div class="col-12">
                            <h2 class="h2 mb-4"> <?php echo e(__('Profitability Section')); ?> </h2>
                            <hr>
                        </div>


                        <?php if(isset($model) && $model->profitability): ?>

                        <?php echo $__env->make('admin.quick-pricing-calculator.form.profitability',[
                        'profitability'=>$model->profitability
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php else: ?>
                        <?php echo $__env->make('admin.quick-pricing-calculator.form.profitability', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php endif; ?>









                    </div>

                </div>

            </div>




             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calculate-btn','data' => []]); ?>
<?php $component->withName('calculate-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 



            <!--end::Form-->

            <!--end::Portlet-->
    </div>

    <div class="col-md-12">


        <div class="kt-portlet">


            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-12">
                        <h2><?php echo e(__('Recommended Calculated Pricing & Profitability')); ?></h2>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total Recommend Price Without VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="total-recommend-price-without-vat" readonly class="form-control disabled-custom text-center" name="total_recommend_price_without_vat" value="<?php echo e(isset($model) ? $model->getTotalRecommendPriceWithoutVat() : old('total_recommend_price_without_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total Recommend Price With VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="total-recommend-price-with-vat" readonly class="form-control disabled-custom text-center" name="total_recommend_price_with_vat" value="<?php echo e(isset($model) ? $model->getTotalRecommendPriceWithVat() : old('total_recommend_price_with_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Price Per Day Without VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="price-per-day-without-vat" readonly class="form-control disabled-custom text-center" name="price_per_day_without_vat" value="<?php echo e(isset($model) ? $model->getPricePerDayWithoutVat() : old('price_per_day_without_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>




                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Price Per Day With VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="price-per-day-with-vat" readonly class="form-control disabled-custom text-center" name="price_per_day_with_vat" value="<?php echo e(isset($model) ? $model->getPricePerDayWithVat() : old('price_per_day_with_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 mt-4">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total Net Profit After Taxes')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="total-net-profit-after-taxes" readonly class="form-control disabled-custom text-center" name="total_net_profit_after_taxes" value="<?php echo e(isset($model) ? $model->getTotalNetProfitAfterTaxes() : old('total_net_profit_after_taxes')); ?>" step="any">
                            </div>
                        </div>

                    </div>





                    <div class="col-md-6 mt-4">
                        <label class="form-label font-weight-bold"><?php echo e(__('Net Profit After Taxes Per Day')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="net-profit-after-taxes-per-day" readonly class="form-control disabled-custom text-center" name="net_profit_after_taxes_per_day" value="<?php echo e(isset($model) ? $model->getNetProfitAfterTaxesPerDay() : old('net_profit_after_taxes_per_day')); ?>" step="any">
                            </div>
                        </div>

                    </div>






                </div>
            </div>

        </div>



        <div class="kt-portlet">


            <div class="kt-portlet__body">
                <div class="row ">
                    <div class="col-12">
                        <h2><?php echo e(__('Sensitivity Section')); ?></h2>
                        <hr>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Apply Price Sensitivity (+/- %) ')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="price-sensitiviy" name="price_sensitivity" class="form-control only-percentage-allowed-between-minus-plus-hundred " name="price_sensitiviy" value="<?php echo e(isset($model) ? $model->getPriceSensitivity() : old('price_sensitiviy')); ?>" step="any">
                            </div>
                        </div>

                    </div>

                </div>


                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total Sensitive Price Without VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="total-sensitive-price-without-vat" readonly class="form-control disabled-custom text-center" name="total_sensitive_price_without_vat" value="<?php echo e(isset($model) ? $model->getTotalSensitivePriceWithoutVat() : old('total_sensitive_price_without_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Total Sensitive Price With VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="total-sensitive-price-with-vat" readonly class="form-control disabled-custom text-center" name="total_sensitive_price_with_vat" value="<?php echo e(isset($model) ? $model->getTotalSensitivePriceWithVat() : old('total_sensitive_price_with_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Sensitive Price Per Day Without VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="sensitive-price-per-day-without-vat" readonly class="form-control disabled-custom text-center" name="sensitive_price_per_day_without_vat" value="<?php echo e(isset($model) ? $model->getSensitivePricePerDayWithoutVat() : old('sensitive_price_per_day_without_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>




                    <div class="col-md-3">
                        <label class="form-label font-weight-bold"><?php echo e(__('Sensitive Price Per Day With VAT')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="sensitive-price-per-day-with-vat" readonly class="form-control disabled-custom text-center" name="sensitive_price_per_day_with_vat" value="<?php echo e(isset($model) ? $model->getSensitivePricePerDayWithVat() : old('sensitive_price_per_day_with_vat')); ?>" step="any">
                            </div>
                        </div>

                    </div>


                    <div class="col-md-4 mt-4">
                        <label class="form-label font-weight-bold"><?php echo e(__('Sensitive Total Net Profit After Taxes')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="sensitive-total-net-profit-after-taxes" readonly class="form-control disabled-custom text-center" name="sensitive_total_net_profit_after_taxes" value="<?php echo e(isset($model) ? $model->getSensitiveTotalNetProfitAfterTaxes() : old('sensitive_total_net_profit_after_taxes')); ?>" step="any">
                            </div>
                        </div>

                    </div>







                    <div class="col-md-4 mt-4">
                        <label class="form-label font-weight-bold"><?php echo e(__('Sensitive Net Profit After Taxes Per Day')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="sensitive-net-profit-after-taxes-per-day" readonly class="form-control disabled-custom text-center" name="sensitive_net_profit_after_taxes_per_day" value="<?php echo e(isset($model) ? $model->getSensitiveNetProfitAfterTaxesPerDay() : old('sensitive_net_profit_after_taxes_per_day')); ?>" step="any">
                            </div>
                        </div>

                    </div>


                    <div class="col-md-4 mt-4">
                        <label class="form-label font-weight-bold"><?php echo e(__('Sensitive Net Profit After Taxes %')); ?> </label>
                        <div class="kt-input-icon">
                            <div class="input-group">
                                <input id="sensitive-net-profit-after-taxes-percentage" readonly class="form-control disabled-custom text-center" name="sensitive_net_profit_after_taxes_percentage" value="<?php echo e(isset($model) ? $model->getSensitiveNetProfitAfterTaxesPercentage() : old('sensitive_net_profit_after_taxes_percentage')); ?>" step="any">
                            </div>
                        </div>

                    </div>





                </div>


            </div>
             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calculate-btn','data' => []]); ?>
<?php $component->withName('calculate-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        </div>
        </form>
         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.bs-modal','data' => ['id' => 'enter-name','modalTitle' => __('Quick Pricing Calculator Name'),'hasSaveBtn' => true,'saveBtnTitle' => __('Save'),'submitBtnClass' => 'save-calc-btn submit-form-btn-new']]); ?>
<?php $component->withName('form.bs-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('enter-name'),'modalTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Quick Pricing Calculator Name')),'hasSaveBtn' => true,'saveBtnTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Save')),'submitBtnClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('save-calc-btn submit-form-btn-new')]); ?>
            <input type="text" class="form-control test" id="calculator-name" value="<?php echo e(isset($model) ? $model->getName() : ''); ?>">
         <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
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



    <script>
        $(document).on('keyup', '.total-cost-calculations-class', function() {
            let index = $(this).closest("[data-repeater-item]").index();
            let workingDays = parseFloat($('[name="manpower_expenses[' + index + '][manpower_expense_working_days]"]').val());
            let costPerDay = parseFloat($('[name="manpower_expenses[' + index + '][manpower_expense_cost_per_day]"]').val());
            let totalCost = parseFloat(costPerDay * workingDays);
            $('[name="manpower_expenses[' + index + '][manpower_expense_total_cost]"]').val(number_format(totalCost, 0));

        });
        $(document).on('change', '.use-freelancer', function() {
            let useFreelancer = +$(this).val();
            if (useFreelancer) {
                $('.use-freelancer-repeater').fadeIn(300)
            } else {
                $('.use-freelancer-repeater').fadeOut(300);
                $('input[name*="freelancer_expenses"]').val(0);
            }
        });

    </script>

    <script>
        $(document).on('keyup', '.mp-total-cost-class', function() {
            let mpCostPerUnit = parseFloat($(this).closest('.form-group').find('[name*="mp_cost_per_unit"]').val());
            let mpUnitsCount = parseFloat($(this).closest('.form-group').find('[name*="mp_units_count"]').val());
            let totalCost = parseFloat(mpCostPerUnit * mpUnitsCount);
            $(this).closest('.form-group').find('[name*="mp_total_cost"]').val(number_format(totalCost, 0));
        });


        $(document).on('keyup', '.direct-opex-total-cost-class', function() {
            let directOpexCostPerUnit = parseFloat($(this).closest('.form-group').find('[name*="direct_opex_cost_per_unit"]').val());
            directOpexCostPerUnit = directOpexCostPerUnit ? directOpexCostPerUnit : 0;
            let directOpexUnitsCount = parseFloat($(this).closest('.form-group').find('[name*="direct_opex_units_count"]').val());
            directOpexUnitsCount = directOpexUnitsCount ? directOpexUnitsCount : 0;
            let totalCost = parseFloat(directOpexCostPerUnit * directOpexUnitsCount);
            $(this).closest('.form-group').find('[name*="direct_opex_total_cost"]').val(number_format(totalCost, 0));
        });

        $(document).on('keyup', '.smex-total-cost-class', function() {
            let SalesAndMarketingCostPerUnit = parseFloat($(this).closest('.form-group').find('[name*="smex_cost_per_unit"]').val());
            SalesAndMarketingCostPerUnit = SalesAndMarketingCostPerUnit ? SalesAndMarketingCostPerUnit : 0;
            let SalesAndMarketingUnitsCount = parseFloat($(this).closest('.form-group').find('[name*="smex_units_count"]').val());
            SalesAndMarketingUnitsCount = SalesAndMarketingUnitsCount ? SalesAndMarketingUnitsCount : 0;
            let totalCost = parseFloat(SalesAndMarketingCostPerUnit * SalesAndMarketingUnitsCount);
            $(this).closest('.form-group').find('[name*="smex_total_cost"]').val(number_format(totalCost, 0));
        });

        $(document).on('keyup', '.gaex-total-cost-class', function() {
            let GeneralCostPerUnit = parseFloat($(this).closest('.form-group').find('[name*="gaex_cost_per_unit"]').val());
            GeneralCostPerUnit = GeneralCostPerUnit ? GeneralCostPerUnit : 0;
            let GeneralUnitsCount = parseFloat($(this).closest('.form-group').find('[name*="gaex_units_count"]').val());
            GeneralUnitsCount = GeneralUnitsCount ? GeneralUnitsCount : 0;
            let totalCost = parseFloat(GeneralCostPerUnit * GeneralUnitsCount);
            $(this).closest('.form-group').find('[name*="gaex_total_cost"]').val(number_format(totalCost, 0));
        });

        $(document).on('keyup', '.freelancer-total-cost-calculations-class', function() {
            let index = $(this).closest("[data-repeater-item]").index();

            let workingDays = parseFloat($('[name="freelancer_expenses[' + index + '][freelancer_working_days]"]').val());
            let costPerDay = parseFloat($('[name="freelancer_expenses[' + index + '][freelancer_cost_per_day]"]').val());
            workingDays = workingDays ? workingDays : 0;
            costPerDay = costPerDay ? costPerDay : 0;
            let totalCost = parseFloat(costPerDay * workingDays);
            $('[name="freelancer_expenses[' + index + '][freelancer_total_cost]"]').val(number_format(totalCost, 0));
        });

        $(document).on('click', '.calculate-class', function(e) {

            e.preventDefault();
            totalPercentage = 0;
            $('.percentage-summation').each(function(index, field) {
                val = $(field).val();

                if (val && val != undefined) {
                    totalPercentage += parseFloat(val);
                }

            });
            totalPercentage = totalPercentage / 100; /////////1 
            totalPercentage = totalPercentage ? totalPercentage : 0;
            corporateTaxes = parseFloat($('#corporate_taxes_percentage').val()) / 100;
            corporateTaxes = corporateTaxes ? corporateTaxes : 0;
            var netProfitPercentage = parseFloat($('#net_profit_after_taxes_percentage').val()) / 100;
            netProfitPercentage = netProfitPercentage ? netProfitPercentage : 0;
            ebt = (netProfitPercentage) / (1 - corporateTaxes);
            var grantTotalPercentage = ebt + totalPercentage;
            var totalCost = 0;

            $('.total-cost-summation').each(function(index, field) {
                val = parseFloat($(field).val().replace(/,/g, ''));
                if (val && val != undefined) {
                    totalCost += parseFloat(val);
                }
            });
            var vatPercentage = parseFloat($('#vat-percentage').val()) / 100;
            vatPercentage = vatPercentage ? vatPercentage : 0;
            var recommendPrice = totalCost / (1 - grantTotalPercentage);
            var deliver_days = parseFloat($('#delivery-days').val());
            deliver_days = deliver_days ? deliver_days : 1;
            $('#total-recommend-price-without-vat').val(number_format(recommendPrice, 0));
            var totalRecommendPriceWithVat = recommendPrice * (1 + vatPercentage);
            $('#total-recommend-price-with-vat').val(number_format(totalRecommendPriceWithVat, 0));
            var pricePerDayWithoutVat = 0;
            if (deliver_days) {
                pricePerDayWithoutVat = recommendPrice / (deliver_days);
                $('#price-per-day-without-vat').val(number_format(pricePerDayWithoutVat, 0));
            } else {
                $('#price-per-day-without-vat').val(0);

            }
            var pricePerDayWithVat = pricePerDayWithoutVat * (1 + vatPercentage);
            $('#price-per-day-with-vat').val(number_format(pricePerDayWithVat, 0));
            let TotalNetProfitAfterTax = recommendPrice * netProfitPercentage;
            $('#total-net-profit-after-taxes').val(number_format(TotalNetProfitAfterTax, 0));
            var netProfitAfterTaxesPerDay = deliver_days ? TotalNetProfitAfterTax / deliver_days : 0;
            $('#net-profit-after-taxes-per-day').val(number_format(netProfitAfterTaxesPerDay, 0));

            let priceSensitive = parseFloat($('#price-sensitiviy').val()) / 100;
            priceSensitive = priceSensitive ? priceSensitive : 0;
            let totalSensitivePriceWithoutVat = recommendPrice * (1 + priceSensitive);
            $('#total-sensitive-price-without-vat').val(number_format(totalSensitivePriceWithoutVat, 0));

            $('#total-sensitive-price-with-vat').val(number_format(totalRecommendPriceWithVat * (1 + priceSensitive), 0));
            var sensitivePricePerDayWithoutVat = pricePerDayWithoutVat * (1 + priceSensitive);
            $('#sensitive-price-per-day-without-vat').val(number_format(sensitivePricePerDayWithoutVat, 0));

            var sensitivePricePerDayWithVat = pricePerDayWithVat * (1 + priceSensitive);
            $('#sensitive-price-per-day-with-vat').val(number_format(sensitivePricePerDayWithVat, 0));

            let sensitiveTotalNetProfitAfterTaxes = (totalSensitivePriceWithoutVat - (totalSensitivePriceWithoutVat * totalPercentage) - totalCost) * (1 - corporateTaxes);

            $('#sensitive-total-net-profit-after-taxes').val(number_format(sensitiveTotalNetProfitAfterTaxes, 0));

            var sensitiveNetProfitAfterTaxesPerDay = deliver_days ? sensitiveTotalNetProfitAfterTaxes / deliver_days : 0;
            $('#sensitive-net-profit-after-taxes-per-day').val(number_format(sensitiveNetProfitAfterTaxesPerDay, 0));
            var sensitiveNetProfitAfterTaxesPercentage = totalSensitivePriceWithoutVat ? sensitiveTotalNetProfitAfterTaxes / totalSensitivePriceWithoutVat * 100 : 0;
            $('#sensitive-net-profit-after-taxes-percentage').val(number_format(sensitiveNetProfitAfterTaxesPercentage, 2) + ' %');

            if ($(this).hasClass('calculate-and-save')) {
                $('#enter-name').modal('show');


            }


        });

    </script>

    <script>
        $(document).on('click', '.save-calc-btn', function() {
            const name = $('#calculator-name').val();
            if (name) {
                $('#name-for-calculator').val(name);
                let form = document.getElementById('quick-pricing-calculator-form-id');
                var formData = new FormData(form);
                $('.submit-form-btn-new').prop('disabled', true);
                $.ajax({
                    cache: false
                    , contentType: false
                    , processData: false
                    , url: form.getAttribute('action')
                    , data: formData
                    , type: form.getAttribute('method')
                    , success: function(res) {
                        $('.submit-form-btn-new').prop('disabled', false)

                        Swal.fire({
                            icon: 'success'
                            , title: res.message,

                        });
                        if ($('select[name="pricing_plan_id"]').val()) {
                            window.location.href = "<?php echo e(route('admin.view.quick.pricing.calculator',['company'=>$company->id , 'active'=>'pricing-plans'])); ?>";

                        } else {
                            window.location.href = "<?php echo e($redirectAfterSubmitRoute ?? ''); ?>";

                        }




                    }
                    , complete: function() {
                        $('#enter-name').modal('hide');
                        $('#name-for-calculator').val('');

                    }
                    , error: function(res) {
                        $('.submit-form-btn-new').prop('disabled', false)
                        Swal.fire({
                            icon: 'error'
                            , title: res.responseJSON.message
                        , });
                    }
                });
            } else {
                alert('<?php echo e(__("Please Enter Calculator Name")); ?>')
            }
        })

    </script>
    <?php if(isset($disabled) && $disabled): ?>
    <script>
        $('input , select , button').prop('disabled', true);
        $('button').prop('hidden', true)

    </script>
    <?php endif; ?>
    <script>
        $('.use-freelancer:checked').trigger('change');

    </script>
    <script>
        $(function() {
            $(document).on('click', '[data-repeater-create]', function() {
                $('select.select2-select').selectpicker('refresh');
            });

        })

    </script>


    <script>
        var openedSelect = null;
        var modalId = null



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

    </script>
<script>
$(function(){
	$('select.revenue_business_line_class').trigger('change')
})
</script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/quick-pricing-calculator/create.blade.php ENDPATH**/ ?>