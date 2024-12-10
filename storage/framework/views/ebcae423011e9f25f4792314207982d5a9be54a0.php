
<?php $__env->startSection('css'); ?>
<style>

.DataTables_Table_0_filter{
	float:left;
}
.dt-buttons button {
	color:#366cf3 !important;
	border-color:#366cf3 !important;
}
.dataTables_wrapper > .row > div.col-sm-6:first-of-type {
	flex-basis:20% !important;
}
.dataTables_wrapper > .row label{
	margin-bottom:0 !important;
	padding-bottom:0 !important ;
}
.kt-portlet__head-title,
.fa-layer-group
{
	color:#366cf3 !important;
	border-bottom:2px solid  #366cf3;
	padding-bottom:.5rem !important;
}


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

    .dataTables_wrapper {
        max-width: 100%;
        padding-bottom: 50px !important;
        overflow-x: overlay;
        max-height: 4000px;
    }

    .dataTables_wrapper {
        max-width: 100%;
        padding-bottom: 50px !important;
        overflow-x: overlay;
        max-height: 4000px;
    }

    .table-active .dtfc-fixed-left,
    .table-active .dtfc-fixed-right {
        background-color: #086691 !important;
        color: white !important;
		

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
  
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab  EGP FX Rate Table -->
            <?php
                    array_push($names, 'Total');
                    array_push($names, 'Sales_Channel_Sales_Percentages');
                    ?>
            
<!--End:: Tab  EGP FX Rate Table -->
<?php
	$view_name = str_replace('Items',' Products Items',$view_name);
?>
<!--Begin:: Tab USD FX Rate Table -->
<div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">
     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($view_name.' Report'),'tableClass' => 'kt_table_with_no_pagination_no_fixed_right']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__env->slot('table_header'); ?>
        <tr class="table-active text-center">
            <th class="text-center absorbing-column max-w-classes"><?php echo e(__($type)); ?></th>
            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th><?php echo e(date('d-M-Y', strtotime($date))); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('table_body'); ?>

        <?php $id =1 ;?>
        <?php $__currentLoopData = $report_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sales_channel_name => $sales_channel_channels_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        

        <?php if($sales_channel_name != 'Total' && $sales_channel_name != 'Growth Rate %'): ?>


        <tr class="group-color ">
            <td class="white-text max-w-classes" style="cursor: pointer;" onclick="toggleRow('<?php echo e($id); ?>')">
                <i class="row_icon<?php echo e($id); ?> flaticon2-down white-text"></i>
                <b><?php echo e(__($sales_channel_name)); ?></b>
            </td>
            
            <?php $total_per_sales_channel = $sales_channel_channels_data['Total'] ?? [];
                                        unset($sales_channel_channels_data['Total']); ?>
            
            <?php $growth_rate_per_sales_channel = $sales_channel_channels_data['Growth Rate %'] ?? [];
                                        unset($sales_channel_channels_data['Growth Rate %']); ?>
            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td class="text-center white-text">
                
                
            </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
        <?php $__currentLoopData = $sales_channel_channels_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel_name => $channel_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="row<?php echo e($id); ?>   text-center">
            <td class="text-left"><b><?php echo e($channel_name . ' - Avg. Prices'); ?></b></td>

            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td class="text-center">
                <?php echo e(number_format($channel_section['Avg. Prices'][$date] ?? 0  , 2  )); ?>

                <span class="color-<?php echo e(getPercentageColor($channel_section['Growth Rate %'][$date]??0)); ?>"><b> <?php echo e(' [ '.number_format(($channel_section['Growth Rate %'][$date]??0), 1) . ' %  ]'); ?></b></span>
            </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php endif; ?>
        <?php $id++ ;?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


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

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">



</script>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    function toggleRow(rowNum) {
        $(".row" + rowNum).toggle();
        $('.row_icon' + rowNum).toggleClass("flaticon2-up flaticon2-down");

    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/average_prices/average_prices_report.blade.php ENDPATH**/ ?>