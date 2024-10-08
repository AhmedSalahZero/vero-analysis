<?php
use Carbon\Carbon;
?>

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
    .max-w-invoice-date {
        width: 25% !important;
        min-width: 25% !important;
        max-width: 25% !important;
    }

    .max-w-counts {
        width: 20% !important;
        min-width: 20% !important;
        max-width: 20% !important;
    }

    .max-w-action {
        width: 25% !important;
        min-width: 25% !important;
        max-width: 25% !important;
    }

    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .dt-buttons.btn-group.flex-wrap {
        margin-bottom: 5rem !important;
    }

    #DataTables_Table_0_filter {
        display: none !important;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
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
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Adjusted Renewal Date')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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









                <div class="row">
                    <div class="col-md-12">
                        <!--begin::Portlet-->


                        <!--begin::Form-->
                        <form method="post" action="<?php echo e(isset($model) ? route('update.letter.of.issuance.renewal.date',['company'=>$company->id, 'letterOfGuaranteeIssuance'=>$letterOfGuaranteeIssuance->id , 'LgRenewalDateHistory'=>$model->id]) :route('store.letter.of.issuance.renewal.date',['company'=>$company->id , 'letterOfGuaranteeIssuance'=>$letterOfGuaranteeIssuance->id])); ?>" class="kt-form kt-form--label-right">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($model)): ?>
                            <?php echo method_field('patch'); ?>
                            <?php endif; ?>
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title head-title text-primary">
                                            <?php echo e(__('Adjusted Collection Date Section')); ?>

                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="form-group row">
                                        <div class="col-md-4 mb-4">
                                            <label> <?php echo e(__('Transaction Name')); ?> </label>
                                            <input type="text" class="form-control" disabled value="<?php echo e($letterOfGuaranteeIssuance->getTransactionName()); ?>">
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label><?php echo e(__('Source')); ?> </label>
                                            <input type="text" class="form-control" disabled value="<?php echo e($letterOfGuaranteeIssuance->getSourceFormatted()); ?>">
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <label><?php echo e(__('LG Code')); ?> </label>
                                            <input type="text" class="form-control" disabled value="<?php echo e($letterOfGuaranteeIssuance->getLgCode()); ?>">
                                        </div>
										
										     <div class="col-md-3 mb-4">
                                            <label><?php echo e(__('Issuance Date')); ?> </label>
                                            <input type="text" class="form-control" disabled value="<?php echo e($letterOfGuaranteeIssuance->getIssuanceDateFormatted()); ?>">
                                        </div>
										
                                        <div class="col-md-3 mb-4">
                                            <label><?php echo e(__('Expiry Date')); ?> </label>
                                            <input type="text" class="form-control" disabled value="<?php echo e($letterOfGuaranteeIssuance->getRenewalDateFormatted()); ?>">
                                        </div>
										
										  <div class="col-md-3">
                                            <label><?php echo e(__('New Expiry Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                                            <div class="kt-input-icon">
                                                <div class="input-group date">
                                                    <input required type="text" name="renewal_date" value="<?php echo e(isset($model) ? $model->getRenewalDateFormattedForDatePicker() : null); ?>" id="kt_datepicker_2" class="form-control" readonly placeholder="<?php echo e(__('Select date')); ?>" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
                                    <div class="col-md-3 mb-4">
                                            <label><?php echo e(__('Renewal Fees')); ?> </label>
                                            <input type="text" class="form-control only-greater-than-or-equal-zero-allowed" name="fees_amount" value="<?php echo e(isset($model)  ? $model->getFeesAmount() : 0); ?>">
                                        </div>
                                       
                                      
                                    </div>
                                </div>
                            </div>

                             <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        </form>
                    </div>
                </div>

                <div class="kt-portlet">

                    <div class="kt-portlet__body with-scroll pt-0">

                        <div class="table-custom-container position-relative  ">


                            <div>




                                <div class="responsive">
                                    <table class="table kt_table_with_no_pagination_no_collapse table-for-currency  table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class-for-currency dataTable no-footer">
                                        <thead>

                                            <tr class="header-tr ">

                                                <th class="view-table-th max-w-serial  header-th  align-middle text-center">
                                                    <?php echo e(__('#')); ?>

                                                </th>

                                                <th class="view-table-th max-w-name  max-w-invoice-date header-th  align-middle text-center">
                                                    <?php echo e(__('Date')); ?>

                                                </th>

                                                <th class="view-table-th max-w-name  max-w-counts header-th  align-middle text-center">
                                                    <?php echo e(__('Days Count')); ?>

                                                </th>

                                                <th class="view-table-th max-w-name  max-w-counts header-th  align-middle text-center">
                                                    <?php echo e(__('Fees Amount')); ?>

                                                </th>


                                                <th class="view-table-th max-w-name max-w-action  header-th  align-middle text-center">
                                                    <?php echo e(__('Actions')); ?>

                                                </th>







                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $previousDate = null ;
                                            ?>
                                            <?php $__currentLoopData = $renewalDateHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $renewalDateHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                                <td class="sub-text-bg max-w-serial text-center   "><?php echo e(++$index); ?></td>
                                                <td class="sub-text-bg max-w-invoice-date  text-center   "><?php echo e($currentRenewalDate = $renewalDateHistory->getRenewalDateFormatted()); ?> <?php echo e(is_null($previousDate) ? __(' (Original Renewal Date) ') : ''); ?> </td>
                                                <td class="sub-text-bg  text-center  max-w-counts "><?php echo e($previousDate ? getDiffBetweenTwoDatesInDays(Carbon::make($previousDate),Carbon::make($currentRenewalDate)) : '-'); ?></td>
                                                <?php
                                                $previousDate = $renewalDateHistory->getRenewalDate();
                                                ?>
                                                <td class="sub-text-bg  text-center max-w-counts "><?php echo e($renewalDateHistory->getFeesAmountFormatted()); ?></td>
                                                <td class="sub-text-bg  text-center max-w-action   ">
                                                    <?php if($loop->last): ?>
                                                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.issuance.renewal.date',[$company,$letterOfGuaranteeIssuance->id,$renewalDateHistory->id])); ?>"><i class="fa fa-pen-alt"></i></a>


                                                    <a class="btn btn-secondary btn-outline-hover-danger btn-icon  " href="#" data-toggle="modal" data-target="#modal-delete-<?php echo e($renewalDateHistory['id']); ?>" title="Delete"><i class="fa fa-trash-alt"></i>
                                                    </a>
                                                    <?php endif; ?>

                                                    <div id="modal-delete-<?php echo e($renewalDateHistory['id']); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><?php echo e(__('Delete Renewal Date History ' .$renewalDateHistory->getRenewalDateFormatted())); ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3><?php echo e(__('Are You Sure To Delete This Item ? ')); ?></h3>
                                                                </div>
                                                                <form action="<?php echo e(route('delete.letter.of.issuance.renewal.date',[$company,$letterOfGuaranteeIssuance->id,$renewalDateHistory->id])); ?>" method="post" id="delete_form">
                                                                    <?php echo e(csrf_field()); ?>

                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-danger">
                                                                            <?php echo e(__('Delete')); ?>

                                                                        </button>
                                                                        <button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">
                                                                            <?php echo e(__('Close')); ?>

                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <?php $__env->startPush('js'); ?>
                            <script>
                                $('.table-for-currency').DataTable({
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



    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfGuaranteeIssuance/renewal-date/index.blade.php ENDPATH**/ ?>