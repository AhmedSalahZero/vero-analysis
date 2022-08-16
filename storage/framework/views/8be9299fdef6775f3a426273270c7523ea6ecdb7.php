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

    

    <!--begin: Datatable -->

    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination ']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
            <tr class="table-active text-center">
                <?php $main_type_name = ucwords(str_replace('_', ' ', $main_type)); ?>
                <th><?php echo e(__($main_type_name) . ' / ' . __(ucwords(str_replace('_', ' ', $type)))); ?></th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e(__($item)); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td><?php echo e(__('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></td>
                <?php if(isset($totals_sales_per_main_type)): ?>
                    <td><?php echo e(__((  'Discounts %'  ))); ?></td>
                <?php endif; ?>

            </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>
            <?php $total_per_item = []; ?>
            <?php $final_total = array_sum($items_totals);
            $final_percentage = $final_total == 0 ? 0 : (($final_total ?? 0) / $final_total) * 100; ?>
            <?php $__currentLoopData = $main_type_items_totals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_type_item_name => $main_item_total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th> <?php echo e(__($main_type_item_name)); ?> </th>

                    <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $value = $report_data[$main_type_item_name][$item] ?? 0;
                        $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100; ?>
                        <td class="text-center">
                                <?php echo e(number_format($value)); ?>

                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        <?php echo e(number_format($main_item_total)); ?>

                    </td>
                    <?php if(isset($totals_sales_per_main_type)): ?>
                        <td class="text-center">
                            <?php echo e(($totals_sales_per_main_type[$main_type_item_name]??0) ==0 ?  0  : number_format((($main_item_total/$totals_sales_per_main_type[$main_type_item_name] )*100) , 1) .' %'); ?>

                        </td>
                    <?php endif; ?>
                </tr>


                
                <tr class="secondary-row-color ">
                    <th> <?php echo e(__($main_type_item_name) .' %'); ?> </th>

                    <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $value = $report_data[$main_type_item_name][$item] ?? 0;
                        $percentage_per_value = $main_item_total == 0 ? 0 : ($value / $main_item_total) * 100; ?>
                        <td class="text-center">

                            <span  ><b> <?php echo e(number_format($percentage_per_value, 1) . ' %  '); ?></b></span>


                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $total_percentage = $final_total == 0 ? 0 : ($main_item_total / $final_total) * 100; ?>
                    <td class="text-center">
                        <span><b> <?php echo e(number_format($total_percentage, 1) . ' %  '); ?></b></span>
                    </td>
                    <?php if(isset($totals_sales_per_main_type)): ?>
                        <td class="text-center">-</td>
                    <?php endif; ?>
                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__('Total')); ?> </th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="text-center">
                        <?php echo e(number_format($items_totals[$item_name] ?? 0)); ?>

                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td><?php echo e(number_format($final_total)); ?>

                    
                </td>
                <?php if(isset($totals_sales_per_main_type)): ?>
                    <td class="text-center">-</td>
                <?php endif; ?>
            </tr>


            <tr class="table-active text-center">
                <th class="text-center"> <?php echo e(__(ucwords(str_replace('_', ' ', $type))) . ' % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?> </th>
                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $items_percentage = $final_total == 0 ? 0 : (($items_totals[$item_name] ?? 0) / $final_total) * 100; ?>
                    <td class="text-center">
                        <b> <?php echo e(number_format($items_percentage, 1) . ' %'); ?></b>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td><b><?php echo e(number_format($final_percentage, 1) . ' %'); ?></b></td>
                <?php if(isset($totals_sales_per_main_type)): ?>
                    <td>-</td>
                <?php endif; ?>

            </tr>
            <?php if(isset($totals_sales_per_main_type)): ?>
                <tr class="table-active text-center">
                    <th class="text-center"> <?php echo e(__(ucwords(str_replace('_', ' ', $type))) . ' % / Sales'); ?> </th>
                    <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $items_percentage = $total_sales == 0 ? 0 : (($items_totals[$item_name] ?? 0) / $total_sales) * 100; ?>
                        <td class="text-center">
                            <b> <?php echo e(number_format($items_percentage, 1) . ' %'); ?></b>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <td><b><?php echo e(number_format((( $total_sales == 0 ? 0 : ($final_total/$total_sales) * 100)), 1) . ' %'); ?></b></td>
                    <td class="text-center">-</td>
                </tr>
            <?php endif; ?>
        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

    <!--end: Datatable -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/two_dimensional_breakdown/sales_report.blade.php ENDPATH**/ ?>