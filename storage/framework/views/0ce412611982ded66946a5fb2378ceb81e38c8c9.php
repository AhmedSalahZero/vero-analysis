<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs',['active'=>'discount_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title head-title text-primary">
                <?php echo e(__('Dashboard Results')); ?>

            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <form action="<?php echo e(route('dashboard.salesDiscount',$company)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group row">
                <div class="col-md-5">
                    <label><?php echo e(__('Start Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date" required value="<?php echo e($start_date); ?>"
                                max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <label><?php echo e(__('End Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date"  required value="<?php echo e($end_date); ?>"
                                max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label> </label>
                    <div class="kt-input-icon">
                        <button type="submit" class="btn active-style"><?php echo e(__('Submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    
    <div class="row">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Sales Discounts Breakdown Analysis')); ?>

                        </h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->

                    <!-- HTML -->
                    <div id="chartdiv" class="chartDiv"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <!--begin: Datatable -->


                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">
                                <th>#</th>
                                <th><?php echo e(__('Sales Discount')); ?></th>
                                <th><?php echo e(__('Discount Values')); ?></th>
                                <th><?php echo e(__('Percentages %')); ?></th>

                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $total = array_sum(array_column($sales_discount_bd,'Sales Value')) ?>
                            <?php $__currentLoopData = $sales_discount_bd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th><?php echo e($key+1); ?></th>
                                <th><?php echo e($item['item']?? '-'); ?></th>
                                <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                                <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($item['Sales Value']/$total)*100) , 1) . ' %'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-active text-center">
                                <th colspan="2"><?php echo e(__('Total')); ?></th>
                                <td class="hidden"></td>
                                <td><?php echo e(number_format($total)); ?></td>
                                <td>100 %</td>
                            </tr>
                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <input type="hidden" id="total" data-total="<?php echo e(json_encode($sales_discount_bd)); ?>">
    </div>

    
    <div class="row">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Sales Channels Versus Discounts')); ?>

                        </h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active text-center">

                                <th><?php echo e(__('Sales Channel / Discounts')); ?></th>
                                <?php

                                    $all_items = $sales_channels_discounts['all_items'];
                                    $items_totals = $sales_channels_discounts['items_totals'];
                                    $report_data = $sales_channels_discounts['report_data'];
                                    $main_type_items_totals = $sales_channels_discounts['main_type_items_totals'];
                                    $totals_sales_per_main_type = $sales_channels_discounts['totals_sales_per_main_type'];
                                    $total_sales = $sales_channels_discounts['total_sales'];
                                ?>
                                <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(__($item)); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e(__('Total Discounts')); ?></td>
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

                                    <b><?php echo e(' [ ' . number_format($final_percentage, 1) . ' % ] '); ?></b>
                                </td>
                                <?php if(isset($totals_sales_per_main_type)): ?>
                                    <td class="text-center">-</td>
                                <?php endif; ?>
                            </tr>


                            <tr class="table-active text-center">
                                <th class="text-center"> <?php echo e(__('Discounts % / Total Discounts')); ?> </th>
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
                                    <th class="text-center"> <?php echo e(__('Discounts % / Sales')); ?> </th>
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
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        // Add data
        chart.data = $('#total').data('total');
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "Sales Value";
        pieSeries.dataFields.category = "item";
        pieSeries.innerRadius = am4core.percent(50);
        // arrow
        pieSeries.ticks.template.disabled = true;
        //number
        pieSeries.labels.template.disabled = true;

        var rgm = new am4core.RadialGradientModifier();
        rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
        pieSeries.slices.template.fillModifier = rgm;
        pieSeries.slices.template.strokeModifier = rgm;
        pieSeries.slices.template.strokeOpacity = 0.4;
        pieSeries.slices.template.strokeWidth = 0;

        chart.legend = new am4charts.Legend();
        chart.legend.position = "right";
    chart.legend.scrollable = true;

    }); // end am4core.ready()
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/home_dashboard/dashboard_salesDiscount.blade.php ENDPATH**/ ?>