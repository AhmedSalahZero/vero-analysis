
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__('Categories Sales Analysis')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action=<?php echo e(route('categories.sales.analysis.result',$company)); ?>   enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet">
                <?php $categories =  App\Models\SalesGathering::company()->whereNotNull('category')->where('category','!=','')->groupBy('category')->selectRaw('category')->get()->pluck('category')->toArray();

                ?>

                <div class="kt-portlet__body">
                    <div class="form-group row">
					
					
                        <div class="col-md-2">
                            <label><?php echo e(__('Start Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="start_date" value="<?php echo e(getEndYearBasedOnDataUploaded($company)['jan']); ?>"  required class="form-control"  placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label><?php echo e(__('End Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="end_date" required value="<?php echo e(getEndYearBasedOnDataUploaded($company)['dec']); ?>"  max="<?php echo e(date('Y-m-d')); ?>"  class="form-control"  placeholder="Select date" />
                                </div>
                            </div>
                        </div>
						
						
                        <div class="col-md-4">
                            <label><?php echo e(__('Select Categories')); ?> 
                            
                            <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                            </label>
                            <div class="kt-input-icon">
                                <div id="append-main-select" class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" data-max-options="<?php echo e(maxOptionsForOneSelector()); ?>" name="categories[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  multiple>
                                        
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row); ?>"> <?php echo e(__($row)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
						
                        <div class="col-md-2">
                            <label><?php echo e(__('Select Interval')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="interval" required class="form-control">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        
                                        <option value="monthly"><?php echo e(__('Monthly')); ?></option>
                                        <option value="quarterly"><?php echo e(__('Quarterly')); ?></option>
                                        <option value="semi-annually"><?php echo e(__('Semi-Annually')); ?></option>
                                        <option value="annually"><?php echo e(__('Annually')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label><?php echo e(__('Data Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="interval" disabled class="form-control">

                                        <option selected value="value"><?php echo e(__('Value')); ?></option>
                                        <option value="quantity"><?php echo e(__('Quantity')); ?></option>
                                    </select>
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
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
    

<script>
    $(document).on('change', '[name="start_date"],[name="end_date"]', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {
            var branches = ['all'];
            var type_of_data = "category";
            var getColumnName = 'category';
            var appendToSelector = '#append-main-select';
            getAnotherSelectValues(branches, type_of_data, getColumnName, appendToSelector);
        }, getNumberOfMillSeconds())



    })

    $(function() {
        $('[name="start_date"]').trigger('change');
    })

    function getAnotherSelectValues(branches, type_of_data, getColumnName, appendToSelector) {
        if (branches.length) {
            $.ajax({
                type: 'POST'
                , data: {
                    'main_data': branches
                    , 'main_field': getColumnName
                    , 'field': type_of_data
                    , 'start_date': $('input[name="start_date"]').val()
                    , 'end_date': $('input[name="end_date"]').val()
                }
                , url: "<?php echo e(route('get.zones.data',$company)); ?>"
                , dataType: 'json'
                , accepts: 'application/json'

            }).done(function(data) {
                var data_type = 'multiple';

                row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + '  >\n';


                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';

                $(appendToSelector).html('');
                $(appendToSelector).append(row);
                reinitializeSelect2();
            });
        }

    }

</script>
    <!--end::Page Scripts -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/categories_sales_form.blade.php ENDPATH**/ ?>