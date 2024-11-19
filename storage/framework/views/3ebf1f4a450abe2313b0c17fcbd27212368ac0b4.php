<?php $__env->startSection('css'); ?>

<style>
    table {
        white-space: nowrap;
    }

</style>
<?php if(in_array('TwoDimensionalBreakdown',Request()->segments())): ?>
<style>
    .secondary-row-color .dtfc-fixed-left,
    .secondary-row-color .dtfc-fixed-right {
        color: black !important;
    }

</style>
<?php endif; ?>
<script>
    // alert(33)

</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />
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

</style>
<?php if(!in_array('DiscountsAnalysisResult',Request()->segments())): ?>
<style>
 .dtfc-fixed-left,
    .dtfc-fixed-right {
        color: white !important;
    }
</style>
<?php endif; ?> 
<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    .dtfc-fixed-left,
    .dtfc-fixed-right {
        background-color: #086691 !important;
    }
	
   

    .secondary-row-color .dtfc-fixed-left,
    .secondary-row-color .dtfc-fixed-right {
        background-color: antiquewhite !important;
        font-weight: bold;
        color: black;
    }

    .secondary-row-color+tr .dtfc-fixed-left,
    .secondary-row-color+tr .dtfc-fixed-right,
        {
        background-color: white !important;
        font-weight: bold;
        color: black !important;
    }


    .group-color>.dtfc-fixed-left,
    .group-color>.dtfc-fixed-right {
        background-color: #086691 !important;
        color: white !important;
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
        color: black;
        font-weight: bold;
    }

</style>
<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>

<style>
    .odd:not(.table-active) .dtfc-fixed-left:first-of-type,
    .odd:not(.table-active) .dtfc-fixed-right:last-of-type {
        background-color: white !important;
        font-weight: bold;
        color: black !important;

    }

</style>

<?php if(in_array('TwoDimensionalBreakdown' , Request()->segments())): ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__($view_name)); ?>

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



<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
            </span>
            <h3 class="kt-portlet__head-title">

                <b> <?php echo e(__('From : ')); ?> </b><?php echo e($dates['start_date']); ?>

                <b> - </b>
                <b> <?php echo e(__('To : ')); ?></b> <?php echo e($dates['end_date']); ?>

                <br>

                <span class="title-spacing"><b> <?php echo e(__('Last Updated Data Date : ')); ?></b> <?php echo e($last_date); ?></span>
            </h3>
        </div>

    </div>
</div>



<!--begin: Datatable -->

 <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination ']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->slot('table_header'); ?>
    <tr class="table-active text-center">
        <?php $main_type_name = ucwords(str_replace('_', ' ', $main_type)); ?>
        <th><?php echo e(__($main_type_name) . ' / ' . __(ucwords(str_replace('_', ' ', $type)))); ?></th>
        <?php $__currentLoopData = $all_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <th><?php echo e(__($item)); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <td><?php echo e(__('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?></td>
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

            <span><b class="color-<?php echo e(getPercentageColor($percentage_per_value)); ?>"> <?php echo e(number_format($percentage_per_value, 1) . ' %  '); ?></b></span>


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

            
        </td>
        <?php if(isset($totals_sales_per_main_type)): ?>
        <td class="text-center">-</td>
        <?php endif; ?>
    </tr>


    <tr class="table-active text-center">
        <th class="text-center"> <?php echo e(__(ucwords(str_replace('_', ' ', $type))) . ' % / ' . __('Total '.($type ==  'discounts' ? 'Discounts' : 'Sales'))); ?> </th>
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
        <th class="text-center"> <?php echo e(__(ucwords(str_replace('_', ' ', $type))) . ' % / Sales'); ?> </th>
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
 <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<!--end: Datatable -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </sc> {
        {
            --<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript">

</script> --}}

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/two_dimensional_breakdown/sales_report.blade.php ENDPATH**/ ?>