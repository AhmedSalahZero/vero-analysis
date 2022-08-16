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
<?php $__env->startSection('dash_nav'); ?>
    <ul class="kt-menu__nav ">

        <li class="kt-menu__item  kt-menu__item " aria-haspopup="true"><a href="<?php echo e(route('forecast.report', $company)); ?>"
                class="kt-menu__link "><span class="kt-menu__link-text"><?php echo e(__('Sales Target Dashboard')); ?></span></a>
        </li>
        <li class="kt-menu__item  kt-menu__item " aria-haspopup="true"><a
                href="<?php echo e(route('breakdown.forecast.report', $company)); ?>" class="kt-menu__link "><span
                    class="kt-menu__link-text"><?php echo e(__('Target Breakdown Dashboard')); ?></span></a>
        </li>

        <li class="kt-menu__item  kt-menu__item" aria-haspopup="true"><a
                href="<?php echo e(route('collection.forecast.report', $company)); ?>" class="kt-menu__link active-button"><span
                    class="kt-menu__link-text active-text"><?php echo e(__('Target Collection Dashboard')); ?></span></a>

    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



    
    <div class="row">
        
        <div class="col-md-12">
            <div class="kt-portlet ">

                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="kt-widget12__chart">
                                <h4> <?php echo e(__('Monthly Collection Values')); ?> </h4>
                                <div  id="monthly_chartdiv" class="chartdashboard"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="kt-widget12__chart">
                                <!-- HTML -->
                                <h4> <?php echo e(__('Accumulated Collection Values')); ?> </h4>
                                <div id="accumulated_chartdiv" class="chartdashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    $monthly_chart_data = [];
    $accumulated_chart_data = [];
    $accumulated_value = 0;
    ?>
    
    <div class="row">
        
        <div class="col-md-12">
            <div class="kt-portlet ">

                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                                <?php $collection_base = ucwords(str_replace('_', ' ', $collection_settings->collection_base)); ?>
                                
                                <?php if($collection_settings->collection_base == 'general_collection_policy'): ?>
                                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($collection_base.' Collection Policy'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                        <?php $__env->slot('table_header'); ?>
                                            <tr class="table-active text-center">
                                                <th><?php echo e(__('Collection / Months')); ?></th>
                                                <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <th> <?php echo e(__('Total Year')); ?> </th>
                                            </tr>
                                        <?php $__env->endSlot(); ?>
                                        <?php $__env->slot('table_body'); ?>
                                            <tr>
                                                <td><b><?php echo e(__('Collection')); ?></b></td>
                                                <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="text-center"> <?php echo e(number_format($collection[$date] ?? 0)); ?>

                                                    </td>
                                                    <?php
                                                    $accumulated_value += $collection[$date] ?? 0;
                                                    $monthly_chart_data[] = [
                                                        'date' => date('d-M-Y', strtotime($date)),
                                                        'price' => number_format($collection[$date] ?? 0, 0),
                                                    ];
                                                    $accumulated_chart_data[] = [
                                                        'date' => date('d-M-Y', strtotime($date)),
                                                        'price' => number_format($accumulated_value, 0),
                                                    ];
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center active-style"><?php echo e(number_format(array_sum($collection))); ?></td>
                                            </tr>
                                        <?php $__env->endSlot(); ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($collection_base.' Collection Policy'),'tableClass' => 'kt_table_with_no_pagination_no_scroll']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                        <?php $__env->slot('table_header'); ?>
                                            <tr class="table-active text-center">
                                                <th><?php echo e(__($collection_base . ' / Months')); ?></th>
                                                <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th><?php echo e(date('M-Y', strtotime($date))); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <th> <?php echo e(__('Total Year')); ?> </th>
                                            </tr>
                                        <?php $__env->endSlot(); ?>
                                        <?php $__env->slot('table_body'); ?>
                                            <?php $total = []; ?>
                                            <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $base_name => $base_collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td> <b> <?php echo e($base_name); ?> </b></td>
                                                    <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $total[$date] = ($base_collection[$date] ?? 0) + ($total[$date] ?? 0); ?>
                                                        <td class="text-center"> <?php echo e(number_format($base_collection[$date] ?? 0)); ?>

                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="text-center active-style"><?php echo e(number_format(array_sum($base_collection))); ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="active-style"> <b> <?php echo e(__('Total')); ?> </b></td>
                                                <?php $__currentLoopData = $monthly_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="active-style"><?php echo e(number_format($total[$date] ?? 0)); ?></td>
                                                    <?php
                                                    $accumulated_value += $total[$date] ?? 0;
                                                    $monthly_chart_data[] = [
                                                        'date' => date('d-M-Y', strtotime($date)),
                                                        'price' => number_format($total[$date] ?? 0, 0),
                                                    ];
                                                    $accumulated_chart_data[] = [
                                                        'date' => date('d-M-Y', strtotime($date)),
                                                        'price' => number_format($accumulated_value, 0),
                                                    ];
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center active-style"><?php echo e(number_format(array_sum($total))); ?></td>
                                            </tr>
                                        <?php $__env->endSlot(); ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="monthly_data" data-total="<?php echo e(json_encode($monthly_chart_data ?? [])); ?>">
    <input type="hidden" id="accumulated_data" data-total="<?php echo e(json_encode($accumulated_chart_data ?? [])); ?>">





