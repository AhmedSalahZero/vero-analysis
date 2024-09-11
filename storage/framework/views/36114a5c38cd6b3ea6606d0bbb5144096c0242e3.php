<?php $__env->startSection('css'); ?>
<?php
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived ;
use App\Models\SupplierInvoice;
$fullClassName = '\App\Models\\'.$modelType ;
?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
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
        width: 12.5% !important;
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
<?php echo e(__('Settlement Using Unapplied Amount Form')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form method="post" action="<?php echo e(isset($model) ?  route('update.settlement.by.unapplied.amounts',['company'=>$company->id,'modelType'=>$modelType,'unappliedAmountId'=>$model->id,'settlementId'=>$settlement->id]) :route('store.settlement.by.unapplied.amounts',['company'=>$company->id,'modelType'=>$modelType])); ?>" class="kt-form kt-form--label-right">
	
            <input type="hidden" name="invoiceId" value="<?php echo e($invoiceId); ?>">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="<?php echo e(isset($model) ? 1 : 0); ?>">
            
            <input type="hidden" id="ajax-invoice-item" data-single-model="<?php echo e(1); ?>" value="<?php echo e($invoiceNumber); ?>">
            <?php echo csrf_field(); ?>
            <?php if(isset($model)): ?>
            <?php echo method_field('put'); ?>
            <?php endif; ?>
            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Settlement Using Unapplied Amount')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">


                        <div class="col-md-5">
                            <label><?php echo e($customerNameText); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select id="<?php echo e($customerNameColumnName); ?>" name="<?php echo e($customerIdColumnName); ?>" class="form-control ajax-get-invoice-numbers">
                                            <?php $__currentLoopData = $customerInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partnerId => $customerName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option selected value="<?php echo e($partnerId); ?>"><?php echo e($customerName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <label><?php echo e(__('Select Currency')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select readonly name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        <?php $__currentLoopData = isset($currencies) ? $currencies : getBanksCurrencies (); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyId=>$currentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                        $selected = isset($model) ? $model->getCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                        $selected = $selected ? 'selected':'';
                                        ?>

                                        <option <?php echo e($selected); ?> value="<?php echo e($currencyId); ?>"><?php echo e(touppercase($currentName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?php echo e(__('Settlement Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input  type="text" name="settlement_date" value="<?php echo e($settlementDate); ?>" class="form-control is-date-css"  placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Settlement Information')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <div class="js-append-to">
                        <div class="col-md-12 js-duplicate-node">

                        </div>
                    </div>
                    <div class="js-template 
					
					
					
					 ">
                        <div class="col-md-12 js-duplicate-node">
							<?php echo $fullClassName::getSettlementsTemplate($invoiceNumber , $dueDateFormatted  , $invoiceDueDateFormatted,$invoiceCurrency,$netInvoiceAmountFormatted,$collectedAmountFormatted,$netBalanceFormatted,$settlementAmount,$withholdAmount); ?>

							
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>

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
    $('#type').change(function() {
        selected = $(this).val();
        $('.js-section-parent').addClass('hidden');
        if (selected) {
            $('#' + selected).removeClass('hidden');
        }
    });
    $('#type').trigger('change')

</script>


<script>
    
    $(function() {
        $('#type').trigger('change');
    })

</script>



<script>
    $(function() {

        $('select.ajax-get-invoice-numbers').trigger('change')
    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/unapplied-amounts/form.blade.php ENDPATH**/ ?>