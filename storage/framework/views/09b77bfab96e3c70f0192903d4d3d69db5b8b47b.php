<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__($view_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action=<?php echo e($name_of_selector_label == 'Sales Discount' ? route('branches.salesDiscount.analysis.result', $company) : route('branches.analysis.result', $company)); ?> enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet">
                <?php 
                   
                        $branches = getTypeFor('branch',$company->id,false);
                        
                        if ($name_of_selector_label == 'Products Items') {

                            $column =  3 ;
                            $data_type_selector = '';
                        }elseif ($name_of_selector_label == 'Sub Categories') {
                            $column =  4 ;
                            $data_type_selector = '';
                        }else {
                            $column =  6 ;
                            $data_type_selector = 'disabled';
                        }
                    ?>
                <input type="hidden" name="type" value="<?php echo e($type); ?>">
                <input type="hidden" name="view_name" value="<?php echo e($view_name); ?>">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?php echo e(__('Data Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="data_type" id="data_type" <?php echo e($data_type_selector); ?> class="form-control">

                                        <option selected value="value"><?php echo e(__('Value')); ?></option>
                                        <option value="quantity"><?php echo e(__('Quantity')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php echo $__env->make('comparing_type_selector', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                    </div>

                   <div class="form-group row">
                        <?php if(isset(get_defined_vars()['__data']['type']) && get_defined_vars()['__data']['type'] !='averagePrices'): ?>
                        <div class="col-md-4  first-interval">
                            <label></label>
                            <div class="flex-center "><label class="first-interval"><?php echo e(__('First Interval')); ?></label></div>

                        </div>
                        <?php endif; ?>

                        <div class="col-md-4">
                            <label><?php echo e(__('Start Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" required value="<?php echo e(getEndYearBasedOnDataUploaded($company)['jan']); ?>" name="start_date" class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label><?php echo e(__('End Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" required name="end_date" value="<?php echo e(getEndYearBasedOnDataUploaded($company)['dec']); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
		    <input type="hidden" name="main_type" value="branch">
                        <input type="hidden" id="append-to" value="branches">
						
                        <div class="col-md-4">
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

                    </div>

                    <div class="form-group row">
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select Branches')); ?>

                                <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </label>
									
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="branches[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" id="branches" multiple>
                                        
                                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch); ?>"> <?php echo e(__($branch)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if($name_of_selector_label == 'Sub Categories' || $name_of_selector_label == 'Products Items'): ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select Categories ')); ?><span class="multi_selection">
                                    
                                </span>
                                <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="categories">
                                    <select data-live-search="true" data-actions-box="true" name="categories[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>

                        <?php if( $name_of_selector_label == 'Products Items'): ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select Products ')); ?><span class="multi_selection">
                                    
                                </span>

                                <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="products">
                                    <select data-live-search="true" data-actions-box="true" name="products[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php if( $name_of_selector_label == 'Sales Discount'): ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label
                                    // .' ( Multi Selection )'
                                    )); ?>


                            </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="sales_discounts_fields[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" id="sales_discounts_fields" multiple>
                                        <option value="quantity_discount"><?php echo e(__('Quantity Discount')); ?></option>
                                        <option value="cash_discount"><?php echo e(__('Cash Discount')); ?></option>
                                        <option value="special_discount"><?php echo e(__('Special Discount')); ?></option>
                                        <option value="other_discounts"><?php echo e(__('Other Discounts')); ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php else: ?>
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?><span class="multi_selection">
                                    
                                </span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>

                                    </select>
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



<!--end::Page Scripts -->
<script>
    $('#data_type').change(function(e) {
        // if($('#data_type').val()  == 'value'){
        var data_type = 'multiple';
        // $('.multi_selection').html("<?php echo e(__('( Multi Selection )')); ?>");

        // }
        // else{
        //     var data_type = '';
        //     $('.multi_selection').html("");
        // }
        $('#branches option:selected').prop('selected', false);

        $('.filter-option-inner-inner').html('Nothing selected');
        $('#sales_channels').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + ' ></select>';
        $('#sales_channels').append(row)
        $('#categories').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" ' + data_type + '  required ></select>';
        $('#categories').append(row);
        $('#products').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  ></select>';
        $('#products').append(row);
        reinitializeSelect2();

    });
    $(document).on('change', '#branches', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {
            if (tryParseJSONObject($(this).val()[0])) {
                branches = JSON.parse($(this).val()[0]);
            } else {
                branches = $(this).val();
            }
            type_of_data = "<?php echo e($type); ?>";
            if ("<?php echo e($name_of_selector_label); ?>" == 'Sub Categories' || "<?php echo e($name_of_selector_label); ?>" == 'Products Items') {
                getCategories(branches, 'category');
            } else {
                getSalesChannales(branches, type_of_data);
            }

        }, getNumberOfMillSeconds());


    });
    $(document).on('change', '[name="categories[]"]', function() {


        clearTimeout(wto);
        wto = setTimeout(() => {
            if (tryParseJSONObject($('#branches').val()[0])) {
                branches = JSON.parse($('#branches').val()[0]);
            } else {
                branches = $('#branches').val();
            }
            type_of_data = "<?php echo e($type); ?>";

            categories = $(this).val();

            getProducts(branches, categories, 'sub_category', type_of_data)

        }, getNumberOfMillSeconds());



    });
    $(document).on('change', '[name="products[]"]', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {

            if (tryParseJSONObject($('#branches').val()[0])) {
                branches = JSON.parse($('#branches').val()[0]);
            } else {
                branches = $('#branches').val();
            }
            categories = $('[name="categories[]"]').val();
            products = $(this).val();

            type_of_data = "<?php echo e($type); ?>";
            getProductItems(branches, categories, products, type_of_data)


        }, getNumberOfMillSeconds());



    });

    function tryParseJSONObject(jsonString) {
        try {
            var o = JSON.parse(jsonString);

        } catch (e) {
            return false;
        }

        return true;
    };

    // Sales Channales
    function getSalesChannales(branches, type_of_data) {
        if (branches.length) {
            $.ajax({
                type: 'POST'
                , data: {
                    'main_data': branches
                    , 'main_field': 'branch'
                    , 'field': type_of_data
                    , 'start_date': $('input[name="start_date"]').val()
                    , 'end_date': $('input[name="end_date"]').val()
                }
                , url: "<?php echo e(route('get.zones.data',$company)); ?>"
                , dataType: 'json'
                , accepts: 'application/json'
             
            }).done(function(data) {

                // if($('#data_type').val()  == 'value'){
                var data_type = 'multiple';
               
                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + '  >\n';
         

                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';

                $('#sales_channels').html('');
                $('#sales_channels').append(row);
                reinitializeSelect2();
            });
        }

    }

    // Categories
    function getCategories(branches, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': branches
                , 'main_field': 'branch'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }
            // else{
            // var data_type = '';
            // }
            row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" ' + data_type + '  required >\n';
            if ($('#data_type').val() !== 'value') {
                row += '<option value="">Select</option>\n';
            }
            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';

            $('#categories').html('');
            $('#categories').append(row);
            reinitializeSelect2();
        });
    }
    // Sub Categories
    function getProducts(branches, categories, type_of_data, type) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': branches
                , 'main_field': 'branch'
                , 'second_main_data': categories
                , 'sub_main_field': 'category'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }
            // else{
            //     var data_type = '';
            // }

            if (type == 'sub_category') {

                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required >\n';
                if ($('#data_type').val() !== 'value') {
                    row += '<option value="">Select</option>\n';
                }


                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';
                $('#sales_channels').html('');
                $('#sales_channels').append(row);
                reinitializeSelect2();
            } else {
                row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
                if ($('#data_type').val() !== 'value') {
                    row += '<option value="">Select</option>\n';
                }

                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';

                $('#products').html('');
                $('#products').append(row);
                reinitializeSelect2();
            }
        });
    }
    // Product Or Services
    function getProductItems(branches, categories, products, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': branches
                , 'main_field': 'branch'
                , 'second_main_data': categories
                , 'sub_main_field': 'category'
                , 'third_main_data': products
                , 'third_main_field': 'sub_category'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            , }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }
            // else{
            //     var data_type = '';
            // }
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
            // if($('#data_type').val()  !== 'value'){
            //     row += '<option value="">Select</option>\n' ;
            // }
            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';

            $('#sales_channels').html('');
            $('#sales_channels').append(row);
            reinitializeSelect2();
        });
    }

</script>
<script>
    $(function() {
        reinitializeSelect2();
        $('#branches').trigger('change');
    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/branches_analysis_form.blade.php ENDPATH**/ ?>