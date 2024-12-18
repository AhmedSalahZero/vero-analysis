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
<?php $__env->startSection('dash_nav'); ?>
<?php echo $__env->make('client_view.home_dashboard.main_navs' , ['active'=>'sales_dashboard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
// $dates = [ ];
// $report_data = []

?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title head-title text-primary">
                <?php echo e(__('Dashboard Results')); ?>

            </h3>
        </div>
    </div>
    
    <div class="kt-portlet__body">
        <form action="<?php echo e(route('dashboard',$company)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group row">
                <div class="col-md-5">
                    <label><?php echo e(__('Start Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date" required value="<?php echo e($start_date); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <label><?php echo e(__('End Date')); ?></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date" required value="<?php echo e($end_date); ?>" max="<?php echo e(date('Y-m-d')); ?>" class="form-control" placeholder="Select date" />
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
            
            <div class="col-md-6 col-lg-4 col-xl-4">
                <!--begin::New Orders-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Day Sales')); ?> <span > : <?php echo e($end_date ?  \Carbon\Carbon::make($end_date)->format('d-M-Y') : ''); ?>

                                    <br>
                                </span>
                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-dark">
                            <?php echo e(number_format($daySales)); ?>

                            
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-dark" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
            
            <div class="col-md-6 col-lg-4 col-xl-4">

                <!--begin::New Orders-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            
                            <h4 class="kt-widget24__title font-size">


                                <?php echo e(__('Current Month')); ?> :
                                <?php echo e(\Carbon\Carbon::make($end_date)->format('M - Y')); ?>

                                
                                

                            </h4>

                            

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-danger">
                            <?php echo e(number_format($currentMonthSales)); ?>

                            
                            
                        </span>
                    </div>

                    <?php
                        // $current_month = $sales_value_data['current_month'] !== '-' ? $sales_value_data['current_month'] : 0;
                        // $previous_month = $sales_value_data['previous_month'] !== '-' ? $sales_value_data['previous_month'] : 0;
                        // $percentage = $previous_month == 0 ? 0 : number_format((($current_month - $previous_month) / $previous_month) * 100);
                        ?>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-danger" role="progressbar" style="width: <?php echo e($percentage); ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">
                            <?php echo e(__('Change')); ?>

                        </span>
                        <span class="kt-widget24__number">
                            
                            
                            <?php echo e(number_format($percentage , 2)); ?> %
                        </span>
                    </div>
                </div>

                <!--end::New Orders-->
            </div>
            
            <div class="col-md-6 col-lg-4 col-xl-4">

                <!--begin::New Users-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Year To Date Sales')); ?>

                                (<?php echo e($yearOfEndDate =  \Carbon\Carbon::make($end_date)->startOfMonth()->subMonth(1)->format('Y')); ?>)

                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-success">
                            <?php echo e(number_format($salesToDate)); ?>

                            
                            
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">

                    </div>
                </div>

                <!--end::New Users-->
            </div>
            
            <div class="col-md-6 col-lg-6 col-xl-6">

                <!--begin::Total Profit-->
                <div class="kt-widget24 text-center">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">

                            
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Previous 3 Months')); ?> : ( <?php echo e(\Carbon\Carbon::make($end_date)->startOfMonth()->subMonth(3)->format('M') 
                                    . ' - ' . \Carbon\Carbon::make($end_date)->startOfMonth()->subMonth(2)->format('M') . ' - ' .
                                     \Carbon\Carbon::make($end_date)->startOfMonth()->subMonth(1)->format('M')); ?> )

                                (<?php echo e($yearOfEndDate); ?>)

                            </h4>
                            

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-brand">
                            
                        
                        <?php echo e(number_format($perviousThreeMonthsSales)); ?>

                        </span>
                    </div>

                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">

                        </span>
                        <span class="kt-widget24__number">

                        </span>
                    </div>
                </div>

                <!--end::Total Profit-->
            </div>
            
            <div class="col-md-6 col-lg-6 col-xl-6">

                <!--begin::New Feedbacks-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Previous Month')); ?> : ( <?php echo e(\Carbon\Carbon::make($end_date)->startOfMonth()->subMonth(1)->format('M')); ?> ) (<?php echo e($yearOfEndDate ?? ''); ?>)
                            </h4>
                            
                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-warning">
                            <span class="text-red"></span>
                            <?php echo e(number_format($previous_month_sales)); ?>

                            
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">

                        </span>
                        <span class="kt-widget24__number">

                        </span>
                    </div>
                </div>

                <!--end::New Feedbacks-->
            </div>
        </div>
    </div>
</div>
<!--end:: Widgets/Stats-->

<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Sales Trend Analysis Charts')); ?>

                    </h3>
                </div>
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


<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet ">

            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__head kt-portlet__head--lg">
                                    <div class="kt-portlet__head-label">
                                        <span class="kt-portlet__head-icon">
                                            <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                                        </span>
                                        <h3 class="kt-portlet__head-title">

                                            <?php echo e(__('Monthly And Accumulated Sales Table')); ?>


                                            
                                        </h3>
                                    </div>

                                </div>
                            </div>

                             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['fixedColumns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>

                                <?php $__env->slot('table_header'); ?>
                                <?php $tableHeader = $monthlyChartArr[array_key_first($monthlyChartArr)] ?? [] ?>
                                <tr class="table-active text-center">
                                    <th><?php echo e(__('Sales Value / Month')); ?></th>
                                    <?php $__currentLoopData = $tableHeader; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($date); ?></th>
                                    <?php if($loop->last): ?>
                                    <td><?php echo e(__('Total Sales')); ?></td>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <?php $__env->endSlot(); ?>
                                <?php array_shift($monthlyChartArr) ?>
                                <?php $__env->slot('table_body'); ?>
                                <?php $__currentLoopData = $monthlyChartArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($values) && is_null($values[0])): ?>

                                <tr class="group-color  table-active text-lg-left  ">
                                    <td colspan="<?php echo e(count($values) + 2); ?>"><b class="white-text"><?php echo e(__($title)); ?></b></td>
                                    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="hidden"> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="hidden"> </td>
                                </tr>
                                <?php else: ?>

                                <tr class=" text-lg-left  ">
                                    <td><b class=""><?php echo e(__($title)); ?></b></td>
                                    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td> <?php echo $val; ?> </td>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="hidden"> </td>
                                </tr>

                                <?php endif; ?>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__env->endSlot(); ?>
                             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 







                            

                            <input type="hidden" id="monthly_data" data-total="<?php echo e(json_encode($formattedDataForChart ?? [])); ?>">
                            <input type="hidden" id="accumulated_data" data-total="<?php echo e(json_encode($monthlyChartCumulative ?? [])); ?>">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/home_dashboard/dashboard.blade.php ENDPATH**/ ?>