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

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />
<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691 !important;
    }

    .dtfc-fixed-left,
    .dtfc-fixed-right {
        background-color: #086691 !important;
    }

    .dtfc-fixed-left,
    .dtfc-fixed-right {
        color: white !important;
    }

    thead * {
        text-align: center !important;
    }

    .bg-white {
        background-color: #fff !important;
    }

    .text-black {
        color: black !important;

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
    
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab  EGP FX Rate Table -->
            <div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                 <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableTitle' => __($view_name.' Report'),'tableClass' => 'kt_table_with_no_pagination']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__env->slot('table_header'); ?>
                    <tr class="table-active text-center">
                        <th class="text-center absorbing-column max-w-classes"><?php echo e(__(spaceAfterCapitalLetters(camelize($type)))); ?></th>
                        <?php
                        $colsSpans = arrayCountAllLongest($sumForEachInterval) + 1 ;
                        ?>
                        <?php $__currentLoopData = getLongestArray($sumForEachInterval); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $d; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th>
                            <?php echo e($endOfMonth=\Carbon\Carbon::parse($year.'-'.$month)->endOfMonth()->format('d-M-Y')); ?>


                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        
                    </tr>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('table_body'); ?>

                    <?php $idd =1 ;?>

                    <?php $__currentLoopData = $sumForEachInterval; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone_name => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $totalCountInvoiceNumber = 0 ;
                    ?>
                    <tr class="group-color ">
                        <td colspan="<?php echo e($colsSpans); ?>" class=" bg-white text-black max-w-classes" style="cursor: pointer;" onclick="toggleRow('<?php echo e($idd); ?>')">
                            <i class="row_icon<?php echo e($idd); ?> flaticon2-up text-black"></i>
                            <b>
                                <?php echo e(__($zone_name)); ?>


                            </b>
                        </td>
                        <?php $__currentLoopData = getLongestArray($sumForEachInterval); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $d; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval=>$q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td hidden>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>


                    <tr class="row<?php echo e($idd); ?>  active-style text-center" style="display: none">
                        <td class="text-left"><b><?php echo e(__('Invoice Count')); ?></b></td>


                        <?php $__currentLoopData = getLongestArray($sumForEachInterval); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $d; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval=>$q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="text-center">
                            <span class="white-text"><b>
                                    <?php
                                    $countInvoiceNumber = ($sumForEachInterval[$zone_name][$year][$interval]['invoice_number']) ?? 0
                                    ?>
                                    <?php echo e(number_format( $countInvoiceNumber )); ?>


                                </b></span>
                        </td>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                    </tr>

                    <?php if($type != 'product_item'): ?>

                    <tr class="row<?php echo e($idd); ?>  active-style text-center" style="display: none">
                        <td class="text-left"><b><?php echo e(__('Avg Product Items Count Per Invoice')); ?></b></td>

                        <?php $__currentLoopData = getLongestArray($sumForEachInterval); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $d; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval=>$q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                        $invoiceNumber = ($sumForEachInterval[$zone_name][$year][$interval]['invoice_number']) ?? 0 ;
                        ?>
                        <td class="text-center">
                            <span class="white-text"><b>
                                    <?php echo e(round(($sumForEachInterval[$zone_name][$year][$interval]['avg']) ?? 0)); ?>

                                </b></span>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>










                    <tr class="row<?php echo e($idd); ?>  active-style text-center" style="display: none">
                        <td class="text-left"><b><?php echo e(__('Avg Invoice Value')); ?></b></td>


                        <?php $__currentLoopData = getLongestArray($sumForEachInterval); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$index = -1 ;
						?>
                        <?php $__currentLoopData = $d; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval=>$q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$index++;
						?>
                        <td class="text-center">
                            <span class="white-text"><b>
                                    <?php
                                 
                                    $invoiceNumber = ($sumForEachInterval[$zone_name][$year][$interval]['invoice_number']) ?? 0 ;
                                    $salesValue = array_values($reportSalesValues[$zone_name])[$index] ?? 0 ;
									
									
                                    $avg_invoice_value = $invoiceNumber ? number_format($salesValue / $invoiceNumber) : 0;
                                    ?>
                          
                                    <?php echo e($avg_invoice_value); ?>

                                </b></span>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>

                    <?php endif; ?>



                    <?php
                    $idd = $idd + 1 ;
                    ?>

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
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>

<script>
    function toggleRow(rowNum) {
        $(".row" + rowNum).toggle();
        $('.row_icon' + rowNum).toggleClass("flaticon2-down flaticon2-up");
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/invoices_analysis_report.blade.php ENDPATH**/ ?>