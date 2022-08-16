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
    <form action="<?php echo e(route('existing.products.allocations', $company)); ?>" method="POST">
        <?php echo csrf_field(); ?>



<?php if((canShowNewItemsProducts($company->id))): ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <?php $total_new_items_targets = array_sum($sales_targets_values); ?>
                    <h2>
                        <?php echo e(__('New Products Items Sales Target Year ') .date('Y', strtotime($sales_forecast->start_date)) .' : ' .number_format($total_new_items_targets)); ?>

                    </h2>
                </div>
            </div>
            <div class="kt-portlet__body">

                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('New Product Items Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__(str_replace('_', ' ', ucwords($allocation_base)))); ?></th>
                            <th><?php echo e(__('Sales Target Value')); ?></th>
                            <?php if($sales_forecast->target_base !== 'new_start' || $sales_forecast->new_start !== 'product_target'): ?>
                                <th><?php echo e(__('Sales Target %')); ?></th>
                            <?php endif; ?>
                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                    
                    <?php
                    sortTwoDimensionalArr($sales_targets_values);
                    ?>
                        <?php $__currentLoopData = $sales_targets_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_vame => $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $percentages[$base_vame] = $total_new_items_targets == 0 ? 0 : ($target / $total_new_items_targets) * 100; ?>
                            <tr>
                                <td><?php echo e($base_vame); ?></td>
                                <td class="text-center"><?php echo e(number_format($target)); ?></td>
                                <td class="text-center"><?php echo e(number_format($percentages[$base_vame] ?? 0, 2) . ' %'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="active-style"><?php echo e(__('Total')); ?></td>
                            <td class="text-center active-style"><?php echo e(number_format($total_new_items_targets)); ?></td>
                            <td class="text-center active-style"><?php echo e(isset($percentages) ? number_format(array_sum($percentages), 2) . ' %'  : 0); ?></td>
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


        <?php $item = ucwords(str_replace('_', ' ', $allocation_base)); ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <?php $existing_items_target = $sales_forecast->sales_target - ($total_new_items_targets ?? 0); ?>
                    <h2>
                        <?php echo e(__('Existing Products Items Sales Target Year ') .date('Y', strtotime($sales_forecast->start_date)) .' : ' .number_format($existing_items_target)); ?>

                    </h2>
                    <input type="hidden" name="total_existing_target" value="<?php echo e($existing_items_target); ?>">
                </div>
            </div>
            <div class="kt-portlet__body">
                <?php if($allocations_setting->breakdown === 'new_breakdown_quarterly'): ?>
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($item.' Sales Targets Values Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th><?php echo e(__('Item')); ?></th>
                                <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(__($quarter_name)); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__('Total Year')); ?></th>

                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <tr>
                                <td><?php echo e(__('Quaterly Sales Target Values')); ?></td>
                                <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="text-center"><?php echo e(number_format($value ?? 0)); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center"><?php echo e(number_format(array_sum($sales_targets))); ?></td>
                            </tr>
                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                <?php endif; ?>
                <br>
                <br>

                <div class="kt-portlet">
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="kt-option bg-secondary">
                                        <span class="kt-option__control">
                                            <span
                                                class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                checked>
                                                <input class="rows" name="use_modified_targets" type="checkbox"
                                                value="1" <?php echo e(($existing_allocations_base['use_modified_targets']??(old('use_modified_targets'))) == 0 ?: 'checked'); ?>

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
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($item.' Sales Target Values Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__($item . ' Name')); ?></th>
                            <th><?php echo e(__(($allocations_setting->breakdown == 'last_3_years' ? 'Last 3 Years Average' : 'Pervious Year') . ' Sales Value')); ?>

                            </th>
                            <?php if($allocations_setting->breakdown !== 'new_breakdown_annually'): ?>
                                <th><?php echo e(__('Sales Target Value')); ?></th>
                                <th><?php echo e(__('Sales Target %')); ?></th>
                            <?php endif; ?>
                            <?php if($allocations_setting->breakdown !== 'new_breakdown_quarterly'): ?>
                                <th><?php echo e(__(($allocations_setting->breakdown !== 'new_breakdown_annually' ? 'Modify' : 'Insert') . ' Sales Target')); ?>

                                </th>
                                <th style="width: 8% !important">
                                    <?php echo e(__(($allocations_setting->breakdown !== 'new_breakdown_annually' ? 'Modify' : 'Insert') . ' Sales %')); ?>

                                </th>
                            <?php else: ?>
                                <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(__('Modify ' . $quarter_name . ' Sales Target')); ?></th>
                                    <th style="width: 8% !important"><?php echo e(__('Modify ' . $quarter_name . ' Sales %')); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                        <?php $total = array_sum(array_column($breakdown_base_data, 'Sales Value'));
                        $allocations_setting->breakdown !== 'last_3_years' ?: ($total = $total / 3);
                        $total_existing_targets = 0;
                        $breakdown_base_data;
                        sortTwoDimensionalBaseOnKey($breakdown_base_data , 'Sales Value');
                        ?>

                        <?php $__currentLoopData = $breakdown_base_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($product_data['item'] ?? '-'); ?></td>
                                <?php
                                $sales_value = $allocations_setting->breakdown == 'last_3_years' ? ($product_data['Sales Value'] ?? 0) / 3 : $product_data['Sales Value'] ?? 0;
                                $target_percentage = $total == 0 ? 0 : $sales_value / $total;
                                $existing_target_per_product = $target_percentage * $existing_items_target;
                                $total_existing_targets += $existing_target_per_product;
                                ?>
                                <td class="text-center"><?php echo e(number_format($sales_value ?? 0)); ?></td>

                                <?php if($allocations_setting->breakdown !== 'new_breakdown_annually'): ?>

                                    <td class="text-center"><?php echo e(number_format($existing_target_per_product)); ?></td>
                                    <input type="hidden" name="existing_products_target[<?php echo e($product_data['item']); ?>]" value="<?php echo e($existing_target_per_product); ?>">
                                    <td class="text-center light-gray-bg">
                                        <?php echo e(number_format($target_percentage * 100, 1) . ' %'); ?>

                                    </td>

                                <?php endif; ?>
                                <?php if($allocations_setting->breakdown !== 'new_breakdown_quarterly'): ?>
                                    <td class="text-center">
                                        <input type="number"  placeholder="<?php echo e(__('Value')); ?>"
                                        class="modify_sales_target form-control" >
                                    </td>
                                    <?php
                                        if ($existing_allocations_base === null ) {
                                            $percentage = old('modify_sales_target')[ $product_data['item']] ?? '';

                                        } else {
                                            $percentage = $existing_allocations_base['allocation_base_percentages'][$product_data['item']] ?? '';
                                            if (is_array($percentage)) {
                                                $percentage = '';
                                            }
                                        }

                                    ?>
                                    <td class="text-center light-gray-bg">
                                        <input type="number" name="modify_sales_target[<?php echo e($product_data['item']); ?>]"
                                            placeholder="<?php echo e(__('%')); ?>"
                                            class="modify_sales_target_percentage form-control"
                                            value="<?php echo e($percentage); ?>">
                                    </td>
                                <?php else: ?>
                                    <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $quarter_name = str_replace(' ', '_', $quarter_name); ?>

                                        <td class="text-center">
                                            <input type="number"  placeholder="<?php echo e(__('Value')); ?>"
                                                class="modify_sales_target_<?php echo e($quarter_name); ?> form-control"
                                                data-quarter_annual_target="<?php echo e($value); ?>" >
                                        </td>

                                        <td class="text-center light-gray-bg">
                                            <input type="number"
                                                name="modify_sales_target[<?php echo e($product_data['item']); ?>][<?php echo e($quarter_name); ?>]"
                                                data-quarter_annual_target="<?php echo e($value); ?>"
                                                value="<?php echo e($existing_allocations_base['allocation_base_percentages'][$product_data['item']][$quarter_name] ?? ''); ?>"
                                                placeholder="<?php echo e(__('%')); ?>"
                                                class="modify_sales_target_percentage_<?php echo e($quarter_name); ?> form-control">
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-active text-center">
                            <th><?php echo e(__('Total')); ?></th>
                            <td><?php echo e(number_format($total)); ?></td>
                            <?php if($allocations_setting->breakdown !== 'new_breakdown_annually'): ?>
                                <td><?php echo e(number_format($total_existing_targets)); ?></td>
                                <td>100.00 %</td>
                            <?php endif; ?>
                            <?php if($allocations_setting->breakdown !== 'new_breakdown_quarterly'): ?>
                                <td id="total_modify_sales_target">
                                    <?php echo e(!isset($existing_allocations_base['products_modified_targets'])? 0: number_format(array_sum(array_column($existing_allocations_base['products_modified_targets'], 'value') ?? []))); ?>

                                </td>
                                <td id="total_modify_sales_target_percentage">
                                    <?php echo e(!isset($existing_allocations_base['products_modified_targets'])? 0: number_format(array_sum(array_column($existing_allocations_base['products_modified_targets'], 'percentage') ?? []))); ?>

                                </td>
                            <?php else: ?>
                                <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $quarter_name = str_replace(' ', '_', $quarter_name); ?>
                                    <td id="total_modify_sales_target_<?php echo e($quarter_name); ?>">
                                        <?php echo e(!isset($modified_targets['products_modified_targets'])? 0: number_format(array_sum(array_column($modified_targets['products_modified_targets'], 'value') ?? []))); ?>

                                    </td>
                                    <td id="total_modify_sales_target_percentage_<?php echo e($quarter_name); ?>">
                                        <?php echo e(!isset($modified_targets['products_modified_targets'])? 0: number_format(array_sum(array_column($modified_targets['products_modified_targets'], 'percentage') ?? []))); ?>

                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    <?php if($allocations_setting->breakdown !== 'new_breakdown_quarterly'): ?>
        <script>
            $(document).ready(function() {
                $('.modify_sales_target_percentage').each(function(index, element) {
                    // element == this
                    var modify_sales_target_percentage = parseFloat($(this).val()) / 100;

                    modifiedTragetPercentage(index, modify_sales_target_percentage);
                });
            });
        </script>
    <?php endif; ?>


    <?php if($allocations_setting->breakdown == 'new_breakdown_quarterly'): ?>
        <?php $__currentLoopData = $sales_targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $quarter_name = str_replace(' ', '_', $quarter_name); ?>
            <script>
                $(document).ready(function() {
                    $('.modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>').each(function(index, element) {
                        // element == this

                        var modify_sales_target_percentage = parseFloat($(this).val()) / 100;
                        var value = (modify_sales_target_percentage * parseFloat("<?php echo e($value); ?>"));
                    quarterPercentages("<?php echo e($quarter_name); ?>", index, modify_sales_target_percentage, value);
                    });
                });


                $('.modify_sales_target_' + '<?php echo e($quarter_name); ?>').on('change', function() {
                    var index = $('.modify_sales_target_' + '<?php echo e($quarter_name); ?>').index(this);
                    var modify_sales_target = parseFloat($(this).val());

                    var percentage = (modify_sales_target / parseFloat("<?php echo e($value); ?>")) * 100;
                    $('.modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>').eq(index).val(percentage.toFixed(2));
                    totalFunction('.modify_sales_target_' + '<?php echo e($quarter_name); ?>', '#total_modify_sales_target_' +
                        '<?php echo e($quarter_name); ?>', 0, null);
                    totalFunction('.modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>',
                        '#total_modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>', 2, '%');
                });


                $('.modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>').on('change', function() {
                    var index = $('.modify_sales_target_percentage_' + '<?php echo e($quarter_name); ?>').index(this);
                    var modify_sales_target_percentage = parseFloat($(this).val()) / 100;
                    var value = (modify_sales_target_percentage * parseFloat("<?php echo e($value); ?>"));




                    quarterPercentages("<?php echo e($quarter_name); ?>", index, modify_sales_target_percentage, value);
                });
            </script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    
    <script>
        function quarterPercentages(quarter_name, index, modify_sales_target_percentage, value) {
            $('.modify_sales_target_' + quarter_name).eq(index).val(value.toFixed(0));
            totalFunction('.modify_sales_target_percentage_' + quarter_name,
                '#total_modify_sales_target_percentage_' + quarter_name, 2, '%');
            totalFunction('.modify_sales_target_' + quarter_name, '#total_modify_sales_target_' + quarter_name, 0, null);
        }
    </script>
    <script>
        $('#allocation_base').on('change', function() {
            val = $(this).find('option:selected').text();
            $('#add_new_items').attr('disabled', false);

            $('#item_type').html(' ' + $.trim(val));
        });


        $('#add_new_items').change(function() {
            if ($(this).prop("checked")) {
                $('#number_of_items').fadeIn(300);
            } else {
                $('#number_of_items').fadeOut(300);
            }

        });

        // Changing Target
        $('.modify_sales_target').on('change', function() {
            var index = $('.modify_sales_target').index(this);
            var modify_sales_target = parseFloat($(this).val());
            var percentage = (modify_sales_target / parseFloat("<?php echo e($existing_items_target ?? 0); ?>")) * 100;
            $('.modify_sales_target_percentage').eq(index).val(percentage.toFixed(2));

            totalFunction('.modify_sales_target_percentage', '#total_modify_sales_target_percentage', 2, '%');
            totalFunction('.modify_sales_target', '#total_modify_sales_target', 0, null);
        });

        // Changing Percentage
        $('.modify_sales_target_percentage').on('change', function() {
            var index = $('.modify_sales_target_percentage').index(this);
            var modify_sales_target_percentage = parseFloat($(this).val()) / 100;

            modifiedTragetPercentage(index, modify_sales_target_percentage);
        });

        function modifiedTragetPercentage(index, modify_sales_target_percentage) {
            var value = (modify_sales_target_percentage * parseFloat("<?php echo e($existing_items_target ?? 0); ?>"));
            $('.modify_sales_target').eq(index).val(value.toFixed(0));
            totalFunction('.modify_sales_target_percentage', '#total_modify_sales_target_percentage', 2, '%');
            totalFunction('.modify_sales_target', '#total_modify_sales_target', 0, null);
        }

        function totalFunction(field_name, total_field_name, decimals, characters = null) {
            total = 0;
            $(field_name).each(function(index, element) {

                if (element.value !== '') {
                    total = parseFloat(element.value) + total;
                }

            });
            if (characters === null) {
                total = total.toFixed(decimals);
            } else {
                total = total.toFixed(decimals) + ' %';

            }
            $(total_field_name).html(total);
        }
    </script>
<?php $__env->stopSection(); ?>
;

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast/existing_products_allocation_base.blade.php ENDPATH**/ ?>