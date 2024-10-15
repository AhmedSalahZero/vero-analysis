
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Safe Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('result.partners.statement',['company'=>$company->id ])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-3 mb-4">
                            <label><?php echo e(__('Start Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="start_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label><?php echo e(__('End Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="end_date" value="<?php echo e(now()->addYear()); ?>">
                                </div>
                            </div>
                        </div>
   <div class="col-md-3 mb-4">
                            <label><?php echo e(__('Currency')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select id="invoice-currency-id" data-live-search="true" data-actions-box="true" name="currency" required class="form-control  kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name">
                                        <?php $__currentLoopData = getCurrency(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency=>$currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency); ?>"><?php echo e(touppercase($currencyName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

					<div class="col-md-3 mb-4">
                            <label><?php echo e(__('Partner Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="partner_type" id="partner_type" required class="form-control  kt-bootstrap-select select2-select kt_bootstrap_select">
                                        <?php $__currentLoopData = $partnerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
						
						
							<div class="col-md-3 mb-4">
                            <label><?php echo e(__('Partners')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="partner_id" id="customer_name" required class="form-control  kt-bootstrap-select select2-select kt_bootstrap_select">
                                        
                                    </select>
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







                    </div>

                </div>
            </div>





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
<script src="/custom/money-receive.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/partners_statement_form.blade.php ENDPATH**/ ?>