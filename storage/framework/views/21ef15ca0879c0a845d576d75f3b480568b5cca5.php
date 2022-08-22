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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
<style>
    table.dataTable thead tr > .dtfc-fixed-left, table.dataTable thead tr > .dtfc-fixed-right{
        background-color:#086691 !important;
    }
    .dtfc-fixed-left:not(.active-style),  .dtfc-fixed-right:not(.active-style){
        background-color:white !important;
        color:black;
    } 
      .group-color > .dtfc-fixed-left,  .group-color > .dtfc-fixed-right{
        background-color:#086691 !important;
           color:white !important;
         }
    .dtfc-fixed-left , .dtfc-fixed-right{
        /* color:white !important; */
    }
    
    thead *{
        text-align:center !important;
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
                    array_push($branches_names, 'Total');
                    array_push($branches_names, 'Branch_Sales_Percentages');
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
                                <th class="text-center absorbing-column"><?php echo e(__('Branch')); ?></th>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__('Total')); ?></th>
                            </tr>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('table_body'); ?>
<?php

sortReportForTotals($report_data)
// (uasort($report_data,  function($a,$b) use($report_data){

// if(isset($b['Total']) && $a['Total']){
// $a = array_sum($a['Total']);
// $b = array_sum($b['Total']);

//      if ($a == $b) {
//         return 0;
//     }
//     return ($a > $b) ? -1 : 1;
//     }
//     return ;
// }

// )
//     );
   

?> 
                            <?php $id =1 ;?>
                            <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone_name => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php $chart_data = [];?>

                                <?php if($zone_name != 'Total' && $zone_name != 'Growth Rate %'): ?>
                                <?php
                                    // $row_name = str_replace(' ', '_', $zone_name);
                                    // $row_name = str_replace(['&','(',')','{','}'], '_', $row_name);
                                 ?>

                                    <tr class="group-color">
                                        <td class="white-text"  style="cursor: pointer;" onclick="toggleRow('<?php echo e($id); ?>')">
                                            <i class="row_icon<?php echo e($id); ?> flaticon2-up white-text"></i>
                                            <b><?php echo e(__($zone_name)); ?></b>
                                        </td>
                                        
                                        <?php $total_per_zone = $data['Total'] ?? [];
                                        unset($data['Total']); ?>
                                        
                                        <?php $growth_rate_per_zone = $data['Growth Rate %'] ?? [];
                                        unset($data['Growth Rate %']); ?>

                                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center white-text"><?php echo e(number_format($total_per_zone[$date] ?? 0) . '  [ GR '.number_format($growth_rate_per_zone[$date] ?? 0) . ' % ]'); ?>

                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center white-text"><?php echo e(number_format(array_sum($total_per_zone??[]),0)); ?></td>
                                    </tr>
                           

                                    <?php
                                        sortSubItems($data)
                                    ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel_name => $channel_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



          
                                        <tr class="row<?php echo e($id); ?>  text-center" style="display: none">
                                            <td class="text-left"><b><?php echo e($channel_name); ?></b></td>


                                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center">
                                                    <?php echo e(number_format(($channel_section['Sales Values'][$date] ?? 0),0)); ?>

                                                    <span class="active-text-color "><b> <?php echo e(' [ '.number_format(($channel_section['Growth Rate %'][$date]??0), 1) . ' %  ]'); ?></b></span>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(number_format(array_sum($channel_section['Sales Values']??[]),0)); ?></td>
                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>






                                <?php elseif($zone_name == 'Total' || $zone_name == 'Growth Rate %'): ?>
                                    <tr class="active-style text-center">
                                        <td class="active-style text-center" ><b><?php echo e(__($zone_name)); ?></b></td>
                                        <?php $decimals = $zone_name == 'Growth Rate %' ? 2 : 0; ?>
                                        <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center active-style">
                                                <?php echo e(number_format($data[$date] ?? 0,$decimals) . ($decimals == 0 ? '' : ' %')); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center active-style"><?php echo e($zone_name == 'Growth Rate %' ? "-" : number_format(array_sum($data  ?? []),0)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php $id++ ;?>
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
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>

     <script>
        function toggleRow(rowNum) 
        {
            $(".row" + rowNum).toggle();
            $('.row_icon' + rowNum).toggleClass("flaticon2-down flaticon2-up");
        }
        </script> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/reports/sales_gathering_analysis/branches_analysis_report.blade.php ENDPATH**/ ?>