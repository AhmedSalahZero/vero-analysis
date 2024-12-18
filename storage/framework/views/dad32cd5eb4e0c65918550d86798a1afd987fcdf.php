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
        <form class="kt-form kt-form--label-right" method="POST" action=<?php if($name_of_selector_label=='Sales Discount' ): ?> <?php echo e(route('categories.salesDiscount.analysis.result', $company)); ?> <?php elseif($type=='averagePrices' ): ?> <?php echo e(route('averagePrices.result', $company)); ?> <?php else: ?> <?php echo e(route('categories.analysis.result', $company)); ?> <?php endif; ?> enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">
                <?php if($type == 'averagePrices'): ?>
                <input type="hidden" name="type_of_report" value="categories_products_avg">
                <?php
                            $type = 'product_or_service'  ;
                        ?>
                <?php endif; ?>


                <?php 
             
                    
                    if(isCustomerExceptionalCase($type , $name_of_selector_label) 
                    || isCustomerExceptionalForProducts($type , $name_of_selector_label)
                    || isCustomerExceptionalForProductsItems($type , $name_of_selector_label))
                    // in this case we will get customers instead of categories
                    $categoriesData = getTypeFor('customer_name',$company->id , false);
                    else
                    {
                    $categoriesData = getTypeFor('category',$company->id , false);

                    }

                        if ($name_of_selector_label == 'Products Items') {
                            $column =  3 ;
                            $data_type_selector = '';
                        }elseif ($name_of_selector_label == 'Products / Services') {
                            $column =  4 ;
                            $data_type_selector = '';
                        }else {
                            $column =  6 ;
                            $data_type_selector = 'disabled';
                        }
                        if($name_of_selector_label == 'Products Items' && $type == 'product_item' && $view_name =='Categories Against Products Items Trend Analysis' )
                        {
                            $column =  4 ;
                        }

                        if($name_of_selector_label == 'Products / Services')
                        {
                            $column = 6 ; 
                        }


                    ?>

                <input type="hidden" name="type" value="<?php echo e($type); ?>">
                <input type="hidden" name="view_name" value="<?php echo e($view_name); ?>">
                <div class="kt-portlet__body">
                    <?php if(! (in_array('CategoriesProductsAveragePricesView',Request()->segments()))): ?>
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
                    <?php else: ?>
                    <input type="hidden" name="data_type" id="data_type" <?php echo e($data_type_selector); ?> value="value">
                    <?php endif; ?>


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
                                    <input type="date" name="start_date" value="<?php echo e(getEndYearBasedOnDataUploaded($company)['jan']); ?>" required class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label><?php echo e(__('End Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="end_date" required value="<?php echo e(getEndYearBasedOnDataUploaded($company)['dec']); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
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

                            <?php if(isCustomerExceptionalCase($type , $name_of_selector_label)
                            ||
                            isCustomerExceptionalForProducts($type , $name_of_selector_label )
                            ||
                            isCustomerExceptionalForProductsItems($type , $name_of_selector_label )

                            ): ?>
                            <label><?php echo e(__('Select Customers')); ?> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <?php else: ?>

                            <label><?php echo e(__('Select Categories')); ?> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <?php endif; ?>


                            <?php if((isCustomerExceptionalCase($type , $name_of_selector_label)
                            ||
                            isCustomerExceptionalForProducts($type , $name_of_selector_label )
                            ||
                            isCustomerExceptionalForProductsItems($type , $name_of_selector_label )

                            )): ?>

                            <input type="hidden" name="main_type" value="customer_name">
                            <input type="hidden" id="append-to" value="categoriesData">

                            <?php else: ?>

                            <input type="hidden" name="main_type" value="category">
                            <input type="hidden" id="append-to" value="categoriesData">
                            <?php endif; ?>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="categoriesData[]" required data-live-search="true" data-actions-box="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" id="categoriesData" multiple>
                                        
                                        <?php $__currentLoopData = $categoriesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category); ?>"> <?php echo e(__($category)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <?php if( $name_of_selector_label == 'Products Items'): ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select Products ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="products">
                                    <select data-live-search="true" data-actions-box="true" name="products[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>


                        <?php if( $name_of_selector_label == 'Sales Discount'): ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label)); ?> </label>
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

                        <?php if($name_of_selector_label == 'Customers Against Categories' ): ?>
                        <?php
                        $name_of_selector_label = "Categories";
                        ?>
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php elseif($name_of_selector_label == 'Customers Against Products'): ?>

                        <?php
                        $name_of_selector_label = "Products";
                        ?>
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <?php elseif($name_of_selector_label == 'Customers Against Products Items'): ?>

                        <?php
                        $name_of_selector_label = "Product Items";
                        ?>
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <?php else: ?>

                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
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
        $('#categoriesData option:selected').prop('selected', false);

        $('.filter-option-inner-inner').html('Nothing selected');
        $('#sales_channels').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + ' ></select>';
        $('#sales_channels').append(row)
        $('#categories').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" ' + data_type + '  required ></select>';
        $('#categories').append(row);
        $('#products').html('');
        row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  ></select>';
        $('#products').append(row);
        reinitializeSelect2();

    });
    $(document).on('change', '#categoriesData', function() {


        clearTimeout(wto);
        wto = setTimeout(() => {

            //    alert("<?php echo e($name_of_selector_label); ?>")
            if (tryParseJSONObject($(this).val()[0])) {
                categoriesData = JSON.parse($(this).val()[0]);
            } else {
                categoriesData = $(this).val();
            }
            type_of_data = "<?php echo e($type); ?>";
            if ("<?php echo e($name_of_selector_label); ?>" == 'Products / Services' || "<?php echo e($name_of_selector_label); ?>" == 'Products Items') {
                getProducts(categoriesData, 'product_or_service', type_of_data);
            } else {


                if ("<?php echo e(isCustomerExceptionalCase($type , $name_of_selector_label)); ?>") {
                    // alert('if')
                    getCategories(categoriesData, 'category');
                } else if ("<?php echo e(isCustomerExceptionalForProducts($type , $name_of_selector_label)); ?>") {
                    // alert('else if')
                    getProductsForCustomers(categoriesData, 'product_or_service', 'product_or_service');
                } else if ("<?php echo e(isCustomerExceptionalForProductsItems($type , $name_of_selector_label)); ?>") {
                    // alert('else if')
                    getProductItemsForCustomers(categoriesData, 'product_item');
                } else {
                    // alert('else')
                    getSalesChannales(categoriesData, type_of_data);

                }
                // wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
            }

        }, getNumberOfMillSeconds());


    });
    $(document).on('change', '[name="categories[]"]', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {


            if (tryParseJSONObject($('#categoriesData').val()[0])) {
                categoriesData = JSON.parse($('#categoriesData').val()[0]);
            } else {
                categoriesData = $('#categoriesData').val();
            }
            type_of_data = "<?php echo e($type); ?>";

            categories = $(this).val();

            getProducts(categoriesData, categories, 'product_or_service', type_of_data)

        }, getNumberOfMillSeconds());


    });
    $(document).on('change', '[name="products[]"]', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {


            if (tryParseJSONObject($('#categoriesData').val()[0])) {
                categoriesData = JSON.parse($('#categoriesData').val()[0]);
            } else {
                categoriesData = $('#categoriesData').val();
            }
            categories = $('[name="categories[]"]').val();
            products = $(this).val();

            type_of_data = "<?php echo e($type); ?>";
            getProductItems(categoriesData, products, type_of_data)


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
    function getSalesChannales(categoriesData, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categoriesData
                , 'main_field': 'category'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {

            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" required multiple>\n';
            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';

            $('#sales_channels').html('');
            $('#sales_channels').append(row);
            reinitializeSelect2();
        });
    }

    // Categories
    function getCategories(categoriesData, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categoriesData
                , 'main_field': 'customer_name'
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
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" ' + data_type + '  required >\n';
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
    // Sub Categories
    function getProducts(categories, type_of_data, type) {

        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categories
                , 'main_field': 'category'
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

            if (type == 'product_or_service') {

                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required >\n';
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
            } else {
                row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }

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



    function getProductsForCustomers(categories, type_of_data, type) {
        // alert('q');
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categories
                , 'main_field': 'customer_name'
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
            // alert(type);
            if (type == 'product_or_service') {

                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required >\n';
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
            } else {
                row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }

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
    function getProductItems(categoriesData, products, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categoriesData
                , 'main_field': 'category'
                , 'third_main_data': products
                , 'third_main_field': 'product_or_service'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            , }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select select2 kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required multiple >\n';
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


    function getProductItemsForCustomers(categoriesData, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': categoriesData
                , 'main_field': 'customer_name'
                , 'field': type_of_data
                , 'start_date': $('input[name="start_date"]').val()
                , 'end_date': $('input[name="end_date"]').val()
            , }
            , url: "<?php echo e(route('get.zones.data',$company)); ?>"
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select select2 kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required multiple >\n';
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
        $('#categoriesId').trigger('change');
    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/categories_analysis_form.blade.php ENDPATH**/ ?>