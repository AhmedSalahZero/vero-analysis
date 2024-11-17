
<?php $__env->startSection('css'); ?>

<style>
    table {
        white-space: nowrap;
        table-layout: auto;
        border-collapse: collapse;
        width: 100%;
    }

    table td {
        border: 1px solid #ccc;
        color: gr
    }

    table .absorbing-column {
        width: 100%;
    }

</style>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />



<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        /* color:#595d6e ; */
    }

    table.dataTable tbody tr.group-color>.dtfc-fixed-left,
    table.dataTable tbody tr.group-color>.dtfc-fixed-right {
        background-color: #086691 !important;
    }


    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        font-weight: bold;
        color: black;
    }

    thead * {
        text-align: center !important;
    }

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
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">

                <li class="nav-item ">
                    <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                        <i class="flaticon2-checking"></i>Reports Table
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <div id="chartdiv"></div>
            <!--End:: Tab  EGP FX Rate Table -->
            <!--Begin:: Tab USD FX Rate Table -->
            <div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                 <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($view_name.' Report'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                    <tr class="table-active text-center">
                        <th class="text-center absorbing-column"><?php echo e(__('Product Item')); ?></th>
                        
                        <th><?php echo e($firstReportData['first_report_date']); ?></th>
                        <th><?php echo e($secondReportData['full_date']); ?></th>
                        
                        
                        <th><?php echo e(__('Growth Rate %')); ?></th>
                    </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                    <?php
                    $id = 0 ;
					$firstAllTotal = 0 ;
					$secondAllTotal = 0 ;
                    ?>
                    <?php $__currentLoopData = $mainItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainItemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="group-color ">

                        <td class="white-text" style="cursor: pointer;" onclick="toggleRow('<?php echo e($id); ?>')">
                            <i class="row_icon<?php echo e($id); ?> flaticon2-up white-text"></i>
                            <b><?php echo e(__($mainItemName)); ?></b>
                        </td>
                        <td class="text-center white-text">
                            <?php
                            $firstTotal = isset($report_data[$mainItemName]) ? sum_all_array_values($report_data[$mainItemName]) : 0 ;
							$firstAllTotal += $firstTotal ; 

                            ?>
                            <?php echo e(number_format($firstTotal)); ?>

                        </td>

                        <td class="text-center white-text">
                            <?php
                            $secondTotal = isset($secondReportData['report_data'][$mainItemName]) ? sum_all_array_values($secondReportData['report_data'][$mainItemName]) : 0 ;
							$secondAllTotal += $secondTotal ; 
							
                            ?>
                            <?php echo e(number_format($secondTotal)); ?>

                        </td>

                        <td class="text-center white-text"><?php echo e($firstTotal ? number_format(    ($secondTotal - $firstTotal) / $firstTotal *100    , 2 ) . ' %' : __('NA')); ?> </td>
                    </tr>
                    <?php $__currentLoopData = $secondReportData['report_data'][$mainItemName]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secondItemName=>$vall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="row<?php echo e($id); ?>  text-center" style="display: none">
                        <td class="text-left"><b><?php echo e($secondItemName); ?></b></td>
                        <td class="text-center">
                            <?php
                            $firstReportTotalForItem = $report_data[$mainItemName][$secondItemName] ?? 0 ;
                            $secondReportTotalForItem = $vall ;
                            ?>
                            <span class="active-text-color"><b> <?php echo e(number_format($firstReportTotalForItem)); ?> </b></span>
                        </td>
                        <td class="text-center">
                            <span class="active-text-color"><b> <?php echo e(number_format($secondReportTotalForItem)); ?> </b></span>
                        </td>
                        <td><?php echo e($firstReportTotalForItem ? number_format(    ($secondReportTotalForItem - $firstReportTotalForItem) / $firstReportTotalForItem *100   , 2 ) . ' %' : __('NA')); ?> </td>
                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $id++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					
					   <tr class="active-style text-center">
                                        <td class="active-style text-center" ><b><?php echo e(__('Total')); ?></b></td>
                

                    <td class="text-center active-style">
                        <?php echo e(number_format($firstAllTotal)); ?>

						</td>
						  <td class="text-center active-style">
                        <?php echo e(number_format($secondAllTotal)); ?>

						</td>
                  
						<?php
							$finalGrowthRate = $firstAllTotal ? ($secondAllTotal - $firstAllTotal) / $firstAllTotal * 100 : 0 ;
						?>
                    <td class="text-center active-style"><?php echo e(number_format(  $finalGrowthRate ,2)); ?> %</td>
                    </tr>


                    <?php $__env->endSlot(); ?>
                 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 


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




<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>
<script>
    function toggleRow(rowNum) {
        $(".row" + rowNum).toggle();
        $('.row_icon' + rowNum).toggleClass("flaticon2-down flaticon2-up");
    }

</script>
<?php $__currentLoopData = $Items_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name_of_sales_channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/second_comparing_analysis.blade.php ENDPATH**/ ?>