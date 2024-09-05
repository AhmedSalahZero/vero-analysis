<?php
use App\Models\MoneyReceived ;
use App\Models\MoneyPayment ;
?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .css-fix-plus-direction {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-direction: row-reverse;
    }

    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
    }

    .customer-name-width {
        max-width: 250px !important;
        width: 250px !important;
        min-width: 250px !important;
    }

    .drawee-bank-width {
        max-width: 665px !important;
        width: 665px !important;
        min-width: 665px !important;
    }

    .width-8 {
        max-width: 100px !important;
        width: 100px !important;
        min-width: 100px !important;
        flex: initial !important;
    }

    .width-12 {
        max-width: 150px !important;
        width: 150px !important;
        min-width: 150px !important;
        flex: initial !important;
    }



    .width-15 {
        max-width: 170px !important;
        width: 170px !important;
        min-width: 170px !important;
        flex: initial !important;
    }

    thead tr {
        background-color: #CCE2FD !important;

    }

    thead tr th {
        border: 1px solid white !important;
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





    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>

<style>
    .show-class-js.js-parent-to-table {
        overflow: scroll !important;
    }

</style>
<style>

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Opening Balance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="<?php echo e(isset($model) ? route('opening-balance.update',['company'=>$company->id,'opening_balance'=>$model->id]) : route('opening-balance.store',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Opening Balance')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Opening Balance'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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

                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Opening Balance Date')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-md-4 ">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['type' => 'text','classes' => 'datepicker-input','defaultValue' => formatDateForDatePicker(isset($model)  ? $model->getDate() : now()),'model' => $model??null,'label' => __('Opening Balance Date'),'placeholder' => __(''),'name' => 'date','required' => true]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('datepicker-input'),'default-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatDateForDatePicker(isset($model)  ? $model->getDate() : now())),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Opening Balance Date')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('date'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                    <?php echo e(__('Cash In Safe Opening Balance')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = MoneyReceived::CASH_IN_SAFE;
                                $repeaterId = 'm_repeater_6';
                                ?>
                                <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'show-class-js','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                     <?php $__env->slot('ths'); ?> 
                                        <?php $__currentLoopData = [
                                        __('Amount')=>'col-md-1',
                                        __('Currency')=>'col-md-1',
                                        __('Exchange <br> Rate')=>'col-md-1'
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
                                        $rows = isset($model) ? $model->cashInSafes :[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cashInSafeStatement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($cashInSafeStatement instanceof \App\Models\CashInSafeStatement) ){
                                        unset($cashInSafeStatement);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input type="hidden" name="received_branch_id" value="<?php echo e($company->getHeadOfficeId()); ?>">
                                                        <input name="received_amount" type="text" class="form-control " value="<?php echo e(number_format(isset($cashInSafeStatement) ? $cashInSafeStatement->getDebitAmount() : old('amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id" value="<?php echo e(isset($cashInSafeStatement) ? $cashInSafeStatement->id : 0); ?>">





                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($cashInSafeStatement) && $cashInSafeStatement->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>
                                            <td>

                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="exchange_rate" type="text" class="form-control " value="<?php echo e(number_format(isset($cashInSafeStatement) ? $cashInSafeStatement->getExchangeRate() : old('exchange_rate',1))); ?>">
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










                    <div class="kt-portlet">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Cheque In Safe Opening Balance')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = MoneyReceived::CHEQUE;
                                $repeaterId = 'm_repeater_7';

                                ?>
                                <div class="modal fade " data-type="" id="js-choose-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                <button type="button" class="btn btn-primary js-append-bank-name-if-not-exist-in-repeater"><?php echo e(__('Save')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'show-class-js modal-parent--js is-customer-class','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js modal-parent--js is-customer-class'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                     <?php $__env->slot('ths'); ?> 
                                        <?php $__currentLoopData = [
                                        __('Customer <br> Name')=>'customer-name-width',
                                        __('Currency')=>'width-8',
                                        __('Due <br> Date')=>'width-12',
                                        __('Drawee <br> Bank')=>'drawee-bank-width',
                                        __('Amount')=>'col-md-1',
                                        __('Cheque <br> Number')=>'col-md-1',
                                        __('Exchange <br> Rate')=>'col-md-1'

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
                                        $rows = isset($model) ? $model->chequeInSafe :[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chequeInSafe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($chequeInSafe instanceof \App\Models\MoneyReceived) ){
                                        unset($chequeInSafe);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="<?php echo e(isset($chequeInSafe) ? $chequeInSafe->id : 0); ?>">
                                            <td>
                                                <div class="input-group css-fix-plus-direction">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'Partner','addNewModalModalTitle' => __('Customer Name'),'options' => $customersFormatted,'addNew' => false,'label' => ' ','class' => 'customer_name_class repeater-select','dataFilterType' => ''.e('create').'','all' => false,'name' => 'customer_id','selectedValue' => isset($chequeInSafe) ? $chequeInSafe->getCustomerId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Partner'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Customer Name')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($customersFormatted),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'class' => 'customer_name_class repeater-select','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'customer_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($chequeInSafe) ? $chequeInSafe->getCustomerId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                </div>

                                            </td>

                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers width-8" js-when-change-trigger-change-account-type>
                                                        
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($chequeInSafe) && $chequeInSafe->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>

                                            <td>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($chequeInSafe) ?  formatDateForDatePicker($chequeInSafe->getChequeDueDate()) : formatDateForDatePicker(now()),'label' => __('Due Date'),'id' => 'due_date','class' => 'width-12','name' => 'due_date','classes' => 'width-12']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($chequeInSafe) ?  formatDateForDatePicker($chequeInSafe->getChequeDueDate()) : formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Due Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('due_date'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('width-12'),'name' => 'due_date','classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('width-12')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">

                                                        <select data-live-search="true" data-actions-box="true" name="drawee_bank_id" class="form-control repeater-select select2-select	drawee-bank-class">
                                                            <?php $__currentLoopData = $selectedBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId=>$bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($bankId); ?>" <?php echo e(isset($chequeInSafe) && $chequeInSafe->cheque && $chequeInSafe->cheque->getDraweeBankId() == $bankId ? 'selected':''); ?>><?php echo e($bankName); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary js-drawee-bank-class"><?php echo e(__('Add New Bank')); ?></button>



                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="received_amount" type="text" class="form-control " value="<?php echo e(number_format(isset($chequeInSafe) ? $chequeInSafe->getReceivedAmount() : old('amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="cheque_number" type="text" class="form-control " value="<?php echo e(number_format(isset($chequeInSafe) ? $chequeInSafe->getChequeNumber() : old('cheuqe_number',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="exchange_rate" type="text" class="form-control " value="<?php echo e(number_format(isset($chequeInSafe) ? $chequeInSafe->getExchangeRate() : old('amount',0))); ?>">
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












                    <div class="kt-portlet">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Cheque Under Collection Opening Balance')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = MoneyReceived::CHEQUE_UNDER_COLLECTION;
                                $repeaterId = 'm_repeater_8';

                                ?>
                                <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'show-class-js modal-parent--js is-customer-class','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js modal-parent--js is-customer-class'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                     <?php $__env->slot('ths'); ?> 
                                        <?php $__currentLoopData = [
                                        __('Customer <br> Name')=>'customer-name-width',
                                        __('Currency')=>'width-8',
                                        __('Due <br> Date')=>'width-12',
                                        __('Drawee <br> Bank')=>'drawee-bank-width',
                                        __('Amount')=>'width-15',
                                        __('Cheque <br> Number')=>'width-15',
                                        __('Exchange <br> Rate')=>'width-8',
                                        __('Deposit <br> Date') => 'width-12',
                                        __('Drawal <br> Bank')=>'drawee-bank-width',
                                        __('Account <br> Type')=>'customer-name-width',
                                        __('Account <br> Number')=>'customer-name-width',
                                        __('Clearance <br> Days')=>'width-8'

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
                                        $rows = isset($model) ? $model->chequeUnderCollections :[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chequeUnderCollection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($chequeUnderCollection instanceof \App\Models\MoneyReceived) ){
                                        unset($chequeUnderCollection);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="<?php echo e(isset($chequeUnderCollection) ? $chequeUnderCollection->id : 0); ?>">



                                            <td>

                                                <div class="input-group css-fix-plus-direction">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'Partner','addNewModalModalTitle' => __('Customer Name'),'options' => $customersFormatted,'addNew' => false,'label' => ' ','class' => 'customer_name_class repeater-select','dataFilterType' => ''.e('create').'','all' => false,'name' => 'customer_id','selectedValue' => isset($chequeUnderCollection) ? $chequeUnderCollection->getCustomerId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Partner'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Customer Name')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($customersFormatted),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'class' => 'customer_name_class repeater-select','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'customer_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($chequeUnderCollection) ? $chequeUnderCollection->getCustomerId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                </div>

                                            </td>

                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($chequeUnderCollection) && $chequeUnderCollection->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>
                                            <td>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($chequeUnderCollection) ?  formatDateForDatePicker($chequeUnderCollection->getChequeDueDate()) : formatDateForDatePicker(now()),'label' => __('Due Date'),'id' => 'due_date','name' => 'due_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($chequeUnderCollection) ?  formatDateForDatePicker($chequeUnderCollection->getChequeDueDate()) : formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Due Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('due_date'),'name' => 'due_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">

                                                        <select data-live-search="true" data-actions-box="true" name="drawee_bank_id" class="form-control repeater-select select2-select	drawee-bank-class">
                                                            <?php $__currentLoopData = $selectedBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId=>$bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($bankId); ?>" <?php echo e(isset($chequeUnderCollection) && $chequeUnderCollection->cheque && $chequeUnderCollection->cheque->getDraweeBankId() == $bankId ? 'selected':''); ?>><?php echo e($bankName); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary js-drawee-bank-class"><?php echo e(__('Add New Bank')); ?></button>


                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="received_amount" type="text" class="form-control " value="<?php echo e(number_format(isset($chequeUnderCollection) ? $chequeUnderCollection->getReceivedAmount() : old('amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="cheque_number" type="text" class="form-control " value="<?php echo e((isset($chequeUnderCollection) ? $chequeUnderCollection->getChequeNumber() : old('cheuqe_number',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="exchange_rate" type="text" class="form-control " value="<?php echo e(number_format(isset($chequeUnderCollection) ? $chequeUnderCollection->getExchangeRate() : old('amount',0))); ?>">
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <div class="date-max-width">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($chequeUnderCollection) ?  formatDateForDatePicker($chequeUnderCollection->getChequeDepositDate()) :  formatDateForDatePicker(now()),'label' => __('Deposit Date'),'id' => 'deposit_date','name' => 'deposit_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($chequeUnderCollection) ?  formatDateForDatePicker($chequeUnderCollection->getChequeDepositDate()) :  formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Deposit Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('deposit_date'),'name' => 'deposit_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="drawl_bank_id" class="form-control js-drawl-bank">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($chequeUnderCollection) && $chequeUnderCollection && $chequeUnderCollection->getChequeAccountType() == $financialInstitutionBank->id ? 'selected':''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($chequeUnderCollection) && $chequeUnderCollection->getChequeAccountType() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="<?php echo e(isset($chequeUnderCollection) ? $chequeUnderCollection->getChequeAccountNumber(): 0); ?>" name="account_number" class="form-control js-account-number">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <input value="<?php echo e(isset($chequeUnderCollection) ? $chequeUnderCollection->getChequeClearanceDays() : 0); ?>" required name="clearance_days" step="any" min="0" class="form-control only-greater-than-zero-or-equal-allowed" placeholder="<?php echo e(__('Clearance Days')); ?>">
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







                    <div class="kt-portlet">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <?php echo e(__('Payable Cheques Opening Balance')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = MoneyPayment::PAYABLE_CHEQUE;
                                $repeaterId = 'm_repeater_9';

                                ?>
                                <input type="hidden" name="tableIds[]" value="<?php echo e($tableId); ?>">
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['repeaterWithSelect2' => true,'parentClass' => 'show-class-js modal-parent--js is-supplier-class','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js modal-parent--js is-supplier-class'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                                     <?php $__env->slot('ths'); ?> 
                                        <?php $__currentLoopData = [
                                        __('Supplier <br> Name')=>'customer-name-width',
                                        __('Currency')=>'width-8',
                                        __('Due <br> Date')=>'width-12',
                                        __('Amount')=>'width-15',
                                        __('Cheque <br> Number')=>'width-15',
                                        __('Exchange <br> Rate')=>'width-8',
                                        __('Pament <br> Bank')=>'drawee-bank-width',
                                        __('Account <br> Type')=>'customer-name-width',
                                        __('Account <br> Number')=>'customer-name-width',


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
                                        $rows = isset($model) ? $model->payableCheques :[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payableCheques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($payableCheques instanceof \App\Models\MoneyPayment) ){
                                        unset($payableCheques);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="<?php echo e(isset($payableCheques) ? $payableCheques->id : 0); ?>">



                                            <td>

                                                <div class="input-group css-fix-plus-direction">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['addNewModal' => true,'addNewModalModalType' => '','addNewModalModalName' => 'Partner','addNewModalModalTitle' => __('Supplier Name'),'options' => $suppliersFormatted,'addNew' => false,'label' => ' ','class' => 'customer_name_class repeater-select','dataFilterType' => ''.e('create').'','all' => false,'name' => 'supplier_id','selectedValue' => isset($payableCheques) ? $payableCheques->getSupplierId() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['add-new-modal' => true,'add-new-modal-modal-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(''),'add-new-modal-modal-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Partner'),'add-new-modal-modal-title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Supplier Name')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suppliersFormatted),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(' '),'class' => 'customer_name_class repeater-select','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'supplier_id','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($payableCheques) ? $payableCheques->getSupplierId() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                </div>

                                            </td>

                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($payableCheques) && $payableCheques->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>

                                            <td>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($payableCheques) ?  formatDateForDatePicker($payableCheques->getChequeDueDate()) : formatDateForDatePicker(now()),'label' => __('Due Date'),'id' => 'due_date','name' => 'due_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($payableCheques) ?  formatDateForDatePicker($payableCheques->getChequeDueDate()) : formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Due Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('due_date'),'name' => 'due_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="paid_amount" type="text" class="form-control " value="<?php echo e(number_format(isset($payableCheques) ? $payableCheques->getPaidAmount() : old('paid_amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="cheque_number" type="text" class="form-control " value="<?php echo e(number_format(isset($payableCheques) ? $payableCheques->getChequeNumber() : old('cheuqe_number',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="exchange_rate" type="text" class="form-control " value="<?php echo e(number_format(isset($payableCheques) ? $payableCheques->getExchangeRate() : old('amount',0))); ?>">
                                                    </div>
                                                </div>

                                            </td>

                                          

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="delivery_bank_id" class="form-control">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($payableCheques) && $payableCheques && $payableCheques->getChequeAccountType() == $financialInstitutionBank->id ? 'selected':''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>" <?php if(isset($payableCheques) && $payableCheques->getChequeAccountType() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="<?php echo e(isset($payableCheques) ? $payableCheques->getChequeAccountNumber(): 0); ?>" name="account_number" class="form-control js-account-number">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                        </select>
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

            <?php $__env->stopSection(); ?>
            <?php $__env->startSection('js'); ?>
            <script>
                function reinitalizeMonthYearInput(dateInput) {
                    var currentDate = $(dateInput).val();
                    var startDate = "<?php echo e(isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1); ?>";
                    startDate = startDate == '-1' ? '' : startDate;
                    var endDate = "<?php echo e(isset($studyEndDate) && $studyEndDate? $studyEndDate : -1); ?>";
                    endDate = endDate == '-1' ? '' : endDate;

                    $(dateInput).datepicker({
                            viewMode: "year"
                            , minViewMode: "year"
                            , todayHighlight: false
                            , clearBtn: true
                            , autoclose: true
                            , format: "mm/01/yyyy"
                        , })
                        .datepicker('setDate', new Date(currentDate))
                        .datepicker('setStartDate', new Date(startDate))
                        .datepicker('setEndDate', new Date(endDate))
                }

            </script>
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
            
            
            <script>

            </script>

            <script>
                $(document).find('.datepicker-input').datepicker({
                    dateFormat: 'mm-dd-yy'
                    , autoclose: true
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

         

            <script src="/custom/money-receive.js"></script>


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

                    const additionalColumn = $(this).attr('data-additional-column')
                    const additionalColumnValue = $(this).attr('data-additional-column-value')
					let route = "<?php echo e(route('add.new.partner.type',['company'=>$company->id , 'type'=>'replace_with_actual_type'])); ?>"
					let isSupplier = $(this).closest('.modal-parent--js.is-supplier-class').length ;  
					let isCustomer = $(this).closest('.modal-parent--js.is-customer-class').length ;
					let type = isSupplier > 0 ?'Supplier':'Customer';
					route = 	route.replace('replace_with_actual_type',modalName);
					
                    $.ajax({
                        url: route
                        , data: {
							value,
							type
                        }
                        , type: "POST"
                        , success: function(response) {
                            $(that).attr('disabled', false);
                            modal.find('input').val('');
                            $('.modal').modal('hide')
                            if (response.status) {

                                const allSelect = $(that).closest('.kt-portlet').find('select[data-modal-name="' + modalName + '"][data-modal-type="' + modalType + '"]');
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
            <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/opening-balance/form.blade.php ENDPATH**/ ?>