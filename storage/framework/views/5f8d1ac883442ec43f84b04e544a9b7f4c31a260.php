<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
<style>
      table.dataTable thead tr > .dtfc-fixed-left, table.dataTable thead tr > .dtfc-fixed-right{
        background-color:#086691;
    }
    .dataTables_wrapper .dataTable th, .dataTables_wrapper .dataTable td{
        /* color:#595d6e ; */
    }
    table.dataTable tbody tr.group-color > .dtfc-fixed-left, table.dataTable tbody tr.group-color > .dtfc-fixed-right{
        background-color:#086691 !important;
    }
    
    
  .dataTables_wrapper .dataTable th, .dataTables_wrapper .dataTable td{
      color:#595d6e;
  }
    thead *{
        text-align:center !important;
    }
</style>

    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

        .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;}
    </style>
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

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1" role="tab">
                            <i class="flaticon-line-graph"></i> &nbsp; Charts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                            <i class="flaticon2-checking"></i>Reports Table
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content  kt-margin-t-20">

                <!--Begin:: Tab  EGP FX Rate Table -->
                <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                    <?php
                    array_push($sales_channels_names, 'Total');
                    array_push($sales_channels_names, 'Sales_Channel_Sales_Percentages');
                    ?>
                    <?php $__currentLoopData = $sales_channels_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name_of_sales_channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="col-xl-12">
                            <div class="kt-portlet kt-portlet--height-fluid">
                                <div class="kt-portlet__body kt-portlet__body--fluid">
                                    <div class="kt-widget12">
                                        <div class="kt-widget12__chart">
                                            <!-- HTML -->
                                            <h4><?php echo e(str_replace('_', ' ', $name_of_sales_channel) . ($name_of_sales_channel ==  "Sales_Channel_Sales_Percentages" ? ' Against Total Sales' : ' Sales Trend Analysis Chart')); ?>

                                            </h4>
                                            <div id="<?php echo e($name_of_sales_channel); ?>_count_chartdiv" class="chartdashboard"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!--End:: Tab  EGP FX Rate Table -->

                <!--Begin:: Tab USD FX Rate Table -->
                <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Sales Channel Sales Trend Analysis Report'),'tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active">
                                <th><?php echo e(__('Sales Channel')); ?></th>
                                <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $__currentLoopData = $final_report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sales_channel_name => $zoone_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $chart_data = []; ?>

                                <tr class="group-color text-lg-left  ">
                                    <td colspan="<?php echo e(count($total_sales_channels) + 1); ?>"><b
                                            class="white-text"><?php echo e(__($sales_channel_name)); ?></b>
                                    </td>
                                    <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="hidden"> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Sales Values')); ?></th>
                                    <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $chart_data[] = [
                                            'date' => date('d-M-Y', strtotime($date)),
                                            'Sales Value' => number_format($zoone_data['Sales Values'][$date] ?? 0),
                                            'Sales GR %' => number_format($zoone_data['Growth Rate %'][$date] ?? 0, 2),
                                        ]; ?>
                                        <td class="text-center">
                                            <?php echo e(number_format($zoone_data['Sales Values'][$date] ?? 0)); ?></td>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Growth Rate %')); ?></th>
                                    <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <?php echo e(number_format($zoone_data['Growth Rate %'][$date] ?? 0, 2) . ' %'); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <input type="hidden" id="<?php echo e(str_replace(' ', '_', $sales_channel_name)); ?>_data"
                                    data-total="<?php echo e(json_encode($chart_data)); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th class="active-style text-center"><?php echo e(__('TOTAL')); ?></th>
                                <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="text-center active-style"><?php echo e(number_format($total ?? 0)); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <tr>
                                <th class="active-style text-center"><?php echo e(__('GROWTH RATE %')); ?></th>
                                <?php $chart_data = []; ?>
                                <?php $__currentLoopData = $total_sales_channels_growth_rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $chart_data[] = [
                                        'date' => date('d-M-Y', strtotime($date)),
                                        'Total Sales Values' => number_format($total_sales_channels[$date] ?? 0),
                                        'Sales GR %' => number_format($total ?? 0, 2),
                                    ]; ?>
                                    <td class="text-center active-style"><?php echo e(number_format($total ?? 0, 2) . ' %'); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <input type="hidden" id="Total_data" data-total="<?php echo e(json_encode($chart_data)); ?>">

                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __('Sales Channel Sales Percentage (%) Against Total Sales'),'tableClass' => 'kt_table_with_no_pagination_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <?php $__env->slot('table_header'); ?>
                            <tr class="table-active">
                                <th><?php echo e(__('Sales Channel')); ?></th>


                                <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $chart_data = []; ?>
                            <?php $__currentLoopData = $final_report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sales_channel_name => $zoone_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="group-color text-lg-left  ">
                                    <td colspan="<?php echo e(count($total_sales_channels) + 1); ?>"><b
                                            class="white-text"><?php echo e(__($sales_channel_name)); ?></b></td>
                                    <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="hidden"> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('Percent %')); ?></th>
                                    <?php $__currentLoopData = $total_sales_channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $percentage = $total == 0 ? 0 : number_format((($zoone_data['Sales Values'][$date] ?? 0) / ($total ?? 0) *100), 2);
                                        $chart_data[$date][$sales_channel_name] = [$sales_channel_name . ' %' => $percentage, ];
                                        ?>

                                        <td class="text-center">
                                            <?php echo e($percentage . ' %'); ?>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $return = array();
                                array_walk($chart_data, function($values,$date) use (&$return) {
                                    $return[] =array_merge(['date'=>date('d-M-Y', strtotime($date))], array_merge(...array_values($values)));
                                });
                            ?>
                            <input type="hidden" id="Sales_Channel_Sales_Percentages_data" data-total="<?php echo e(json_encode($return)); ?>">


                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>


                             <?php echo $__env->make('seasonality_table' , ['total_branches'=>$total_sales_channels , 'totalArrys'=>[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                </div>
                <!--End:: Tab USD FX Rate Table -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
 



    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <?php $__currentLoopData = $sales_channels_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name_of_sales_channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance

                var chart = am4core.create("<?php echo e($name_of_sales_channel); ?>_count_chartdiv", am4charts.XYChart);

                // Increase contrast by taking evey second color
                chart.colors.step = 2;

                // Add data
                chart.data = $('#<?php echo e($name_of_sales_channel); ?>_data').data('total');
                if("<?php echo e($name_of_sales_channel); ?>"== 'Sales_Channel_Sales_Percentages'){
                    console.log($('#<?php echo e($name_of_sales_channel); ?>_data').data('total'));
                }
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


        

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/salesChannels_sales_report.blade.php ENDPATH**/ ?>