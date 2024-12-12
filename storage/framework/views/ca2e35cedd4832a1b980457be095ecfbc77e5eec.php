
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .chartdiv {
        width: 100% !important;
        height: 500px !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__($view_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <?php $intervals = ['First'=>'_one', 'Second' => '_two']; ?>
    <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval_name => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="col-md-6">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <b> <?php echo e(__('From : ')); ?> </b><?php echo e($dates['start_date'.$name]); ?>

                        <b> - </b>
                        <b> <?php echo e(__('To : ')); ?></b> <?php echo e($dates['end_date'.$name]); ?>

                        <br>

                        <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b> <?php echo e($last_date); ?></span>
                        <br>
                    </h3>
                </div>

            </div>
            <div class="kt-portlet__body">

                <!--begin: Datatable -->

                <!-- HTML -->
                <div id="chartdiv<?php echo e($name); ?>" class="chartdiv"></div>

                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <?php $report_name = 'result_for_interval'.$name?>
    <input type="hidden" id="data<?php echo e($name); ?>" data-total="<?php echo e(json_encode($$report_name)); ?>">
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="row">
    
    <?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval_name => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
                $report_name = 'result_for_interval'.$name ;
                $report_count_data = 'count_result_for_interval'.$name ;
            ?>

    <div class="col-md-6">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">

                        <b> <?php echo e(__('From : ')); ?> </b><?php echo e($dates['start_date'.$name]); ?>

                        <b> - </b>
                        <b> <?php echo e(__('To : ')); ?></b> <?php echo e($dates['end_date'.$name]); ?>

                        <br>

                        <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b> <?php echo e($last_date); ?></span>
                    </h3>
                </div>

            </div>
            <div class="kt-portlet__body">

                <!--begin: Datatable -->


                 <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_search']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                    <tr class="table-active text-center">
                        <th>#</th>
                        <th class="text-center"><?php echo e(__(ucwords(str_replace('_',' ',$type)))); ?></th>
                        <th class="text-center"><?php echo e(__('Sales Values')); ?></th>
                        <th class="text-center"><?php echo e(__('Sales %')); ?></th>
                        <?php if(isset($$report_count_data) && count($$report_count_data) > 0): ?>
                        <th class="text-center"><?php echo e(__('Count')); ?></th>
                        <th class="text-center"><?php echo e(__('Count %')); ?></th>
                        <?php endif; ?>
                    </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>
                    <?php $total = array_sum(array_column($$report_name,'Sales Value'));
                                    $total_count = (isset($$report_count_data) && count($$report_count_data) > 0) ? array_sum(array_column($$report_count_data,'Count')) : 0; ?>
                    <?php $__currentLoopData = $$report_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th><?php echo e($key+1); ?></th>
                        <th><?php echo e($item['item']?? '-'); ?></th>
                        <td class="text-center"><?php echo e(number_format($item['Sales Value']??0)); ?></td>
                        <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($item['Sales Value']/$total)*100) , 1) . ' %'); ?></td>
                        <?php if(isset($$report_count_data) && count($$report_count_data) > 0): ?>
                        <td class="text-center"><?php echo e($$report_count_data[$key]['Count']); ?></td>
                        <td class="text-center"><?php echo e($total == 0 ? 0 : number_format((($$report_count_data[$key]['Count'] /$total_count)*100) , 1) . ' %'); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="table-active text-center">
                        <th colspan="2"><?php echo e(__('Total')); ?></th>
                        <td class="hidden"></td>
                        <td><?php echo e(number_format($total)); ?></td>
                        <td>100 %</td>
                        <?php if(isset($$report_count_data) && count($$report_count_data) > 0): ?>
                        <th><?php echo e($total_count); ?></th>
                        <td>100 %</td>
                        <?php endif; ?>
                    </tr>
                    <?php $__env->endSlot(); ?>
                 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>



<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
</script>
<!-- Chart code -->
<?php $__currentLoopData = $intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval_name => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv" + '<?php echo e($name); ?>', am4charts.PieChart);

        // Add data
        chart.data = $('#data' + '<?php echo e($name); ?>').data('total');
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




<!-- Resources -->




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/interval_comparing/sales_report.blade.php ENDPATH**/ ?>