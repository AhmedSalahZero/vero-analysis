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
.max-w-comment{

	min-width:700px !important;
	text-wrap:wrap !important;
	
}
#DataTables_Table_0_info{
	margin-bottom:20px;
}
    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;

    }

    .z-index-6 {
        position: relative;
        z-index: 1;
    }

    .mt--30 {
        margin-top: -30px;
    }









    .is-sub-row.is-total-row td.sub-numeric-bg,
    .is-sub-row.is-total-row td.sub-text-bg {
        background-color: #087383 !important;
        color: white !important;
    }

    . {
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
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Bank Statement ['  ) . $financialInstitutionName . ' ] [' . $accountTypeName . ' ] [ ' . $accountNumber . ' ] [ ' . __(touppercase($currency)) . ' ]'); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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


                <div class="table-custom-container position-relative  ">
                    <?php if(!$isCurrentAccount): ?>
                    <div class="d-flex z-index-6" style="justify-content:right">
                        <a href="<?php echo e(route('view.withdrawals.settlement.report',['company'=>$company->id ])); ?>" class="btn active-style btn-icon-sm align-self-center">
                            <i class="fas fa-book"></i>
                            <?php echo e(__('Withdrawals Settlement Report')); ?>

                        </a>
                    </div>
                    <?php endif; ?>

                    <div>


                        <div class="responsive mt--30">
                            <table class="table kt_table_with_no_pagination_no_collapse table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                                <thead>

                                    <tr class="header-tr ">

                                        <th class="view-table-th  header-th  align-middle text-center">
                                            <?php echo e(__('#')); ?>

                                        </th>

                                        <th class="view-table-th   header-th  align-middle text-center">
                                            <?php echo e(__('Date')); ?>

                                        </th>
                                        <?php if(! $isCurrentAccount): ?>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Limit')); ?>

                                        </th>
                                        <?php endif; ?>
                                        <?php if($isAgainstCommercialPaper || $isAgainstAssignmentOfContract): ?>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Actual Limit')); ?>

                                        </th>
                                        <?php endif; ?>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Beginning Balance')); ?>

                                        </th>


                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Debit')); ?>

                                        </th>

                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Credit')); ?>

                                        </th>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('End Balance')); ?>

                                        </th>

                                        <?php if(! $isCurrentAccount): ?>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo e(__('Room')); ?>

                                        </th>
                                        <th class="view-table-th     header-th  align-middle text-center">
                                            <?php echo __('Calculated <br> Interest'); ?>

                                        </th>


                                        <?php endif; ?>

                                        <th class="view-table-th   header-th  align-middle text-center">
                                            <?php echo e(__('Reviewed')); ?>

                                        </th>
										
										 <th class="view-table-th   header-th  align-middle text-center">
                                            <?php echo e(__('Actions')); ?>

                                        </th>
                                        <th class="view-table-th   header-th  align-middle text-center max-w-comment">
                                            <?php echo e(__('Comment')); ?>

                                        </th>



                                    </tr>

                                </thead>
                                <tbody>
                                    <script>
                                        let currentTable = null;

                                    </script>
                                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$modelAsStdClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                        <td class="sub-text-bg  "><?php echo e($index+1); ?></td>
                                        <td class="sub-text-bg  text-center "><?php echo e(\Carbon\Carbon::make($modelAsStdClass->date)->format('d-m-Y')); ?></td>
                                        <?php if(! $isCurrentAccount): ?>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->limit)); ?></td>
                                        <?php if($isAgainstCommercialPaper || $isAgainstAssignmentOfContract): ?>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->statement_limit)); ?></td>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->beginning_balance)); ?></td>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->debit)); ?></td>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->credit)); ?></td>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->end_balance)); ?></td>
                                        <?php if(! $isCurrentAccount): ?>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->room)); ?></td>
                                        <td class="sub-text-bg text-center "><?php echo e(number_format($modelAsStdClass->interest_amount)); ?></td>
                                        <?php endif; ?>
										<?php
								
											 $comment = isset($modelAsStdClass->{'comment_'.$lang}) ? $modelAsStdClass->{'comment_'.$lang} : null ;
											
											$reviewedArr = getBankStatementReviewed($modelAsStdClass) ;
											$reviewedText = getReviewedText($reviewedArr);
											
										?>
								
                                        <td class="sub-text-bg text-left "><?php echo e($reviewedText); ?></td>
                                        <td class="sub-text-bg text-left ">
							
											<?php if(isset($modelAsStdClass->is_commission_fees) && $modelAsStdClass->is_commission_fees): ?>
												
												<?php echo $__env->make('modals.edit-commissions-fees',[
													'currentStatementId'=>$modelAsStdClass->id,
													'currentCredit'=>$modelAsStdClass->credit
													,'currentDate'=>$modelAsStdClass->date ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
																					
											<?php endif; ?>
										</td>
                                        <td class="sub-text-bg text-left max-w-comment"><?php echo e($comment?: getBankStatementComment($modelAsStdClass)); ?></td>

                                 


                                    </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>








                                </tbody>
								
                            </table>
<?php echo e($results->appends(Request()->all())->links()); ?>

                        </div>
                    </div>

                    <?php $__env->startPush('js'); ?>
                    <script>
                        var table = $(".kt_table_with_no_pagination_no_collapse");






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

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/bank_statement_result.blade.php ENDPATH**/ ?>