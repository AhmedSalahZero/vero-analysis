<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    div.dropdown-menu.show{
        max-width:400px !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__($view_name)); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action=<?php echo e($name_of_selector_label == 'Sales Discount' ? route('salesPersons.salesDiscount.analysis.result', $company) : route('salesPersons.analysis.result', $company)); ?> enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet">
                <?php 
                    
                    // $salesPersonsData = App\Models\SalesGathering::company()
                    //     ->whereNotNull('sales_person')
                    //     ->where('sales_person','!=','')
                    //     ->groupBy('sales_person')
                    //     ->selectRaw('sales_person')
                    //     ->get()
                    //     ->pluck('sales_person')
                    //     ->toArray();


                         $salesPersonsData = getTypeFor('sales_person',$company->id,false);
                         

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
                    </div>
                    <div class="form-group row">
                        <div class="col-md-<?php echo e($column); ?>">
                            <label><?php echo e(__('Select Sales Persons')); ?> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="salesPersonsData[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" id="salesPersonsData" multiple>
                                        
                                        <?php $__currentLoopData = $salesPersonsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category); ?>"> <?php echo e(__($category)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if($name_of_selector_label == 'Products / Services' || $name_of_selector_label == 'Sales Persons' || $name_of_selector_label =='Products Items'): ?>

                                <div class="col-md-<?php echo e($column); ?>">
                        <label><?php echo e(__('Select Categories')); ?>

                         
                         <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                         </label>
                        <div class="kt-input-icon">
                            <div class="input-group date" id="categories">
                                <select data-live-search="true" data-actions-box="true" name="sales_discounts_fields[]" name="categories[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" multiple>

                                </select>
                            </div>
                        </div>
                    </div>

                    <?php endif; ?>
                    <?php if($name_of_selector_label == 'Products Items' ): ?>

                     <div class="col-md-<?php echo e($column); ?>">
                        <label><?php echo e(__('Select Products')); ?>

                         
                         <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                         </label>
                        <div class="kt-input-icon">
                            <div class="input-group date" id="products__">
                                <select data-live-search="true" data-actions-box="true" name="products[]"  class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" multiple>

                                </select>
                            </div>
                        </div>
                    </div>


                    <?php endif; ?> 


                    <?php if( $name_of_selector_label == 'Sales Discount'): ?>

                    <div class="col-md-<?php echo e($column); ?>">
                        <label><?php echo e(__('Select '.$name_of_selector_label)); ?> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
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
                        <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"><?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </span> </label>
                        <div class="kt-input-icon">
                            <div class="input-group date" id="sales_channels">
                                <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple>

                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label><?php echo e(__('Start Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" required name="start_date" class="form-control" placeholder="Select date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><?php echo e(__('End Date')); ?></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="date" required name="end_date" value="<?php echo e(date('Y-m-d')); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
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
            </div>
            <?php if('salesPersons.Items.analysis' == Request()->route()->getName()): ?>
            <input type="hidden" id="has_product_item">
            <?php endif; ?> 
            
            <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
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

        // }else{
        // var data_type = '';
        // $('.multi_selection').html("");
        // }
        $('#salesPersonsData option:selected').prop('selected', false);

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
    $(document).on('change', '#salesPersonsData', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {

            if (tryParseJSONObject($(this).val()[0])) {
                salesPersonsData = JSON.parse($(this).val()[0]);
            } else {
                salesPersonsData = $(this).val();
            }
            type_of_data = "<?php echo e($type); ?>";
            if(type_of_data == 'product_item' || type_of_data == 'product_or_service' )
            {
                type_of_data = 'category';
            }
            getCategories(salesPersonsData, type_of_data);

        }, getNumberOfMillSeconds());


    });
    $(document).on('change', '[name="categories[]"]', function() {

        clearTimeout(wto);
        wto = setTimeout(() => {

            if (tryParseJSONObject($('#salesPersonsData').val()[0])) {
                salesPersonsData = JSON.parse($('#salesPersonsData').val()[0]);
            } else {
                salesPersonsData = $('#salesPersonsData').val();
            }
            type_of_data = "<?php echo e($type); ?>";

            categories = $(this).val();
            getProducts(salesPersonsData, categories , 'product_or_service' , type_of_data)
        }, getNumberOfMillSeconds());



    });
    $(document).on('change', '[name="products[]"]', function() {
        clearTimeout(wto);
        wto = setTimeout(() => {

            if (tryParseJSONObject($('#salesPersonsData').val()[0])) {
                salesPersonsData = JSON.parse($('#salesPersonsData').val()[0]);
            } else {
                salesPersonsData = $('#salesPersonsData').val();
            }
            // categories = $('[name="categories[]"]').val();
            categories = $('[name="categories[]"]').val();
            products = $(this).val();

            type_of_data = "<?php echo e($type); ?>";
            getProductItems(salesPersonsData ,categories, products)

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
    function getSalesChannales(salesPersonsData, type_of_data) {
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': salesPersonsData
                , 'main_field': 'sales_person'
                , 'field': type_of_data
            }
            , url: '<?php echo e(route('get.zones.data',$company)); ?>'
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {

            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }
            // else{
            //     var data_type = '';
            // }
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + '  >\n';
            // if($('#data_type').val()  !== 'value'){
            //     row += '<option value="">Select</option>\n' ;
            // }

            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';
            console.log(row);
            $('#sales_channels').html('');
            $('#sales_channels').append(row);
            reinitializeSelect2();
        });
    }

    // Categories
    function getCategories(salesPersonsData, type_of_data) {
        // console.log(salesPersonsData, type_of_data);
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': salesPersonsData
                , 'main_field': 'sales_person'
                , 'field': type_of_data
            }
            , url: '<?php echo e(route('get.zones.data',$company)); ?>'
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }else{
            //     var data_type = '';
            // }
            row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select" ' + data_type + '  required >\n';
            // if($('#data_type').val()  !== 'value'){
            //     row += '<option value="">Select</option>\n' ;
            // }

            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';
            console.log(row);
            $('#categories').html('');
            $('#categories').append(row);
            reinitializeSelect2();
        });
    }
    // Sub Categories
    function getProducts(salesPersonsData , categories, type_of_data, type) {
        // alert(categories)
        console.log(type_of_data);
        $.ajax({
            type: 'POST'
            , data: {
                'main_data': salesPersonsData
                , 'main_field': 'sales_person'
                , 'second_main_data': categories
                , 'sub_main_field': 'category'
                // , 'third_main_data': products
                // , 'third_main_field': 'product_or_service'
                , 'field':type_of_data
            , }
            , url: '<?php echo e(route('get.zones.data',$company)); ?>'
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            // if($('#data_type').val()  == 'value'){
            var data_type = 'multiple';
            // }else{
            //     var data_type = '';
            // }
            // console.log(type);
            if (type == 'sales_person' || type == 'product_or_service' 
            // || type == 'product_item'
            ) {

                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="form-control select2-select kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required >\n';

                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                appendTo = '';
                if(type == 'product_item')
                {
                    appendTo ='#products__'
                }
                else{
                    appendTo ='#sales_channels';
                }
                row += '</select>';
                $(appendTo).html('');
                $(appendTo).append(row);
                reinitializeSelect2();
            } else {

                    appendTo = '';
                if(type == 'product_item')
                {
                    appendTo ='#products__'
                }
                else{
                    appendTo ='#sales_channels';
                }

                row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }

                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';
                $(appendTo).html('');
                $(appendTo).append(row);
                reinitializeSelect2();
            }
        });
    }
    // Product Or Services
    function getProductItems(salesPersonsData,categories , products) {
        // if(! document.getElementById('has_product_item'))
        // {
            // return ;
        // }

        

        $.ajax({
            type: 'POST'
            , data: 
            {
                'main_data': salesPersonsData
                , 'main_field': 'sales_person'
                , 'second_main_data': categories
                , 'sub_main_field': 'category'
                , 'third_main_data': products
                , 'third_main_field': 'product_or_service'
                , 'field': 'product_item'
            , }

            // {
            //     'main_data': salesPersonsData
            //     , 'main_field': 'category'
            //     , 'third_main_data': products
            //     , 'third_main_field': 'sales_person'
            //     , 'field': type_of_data
            // , }
            , url: '<?php echo e(route('get.zones.data',$company)); ?>'
            , dataType: 'json'
            , accepts: 'application/json'
        }).done(function(data) {
            var data_type = 'multiple';
        
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  ' + data_type + '  required  >\n';
          

            $.each(data, function(key, val) {
                row += '<option value*="' + val + '">' + val + '</option>\n';

            });
            row += '</select>';
            console.log(row);
            $('#sales_channels').html('');
            $('#sales_channels').append(row);
            reinitializeSelect2();
        });
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/salesPersons_analysis_form.blade.php ENDPATH**/ ?>