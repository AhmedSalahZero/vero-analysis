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
    .bg-lighter ,
    .bg-lighter * 
	{
        background-color: #E2EFFE !important;
        color: black !important;
    }

    .max-w-weeks {
        max-width: 100px !important;
        min-width: 100px !important;
        width: 100px !important;
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
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Weekly Cash Flow Report')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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


                <?php
                $grandTotal = $customerAgings['grand_total'] ??0
                ?>
                <div class="table-custom-container position-relative  ">



                    <div class="responsive">
                        <table class="table kt_table_with_no_pagination_no_collapse table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                            <thead>

                                <tr class="header-tr ">
                                    <th rowspan="3" class="view-table-th expand-all is-open-parent header-th editable-date max-w-classes-expand align-middle text-center trigger-child-row-1">
                                        <?php echo e(__('Expand All' )); ?>

                                        <span>+</span>
                                    </th>
                                    <th rowspan="3" class="view-table-th header-th max-w-classes-name align-middle text-center">
                                        <?php echo e(__('Item')); ?>

                                    </th>
                                    <th class="view-table-th  bg-lighter max-w-weeks header-th  align-middle text-center">
                                        <?php echo e(__('Week Num')); ?>

                                    </th>
                                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekAndYear => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$year = explode('-',$weekAndYear)[1];
									?>
                                    <th class="view-table-th bg-lighter header-th max-w-weeks align-middle text-center">
										<span class="d-block"><?php echo e(__('Week ' .  $week )); ?></span>
										<span class="d-block"><?php echo e('[ ' . $year . ' ]'); ?></span>
									</th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <th rowspan="3" class="view-table-th editable-date align-middle text-center header-th max-w-grand-total">
                                        <?php echo e(__('Total')); ?>

                                    </th>

                                </tr>

                                <tr class="header-tr ">


                                    <th class="view-table-th header-th max-w-weeks  align-middle text-center" class="header-th">
                                        <?php echo e(__('Start Date')); ?>

                                    </th>
                                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$startAndEndDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="view-table-th header-th max-w-weeks text-nowrap  align-middle text-center"><?php echo e($startAndEndDate['start_date']); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>


                                <tr class="header-tr ">

                                    <th class="view-table-th header-th max-w-weeks  align-middle text-center" class="header-th">
                                        <?php echo e(__('End Date')); ?>

                                    </th>
                                      <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$startAndEndDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="view-table-th header-th text-nowrap max-w-weeks  align-middle text-center"><?php echo e($startAndEndDate['end_date']); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tr>




                            </thead>
                            <tbody>
                                <script>
                                    let currentTable = null;

                                </script>
                                <?php
                                $rowIndex = 0 ;
                                ?>
                                <?php $__currentLoopData = ['Cash & Banks Begining Balance','Checks Collected','Incoming Transfers','Bank Deposits','Cash Collections','Customers Invoices','Customers Past Due Invoices','Cheques In Safe','Cheques Under Collection','Sales Forecast Collections','Total Cash Inflow','Outgoing Transfers','Cash Payments','Paid Payable Cheques','Under Payment Payable Cheques','Suppliers Invoices','Suppliers Past Due Invoices','Operational Expenses Payments','Wages & Salaries Payments','Taxes & Social Insurance Payments','Forecasted Suppliers Payments','Total Cash Outflow','Cash Flow From Operations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($customerName == 'total' || $customerName =='grand_total' || $customerName =='total_of_due' || $customerName =='total_customers_due'): ?>
                                <?php continue; ?> ;
                                <?php endif; ?>
                                <?php
                                $hasSubRows = count($customerAging['invoices']??[]) ;
                                $currentTotal = $customerAging['total'] ?? 0 ;
                                ?>
                                <tr class=" <?php if($customerName == 'Total Cash Inflow' || $customerName == 'Total Cash Outflow'): ?> bg-lighter <?php else: ?>  <?php endif; ?>  parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   " data-model-id="<?php echo e($rowIndex); ?>">
                                    <td class="red reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize main-tr is-close"> <?php if($hasSubRows): ?> + <?php endif; ?>  </td>
                                    <td class="sub-text-bg   editable-text  max-w-classes-name is-name-cell "><?php echo e($customerName); ?></td>
                                    <td class="  sub-numeric-bg text-center editable-date"> 
										<?php if($customerName == 'Customers Past Due Invoices'): ?>
										<button   class="btn btn-sm btn-warning text-white js-show-customer-due-invoices-modal"><?php echo e(__('View')); ?></button>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.due-invoices','data' => ['currentInvoiceType' => 'CustomerInvoice','dates' => $dates,'weeks' => $weeks,'pastDueCustomerInvoices' => $pastDueCustomerInvoices,'id' => 'test-modal-id']]); ?>
<?php $component->withName('modal.due-invoices'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentInvoiceType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('CustomerInvoice'),'dates' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dates),'weeks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($weeks),'pastDueCustomerInvoices' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pastDueCustomerInvoices),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
										
										<?php endif; ?> 
										
											<?php if($customerName == 'Suppliers Past Due Invoices'): ?>
										<button   class="btn btn-sm btn-warning text-white js-show-customer-due-invoices-modal"><?php echo e(__('View')); ?></button>
                                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modal.due-invoices','data' => ['currentInvoiceType' => 'SupplierInvoice','dates' => $dates,'weeks' => $weeks,'pastDueCustomerInvoices' => $pastDueSupplierInvoices,'id' => 'test-modal-id']]); ?>
<?php $component->withName('modal.due-invoices'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentInvoiceType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('SupplierInvoice'),'dates' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dates),'weeks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($weeks),'pastDueCustomerInvoices' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pastDueSupplierInvoices),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-modal-id')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
										
										<?php endif; ?> 
										
										
									
									 </td>
									
                                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekAndYear => $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
                                    <?php
									$year = explode('-',$weekAndYear)[1];
                                    $currentValue = $result[$customerName][$weekAndYear] ?? 0 ;
									if($customerName == 'Customers Past Due Invoices' )
									{
										$startDate = $dates[$weekAndYear]['start_date'] ;
										$currentRow = $customerDueInvoices->where('week_start_date',$startDate)->first() ;
										$currentValue =$currentRow ?  $currentRow->amount : 0;
										
									}
									if($customerName == 'Suppliers Past Due Invoices' )
									{
										$startDate = $dates[$weekAndYear]['start_date'] ;
										$currentRow = $supplierDueInvoices->where('week_start_date',$startDate)->first() ;
										$currentValue =$currentRow ?  $currentRow->amount : 0;
										
									}
                                    $currentPercentage = $currentValue && $currentTotal ? $currentValue/ $currentTotal * 100 : 0 ;
                                    ?>
                                    <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($currentValue,0)); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td class="  sub-numeric-bg text-center editable-date"><?php echo e(number_format($result[$customerName]['total'][$year] ?? 0 )); ?></td>

                                </tr>



                                <?php
                                $rowIndex = $rowIndex+ 1;
                                ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                





                                












                            </tbody>
                        </table>
                    </div>

                </div>

                <?php $__env->startPush('js'); ?>
                <script>
                    $(document).on('click', '.trigger-child-row-1', function(e) {
                        const parentId = $(e.target.closest('tr')).data('model-id');
                        var parentRow = $(e.target).parent();
                        var subRows = parentRow.nextAll('tr.add-sub.maintable-1-row-class' + parentId);
                        console.log(parentId, parentRow, subRows);

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
                    if ($('.kt-portlet__body').length) {
                        $('.kt-portlet__body').append(`<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i> <i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>`)
                        $(document).on('click', '.arrow-nav', function() {
                            const scrollLeftOfTableBody = document.querySelector('.kt-portlet__body').scrollLeft
                            const scrollByUnit = 50
                            if (this.classList.contains('arrow-right')) {
                                document.querySelector('.dataTables_scrollBody').scrollLeft += scrollByUnit

                            } else {
                                document.querySelector('.dataTables_scrollBody').scrollLeft -= scrollByUnit

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
 $(document).on('click', '.js-show-customer-due-invoices-modal', function(e) {
        e.preventDefault();
        $(this).closest('td').find('.modal-item-js').modal('show')
    })
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/reports/weekly-cash-flow-report.blade.php ENDPATH**/ ?>