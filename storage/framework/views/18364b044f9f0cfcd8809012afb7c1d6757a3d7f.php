<?php $__env->startSection('css'); ?>
<?php
use App\Models\LetterOfGuaranteeIssuance;
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
<?php echo e(__('Letter Of Gurantee Issuance Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form method="post" action="<?php echo e(isset($model) ?  route('update.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$source]) :route('store.letter.of.guarantee.issuance',['company'=>$company->id,'source'=>$source])); ?>" class="kt-form kt-form--label-right">
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
                                    <?php echo e(__((isset($model) ? 'Edit' : 'Add') . ' Letter Of Guarantee Issuance')); ?>

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
                                        <?php echo e(__('Letter Of Guarantee Type')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">
								
									 <div class="col-md-3">
                                        <label><?php echo e(__('Issuance Type')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
                                            <select name="category_name" required class="form-control repeater-select">
												<option value=""><?php echo e(__('Select')); ?></option>
                                                <?php $__currentLoopData = LetterOfGuaranteeIssuance::getCategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if(isset($model) && $model->getCategoryName() == $key ): ?> selected <?php endif; ?> > <?php echo e($title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                    </div>
									
                                    <div class="col-md-4">
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
                                     <div class="col-md-5">
                                        <label> <?php echo e(__('Bank')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <select required js-when-change-trigger-change-account-type change-financial-instutition-js id="financial-instutition-id" js-get-lg-facility-based-on-financial-institution js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control">
											<option value=""><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getFinancialInstitutionBankId() == $financialInstitutionBank->id ? 'selected':''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
									
									
									
									  <div class="col-md-3">
                                        <label><?php echo e(__('LG Facility')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select required js-update-outstanding-balance-and-limits data-current-selected="<?php echo e(isset($model) ? $model->getLgFacilityId() : 0); ?>" id="lg-facility-id" name="lg_facility_id" class="form-control">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									

									
									
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'limit-id','defaultValue' => 0,'model' => $model??null,'label' => __('LG Limit'),'type' => 'text','placeholder' => __('LG Limit'),'name' => 'limit','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('limit-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Limit')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Limit')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('limit'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'total-lg-for-all-types-id','defaultValue' => 0,'model' => $model??null,'label' => __('Total LGs Outstanding Balance'),'type' => 'text','name' => 'total_lg_outstanding_balance','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total-lg-for-all-types-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total LGs Outstanding Balance')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total_lg_outstanding_balance'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'total-room-id','defaultValue' => 0,'model' => $model??null,'label' => __('Total LGs Room'),'type' => 'text','placeholder' => __('Total LGs Room'),'name' => 'total_lg_outstanding_balance','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total-room-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total LGs Room')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Total LGs Room')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('total_lg_outstanding_balance'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-3">
                                        <label> <?php echo e(__('LG Type')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>

                                        <select required js-update-outstanding-balance-and-limits id="lg-type" name="lg_type" class="form-control js-toggle-bond">
                                            <option value=""><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = getLgTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $nameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($name); ?>" <?php if(isset($model) && $model->getLgType() == $name ): ?> selected <?php endif; ?> > <?php echo e($nameFormatted); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3 ">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'current-lg-type-outstanding-balance-id','defaultValue' => 0,'model' => $model??null,'label' => __('LG Type Outstanding Balance'),'type' => 'text','placeholder' => __('LG Type Outstanding Balance'),'name' => 'lg_type_outstanding_balance','class' => 'only-greater-than-zero-allowed','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('current-lg-type-outstanding-balance-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Type Outstanding Balance')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Type Outstanding Balance')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_type_outstanding_balance'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-zero-allowed'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['model' => $model??null,'label' => __('LG Code'),'type' => 'text','placeholder' => __('LG Code'),'name' => 'lg_code','class' => '','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Code')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Code')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_code'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                                    <select required  data-current-selected="<?php echo e(isset($model) ? $model->getBeneficiaryId():0); ?>" data-current-selected="<?php echo e(isset($model) ? $model->getBeneficiaryId() : 0); ?>" js-update-contracts-based-on-customers data-live-search="true" data-actions-box="true" id="customer_name" name="partner_id" class="form-control select2-select">
                                            
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

                                    <div class="col-md-3 hidden hide-only-bond only-with-customer">

                                        <label> <?php echo e(__('Contract Reference')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <select js-update-purchase-orders-based-on-contract id="contract-id" data-current-selected="<?php echo e(isset($model) ?  $model->getContractId() : 0); ?>" name="contract_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                            
                                        </select>
                                    </div>





                                    <div class="col-md-2 hidden hide-only-bond only-with-customer">

                                        <label> <?php echo e(__('Purchase Order')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>

                                        <select id="purchase-order-id" data-current-selected="<?php echo e(isset($model) ? $model->getPurchaseOrderId() : 0); ?>" name="purchase_order_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-2 hidden hide-only-bond only-with-customer">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Purchase Order Date'),'required' => true,'model' => $model??null,'name' => 'purchase_order_date','placeholder' => __('Select Purchase Order Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Purchase Order Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('purchase_order_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Purchase Order Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
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
                                        <?php echo e(__('Letter Of Guarantee Information')); ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">
								
								

                                    <div class="col-md-3">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['classes' => 'recalc-renewal-date issuance-date-js','label' => __('Issuance Date'),'required' => true,'model' => $model??null,'name' => 'issuance_date','placeholder' => __('Select Purchase Order Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalc-renewal-date issuance-date-js'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Issuance Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('issuance_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Purchase Order Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 1,'model' => $model??null,'label' => __('LG Duration Months'),'type' => 'numeric','placeholder' => __('LG Duration Months'),'name' => 'lg_duration_months','class' => 'recalc-renewal-date lg-duration-months-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 1,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Duration Months')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('numeric'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Duration Months')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_duration_months'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('recalc-renewal-date lg-duration-months-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">

                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['classes' => 'renewal-date-js','readonly' => true,'label' => __('Renewal Date'),'required' => true,'model' => $model??null,'name' => 'renewal_date','placeholder' => __('Select Renewal Date')]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('renewal-date-js'),'readonly' => true,'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Renewal Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('renewal_date'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Select Renewal Date'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['dataCurrentValue' => isset($model) ? $model->getLgAmount():0,'model' => $model??null,'label' => __('LG Amount'),'type' => 'text','placeholder' => __('LG Amount'),'name' => 'lg_amount','class' => 'only-greater-than-or-equal-zero-allowed only-smaller-than-or-equal-specific-number-allowed recalculate-cash-cover-amount-js recalculate-lg-commission-amount-js lg-amount-js ','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-current-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getLgAmount():0),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed only-smaller-than-or-equal-specific-number-allowed recalculate-cash-cover-amount-js recalculate-lg-commission-amount-js lg-amount-js '),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>

                                    <div class="col-md-3">
                                        <label><?php echo e(__('LG Currency')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
										<input type="text" class="form-control current-currency-input" name="lg_currency" id="lg-currency-id" value="" readonly js-when-change-trigger-change-account-type >
                                        
                                        </div>
                                    </div>
							
                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => $source != LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER ?  'cash-cover-rate-id' : 'cash-cover-rate-id2','defaultValue' => $source == LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER ? 100 : 0 ,'readonly' => $source == LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER,'model' => $model??null,'label' => __('Cash Cover Rate %'),'type' => 'text','placeholder' => __('Cash Cover Rate %'),'name' => 'cash_cover_rate','class' => 'only-greater-than-or-equal-zero-allowed recalculate-cash-cover-amount-js cash-cover-rate-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($source != LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER ?  'cash-cover-rate-id' : 'cash-cover-rate-id2'),'default-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($source == LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER ? 100 : 0 ),'readonly' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($source == LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Cover Rate %')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Cover Rate %')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cash_cover_rate'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed recalculate-cash-cover-amount-js cash-cover-rate-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 0,'readonly' => true,'model' => $model??null,'label' => __('Cash Cover Amount'),'type' => 'text','placeholder' => __('Cash Cover Amount'),'name' => 'cash_cover_amount','class' => 'only-greater-than-or-equal-zero-allowed cash-cover-amount-js' ,'required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 0,'readonly' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Cover Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Cash Cover Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cash_cover_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed cash-cover-amount-js' ),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
							




                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'lg_commission_rate-id','defaultValue' => 0,'model' => $model??null,'label' => __('LG Commission Rate %'),'type' => 'text','placeholder' => __('LG Commission Rate %'),'name' => 'lg_commission_rate','class' => 'only-greater-than-or-equal-zero-allowed recalculate-lg-commission-amount-js lg-commission-rate-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_commission_rate-id'),'default-value' => 0,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Commission Rate %')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Commission Rate %')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_commission_rate'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed recalculate-lg-commission-amount-js lg-commission-rate-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>


                                    <div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['defaultValue' => 0,'readonly' => true,'model' => $model??null,'label' => __('LG Commission Amount'),'type' => 'text','placeholder' => __('LG Commission Amount'),'name' => 'lg_commission_amount','class' => 'only-greater-than-or-equal-zero-allowed lg-commission-amount-js','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['default-value' => 0,'readonly' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Commission Amount')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LG Commission Amount')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lg_commission_amount'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed lg-commission-amount-js'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </div>
                                 
									<div class="col-md-3">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.input','data' => ['id' => 'min_lg_commission_fees_id','defaultValue' => 0,'readonly' => true,'model' => $model??null,'label' => __('Min LG Commission Fees'),'type' => 'text','placeholder' => __('Min LG Commission Fees'),'name' => 'min_lg_commission_fees','class' => 'only-greater-than-or-equal-zero-allowed ','required' => true]]); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('min_lg_commission_fees_id'),'default-value' => 0,'readonly' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min LG Commission Fees')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Min LG Commission Fees')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('min_lg_commission_fees'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('only-greater-than-or-equal-zero-allowed '),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                        <label><?php echo e(__('LG Commission Interval')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="input-group">
                                            <select name="lg_commission_interval" class="form-control repeater-select">
                                                
                                                <?php $__currentLoopData = getCommissionInterval(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if(isset($model) && $model->getLgCommissionInterval() == $key ): ?> selected <?php endif; ?> > <?php echo e($title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                    </div>




									 <div class="col-md-3">
                                        <label><?php echo e(__('Cash Cover From Account Type')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select id="account_type_id" name="cash_cover_deducted_from_account_type" class="form-control js-update-account-id-based-on-account-type">
                                                    <?php $__currentLoopData = $cashCoverAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(isset($model) && ($accountType->id == $model->getCashCoverDeductedFromAccountTypeId()) ): ?> selected <?php endif; ?> value="<?php echo e($accountType->id); ?>"><?php echo e($accountType->getName()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label><?php echo e(__('Account Number')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select js-cd-or-td-account-number data-current-selected="<?php echo e(isset($model) ? $model->getCashCoverDeductedFromAccountId(): 0); ?>" name="cash_cover_deducted_from_account_id" class="form-control js-account-number">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
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
									

                                    <div class="col-md-3">
                                        <label><?php echo e(__('Fees & Commission Account Type')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select data-append-to-query=".js-account-id-2" name="lg_fees_and_commission_account_type" class="form-control 
												js-update-account-id-based-on-account-type
												">
                                                    
                                                    <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getFeesAndCommissionAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
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
                                                <select data-current-selected="<?php echo e(isset($model) ? $model->getFeesAndCommissionAccountId(): 0); ?>" name="lg_fees_and_commission_account_id" class="form-control js-account-id-2">
                                                    <option value="" selected><?php echo e(__('Select')); ?></option>
                                                </select>
                                            </div>
                                        </div>
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
                $(document).on('change', '.recalc-renewal-date', function(e) {
                    e.preventDefault()
                    let date = $('.issuance-date-js').val();
                    date = date.replaceAll('-', '/')

                    const issuanceDate = new Date(date);
                    const duration = $('.lg-duration-months-js').val();
                    if (issuanceDate || duration == '0') {
                        const numberOfMonths = duration

                        let renewalDate = issuanceDate.addMonths(numberOfMonths)

                        renewalDate = formatDateForSelect2(renewalDate)
                        $('.renewal-date-js').val(renewalDate).trigger('change')
                    }

                })
                $(document).on('change', '.recalculate-cash-cover-amount-js', function() {
                    const lgAmount = number_unformat($('.lg-amount-js').val())
                    const cashCoverRateJs = number_unformat($('.cash-cover-rate-js').val()) / 100
                    const cashCoverAmount = lgAmount * cashCoverRateJs
                    $('.cash-cover-amount-js').val(toFixed(cashCoverAmount))
                })

                $(document).on('change', '.recalculate-lg-commission-amount-js', function() {
                    const lgAmount = number_unformat($('.lg-amount-js').val())
                    const rate = number_unformat($('.lg-commission-rate-js').val()) / 100
                    const lgCommissionAmount = lgAmount * rate
                    $('.lg-commission-amount-js').val(toFixed(lgCommissionAmount))
                })

                $('.recalc-renewal-date').trigger('change')
                $('.recalculate-cash-cover-amount-js').trigger('change')
                $('.recalculate-lg-commission-amount-js').trigger('change')

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
            <script>
                $(document).on('change', '[js-update-outstanding-balance-and-limits]', function(e) {
                    e.preventDefault()
                    const financialInstitutionId = $('select#financial-instutition-id').val()
                    const lgType = $('select#lg-type').val()
							const source = "<?php echo e($source); ?>"
						const letterOfGuaranteeFacilityId = $('select#lg-facility-id').val();
						const lgIssuanceId = "<?php echo e(isset($model) ? $model->id : 0); ?>" 
                    $.ajax({
                        url: "<?php echo e(route('update.letter.of.guarantee.outstanding.balance.and.limit',['company'=>$company->id])); ?>"
                        , data: {
							lgIssuanceId,
                            financialInstitutionId
                            , lgType,
							source,
							letterOfGuaranteeFacilityId
                        }
                        , type: "GET"
                        , success: function(res) {
							let customerOptions = '<option value=""><?php echo e(__("Please Select")); ?></option>';
							let currentSelectedCustomerId = $('select#customer_name').attr('data-current-selected');
							
							for(var customerId in res.customers ){
								var customerName = res.customers[customerId];
								var isSelected =  customerId  == currentSelectedCustomerId  ? 'selected' :'';
								customerOptions += '<option '+ isSelected +' value="'+customerId+'">'+ customerName +'</option> ';
							}
							$('select#customer_name').empty().append(customerOptions).trigger('change');
							
							
                            $('#limit-id').val(res.limit).prop('readonly', true)
                            $('#total-lg-for-all-types-id').val(res.total_lg_outstanding_balance).prop('readonly', true)
                            $('#total-room-id').val(res.total_room).prop('readonly', true)
							var totalRoom = number_unformat(res.total_room);
							$('input[name="lg_amount"]').attr('data-can-not-be-greater-than',totalRoom);
                            $('#current-lg-type-outstanding-balance-id').val(res.current_lg_type_outstanding_balance).prop('readonly', true)
							$('#lg-currency-id').val(res.currency_name).trigger('change');
                            $('#min_lg_commission_fees_id').val(res.min_lg_commission_rate).trigger('change');
                            $('#lg_commission_rate-id').val(res.lg_commission_rate).trigger('change');
                            $('#issuance_fees_id').val(res.min_lg_issuance_fees_for_current_lg_type).trigger('change');
                            $('#cash-cover-rate-id').val(res.min_lg_cash_cover_rate_for_current_lg_type).trigger('change');
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
                $(document).on('change', '[js-update-contracts-based-on-customers]', function(e) {
                    const customerId = $('select#customer_name').val()
					
                    if (!customerId) {
                        return;
                    }
                    $.ajax({
                        url: "<?php echo e(route('update.contracts.based.on.customer',['company'=>$company->id])); ?>"
                        , data: {
                            customerId
                        , }
                        , type: "GET"
                        , success: function(res) {
							var isCustomer = res.is_customer ;
							if(!isCustomer){
								$('.only-with-customer .required-label').addClass('visibility-hidden')
							
							}else{
								$('.only-with-customer .required-label').removeClass('visibility-hidden')
						
							}
                            var contractsOptions = '';
                            var currentSelectedId = $('select#contract-id').attr('data-current-selected')
                            for (var contractId in res.contracts) {
                                var contractName = res.contracts[contractId];
                                contractsOptions += `<option ${currentSelectedId == contractId ? 'selected' : '' } value="${contractId}"> ${contractName}  </option> `;
                            }
							$('select#purchase-order-id').empty().selectpicker("refresh");
                            $('select#contract-id').empty().append(contractsOptions).selectpicker("refresh");
                            $('select#contract-id').trigger('change')
                        }
                    })
                })
                $('[js-update-contracts-based-on-customers]').trigger('change')

            </script>





            <script>
                $(document).on('change', '[js-update-purchase-orders-based-on-contract]', function(e) {
                    const contractId = $('select#contract-id').val()
                    if (!contractId) {
                        return
                    }
                    $.ajax({
                        url: "<?php echo e(route('update.sales.orders.based.on.contract',['company'=>$company->id])); ?>"
                        , data: {
                            contractId
                        , }
                        , type: "GET"
                        , success: function(res) {
                            var purchaseOrdersOptions = '<option value="null"> <?php echo e(__("All")); ?> </option> ';
                            var currentSelectedId = $('select#purchase-order-id').attr('data-current-selected')
                            for (var purchaseOrderId in res.purchase_orders) {
                                var contractName = res.purchase_orders[purchaseOrderId];
                                purchaseOrdersOptions += `<option ${currentSelectedId == purchaseOrderId ? 'selected' : '' } value="${purchaseOrderId}"> ${contractName}  </option> `;
                            }
                            $('select#purchase-order-id').empty().append(purchaseOrdersOptions).selectpicker("refresh");
                        }
                    })
                })
                $('[js-update-purchase-orders-based-on-contract]').trigger('change')

            </script>
			
			
			
            <script>
                $(document).on('change', '[js-cd-or-td-account-number]', function() {
                    const parent = $(this).closest('.kt-portlet__body');
					const financialInstitutionId = $('select#financial-instutition-id').val();
			
                    const accountType = parent.find('.js-update-account-id-based-on-account-type').val()
                    const accountId = parent.find('[js-cd-or-td-account-number]').val();
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
								parent.find('#cd-or-td-amount-id').attr('data-value',0).val(0).trigger('change')
						
					}
                })

            </script>



<script>

$(document).on('change','select[js-get-lg-facility-based-on-financial-institution]',function(){
	const financialInstitutionId = $('#financial-instutition-id').val();
	const currentSelected = $('select#lg-facility-id').attr('data-current-selected');
	$.ajax({
		url:"<?php echo e(route('get.lg.facility.based.on.financial.institution',['company'=>$company->id])); ?>",
		data:{
			financialInstitutionId
		},
		success:function(res){
			const lgFacilities = res.letterOfGuaranteeFacilities ;
			let options='<option value=""><?php echo e(__("Select")); ?></option>';
			for(id in lgFacilities){
				var name =lgFacilities[id]; 
				options+=`<option ${currentSelected == id ? 'selected' : '' } value="${id}"  >${name}</option>`
			}
			$('select#lg-facility-id').empty().append(options).trigger('change')
		}
	})
})
$('select[js-get-lg-facility-based-on-financial-institution]').trigger('change')
</script>
			
               <?php echo $__env->make('reports.LetterOfGuaranteeIssuance.commonJs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfGuaranteeIssuance/lg-facility-form.blade.php ENDPATH**/ ?>