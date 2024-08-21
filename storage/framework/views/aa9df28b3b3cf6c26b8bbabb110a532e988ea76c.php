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
    .dt-buttons.btn-group.flex-wrap {
        margin-bottom: 5rem !important;
    }

    #DataTables_Table_0_filter {
        display: none !important;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
    }


    .max-w-name {
        width: 45% !important;
        min-width: 45% !important;
        max-width: 45% !important;
    }

    .max-w-currency {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .max-w-amount {
        width: 15% !important;
        min-width: 15% !important;
        max-width: 15% !important;
    }

    .max-w-report-btn {
        width: 15% !important;
        min-width: 15% !important;
        max-width: 15% !important;
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
        max-width: 50%;
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
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($title); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <div class="kt-portlet">


            <div class="kt-portlet__body">

                <?php

                $tableId = 'kt_table_1';
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
                <?php echo csrf_field(); ?>

                <div class="kt-portlet mb-0">
                 
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl ">
                    <?php
                    $index = 0 ;
                    ?>
                    <?php $__currentLoopData = $cardNetBalances['currencies'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName=>$total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.money-card','data' => ['invoiceType' => $modelType,'showReport' => 1,'color' => getColorFromIndex($index),'currencyName' => $currencyName,'total' => $total]]); ?>
<?php $component->withName('money-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['invoiceType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($modelType),'show-report' => 1,'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(getColorFromIndex($index)),'currencyName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currencyName),'total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($total)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <?php
                    $index++;
                    ?>
                    <?php if($loop->last && isset($cardNetBalances['main_currency'])): ?>
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.money-card','data' => ['invoiceType' => $modelType,'showReport' => 0,'color' => 'success','currencyName' => 'Main Currency ' .'['. array_key_first($cardNetBalances['main_currency'] ) . ']','total' => $cardNetBalances['main_currency'][$mainCurrency] ?? 0]]); ?>
<?php $component->withName('money-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['invoiceType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($modelType),'show-report' => 0,'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('success'),'currencyName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Main Currency ' .'['. array_key_first($cardNetBalances['main_currency'] ) . ']'),'total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cardNetBalances['main_currency'][$mainCurrency] ?? 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </div>
            </div>
        </div>



        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <?php $__currentLoopData = $cardNetBalances['currencies']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName=>$total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($loop->first ? 'active':''); ?>" onclick="return false;" data-toggle="tab" href="#<?php echo e($currencyName.'report__table'); ?>" role="tab">
                                <i class="flaticon2-checking"></i> &nbsp; <?php echo e(__('Balance In').' ' .__($currencyName)); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </div>
            </div>
        </div>




        <div class="tab-content">
            <?php $__currentLoopData = $cardNetBalances['currencies']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName=>$total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane <?php echo e($loop->first ? 'active':''); ?>" id="<?php echo e($currencyName.'report__table'); ?>" role="tabpanel">
                <div class="kt-portlet">
                    <div class="kt-portlet__body with-scroll pt-0">

                        <div class="table-custom-container position-relative  ">


                            <div>




                                <div class="responsive">
                                    <table class="table kt_table_with_no_pagination_no_collapse table-for-currency-<?php echo e($currencyName); ?>  table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class-for-currency-<?php echo e($currencyName); ?> dataTable no-footer">
                                        <thead>

                                            <tr class="header-tr ">

                                                <th class="view-table-th max-w-serial  header-th  align-middle text-center">
                                                    <?php echo e(__('#')); ?>

                                                </th>

                                                <th class="view-table-th max-w-name   header-th  align-middle text-center">
                                                    <?php echo e(__('Name')); ?>

                                                </th>

                                                <th class="view-table-th  max-w-currency    header-th  align-middle text-center">
                                                    <?php echo e(__('Currency')); ?>

                                                </th>
                                                <th class="view-table-th max-w-amount    header-th  align-middle text-center">
                                                    <?php echo e(__('Net Balance')); ?>

                                                </th>

                                                <th class="view-table-th max-w-report-btn    header-th  align-middle text-center">
                                                    <?php echo e(__('Statement Report')); ?>

                                                </th>
                                                <th class="view-table-th max-w-report-btn    header-th  align-middle text-center">
                                                    <?php echo e(__('Invoice Report')); ?>

                                                </th>



                                            </tr>

                                        </thead>
                                        <tbody>
                                            <script>
                                                window['currentTable<?php echo e($currencyName); ?>'] = null;

                                            </script>
                                            <?php
                                            ?>
                                            <?php $__currentLoopData = $invoicesBalances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$invoicesBalancesAsStdClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $currencyName == $invoicesBalancesAsStdClass->currency): ?>
                                            <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                                <td class="sub-text-bg max-w-serial   "><?php echo e($index+1); ?></td>
                                                <td class="sub-text-bg  max-w-name is-name-cell "><?php echo e($invoicesBalancesAsStdClass->{$clientNameColumnName}); ?></td>
                                                <td class="sub-text-bg text-center max-w-currency"><?php echo e($currencyName); ?></td>
                                                <td class="sub-text-bg text-center max-w-amount"><?php echo e(number_format($invoicesBalancesAsStdClass->net_balance)); ?></td>
                                                <td class="sub-text-bg max-w-report-btn text-center">
                                                    <?php if($currencyName && $invoicesBalancesAsStdClass->{$clientNameColumnName}): ?>
                                                    <a href="<?php echo e(route('view.invoice.statement.report',['company'=>$company->id ,'partnerId'=>$invoicesBalancesAsStdClass->{$clientIdColumnName},'currency'=>$invoicesBalancesAsStdClass->currency,'modelType'=>$modelType])); ?>" class="btn btn-sm btn-primary" style="border-radius: 20px !important"><?php echo e($customersOrSupplierStatementText); ?></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="sub-text-bg max-w-report-btn text-center">
                                                    <?php if($invoicesBalancesAsStdClass->{$clientNameColumnName} && $invoicesBalancesAsStdClass->currency): ?>
                                                    <a href="<?php echo e(route('view.invoice.report',['company'=>$company->id ,'partnerId'=>$invoicesBalancesAsStdClass->{$clientIdColumnName},'currency'=>$invoicesBalancesAsStdClass->currency,'modelType'=>$modelType])); ?>" class="btn btn-sm btn-success" style="border-radius: 20px !important"><?php echo e(__('Invoices Report')); ?></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <?php $__env->startPush('js'); ?>
                            <script>
                                window['table<?php echo e($currencyName); ?>'] = $(".table-for-currency-<?php echo e($currencyName); ?>");
                                window['table<?php echo e($currencyName); ?>'].DataTable({
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
                                            if (!window['currentTable<?php echo e($currencyName); ?>']) {
                                                window['currentTable<?php echo e($currencyName); ?>'] = $('.main-table-class-for-currency-<?php echo e($currencyName); ?>').DataTable();
                                            }
                                            $('.buttons-html5').addClass('btn border-parent btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
                                            $('.buttons-print').addClass('btn border-parent top-0 btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')

                                        },





                                    }

                                )

                            </script>
                            <?php $__env->stopPush(); ?>

                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>








    </div>
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
<?php $__currentLoopData = $cardNetBalances['currencies'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName=>$total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>

$(function(){

	$('#<?php echo e($currencyName); ?>report__table .dt-buttons.btn-group').prepend('<a href="<?php echo e(route("view.invoice.statement.report",["company"=>$company->id ,"currency"=>$currencyName,"modelType"=>$modelType,"partnerId"=>0,"all_partners"=>1 ])); ?>" class="btn btn-primary buttons-copy buttons-html5 border-parent btn-border-export btn-bold ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away"> <?php echo e($currencyName); ?> <?php echo e($customersOrSupplierStatementText . ' '. __("Report")); ?> </a>')
})

</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/balances_form.blade.php ENDPATH**/ ?>