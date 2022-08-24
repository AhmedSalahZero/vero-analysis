<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__($view_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <?php if(session('warning')): ?>
                <div class="alert alert-warning">
                    <ul>
                        <li><?php echo e(session('warning')); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>



    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                </span>
                <h3 class="kt-portlet__head-title">

                    <b> <?php echo e(__('From : ')); ?> </b><?php echo e($dates['start_date']); ?>

                    <b> - </b>
                    <b> <?php echo e(__('To : ')); ?></b> <?php echo e($dates['end_date']); ?>

                    <br>

                    <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b> <?php echo e($last_date); ?></span>

                </h3>
            </div>

        </div>
    </div>

    

    <!--Sales Values Table -->

    

    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Sales Values Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th><?php echo e(__($main_type_name) . ' / ' . __('Customers Natures')); ?></th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($item)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e(__('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>
                <th><?php echo e(__('% / Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>
                <th><?php echo e(__('Stop')); ?></th>
                <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <th><?php echo e(__('Dead')); ?></th>
                <th><?php echo e(__('% / '.$main_type_name)); ?></th>
            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
            <?php $total_per_item = []; ?>
            <?php

                $dead_stop_totals = [ 'Stop' =>($items_totals_sales_values['Stop']??0), 'Dead' =>($items_totals_sales_values['Dead']??0)];
                unset($items_totals_sales_values['Dead']);
                unset($items_totals_sales_values['Stop']);
                $final_total = array_sum($items_totals_sales_values);
                $final_percentage = $final_total == 0 ? 0 : (($final_total ?? 0) / $final_total) * 100;
                $stop_and_dead = [];
            ?>

            <?php $__currentLoopData = $report_totals_sales_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_type_item_name => $main_item_total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                    <th> <?php echo e(__($main_type_item_name)); ?> </th>
                    <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $value = ($report_sales_values[$main_type_item_name][$item] ?? 0);
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;

                        ?>
                        <td class="text-center"> <?php echo e(number_format($value)); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        <?php echo e(number_format($main_item_total)); ?>

                    </td>
                    <td class="text-center">
                        <span class="active-text-color text-center"><b> <?php echo e(number_format($total_percentage, 1) . ' % '); ?></b></span>
                    </td>
                    <?php $items_after_total = ['Stop','Dead']; ?>
                    <?php $__currentLoopData = $items_after_total; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $value =( $report_sales_values[$main_type_item_name][$item] ?? 0);
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;
                        ?>
                        <td class="text-center"> <?php echo e(number_format($value)); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                        <?php echo e(number_format($items_totals_sales_values[$item_name] ?? 0)); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center"><?php echo e(number_format($final_total)); ?></td>
                <td class="text-center"><b><?php echo e(number_format($final_percentage, 1) . ' % '); ?></b></td>
                <?php $__currentLoopData = $dead_stop_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                        <?php echo e(number_format(($total ?? 0))); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e('Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?> </th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $items_percentage = $final_total == 0 ? 0 : (($items_totals_sales_values[$item_name] ?? 0) / $final_total) * 100; ?>
                    <td class="text-center">
                        <b> <?php echo e(number_format($items_percentage, 1) . ' %'); ?></b>
                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td><b><?php echo e(number_format($final_percentage, 1) . ' %'); ?></b></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

     <!--Counts Table -->











     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Counts Table'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $type)); ?>
                <th><?php echo e(__($main_type_name) . ' / ' . __('Customers Natures')); ?></th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($item)); ?></th>
                    <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e(__('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>
                <th><?php echo e(__('% / Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></th>
                <th><?php echo e(__('Stop')); ?></th>
                <th><?php echo e(__('% / '.$main_type_name)); ?></th>
                <th><?php echo e(__('Dead')); ?></th>
                <th><?php echo e(__('% / '.$main_type_name)); ?></th>
            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
            <?php $total_per_item = []; ?>
            <?php
                $dead_stop_totals = [ 'Stop' =>$items_totals_counts['Stop'] ?? 0, 'Dead' =>$items_totals_counts['Dead'] ?? 0];
                unset($items_totals_counts['Dead']);
                unset($items_totals_counts['Stop']);
                $final_total = array_sum($items_totals_counts);
                $final_percentage = $final_total == 0 ? 0 : (($final_total ?? 0) / $final_total) * 100;
            ?>

            <?php $__currentLoopData = $report_totals_counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_type_item_name => $main_item_total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th> <?php echo e(__($main_type_item_name)); ?> </th>
                    <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $value = $report_counts[$main_type_item_name][$item] ?? 0;
                        $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100; ?>
                        <td class="text-center"><?php echo e(number_format($value)); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        <?php echo e(number_format($main_item_total)); ?>


                    </td>
                    <td class="text-center">
                        <span class="active-text-color "><b> <?php echo e(number_format($total_percentage, 1) . ' % '); ?></b></span>
                    </td>
                    <?php $items_after_total = ['Stop','Dead']; ?>
                    <?php $__currentLoopData = $items_after_total; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $value = $report_counts[$main_type_item_name][$item] ?? 0;
                            $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100;

                        ?>
                        <td class="text-center"> <?php echo e(number_format($value)); ?></td>
                        <td class="text-center">
                            <span class="active-text-color "><b> <?php echo e(number_format($percentage_per_value, 1).' % '); ?></b></span>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                        <?php echo e(number_format($items_totals_counts[$item_name] ?? 0)); ?>

                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td><?php echo e(number_format($final_total)); ?>

                </td>
                <td>-</td>
                <?php $__currentLoopData = $dead_stop_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                        <?php echo e(number_format($total ?? 0)); ?>

                    </td>
                    <td class="text-center">
                        <b><?php echo e(number_format($final_percentage, 1) . ' % '); ?></b>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tr>
            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e('Nature % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Count'))); ?> </th>

                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $items_percentage = $final_total == 0 ? 0 : (($items_totals_counts[$item_name] ?? 0) / $final_total) * 100; ?>
                    <td class="text-center">
                        <b> <?php echo e(number_format($items_percentage, 1) . ' %'); ?></b>
                    </td>
                    <td class="text-center">
                        -
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td><b><?php echo e(number_format($final_percentage, 1) . ' %'); ?></b></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/customer_nature/two_dimensional_report.blade.php ENDPATH**/ ?>