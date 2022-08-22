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
    <form action="<?php echo e(route('new.product.allocation.base', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php $total_sales_targets_values = 0;
        $total_sales_targets_percentages = 0; ?>
        <?php if(1): ?>
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3>
                            <?php echo e(__('New Products Item Sales Annual Target Year ') .date('Y', strtotime($sales_forecast->start_date)) .' : ' .number_format($product_seasonality->sum('sales_target_value'))); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    
                    <?php if($errors->has('percentages_total')): ?>
                        <h4 style="color: red"><i class="fa fa-hand-point-right">
                            </i></i><?php echo e($errors->first('percentages_total')); ?></h4>

                    <?php else: ?>
                        <h4 class="text-success"><i class="fa fa-hand-point-right">
                            </i></i><?php echo e(__('Total Percentages Must Be Equal To 100 %')); ?></h4>
                    <?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('New Product Items Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__(str_replace('_', ' ', ucwords($allocation_base)))); ?></th>
                                <?php $__currentLoopData = $product_seasonality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th style="width: 8%"><?php echo e($product->name); ?></th>
                                    <th><?php echo e(__('Sales Target [ ') . number_format($product->sales_target_value ?? 0) . ' ]'); ?>

                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <input type="hidden" name="allocation_base" value="<?php echo e($allocation_base); ?>">
                            <?php $key = 0; ?>
                            <?php $key_for_new_items = 0; ?>

                            <?php $__currentLoopData = $allocation_bases_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center">
                                    <?php if($type == 'new'): ?>
                                    <?php $name = ($allocations_base_row->new_allocation_bases_names[$key_for_new_items]) ?? (old('new_allocation_base_items')[$key_for_new_items]??''); ?>
                                        <td class="text-center light-gray-bg">
                                            <div class="input-group validated">
                                                <input type="text" name="new_allocation_base_items[<?php echo e($key_for_new_items); ?>]"
                                                    value="<?php echo e($name); ?>"
                                                    placeholder="<?php echo e(__('Insert ' . str_replace('_', ' ', ucwords($allocation_base)))); ?>"
                                                    class="form-control">
                                                <?php if($errors->has('new_allocation_base_items.' . $key_for_new_items)): ?>
                                                    <div class="invalid-feedback">
                                                        <?php echo e($errors->first('new_allocation_base_items.' . $key_for_new_items)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <?php $key_for_new_items++; ?>
                                    <?php else: ?>
                                        <td> <?php echo e($item); ?> </td>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = $product_seasonality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            if($allocations_base_row === null){
                                                $value = (old('allocation_base_data')[$product->name][$item][$type] ?? '' );
                                            }else{

                                                $value = @$allocations_base_row->allocation_base_data[$product->name][$item][$type];
                                                if ($type == 'new') {
                                                    $value = @$allocations_base_row->allocation_base_data[$product->name][$name][$type];
                                                }
                                            }

                                        ?>
                                        <?php $product_name = str_replace(' ', '_', strtolower($product->name)); ?>
                                        <td class="text-center" style="background-color:lightgrey;">
                                            <input type="number" step="any"
                                                name="allocation_base_data[<?php echo e($product->name); ?>][<?php echo e($item); ?>][<?php echo e($type); ?>]"
                                                value="<?php echo e($value ?? ''); ?>" placeholder="<?php echo e(__('Insert %')); ?>"
                                                class="sales_target_percentage_<?php echo e($product_name); ?> form-control">
                                        </td>
                                        <td class="text-center">
                                            <input type="number" step="any" placeholder="<?php echo e(__('Insert Value')); ?>"
                                                class="sales_target_value_<?php echo e($product_name); ?> form-control">
                                        </td>
                                        <?php $key++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <tr>
                                <td class="text-center active-style"><?php echo e(__('Total')); ?></td>
                                <?php $__currentLoopData = $product_seasonality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $product_name = str_replace(' ', '_', strtolower($product->name)); ?>
                                    <td class="text-center active-style"
                                        id="total_sales_target_percentage_<?php echo e($product_name); ?>">
                                        <?php echo e(!isset($modified_targets['products_modified_targets'])? 0: number_format(array_sum(array_column($modified_targets['products_modified_targets'], 'percentage') ?? []))); ?>

                                    </td>
                                    <td class="text-center active-style" id="total_sales_target_value_<?php echo e($product_name); ?>">
                                        <?php echo e(!isset($modified_targets['products_modified_targets'])? 0: number_format(array_sum(array_column($modified_targets['products_modified_targets'], 'value') ?? []))); ?>

                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


    <?php $__currentLoopData = $product_seasonality; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $product_name = str_replace(' ', '_', strtolower($product->name));
        $value = $product->sales_target_value; ?>

        <script>
            $(document).ready(function() {

                $('.sales_target_percentage_' + '<?php echo e($product_name); ?>').each(function(index, element) {
                    var index = $('.sales_target_percentage_' + '<?php echo e($product_name); ?>').index(this);
                    var sales_target_percentage = parseFloat($(this).val()) / 100;
                    targetpercentage(index, sales_target_percentage, "<?php echo e($value); ?>",
                        "<?php echo e($product_name); ?>");

                });
            });

            $('.sales_target_value_' + '<?php echo e($product_name); ?>').on('change', function() {
                var index = $('.sales_target_value_' + '<?php echo e($product_name); ?>').index(this);
                var sales_target = parseFloat($(this).val());
                targetValue(index, sales_target, "<?php echo e($value); ?>", "<?php echo e($product_name); ?>");

            });




            $('.sales_target_percentage_' + '<?php echo e($product_name); ?>').on('change', function() {

                var index = $('.sales_target_percentage_' + '<?php echo e($product_name); ?>').index(this);
                var sales_target_percentage = parseFloat($(this).val()) / 100;
                targetpercentage(index, sales_target_percentage, "<?php echo e($value); ?>", "<?php echo e($product_name); ?>");

            });
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




    <script>
        function targetValue(index, sales_target, value, product_name) {
            var percentage = (sales_target / parseFloat(value)) * 100;
            $('.sales_target_percentage_' + product_name).eq(index).val(percentage.toFixed(2));
            totalFunction('.sales_target_value_' + product_name, '#total_sales_target_value_' + product_name, 0);
            totalFunction('.sales_target_percentage_' + product_name, '#total_sales_target_percentage_' + product_name, 2);
        }

        function targetpercentage(index, sales_target_percentage, value, product_name) {
            var value = (sales_target_percentage * parseFloat(value));
            $('.sales_target_value_' + product_name).eq(index).val(value.toFixed(0));
            totalFunctionForProducts('.sales_target_percentage_' + product_name, '#total_sales_target_percentage_' +
                product_name, 2, '%');
            totalFunctionForProducts('.sales_target_value_' + product_name, '#total_sales_target_value_' + product_name, 0);
        }

        function totalFunctionForProducts(field_name, total_field_name, decimals, character = null) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '') {
                    total = parseFloat(element.value) + total;
                }

            });
            if (character !== null) {
                total = (total.toFixed(decimals)) + ' ' + character;
            } else {
                total = (total.toFixed(decimals));
            }
            $(total_field_name).html(total);
        }



        $('.months').on('change', function() {
            key = $(this).data('product');
            totalFunction('.months', '.total_months', key, 0);
        });
        $('.quarters').on('change', function() {
            key = $(this).data('product');
            totalFunction('.quarters', '.total_quarters', key, 0);
        });

        function totalFunction(field_name, total_field_name, key, decimals) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '' && key == $(this).data('product')) {
                    total = parseFloat(element.value) + total;
                }

            });
            $(total_field_name).eq(key).val((total.toFixed(decimals) + ' ' + character));
        }


        $('.products').on('change', function() {
            var name = $(this).find(':selected').data('name');
            var id = $(this).find(':selected').data('id');
            var index = $('.products').index(this);
            $('.categories option').eq(index).remove();
            select = '<option value="' + id + '" selected>' + name + '</option>';
            $('.categories').eq(index).append(select);
        });

        // $('.sales_target_value').on('change', function () {
        //     var index = $('.sales_target_value').index(this);
        //     var sales_target_value = parseFloat($(this).val());
        //     var sales_target = $('.sales_target').eq(index).val();
        //     var percentage = (sales_target_value/parseFloat(sales_target))*100;
        //     $('.sales_target_percentage').eq(index).val(percentage.toFixed(2));
        // });

        // $('.sales_target_percentage').on('change', function () {
        //     var index = $('.sales_target_percentage').index(this);
        //     var sales_target = $('.sales_target').eq(index).val();
        //     percentageChangeing(index,$(this).val(),sales_target);
        // });

        // function percentageChangeing(index,percentage,sales_target) {

        //     var sales_target_percentage = parseFloat(percentage) /100;
        //     var value = (sales_target_percentage*parseFloat(sales_target)) ;
        //     $('.sales_target_value').eq(index).val(value.toFixed(0));
        // }

        $('.seasonality').on('change', function() {
            val = $(this).val();
            var index = $('.seasonality').index(this);

            if (val == 'new_seasonality_monthly') {
                $('.monthly_seasonality').eq(index).fadeIn(300);
                $('.quarterly_seasonality').eq(index).fadeOut("slow", function() {});
            } else if (val == 'new_seasonality_quarterly') {
                $('.monthly_seasonality').eq(index).fadeOut("slow", function() {
                    $('.quarterly_seasonality').eq(index).fadeIn(300);
                });

            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/new_products_allocation_base.blade.php ENDPATH**/ ?>