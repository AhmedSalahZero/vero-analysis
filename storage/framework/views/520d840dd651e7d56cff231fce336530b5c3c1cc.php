
<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<style>
[data-chart-name="Total-Aging-Analysis-Chart"]{
	max-height:340px !important;
}
[data-chart-name="Total-Coming-Dues-Aging-Analysis-Chart"],
[data-chart-name="Total-Past-Dues-Aging-Analysis-Chart"]
{
	max-height:580px !important;
}
    .is-sub-row.is-total-row td.sub-numeric-bg,
    .is-sub-row.is-total-row td.sub-text-bg {
        background-color: #087383 !important;
        color: white !important;
    }

    .is-name-cell {
        white-space: normal !important;
    }

    .top-0 {
        top: 0 !important;
    }

    .parent-tr td {
        border: 1px solid #E2EFFE !important;
    }

    .dataTables_filter {
        width: 30% !important;
        text-align: left !important;

    }

    .border-parent {
        border: 2px solid #E2EFFE;
    }

    .dt-buttons.btn-group,
    .buttons-print {
        max-width: 30%;
        margin-left: auto;
        position: relative;
        top: 45px;
    }

    .details-btn {
        display: block;
        margin-top: 10px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 600;

    }

    .expand-all {
        cursor: pointer;
    }

    td.editable-date.max-w-fixed,
    th.editable-date.max-w-fixed,
    input.editable-date.max-w-fixed {
        width: 1050px !important;
        max-width: 1050px !important;
        min-width: 1050px !important;

    }

    td.editable-date.max-w-classes-expand,
    th.editable-date.max-w-classes-expand,
    input.editable-date.max-w-classes-expand {
        width: 70px !important;
        max-width: 70px !important;
        min-width: 70px !important;

    }

    td.max-w-classes-name,
    th.max-w-classes-name,
    input.max-w-classes-name {
        width: 350px !important;
        max-width: 350px !important;
        min-width: 350px !important;

    }

    td.max-w-grand-total,
    th.max-w-grand-total,
    input.max-w-grand-total {
        width: 100px !important;
        max-width: 100px !important;
        min-width: 100px !important;

    }

    * {
        box-sizing: border-box !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($customersOrSupplierAgingText); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
$moreThan150=\App\ReadyFunctions\InvoiceAgingService::MORE_THAN_150;
?>
<style>
    td.editable-date,
    th.editable-date,
    input.editable-date {
        width: 100px !important;
        min-width: 100px !important;
        max-width: 100px !important;
        overflow: hidden;
    }

    .width-66 {


        width: 66% !important;
    }

    .border-bottom-popup {
        border-bottom: 1px solid #d6d6d6;
        padding-bottom: 20px;
    }

    .flex-self-start {
        align-self: flex-start;
    }

    .flex-checkboxes {
        margin-top: 1rem;
        flex: 1;
        width: 100% !important;
    }


    .flex-checkboxes>div {
        width: 100%;
        width: 100% !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .custom-divs-class {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }


    .modal-backdrop {
        display: none !important;
    }

    .modal-content {
        min-width: 600px !important;
    }

    .form-check {
        padding-left: 0 !important;

    }

    .main-with-no-child,
    .main-with-no-child td,
    .main-with-no-child th {
        background-color: #046187 !important;
        color: white !important;
        font-weight: bold;
    }

    .is-sub-row td.sub-numeric-bg,
    .is-sub-row td.sub-text-bg {
        border: 1.5px solid white !important;
        background-color: #0e96cd !important;
        color: white !important;


        background-color: #E2EFFE !important;
        color: black !important
    }



    .sub-numeric-bg {
        text-align: center;

    }



    th.dtfc-fixed-left {
        background-color: #074FA4 !important;
        color: white !important;
    }

    .header-tr,
        {
        background-color: #046187 !important;
    }

    .dt-buttons.btn-group {
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }

    .is-sales-rate,
    .is-sales-rate td,
    .is-sales-growth-rate,
    .is-sales-growth-rate td {
        background-color: #046187 !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        font-weight: bold;
        color: black;
    }

    a[data-toggle="modal"] {
        color: #046187 !important;
    }

    a[data-toggle="modal"].text-white {
        color: white !important;
    }

    .btn-border-radius {
        border-radius: 10px !important;
    }

</style>
<div class="row">
    <div class="col-md-12">

        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="return false;" data-toggle="tab" href="#kt_apps_contacts_view_tab_1" role="tab">
                                <i class="flaticon2-checking"></i> &nbsp; <?php echo e(__('Report Table')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " onclick="return false;" data-toggle="tab" href="#kt_apps_contacts_view_tab_2" role="tab">
                                <i class="flaticon-line-graph"></i><?php echo e(__('Charts')); ?>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        

        <?php

        $tableId = 'kt_table_1';
        ?>



        <?php echo csrf_field(); ?>


        <?php
        $grandTotal = $agings['grand_total'] ??0
        ?>
        <div class="tab-content">
            <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                <div class="kt-portlet">

                    <div class="kt-portlet__body with-scroll">
                        <div class="table-custom-container position-relative  ">



                            <div class="responsive">
                                <table class="table kt_table_with_no_pagination_no_collapse table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                                    <thead>

                                        <tr class="header-tr ">
                                            <th class="view-table-th expand-all is-open-parent header-th editable-date max-w-classes-expand align-middle text-center trigger-child-row-1" rowspan="2">
                                                <?php echo e(__('Expand All' )); ?>

                                                <span>+</span>
                                            </th>
                                            <th class="view-table-th header-th max-w-classes-name align-middle text-center" class="header-th" rowspan="2">
                                                <?php echo e(__('Customer Name')); ?>


                                            </th>
                                            <th class="view-table-th editable-date header-th max-w-fixed" style="" colspan="<?php echo e(count(getInvoiceDayIntervals() )+1); ?>"> <?php echo e(__('Past Due')); ?> </th>
                                            <th class="view-table-th align-middle text-center editable-date header-th" rowspan="2">
                                                <?php echo e(__('Total Past Due')); ?>

                                                <button class="btn btn-sm btn-light d-block details-btn" id="show-past-due-detail"><?php echo e(__('Show Details')); ?></button>
                                            </th>
                                            <th class="view-table-th editable-date header-th">
                                                <?php echo e(__('Current Due')); ?>

                                            </th>
                                            <th colspan="<?php echo e(count(getInvoiceDayIntervals() )+1); ?>" class="view-table-th header-th">
                                                <?php echo e(__('Coming Due ')); ?>

                                            </th>
                                            <th class="view-table-th align-middle text-center editable-date header-th" rowspan="2">
                                                <?php echo e(__('Total Coming Due')); ?>

                                                <button class="btn btn-sm btn-light d-block details-btn" id="show-coming-due-detail"><?php echo e(__('Show Details')); ?></button>

                                            </th>

                                            <th class="view-table-th editable-date align-middle text-center header-th max-w-grand-total" rowspan="2">
                                                <?php echo e(__('Grand Total')); ?>

                                            </th>


                                        </tr>


                                        <tr class="header-tr ">


                                            <th class="view-table-th editable-date header-th"><?php echo e($moreThan150); ?>

                                                <span class="d-block"><?php echo e(__('Days')); ?></span>

                                            </th>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="view-table-th editable-date header-th">
                                                <span style="white-space:nowrap !important">[<?php echo e($daysIntervalInInverseOrder); ?>] <?php echo e(__('Days')); ?></span>
												
                                                
												<?php if(isset($weeksDates['past_due'][$daysIntervalInInverseOrder]['start_date'])): ?>
												<span class="d-block"><?php echo e($weeksDates['past_due'][$daysIntervalInInverseOrder]['start_date']); ?> <br></span>
												<span class="d-block"><?php echo e($weeksDates['past_due'][$daysIntervalInInverseOrder]['end_date']); ?> <br></span>
												<?php endif; ?>
												
                                                
                                            </th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <th class="view-table-th editable-date header-th">
                                                <?php echo e(__('At Date')); ?>

                                                <?php echo e(\Carbon\Carbon::make($aginDate)->format('d-m-Y')); ?>

                                            </th>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                            <th class="view-table-th header-th">
                                                <span style="white-space:nowrap !important">[<?php echo e($daysInterval); ?>] <?php echo e(__('Days')); ?></span>
                                                
												<?php if(isset($weeksDates['coming_due'][$daysInterval]['start_date'])): ?>
                                                <span class="d-block"><?php echo e($weeksDates['coming_due'][$daysInterval]['start_date']); ?> <br></span>
                                                <span class="d-block"><?php echo e($weeksDates['coming_due'][$daysInterval]['end_date']); ?> <br></span>
												<?php endif; ?>
                                                

                                            </th>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <th class="view-table-th editable-date header-th">
                                                <span class="d-block"><?php echo e($moreThan150); ?></span>
                                                <span class="d-block"><?php echo e(__('Days')); ?></span>
                                            </th>



                                        </tr>

                                    </thead>
                                    <tbody class="">
                                        <script>
                                            let currentTable = null;

                                        </script>
                                        <?php
                                        $rowIndex = 0 ;
                                        ?>
                                        <?php $__currentLoopData = $agings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clientName=> $aging): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($clientName == 'total' || $clientName =='grand_total' || $clientName =='total_of_due' || $clientName =='invoice_count' || $clientName=='total_clients_due' || $clientName=='grand_clients_total' || $clientName=='charts'): ?>
                                        <?php continue; ?> ;
                                        <?php endif; ?>
                                        <?php
                                        $hasSubRows = count($aging['invoices']??[]) ;
                                        $currentTotal = $aging['total'] ?? 0 ;
                                        ?>
                                        <tr class=" parent-tr  reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   " data-model-id="<?php echo e($rowIndex); ?>">
                                            <td class="red reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize main-tr is-close"> <?php if($hasSubRows): ?> + <?php endif; ?></td>
                                            <td class="sub-text-bg   editable-text  max-w-classes-name is-name-cell "><?php echo e($clientName); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['past_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $currentValue = $aging['past_due'][$daysIntervalInInverseOrder] ?? 0 ;
                                            $currentPercentage = $currentValue && $currentTotal ? $currentValue/ $currentTotal * 100 : 0 ;
                                            ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentValue  ,0)); ?> <?php if($currentPercentage): ?> <?php endif; ?> </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['past_due']['total'] ?? 0 ,0)); ?></td>

                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['current_due'][0] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['coming_due'][$daysInterval] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['coming_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($aging['coming_due']['total'] ?? 0 ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentTotal ,0)); ?></td>
                                        </tr>




                                        <?php $__currentLoopData = $aging['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoiceNumber=>$invoiceDetailArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="edit-info-row add-sub maintable-1-row-class<?php echo e($rowIndex); ?> is-sub-row d-none">
                                            <td class=" reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize is-close "></td>
                                            <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell "><?php echo e($invoiceNumber); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['past_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['past_due'][$daysIntervalInInverseOrder] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['past_due']['total'] ?? 0 ,0)); ?></td>

                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['current_due'][0] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['coming_due'][$daysInterval] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['coming_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['coming_due']['total'] ?? 0 ,0)); ?></td>
                                            <td class="sub-numeric-bg text-center editable-date"><?php echo e(number_format($invoiceDetailArr['total']??0 , 0)); ?></td>

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                                        <?php
                                        $rowIndex = $rowIndex+ 1;
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        <tr class="edit-info-row add-sub is-total-row is-sub-row ">
                                            <td class=" reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close "></td>

                                            <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell "><?php echo e(__('Total')); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['total']['past_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['total']['past_due'][$daysIntervalInInverseOrder] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php echo e(number_format($agings['total_of_due']['past_due']??0)); ?>

                                            </td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['total']['current_due'][0] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['total']['coming_due'][$daysInterval] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['total']['coming_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php echo e(number_format($agings['total_of_due']['coming_due']??0)); ?>

                                            </td>
                                            <td class="sub-numeric-bg text-center editable-date"><?php echo e(number_format($grandTotal ,0)); ?></td>

                                        </tr>





                                        <tr class="edit-info-row add-sub is-total-row is-sub-row ">
                                            <td class=" reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close "></td>

                                            <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell "><?php echo e(__('Percentage From Grand Total %')); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e($grandTotal && isset($agings['total']['past_due'][$moreThan150]) ?  number_format($agings['total']['past_due'][$moreThan150] / $grandTotal *100 ,2) . ' %' : 0); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e($grandTotal && isset($agings['total']['past_due'][$daysIntervalInInverseOrder]) ? number_format($agings['total']['past_due'][$daysIntervalInInverseOrder] /$grandTotal * 100 ,2) . ' %' : 0); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php echo e($grandTotal && isset($agings['total_of_due']['past_due']) ?   number_format($agings['total_of_due']['past_due']/ $grandTotal * 100 ,2) . ' %' : 0); ?>

                                            </td>

                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e($grandTotal && isset($agings['total']['current_due'][0]) ?  number_format($agings['total']['current_due'][0]  / $grandTotal * 100 ,2). ' %' : 0); ?> </td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e($grandTotal && isset($agings['total']['coming_due'][$daysInterval])?  number_format($agings['total']['coming_due'][$daysInterval]  / $grandTotal *100 ,2) . ' %' : 0); ?> </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e($grandTotal && isset($agings['total']['coming_due'][$moreThan150]) ? number_format($agings['total']['coming_due'][$moreThan150]  / $grandTotal *100  ,2) . ' %':0); ?> </td>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php echo e($grandTotal && isset($agings['total_of_due']['coming_due']) ?  number_format($agings['total_of_due']['coming_due'] / $grandTotal * 100 ,2) . ' %' : 0); ?>

                                            </td>
                                            <td class="sub-numeric-bg text-center editable-date"><?php echo e($grandTotal ? number_format($grandTotal / $grandTotal * 100 ) . ' %' : 0); ?></td>

                                        </tr>




                                        <tr class="edit-info-row add-sub is-total-row is-sub-row ">
                                            <td class=" reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close "></td>

                                            <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell "><?php echo e(__('Invoice Count')); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['invoice_count']['past_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['invoice_count']['past_due'][$daysIntervalInInverseOrder] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php
                                                $totalInvoiceForPastDue = array_sum($agings['invoice_count']['past_due'] ?? []);
                                                ?>
                                                <?php echo e(number_format($totalInvoiceForPastDue)); ?>

                                            </td>
                                            <?php
                                            $totalInvoiceForCurrentDue = $agings['invoice_count']['current_due'][0] ?? 0;
                                            ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format( $totalInvoiceForCurrentDue,0)); ?></td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['invoice_count']['coming_due'][$daysInterval] ?? 0 ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($agings['invoice_count']['coming_due'][$moreThan150] ?? 0 ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php
                                                $totalInvoiceForComingDue = array_sum($agings['invoice_count']['coming_due'] ?? [])
                                                ?>
                                                <?php echo e(number_format($totalInvoiceForComingDue)); ?>

                                            </td>
                                            <td class="sub-numeric-bg text-center editable-date"><?php echo e(number_format($totalInvoiceForPastDue+$totalInvoiceForComingDue+$totalInvoiceForCurrentDue)); ?></td>

                                        </tr>





                                        <tr class="edit-info-row add-sub is-total-row is-sub-row ">
                                            <td class=" reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close "></td>

                                            <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell "><?php echo e(__('Customers Count')); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format(count($agings['invoice_count']['past_due']['clients'][$moreThan150] ?? []))); ?></td>
                                            <?php $__currentLoopData = array_reverse(getInvoiceDayIntervals()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysIntervalInInverseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format( count($agings['invoice_count']['past_due']['clients'][$daysIntervalInInverseOrder]?? [])  ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date">

                                                <?php echo e(number_format(count($agings['total_clients_due']['past_due'] ?? []))); ?>

                                            </td>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format(count($agings['invoice_count']['current_due']['clients'][0] ?? []) ,0)); ?></td>
                                            <?php $__currentLoopData = getInvoiceDayIntervals(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daysInterval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format(count($agings['invoice_count']['coming_due']['clients'][$daysInterval] ?? []) ,0)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format(count($agings['invoice_count']['coming_due']['clients'][$moreThan150] ?? []) ,0)); ?></td>
                                            <td class="  sub-numeric-bg text-center editable-date">
                                                <?php echo e(number_format(count($agings['total_clients_due']['coming_due'] ?? []))); ?>

                                            </td>
                                            <td class="sub-numeric-bg text-center editable-date">
                                                <?php echo e(number_format(count($agings['grand_clients_total']??[]))); ?></td>
                                        </tr>


















                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                <?php $__currentLoopData = $agings['charts']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName =>$chartArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                    
                        <div class="row">
						
							 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.title','data' => ['title' => $chartName]]); ?>
<?php $component->withName('title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chartName)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                            <div class="col-md-6">
                                <div class="kt-portlet kt-portlet--mobile">

                                    <div class="kt-portlet__body" data-chart-name="<?php echo e(convertStringToClass($chartName)); ?>">

                                        <!--begin: Datatable -->

                                        <!-- HTML -->
                                        <div id="chartdiv_<?php echo e(convertStringToClass($chartName)); ?>" class="chartDiv"></div>

                                        <!--end: Datatable -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-portlet--mobile">



                                    <div class="kt-portlet__body">

                                        <!--begin: Datatable -->

                                        <?php
                                        $order = 1 ;
                                        ?>

                                         <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_info']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                            <?php $__env->slot('table_header'); ?>
                                            <tr class="table-active remove-max-class text-center">
                                                <th>#</th>
                                                <th><?php echo e(__('Item')); ?></th>
                                                <th><?php echo e(__('Value')); ?></th>
                                                <th><?php echo e(__('%')); ?></th>

                                            </tr>
                                            <?php $__env->endSlot(); ?>
                                            <?php $__env->slot('table_body'); ?>

                                            <?php $__currentLoopData = $chartArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th><?php echo e(++$key); ?></th>
                                                <th style="white-space: normal !important"><?php echo e($item['item']); ?></th>
                                                <td class="text-center"><?php echo e(number_format($item['value'])); ?></td>
                                                <td class="text-center"><?php echo e(number_format($item['percentage'],1)); ?> %</td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <tr class="table-active remove-max-class text-center">
                                                <th colspan="2"><?php echo e(__('Total')); ?></th>
                                                <td><?php echo e(number_format($item['total_for_all_values'] , 0)); ?></td>
                                                <td><?php echo e(number_format($item['total_for_all_percentages'] , 1)); ?> %</td>
                                            </tr>
                                            <?php $__env->endSlot(); ?>
                                         <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 




                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $agings['charts']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $chartArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" id="total_<?php echo e(convertStringToClass($chartName)); ?>" data-total="<?php echo e(json_encode(
      							      $chartArr
        					)); ?>">
				                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                


            </div>
        </div>

        <?php $__env->startPush('js'); ?>

		
        <script>
            $(document).on('click', '.trigger-child-row-1', function(e) {
                const parentId = $(e.target.closest('tr')).data('model-id');
                var parentRow = $(e.target).parent();
                var subRows = parentRow.nextAll('tr.add-sub.maintable-1-row-class' + parentId);

                subRows.toggleClass('d-none');
                if (subRows.hasClass('d-none')) {
                    parentRow.find('td.trigger-child-row-1').removeClass('is-open').addClass('is-close').html('+');
                    var closedId = parentRow.attr('data-index')


                } else if (!subRows.length) {
                    // if parent row has no sub rows then remove + or - 
                    parentRow.find('td.trigger-child-row-1').html('×');
                } else {
                    parentRow.find('td.trigger-child-row-1').addClass('is-open').removeClass('is-close').html('-');



                }

            });



            $(document).on('click', '.expand-all', function(e) {
                e.preventDefault();
                if ($(this).hasClass('is-open-parent')) {
                    $(this).addClass('is-close-parent').removeClass('is-open-parent')
                    $(this).find('span').html('-')

                    $('.main-tr.is-close').trigger('click')
                } else {
                    $(this).addClass('is-open-parent').removeClass('is-close-parent')
                    $(this).find('span').html('+')

                    $('.main-tr.is-open').trigger('click')
                }

            })





            var table = $(".kt_table_with_no_pagination_no_collapse");


            window.addEventListener('scroll', function() {
                const top = window.scrollY > 140 ? window.scrollY : 140;

                $('.arrow-nav').css('top', top + 'px')
            })
            if ($('.kt-portlet__body.with-scroll').length) {
                $('.kt-portlet__body.with-scroll').append(`<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i> <i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>`)
                $(document).on('click', '.arrow-nav', function() {
                    const scrollLeftOfTableBody = document.querySelector('.kt-portlet__body.with-scroll').scrollLeft
                    const scrollByUnit = 50
                    if (this.classList.contains('arrow-right')) {
                        document.querySelector('.with-scroll .dataTables_scrollBody').scrollLeft += scrollByUnit

                    } else {
                        document.querySelector('.with-scroll .dataTables_scrollBody').scrollLeft -= scrollByUnit

                    }
                })

            }



            table.DataTable({




                    dom: 'Bfrtip'

                    , "processing": false
                    , "scrollX": true
                    , "scrollY": true
                    , "ordering": false
                    , 'paging': false
                    , "fixedColumns": {
                        left: 2
                    }
                    , "fixedHeader": {
                        headerOffset: 60
                    }
                    , "serverSide": false
                    , "responsive": false
                    , "pageLength": 25
                    , drawCallback: function(setting) {
                        if (!currentTable) {
                            currentTable = $('.main-table-class').DataTable();
                        }
                        currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(false);
                        currentTable.columns([13, 14, 15, 16, 17, 18, 19, 20, 21]).visible(false);
                        $('.buttons-html5').addClass('btn border-parent btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
                        $('.buttons-print').addClass('btn border-parent top-0 btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')

                    },





                }

            )

        </script>
        <?php $__env->stopPush(); ?>

        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
    function getDateFormatted(yourDate) {
        const offset = yourDate.getTimezoneOffset()
        yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000))
        return yourDate.toISOString().split('T')[0]
    }

    am4core.ready(function() {

        // Themes begin



    }); // end am4core.ready()

</script>
<script>

    $(document).on('click', '#show-past-due-detail', function() {
        if (!currentTable) {
            currentTable = $('.main-table-class').DataTable()
        }
        if (currentTable.column(2).visible()) {
            $(this).html("<?php echo e(__('Show Details')); ?>")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(false);
        } else {
            $(this).html("<?php echo e(__('Hide Details')); ?>")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(true);
        }
    })

    $(document).on('click', '#show-coming-due-detail', function() {
        if (!currentTable) {
            currentTable = $('.main-table-class').DataTable()
        }
        if (currentTable.column(13).visible()) {
            $(this).html("<?php echo e(__('Show Details')); ?>")
            currentTable.columns([13, 14, 15, 16, 17, 18, 19, 20, 21]).visible(false);
        } else {
            $(this).html("<?php echo e(__('Hide Details')); ?>")
            currentTable.columns([13, 14, 15, 16, 17, 18, 19, 20, 21]).visible(true);
        }
    })

</script>



<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->

<?php $__currentLoopData = $agings['charts']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $chartArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv_<?php echo e(convertStringToClass($chartName)); ?>", am4charts.PieChart);

        // Add data
        chart.data = $('#total_<?php echo e(convertStringToClass($chartName)); ?>').data('total');
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
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

    });

</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/invoices-aging.blade.php ENDPATH**/ ?>