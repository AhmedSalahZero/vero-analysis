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
        <li class="kt-menu__item  kt-menu__item" aria-haspopup="true"><a href="<?php echo e(route('forecast.report', $company)); ?>"
                class="kt-menu__link active-button"><span
                    class="kt-menu__link-text active-text"><?php echo e(__('Sales Target Dashboard')); ?></span></a>
        </li>
        <li class="kt-menu__item  kt-menu__item " aria-haspopup="true"><a
                href="<?php echo e(route('breakdown.forecast.report', $company)); ?>" class="kt-menu__link "><span
                    class="kt-menu__link-text"><?php echo e(__('Target Breakdown Dashboard')); ?></span></a>
        </li>
        <?php if((App\Models\CollectionSetting::where('company_id', $company->id)->first()) !== null): ?>)
            <li class="kt-menu__item  kt-menu__item " aria-haspopup="true"><a
                    href="<?php echo e(route('collection.forecast.report', $company)); ?>" class="kt-menu__link "><span
                        class="kt-menu__link-text"><?php echo e(__('Target Collection Dashboard')); ?></span></a>
            </li>
        <?php endif; ?>

    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--begin:: Widgets/Stats-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Sales Results')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-xl">
                
                <?php $__currentLoopData = $quarters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter_name => $quarter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="col-md-<?php echo e($quarter_name == 'Total' ? '4' : '2'); ?> col-lg-<?php echo e($quarter_name == 'Total' ? '4' : '2'); ?> col-xl-<?php echo e($quarter_name == 'Total' ? '4' : '2'); ?>">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__($quarter_name)); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-<?php echo e($quarter['color_class']); ?>">
                                    <?php echo e(number_format($quarter['value'] ?? 0)); ?>

                                </span>
                            </div>

                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-<?php echo e($quarter['color_class']); ?>" role="progressbar"
                                    style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="kt-widget24__action">
                                <span class="kt-widget24__change">

                                </span>
                                <span class="kt-widget24__number">

                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    <?php echo e(__('Products Sales Results')); ?>

                </h3>
            </div>
        </div>
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-xl">
                

                <div class="col-md-6 col-lg-6 col-xl-6">

                    <!--begin::New Orders-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title font-size">
                                    <?php echo e(__('New Product Items Sales Target')); ?>

                                </h4>

                            </div>
                        </div>
                        <div class="kt-widget24__details">
                            <span class="kt-widget24__stats kt-font-info">
                                <?php echo e(number_format($new_products_targets_data['value'] ?? 0) .' [ ' .number_format($new_products_targets_data['percentage'] ?? 2) .' % ]'); ?>

                            </span>
                        </div>

                        <div class="progress progress--sm">
                            <div class="progress-bar kt-bg-info" role="progressbar"
                                style="width: <?php echo e($new_products_targets_data['percentage']); ?>%;" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="<?php echo e($new_products_targets_data['percentage']); ?>"></div>
                        </div>
                        <div class="kt-widget24__action">
                            <span class="kt-widget24__change">

                            </span>
                            <span class="kt-widget24__number">

                            </span>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6">

                    <!--begin::New Orders-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <h4 class="kt-widget24__title font-size">
                                    <?php echo e(__('Existing Product Items Sales Target')); ?>

                                </h4>

                            </div>
                        </div>
                        <div class="kt-widget24__details">
                            <span class="kt-widget24__stats kt-font-info">
                                <?php echo e(number_format($existing_products_targets_data['value'] ?? 0) .' [ ' .number_format($existing_products_targets_data['percentage'] ?? 2) .' % ]'); ?>

                            </span>
                        </div>

                        <div class="progress progress--sm">
                            <div class="progress-bar kt-bg-info" role="progressbar"
                                style="width: <?php echo e($existing_products_targets_data['percentage']); ?>%;" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="<?php echo e($existing_products_targets_data['percentage']); ?>">
                            </div>
                        </div>
                        <div class="kt-widget24__action">
                            <span class="kt-widget24__change">

                            </span>
                            <span class="kt-widget24__number">

                            </span>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        <div class="col-md-12">
            <div class="kt-portlet ">

                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="kt-widget12__chart">
                                <h4> <?php echo e(__('Monthly Sales Values')); ?> </h4>
                                <div id="monthly_chartdiv" class="chartdashboard"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="kt-widget12__chart">
                                <!-- HTML -->
                                <h4> <?php echo e(__('Accumulated Sales Values')); ?> </h4>
                                <div id="accumulated_chartdiv" class="chartdashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
        $dates = array_column($chart_data['multi_chart'],'date');

        $accumulated_chart = $chart_data['accumulated_chart'] ;
        $gr = $chart_data['gr'] ;
        $month_sales_percentage = $chart_data['month_sales_percentage'] ;
        $sales_values = $chart_data['sales'];
        $accumulated_data = $chart_data['accumulated_data'];

    ?>
    
    <div class="row">
        
        <div class="col-md-12">
            <div class="kt-portlet ">

                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">


                                <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                    <?php $__env->slot('table_header'); ?>
                                        <tr class="table-active text-center">
                                            <th><?php echo e(__('Sales Value / Month')); ?></th>
                                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th><?php echo e(date('t-M-Y',strtotime($date))); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(__('Total Sales')); ?></td>

                                        </tr>
                                    <?php $__env->endSlot(); ?>
                                    <?php $__env->slot('table_body'); ?>
                                        <tr class="group-color text-lg-left  ">
                                            <td colspan="<?php echo e(count($dates) + 2); ?>"><b
                                                    class="white-text"><?php echo e(__('Monthly Sales')); ?></b></td>
                                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="hidden"> </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="hidden"> </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Sales Values')); ?></th>
                                            <?php $__currentLoopData = $sales_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td>
                                                    <?php echo e(number_format(($value ?? 0), 0 )); ?>

                                                    <span class="active-text-color"><b><?php echo e(' [ GR  ' . number_format($gr[$date] ?? 0, 1) . ' % ] '); ?></b></span>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(number_format(array_sum($sales_values))); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('Month Sales %')); ?></th>
                                            <?php $__currentLoopData = $month_sales_percentage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td>
                                                   <?php echo e(number_format($value ?? 0, 1) .' %'); ?></b></span>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(number_format(array_sum($month_sales_percentage)) .' %'); ?></td>
                                        </tr>
                                        <tr class="group-color text-lg-left  ">
                                            <td colspan="<?php echo e(count($dates) + 2); ?>"><b
                                                    class="white-text"><?php echo e(__('Accumulated Sales')); ?></b></td>
                                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="hidden"> </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="hidden"> </td>
                                        </tr>



                                        <tr>
                                            <th><?php echo e(__('Sales Values')); ?></th>
                                            <?php $__currentLoopData = $accumulated_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <td>
                                                    <?php echo e(number_format(($value ?? 0), 0 )); ?>

                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td>-</td>
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
                    </div>

                </div>
            </div>
        </div>

    </div>











    <input type="hidden" id="monthly_data" data-total="<?php echo e(json_encode($chart_data['multi_chart'] ?? [])); ?>">
    <input type="hidden" id="accumulated_data" data-total="<?php echo e(json_encode($chart_data['accumulated_chart'] ?? [])); ?>">
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

            // Increase contrast by taking evey second color
            chart.colors.step = 2;

            // Add data
            chart.data = $('#monthly_data').data('total');

            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.minGridDistance = 50;

            // Create series
            function createAxisAndSeries(field, name, opposite, bullet) {
                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                if (chart.yAxes.indexOf(valueAxis) != 0) {
                    valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
                }

                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = field;
                series.dataFields.dateX = "date";
                series.strokeWidth = 2;
                series.yAxis = valueAxis;
                series.name = name;
                series.tooltipText = "{name}: [bold]{valueY}[/]";
                series.tensionX = 0.8;
                series.showOnInit = true;

                var interfaceColors = new am4core.InterfaceColorSet();

                switch (bullet) {
                    case "triangle":
                        var bullet = series.bullets.push(new am4charts.Bullet());
                        bullet.width = 12;
                        bullet.height = 12;
                        bullet.horizontalCenter = "middle";
                        bullet.verticalCenter = "middle";

                        var triangle = bullet.createChild(am4core.Triangle);
                        triangle.stroke = interfaceColors.getFor("background");
                        triangle.strokeWidth = 2;
                        triangle.direction = "top";
                        triangle.width = 12;
                        triangle.height = 12;
                        break;
                    case "rectangle":
                        var bullet = series.bullets.push(new am4charts.Bullet());
                        bullet.width = 10;
                        bullet.height = 10;
                        bullet.horizontalCenter = "middle";
                        bullet.verticalCenter = "middle";

                        var rectangle = bullet.createChild(am4core.Rectangle);
                        rectangle.stroke = interfaceColors.getFor("background");
                        rectangle.strokeWidth = 2;
                        rectangle.width = 10;
                        rectangle.height = 10;
                        break;
                    default:
                        var bullet = series.bullets.push(new am4charts.CircleBullet());
                        bullet.circle.stroke = interfaceColors.getFor("background");
                        bullet.circle.strokeWidth = 2;
                        break;
                }

                valueAxis.renderer.line.strokeOpacity = 1;
                valueAxis.renderer.line.strokeWidth = 2;
                valueAxis.renderer.line.stroke = series.stroke;
                valueAxis.renderer.labels.template.fill = series.stroke;
                valueAxis.renderer.opposite = opposite;
            }
            $.each(chart.data[0], function(key, val) {
                if (key != 'date') {
                    createAxisAndSeries(key, key, true, "circle");
                }
            });



            // Add legend
            chart.legend = new am4charts.Legend();

            // Add cursor
            chart.cursor = new am4charts.XYCursor();


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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/forecast_summary_reports/dashboard.blade.php ENDPATH**/ ?>