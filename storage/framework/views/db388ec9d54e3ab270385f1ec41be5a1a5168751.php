
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

    input.form-control[disabled]:not(.ignore-global-style),
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

        <form method="post" action="<?php echo e(route('financial.institution.store.account',['company'=>$company->id ,'financialInstitution'=>$financialInstitution->id ])); ?>" class="kt-form kt-form--label-right">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Add New Account For') . ' ' . $financialInstitution->getName() ]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Add New Account For') . ' ' . $financialInstitution->getName() )]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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

                        <div class="kt-portlet ">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __('Account Information')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Account Information'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">

                                <div class="form-group row" style="flex:1;">
                                    <div class="col-md-12 mt-3">



                                        <div class="" style="width:100%">

                                            <div id="m_repeater_0" class="cash-and-banks-repeater">
                                                <div class="form-group  m-form__group row  ">
                                                    <div data-repeater-list="accounts" class="col-lg-12">
                                                        <?php echo $__env->make('reports.financial-institution.repeater' , [
															'addStartDate'=>true 
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/financial-institution/add-account.blade.php ENDPATH**/ ?>