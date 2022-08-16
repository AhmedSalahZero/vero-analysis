<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css" />
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
    <form action="<?php echo e(route('products.sales.targets', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php $total_sales_targets_values = 0; $total_sales_targets_percentages = 0;
        $name_of_product = ($has_product_item === true) ? 'Item' :'' ;?>
        <?php if($sales_forecast['add_new_products'] == 1): ?>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Sales Forecast')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <h2><?php echo e(__('Sales Annual Target Year ' )  . date('Y',strtotime($sales_forecast->start_date)) .' : '. number_format($sales_forecast->sales_target)); ?></h2>
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('New Product '.$name_of_product.' Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__('Product '.$name_of_product.' Name')); ?></th>
                                <th><?php echo e(__('Sales Target Value')); ?></th>
                                <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                    <th><?php echo e(__('Sales Target %')); ?></th>
                                <?php endif; ?>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>

                            <?php for($number = 0; $number < $sales_forecast->number_of_products; $number++): ?>
                                <?php
                                    $sales_targets_value = $product_seasonality[$number]->sales_target_value??0;
                                    $sales_targets_percentage = $product_seasonality[$number]->sales_target_percentage??0;
                                    $total_sales_targets_values += $sales_targets_value;
                                    $total_sales_targets_percentages += $sales_targets_percentage;
                                ?>
                                <tr>
                                    <td class="text-center"> <?php echo e(@$product_seasonality[$number]->name); ?></td>

                                    <td class="text-center"><?php echo e(number_format(($sales_targets_value))); ?></td>
                                    <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                        <td class="text-center"><?php echo e(number_format(($sales_targets_percentage),2) . ' %'); ?></td>
                                    <?php endif; ?>

                                </tr>
                            <?php endfor; ?>
                            
                            <tr>
                                <td class="text-center active-style"> <?php echo e(__('Total')); ?></td>

                                <td class="text-center active-style"><?php echo e(number_format($total_sales_targets_values)); ?></td>
                                <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                    <td class="text-center active-style"><?php echo e(number_format($total_sales_targets_percentages). ' %'); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Forecast')); ?>

                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <?php $existing_products_sales_targets = $sales_forecast->sales_target - $total_sales_targets_values ;?>
                <h2><?php echo e(__('Existing Product '.$name_of_product.' Target Year ' )  . date('Y',strtotime($sales_forecast->start_date)) .' : '. number_format($existing_products_sales_targets)); ?></h2>
                <br>
                <br>

                <div class="kt-portlet">
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label><?php echo e(__('Show From Others (Multi-Selector  - Maximum 5 )')); ?> <span class="required">*</span></label>

                                        <select class="form-control kt-select2" id="kt_select2_9" name="others_target[]" multiple="multiple">
                                            <?php $__currentLoopData = $selector_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product); ?>" <?php echo e((false !== $found = array_search($product,($modified_targets->others_target??[]))) ? 'selected' : ''); ?>><?php echo e($product); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label ></label>
                                    <input type="submit" class="btn active-style" name="submit" value="<?php echo e(__('Show')); ?>" >
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="kt-option bg-secondary">
                                        <span class="kt-option__control">
                                            <span
                                                class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                checked>
                                                <input class="rows" name="use_modified_targets" type="checkbox"
                                                value="1" <?php echo e((($modified_targets['use_modified_targets'])??(old('use_modified_targets'))) == 0 ?: 'checked'); ?>

                                                    id="product_item_check_box">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="kt-option__label d-flex">
                                            <span class="kt-option__head mr-auto p-2">
                                                <span class="kt-option__title">
                                                    <b>
                                                        <?php echo e(__('Click To Activate Modified Targets')); ?>

                                                    </b>
                                                </span>

                                            </span>
                                        </span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($errors->has("percentages_total")): ?>
                    <h4 style="color: red"><i class="fa fa-hand-point-right">
                    </i></i><?php echo e($errors->first("percentages_total")); ?></h4>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Existing Product '.$name_of_product.' Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__('Product '.$name_of_product.' Name')); ?></th>
                            <th><?php echo e(__('Pervious Year Sales Value')); ?></th>
                            <th><?php echo e(__('Sales Target Value')); ?></th>
                            <th><?php echo e(__('Sales Target %')); ?></th>
                            <th><?php echo e(__('Modify Sales Target')); ?></th>
                            <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                <th><?php echo e(__('Modify Sales %')); ?></th>
                            <?php endif; ?>
                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                    <?php $total = array_sum(array_column($product_item_breakdown_data,'Sales Value'));
                          $total =  $sales_forecast->seasonality == "last_3_years" ? $total/3 : $total ;
                        $total_existing_targets = 0;
                    ?>
                        <?php $__currentLoopData = $product_item_breakdown_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th><?php echo e($product_data['item'] ?? '-'); ?></th>
                                <?php $sales_values  = $sales_forecast->seasonality == "last_3_years" ? (($product_data['Sales Value']??0)/3 ):$product_data['Sales Value'] ; ?>
                                <td class="text-center"><?php echo e(number_format($sales_values)); ?></td>

                                <?php
                                    $target_percentage = ($total == 0) ? 0 : (($sales_values/$total)) ;
                                    $existing_target_per_product = $target_percentage*$existing_products_sales_targets;
                                    $total_existing_targets += $existing_target_per_product;
                                ?>
                                <td class="text-center"><?php echo e(number_format ($existing_target_per_product)); ?></td>
                                <td class="text-center"><?php echo e(number_format ($target_percentage*100, 1). ' %'); ?></td>
                                <input type="hidden" name="sales_targets_percentages[<?php echo e($product_data['item']); ?>]" value="<?php echo e($target_percentage); ?>">


                                <td class="text-center">
                                    <input type="number" name="modify_sales_target[<?php echo e($product_data['item']); ?>][value]" placeholder="<?php echo e(__('Value')); ?>" class="modify_sales_target form-control" value="<?php echo e(@$modified_targets['products_modified_targets'][$product_data['item']]['value']); ?>">
                                </td>
                                <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                    <td class="text-center">
                                        <input type="number" name="modify_sales_target[<?php echo e($product_data['item']); ?>][percentage]" placeholder="<?php echo e(__('%')); ?>" class="modify_sales_target_percentage form-control" value="<?php echo e(($modified_targets['products_modified_targets'][$product_data['item']]['percentage'])?? (old('modify_sales_target')[$product_data['item']]['percentage']??0)); ?>">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-active text-center">
                            <th ><?php echo e(__('Total')); ?></th>
                            <td><?php echo e(number_format($total)); ?></td>
                            <td><?php echo e(number_format($total_existing_targets)); ?></td>
                            <td>100 %</td>
                            <td id="total_modify_sales_target"><?php echo e(!isset($modified_targets['products_modified_targets'])  ? 0 :  number_format((array_sum(array_column($modified_targets['products_modified_targets'],'value') ?? [])))); ?></td>
                            <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !=='product_target'): ?>
                                <td id="total_modify_sales_target_percentage"><?php echo e(!isset($modified_targets['products_modified_targets'])  ? 0 :  number_format((array_sum(array_column($modified_targets['products_modified_targets'],'percentage') ?? [])))); ?></td>
                            <?php endif; ?>
                        </tr>

                    <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

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

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/vendors/general/select2/dist/js/select2.full.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/select2.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
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
    <script>
        $('.products').on('change', function () {
            var name= $(this).find(':selected').data('name');
            var id= $(this).find(':selected').data('id');
            var index = $('.products').index(this);
            $('.categories option').eq(index).remove();
            select = '<option value="'+id+'" selected>'+name +'</option>';
            $('.categories').eq(index).append(select);
        });


        $('.modify_sales_target').on('change', function () {
            var index = $('.modify_sales_target').index(this);
            var modify_sales_target = parseFloat($(this).val());
            var percentage = (modify_sales_target/parseFloat("<?php echo e($existing_products_sales_targets); ?>"))*100;
            $('.modify_sales_target_percentage').eq(index).val(percentage.toFixed(2));
            totalFunction('.modify_sales_target','#total_modify_sales_target',0);
            totalFunction('.modify_sales_target_percentage','#total_modify_sales_target_percentage',2);
        });
        $('.modify_sales_target_percentage').on('change', function () {
            var index = $('.modify_sales_target_percentage').index(this);
            var modify_sales_target_percentage = parseFloat($(this).val()) /100;
            var value = (modify_sales_target_percentage*parseFloat("<?php echo e($existing_products_sales_targets); ?>")) ;
            $('.modify_sales_target').eq(index).val(value.toFixed(0));
            totalFunction('.modify_sales_target_percentage','#total_modify_sales_target_percentage',2);
            totalFunction('.modify_sales_target','#total_modify_sales_target',0);

        });



        $('.seasonality').on('change', function() {
            val = $(this).val();
            var index = $('.seasonality').index(this);

              if (val == 'new_seasonality_monthly') {
                    $('.monthly_seasonality').eq(index).fadeIn(300);
                $('.quarterly_seasonality').eq(index).fadeOut("slow", function() {
                });
            } else if (val == 'new_seasonality_quarterly') {
                $('.monthly_seasonality').eq(index).fadeOut("slow", function() {
                    $('.quarterly_seasonality').eq(index).fadeIn(300);
                });

            }
        });
        function totalFunction(field_name,total_field_name,decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '') {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).html(total.toFixed(decimals));
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/products_sales_targets.blade.php ENDPATH**/ ?>