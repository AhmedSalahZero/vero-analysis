<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet"
        type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('categories.create', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Forecast')); ?>

                    </h3>
                </div>
            </div>

        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile">

                    <div class="kt-portlet__body">
                        <?php for($number = 1; $number <= $sales_forecast->number_of_products; $number++): ?>
                            <div class="col-md-12" >
                                <label> <b> <?php echo e(__('Category Name') . ' ' .$number); ?> </b><span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="text" step="any" class="form-control" name="category_name[]" value="<?php echo e(@$categories[$number-1]['name']); ?>" placeholder="<?php echo e(__("Insert Name")); ?>">
                                    </div>
                                </div>
                            </div>
                            <br>
                            
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet">
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-6">
                            
                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <input type="submit" class="btn active-style" name="submit" value="<?php echo e(__('Next')); ?>" >
                            <input type="submit" class="btn btn-danger" name="submit" value="<?php echo e(__('Skip')); ?>" >
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"
        type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/categories.blade.php ENDPATH**/ ?>