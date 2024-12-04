<?php $__env->startSection('css'); ?>
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

        <form method="post" action="<?php echo e(isset($model) ?  route('loans.update',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'mediumTermLoan'=>$model->id]) :route('loans.store',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])); ?>" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
            <input type="hidden" name="id" value="<?php echo e(isset($model) ? $model->id : 0); ?>">
            <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
            <input type="hidden" name="financial_institution_id" value="<?php echo e($financialInstitution->id); ?>">
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.sectionTitle','data' => ['title' => __((isset($model) ? 'Edit' : 'Add') . ' Loans')]]); ?>
<?php $component->withName('sectionTitle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__((isset($model) ? 'Edit' : 'Add') . ' Loans'))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title head-title text-primary">
                                            <?php echo e(__('Loan Information')); ?>

                                        </h3>
                                    </div>
                                </div>

                                <div class="kt-portlet__body">
                                    <div class="form-group">
                                        <div class="row">
										
										   <div class="col-md-4 ">
                                                <label><?php echo e(__('Name')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getName():''); ?>" name="name" class="form-control  " >
                                                </div>
                                            </div> 
											
											

                                            <div class="col-md-2">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('Start Date'),'required' => true,'model' => $model??null,'name' => 'start_date']]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Start Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('start_date')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                            </div>
											
											 <div class="col-md-2">
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.date','data' => ['label' => __('End Date'),'required' => true,'model' => $model??null,'name' => 'end_date']]); ?>
<?php $component->withName('form.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('End Date')),'required' => true,'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model??null),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('end_date')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                            </div>
											
											
											    
											
											   <div class="col-md-2	">
                                                <label><?php echo e(__('Currency')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="input-group">
                                                    <select name="currency" class="form-control" >
                                                        <option selected><?php echo e(__('Select')); ?></option>
                                                        <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currencyName); ?>" <?php if(isset($model) && $model->getCurrency() == $currencyName ): ?> selected <?php elseif($currencyName == 'EGP' ): ?> selected <?php endif; ?> > <?php echo e($currencyValue); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
											
											  <div class="col-md-2">
                                                <label><?php echo e(__('Limit')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getLimit():  0); ?>" name="limit" class="form-control only-greater-than-zero-allowed " >
                                                </div>
                                            </div> 
											
											  <div class="col-md-2 ">
                                                <label><?php echo e(__('Account Number')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getAccountNumber():0); ?>" name="account_number" class="form-control  " >
                                                </div>
                                            </div>   
											
											<div class="col-md-2 ">
                                                <label><?php echo e(__('Borrowing Rate %')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getBorrowingRate():0); ?>" name="borrowing_rate" id="borrowing-rate-id" class="form-control  recalculate-interest-rate " >
                                                </div>
                                            </div> 
											
											<div class="col-md-2 ">
                                                <label><?php echo e(__('Margin Rate %')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getMarginRate():0); ?>" name="margin_rate" id="margin-rate-id" class="form-control recalculate-interest-rate " >
                                                </div>
                                            </div> 
												
											
											
											<div class="col-md-2 ">
                                                <label><?php echo e(__('Interest Rate %')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input readonly name="interest_rate"  type="text" value="<?php echo e(isset($model) ? $model->getInterestRate():0); ?>" name="margin_rate" class="form-control  " >
                                                </div>
                                            </div> 
                                        

                                       <div class="col-md-2">
                                                <label><?php echo e(__('Duration (In Months)')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <input  type="text" value="<?php echo e(isset($model) ? $model->getDuration():0); ?>" name="duration" class="form-control " >
                                                </div>
                                            </div>
											
											
											  <div class="col-md-2">
                                                <label><?php echo e(__('Installment Payment Interval')); ?>

                                                    <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                </label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select required data-from-current-selected="<?php echo e(isset($model) ? $model->getPaymentInstallmentInterval(): 0); ?>" name="installment_payment_interval" class="form-control ">
                                                            <option value="" selected><?php echo e(__('Select')); ?></option>
															<?php $__currentLoopData = getDurationIntervalTypesForSelect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervalArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<option value="<?php echo e($intervalArr['value']); ?>" <?php if(isset($model) && $intervalArr['value'] == $model->getPaymentInstallmentInterval() ): ?> selected <?php endif; ?> > <?php echo e($intervalArr['title']); ?> </option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
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
		$(document).on('change','.type',function(){
			
		})
		</script>

        <script>
            $('input[name="borrowing_rate"],input[name="margin_rate"]').on('change', function() {
                let borrowingRate = $('input[name="borrowing_rate"]').val();
                borrowingRate = borrowingRate ? parseFloat(borrowingRate) : 0;
                let bankMaringRate = $('input[name="margin_rate"]').val();
                bankMaringRate = bankMaringRate ? parseFloat(bankMaringRate) : 0;
                const interestRate = borrowingRate + bankMaringRate;
                $('input[name="interest_rate"]').attr('readonly', true).val(interestRate);
            })
            $('input[name="borrowing_rate"]').trigger('change')

        </script>
      
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/loans/form.blade.php ENDPATH**/ ?>