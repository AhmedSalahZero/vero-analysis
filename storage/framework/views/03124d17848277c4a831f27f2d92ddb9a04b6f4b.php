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
    

    <?php echo $__env->make('datatable_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                            <i class="flaticon2-checking"></i>Reports Table
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content  kt-margin-t-20">

                <!--Begin:: Tab  EGP FX Rate Table -->
                    <?php
                    array_push($zones_names, 'Total');
                    array_push($zones_names, 'Zone_Sales_Percentages');
                    ?>
                
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
                                <th class="text-center absorbing-column"><?php echo e(__($type_name)); ?></th>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__('Total')); ?></th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
                            <?php $id =1 ;?>
                            <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone_name => $zone_channels_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php $chart_data = [];?>

                                <?php if($zone_name != 'Total' && $zone_name != 'Discount % / Total Sales'): ?>
                                    <?php
                                    // $row_name = str_replace(' ', '_', $zone_name);
                                    // $row_name = str_replace(['&','(',')','{','}'], '_', $row_name);
                                    ?>

                                    <tr class="group-color">
                                        <td class="white-text"  style="cursor: pointer;" onclick="toggleRow('<?php echo e($id); ?>')">
                                            <i class="row_icon<?php echo e($id); ?> flaticon2-up white-text"></i>
                                            <b><?php echo e(__($zone_name)); ?></b>
                                        </td>
                                        
                                        <?php $total_per_zone = $zone_channels_data['Total'] ?? [];
                                        unset($zone_channels_data['Total']); ?>
                                        


                                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $growth_rate_per_zone = ($report_data['Total'][$date]??0) == 0 ? 0 :(($total_per_zone[$date] ?? 0) /( ($report_data['Total'][$date]??0))*100); ?>

                                            <td class="text-center white-text"><?php echo e(number_format($total_per_zone[$date] ?? 0) . '  [ Dist '.number_format($growth_rate_per_zone ,1) . ' % ]'); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center white-text"><?php echo e(number_format(array_sum($total_per_zone??[]),0)); ?></td>
                                    </tr>
                                    <?php $__currentLoopData = $zone_channels_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel_name => $channel_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php $__currentLoopData = $channel_section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $channel_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="row<?php echo e($id); ?> <?php echo e(($section == 'Perc.% / Sales') ? 'secondary-row-color' : ''); ?> text-center"
                                                style="display: none">
                                                
                                                <?php $name_ofdiscount = ucwords(str_replace('_',' ' ,$channel_name)) ?>
                                                <td class="text-left"><b><?php echo e($name_ofdiscount . ' ' . $section); ?></b></td>
                                                <?php
                                                    $decimals = ($section == 'Perc.% / Sales') ? 2 : 0;

                                                ?>
                                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $result = ($section == 'Perc.% / Sales') ?(($channel_data[$date] ?? 0)*100) : ($channel_data[$date] ?? 0);
                                                    ?>
                                                    <td class="text-center">
                                                        <?php echo e(number_format($result, $decimals) . ($decimals == 0 ? '' : ' %')); ?>

                                                    </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(($section == 'Perc.% / Sales') ? '-' : number_format(array_sum($channel_data??[]),0)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




















                                <?php elseif($zone_name == 'Total' || $zone_name == 'Discount % / Total Sales'): ?>
                                    <tr class="active-style text-center">
                                        <td class="active-style text-center" ><b><?php echo e(__($zone_name)); ?></b></td>
                                       

                                        <?php
                                            $decimals =  $zone_name == 'Discount % / Total Sales'  ? 1 : 0;

                                        ?>
                                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $result = $zone_name == 'Discount % / Total Sales' ?(($zone_channels_data[$date] ?? 0)*100) : ($zone_channels_data[$date] ?? 0);
                                            ?>
                                            <td class="text-center active-style">
                                                <?php echo e(number_format($result,$decimals)  . ($decimals == 0 ? '' : ' %')); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center active-style"><?php echo e($zone_name == 'Growth Rate %' ? "-" : number_format(array_sum($zone_channels_data  ?? []),0)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php $id++;?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>

                    
                </div>
                <!--End:: Tab USD FX Rate Table -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Resources -->
    
    
    
    
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
    <script>
        function toggleRow(rowNum) {
            $(".row" + rowNum).toggle();
            $('.row_icon' + rowNum).toggleClass("flaticon2-down flaticon2-up");
        }
    </script>
    <?php $__currentLoopData = $zones_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name_of_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance

                var chart = am4core.create("<?php echo e($name_of_zone); ?>_count_chartdiv", am4charts.XYChart);

                // Increase contrast by taking evey second color
                chart.colors.step = 2;

                // Add data
                chart.data = $('#<?php echo e($name_of_zone); ?>_data').data('total');
                if ("<?php echo e($name_of_zone); ?>" == 'Zone_Sales_Percentages') {
                    console.log($('#<?php echo e($name_of_zone); ?>_data').data('total'));
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/sales_discounts_analysis_report.blade.php ENDPATH**/ ?>