<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <script>
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            var chart = am4core.create("monthly_chartdiv", am4charts.XYChart);

            // Add data
            chart.data = $('#monthly_data').data('total');

            // Set input format for the dates
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";


            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

            // Create series
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = "price";
            series.dataFields.dateX = "date";
            series.tooltipText = "{price}"
            series.strokeWidth = 2;
            series.minBulletDistance = 5;

            // Drop-shaped tooltips
            series.tooltip.background.cornerRadius = 20;
            series.tooltip.background.strokeOpacity = 0;
            series.tooltip.pointerOrientation = "vertical";
            series.tooltip.label.minWidth = 40;
            series.tooltip.label.minHeight = 40;
            series.tooltip.label.textAlign = "middle";
            series.tooltip.label.textValign = "middle";

            // Make bullets grow on hover
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.strokeWidth = 2;
            bullet.circle.radius = 4;
            bullet.circle.fill = am4core.color("#fff");

            var bullethover = bullet.states.create("hover");
            bullethover.properties.scale = 1.3;

            // Make a panning cursor
            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "panXY";
            chart.cursor.xAxis = dateAxis;
            chart.cursor.snapToSeries = series;
            valueAxis.cursorTooltipEnabled = false;

            // Create vertical scrollbar and place it before the value axis
            chart.scrollbarY = new am4core.Scrollbar();
            chart.scrollbarY.parent = chart.leftAxesContainer;
            chart.scrollbarY.toBack();

            // Create a horizontal scrollbar with previe and place it underneath the date axis
            chart.scrollbarX = new am4charts.XYChartScrollbar();
            chart.scrollbarX.series.push(series);
            chart.scrollbarX.parent = chart.bottomAxesContainer;

            dateAxis.start = 0.0005;
            dateAxis.keepSelection = true;


        }); // end am4core.ready()
    </script>

    <script>
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            var chart = am4core.create("accumulated_chartdiv", am4charts.XYChart);

            // Add data
            chart.data = $('#accumulated_data').data('total');

            // Set input format for the dates
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";


            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

            // Create series
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = "price";
            series.dataFields.dateX = "date";
            series.tooltipText = "{price}"
            series.strokeWidth = 2;
            series.minBulletDistance = 5;

            // Drop-shaped tooltips
            series.tooltip.background.cornerRadius = 20;
            series.tooltip.background.strokeOpacity = 0;
            series.tooltip.pointerOrientation = "vertical";
            series.tooltip.label.minWidth = 40;
            series.tooltip.label.minHeight = 40;
            series.tooltip.label.textAlign = "middle";
            series.tooltip.label.textValign = "middle";

            // Make bullets grow on hover
            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.strokeWidth = 2;
            bullet.circle.radius = 4;
            bullet.circle.fill = am4core.color("#fff");

            var bullethover = bullet.states.create("hover");
            bullethover.properties.scale = 1.3;

            // Make a panning cursor
            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "panXY";
            chart.cursor.xAxis = dateAxis;
            chart.cursor.snapToSeries = series;
            valueAxis.cursorTooltipEnabled = false;

            // Create vertical scrollbar and place it before the value axis
            chart.scrollbarY = new am4core.Scrollbar();
            chart.scrollbarY.parent = chart.leftAxesContainer;
            chart.scrollbarY.toBack();

            // Create a horizontal scrollbar with previe and place it underneath the date axis
            chart.scrollbarX = new am4charts.XYChartScrollbar();
            chart.scrollbarX.series.push(series);
            chart.scrollbarX.parent = chart.bottomAxesContainer;

            dateAxis.start = 0.0005;
            dateAxis.keepSelection = true;


        }); // end am4core.ready()
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast_summary_reports/collection_dashboard.blade.php ENDPATH**/ ?>