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
<?php echo e(__('Letter Of Credit Opening Balance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <form method="post" action="<?php echo e(isset($model) ? route('lc-opening-balance.update',['company'=>$company->id,'lc_opening_balance'=>$model->id]) : route('lc-opening-balance.store',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Letter Of Credit Opening Balance')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Letter Of Credit Opening Balance'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                    <?php echo e(__('LC Opening Balance Date')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-md-4 ">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['type' => 'text','classes' => 'datepicker-input','defaultValue' => formatDateForDatePicker(isset($model)  ? $model->getDate() : now()),'model' => $model??null,'label' => __('LC Opening Balance Date'),'placeholder' => __(''),'name' => 'date','required' => true]]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('text'),'classes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('datepicker-input'),'default-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatDateForDatePicker(isset($model)  ? $model->getDate() : now())),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('LC Opening Balance Date')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('')),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('date'),'required' => true]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                    <?php echo e(__('100% Cash Cover Begining Balance ')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = 'LcHundredPercentageCashCoverOpeningBalance'; // name of relationship
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
                                            __('Currency')=>'width-8',
                                            __('Bank <br> Name')=>'drawee-bank-width',
                                            __('Account <br> Type')=>'customer-name-width',
                                            __('Account <br> Number')=>'customer-name-width',
                                            __('LC Amount')=>'width-15',
                                            __('LC <br> Type')=>'width-15',
                                            __('LC <br> Expiry Date')=>'width-12'
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
                                        $rows = isset($model) ? $model->LcHundredPercentageCashCoverOpeningBalance :[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $LcHundredPercentageCashCoverOpeningBalance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($LcHundredPercentageCashCoverOpeningBalance instanceof \App\Models\LcHundredPercentageCashCoverOpeningBalance) ){
                                        unset($LcHundredPercentageCashCoverOpeningBalance);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="<?php echo e(isset($LcHundredPercentageCashCoverOpeningBalance) ? $LcHundredPercentageCashCoverOpeningBalance->id : 0); ?>">
                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($LcHundredPercentageCashCoverOpeningBalance) && $LcHundredPercentageCashCoverOpeningBalance->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control js-drawl-bank">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" ><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($accountType->id); ?>"><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="<?php echo e(isset($LcHundredPercentageCashCoverOpeningBalance) ? $LcHundredPercentageCashCoverOpeningBalance->getCurrentAccountNumber(): 0); ?>" name="current_account_number" class="form-control js-account-number">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>



                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="amount" type="text" class="form-control " value="<?php echo e(number_format(isset($LcHundredPercentageCashCoverOpeningBalance) ? $LcHundredPercentageCashCoverOpeningBalance->getAmount() : old('amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="lc_type" class="form-control">
                                                            
                                                            <?php $__currentLoopData = $lcTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lcTypeId => $lcTypeTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($lcTypeId); ?>" <?php if(isset($LcHundredPercentageCashCoverOpeningBalance) && $LcHundredPercentageCashCoverOpeningBalance->getLcType() == $lcTypeId): ?> selected <?php endif; ?>><?php echo e($lcTypeTitle); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="date-max-width">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($LcHundredPercentageCashCoverOpeningBalance) ?  formatDateForDatePicker($LcHundredPercentageCashCoverOpeningBalance->getExpiryDate()) :  formatDateForDatePicker(now()),'label' => __('Expiry Date'),'id' => 'lc_expiry_date','name' => 'lc_expiry_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($LcHundredPercentageCashCoverOpeningBalance) ?  formatDateForDatePicker($LcHundredPercentageCashCoverOpeningBalance->getExpiryDate()) :  formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Expiry Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_expiry_date'),'name' => 'lc_expiry_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
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
                                    <?php echo e(__('Against CD Or TD')); ?>

                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                <?php
                                $index = 0 ;
                                ?>



                                
                                <?php
                                $tableId = 'LcAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances'; // name of relationship
                                $repeaterId = 'm_repeater_9';

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
                                            __('Currency')=>'width-8',
                                            __('Bank <br> Name')=>'drawee-bank-width',
                                            __('Account <br> Type')=>'customer-name-width',
                                            __('Account <br> Number')=>'customer-name-width',
                                            __('LC Amount')=>'width-15',
                                            __('LC <br> Type')=>'width-15',
                                            __('LC <br> End Date')=>'width-12'
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
                                        $rows = isset($model) ? $model->{$tableId}:[-1] ;
                                        ?>
                                        <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lcAgainstTdOrCdOpeningBalance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if( !($lcAgainstTdOrCdOpeningBalance instanceof \App\Models\LcAgainstTdOrCdOpeningBalance) ){
                                        unset($lcAgainstTdOrCdOpeningBalance);
                                        }
                                        ?>
                                        <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="<?php echo e(isset($lcAgainstTdOrCdOpeningBalance) ? $lcAgainstTdOrCdOpeningBalance->id : 0); ?>">
                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($lcAgainstTdOrCdOpeningBalance) && $lcAgainstTdOrCdOpeningBalance->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control js-drawl-bank">
                                                            <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($financialInstitutionBank->id); ?>" ><?php echo e($financialInstitutionBank->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            <?php $__currentLoopData = $cdOrTdAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php if(isset($lcAgainstTdOrCdOpeningBalance) && $lcAgainstTdOrCdOpeningBalance->getAccountType() == $accountType->id): ?> selected <?php endif; ?> value="<?php echo e($accountType->id); ?>"><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="<?php echo e(isset($lcAgainstTdOrCdOpeningBalance) ? $lcAgainstTdOrCdOpeningBalance->getAccountNumber(): 0); ?>" name="account_number" class="form-control js-account-number">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>



                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="amount" type="text" class="form-control " value="<?php echo e(number_format(isset($lcAgainstTdOrCdOpeningBalance) ? $lcAgainstTdOrCdOpeningBalance->getAmount() : old('amount',0))); ?>">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="lc_type" class="form-control">
                                                            
                                                            <?php $__currentLoopData = $lcTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lcTypeId => $lcTypeTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($lcTypeId); ?>" <?php if(isset($lcAgainstTdOrCdOpeningBalance) && $lcAgainstTdOrCdOpeningBalance->getLcType() == $lcTypeId): ?> selected <?php endif; ?>><?php echo e($lcTypeTitle); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="date-max-width">
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.calendar','data' => ['onlyMonth' => false,'showLabel' => false,'value' => isset($lcAgainstTdOrCdOpeningBalance) ?  formatDateForDatePicker($lcAgainstTdOrCdOpeningBalance->getEndDate()) :  formatDateForDatePicker(now()),'label' => __('End Date'),'id' => 'lc_expiry_date','name' => 'lc_end_date']]); ?>
<?php $component->withName('calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['onlyMonth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'showLabel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($lcAgainstTdOrCdOpeningBalance) ?  formatDateForDatePicker($lcAgainstTdOrCdOpeningBalance->getEndDate()) :  formatDateForDatePicker(now())),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('End Date')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('lc_expiry_date'),'name' => 'lc_end_date']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
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

            <script>
                $('input[name="borrowing_rate"],input[name="bank_margin_rate"]').on('change', function() {
                    let borrowingRate = $('input[name="borrowing_rate"]').val();
                    borrowingRate = borrowingRate ? parseFloat(borrowingRate) : 0;
                    let bankMaringRate = $('input[name="bank_margin_rate"]').val();
                    bankMaringRate = bankMaringRate ? parseFloat(bankMaringRate) : 0;
                    const interestRate = borrowingRate + bankMaringRate;
                    $('input[name="interest_rate"]').attr('readonly', true).val(interestRate);
                })
                $('input[name="borrowing_rate"]').trigger('change')

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
            <script>


                $('.js-drawl-bank').trigger('change')
            </script>
            <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/lc-opening-balance/form.blade.php ENDPATH**/ ?>