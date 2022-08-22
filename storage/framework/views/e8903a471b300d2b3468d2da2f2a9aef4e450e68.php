<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet"
        type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__($view_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" method="POST"
                action=<?php echo e($name_of_selector_label == 'Sales Discount' ? route('Items.salesDiscount.analysis.result', $company) : route('Items.analysis.result', $company)); ?> enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="kt-portlet">
                    <?php 
                    // $ItemsData = App\Models\SalesGathering::company()
                    //     ->whereNotNull('product_item')
                    //     ->where('product_item','!=','')
                    //     ->groupBy('product_item')
                    //     ->selectRaw('product_item')
                    //     ->get()
                    //     ->pluck('product_item')
                    //     ->toArray();

                        $ItemsData = getTypeFor('product_item',$company->id,false);



                        if ($name_of_selector_label == 'Products Items') {
                            $column =  3 ;
                        }elseif ($name_of_selector_label == 'Products / Services') {
                            $column =  4 ;
                        }else {
                            $column =  6 ;
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
                                        <select name="data_type" id="data_type"   class="form-control">

                                            <option selected value="value"><?php echo e(__('Value')); ?></option>
                                            <option value="quantity"><?php echo e(__('Quantity')); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-<?php echo e($column); ?>">
                                <label><?php echo e(__('Select Products Items')); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select data-live-search="true" data-actions-box="true" name="ItemsData[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"
                                            id="ItemsData" multiple>
                                            
                                            <?php $__currentLoopData = $ItemsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category); ?>"> <?php echo e(__($category)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            


                            <?php if( $name_of_selector_label == 'Sales Discount'): ?>

                                <div class="col-md-<?php echo e($column); ?>">
                                    <label><?php echo e(__('Select '.$name_of_selector_label)); ?> </label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <select data-live-search="true" data-actions-box="true" name="sales_discounts_fields[]" required class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"
                                                id="sales_discounts_fields" multiple>
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
                                    <label><?php echo e(__('Select '.$name_of_selector_label.' ')); ?> <span class="multi_selection"></span></label>
                                    <div class="kt-input-icon">
                                        <div class="input-group date" id="sales_channels">
                                            <select data-live-search="true" data-actions-box="true" name="sales_channels[]" required
                                            class="form-control kt-bootstrap-select kt_bootstrap_select select2-select" multiple>

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
                                        <input type="date" name="start_date" required class="form-control"
                                            placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><?php echo e(__('End Date')); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="date" name="end_date" required value="<?php echo e(date('Y-m-d')); ?>" max="<?php echo e(date('Y-m-d')); ?>"
                                            class="form-control" placeholder="Select date" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><?php echo e(__('Select Interval')); ?> </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select  name="interval" required class="form-control">
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
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!--begin::Page Scripts(used by this page) -->
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"
        type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>"
        type="text/javascript">
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
        $('#data_type').change(function (e) {
            // if($('#data_type').val()  == 'value'){
                var data_type = 'multiple';
                // $('.multi_selection').html("<?php echo e(__('( Multi Selection )')); ?>");

            // }else{
            //     var data_type = '';
            //     $('.multi_selection').html("");
            // }
            $('#ItemsData option:selected').prop('selected', false);

            $('.filter-option-inner-inner').html('Nothing selected');
            $('#sales_channels').html('');
            row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required '+data_type+' ></select>' ;
            $('#sales_channels').append(row)
            $('#categories').html('');
            row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" '+data_type+'  required ></select>' ;
            $('#categories').append(row);
            $('#products').html('');
            row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  '+data_type+'  required  ></select>' ;
            $('#products').append(row);
            reinitializeSelect2();
        });
        $(document).on('change', '#ItemsData', function() {


                   clearTimeout(wto);
  wto = setTimeout(()=> {
  if(tryParseJSONObject($(this).val()[0])){
                ItemsData = JSON.parse($(this).val()[0]);
            }else{
                ItemsData=  $(this).val();
            }
            type_of_data = "<?php echo e($type); ?>";

                getSalesChannales(ItemsData,type_of_data);


  }, getNumberOfMillSeconds());

          

        });
        $(document).on('change', '[name="categories[]"]', function() {

                   clearTimeout(wto);
  wto = setTimeout(()=> {
   if(tryParseJSONObject($('#ItemsData').val()[0])){
                ItemsData = JSON.parse($('#ItemsData').val()[0]);
            }else{
                ItemsData=  $('#ItemsData').val();
            }
            type_of_data = "<?php echo e($type); ?>";

            categories = $(this).val();

            getProducts(ItemsData,categories,'product_item',type_of_data)

  }, getNumberOfMillSeconds());

         

        });
        $(document).on('change', '[name="products[]"]', function() {

                   clearTimeout(wto);
  wto = setTimeout(()=> {


            if(tryParseJSONObject($('#ItemsData').val()[0])){
                ItemsData = JSON.parse($('#ItemsData').val()[0]);
            }else{
                ItemsData=  $('#ItemsData').val();
            }
            categories = $('[name="categories[]"]').val();
            products = $(this).val();

            type_of_data = "<?php echo e($type); ?>";
            getItems(ItemsData,products,type_of_data)

  }, getNumberOfMillSeconds());
  

        });
        function tryParseJSONObject(jsonString) {
            try {
                var o = JSON.parse(jsonString);

            } catch (e) {return false;}

            return true;
        };

        // Sales Channales
        function getSalesChannales(ItemsData,type_of_data) {
            $.ajax({
            type:'POST',
            data: {'main_data' : ItemsData , 'main_field' : 'product_item','field' : type_of_data} ,
            url: '<?php echo e(route('get.zones.data',$company)); ?>',
            dataType:'json',
            accepts:'application/json'
            }).done(function (data) {

                // if($('#data_type').val()  == 'value'){
                    var data_type = 'multiple';
                // }else{
                //     var data_type = '';
                // }
                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required '+data_type+'  >\n' ;
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }


                $.each(data, function(key, val) {
                    row += '<option value="'+val+'">'+ val +'</option>\n' ;

                });
                row +='</select>';
                console.log(row);
                $('#sales_channels').html('');
                $('#sales_channels').append(row);
                reinitializeSelect2();
            });
        }

        // Categories
        function getCategories(ItemsData,type_of_data) {
            $.ajax({
            type:'POST',
            data: {'main_data' : ItemsData, 'main_field' : 'sales_channel','field' : type_of_data} ,
            url: '<?php echo e(route('get.zones.data',$company)); ?>',
            dataType:'json',
            accepts:'application/json'
            }).done(function (data) {
                // if($('#data_type').val()  == 'value'){
                    var data_type = 'multiple';
                // }else{
                //     var data_type = '';
                // }
                row = '<select data-live-search="true" data-actions-box="true" name="categories[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" '+data_type+'  required >\n' ;
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }


                $.each(data, function(key, val) {
                    row += '<option value="'+val+'">'+ val +'</option>\n' ;

                });
                row +='</select>';
                console.log(row);
            $('#categories').html('');
            $('#categories').append(row);
            reinitializeSelect2();
            });
        }
        // Sub Categories
        function getProducts(categories,type_of_data,type) {
            $.ajax({
            type:'POST',
            data: {'main_data' :categories ,
                   'main_field' : 'category',
                   'field' : type_of_data
                } ,
            url: '<?php echo e(route('get.zones.data',$company)); ?>',
            dataType:'json',
            accepts:'application/json'
            }).done(function (data) {
                // if($('#data_type').val()  == 'value'){
                    var data_type = 'multiple';
                // }else{
                //     var data_type = '';
                // }

                if (type == 'product_item') {

                    row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  '+data_type+'  required >\n' ;
                    // if($('#data_type').val()  !== 'value'){
                    //     row += '<option value="">Select</option>\n' ;
                    // }

                    $.each(data, function(key, val) {
                        row += '<option value="'+val+'">'+ val +'</option>\n' ;

                    });
                    row +='</select>';
                    $('#sales_channels').html('');
                    $('#sales_channels').append(row);
                    reinitializeSelect2();
                } else {
                    row = '<select data-live-search="true" data-actions-box="true" name="products[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  '+data_type+'  required  >\n' ;
                    if($('#data_type').val()  !== 'value'){
                        row += '<option value="">Select</option>\n' ;
                    }

                    $.each(data, function(key, val) {
                        row += '<option value="'+val+'">'+ val +'</option>\n' ;

                    });
                    row +='</select>';
                    console.log(row);
                    $('#products').html('');
                    $('#products').append(row);
                    reinitializeSelect2();
                }
            });
        }
        // Product Or Services
        function getItems(ItemsData,products,type_of_data) {
            $.ajax({
            type:'POST',
            data: {'main_data' :ItemsData ,
                   'main_field' : 'category',
                   'third_main_data' : products,
                   'third_main_field' : 'product_item',
                   'field' : type_of_data,
                } ,
            url: '<?php echo e(route('get.zones.data',$company)); ?>',
            dataType:'json',
            accepts:'application/json'
            }).done(function (data) {
                // if($('#data_type').val()  == 'value'){
                    var data_type = 'multiple';
                // }else{
                //     var data_type = '';
                // }
                row = '<select data-live-search="true" data-actions-box="true" name="sales_channels[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select"  '+data_type+'  required  >\n' ;
                // if($('#data_type').val()  !== 'value'){
                //     row += '<option value="">Select</option>\n' ;
                // }


                $.each(data, function(key, val) {
                    row += '<option value="'+val+'">'+ val +'</option>\n' ;

                });
                row +='</select>';
                console.log(row);
            $('#sales_channels').html('');
            $('#sales_channels').append(row);
            reinitializeSelect2();

            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/skus_analysis_form.blade.php ENDPATH**/ ?>