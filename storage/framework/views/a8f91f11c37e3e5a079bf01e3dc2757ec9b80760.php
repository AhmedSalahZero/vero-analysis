<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    hr {}

    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
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

    .kt-portlet {}

    input.form-control[disabled],
    input.form-control:not(.is-date-css)[readonly]:not(#kt_datepicker_2) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Financial Institutions Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="<?php echo e(isset($model) ?  route('update.financial.institutions',['company'=>$company->id,'financialInstitution'=>$model->id]) :route('store.financial.institutions',['company'=>$company->id])); ?>" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
            <input id="js-money-received-id" type="hidden" name="id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
            
            <?php echo csrf_field(); ?>
            <?php if(isset($model)): ?>
            <?php echo method_field('put'); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __((isset($model) ? 'Edit' : 'Add') . ' Financial Institution')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__((isset($model) ? 'Edit' : 'Add') . ' Financial Institution'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Financial Institution Type')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Financial Institution Type'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label><?php echo e(__('Select Financial Institution Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select name="type" class="form-control select2-select" data-live-search="true" data-actions-box="true" id="type">
                                                    
                                                    <option <?php if(isset($model) && $model->isBank() ): ?> selected <?php endif; ?> value="bank"><?php echo e(__('Banks')); ?></option>
                                                    
                                                    
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 bank_class hidden">
                                        <label><?php echo e(__('Select Bank ')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select name="bank_id" data-live-search="true" data-actions-box="true" class="form-control select2-select ">
                                                    
                                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId=>$bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(isset($model) && $bankId==$model->bank_id ): ?> selected <?php endif; ?> value="<?php echo e($bankId); ?>"><?php echo e($bankName); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 financial-institution-name">
                                        <label><?php echo e(__('Financial Institution Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <input value="<?php echo e(isset($model) ? $model->getName() : null); ?>" type="text" name="name" class="form-control" placeholder="<?php echo e(__('Financial Institution Name')); ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <label><?php echo e(__('Branch Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <input value="<?php echo e(isset($model) ? $model->getBranchName() : null); ?>" type="text" name="branch_name" class="form-control" placeholder="<?php echo e(__('Branch Name')); ?>">
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet hidden banks_view">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Company Account Information')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Company Account Information'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label><?php echo e(__('Company Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                        <div class="kt-input-icon">
                                            <input type="text" value="<?php echo e(isset($model) ? $model->getCompanyAccountNumber() : old('company_account_number')); ?>" name="company_account_number" class="form-control" placeholder="<?php echo e(__('Company Account Number')); ?>">
                                        </div>
                                    </div>

                                



                                <div class="col-lg-3">
                                    <label><?php echo e(__('Balance Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <input type="text" name="balance_date" value="<?php echo e(isset($model) && $model->balance_date ? formatDateForDatePicker($model->getBalanceDate()) : null); ?>" class="form-control" readonly placeholder="<?php echo e(__('Select Balance Date')); ?>" id="kt_datepicker_2" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <?php if(!isset($model)): ?>
                            <div class="form-group row" style="flex:1;">
                                <div class="col-md-12 mt-3">



                                    <div class="" style="width:100%">

                                        <div id="m_repeater_0" class="cash-and-banks-repeater">
                                            <div class="form-group  m-form__group row  ">
                                                <div data-repeater-list="accounts" class="col-lg-12">
                                                    <?php if(isset($model) ): ?>
                                                    <?php $__currentLoopData = $model->accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo $__env->make('reports.financial-institution.repeater' , [
                                                    'account'=>$account,

                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <?php echo $__env->make('reports.financial-institution.repeater' , [

                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                                    <?php endif; ?>






                                                </div>
                                            </div>
                                            <div class="m-form__group form-group row">

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

                                            </div>
                                        </div>


                                    </div>



                                </div>

                            </div>
                            <?php endif; ?>


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
    $(document).on('change', '#type', function() {
        if ($(this).val() == 'bank') {
            $('.banks_view').removeClass('hidden');
            $('.bank_class').removeClass('hidden')
            $('.financial-institution-name').addClass('hidden')
        } else {
            $('.banks_view').addClass('hidden');
            $('.bank_class').addClass('hidden');
            $('.financial-institution-name').removeClass('hidden')


        }
    });
    $('#type').trigger('change')

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/reports/financial-institution/form.blade.php ENDPATH**/ ?>