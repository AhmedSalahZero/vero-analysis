<?php
$tableId = 'kt_table_1';
?>

<style>
    html body table tr.edit-info-row[data-sub-item-name][data-percentage-value][data-is-quantity="1"] td {
        background-color: antiquewhite !important;
    }

    .checkboxes-vat {
        margin-top: 15px;
    }
	#kt_table_1_filter{
		display:none;
	}

    .max-w-actions {
        width: 55px !important;
        max-width: 55px !important;
        min-width: 55px !important;
    }

    th:first-of-type,
    td:first-of-type {
        width: 135px !important;
        max-width: 135px !important;
        min-width: 135px !important;
    }

    .financial-income-or-expense-id {
        justify-content: flex-start !important;
    }

    td.editable-date,
    th.editable-date,
    input.editable-date {
        width: 100px !important;
        min-width: 100px !important;
        max-width: 100px !important;
        overflow: hidden;
    }

    td.editable-text,
    th.editable-text,
    .is-name-cell {
        width: 285px !important;
        min-width: 285px !important;
        max-width: 285px !important;
    }

    th.total-row,
    td.total-row {
        width: 110px !important;
        min-width: 110px !important;
        max-width: 110px !important;
    }

    .blured-item {
        padding-right: 0 !important;
    }

    .basis-100 {
        flex-basis: 100%;
    }

    .checkboxes-for-quantity {
        display: flex;
    }

    .checkboxes-for-quantity>* {
        margin-right: 20px;
    }

    .pl-25 {
        padding-left: 17px;
        padding-right: 17px;
    }

    .how-many-item {
        flex-wrap: wrap !important;
        flex-direction: column;
        justify-content: flex-start !important;
        align-items: flex-start !important;
    }

    .flex-checkboxes {
        width: 100% !important;
    }

    .w-160px {
        width: 160px !important
    }

    .bootstrap-select {
        width: 100% !important;
    }

    .margin-left-auto {
        margin-left: auto
    }

    .width-66 {
        width: 75% !important;
    }

    .repeating-fixed-sub {
        width: 100%
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

    .flex-checkboxes>div:not(.modal-footer) {
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

    /* table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control::before, table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control::before,
    .dataTables_wrapper table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td:first-child::before
    {
        content:none ;
    } */
    .modal-backdrop {
        display: none !important;
    }

    .modal-content {
        min-width: 600px !important;
    }

    .form-check {
        padding-left: 0 !important;

    }

    .main-with-no-child {
        background-color: white !important;
        font-weight: bold;
    }

    .is-sub-row td.sub-text-bg {
        background-color: #aedbed !important;
        color: black !important;

    }

    .sub-numeric-bg {
        text-align: center;

    }

    .is-sub-row td.sub-numeric-bg,
    .is-sub-row td.sub-text-bg {
        border: 1.5px solid white !important;
        background-color: #0e96cd !important;
        color: white !important;


        background-color: #E2EFFE !important;
        color: black !important
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
<input type="hidden" id="is-actual-table" value="<?php echo e((int) in_array('actual-report',Request()->segments())); ?>">
<input type="hidden" id="editable-by-btn" value="1">
<?php if(in_array($reportType,['adjusted'])): ?>
<input type="hidden" id="fixed-column-number" value="2">
<?php else: ?>
<input type="hidden" id="fixed-column-number" value="3">
<?php endif; ?>
<input type="hidden" id="sub-item-type" value="<?php echo e($reportType); ?>">
<input type="hidden" id="income_statement_id" value="<?php echo e($incomeStatement->id); ?>">

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Upload Actual Data For ')  . $incomeStatement->getName()); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" action="<?php echo e(route('admin.import.excel.template',['company'=>$company->id,'incomeStatement'=>$incomeStatement->id])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="upload__excel " style="height:100px;display:flex;align-items:center;">

                        <input name="excel_file" type="file" value="<?php echo e(__('Choose File')); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Upload')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-custom-container position-relative  ">
    <input type="hidden" value="<?php echo e($incomeStatement->id); ?>" id="model-id">
    <input type="hidden" id="income-statement-duration-type" value="<?php echo e($incomeStatement->duration_type ?? ''); ?>">

    <input type="hidden" id="cost-of-goods-id" value="<?php echo e(\App\Models\IncomeStatementItem::COST_OF_GOODS_ID); ?>">
    <input type="hidden" id="sales-growth-rate-id" value="<?php echo e(\App\Models\IncomeStatementItem::SALES_GROWTH_RATE_ID); ?>">
    <input type="hidden" id="sales-revenue-id" value="<?php echo e(\App\Models\IncomeStatementItem::SALES_REVENUE_ID); ?>">
    <input type="hidden" id="gross-profit-id" value="<?php echo e(\App\Models\IncomeStatementItem::GROSS_PROFIT_ID); ?>">
    <input type="hidden" id="market-expenses-id" value="<?php echo e(\App\Models\IncomeStatementItem::MARKET_EXPENSES_ID); ?>">
    <input type="hidden" id="sales-and-distribution-expenses-id" value="<?php echo e(\App\Models\IncomeStatementItem::SALES_AND_DISTRIBUTION_EXPENSES_ID); ?>">
    <input type="hidden" id="general-expenses-id" value="<?php echo e(\App\Models\IncomeStatementItem::GENERAL_EXPENSES_ID); ?>">
    <input type="hidden" id="earning-before-interest-taxes-depreciation-amortization-id" value="<?php echo e(\App\Models\IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID); ?>">
    <input type="hidden" id="earning-before-interest-taxes-id" value="<?php echo e(\App\Models\IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_ID); ?>">
    <input type="hidden" id="financial-income-or-expenses-id" value="<?php echo e(\App\Models\IncomeStatementItem::FINANCIAL_INCOME_OR_EXPENSE_ID); ?>">
    <input type="hidden" id="earning-before-taxes-id" value="<?php echo e(\App\Models\IncomeStatementItem::EARNING_BEFORE_TAXES_ID); ?>">
    <input type="hidden" id="corporate-taxes-id" value="<?php echo e(\App\Models\IncomeStatementItem::CORPORATE_TAXES_ID); ?>">
    <input type="hidden" id="net-profit-id" value="<?php echo e(\App\Models\IncomeStatementItem::NET_PROFIT_ID); ?>">
    <input type="hidden" id="sales-rate-maps" value="<?php echo e(json_encode(\App\Models\IncomeStatementItem::salesRateMap())); ?>">
    <input type="hidden" id="vat-rates-maps" value="<?php echo e(json_encode(\App\Models\IncomeStatementItem::vatRatesMap())); ?>">
    <script>
        let sales_rates_maps = document.getElementById('sales-rate-maps').value;
        const sales_rate_maps = JSON.parse(sales_rates_maps);
        let opens = [];
        let globalTable = null;
        let canRedrawWitdth = false;
        let canSendAjaxRequest = true;
        let inEditMode = false;
        let lastInputValue = 0;
        let numberOfConsole = 0
        let lastPercentageSubItemOfEachMainRow = {}
        let lastCostOfUnitSubItemOfEachMainRow = {}
        let modalIsOpenInAddOrEdit = false
        let currentDelete = {}
        let deleteModalIsOpen = false
        let salesRevenueModalTdData = {}
        let nonRepeatingModalTdData = {}
        const vatRateMaps = JSON.parse(document.getElementById('vat-rates-maps').value);

        //	const performance2 = {
        //		
        //	isLastSublingPercentageOfCostOfUnitOfParent:0,
        //	updateNetProfit:0,
        //	updateEarningBeforeTaxes:0,
        //	updateEarningBeforeIntersetTaxesDepreciationAmortization:0,
        //	updateEarningBeforeInterestTaxesDepreciationAmortizationId:0,
        //	insertTableIntoDom:0,
        //	formateTableForNewRow:0,
        //	updateGrossProfit:0,
        //	getRowForSubItemsTr:0,
        //	updateTotalForRow:0,
        //	updateGrowthRateForSalesRevenue:0,
        //	updatePercentageOfSalesFor:0,
        //	getPreviousDate:0,
        //	getDates:0,
        //	updateParentMainRowTotal:0 ,
        //	updateEditableInputs:0,
        //	updatePercentageRows:0,
        //	blur:0,
        //	triggerChangeInsideBlur:0,
        //	refreshPercentagesThatDependsOnSalesRevenueValue:0
        //	}

        const domElements = {
            salesRevenueId: document.getElementById('sales-revenue-id').value
            , salesGrowthRateId: document.getElementById('sales-growth-rate-id').value
            , growthProfitId: document.getElementById('gross-profit-id').value
            , corporateTaxesId: document.getElementById('corporate-taxes-id').value
            , costOfGoodsId: document.getElementById('cost-of-goods-id').value
            , financialIncomeOrExpensesId: document.getElementById('financial-income-or-expenses-id').value
            , marketExpensesId: document.getElementById('market-expenses-id').value
            , generalExpensesId: document.getElementById('general-expenses-id').value
            , salesAndDistributionExpensesId: document.getElementById('sales-and-distribution-expenses-id').value
            , earningBeforeInterestTaxesId: document.getElementById('earning-before-interest-taxes-id').value
            , earningBeforeInterestTaxesDepreciationAmor: document.getElementById('earning-before-interest-taxes-depreciation-amortization-id').value
            , earningBeforeTaxesId: document.getElementById('earning-before-taxes-id').value
            , netProfitId: document.getElementById('net-profit-id').value



        }
        const vars = {
            subItemType: document.getElementById('sub-item-type').value
        }

    </script>



     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.basic-view','data' => ['redirectRoute' => route('admin.view.financial.statement', getCurrentCompanyId()),'saveAndReturn' => true,'formId' => 'store-report-form-id','wrapWithForm' => true,'formAction' => route('admin.store.income.statement.report',['company'=>getCurrentCompanyId()]),'class' => 'position-relative table-with-two-subrows main-table-class','id' => ''.e($tableId).'']]); ?>
<?php $component->withName('tables.basic-view'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['redirect-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.view.financial.statement', getCurrentCompanyId())),'save-and-return' => true,'form-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('store-report-form-id'),'wrap-with-form' => true,'form-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.store.income.statement.report',['company'=>getCurrentCompanyId()])),'class' => 'position-relative table-with-two-subrows main-table-class','id' => ''.e($tableId).'']); ?>
         <?php $__env->slot('filter'); ?> 
            <?php echo $__env->make('admin.income-statement.report.filter' , [
            'type'=>'filter'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('export'); ?> 
            <?php echo $__env->make('admin.income-statement.report.export' , [
            'type'=>'export'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php $__env->endSlot(); ?>


         <?php $__env->slot('headerTr'); ?> 
            <input type="hidden" name="sub_item_type" value="<?php echo e(getReportNameFromRouteName(Request()->route()->getName())); ?>">
            <input type="text" style="height:0;overflow:hidden;width:0;background-color:transparent;border:none;color:transparent;" id="pdf_only" name="opens">
            <input type="text" style="height:0;overflow:hidden;width:0;background-color:transparent;border:none;color:transparent;" id="export_type" name="dynamic_rows_shown">
            <tr class="header-tr " data-model-name="<?php echo e($modelName); ?>">
                <th class="view-table-th header-th trigger-child-row-1 expand-all is-open-parent text-nowrap">
                    <?php echo e(__('Expand')); ?>

                    <span>+</span>
                </th>

                <th style="max-w-actions" class="view-table-th header-th" data-db-column-name="id" data-is-relation="0" class="header-th" data-is-json="0">
                    <?php echo e(__('Actions')); ?>

                </th>
                <th class="view-table-th header-th" data-is-collection-relation="0" data-collection-item-id="0" data-db-column-name="name" data-relation-name="BussinessLineName" data-is-relation="1" class="header-th" data-is-json="0">
                    <?php echo e(__('Name')); ?>

                    
                </th>
                <input type="hidden" name="dates" data-formatted="<?php echo e(json_encode(($incomeStatement->getIntervalFormatted()))); ?>" value="<?php echo e(json_encode(array_keys($incomeStatement->getIntervalFormatted()))); ?>" id="dates">
                <?php $__currentLoopData = $incomeStatement->getIntervalFormatted(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $defaultDateFormate=>$interval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th data-is-actual="<?php echo e((int)isActualDate($defaultDateFormate)); ?>" data-date="<?php echo e($defaultDateFormate); ?>" data-month-year="<?php echo e(explode('-',$defaultDateFormate)[0].'-'.explode('-',$defaultDateFormate)[1]); ?>" class="view-table-th header-th text-wrap" data-is-collection-relation="0" data-collection-item-id="0" data-db-column-name="name" data-relation-name="ServiceCategory" data-is-relation="1" class="header-th" data-is-json="0">
                    <?php echo e($interval); ?>

                    <?php if(isActualDate($defaultDateFormate) && $reportType != 'forecast'): ?>
                    <br>(<?php echo e(__('Actual')); ?>)
                    <?php elseif($reportType != 'forecast'): ?>
                    <br>(<?php echo e(__('Forecast')); ?>)
                    <?php endif; ?>
                    <?php if((int)isActualDate($defaultDateFormate)): ?>
                    <div class="is-actual-dates" data-date="<?php echo e($defaultDateFormate); ?>" style="visibility:hidden"></div>
                    <?php endif; ?>
                </th>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th class="view-table-th header-th">
                    <?php echo e(__('Total')); ?>

                </th>

                <div hidden type="hidden" id="cols-counter" data-value="0"> </div>
                <script>
                    countHeadersInPage('.main-table-class th', '#cols-counter');

                </script>

            </tr>

         <?php $__env->endSlot(); ?>

         <?php $__env->slot('js'); ?> 

            <script>
                let inAddOrEditModal = false;
                let canRefreshPercentages = false;
                window.addEventListener('DOMContentLoaded', function() {
                    (function($) {
						$(document).on('change','.names-items-names',function(){
							var names = [];
							$('#new_items_names').val('[]');
							$('.names-items-names').each(function(index,input){
								var currentName = $(input).val() ;
								if(currentName!=''){
								names.push(currentName);
									
								}
							})
							$('#new_items_names').val(names);
						});
                        window.addEventListener('scroll', function() {
                            const top = window.scrollY > 140 ? window.scrollY : 140;

                            $('.arrow-nav').css('top', top + 'px')
                        })
                        if ($('.kt-portlet__body').length) {

                            $('.kt-portlet__body').append(`
								<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i>
								<i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>
								`)

						
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
                        $(document).on('click', '.import-modal-class', function() {

                            $('#exampleModalCenter').modal('show')

                        })
                        $(document).on('change', '.trim-when-key-up', function() {
                            $(this).val($(this).val().trim())
                        })
                        $(document).on("hidden.bs.modal", '.modal', function(e) {
                            if ($('.modal:visible').length) {
                                $('body').addClass('modal-open');
                            }
                        });
                        $(document).on('click', '.repeat-row', function() {

                            const parentQuery = this.getAttribute('data-parent-query')
                            const columnIndex = this.getAttribute('data-column-index')
                            const rowIndex = this.getAttribute('data-row-index')
                            const parent = $(this).parent()
                            const tr = $(this).closest(parentQuery)

                            const currentVal = filterNumericUserInput(parent.find('input[type="text"]').val(), false)
                            tr.find('input[type="text"]').each(function(i, inputText) {
                                var date = $(inputText).attr('data-date')
                                if (Date.parse(date) > Date.parse(columnIndex)) {
                                    $(inputText).val(currentVal).trigger('blur')
                                }
                            })
                        })

                        $(document).on('change', 'input[name*="is_depreciation_or_amortization"]', function() {
                            const val = $(this).is(':checked');

                            if (val) {
                                $(this).closest('.modal').find('.collection-policy').addClass('d-none').removeClass('d-flex')
                                $(this).closest('.modal').find('.collection-policy input,.collection-policy select').prop('disabled', true)
                                $(this).closest('.modal').find('.checkboxes-vat').addClass('d-none').removeClass('d-flex')
                                $(this).closest('.modal').find('.checkboxes-vat input,.checkboxes-vat select').prop('disabled', true)
                            } else {
                                $(this).closest('.modal').find('.collection-policy').removeClass('d-none').addClass('d-flex')
                                $(this).closest('.modal').find('.collection-policy input,.collection-policy select').prop('disabled', false)

                                $(this).closest('.modal').find('.checkboxes-vat').removeClass('d-none').addClass('d-flex')
                                $(this).closest('.modal').find('.checkboxes-vat input,.checkboxes-vat select').prop('disabled', false)
                            }
                        })

                        $(document).on('change', '.collection_rate_input', function() {


                            let percentage = filterNumericUserInput($(this).val())
                            percentage = parseFloat(percentage)
                            if (percentage > 100) {
                                $(this).val(0)
                                Swal.fire({
                                    text: 'Percentage Can Not Be Greater Than 100'
                                    , icon: 'warning'
                                })
                            }
                            let total = 0;

                            $(this).closest('.collection-policy').find('.collection_rate_input').each(function(index, input) {
                                total += parseFloat(input.value ? input.value : 0)
                            })

                            if (total > 100) {
                                total = total - percentage
                                $(this).val(0)
                                Swal.fire({
                                    text: 'Total Can Not Be Greater Than 100'
                                    , icon: 'warning'
                                })

                            }
                            $(this).closest('.collection-policy').find('.collection_rate_total_class').val(number_format(total, 2) + ' %')
                        })

                        $(document).on('change', '.can-trigger-quantity-modal', function() {
                            let quantityOrPrice = $(this).val()
                            let currentIndex = $(this).closest('.how-many-item').attr('data-index')
                            currentIndex = currentIndex == undefined ? 0 : currentIndex

                            let inEditMode = $(this).attr('data-in-edit-mode')
                            let subItemName = $(this).attr('data-sub-item-name')
                            $(this).closest('.quantity-section').find('[data-index]').attr('data-index', currentIndex)

                            let currentCheckedItem = $(this).parent().parent().find('input[name="sub_items[' + currentIndex + '][is_quantity]"]:checked')
                            if (currentCheckedItem.length >= 1) {
                                let firstCheckboxValue = currentCheckedItem[0].value

                                if (currentCheckedItem.length == 1 && firstCheckboxValue != 'value') {
                                    return;
                                }
                                let firstCheckboxTr = salesRevenueModalTdData[inEditMode][subItemName][firstCheckboxValue]
                                let secondCheckboxValue = currentCheckedItem[1] ? currentCheckedItem[1].value : null
                                let secondCheckboxTr = secondCheckboxValue ? salesRevenueModalTdData[inEditMode][subItemName][secondCheckboxValue] : null


                                let checkedItems = [firstCheckboxValue, secondCheckboxValue]
                                let autocaulationItemValue = null;
                                if (!checkedItems.includes('value')) {
                                    autocaulationItem = 'value'
                                }
                                if (!checkedItems.includes('price')) {
                                    autocaulationItem = 'price'
                                }
                                if (!checkedItems.includes('quantity')) {
                                    autocaulationItem = 'quantity'
                                }

                                let thirdCheckboxTr = salesRevenueModalTdData[inEditMode][subItemName][autocaulationItem]
                                const onlyValueChecked = currentCheckedItem.length == 1;
                                if (onlyValueChecked) //only value allowed
                                {
                                    thirdCheckboxTr = '';
                                }
                                let trs = firstCheckboxTr + secondCheckboxTr + thirdCheckboxTr
                                let quantitySection = $(this).closest('.quantity-section')

                                trs = trs.replaceAll('sub_items[0]', 'sub_items[' + currentIndex + ']')
                                trs = trs.replaceAll('data-index="0"', 'data-index="' + currentIndex + '"')
                                trs = trs.replaceAll('modal-for-quantity-0', 'modal-for-quantity-' + currentIndex)

                                quantitySection.find('tbody.append-sales-revenue-modal-table-body').empty().append(trs)
                                if (!onlyValueChecked) {

                                    quantitySection.find('tbody.append-sales-revenue-modal-table-body tr:last-of-type input').prop('readonly', true)
                                }

                                var checkedItemsAsString = '';
                                checkedItems.forEach(function(element, index) {
                                    if (index) {
                                        checkedItemsAsString += ('_' + element);
                                    } else {
                                        checkedItemsAsString += (element);
                                    }
                                })
                                const name = "sub_items[" + currentIndex + "][is_value_quantity_price]";
                                const selector = '[name="' + name + '"]';
                                $(selector).val(checkedItemsAsString);
                                if (!onlyValueChecked) {

                                    quantitySection.find('tbody.append-sales-revenue-modal-table-body tr:last-of-type i.repeat-row').remove();
                                }
                                quantitySection.find('.modal-for-quantity[data-index="' + currentIndex + '"]').attr('id', 'modal-for-quantity-' + currentIndex)
                                quantitySection.find('.modal-for-quantity[data-index="' + currentIndex + '"]').attr('data-id', 'modal-for-quantity-' + currentIndex)
                                // to update total 
								quantitySection.find('.modal-for-quantity tr td:nth-of-type(2) input.hidden-for-popup:first-of-type').trigger('blur')

                                //$('.hidden-for-popup').trigger('blur')
                                $('.modal-for-quantity').addClass('d-none').addClass('fade').removeClass('d-block')
                                $('.modal-for-quantity[data-index="' + currentIndex + '"]').removeClass('fade').removeClass('d-none').addClass('d-block').modal('show')
                            } else {

                                const name = "sub_items[" + currentIndex + "][is_value_quantity_price]";
                                const selector = '[name="' + name + '"]';
                                $(selector).val('value');
                            }

                        })

                        $(document).on('change', '.can-trigger-non-repeating-modal', function() {
                            // return false ;

                            let currentIndex = $(this).closest('.how-many-item').attr('data-index')
                            currentIndex = currentIndex == undefined ? 0 : currentIndex
                            let inEditMode = +$(this).attr('data-in-edit-mode')
                            let subItemName = $(this).attr('data-sub-item-name')
                            $(this).closest('.non-repeating-section').find('[data-index]').attr('data-index', currentIndex)

                            let currentCheckedItem = $(this).parent().parent().find('input[name="sub_items[' + currentIndex + '][percentage_or_fixed]"]:checked')
                            if (currentCheckedItem.length >= 1) {
                                let firstCheckboxValue = 'value'

                                let firstCheckboxTr = nonRepeatingModalTdData[inEditMode][subItemName][firstCheckboxValue];

                                let checkedItems = [firstCheckboxValue]
                                let autocaulationItemValue = null;
                                let trs = firstCheckboxTr
                                let nonRepeatingSection = $('#modal-for-non-repeating-' + currentIndex)
                                trs = trs.replaceAll('sub_items[0]', 'sub_items[' + currentIndex + ']')
                                trs = trs.replaceAll('data-index="0"', 'data-index="' + currentIndex + '"')
                                trs = trs.replaceAll('modal-for-non-repeating-0', 'modal-for-non-repeating-' + currentIndex)
                                nonRepeatingSection.find('tbody.append-non-repeating-modal-table-body').empty().append(trs)
                                nonRepeatingSection.find('.modal-for-non-repeating[data-index="' + currentIndex + '"]').attr('id', 'modal-for-non-repeating-' + currentIndex)
                                nonRepeatingSection.find('.modal-for-non-repeating[data-index="' + currentIndex + '"]').attr('data-id', 'modal-for-non-repeating-' + currentIndex)

                                // to update total 
                                $('.append-non-repeating-modal-table-body tr td:nth-of-type(2) input.hidden-for-popup-non-repeating:first-of-type').trigger('blur')

                              //
                                $('.modal-for-non-repeating').addClass('d-none').addClass('fade').removeClass('d-block')
								
                                $('.modal-for-non-repeating[data-index="' + currentIndex + '"]').removeClass('fade').removeClass('d-none').addClass('d-block').modal('show')
                            }

                        })


                        $(document).on('change', '.only-one-checked', function() {
                            const parent = $(this).closest('.only-one-checked-parent')
                            parent.find('.only-one-checked').prop('checked', false)
                            parent.find('.for-only-one-checked').addClass('d-none').find('input,select').prop('disabled', true)
                            $(this).prop('checked', true)
                            const checkBoxValue = $(this).val()
                            parent.find('.for-only-one-checked[data-item="' + checkBoxValue + '"]').removeClass('d-none').find('input,select').prop('disabled', false)

                        })





                        $(document).on('change', '.only-one-checkbox', function() {
                            const parent = $(this).closest('.only-one-checkbox-parent')
                            parent.find('.only-one-checkbox').prop('checked', false)
                            $(this).prop('checked', true)
                        })

                        $(document).on('change', '.only-two-checkbox', function() {
                            const parent = $(this).closest('.only-two-checkbox-parent')
                            let currentCheckedLength = parent.find('.only-two-checkbox:checked').length
                            if (currentCheckedLength > 2) {
                                $(this).prop('checked', false)
                            }
                        })

                        function isLastSublingPercentageOfCostOfUnitOfParent(subRow) {

                            if (modalIsOpenInAddOrEdit) {
                                return true
                            }

                            let isCostOfUnit = subRow.getAttribute('data-is-cost-of-unit') && subRow.getAttribute('data-is-cost-of-unit') != 'false'
                            let isPercentage = subRow.getAttribute('data-is-percentage') && subRow.getAttribute('data-is-percentage') != 'false'
                            if (!isCostOfUnit && !isPercentage) {
                                return true;
                            }
                            // check if is last one of the same type of the same parent 
                            let mainRowId = subRow.getAttribute('data-financial-statement-able-item-id')
                            let lastPercentageSubItem = lastPercentageSubItemOfEachMainRow[mainRowId]
                            let lastCostOfUnitSubItem = lastCostOfUnitSubItemOfEachMainRow[mainRowId]
                            let currentSubItemName = subRow.getAttribute('data-sub-item-name')
                            return currentSubItemName == lastPercentageSubItem || currentSubItemName == lastCostOfUnitSubItem;

                        }

                        $(document).on('change', '.is-sub-row input:not([type="checkbox"]):not(.collection_rate_input)', function(e) {
                            let grossProfitId = domElements.growthProfitId;
                            let costOfGoodsId = domElements.costOfGoodsId;
                            let salesRevenueId = domElements.salesRevenueId;
                            let financialIncomeOrExpenses = domElements.financialIncomeOrExpensesId;
                            let corporateTaxesId = domElements.corporateTaxesId;
                            let currentRow = this.closest('tr');
                            let marketExpensesId = domElements.marketExpensesId;
                            let salesAndDistributionExpensesId = domElements.salesAndDistributionExpensesId;
                            let generalExpensesId = domElements.generalExpensesId;
                            let parentModelId = this.getAttribute('data-parent-model-id');
                            let date = this.getAttribute('data-date');
							let canRecalculateParentRowTotal = false // temporary condition
                            if (canRecalculateParentRowTotal && date && parentModelId && isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {
                                updateParentMainRowTotal(parentModelId, date);
                            }
                            if ((parentModelId == salesRevenueId || parentModelId == costOfGoodsId) && isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {
                         //       updateGrowthRateForSalesRevenue(date);
                         //       updateTotalForRow(currentRow);
                         //       updateGrossProfit(date);
                         //       if (parentModelId == salesRevenueId && canRefreshPercentages) {
                         //           let items = refreshPercentagesThatDependsOnSalesRevenueValue(date, this)
                         //       }

                            }
                            if ((parentModelId == marketExpensesId || parentModelId == salesAndDistributionExpensesId || parentModelId == generalExpensesId) && isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {
                            //    updateEarningBeforeIntersetTaxesDepreciationAmortization(date);
                            }
                            if (parentModelId == financialIncomeOrExpenses && isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {

                             //   updateEarningBeforeTaxes(date);
                            }
                            if (parentModelId == corporateTaxesId && isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {
                               // updateNetProfit(date);
                            }

                            updateTotalForRow(currentRow);
                            if (isLastSublingPercentageOfCostOfUnitOfParent(currentRow)) {
                              //  updatePercentageOfSalesFor(parentModelId, date);
                            //    updateAllMainsRowPercentageOfSales([date])

                            }
                        });

                        function recalculatePercentagesOrCostOfUnit(tdElement, firstDate, financialStatementAbleItemId, corporateTaxesId, is_cost_of_unit, earningBeforeTaxesId, salesRevenueRowId, is_percentage, currentVal) {
                            var inputs = []
                            var isFinancialExpense = inEditMode && tdElement.parentElement ? tdElement.parentElement.getAttribute('data-is-financial-expense') : tdElement.getAttribute('data-is-financial-expense')
                            isFinancialExpense = parseInt(isFinancialExpense);

                            var value = filterNumericUserInput(tdElement.innerHTML, isFinancialExpense)

                            var input = tdElement.parentElement.querySelector('input[data-date="' + firstDate + '"]');
                            input.value = value;
                            inputs.push(input)
                            var reportType = vars.subItemType;
                            if (financialStatementAbleItemId != corporateTaxesId) {
                                currentVal = is_cost_of_unit ? tdElement.closest('tr').getAttribute('data-cost-of-unit-value') : tdElement.closest('tr').getAttribute('data-percentage-value')
                            }
                            var percentage_or_cost_of_unit_of_array = is_cost_of_unit ? tdElement.closest('tr').getAttribute('data-is-cost-of-unit-of') : tdElement.closest('tr').getAttribute('data-is-percentage-of');

                            if (!Array.isArray(percentage_or_cost_of_unit_of_array)) {
                                percentage_or_cost_of_unit_of_array = percentage_or_cost_of_unit_of_array ? percentage_or_cost_of_unit_of_array.replace(/\[|\]/g, '').split(',') : [];
                            }

                            if (percentage_or_cost_of_unit_of_array && percentage_or_cost_of_unit_of_array.length) {
                                var loopDates;
                                loopDates = inAddOrEditModal ? dates : [firstDate];
                                // #FIXME: && inAddOrEditModal
                                if (reportType == 'modified' && inAddOrEditModal) {
                                    loopDates = getDatesLargerThanDate(firstDate, dates)
                                }
                                var total = 0;
                                var percentageElementId = financialStatementAbleItemId == corporateTaxesId ? earningBeforeTaxesId : salesRevenueRowId;
                                loopDates.forEach((currentDate) => {
                                    total = 0;
                                    percentage_or_cost_of_unit_of_array.forEach(function(subItemName) {

                                        var valOfCurrentSubItem = 0;
                                        if (financialStatementAbleItemId == corporateTaxesId) {
                                            valOfCurrentSubItem = parseFloat(document.querySelector('input[data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value);
                                            if (valOfCurrentSubItem < 0) {
                                                valOfCurrentSubItem = 0;
                                            }
                                        } else {
                                            subItemName = subItemName.replace(/["]+/g, '').trim()
                                            var subItemTd = document.querySelector('tr[data-sub-item-name="' + subItemName + '"] input[type="hidden"][data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]')

                                            valOfCurrentSubItem = subItemTd ? subItemTd.value : 0;
                                        }
                                        total += parseFloat(valOfCurrentSubItem);

                                    });
                                    if (is_cost_of_unit) {
                                        currentVal = inAddOrEditModal ? currentVal : parseFloat(tdElement.getAttribute('data-cost-of-unit-value'));
                                        currentValue = total ? currentVal * total : 0;
                                        if (isFinancialExpense && isFinancialExpense && currentValue > 0) {
                                            currentValue = currentValue * -1;
                                        }


                                    } else if (is_percentage) {

                                        currentVal = inAddOrEditModal ? currentVal : parseFloat(tdElement.getAttribute('data-percentage-value'));
                                        currentValue = total ? currentVal / 100 * total : 0;
                                        if (isFinancialExpense && isFinancialExpense != 0 && currentValue > 0) {
                                            currentValue = currentValue * -1;
                                        }

                                    }
                                    if (reportType != 'modified' || reportType == 'modified' && !isActualDate(currentDate)) {
                                        currentValue = 9999
                                        tdElement.closest('tr').querySelector('td.editable-date.date-' + currentDate).innerHTML = number_format(currentValue, 2);
                                        var input = tdElement.closest('tr').querySelector('input[data-date][data-date="' + currentDate + '"]')
                                        input.value = currentValue
                                        inputs.push(input)

                                    }
                                })

                                return inputs
                            }
                        }
                    //    const refreshPercentagesThatDependsOnSalesRevenueValue = (date, currentInputThatChanged) => {
                    //        let items = []
                    //        if (!!parseInt(currentInputThatChanged.getAttribute('data-is-quantity'))) {
                    //            document.querySelectorAll('tr[data-is-cost-of-unit="true"]').forEach((tr) => {
                    //                var input = tr.querySelector('input[data-date="' + date + '"]')
                    //                var td = tr.querySelector('td.date-' + date)
                    //                var financialStatementAbleItemId = td.closest('tr').getAttribute('data-financial-statement-able-item-id')
                    //                var inputs = recalculatePercentagesOrCostOfUnit(td, date, financialStatementAbleItemId, domElements.corporateTaxesId, true, domElements.earningBeforeTaxesId, domElements.salesRevenueId, false, parseFloat(currentInputThatChanged.value))
                    //                for (var inputItem of inputs) {
                    //                    inputItem.dispatchEvent(new Event('change', {
                    //                        'bubbles': true
                    //                    }))
                    //                }
                    //                var item = {}
                    //                if (deleteModalIsOpen) {
                    //                    //		item = {change:input}
                    //                    //	item = {
                    //                    //				blur:td 
                    //                    //			}
                    //                } else {
                    //                    //	item = {
                    //                    //			blur:td 
                    //                    //		}
//
//
//
                    //                }
                    //                //	   items.push(item)
//
                    //            });
                    //        } else {
//
                    //            document.querySelectorAll('tr[data-is-percentage="true"]').forEach((tr) => {
                    //                var input = tr.querySelector('input[data-date="' + date + '"]')
                    //                var td = tr.querySelector('td.date-' + date)
//
                    //                var financialStatementAbleItemId = td.closest('tr').getAttribute('data-financial-statement-able-item-id')
                    //                var inputs = recalculatePercentagesOrCostOfUnit(td, date, financialStatementAbleItemId, domElements.corporateTaxesId, false, domElements.earningBeforeTaxesId, domElements.salesRevenueId, true, parseFloat(currentInputThatChanged.value))
//
                    //                for (var inputItem of inputs) {
                    //                    inputItem.dispatchEvent(new Event('change', {
                    //                        'bubbles': true
                    //                    }))
                    //                }
//
                    //                //		var item = {} 
                    //                //		if(deleteModalIsOpen){
                    //                //			item = {change:input}
                    //                //		}
                    //                //		else{
                    //                //			item = {
                    //                //					blur:td 
                    //                //				}
                    //                //		
                    //                //		}
                    //                //	   items.push(item)
//
//
                    //            });
//
//
                    //        }
//
                    //        return items
//
//
                    //    }

                 //       function updateNetProfit(date) {
//
                 //           let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                 //           let corporateTaxesId = domElements.corporateTaxesId;
                 //           let netProfitId = domElements.netProfitId;
                 //           let netProfitRow = document.querySelector('.main-with-no-child[data-model-id="' + netProfitId + '"]');
                 //           let earningBeforeTaxesValueAtDate = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeTaxesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                 //           let corporateTaxesValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + corporateTaxesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                 //           netprofitAtDate = earningBeforeTaxesValueAtDate - corporateTaxesValueAtDate;
                 //           netProfitRow.querySelector('td.date-' + date).innerHTML = number_format(netprofitAtDate);
                 //           var input = netProfitRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]');
                 //           input.value = netprofitAtDate;
         
//
//
                 //           updateTotalForRow(netProfitRow);
                 //           updatePercentageOfSalesFor(domElements.netProfitId, date);
                 //       }

        //                function updateEarningBeforeTaxes(date) {
        //                    let earningBeforeInterstTaxesId = domElements.earningBeforeInterestTaxesId;
        //                    let financialIncomeOrExpensesId = domElements.financialIncomeOrExpensesId;
        //                    let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
        //                    let earningBeforeTaxesIdRow = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeTaxesId + '"]');
        //                    let earningBeforeInterstTaxesValueAtDate = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeInterstTaxesId + '"]' + ' td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
        //                    let financialIncomeOrExpensesValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + financialIncomeOrExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
        //                    earningBeforeTaxesAtDate = parseFloat(earningBeforeInterstTaxesValueAtDate) + parseFloat(financialIncomeOrExpensesValueAtDate);
        //                    earningBeforeTaxesIdRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeTaxesAtDate);
        //                    var input = earningBeforeTaxesIdRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]');
        //                    input.value = earningBeforeTaxesAtDate;
//
        //                    input.dispatchEvent(new Event('change', {
        //                        'bubbles': true
        //                    }))
        //                    updateTotalForRow(earningBeforeTaxesIdRow);
        //                    updateNetProfit(date);
        //                }
//
        //                function updateEarningBeforeIntersetTaxesDepreciationAmortization(date) {
        //                    let grossProfitId = domElements.growthProfitId;
        //                    let marketExpensesId = domElements.marketExpensesId;
        //                    let salesAndDistributionExpensesId = domElements.salesAndDistributionExpensesId;
        //                    let generalExpensesId = domElements.generalExpensesId;
        //                    let costOfGoodsId = domElements.costOfGoodsId;
        //                    let earningBeforeInterstTaxesDepreciationAmortizationId = domElements.earningBeforeInterestTaxesDepreciationAmor;
        //                    let earningBeforeInterestTaxesDepreciationAmortizationRow = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeInterstTaxesDepreciationAmortizationId + '"]');
        //                    let grossProfitAtDate = parseFloat(document.querySelector('.main-with-no-child[data-model-id="' + grossProfitId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    let marketExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + marketExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    let salesAndDistributionExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesAndDistributionExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    let generalExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + generalExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    var mainWithSubItemsCostOfGoods = document.querySelector('.is-main-with-sub-items[data-model-id="' + costOfGoodsId + '"]')
//
        //                    let depreciationForCostOfGoodsSold = [...myNextAll(mainWithSubItemsCostOfGoods, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + costOfGoodsId)]
//
        //                    let totalDepreciationForCostOfGoodsSoldAtDate = 0;
        //                    for (depreciationRow of depreciationForCostOfGoodsSold) {
        //                        totalDepreciationForCostOfGoodsSoldAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    }
//
        //                    var mainWithSubItemsMarketExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + marketExpensesId + '"]')
        //                    let depreciationForMarketExpenses = [...myNextAll(mainWithSubItemsMarketExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + marketExpensesId)]
//
        //                    let totalDepreciationForMarketExpensesAtDate = 0;
        //                    for (depreciationRow of depreciationForMarketExpenses) {
        //                        totalDepreciationForMarketExpensesAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    }
//
        //                    var mainWithSubItemsSalesAndDistrubtionExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + salesAndDistributionExpensesId + '"]')
//
        //                    let depreciationForSalesAndDistributionExpense = [...myNextAll(mainWithSubItemsSalesAndDistrubtionExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + salesAndDistributionExpensesId)];
        //                    let totalDepreciationForSalesAndDistributionExpenseAtDate = 0;
        //                    for (depreciationRow of depreciationForSalesAndDistributionExpense) {
        //                        totalDepreciationForSalesAndDistributionExpenseAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    }
        //                    var mainWithSubItemsGeneralExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + generalExpensesId + '"]')
        //                    let depreciationForGeneralExpenses = [...myNextAll(mainWithSubItemsGeneralExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + generalExpensesId)];
        //                    let totalDepreciationForGeneralExpensesAtDate = 0;
        //                    for (depreciationRow of depreciationForGeneralExpenses) {
        //                        totalDepreciationForGeneralExpensesAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
        //                    }
        //                    let totalDepreciationsAtDate = totalDepreciationForGeneralExpensesAtDate + totalDepreciationForSalesAndDistributionExpenseAtDate + totalDepreciationForMarketExpensesAtDate + totalDepreciationForCostOfGoodsSoldAtDate
        //                    let earningBeforeInterestTaxesAtDate = grossProfitAtDate - marketExpensesAtDate - salesAndDistributionExpensesAtDate - generalExpensesAtDate;
        //                    let earningBeforeInterstTaxesDepreciationAmortizationAtDate = earningBeforeInterestTaxesAtDate + totalDepreciationsAtDate;
        //                    earningBeforeInterestTaxesDepreciationAmortizationRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeInterstTaxesDepreciationAmortizationAtDate);
        //                    var input = earningBeforeInterestTaxesDepreciationAmortizationRow.querySelector('input[data-date="' + date + '"]')
        //                    input.value = earningBeforeInterstTaxesDepreciationAmortizationAtDate
        //                    input.dispatchEvent(new Event('change', {
        //                        'bubbles': true
        //                    }));
        //                    updateTotalForRow(earningBeforeInterestTaxesDepreciationAmortizationRow);
//
        //                    updatePercentageOfSalesFor(earningBeforeInterstTaxesDepreciationAmortizationId, date)
//
//
        //                    updateEarningBeforeInterestTaxesDepreciationAmortizationId(earningBeforeInterestTaxesAtDate, date)
//
        //                }

        //                function updateEarningBeforeInterestTaxesDepreciationAmortizationId(earningBeforeInterestTaxesWithoutDepreciationAtDate, date) {
//
        //                    let EarningBeforeInterestTaxesId = domElements.earningBeforeInterestTaxesId;
        //                    let earningBeforeInterestTaxesRow = document.querySelector('.main-with-no-child[data-model-id="' + EarningBeforeInterestTaxesId + '"]');
        //                    earningBeforeInterestTaxesRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeInterestTaxesWithoutDepreciationAtDate);
        //                    var input = earningBeforeInterestTaxesRow.querySelector('input[data-date="' + date + '"]')
//
        //                    input.value = earningBeforeInterestTaxesWithoutDepreciationAtDate
//
//
        //                    input.dispatchEvent(new Event('change', {
        //                        'bubbles': true
        //                    }));
        //                    updateTotalForRow(earningBeforeInterestTaxesRow);
//
        //                }

                        function formateRowsForInsertaionIntoDom(rowsAsString) {
                            return `<table class="append-table-into-dom"> <tbody> ` + rowsAsString + ' </tbody></table>';
                        }

                        function insertTableIntoDom(tableString) {
                            $('#store-report-form-id').append(tableString);
                        }



                        function formateTableForNewRow(formDataObject) {

                            let numberOfAddedItems = formDataObject.how_many_items;
                            let incomeStatementId = formDataObject.financial_statement_able_id;
                            let incomeStatementItemId = formDataObject.financial_statement_able_item_id;
                            let salesRevenueId = domElements.salesRevenueId;
                            rows = ``;
                            var i = 0;
                            for (i; i < numberOfAddedItems; i++) {

                                var subItemName = formDataObject['sub_items[' + i + '][name]'];
                                var isDepreciationOrAmortization = formDataObject['sub_items[' + i + '][is_depreciation_or_amortization]'];
                                var canBePercentage = formDataObject['sub_items[' + i + '][can_be_percentage_or_fixed]'];
                                var isFinancialExpense = formDataObject['sub_items[' + i + '][is_financial_expense]'] == '1';
                                var isFinancialIncome = formDataObject['sub_items[' + i + '][is_financial_income]'] == '1';

                                var isQuantity = 0;
                                var percentageOrFixed = formDataObject['sub_items[' + i + '][percentage_or_fixed]'];
                                var isPercentage = percentageOrFixed == 'percentage';
                                var isCostOfUnit = percentageOrFixed == 'cost_of_unit';
                                var isPercentageOf = isPercentage && formDataObject['sub_items[' + i + '][is_percentage_of][]'] ? "[" + formDataObject['sub_items[' + i + '][is_percentage_of][]'].toString() + "]" : '';
                                var isCostOfUnitOf = isCostOfUnit && formDataObject['sub_items[' + i + '][is_cost_of_unit_of][]'] ? "[" + formDataObject['sub_items[' + i + '][is_cost_of_unit_of][]'].toString() + "]" : '';
                                var isRepeatingFixed = percentageOrFixed == 'repeating_fixed';
                                var isNoneRepeatingFixed = percentageOrFixed == 'non_repeating_fixed';
                                var canTriggerChange = isRepeatingFixed || isPercentage;
                                var tdValue = 0;
                                var valuesOfDates = [];
                                if (isNoneRepeatingFixed) {

                                    dates.forEach((date) => {
                                        tdValue = formDataObject['sub_items[' + i + '][non_repeating_popup][' + date + ']'];

                                        tdValue = isFinancialExpense && tdValue > 0 ? tdValue * -1 : tdValue;
                                        value = tdValue;
                                        valuesOfDates.push({
                                            date
                                            , value
                                        })
                                    })
                                } else if (isRepeatingFixed) {
                                    tdValue = formDataObject['sub_items[' + i + '][repeating_fixed_value]'];
                                    tdValue = isFinancialExpense && tdValue > 0 ? tdValue * -1 : tdValue;
                                    value = tdValue;

                                    dates.forEach((date) => {
                                        valuesOfDates.push({
                                            date
                                            , value
                                        })
                                    })
                                } else if (isPercentage || isCostOfUnit) {

                                    let financialStatementAbleItemId = formDataObject.financial_statement_able_item_id;
                                    let corporateTaxesId = domElements.corporateTaxesId;
                                    let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                                    let salesRevenueId = domElements.salesRevenueId;
                                    let salesRevenueRowId = salesRevenueId;
                                    let hasCostOfUnitOfOrHasIsPercentage = isCostOfUnit ? isCostOfUnitOf.length : isPercentageOf.length
                                    let errorMessage = isCostOfUnit ? 'Please Select Cost Per Unit Items For ' + subItemName : 'Please Select Percentage Of Items For ' + subItemName
                                    if (!hasCostOfUnitOfOrHasIsPercentage) {
                                        rows = null;
                                        alert(errorMessage);
                                        return;
                                    }

                                    var percentageOrCostOfUnitValue = isCostOfUnit ? formDataObject['sub_items[' + i + '][cost_of_unit_value]'] : formDataObject['sub_items[' + i + '][percentage_value]'];
                                    tdValue = percentageOrCostOfUnitValue ? percentageOrCostOfUnitValue : 0;
                                    var originPercentageOrCostOfUnitValue = tdValue


                                    var percentage_or_cost_of_unit_of_array = isCostOfUnit ? isCostOfUnitOf : isPercentageOf;

                                    if (!Array.isArray(percentage_or_cost_of_unit_of_array)) {

                                        percentage_or_cost_of_unit_of_array = percentage_or_cost_of_unit_of_array ? percentage_or_cost_of_unit_of_array.replace(/\[|\]/g, '').split(',') : [];
                                    }

                                    var total = 0;
                                    var percentageElementId = financialStatementAbleItemId == corporateTaxesId ? earningBeforeTaxesId : salesRevenueRowId;

                                    dates.forEach(function(date) {
                                        var currentDate = date

                                        total = 0;
                                        percentage_or_cost_of_unit_of_array.forEach(function(subItemName) {

                                            var valOfCurrentSubItem = 0;
                                            if (financialStatementAbleItemId == corporateTaxesId) {
                                                valOfCurrentSubItem = parseFloat(document.querySelector('input[data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value);
                                                if (valOfCurrentSubItem < 0) {
                                                    valOfCurrentSubItem = 0;
                                                }
                                            } else {
                                                var subItemTD = document.querySelector('tr[data-sub-item-name="' + subItemName + '"] input[type="hidden"][data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]')

                                                valOfCurrentSubItem = subItemTD ? subItemTD.value : 0;
                                            }
                                            total += parseFloat(valOfCurrentSubItem);

                                        });
                                        //  var percentageOrCostOfUnitValue = isCostOfUnit ? parseFloat(formDataObject['sub_items[' + i + '][repeating_fixed_value]']) : parseFloat(tdElement.getAttribute('data-percentage-value'))
                                        //var percentageOrCostOfUnitValue = isCostOfUnit ? parseFloat(tdElement.getAttribute('data-cost-of-unit-value')) : parseFloat(tdElement.getAttribute('data-percentage-value'))
                                        percentageOrCostOfUnitValue = inAddOrEditModal ? originPercentageOrCostOfUnitValue : percentageOrCostOfUnitValue;
                                        var currentVal = inAddOrEditModal ? originPercentageOrCostOfUnitValue : percentageOrCostOfUnitValue;
                                        currentValue = 0
                                        if (isCostOfUnit) {
                                            currentValue = total ? currentVal * total : 0;
                                        } else if (isPercentage) {
                                            currentValue = total ? currentVal / 100 * total : 0;
                                        }
                                        value = currentValue;
                                        tdValue = currentValue
                                        if (isFinancialExpense && value > 0) {
                                            value = value * -1;
                                        }
                                        valuesOfDates.push({
                                            date
                                            , value // not change value name
                                        });
                                    });
                                }
                                rows += getRowForSubItemsTr('kt_table_1', dates, percentageOrCostOfUnitValue, incomeStatementId, incomeStatementItemId, subItemName, isDepreciationOrAmortization, isQuantity, canBePercentage, percentageOrFixed, isPercentage, isRepeatingFixed, isNoneRepeatingFixed, valuesOfDates, canTriggerChange, isPercentageOf, isCostOfUnit, isCostOfUnitOf, isFinancialExpense);
                            }

                            formattedTable = formateRowsForInsertaionIntoDom(rows)
                            insertTableIntoDom(formattedTable);
                            // triggerBlurForEditableTd();
                            return formattedTable;
                        }


               //         function updateGrossProfit(date) {
               //             let grossProfitId = domElements.growthProfitId;
               //             let costOfGoodsId = domElements.costOfGoodsId;
               //             let salesReveueId = domElements.salesRevenueId;
               //             let grossProfitRow = document.querySelector('.main-with-no-child[data-model-id="' + grossProfitId + '"]');
               //             let salesRevenueValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + salesReveueId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
               //             let costOfGoodsValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + costOfGoodsId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
               //             grossProfitAtDate = salesRevenueValueAtDate - costOfGoodsValueAtDate;
//
               //             grossProfitRow.querySelector('td.date-' + date).innerHTML = number_format(grossProfitAtDate);
               //             var input = grossProfitRow.querySelector('input[data-date="' + date + '"]')
               //             input.value = grossProfitAtDate
//
               //             input.dispatchEvent(new Event('change', {
               //                 'bubbles': true
               //             }));
//
//
//
               //             updateTotalForRow(grossProfitRow);
//
               //         }

                        function getRowForSubItemsTr(tableId, dates, percentageOrCostOfUnitValue, incomeStatementId, incomeStatementItemId, subItemName, isDepreciationOrAmortization, isQuantity, canBePercentageOrFixed, fixedOrPercentage, isPercentage, isRepeatingFixed, isNoneRepeatingFixed, valuesOfDates, canTriggerChange, isPercentageOf, isCostOfUnit, isCostOfUnitOf, isFinancialExpense) {

                            let row = `<tr   data-financial-statement-able-item-id="${incomeStatementItemId}" class="d-none edit-info-row add-sub maintable-1-row-class${incomeStatementItemId} is-sub-row even" data-sub-item-name="${subItemName}" data-is-trigger-change="${canTriggerChange}" data-can-be-percentage-or-fixed="${canBePercentageOrFixed}" data-percentage-or-fixed="${fixedOrPercentage}" data-is-percentage="${isPercentage}" data-is-cost-of-unit="${isCostOfUnit}" data-is-percentage-of="${isPercentageOf}" data-is-cost-of-unit-of="${isCostOfUnitOf}"  data-is-repeating-fixed="${isRepeatingFixed}" data-is-none-repeating-fixed="${isNoneRepeatingFixed}">
																<td class="red reset-table-width text-nowrap trigger-child-row-1 cursor-pointer  sub-text-bg dtfc-fixed-left" style="left: 0px; position: sticky;"></td>
																<td class="cursor-pointer sub-text-bg dtfc-fixed-left" style="left: 70.25px; position: sticky;">
												<div class="d-flex align-items-center justify-content-between">
													<a data-is-subitem="1" class="d-block edit-btn mb-2 text-white " href="#" data-toggle="modal" data-is-depreciation-or-amortization="${isDepreciationOrAmortization}" data-income-statement-id="${incomeStatementId}" data-target="#edit-sub-modal${incomeStatementItemId}${convertStringToClass(subItemName)}"> <i class="fa fa-pen-alt edit-modal-icon"></i> </a> <a class="d-block  delete-btn text-white mb-2 text-danger" href="#" data-toggle="modal" data-target="#delete-sub-modal${incomeStatementId}${convertStringToClass(subItemName)}">
														<i class="fas fa-trash-alt"></i>

													</a>
												</div>
											</td>
											<td class="sub-text-bg  editable editable-text is-name-cell dtfc-fixed-left" data-income-statement-id="${incomeStatementId}" data-main-model-id="${incomeStatementItemId}" data-income-statement-item-id="${incomeStatementItemId}" data-main-row-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}" data-table-id="${tableId}" data-is-quantity="${isQuantity}" style="left: 141.417px; position: sticky;" contenteditable="true" title="<?php echo e(__('Click To Edit')); ?>">${subItemName}</td><input type="hidden" class="text-input-hidden" name="financialStatementAbleItemName[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]" value="${subItemName}">`;
                            dates.forEach(function(date) {
                                var currentValueIndex = valuesOfDates.findIndex((item) => item.date == date)
                                var currentValue = 0;
                                if (currentValueIndex >= 0) {
                                    var currentValue = valuesOfDates[currentValueIndex].value;
                                }
                                row += `<td class="sub-numeric-bg text-nowrap editable editable-date date-${date}" data-income-statement-id="${incomeStatementId}" data-main-model-id="${incomeStatementId}" data-income-statement-item-id="${incomeStatementItemId}" data-main-row-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}" data-table-id="${tableId}" data-is-quantity="${isQuantity}" contenteditable="true" title="<?php echo e(__('Click To Edit')); ?>" data-percentage-value="${isCostOfUnit ? 0 : percentageOrCostOfUnitValue}" data-cost-of-unit-value="${isCostOfUnit ? percentageOrCostOfUnitValue : 0}" data-is-financial-expense="${isFinancialExpense ? 1 :0}">${currentValue}</td>

								<input type="hidden" name="value[${incomeStatementId}][${incomeStatementItemId}][${subItemName}][${date}]" data-is-quantity="${isQuantity}" data-is-cost-of-unit="${isCostOfUnit}" data-date="${date}" data-parent-model-id="${incomeStatementItemId}" value="${currentValue}">
								<input type="hidden" name="is_financial_income[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]"   value="${currentValue}">
								
								`;
                            })

                            row += `<td class="  sub-numeric-bg text-nowrap total-row" data-financial-statement-able-item-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}">0</td>
										<input type="hidden" class="input-hidden-for-total" name="subTotals[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]" data-parent-model-id="${incomeStatementItemId}" value="0">
										</tr>`;
                            return row;
                        }

                        function updateTotalForRow(row) {
							return false ;

                            const salesRevenueId = domElements.salesRevenueId
                            var total = 0;
							$(row).find('>input[data-date]').each(function(index,input){
								 total += parseFloat($(input).val());
							})


                            if (row.getAttribute('data-model-id') == domElements.netProfitId) {
                                var earningBeforeTaxesTotalValue = parseFloat(document.querySelector('.main-with-no-child[data-financial-statement-able-item-id="' + domElements.earningBeforeTaxesId + '"] input.input-hidden-for-total').value)
                                var corporateTaxesTotalValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-financial-statement-able-item-id="' + domElements.corporateTaxesId + '"] input.input-hidden-for-total').value)
                                var totalOfNetProfit = earningBeforeTaxesTotalValue - corporateTaxesTotalValue;
                                row.querySelector('.input-hidden-for-total').value = totalOfNetProfit;
                                row.querySelector('td.total-row').innerHTML = number_format(totalOfNetProfit);
                            } else if ((row.getAttribute('data-model-id') == domElements.corporateTaxesId) && vars.subItemType != 'actual') {
                                var earningBeforeTaxesTotalValue = parseFloat(document.querySelector('.main-with-no-child[data-financial-statement-able-item-id="' + domElements.earningBeforeTaxesId + '"] input.input-hidden-for-total').value)
                                var corporateTaxesPercentageValue = parseFloat(document.querySelector('.is-sub-row.maintable-1-row-class' + domElements.corporateTaxesId + ' td.editable-date').getAttribute('data-percentage-value')) / 100
                                var corporateTaxesValue = earningBeforeTaxesTotalValue < 0 ? 0 : earningBeforeTaxesTotalValue * corporateTaxesPercentageValue
                                row.querySelector('.input-hidden-for-total').value = corporateTaxesValue;
                                row.querySelector('td.total-row').innerHTML = number_format(corporateTaxesValue);
                            } else if (row.querySelector('.input-hidden-for-total')) {
                                row.querySelector('.input-hidden-for-total').value = total;
                                row.querySelector('td.total-row').innerHTML = number_format(total);

                            } else {
                                // no total row found

                            }


                        }
                        $(document).on('focus', '.editable-date', function() {
                            lastInputValue = $(this).html()
                            $(this).html('<br>')
                        })

                        $(document).on('blur', '.blured-item', function() {
                            const date = this.getAttribute('data-date')
                            const type = this.getAttribute('data-type')
                            const parentElement = this.parentElement.parentElement
                            const tbody = this.parentElement.parentElement.parentElement

                            const currentIndex = $(this).closest('[data-index]').attr('data-index')
                            const unformattedValue = this.parentElement.querySelector('input[type="text"]').value

                            const numericValue = filterNumericUserInput(unformattedValue, false)

                            $(parentElement).find('input[data-date="' + date + '"]').val(numericValue)
                            const onlyValueChecked = $(tbody).find('tr').length == 1;
                            if (onlyValueChecked) {
                                recalculateTotalForSalesRevenuePopup(parentElement);
                                return;
                            }
                            const autoCalculationRow = $(tbody).find('tr:last-of-type')

                            let equation = autoCalculationRow.attr('data-equation')
                            let numberFormatDigit = autoCalculationRow.attr('data-number-format')
                            const numberFormatDigits = autoCalculationRow.attr('data-number-format')
                            equation = equation.split(/([-+*\/])/g)
                            const firstClassName = equation[0].trim()
                            const mathOperator = equation[1].trim()
                            const secondClassName = equation[2].trim()

                            const firstVal = filterNumericUserInput($(tbody).find('.' + firstClassName + ' input[data-date="' + date + '"]').val(), false)
                            const secondVal = filterNumericUserInput($(tbody).find('.' + secondClassName + ' input[data-date="' + date + '"]').val(), false)

                            let result = secondVal == 0 && mathOperator == '/' ? 0 : firstVal + mathOperator + secondVal
                            result = eval(result)
                            $(autoCalculationRow).find('input[type="hidden"][data-date="' + date + '"]').val(result, numberFormatDigits)
                            $(autoCalculationRow).find('input[type="text"][data-date="' + date + '"]').val(number_format(result, numberFormatDigits)).trigger('change')
                            $(autoCalculationRow).find('i').remove();
                            recalculateTotalForSalesRevenuePopup(parentElement)
                        })
						
						 $(document).on('blur', '.blured-item-non-repeating', function() {
                            const date = this.getAttribute('data-date')
                            const type = this.getAttribute('data-type')
                            const parentElement = this.parentElement.parentElement
                            const tbody = this.parentElement.parentElement.parentElement

                            const currentIndex = $(this).closest('[data-index]').attr('data-index')
                            const unformattedValue = this.parentElement.querySelector('input[type="text"]').value
                            const numericValue = filterNumericUserInput(unformattedValue, false)
                            $(parentElement).find('input[data-date="' + date + '"]').val(numericValue)
                                recalculateTotalForNonRepeatingPopup(parentElement);
							
                        })

                        function recalculateTotalForSalesRevenuePopup(parentElement) {
                            // total quantity and value
							parentElement = parentElement.closest('tbody');
                            const totalPerType = {};
                            let numberOfDigit = 0;
                            for (var type of ['quantity', 'value', 'price']) {
                                var currentRowTotal = 0;
                                if (type != 'price') {
									
									$(parentElement).find('input[type="hidden"][data-type="'+type+'"]').each(function(index, input) {
                                        currentRowTotal += parseFloat($(input).val());
                                    })
                                   // $('input[type="hidden"][data-type="' + type + '"][data-in-edit-mode="'+inEditMode+'"]').each(function(index, input) {
                                   //     currentRowTotal += parseFloat($(input).val());
                                   // })
                                }
                                totalPerType[type] = currentRowTotal
                                if (type == 'price') {
						
                                    currentRowTotal = totalPerType.quantity != 0 ? totalPerType.value / totalPerType.quantity : 0;

                                }
                                if (currentRowTotal < 1000) {
                                    numberOfDigit = 2;
                                }
								
                                $(parentElement).find('input.total-for-' + type).val(number_format(currentRowTotal, numberOfDigit)).trigger('change');
                                //$('input.total-for-' + type).val(number_format(currentRowTotal, numberOfDigit)).trigger('change');
                            }





                        }
						
						 function recalculateTotalForNonRepeatingPopup(parentElement) {
							
                            // total quantity and value
                            const totalPerType = {};
                            let numberOfDigit = 0;
                            for (var type of [ 'value']) {
                                var currentRowTotal = 0;
                                 $(parentElement).find('input[type="hidden"][data-type-non-repeating="' + type + '"]').each(function(index, input) {
                                        currentRowTotal += parseFloat($(input).val());
                                    })
                                totalPerType[type] = currentRowTotal
                                if (currentRowTotal < 1000) {
                                    numberOfDigit = 2;
                                }
                                $(parentElement).find('input.total-for-non-repeating-' + type).val(number_format(currentRowTotal, numberOfDigit))
								// casue slow down
								//.trigger('change');
                            }





                        }

                        $(document).on('blur', '.editable', function() {
                            if ($(this).html() == '<br>') {
                                $(this).html(lastInputValue)
                                $(this).trigger('blur')
                                return;
                            }
                            let tdElement = this;
                            let changedInputs = updateEditableInputs(tdElement)
                            const newArr = []
                            for (var i = 0; i < changedInputs.length; i++) {
                                if (!newArr.includes(changedInputs[i])) {
                                    newArr.push(changedInputs[i])
                                }
                            }
                            changedInputs = newArr;

                            for (var i = 0; i < changedInputs.length; i++) {
                                changedInputs[i].dispatchEvent(new Event('change', {
                                    'bubbles': true
                                }))
                            }
                            if (modalIsOpenInAddOrEdit || deleteModalIsOpen) {
                                if (isLastKey(date, dates)) {
                                    if (canRedrawWitdth) {
                                        globalTable.columns.adjust()

                                    }
                                }

                            } else {
                                if (canRedrawWitdth) {
                                    globalTable.columns.adjust()

                                }

                            }

                        });

           //             function updateGrowthRateForSalesRevenue(currentDate) {
           //                 let dates = getDates();
           //                 let previousDate = getPreviousDate(dates, currentDate);
           //                 if (previousDate) {
           //                     let salesRevenueId = domElements.salesRevenueId;
           //                     let salesGrowthRateId = domElements.salesGrowthRateId;
           //                     let currentTotalSalesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] ' + 'input[data-date="' + currentDate + '"]').value);
           //                     let previousTotalSalesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] ' + 'input[data-date="' + previousDate + '"]').value);
           //                     var salesRevenueGrowthRate = 0;
           //                     if (previousTotalSalesRevenueValue) {
           //                         salesRevenueGrowthRate = previousTotalSalesRevenueValue ? ((currentTotalSalesRevenueValue - previousTotalSalesRevenueValue) / previousTotalSalesRevenueValue) * 100 : 0;
           //                     }
           //                     var input = document.querySelector('.main-with-no-child[data-model-id="' + salesGrowthRateId + '"] ' + 'input[data-date="' + currentDate + '"]');
           //                     if (input) {
//
           //                         input.value = salesRevenueGrowthRate;
           //                         input.dispatchEvent(new Event('change', {
           //                             'bubbles': true
           //                         }))
           //                         document.querySelector('.main-with-no-child[data-model-id="' + salesGrowthRateId + '"] ' + 'td.date-' + currentDate).innerHTML = number_format(salesRevenueGrowthRate, 2) + ' %';
//
           //                     }
//
           //                 }
           //                 return number_format(0, 2) + ' %';
//
//
           //             }
//
                        function getPreviousDate(dates, currentDate) {
                            let index = dates.indexOf(currentDate);
                            if (index == 0) {
                                return null;
                            }
                            return dates[index - 1];

                        }

                        function getDates() {
                            var dates = "<?php echo e(json_encode(array_keys($incomeStatement->getIntervalFormatted()))); ?>";
                            dates = dates.replace(/(&quot\;)/g, "\"");
                            return JSON.parse(dates);
                        }



                        function updateParentMainRowTotal(parentModelId, date) {
							
                            let parentElement = document.querySelector('tr.is-main-with-sub-items[data-model-id="' + parentModelId + '"]');
                            let total = 0;
                            let siblings = myNextAllWithNested(parentElement)

                            siblings.forEach(function(subRow, index) {
                                // if has no quantity 
                                if (subRow.querySelectorAll('td[data-is-quantity="1"]').length == 0) {
                                    var subRowTdValue = parseFloat(subRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                                    total += subRowTdValue;
                                }
                            });
                            parentElement.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value = total;
                            parentElement.querySelector('td.date-' + date).innerHTML = number_format(total);
                            updateTotalForRow(parentElement);

                        }

                        function triggerBlurForEditableTd(date) {

                            document.querySelector('table.append-table-into-dom tr:first-of-type td.date-' + date).dispatchEvent(new Event('blur', {
                                'bubbles': true
                            }))

                        }

                        function getDatesLargerThanDate(searchDate, dates) {
                            let result = [searchDate];

                            dates = dates.filter((date) => {
                                return moment(searchDate).isBefore(date);
                            });

                            return result.concat(dates);

                        }

                        function updateEditableInputs(tdElement) { //updateInputs
                            var inputs = []
                            let reportType = vars.subItemType;
                            let financialStatementAbleItemId = tdElement.closest('tr').getAttribute('data-financial-statement-able-item-id');
                            let hasVatRate = vatRateMaps[financialStatementAbleItemId] ? vatRateMaps[financialStatementAbleItemId].has_vat_rate:0;
                            let canBeDeductable = vatRateMaps[financialStatementAbleItemId] ?  vatRateMaps[financialStatementAbleItemId].can_be_dedictiable:0;
                            let corporateTaxesId = domElements.corporateTaxesId;
                            let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                            let salesRevenueId = domElements.salesRevenueId;
                            let salesRevenueRowId = salesRevenueId;
                            let isFinancialExpense = inEditMode && tdElement.parentElement ? tdElement.parentElement.getAttribute('data-is-financial-expense') : tdElement.getAttribute('data-is-financial-expense')
                            let isDeductible = inEditMode && tdElement.parentElement ? tdElement.parentElement.getAttribute('data-is-dedictible') : tdElement.getAttribute('data-is-dedictible')
                            let vatRate = inEditMode && tdElement.parentElement ? tdElement.parentElement.getAttribute('data-vat-rate') : tdElement.getAttribute('data-vat-rate')
                            let firstDateString = $(tdElement).attr("class").split(/\s+/).filter(function(classItem) {
                                return classItem.startsWith('date-');
                            })[0];
                            if (firstDateString) {
                                var firstDate = firstDateString.split('date-')[1]
                                var value = filterNumericUserInput(tdElement.innerHTML, isFinancialExpense);
                                var input = tdElement.parentElement.querySelector('input[data-date="' + firstDate + '"]');
                                input.value = value;
                                let is_repeating_fixed = tdElement.closest('tr').getAttribute('data-is-repeating-fixed');
                                is_repeating_fixed = is_repeating_fixed == 'true' || is_repeating_fixed == 1;

                                let is_percentage = tdElement.closest('tr').getAttribute('data-is-percentage');
                                let is_cost_of_unit = tdElement.closest('tr').getAttribute('data-is-cost-of-unit');
                                is_percentage = is_percentage == 'true' || is_percentage == 1
                                is_cost_of_unit = is_cost_of_unit == 'true' || is_cost_of_unit == 1
                                let is_percentage_or_fixed = tdElement.closest('tr').getAttribute('data-can-be-percentage-or-fixed');
                                is_percentage_or_fixed = is_percentage_or_fixed == 'true' || is_percentage_or_fixed == 1;

                                let currentVal = filterNumericUserInput(tdElement.innerHTML, isFinancialExpense);



                                currentVal = parseFloat(currentVal);

                                if (is_percentage_or_fixed && is_repeating_fixed || is_percentage_or_fixed && !is_percentage && !is_cost_of_unit && inAddOrEditModal) {
                                    var tdSpecificDateIfExist = inAddOrEditModal ? '' : '.date-' + firstDate
                                    var inputSpecificDateIfExist = inAddOrEditModal ? '' : '[data-date="' + firstDate + '"]';
                                    if (reportType == 'modified' && !inAddOrEditModal) {
                                        var loopingDates = getDatesLargerThanDate(firstDate, dates);

                                        loopingDates.forEach((loopingDate) => {
                                            tdSpecificDateIfExist = '.date-' + loopingDate
                                            inputSpecificDateIfExist = '[data-date="' + loopingDate + '"]';
                                            tdElement.closest('tr').querySelector('td.editable-date' + tdSpecificDateIfExist).innerHTML = number_format(currentVal, 2);
                                            var input = tdElement.closest('tr').querySelector('input[data-date]' + inputSpecificDateIfExist)

                                            input.value = currentVal
                                            inputs.push(input)

                                        })

                                        return inputs;
                                    } else {
                                        tdElement.closest('tr').querySelectorAll('td.editable-date' + tdSpecificDateIfExist).forEach(function(td, index) {
                                            td.innerHTML = number_format(currentVal, 2);
                                        })
                                        tdElement.closest('tr').querySelectorAll('input[data-date]' + inputSpecificDateIfExist).forEach(function(input, index) {
                                            input.value = currentVal
                                            inputs.push(input)

                                        })

                                        return inputs


                                    }
                                }
                                if (is_percentage_or_fixed && is_percentage || is_percentage_or_fixed && is_cost_of_unit) {

                                    return recalculatePercentagesOrCostOfUnit(tdElement, firstDate, financialStatementAbleItemId, corporateTaxesId, is_cost_of_unit, earningBeforeTaxesId, salesRevenueId, is_percentage, currentVal)

                                } else {

                                    var val = filterNumericUserInput(tdElement.innerHTML, isFinancialExpense);
                                    var input = tdElement.parentElement.querySelector('input[data-date="' + firstDate + '"]')
                                    input.value = val
                                    inputs.push(input)
                                    return inputs
                                }


                            } else {

                                var val = filterNumericUserInput(tdElement.innerHTML, isFinancialExpense);
                                var input = tdElement.parentElement.querySelector('input.text-input-hidden')
                                input.value = val
                                inputs.push(input)
                                return inputs

                            }


                        }

                        function filterNumericUserInput(value, isFinancialExpense = false) {
                            if (!value) {
                                return 0;
                            }
                            value = value.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "").replace(/[%]/g, '')


                            return isFinancialExpense == 1 && value > 0 ? value * -1 : value
                        }



                        function formatsubrow1(d, dates) {

                            let subtable = `<table id="subtable-1-id${d.id}" class="subtable-1-class table table-striped-  table-hover table-checkable position-relative dataTable no-footer dtr-inline" > <thead style="display:none"><tr><td></td><td></td><td></td><td></td><td></td>
  					  <td></td> <td></td><td></td>  `;
                            for (date in dates) {
                                subtable += ' <td> </td>';
                            }
                            subtable += ` </tr> </thead> `;

                            subtable += '</table>';
                            return (subtable);
                        }

                        // Add event listener for opening and closing details
                        $(document).on('hide.bs.modal', '.edit-sub-modal-class', function() {
                            inEditMode = false
                        })
                        $(document).on('click', '.edit-btn', function() {
                            inEditMode = true
                            const target = $(this).attr('data-target');
                            if (target) {
                                $(target).find('.can-trigger-quantity-modal:checked:first-of-type').trigger('change');
                                $(target).find('.can-trigger-non-repeating-modal:checked:first-of-type').trigger('change');
                            }


                        })
                        $(document).on('change', '.has-collection-policy-class', function() {
                            const hasCollectionPolicy = this.checked

                            const collectionPolicyContent = $(this).closest('.collection-policy').find('.collection-policy-content')
                            $(this).closest('.collection-policy').find('.has_collection_policy_input').val(hasCollectionPolicy ? 1 : 0)

                            if (hasCollectionPolicy) {
                                collectionPolicyContent.removeClass('d-none')
                            } else {
                                collectionPolicyContent.addClass('d-none')
                            }



                        })

                        $(document).on('click', '.can_be_percentage_or_fixed_class', function() {
                            let val = $(this).val();
                            $(this).closest('.how-many-item').find('.non-repeating-fixed-sub,.repeating-fixed-sub,.percentage-sub,.cost-of-unit-sub').removeClass('d-flex').addClass('d-none');
                            $(this).closest('.how-many-item').find('.can_be_percentage_or_fixed_class').prop('checked', false);
                            $(this).prop('checked', true);
                            let classNameToShow = '.' + val.replaceAll(/[_]/g, '-') + '-sub';
                            $(this).closest('.how-many-item').find(classNameToShow).addClass('d-flex').removeClass('d-none');

                        });
                        $(document).on('click', '.filter-btn-class', function(e) {
                            e.preventDefault();
                            $('#loader_id').removeClass('hide_class');
                            const interval = $('select[name="interval_view"]').val();
                            formatDatesForInterval(interval);
                            $(document).trigger('click');
                            $('#loader_id').addClass('hide_class')

                        });
                        $(document).on('click', '.redirect-btn', function(e) {
                            e.preventDefault();
                            window.location.href = $(this).data('redirect-to');
                        })
                        $(document).on('click', function(e) {
                            // close opened custom modal [for filter and export btn]
                            let target = e.target;
                            if (!$(target).closest('.close-when-clickaway').length && !$(target).closest('.do-not-close-when-click-away').length) {
                                $('.close-when-clickaway').addClass('d-none');
                            }
                        });


                        $(document).on('click', '.trigger-child-row-1', function(e) {
                            const parentId = $(e.target.closest('tr')).data('model-id');
                            var parentRow = $(e.target).parent();
                            var subRows = parentRow.nextAll('tr.add-sub.maintable-1-row-class' + parentId);

                            subRows.toggleClass('d-none');
                            if (subRows.hasClass('d-none')) {
                                parentRow.find('td.trigger-child-row-1').removeClass('is-open').addClass('is-close').html('+');
                                var closedId = parentRow.attr('data-financial-statement-able-item-id')
                                const index = opens.indexOf(closedId);
                                //
                                opens.splice(index, 1);

                                if (canRedrawWitdth) {
                                    globalTable.columns.adjust();

                                }
                            } else if (!subRows.length) {
                                // if parent row has no sub rows then remove + or - 
                                parentRow.find('td.trigger-child-row-1').html('×');
                            } else {
                                parentRow.find('td.trigger-child-row-1').addClass('is-open').removeClass('is-close').html('-');
                                opens.push(parentRow.attr('data-financial-statement-able-item-id'));


                                if (canRedrawWitdth) {
                                    globalTable.columns.adjust();

                                }

                            }

                        });



                        $(document).on('click', '.expand-all', function(e) {
                            e.preventDefault();
                            if ($(this).hasClass('is-open-parent')) {
                                $(this).addClass('is-close-parent').removeClass('is-open-parent')
                                $(this).find('span').html('-')

                                $('.is-main-with-sub-items .is-close').trigger('click')
                            } else {
                                $(this).addClass('is-open-parent').removeClass('is-close-parent')
                                $(this).find('span').html('+')

                                $('.is-main-with-sub-items .is-open').trigger('click')
                            }

                        })

                        "use strict";
                        var KTDatatablesDataSourceAjaxServer = function() {
                            function getFixedColumnNumbers() {
                                return $('#fixed-column-number').val()
                            }
                            var initTable1 =
                                function() {

                                    var tableId = '#' + "<?php echo e($tableId); ?>";
                                    var salesGrowthRateId = domElements.salesGrowthRateId
                                    var table = $(tableId);
                                    let data = $('#dates').val();
                                    data = JSON.parse(data);
                                    window['dates'] = data;
                                    const columns = [];
                                    columns.push({
                                        data: 'id'
                                        , searchable: false
                                        , orderable: false
                                        , className: 'trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize  is-close '
                                        , render: function(d, b, row) {
                                            if (!row.isSubItem && row.has_sub_items) {
                                                return '+';
                                            } else if (row.isSubItem && row.pivot && row.pivot.can_be_percentage_or_fixed) {

                                                var subItemViewName = '';
                                                if (row.pivot.sub_item_type != 'actual') {
                                                    subItemViewName = row.pivot.percentage_or_fixed.replaceAll(/[_]/g, ' ');
                                                    if (subItemViewName == 'non repeating fixed') {
                                                        subItemViewName = 'non repeating';
                                                    }
                                                }
                                                return subItemViewName
                                            }
                                            return '';
                                        }
                                    });
                                    columns.push({
                                        render: function(d, b, row) {
                                            let modelId = $('#model-id').val();

                                            if (!row.isSubItem && row.has_sub_items) {
                                                elements = `<a data-is-subitem="0" data-income-statement-item-id="${row.id}" data-income-statement-id="${modelId}" class="d-block add-btn mb-2" href="#" data-toggle="modal" data-target="#add-sub-modal${row.id}"><?php echo e(__('Add')); ?></a> `;
                                                if (row.sub_items.length) {}
                                                return elements;
                                            } else if (row.isSubItem && (row.pivot.created_from == row.pivot.sub_item_type) || vars.subItemType == 'modified' && row.pivot) {
                                                if (vars.subItemType == 'modified' && (row.pivot.percentage_or_fixed == 'non_repeating_fixed' || row.pivot.percentage_or_fixed == 'repeating_fixed')) {
                                                    return '';
                                                }
                                                var deleteItem = vars.subItemType == 'modified' && row.pivot ? '' : `<a data-income-statement-item-id="${row.pivot.financial_statement_able_item_id}" data-income-statement-id="${row.pivot.financial_statement_able_id}" class="d-block  delete-btn text-white mb-2 text-danger" href="#" data-toggle="modal" data-target="#delete-sub-modal${row.pivot.financial_statement_able_item_id + convertStringToClass(row.pivot.sub_item_name) }">
													<i class="fas fa-trash-alt"></i>
													
													</a>`;
                                                return `
											<div class="d-flex align-items-center justify-content-between">
												<a  data-is-subitem="1" data-income-statement-item-id="${row.pivot.financial_statement_able_item_id}" data-income-statement-id="${row.pivot.financial_statement_able_id}" class="d-block edit-btn mb-2 text-white " href="#" data-toggle="modal" data-is-depreciation-or-amortization="${row.pivot.is_depreciation_or_amortization}" data-income-statement-id="${row.pivot.financial_statement_able_id}" data-target="#edit-sub-modal${row.pivot.financial_statement_able_item_id + convertStringToClass(row.pivot.sub_item_name) }"> 
												<i class="fa fa-pen-alt edit-modal-icon"></i>  
												</a> 
												${deleteItem}
													</div>
											`
                                            }
                                            return '';
                                        }
                                        , data: 'id'
                                        , className: 'cursor-pointer sub-text-bg max-w-actions'
                                    , });
                                    columns.push({
                                        render: function(d, b, row) {
                                            this.currentRow = row;
                                            if (row.isSubItem) {
                                                return row.pivot.sub_item_name;
                                            }
                                            return row['name']

                                        }
                                        , data: 'id'
                                        , className: 'sub-text-bg  editable editable-text is-name-cell'
                                    });
                                    for (let i = 0; i < data.length; i++) {
                                        columns.push({
                                            render: function(d, b, row, setting) {
                                                date = data[i];
                                                if (row.isSubItem && row.pivot.payload) {
                                                    var payload = JSON.parse(row.pivot.payload);
                                                    var actualDates = JSON.parse(row.pivot.actual_dates);
                                                    if (actualDates && actualDates.includes(date)) {
                                                        $('.dataTables_scrollHeadInner .main-table-class:eq(0) th:not(.is-actual).date-' + date).addClass('is-actual');
                                                    }
                                                    return payload[date] ? number_format(payload[date]) : 0;
                                                }

                                                if (row.main_rows && row.main_rows[0]) {
                                                    var isPercentageRow = row.is_sales_rate || row.id == salesGrowthRateId
                                                    var noDecimals = isPercentageRow ? 2 : 0;
                                                    var percentageMarket = isPercentageRow ? ' %' : '';

                                                    var autoCalculatedValue = row.main_rows[0].pivot.payload;
                                                    return autoCalculatedValue ? number_format(JSON.parse(autoCalculatedValue)[date], noDecimals) + percentageMarket : 0

                                                }
                                                return 0;

                                            }
                                            , data: 'id'
                                            , className: 'sub-numeric-bg  editable editable-date date-' + data[i]

                                        });




                                    }

                                    columns.push({
                                        render: function(d, b, row, setting) {
                                            var subTotal = row.main_rows && row.main_rows[0] ? row.main_rows[0].pivot.total : 0
                                            return subTotal;

                                        }
                                        , data: 'id'
                                        , className: 'sub-numeric-bg  total-row'

                                    })

                                    const isActualTable = +$('#is-actual-table').val();

                                    // begin first table
                                    table.DataTable({




                                            dom: 'Bfrtip',
                                            // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                            "ajax": {
                                                "url": "<?php echo e($getDataRoute); ?>"
                                                , "type": "post"
                                                , "dataSrc": "data", // they key in the jsom response from the server where we will get our data
                                                "data": function(d) {
                                                    d.search_input = $(getSearchInputSelector(tableId)).val();
                                                    d.sub_item_type = $('#sub-item-type').val()
                                                    d.income_statement_id = $('#income_statement_id').val()
                                                }

                                            }
                                            , "processing": false
                                            , "scrollX": true
                                            , "scrollY": true
                                            , "ordering": false
                                            , 'paging': false
                                            , "fixedColumns": {
                                                left: getFixedColumnNumbers()
                                            }
                                            , "fixedHeader": {
                                                headerOffset: 60
                                            }
                                            , "serverSide": true
                                            , "responsive": false
                                            , "pageLength": 25
                                            , "columns": columns
                                            , columnDefs: [{
                                                targets: 0
                                                , defaultContent: 'salah'
                                                , className: 'red reset-table-width text-nowrap'
                                            }]
                                            , buttons: [{
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<svg style="margin-right:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" id="Path-103" fill="#000000" fill-rule="nonzero" opacity="0.3"/><rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="2" width="2" height="12" rx="1"/><path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" id="Path-104" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000) "/></g></svg>' + '<?php echo e(__("Upload Actual Template")); ?>'
                                                    , 'className': isActualTable ? 'btn btn-bold btn-secondary ml-2 filter-table-btn  flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away import-modal-class' : 'd-none'

                                                }
                                                , {
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<span style="margin-right:10px;position:relative" class="svg-icon kt-svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Files/Import.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><rect fill="#000000" opacity="0.3" transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) " x="11" y="1" width="2" height="12" rx="1"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/><path d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z" fill="#000000" fill-rule="nonzero"/></g></svg></span>' + '<?php echo e(__("Download Actual Template")); ?>'
                                                    , 'className': isActualTable ? 'btn btn-bold btn-secondary ml-2 filter-table-btn  flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away' : 'd-none'
                                                    , "action": function() {
                                                        window.location.href = "<?php echo e(route('admin.export.excel.template',['company'=>$company->id,'incomeStatement'=>$incomeStatement->id])); ?>"
                                                    }
                                                }, {
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<svg style="margin-right:10px;position:relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"/></g></svg>' + '<?php echo e(__("Analysis")); ?>'
                                                    , 'className': 'btn btn-bold btn-secondary filter-table-btn ml-2  flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away'
                                                    , "action": function() {
                                                        window.location.href = "<?php echo e(route('dashboard.breakdown.incomeStatement',[$company->id,$reportType,$incomeStatement->id])); ?>"
                                                    }
                                                },

                                                {
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<svg style="margin-right:10px;position:relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"/></g></svg>' + '<?php echo e(__("Interval View")); ?>'
                                                    , 'className': 'btn btn-bold btn-secondary filter-table-btn ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away'
                                                    , "action": function() {
                                                        $('#filter_form-for-' + tableId.replace('#', '')).toggleClass('d-none');
                                                    }
                                                }
                                                , {
                                                    "text": '<svg style="margin-right:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" id="Path-103" fill="#000000" fill-rule="nonzero" opacity="0.3"/><rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="2" width="2" height="12" rx="1"/><path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" id="Path-104" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000) "/></g></svg>' + '<?php echo e(__("Export [Excel]")); ?>'
                                                    , 'className': 'btn btn-bold btn-secondary  flex-1 flex-grow-0 btn-border-radius ml-2 do-not-close-when-click-away'
                                                    , "action": function() {
                                                        let form = $('form#store-report-form-id');
                                                        $('#export_type').val(0);
                                                        let oldFormAction = form.attr('action');
                                                        let exportFormAction = "<?php echo e(route('admin.export.income.statement.report',$company->id)); ?>";
                                                        form.attr('action', exportFormAction);
                                                        form.submit();
                                                        form.attr('action', oldFormAction);

                                                        // $('#export_form-for-'+tableId.replace('#','')).toggleClass('d-none');
                                                    }
                                                },

                                                {
                                                    "text": '<svg style="margin-right:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" id="Path-103" fill="#000000" fill-rule="nonzero" opacity="0.3"/><rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="2" width="2" height="12" rx="1"/><path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" id="Path-104" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000) "/></g></svg>' + '<?php echo e(__("Export [Pdf]")); ?>'
                                                    , 'className': 'btn btn-bold btn-secondary  flex-1 flex-grow-0 btn-border-radius ml-2 do-not-close-when-click-away'
                                                    , "action": function() {
                                                        let form = $('form#store-report-form-id');
                                                        let oldFormAction = form.attr('action');
                                                        $('#export_type').val(1);
                                                        $('#pdf_only').val(JSON.stringify(opens))
                                                        let exportFormAction = "<?php echo e(route('admin.export.income.statement.report.pdf',$company->id)); ?>";
                                                        form.attr('action', exportFormAction);
                                                        form.submit();
                                                        form.attr('action', oldFormAction);

                                                        // $('#export_form-for-'+tableId.replace('#','')).toggleClass('d-none');
                                                    }
                                                },


                                            ]
                                            , createdRow: function(row, data, dataIndex, cells) {

                                                let reportType = vars.subItemType;
                                                let subOfSelect = ''

                                                let salesGrowthRateId = domElements.salesGrowthRateId;
                                                let costOfGoodsId = domElements.costOfGoodsId;
                                                let corporateTaxesId = domElements.corporateTaxesId;
                                                let salesReveueId = domElements.salesRevenueId;
											
                                                if (data.id == salesReveueId&& !data.duration) {
											
                                                    sales_revenues_sub_items_names = [{id:'all',name:'<?php echo e(__("All")); ?>'}];
                                                    sales_revenues_quantity_sub_items_names = [{id:'all',name:"<?php echo e(__('All')); ?>"}];

                                                    if (data.sub_items ) {
										
                                                        data.sub_items.forEach(function(subItemParent) {

                                                            if (subItemParent.pivot.is_quantity == 0) {
															
                                                                sales_revenues_sub_items_names.push({id:subItemParent.pivot.id , name:subItemParent.pivot.sub_item_name})
                                                            } else if (subItemParent.pivot.is_quantity && subItemParent.pivot.is_quantity != 0) {
                                                                sales_revenues_quantity_sub_items_names.push({id:subItemParent.pivot.id , name:subItemParent.pivot.sub_item_name})

                                                            }
                                                        });
                                                    }

                                                    window['sales_revenues_sub_items_names'] = sales_revenues_sub_items_names;
                                                    window['sales_revenues_quantity_sub_items_names'] = sales_revenues_quantity_sub_items_names;
                                                }
                                                if (data.id == costOfGoodsId) {
                                                    cost_of_goods_sub_items_names = [];
                                                    if (data.sub_items) {
                                                        data.sub_items.forEach(function(subItemParent) {
                                                            if (subItemParent.pivot.is_quantity == 0) {
                                                                cost_of_goods_sub_items_names.push({id:subItemParent.pivot.id,name:subItemParent.pivot.sub_item_name})
                                                            }
                                                        });
                                                    }

                                                    window['cost_of_goods_sub_items_names'] = cost_of_goods_sub_items_names;
                                                }
                                                var totalOfRowArray = [];
                                                var incomeStatementId = data.isSubItem ? data.pivot.financial_statement_able_id : $('#model-id').val();
                                                var incomeStatementItemId = data.isSubItem ? data.pivot.financial_statement_able_item_id : data.id;
                                                var subItemName = data.isSubItem ? data.pivot.sub_item_name : '';
                                                let is_quantity = false;

                                                $(cells).filter(".editable").attr('contenteditable', true)
                                                    .attr('data-income-statement-id', incomeStatementId)
                                                    .attr('title', "<?php echo e(__('Click To Edit')); ?>")
                                                    .attr('data-main-model-id', incomeStatementId)
                                                    .attr('data-income-statement-item-id', incomeStatementItemId)
                                                    .attr('data-financial-statement-able-item-id', incomeStatementItemId)
                                                    .attr('data-main-row-id', incomeStatementItemId)
                                                    .attr('data-sub-item-name', subItemName)
                                                    .attr('data-table-id', "<?php echo e($tableId); ?>")
                                                    .attr('data-is-quantity', data.isSubItem ? data.pivot.is_quantity : false)
                                                    .attr('data-is-financial-expense', data.isSubItem ? data.pivot.is_financial_expense : false)
                                                    .attr('data-vat-rate', data.isSubItem ? data.pivot.vat_rate : 0)
                                                    .attr('data-is-deductible', data.isSubItem ? data.pivot.is_deductible : false)
                                                    .attr('data-is-financial-income', data.isSubItem ? data.pivot.is_financial_income : false)
                                                    .attr('data-percentage-value', data.isSubItem && data.pivot.percentage_or_fixed == 'percentage' ? data.pivot.percentage_value : -1)
                                                    .attr('data-cost-of-unit-value', data.isSubItem && data.pivot.percentage_or_fixed == 'cost_of_unit' ? data.pivot.cost_of_unit_value : -1)
                                                if (data.isSubItem) {
                                                    let has_percentage_or_fixed_sub_items = '';
                                                    if (data.pivot.can_be_percentage_or_fixed && reportType != 'actual') {
                                                        sub_items_options = '';
                                                        sub_items_quantity_options = '';
                                                        var checkedPercentages = [];
                                                        var checkedCostOfUnit = [];
                                                        if (data.pivot.percentage_value) {
                                                            checkedPercentages = JSON.parse(data.pivot.is_percentage_of);
                                                        }
                                                        if (data.pivot.cost_of_unit_value) {
                                                            checkedCostOfUnit = JSON.parse(data.pivot.is_cost_of_unit_of) ? JSON.parse(data.pivot.is_cost_of_unit_of) : [];
                                                        }
                                                        if (data.pivot.financial_statement_able_item_id == corporateTaxesId) {
                                                            sub_items_options = '<option selected value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'

                                                        } else {
                                                            window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                                var isCurrentChecked = checkedPercentages && (checkedPercentages.includes(MainItemObject.id.toString()) || checkedPercentages.includes(MainItemObject.name) )  ? ' selected' : ' ';
                                                                sub_items_options += '<option ' + isCurrentChecked + ' value="' + MainItemObject.id + '">' + MainItemObject.name + '</option>'
                                                            })

                                                            window['sales_revenues_quantity_sub_items_names'].forEach(function(MainItemObject) {
                                                                var isCurrentChecked = checkedCostOfUnit.includes(MainItemObject.id.toString()) || checkedCostOfUnit.includes(MainItemObject.name) ? ' selected' : ' ';
                                                                sub_items_quantity_options += '<option ' + isCurrentChecked + ' value="' + MainItemObject.id + '">' + MainItemObject.name + '</option>'
                                                            })

                                                        }
                                                        var nonRepeatingFixedisChecked = '';
                                                        var repeatingFixedisChecked = '';
                                                        var percentageisChecked = '';
                                                        var costOfUnitisChecked = '';
                                                        var nonRepeatingFixedDisplay = 'd-none';
                                                        var repeatingFixedDisplay = 'd-none';
                                                        var costOfUnitDisplay = 'd-none';
                                                        var percentageDisplay = 'd-none';
                                                        if (data.pivot.percentage_or_fixed == 'non_repeating_fixed') {
                                                            nonRepeatingFixedisChecked = 'checked';
                                                            nonRepeatingFixedDisplay = '';

                                                        } else if (data.pivot.percentage_or_fixed == 'repeating_fixed') {
                                                            repeatingFixedisChecked = 'checked';
                                                            repeatingFixedDisplay = '';
                                                        } else if (data.pivot.percentage_or_fixed == 'percentage') {
                                                            percentageisChecked = 'checked';
                                                            percentageDisplay = ''

                                                        } else if (data.pivot.percentage_or_fixed == 'cost_of_unit') {
                                                            costOfUnitisChecked = 'checked'
                                                            costOfUnitDisplay = ''

                                                        }

                                                        var repeating = `<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
																	<label ><?php echo e(__('Non-Repeating Amount')); ?></label>
															
															<input data-sub-item-name="${data.pivot.sub_item_name}" data-in-edit-mode="1" ${nonRepeatingFixedisChecked} class="can_be_percentage_or_fixed_class non-repeating-fixed can-trigger-non-repeating-modal" type="checkbox" value="non_repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
															</div>
															</div>
															<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label ><?php echo e(__('Repeating Fixed Amount')); ?></label>
																	<input ${repeatingFixedisChecked}  class="can_be_percentage_or_fixed_class repeating-fixed" type="checkbox" value="repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
																	</div>
															</div>`;



                                                        var hideRepeating = false;

                                                        if (parseInt(data.pivot.financial_statement_able_item_id) == parseInt(corporateTaxesId.trim())) {
                                                            hideRepeating = true
                                                        }
                                                        if (hideRepeating) {
                                                            repeating = ''
                                                        }
                                                        const canViewPercentageOfSalesAndCostOfUnit = data.pivot.financial_statement_able_item_id != domElements.corporateTaxesId
                                                        subOfSelect = canViewPercentageOfSalesAndCostOfUnit ? `<div class="mt-2">
														<label><?php echo e(__('Sub Of')); ?></label>
														<select  name="sub_of_id" class="form-control main-row-select" data-selected-main-row="${data.pivot.financial_statement_able_item_id}">
															
														</select>
													
												</div>` : `<input type="hidden" name="sub_of_id" value="${domElements.corporateTaxesId}"> `
                                                        const percentageAndCostOfUnitAndRepeatingDivs = data.pivot.financial_statement_able_item_id != domElements.corporateTaxesId ? `<div class="form-group custom-divs-class">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
																<label ><?php echo e(__('% Of Sales')); ?></label>
															<input ${percentageisChecked} class="can_be_percentage_or_fixed_class percentage-of-sales" type="checkbox" value="percentage" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
																<div class="form-group custom-divs-class">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
																<label ><?php echo e(__('Cost Per Unit')); ?></label>
															<input ${costOfUnitisChecked} class="can_be_percentage_or_fixed_class cost-of-unit" type="checkbox" value="cost_of_unit" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
															
															
															
															
															</div>
															
															<div class="non-repeating-fixed-sub ${nonRepeatingFixedDisplay}">
															</div>
															<div class="repeating-fixed-sub ${repeatingFixedDisplay}">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label class="form-label flex-self-start"><?php echo e(__('Amount')); ?></label>
																	<input type="text" class="form-control" name="sub_items[0][repeating_fixed_value]" value="${data.pivot.repeating_fixed_value ? data.pivot.repeating_fixed_value : 0}">
																</div>
															</div>
															
															<div class="percentage-sub w-100 ${percentageDisplay}">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap" style="width:60% !important">
																	<div class="d-flex parent-for-select flex-column align-items-center justify-content-center flex-wrap" style="width:100% !important">
																		<label class="form-label flex-self-start"><?php echo e(__('% Of')); ?></label>
																	
																	<select multiple
																	data-width="auto"
																class="form-select select select2-select2 sub_select"   name="sub_items[0][is_percentage_of][]">
																	${sub_items_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap margin-left-auto w-160px">
																		<label class="flex-self-start"><?php echo e(__('Percentage Value')); ?></label>
																		<div>
																			<input value="${data.pivot.percentage_value?data.pivot.percentage_value:0}" type="text" class="form-control" name="sub_items[0][percentage_value]">
																			</div>	
																	</div>
															</div>
															
																
															
															
															
															
															<input type="hidden" name="sub_items[0][can_be_percentage_or_fixed]" value="1">
															
															<div class="cost-of-unit-sub w-100 ${costOfUnitDisplay}">
																<div class="d-flex align-items-center justify-content-between" style="flex:1">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap" style="width:60% !important">
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap " style="width:100% !important">
																		<label class="form-label flex-self-start"><?php echo e(__('Cost Per Unit Of')); ?></label>
																	<select multiple
																class="form-select select select2-select2 sub_select"   name="sub_items[0][is_cost_of_unit_of][]">
																	${sub_items_quantity_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap margin-left-auto w-160px">
																		<label class="flex-self-start"><?php echo e(__('Cost Per Unit Value')); ?></label>
																		<div>
																			<input value="${data.pivot.cost_of_unit_value?data.pivot.cost_of_unit_value:0}" type="text" class="form-control" name="sub_items[0][cost_of_unit_value]"
																			</div>	
																	</div>
															</div>
																</div>
																
																</div>
																
																
																
																` : `
															<input type="hidden" name="sub_items[0][is_percentage_of][]" value="Earning Before Taxes - EBT">
															
															<input type="hidden" name="sub_items[0][percentage_or_fixed]" value="percentage">
																<input type="hidden" name="sub_items[0][can_be_percentage_or_fixed]" value="1">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap w-160px">
																		<label class="flex-self-start"><?php echo e(__('Percentage Value')); ?></label>
																		<div>
																			<input value="${data.pivot.percentage_value?data.pivot.percentage_value:0}" type="text" class="form-control" name="sub_items[0][percentage_value]">
																			</div>	
																	</div>
															</div>
															`













                                                        has_percentage_or_fixed_sub_items =
                                                            `
															<br>
															<div class="flex-checkboxes how-many-item" data-id="0">
																<div class="form-check mt-2">
															
															${repeating}
															
															${percentageAndCostOfUnitAndRepeatingDivs}
																
																
																`;



                                                    }

                                                    let Depreciation = '';

                                                    var quantity = '';
                                                    if (data.pivot && data.pivot.can_be_quantity) {
                                                        if (data.pivot.is_quantity) {
                                                        }

                                                    }
                                                    if (data.pivot && data.pivot.can_be_depreciation) {
                                                        let checkedDepreciation = '';
                                                        if (data.pivot.is_depreciation_or_amortization) {
                                                            checkedDepreciation = ' checked ';
                                                        }
                                                        Depreciation = `
																<label><?php echo e(__('Is Depreciation Or Amortization ? ')); ?></label>
										
															<input ${checkedDepreciation} class="" type="checkbox" value="1" name="is_depreciation_or_amortization"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">`
                                                    }

                                                    $(row).append(
                                                        `
										<div class="modal fade edit-sub-modal-class" id="edit-sub-modal${data.pivot.financial_statement_able_item_id + convertStringToClass(data.pivot.sub_item_name) }" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content modal-xl">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Sub Item For')); ?> ${data.pivot.sub_item_name} </h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form data-financial-statement-able-item-id="${data.pivot.financial_statement_able_item_id}" id="edit-sub-item-form${data.pivot.financial_statement_able_item_id + convertStringToClass(data.pivot.sub_item_name)  }" class="edit-submit-sub-item" action="<?php echo e(route('admin.update.income.statement.report',['company'=>getCurrentCompanyId()])); ?>">
														<input type="hidden" name="in_add_or_edit_modal" value="1">
														
														<input type="hidden" name="sub_item_type" value="<?php echo e(getReportNameFromRouteName(Request()->route()->getName())); ?>">
														<input type="hidden" name="financial_statement_able_item_id"  value="${data.pivot.financial_statement_able_item_id}">
														<input  type="hidden" name="financial_statement_able_id"  value="<?php echo e($incomeStatement->id); ?>">
														<input  type="hidden" name="income_statement_id"  value="<?php echo e($incomeStatement->id); ?>">
														<input  type="hidden" name="in_edit_mode"  value="1">
														<input  type="hidden" name="was_financial_income"  value="${data.pivot && data.pivot.is_financial_income!=null ? data.pivot.is_financial_income :''}">
														<input  type="hidden" name="was_financial_expense"  value="${data.pivot && data.pivot.is_financial_expense!=null ? data.pivot.is_financial_expense :''}">
														<input  type="hidden" name="sub_item_name"  value="${data.pivot.sub_item_name}">
														<div class="d-flex align-items-center">
														
																<div style="width:75%">
														<label><?php echo e(__('Name')); ?></label>
														<input ${data.pivot.financial_statement_able_item_id == domElements.corporateTaxesId ? 'readonly':'' } name="new_sub_item_name"  class="form-control mb-2" type="text" value="${data.pivot.sub_item_name}">
														
														</div>
														<div style="margin-left: 15px;
															display: flex;
															flex-direction: column;
															align-items: center;">
															
														${Depreciation}
														</div>
														${data.pivot.financial_statement_able_item_id == domElements.salesRevenueId ? getSalesRevenueModal(true ,data.pivot,data.pivot.financial_statement_able_item_id) : ''}
														</div>
														
														${has_percentage_or_fixed_sub_items}
														${subOfSelect}
														${getNonRepeatingModal(true ,data.pivot,data.pivot.financial_statement_able_item_id)}
														${getVatRate(true ,data.pivot,data )}
														
														${getFinancialIncomeOrExpenseCheckBoxes(true ,data.pivot,data.pivot.financial_statement_able_item_id )}
														${getCollectionPolicyHtml(true,data.pivot,data.pivot.financial_statement_able_item_id)}
														</div>

														
													</form>
												<div class="modal-footer" style="border-top:0 !important">
													<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
													<button type="button" class="btn btn-primary save-sub-item-edit" data-id="${data.pivot.financial_statement_able_item_id}" data-sub-item-name="${data.pivot.sub_item_name }"><?php echo e(__('Edit')); ?></button>
												</div>
												</div>
											</div>
												</div>
												`
                                                    )


                                                    $(row).append(
                                                        `
                            
                            
											<div class="modal fade delete-item-modal" data-item-id="${data.pivot.financial_statement_able_item_id}" data-sub-name="${data.pivot.sub_item_name}" id="delete-sub-modal${data.pivot.financial_statement_able_item_id + convertStringToClass(data.pivot.sub_item_name)}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content ">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Delete Sub Item ')); ?> ${data.pivot.sub_item_name} </h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form id="delete-sub-item-form${data.pivot.financial_statement_able_item_id+convertStringToClass(data.pivot.sub_item_name) }" class="delete-submit-sub-item" action="<?php echo e(route('admin.destroy.income.statement.report',['company'=>getCurrentCompanyId()])); ?>">
																<input type="hidden" value="1" name="in_delete_modal" >
																<input type="hidden" name="sub_item_type" value="<?php echo e(getReportNameFromRouteName(Request()->route()->getName())); ?>">
																<input type="hidden" name="income_statement_id" value="<?php echo e($incomeStatement->id); ?>">
																<input type="hidden" name="is_financial_income" value="${data.pivot.is_financial_income }">
																<input type="hidden" name="is_financial_expense" value="${data.pivot.is_financial_expense}">
																<input type="hidden" name="financial_statement_able_item_id"  value="${data.pivot.financial_statement_able_item_id}">
																<input  type="hidden" name="financial_statement_able_id"  value="<?php echo e($incomeStatement->id); ?>">
																<input  type="hidden" name="sub_item_name"  value="${data.pivot.sub_item_name}">
																<p><?php echo e(__('Are You Sure To Delete ')); ?> ${data.pivot.sub_item_name}  ? </p>
															</form>
														</div>
														<div class="modal-footer" style="border-top:0 !important">
															<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
															<button type="button" class="btn btn-primary save-sub-item-delete" data-id="${data.pivot.financial_statement_able_item_id}" data-sub-item-name="${data.pivot.sub_item_name }" ><?php echo e(__('Delete')); ?></button>
														</div>
														</div>
													</div>
														</div>
														`
                                                    )

                                                    $(row).addClass('edit-info-row').addClass('add-sub maintable-1-row-class' + (incomeStatementItemId))
                                                    $(row).addClass('d-none is-sub-row ');
                                                    $(row).attr('data-sub-item-name', data.pivot.sub_item_name)

                                                    $(row).attr('data-percentage-value', data.pivot && data.pivot.percentage_or_fixed == 'percentage' ? data.pivot.percentage_value || 0 : 0)
                                                    $(row).attr('data-cost-of-unit-value', data.pivot && data.pivot.percentage_or_fixed == 'cost_of_unit' ? data.pivot.cost_of_unit_value || 0 : 0)
                                                    $(row).attr('data-is-financial-expense', data.pivot && data.pivot.is_financial_expense == '1' ? 1 : 0)
                                                    $(row).attr('data-is-quantity', data.pivot && data.pivot.is_quantity == '1' ? 1 : 0)
                                                    $(row).attr('data-is-financial-income', data.pivot && data.pivot.is_financial_income == '1' ? 1 : 0)
                                                    $(row).attr('data-vat-rate', data.pivot ? data.pivot.vat_rate : 0)
                                                    $(row).attr('data-is-deductible', data.pivot ? data.pivot.is_deductible : 0)

                                                    if (data.pivot.can_be_percentage_or_fixed) {
                                                        $(row).attr('data-can-be-percentage-or-fixed', data.pivot.can_be_percentage_or_fixed)
                                                        $(row).attr('data-is-percentage-of', data.pivot.is_percentage_of)
                                                        $(row).attr('data-is-cost-of-unit-of', data.pivot.is_cost_of_unit_of)
                                                        $(row).attr('data-percentage-or-fixed', data.pivot.percentage_or_fixed)
                                                        $(row).attr('data-is-percentage', data.pivot.percentage_or_fixed == 'percentage')
                                                        $(row).attr('data-is-cost-of-unit', data.pivot.percentage_or_fixed == 'cost_of_unit')
                                                        $(row).attr('data-is-repeating-fixed', data.pivot.percentage_or_fixed == 'repeating_fixed')
                                                        $(row).attr('data-is-none-repeating-fixed', data.pivot.percentage_or_fixed == 'non_repeating_fixed')
                                                        $(row).attr('data-financial-statement-able-item-id', incomeStatementItemId)

                                                    }



                                                    if (data.pivot && data.pivot.is_depreciation_or_amortization) {
                                                        $(row).addClass('is-depreciation-or-amortization')
                                                    }


                                                    $(cells).filter('.editable.editable-date').each(function(index, dateDt) {
                                                        var filterDate = $(dateDt).attr("class").split(/\s+/).filter(function(classItem) {
                                                            return classItem.startsWith('date-');
                                                        })[0];
                                                        // good
                                                        filterDate = filterDate.split('date-')[1];
                                                        totalOfRowArray.push(parseFloat(filterNumericUserInput($(dateDt).html(), data.pivot ? data.pivot.is_financial_expense : 0)));

                                                        var hiddenInput = `<input type="hidden" name="value[${incomeStatementId}][${incomeStatementItemId}][${subItemName}][${filterDate}]" data-date="${filterDate}" data-is-quantity="${data.pivot ? data.pivot.is_quantity : 0}" data-is-cost-of-unit="${data.pivot ? data.pivot.is_cost_of_unit_of : 0}" data-parent-model-id="${incomeStatementItemId}" value="${(filterNumericUserInput($(dateDt).html(), data.pivot ? data.pivot.is_financial_expense : 0 ))}" >
														<input type="hidden" name="is_financial_income[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]"  value="${data.pivot && data.pivot.is_financial_income!= null? data.pivot.is_financial_income :0}" >
														
														 `;
                                                        $(dateDt).after(hiddenInput);

                                                    });

                                                    $(row).append(
                                                        `<input type="hidden" class="input-hidden-for-total" name="subTotals[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]"  data-parent-model-id="${incomeStatementItemId}" value="0" >`
                                                    );


                                                    $(cells).filter('.editable.editable-text').each(function(index, textDt) {



                                                        var hiddenInput = `<input type="hidden" class="text-input-hidden"  name="financialStatementAbleItemName[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]" value="${$(textDt).html()}" > `;
                                                        $(textDt).after(hiddenInput);
                                                    })

                                                } else {
                                                    if (!data.has_sub_items) {

                                                        $(row).addClass('main-with-no-child').attr('data-model-id', data.id).attr('data-financial-statement-able-item-id', data.id);
                                                        $(cells).filter('.editable.editable-date').each(function(index, dateDt) {

                                                            var filterDate = $(dateDt).attr("class").split(/\s+/).filter(function(classItem) {
                                                                return classItem.startsWith('date-');
                                                            })[0];
                                                            filterDate = filterDate.split('date-')[1];

                                                            var hiddenInput = `<input type="hidden" name="valueMainRowWithoutSubItems[${incomeStatementId}][${incomeStatementItemId}][${filterDate}]" data-date="${filterDate}" data-parent-model-id="${incomeStatementItemId}" value="${(filterNumericUserInput($(dateDt).html(),data.pivot ? data.pivot.is_financial_expense : false))}" > `;
                                                            $(dateDt).after(hiddenInput);
                                                        });
                                                        var subTotal = data.main_rows && data.main_rows[0] ? data.main_rows[0].pivot.total : 0
                                                        totalOfRowArray.push(parseFloat(subTotal))
                                                        $(row).append(`
											<input type="hidden" class="input-hidden-for-total" name="totals[${incomeStatementId}][${incomeStatementItemId}]" value="${subTotal}">
										`);


                                                        let dependOn = data.depends_on ? JSON.parse(data.depends_on) : [];
                                                        if (dependOn.length) {
                                                            $(row).attr('data-depends-on', dependOn.join(','))
                                                        }
                                                        $(cells).each(function(index, cell) {
                                                            $(cell).removeClass('editable').removeClass('editable-text').attr('contenteditable', false).attr('title', '')
                                                        });


                                                        if (data.is_sales_rate) {
                                                            $(row).addClass('is-sales-rate ');
                                                        }

                                                        if (data.is_sales_rate || data.id == salesGrowthRateId) {
                                                            if (data.id == salesGrowthRateId) {
                                                                $(row).addClass('is-sales-growth-rate')
                                                            }
                                                            $(row).addClass('is-rate');
                                                        } else {


                                                        }

                                                    } else {
                                                        $(row).addClass('is-main-with-sub-items').attr('data-financial-statement-able-item-id', data.id);
                                                        if (data.is_main_for_all_calculations) {
                                                            $(row).addClass('is-main-for-all-calculations');
                                                        }
                                                        $(cells).filter('.editable.editable-date').each(function(index, dateDt) {
                                                            var filterDate = $(dateDt).attr("class").split(/\s+/).filter(function(classItem) {
                                                                return classItem.startsWith('date-');
                                                            })[0];


                                                            filterDate = filterDate.split('date-')[1];
                                                            totalOfRowArray.push(parseFloat(filterNumericUserInput($(dateDt).html(), data.pivot ? data.pivot.is_financial_expense : 0)));

                                                            var hiddenInput = `<input type="hidden" class="main-row-that-has-sub-class" name="valueMainRowThatHasSubItems[${incomeStatementId}][${incomeStatementItemId}][${filterDate}]" data-date="${filterDate}" data-parent-model-id="${incomeStatementItemId}" value="${(filterNumericUserInput($(dateDt).html(),data.pivot ? data.pivot.is_financial_expense : 0))}" > `;
                                                            $(dateDt).after(hiddenInput);
                                                        });
                                                        var subTotal = data.main_rows && data.main_rows[0] ? data.main_rows[0].pivot.total : 0

                                                        $(row).append(
                                                            `<input type="hidden" class="input-hidden-for-total" name="totals[${incomeStatementId}][${incomeStatementItemId}]"  data-parent-model-id="${incomeStatementItemId}" value="${subTotal}" >`
                                                        );

                                                        $(cells).each(function(index, cell) {
                                                            $(cell).removeClass('editable').removeClass('editable-text').attr('contenteditable', false).attr('title', '')
                                                        });

                                                        // ssss

                                                        let has_percentage_or_fixed_sub_items = '';
                                                        if (data.has_percentage_or_fixed_sub_items && reportType != 'actual') {
                                                            sub_items_options = '';
                                                            sub_items_of_unit_options = '';
                                                            let corporateTaxesId = $('#corporate-taxes-id').val();

                                                            if (data.id == corporateTaxesId) {
                                                                sub_items_options = '<option value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'
                                                            } else {
															//	var all_options = [];
															//	var all_options_quantity = [];
															//	 window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
															//		all_options.push(MainItemObject.id.toString());
                                                            //    })
																
                                                                window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                                    sub_items_options += '<option value="' + MainItemObject.id.toString() + '">' + MainItemObject.name + '</option>'
                                                                })
															//	  window['sales_revenues_quantity_sub_items_names'].forEach(function(MainItemObject) {
															//		all_options_quantity.push( MainItemObject.id.toString())
                                                            //    })
																
                                                                window['sales_revenues_quantity_sub_items_names'].forEach(function(MainItemObject) {
                                                                    sub_items_of_unit_options += '<option value="' + MainItemObject.id.toString() + '">' + MainItemObject.name + '</option>'
                                                                })
                                                            }
                                                            var hideRepeating = false;

                                                            if (parseInt(data.id) == parseInt(corporateTaxesId.trim())) {
                                                                hideRepeating = true
                                                            }


                                                            var repeating = `<div class="form-group custom-divs-class">
															
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label ><?php echo e(__('Non-Repeating Amount')); ?></label>
															
															<input data-sub-item-name="new" data-in-edit-mode="0"  class="can_be_percentage_or_fixed_class non-repeating-fixed can-trigger-non-repeating-modal" type="checkbox" value="non_repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
															<input   type="hidden" value="1" name="in_add_mode"  >	
															</div>
															</div>
															<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label ><?php echo e(__('Repeating Fixed Amount')); ?></label>
																	
																	<input class="can_be_percentage_or_fixed_class repeating-fixed" type="checkbox" value="repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
																	</div>
															</div>`;
                                                            if (hideRepeating) {

                                                                repeating = ''
                                                            }
                                                            has_percentage_or_fixed_sub_items =
                                                                `
															<br>
															<div class="flex-checkboxes">
															
																<div class="form-check mt-2">
															
															${repeating}
															
														<div class="form-group custom-divs-class">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
																<label ><?php echo e(__('% Of Sales')); ?></label>
															<input class="can_be_percentage_or_fixed_class percentage-of-sales" type="checkbox" value="percentage" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
															
															<div class="form-group custom-divs-class">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
																<label ><?php echo e(__('Cost Per Unit')); ?></label>
															<input class="can_be_percentage_or_fixed_class cost-of-unit" type="checkbox" value="cost_of_unit" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
															</div>
															
															
															
															</div>
															
															<div class="non-repeating-fixed-sub d-none">
															</div>
															<div class="repeating-fixed-sub d-none">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label class="form-label flex-self-start"><?php echo e(__('Amount')); ?></label>
																	<input type="text" class="form-control" name="sub_items[0][repeating_fixed_value]" value="0">
																</div>
															</div>
															
															<div class="percentage-sub d-none w-100">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap" style="width:60% !important">
																	<div class="d-flex parent-for-select flex-column align-items-center justify-content-center flex-wrap" style="width:100% !important">
																		<label class="form-label flex-self-start"><?php echo e(__('% Of')); ?></label>
																	
																	<select multiple
																	data-width="auto"
																class="form-select select select2-select2 sub_select"   name="sub_items[0][is_percentage_of][]">
																	${sub_items_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap margin-left-auto w-160px">
																		<label class="flex-self-start"><?php echo e(__('Percentage Value')); ?></label>
																		<div>
																			<input type="text" class="form-control" name="sub_items[0][percentage_value]"
																			</div>	
																	</div>
															</div>
															
														
															
															<input type="hidden" name="sub_items[0][can_be_percentage_or_fixed]" value="1">
																</div>
																
																
																	<div class="cost-of-unit-sub d-none w-100">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap" style="width:60% !important">
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap" style="width:100% !important">
																		<label class="form-label flex-self-start"><?php echo e(__('Cost Per Unit Of')); ?></label>
																	
																	<select multiple
																class="form-select select select2-select2 sub_select"   name="sub_items[0][is_cost_of_unit_of][]">
																	${sub_items_of_unit_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap margin-left-auto w-160px">
																		<label class="flex-self-start"><?php echo e(__('Cost Per Unit Value')); ?></label>
																		<div>
																			<input type="text" class="form-control" name="sub_items[0][cost_of_unit_value]"
																			</div>	
																	</div>
															</div>
															
															`;
                                                        }


                                                        var increaseNameWidth = null;
                                                        if (data.has_percentage_or_fixed_sub_items) {
                                                            $(row).addClass('has-percentage-or-fixed-sub-items').attr('data-financial-statement-able-item-id', incomeStatementItemId)
                                                        } else {
                                                            increaseNameWidth = true
                                                        }
                                                        if (data.has_depreciation_or_amortization) {
                                                            $(row).addClass('has-depreciation-or-amortization');
                                                            nameAndDepreciationIfExist = ` <div class="append-names mt-2" data-id="${data.id}">

											<div class="form-group how-many-item d-flex flex-wrap text-nowrap justify-content-between align-items-center border-bottom-popup" data-id="${data.id}" data-index="0">
											<div style="display:flex;align-items:center;justify-content:space-between;width:100%">
												<div style="width:60%">
													<label class="form-label"><?php echo e(__('Name')); ?></label>
													<input  name="sub_items[0][name]" type="text" value="" class="form-control names-items-names trim-when-key-up" required>
												</div>
												
												<div class="form-check mt-2 text-center ">
												<label class="form-check-label"  style="margin-top:3px;display:block" >
													<?php echo e(__('Is Depreciation Or Amortization ?')); ?>

												</label>

												<input class="" type="checkbox" value="1" name="sub_items[0][is_depreciation_or_amortization]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
												</div>
											</div>
												` + has_percentage_or_fixed_sub_items + `
												</div>
															 `;
                                                        } else {
                                                            if (data.id == domElements.financialIncomeOrExpensesId) {
                                                                // quantityCheckbox = ''
                                                                increaseNameWidth = true
                                                            }
                                                            nameAndDepreciationIfExist = ` <div class="append-names mt-2" data-id="${data.id}">

															<div class="form-group how-many-item d-flex flex-wrap text-nowrap justify-content-between align-items-center border-bottom-popup" data-id="${data.id}" data-index="0">
																<div style="display:flex;align-items:center;width:100%;justify-content:space-between; ">
																<div class="${increaseNameWidth ? 'width-66' : ''}"><label class="form-label"><?php echo e(__('Name')); ?></label>
																<input name="sub_items[0][name]" type="text" value="" class="form-control trim-when-key-up  names-items-names" required></div>
																` + `` + `</div>` +
                                                                `
																` + has_percentage_or_fixed_sub_items + `
															
															${data.id == domElements.salesRevenueId ? getSalesRevenueModal(false , null , data.id):''}
															${data.id == domElements.salesRevenueId ? getVatRate(false , null , data) : '' }
															${data.id == domElements.salesRevenueId ? getCollectionPolicyHtml(false,null,data.id):''}
															</div> ` + '' + `
														 `;

                                                        }

                                                        $(row).addClass('edit-info-row').addClass('add-sub maintable-1-row-class' + (data.id)).attr('data-model-id', data.id).attr('data-model-name', '<?php echo e($modelName); ?>')
                                                            .append(`
																								<div class="modal fade add-sub-item-modal" id="add-sub-modal${data.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
																			<div class="modal-dialog" role="document">
																				<div class="modal-content modal-xl">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Sub Item For')); ?> ${data.name} </h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																					</button>
																				</div>
																				<div class="modal-body">
																					<form  data-financial-statement-able-item-id="${data.id}" id="add-sub-item-form${data.id}" class="submit-sub-item" action="<?php echo e(route('admin.store.income.statement.report',['company'=>getCurrentCompanyId()])); ?>">
																						
																						<label class="label "><?php echo e(__('How Many Items ?')); ?></label>
																																	<input type="hidden" name="in_add_or_edit_modal" value="1">
																																					<input style="height:0;overflow:hidden;width:0;background-color:transparent;border:none;color:transparent;"   type="text" value="[]" id="new_items_names" name="new_items_names_in_popup"  >	

																						<input type="hidden" name="sub_item_type" value="<?php echo e(getReportNameFromRouteName(Request()->route()->getName())); ?>">
																						<input type="hidden" name="financial_statement_able_item_id"  value="${data.id}">
																						<input  type="hidden" name="financial_statement_able_id"  value="<?php echo e($incomeStatement->id); ?>">
																						<input  type="hidden" name="income_statement_id"  value="<?php echo e($incomeStatement->id); ?>">

																						<input data-id="${data.id}" class="form-control how-many-class only-greater-than-zero-allowed" name="how_many_items" type="number" value="1">
																					
																					${nameAndDepreciationIfExist}
																																		${data.id != domElements.salesRevenueId ? getVatRate(false , null , data) : '' }
																																		${data.id != domElements.salesRevenueId ? getNonRepeatingModal(false , null , data.id) : '' }
																																		
																					${getFinancialIncomeOrExpenseCheckBoxes(false ,null, data.id)}
																					${data.id != domElements.salesRevenueId ? getCollectionPolicyHtml(false,null,data.id) :'' }
																					</div>
																					</form>
																				</div>
																				<div class="modal-footer" style="border-top:0 !important">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
																					<button type="button" class="btn btn-primary save-sub-item" data-redirect-to='' data-id="${data.id}"><?php echo e(__('Save')); ?></button>
																				</div>
																				</div>
																			</div>
																				</div>

																								`)

                                                    }


                                                };
                                                $(cells).filter(".editable").attr('contenteditable', true);


                                                if (data.is_sales_rate || data.id == salesGrowthRateId) {
                                                    if (data.id != salesGrowthRateId) {
                                                        var subTotal = data.main_rows && data.main_rows[0] ? data.main_rows[0].pivot.total : 0
                                                        $(row).find('td.total-row').html(number_format(subTotal, 2) + ' %');
                                                        $(row).find('.input-hidden-for-total').val(subTotal)
                                                    } else {
                                                        $(row).find('td.total-row').html('-')

                                                    }
                                                } else {
                                                    var totals = array_sum(totalOfRowArray);

                                                    $(row).find('td.total-row').html(number_format(totals));
                                                    $(row).find('.input-hidden-for-total').val(totals)
                                                }

                                            }
                                            , drawCallback: function(settings) {

                                                getLastSubItemOfEachMainRow()
                                                const reportType = vars.subItemType;
                                                $('.editable-text').attr('contenteditable', false)


                                                let corporateTaxesId = document.getElementById('corporate-taxes-id').value;
                                                $('tr[data-percentage-or-fixed="percentage"] td.editable,tr[data-percentage-or-fixed="cost_of_unit"] td.editable').attr('contenteditable', false).attr('title', '');
                                                let options = '';
                                                document.querySelectorAll('.is-main-with-sub-items').forEach(function(row, index) {
                                                    let modelId = row.getAttribute('data-model-id');
                                                    var name = row.querySelector('.is-name-cell').innerHTML;
                                                    options += ` <option value="${modelId}"> ${name} </option> `
                                                })
                                                document.querySelectorAll('.main-row-select').forEach(function(mainRowSelect, index) {
                                                    var selectedRowId = mainRowSelect.getAttribute('data-selected-main-row');
                                                    var replace = `value="${selectedRowId}"`;
                                                    var replaceWith = `selected value="${selectedRowId}"`
                                                    options = options.replace(replace, replaceWith);
                                                    mainRowSelect.innerHTML = options;
                                                });
                                                document.querySelectorAll('.main-row-select[data-selected-main-row="' + corporateTaxesId + '"] option').forEach((option) => {
                                                    if (option.value != corporateTaxesId) {
                                                        option.remove();
                                                    }
                                                })

                                                var addBtnForCorporateTaxes = document.querySelector('.add-btn[data-income-statement-item-id="' + corporateTaxesId + '"]')
                                                var deleteBtnForCorporateTaxes = document.querySelector('.delete-btn[data-income-statement-item-id="' + corporateTaxesId + '"]')
                                                if (addBtnForCorporateTaxes) {
                                                    addBtnForCorporateTaxes.classList.add('d-none')
                                                    addBtnForCorporateTaxes.classList.remove('d-block')
                                                }
                                                if (deleteBtnForCorporateTaxes) {
                                                    deleteBtnForCorporateTaxes.classList.add('d-none')
                                                    deleteBtnForCorporateTaxes.classList.remove('d-block')
                                                }
                                                if (reportType != 'actual') {
                                                    const netProfitId = domElements.netProfitId;
                                                    const corporateTaxesPercentageValue = document.querySelector('.is-sub-row.maintable-1-row-class' + corporateTaxesId + ' td.editable-date') ? document.querySelector('.is-sub-row.maintable-1-row-class' + corporateTaxesId + ' td.editable-date').getAttribute('data-percentage-value') / 100 : 0;
                                                    const earningBeforeTaxesTotalValue = document.querySelector('.main-with-no-child[data-financial-statement-able-item-id="' + domElements.earningBeforeTaxesId + '"] input.input-hidden-for-total').value;
                                                    const totalCorporateTaxes = earningBeforeTaxesTotalValue < 0 ? 0 : earningBeforeTaxesTotalValue * corporateTaxesPercentageValue;
                                                    const corporateTaxesRow = document.querySelector('tr[data-model-id="' + corporateTaxesId + '"]')
                                                    const corporateTaxesSubRowRow = document.querySelector('tr.is-sub-row.maintable-1-row-class' + corporateTaxesId)
                                                    const salesRevenueId = domElements.salesRevenueId
                                                    const corporateTaxesSalesRateRow = document.querySelector('tr.is-sales-rate[data-financial-statement-able-item-id="' + sales_rate_maps[corporateTaxesId] + '"]')
                                                    const netProfitTaxesSalesRateRow = document.querySelector('tr.is-sales-rate[data-financial-statement-able-item-id="' + sales_rate_maps[netProfitId] + '"]')

                                                    const totalOfSalesRevenue = document.querySelector('.maintable-1-row-class' + salesRevenueId + ' .input-hidden-for-total').value;
                                                    const netProfitRow = document.querySelector('tr[data-model-id="' + netProfitId + '"]')
                                                    corporateTaxesRow.querySelector('td.total-row').innerHTML = number_format(totalCorporateTaxes)
                                                    corporateTaxesSubRowRow.querySelector('td.total-row').innerHTML = number_format(totalCorporateTaxes)
                                                    corporateTaxesRow.querySelector('input.input-hidden-for-total').value = totalCorporateTaxes
                                                    corporateTaxesSubRowRow.querySelector('input.input-hidden-for-total').value = totalCorporateTaxes
                                                    corporateTaxesSalesRateRow.querySelector('.total-row').innerHTML = number_format(totalOfSalesRevenue ? totalCorporateTaxes / totalOfSalesRevenue * 100 : 0, 2) + ' %'

                                                    const totalValueForNetProfit = earningBeforeTaxesTotalValue - totalCorporateTaxes;
                                                    netProfitRow.querySelector('td.total-row').innerHTML = number_format(totalValueForNetProfit)
                                                    netProfitRow.querySelector('input.input-hidden-for-total').value = totalValueForNetProfit
                                                    netProfitTaxesSalesRateRow.querySelector('.total-row').innerHTML = number_format(totalOfSalesRevenue ? totalValueForNetProfit / totalOfSalesRevenue * 100 : 0, 2) + ' %'
                                                }
                                                reinitializeSelect2();
                                                let actualDates = [];
                                                document.querySelectorAll('.is-actual-dates').forEach(function(th, index) {
                                                    if (!actualDates.includes($(th).data('date'))) {
                                                        actualDates.push($(th).data('date'));
                                                    }
                                                })

                                                if (reportType == 'actual') {
                                                    // if from forecast online
                                                    document.querySelectorAll('.is-name-cell[contenteditable]').forEach(function(td, index) {
                                                        td.setAttribute('contenteditable', false)
                                                        td.setAttribute('title', '')
                                                    });
                                                    document.querySelectorAll('th[data-is-actual="0"]').forEach((th) => {
                                                        var isActual = th.getAttribute('data-is-actual');
                                                        if (isActual) {
                                                            var currentThDate = th.getAttribute('data-date');
                                                            document.querySelectorAll('.editable-date.date-' + currentThDate).forEach((tdField) => {
                                                                tdField.removeAttribute('contenteditable')
                                                                tdField.removeAttribute('title');
                                                            })
                                                        }
                                                    })






                                                }

                                                if (reportType == 'adjusted') {



                                                    $('.main-table-class').DataTable().column(1).visible(false);
                                                    $('.kt-portlet__foot').css('display', 'none');
                                                    $('#store-report-form-id .kt-portlet').append(`<div class='single-btn'><button style="float:right" type="submit" class="btn active-style redirect-btn" data-redirect-to="<?php echo e(route('admin.view.financial.statement',getCurrentCompanyId())); ?>"> Back To Financial Statement </button></div>`);
                                                    document.querySelectorAll('[contenteditable]').forEach(function(td, index) {
                                                        td.setAttribute('contenteditable', false);
                                                        td.setAttribute('title', '')
                                                    })
                                                    actualDates.forEach(function(actualDate) {
                                                        document.querySelectorAll('.editable-date.date-' + actualDate).forEach(function(td, index) {
                                                            td.setAttribute('contenteditable', false);
                                                            td.setAttribute('title', '');
                                                        })
                                                    })
                                                }
                                                if (reportType == 'modified') {
                                                    const table = globalTable;
                                                    // table.column(1).visible(false);
                                                    document.querySelectorAll('.is-name-cell[contenteditable]').forEach(function(td, index) {
                                                        td.setAttribute('contenteditable', false);
                                                        td.setAttribute('title', '')
                                                    })
                                                    actualDates.forEach(function(actualDate) {
                                                        document.querySelectorAll('.editable-date.date-' + actualDate).forEach(function(td, index) {
                                                            td.setAttribute('contenteditable', false);
                                                            td.setAttribute('title', '')
                                                        })
                                                    })
                                                }

                                                $('.has-collection-policy-class:checked').trigger('change')
                                                $('.only-one-checked:checked').trigger('change')
                                                $('.collection_rate_input').trigger('change')
                                                $('input[name*="is_depreciation_or_amortization"]').trigger('change')





                                                // handle data for intervals 
                                            }
                                            , initComplete: function(settings, json) {
                                                table = $('.main-table-class').DataTable();
                                                globalTable = table;


                                                if (canRedrawWitdth) {
                                                    table.columns.adjust();

                                                }
                                                canRefreshPercentages = true;
                                            }



                                        }

                                    );
                                };

                            return {

                                //main function to initiate the module
                                init: function() {
                                    initTable1();

                                },

                            };

                        }();

                        jQuery(document).ready(function() {
                            KTDatatablesDataSourceAjaxServer.init();

                            function validatePercentage() {
                                let hasError = false
                                $('.how-many-item').each(function(index, howManyItemDiv) {
                                    var hasCollectionPolicy = $(howManyItemDiv).find('.has-collection-policy-class')[0]
                                    if (hasCollectionPolicy && hasCollectionPolicy.checked) {
                                        hasCollectionPolicy = true
                                    } else {
                                        hasCollectionPolicy = false
                                    }
                                    var customCollectionPolicy = $(howManyItemDiv).find('.only-one-checked:checked').val();
                                    var total = $(howManyItemDiv).find('.collection_rate_total_class').val();
                                    if (hasCollectionPolicy && customCollectionPolicy == 'customize' && total != '100.00 %') {
                                        hasError = true
                                        Swal.fire({
                                            text: 'Percentage Must Be 100 %'
                                            , icon: 'warning'
                                        })

                                    }
                                    return;

                                })
                                return hasError;


                            }
                            $(document).on('click', '.close-inner-modal', function() {

                                $('.modal-for-quantity').removeClass('d-block').modal('hide')
                                $('.modal-for-non-repeating').removeClass('d-block').modal('hide')
                            })
                            $(document).on('show.bs.modal', '.edit-sub-modal-class,.add-sub-item-modal', function() {
                                modalIsOpenInAddOrEdit = true
                            })
                            $(document).on('hide.bs.modal', '.edit-sub-modal-class,.add-sub-item-modal', function() {
                                modalIsOpenInAddOrEdit = false
                            })

                            $(document).on('show.bs.modal', '.delete-item-modal', function() {
                                let mainRowId = this.getAttribute('data-item-id')
                                let subItemName = this.getAttribute('data-sub-name')
                                deleteModalIsOpen = true
                                currentDelete = {
                                    id: mainRowId
                                    , subName: subItemName
                                }
                            })
                            $(document).on('hide.bs.modal', '.delete-item-modal', function() {
                                currentDelete = {}
                                deleteModalIsOpen = false
                            })

                            $(document).on('click', '.save-sub-item', function(e) {

                                // valiation
								

                                let hasError = validatePercentage()
                                if (hasError) {
                                    return;
                                }

                                $(this).prop('disabled', true)
                                if (!canSendAjaxRequest) {
                                    return;
                                }
                                canSendAjaxRequest = false;
                                const salesRevenueId = domElements.salesRevenueId
                                const financeIncomeOrExpensesId = domElements.financialIncomeOrExpensesId
                                const salesAndDistributionExpensesId = domElements.salesAndDistributionExpensesId
                                const marketExpensesId = domElements.marketExpensesId
                                const generalExpensesId = domElements.generalExpensesId
                                const salesRevenueSubItem = window['sales_revenues_sub_items_names'].length ? window['sales_revenues_sub_items_names'][0] : null
                                const costOfGoodsId = domElements.costOfGoodsId
                                const costOfGoodsSubItem = window['cost_of_goods_sub_items_names'].length ? window['cost_of_goods_sub_items_names'][0] : null
                                let submitBtn = $(this);

                                e.preventDefault();
                                inAddOrEditModal = true;
                                let id = $(this).data('id');
                                let form = document.getElementById('add-sub-item-form' + id);
                                var formData = new FormData(form)


                                var formDataObject = {};
                                formData.forEach((value, key) => {
                                    if (!Reflect.has(formDataObject, key)) {
                                        formDataObject[key] = value;
                                        return;
                                    }
                                    if (!Array.isArray(formDataObject[key])) {
                                        formDataObject[key] = [formDataObject[key]];
                                    }
                                    formDataObject[key].push(value);
                                });


                                let formattedTable = formateTableForNewRow(formDataObject);

                                // save data form also 
                                if (formattedTable) {
                                    var updateCurrentRow = false;
                                    var updateRowId = id == costOfGoodsId ? costOfGoodsId : salesRevenueId
                                    var updateSubItem = id == costOfGoodsId ? costOfGoodsSubItem : salesRevenueSubItem

                                    if (id == costOfGoodsId && !costOfGoodsSubItem) {
                                        updateCurrentRow = true;
                                    }
                                    if (id == salesRevenueId && !salesRevenueSubItem) {
                                        updateCurrentRow = true;
                                    }
                                    if (id == financeIncomeOrExpensesId) {
                                        updateCurrentRow = true;
                                    }
                                    if (id == financeIncomeOrExpensesId) {
                                        updateCurrentRow = true;
                                    }
                                    if (id == financeIncomeOrExpensesId || id == marketExpensesId || id == generalExpensesId || id == salesAndDistributionExpensesId) {
                                        updateCurrentRow = true;
                                    }
                                    for (date of dates) {
                                        // do not update anything if you add sales renuve sub item because it will be 0 anyway
                                        if (id != salesRevenueId) {
                                            inAddOrEditModal = false
                                            var updateElement = updateCurrentRow ? triggerBlurForEditableTd(date) : document.querySelector('.maintable-1-row-class' + updateRowId + '[data-sub-item-name="' + updateSubItem + '"] td.date-' + date)
                                            if (updateElement) {
                                                // updateElement.dispatchEvent(new Event('blur', {
                                                //     'bubbles': true
                                                // }))
                                            }
                                        }

                                    }
                                    dataForm = document.getElementById('store-report-form-id');
                                    dataForm = new FormData(dataForm);
                                    for (var pair of formData.entries()) {
                                        dataForm.append(pair[0], pair[1]);
                                    }
								
									 dataForm.append('new_added_elements',$('#new_items_names').val());
							
                                    $('.append-table-into-dom').remove();
												
											
                                    $.ajax({
                                        type: 'POST'
                                        , url: $(form).attr('action')
                                        , data: dataForm
                                        , cache: false
                                        , contentType: false
                                        , processData: false
                                        , success: function(res) {
                                            submitBtn.attr('disabled', false);
                                            canSendAjaxRequest = true;
                                            window.location.reload()
                                            if (res.status) {
                                                Swal.fire({
                                                    icon: 'success'
                                                    , title: res.message,
													  showConfirmButton: false,
													timer: 2000
                                                , })
                                            } else {
                                                submitBtn.attr('disabled', false);
                                                Swal.fire({
                                                    icon: 'error'
                                                    , title: res.message
                                                    , text: 'حدث خطا اثناء تنفيذ العملية'
                                                })
                                            }
                                        }
                                        , error: function(res) {
                                            submitBtn.attr('disabled', false);
                                            canSendAjaxRequest = true;
                                            let message = '';
                                            if (res.responseJSON && res.responseJSON.message) {
                                                message = res.responseJSON.message;
                                                if (res.responseJSON.errors) {
                                                    var err = res.responseJSON.errors;
                                                    message = err[Object.keys(err)[0]][0];
                                                }
                                            } else if (res.statusText) {
                                                message = res.statusText;
                                            }
											if(message.includes('CSRF')){
												message = "<?php echo e(__('Your Session Expired .. Please Reload The Page And Try Again')); ?>"
											}
                                            Swal.fire({
                                                icon: 'error'
                                                , title: "<?php echo e(__('Something Went Wrong')); ?>"
                                                , text: message,
												  showConfirmButton: false,
												timer: 2000
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        }
                                    });
                                }
                                //submitBtn.attr('disabled', false);

                                $('.append-table-into-dom').remove();

                                inAddOrEditModal = false;
                            });



                            $(document).on('click', '.save-sub-item-edit', function(e) {
                                var hasCollectionPolicy = $(this).closest('.modal-content').find('.has-collection-policy-class')[0]
                                //var hasCollectionPolicy = $(howManyItemDiv).find('.has-collection-policy-class')[0]
                                if (hasCollectionPolicy && hasCollectionPolicy.checked) {
                                    hasCollectionPolicy = true
                                } else {
                                    hasCollectionPolicy = false
                                }
                                var customCollectionPolicy = $(this).closest('.modal-content').find('.only-one-checked:checked').val();
                                var isFinancialExpense = $(this).closest('.modal-content').find('.is-financial-expense-class:checked').val();
                                var total = $(this).closest('.modal-content').find('.collection_rate_total_class').val();
                                if (hasCollectionPolicy && customCollectionPolicy == 'customize' && total != '100.00 %') {
                                    Swal.fire({
                                        text: 'Percentage Must Be 100 %'
                                        , icon: 'warning'
                                    })
                                    return

                                }

                                e.preventDefault();
                                inAddOrEditModal = true;
                                inEditMode = true
                                const btn = $(this);
                                btn.prop('disabled', true);
                                let id = $(this).data('id');
                                let subItemName = $(this).data('sub-item-name');
                                let form = document.getElementById('edit-sub-item-form' + id + convertStringToClass(subItemName));
                                var formData = new FormData(form);

                                var formDataObject = {};
                                formData.forEach((value, key) => {
                                    if (!Reflect.has(formDataObject, key)) {
                                        formDataObject[key] = value;
                                        return;
                                    }
                                    if (!Array.isArray(formDataObject[key])) {
                                        formDataObject[key] = [formDataObject[key]];
                                    }
                                    formDataObject[key].push(value);
                                });
                                if (formDataObject['sub_items[0][can_be_percentage_or_fixed]']) {
                                    var incomeStatementId = formDataObject['financial_statement_able_id'];
                                    var incomeStatementItemId = formDataObject['financial_statement_able_item_id'];
                                    var oldSubItemName = formDataObject['sub_item_name'];
                                    var percentage_or_fixed = formDataObject['sub_items[0][percentage_or_fixed]'];
                                    var is_percentage = percentage_or_fixed == 'percentage';
                                    var is_cost_of_unit = percentage_or_fixed == 'cost_of_unit';
                                    var is_non_repeating_fixed = percentage_or_fixed == 'non_repeating_fixed';
                                    var is_repeating_fixed = percentage_or_fixed == 'repeating_fixed';
                                    var is_percentage_of = is_percentage ? "[" + formDataObject['sub_items[0][is_percentage_of][]'].toString() + "]" : '';
                                    var is_cost_of_unit_of = is_cost_of_unit ? "[" + formDataObject['sub_items[0][is_cost_of_unit_of][]'].toString() + "]" : '';

                                    var percentage_value = is_percentage ? formDataObject['sub_items[0][percentage_value]'] : 0;
                                    var cost_of_unit_value = is_cost_of_unit ? formDataObject['sub_items[0][cost_of_unit_value]'] : 0;
                                    var repeating_value = is_repeating_fixed ? formDataObject['sub_items[0][repeating_fixed_value]'] : 0;
                                    var tdValue = 0;
                                    if (is_non_repeating_fixed) {
                                        tdValue = 0
                                    } else if (is_percentage) {
                                        tdValue = percentage_value;
                                    } else if (is_repeating_fixed) {
                                        tdValue = repeating_value;
                                    } else if (is_cost_of_unit) {
                                        tdValue = cost_of_unit_value;
                                    }

                                    $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"]').attr('data-is-financial-expense', isFinancialExpense == 1 ? 1 : 0).attr('data-percentage-value', is_percentage ? tdValue : 0).attr('data-cost-of-unit-value', is_cost_of_unit ? tdValue : 0).attr('data-financial-statement-able-item-id', incomeStatementItemId).attr('data-is-percentage-of', is_percentage_of).attr('data-is-cost-of-unit-of', is_cost_of_unit_of).attr('data-percentage-or-fixed', percentage_or_fixed).attr('data-is-percentage', is_percentage).attr('data-is-cost-of-unit', is_cost_of_unit).attr('data-is-repeating-fixed', is_repeating_fixed).attr('data-is-none-repeating-fixed', is_non_repeating_fixed).attr('data-is-trigger-change', 'true');
                                    if (vars.subItemType == 'modified') {
                                        var firstDateForecast = getFirstDataForecast()
                                        if (firstDateForecast) {
                                            $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"] td.editable-date.date-' + firstDateForecast).attr('data-is-financial-expense', isFinancialExpense == 1 ? 1 : 0).html(number_format(tdValue)).trigger('blur')
											;
                                        }
                                    } else {
                                        if (is_non_repeating_fixed) {
                                            dates.forEach(function(date) {
                                                tdValue = formDataObject['sub_items[0][non_repeating_popup][' + date + ']'];
												if(isFinancialExpense && tdValue > 0){
													tdValue = tdValue  * -1 ;
												}
                                                $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"] td.editable-date.date-'+date).html(number_format(tdValue))
												$('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"] td.editable-date.date-'+date).parent().find('input[type="hidden"][data-date="'+date+'"]').val((tdValue))
												//.trigger('blur')
												;

                                            })

                                        } else {
                                            $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"] td.editable-date:eq(0)').html(number_format(tdValue)).trigger('blur');

                                        }

                                    }
                                }
                                // refresh formdata object 
                                formData = document.getElementById('edit-sub-item-form' + id + convertStringToClass(subItemName))
                                formData = new FormData(formData);
                                // submit main table inputs 

                                dataForm = document.getElementById('store-report-form-id');
                                dataForm = new FormData(dataForm);
                                for (var pair of formData.entries()) {
                                    dataForm.append(pair[0], pair[1]);
                                }
                                $.ajax({
                                    type: 'POST'
                                    , url: $(form).attr('action')
                                    , data: dataForm
                                    , cache: false
                                    , contentType: false
                                    , processData: false
                                    , success: function(res) {
                                        window.location.reload()
                                        if (res.status) {

                                            Swal.fire({
                                                icon: 'success'
                                                , title: res.message,
												  showConfirmButton: false,
												timer: 2000
                                                // text: 'تمت العملية بنجاح',
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
												
                                                , text: 'حدث خطا اثناء تنفيذ العملية',
												  showConfirmButton: false,
												timer: 2000
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        }
                                    }
                                    , error: function(data) {
                                        // $(this).prop('disabled',false);

                                    }
                                });

                                inAddOrEditModal = false;
                                inEditMode = false
                            });




                            $(document).on('click', '.save-sub-item-delete', function(e) {
                                e.preventDefault();
                                let id = $(this).data('id');
                                let subItemName = $(this).data('sub-item-name');
                                $(this).prop('disabled', true);
                                // edit-info-row add-sub maintable-1-row-class1 is-sub-row even
                                if (id == domElements.salesRevenueId) {
                                    let subItemWithoutQuantity = getSubItemsFromString(subItemName)
                                    let subItemWithQuantity = subItemWithoutQuantity + "<?php echo e(__(quantityIdentifier)); ?>"
                                    for (subName of [subItemWithoutQuantity, subItemWithQuantity]) {
                                        document.querySelectorAll('tr.maintable-1-row-class' + id + '[data-sub-item-name="' + subName + '"] td.editable-date').forEach((editableDateTd) => {
                                            editableDateTd.innerHTML = 0
                                            editableDateTd.setAttribute('data-percentage-value', 0)
                                            editableDateTd.setAttribute('data-cost-of-unit-value', 0)
                                        })
                                        document.querySelectorAll('tr.maintable-1-row-class' + id + '[data-sub-item-name="' + subName + '"] input[data-date]').forEach((editableDateInput) => {
                                            editableDateInput.value = 0
                                            //editableDateInput.dispatchEvent(new Event('change', {
                                            //    'bubbles': true
                                            //}));
                                        })
                                    }

                                } else {
                                    document.querySelectorAll('tr.maintable-1-row-class' + id + '[data-sub-item-name="' + subItemName + '"] td.editable-date').forEach((editableDateTd) => {
                                        editableDateTd.innerHTML = 0
                                        editableDateTd.setAttribute('data-percentage-value', 0)
                                        editableDateTd.setAttribute('data-cost-of-unit-value', 0)
                                        //editableDateTd.dispatchEvent(new Event('blur'));
                                    })
                                }


                                let form = document.getElementById('delete-sub-item-form' + id + convertStringToClass(subItemName));

                                var formData = new FormData(form);

                                dataForm = document.getElementById('store-report-form-id');
                                dataForm = new FormData(dataForm);
                                for (var pair of formData.entries()) {
                                    dataForm.append(pair[0], pair[1]);
                                }
                                $.ajax({
                                    type: 'POST'
                                    , url: $(form).attr('action')
                                    , data: dataForm
                                    , cache: false
                                    , contentType: false
                                    , processData: false
                                    , success: function(res) {
                                        $(this).prop('disabled', false);

                                        window.location.reload()
                                        if (res.status) {

                                            Swal.fire({
                                                icon: 'success'
												
                                                , title: res.message,
												  showConfirmButton: false,
												timer: 2000
                                                // text: 'تمت العملية بنجاح',
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
                                                , text: 'حدث خطا اثناء تنفيذ العملية',
												  showConfirmButton: false,
												timer: 2000

                                            })
                                        }
                                    }
                                    , error: function(data) {
                                        $(this).prop('disabled', false);

                                    }
                                });
                            });




                       //     $(document).on('change', '.main-with-no-child input', function(e) {
//
                       //         let rowId = this.getAttribute('data-parent-model-id');
                       //         const currentRow = this.closest('tr')
                       //         let grossProfitId = domElements.growthProfitId;
                       //         let earningBeforeInterestTaxesDepreciationAmortizationId = domElements.earningBeforeInterestTaxesDepreciationAmor;
                       //         let earningBeforeInterestTaxesId = domElements.earningBeforeInterestTaxesId;
                       //         let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                       //         let date = this.getAttribute('data-date');
//
                       //         if (rowId == grossProfitId) {
                       //             updateEarningBeforeIntersetTaxesDepreciationAmortization(date);
                       //             updateTotalForRow(currentRow);
                       //             updatePercentageOfSalesFor(rowId, date);
//
                       //         } else if (rowId == earningBeforeInterestTaxesId) {
                       //             updateEarningBeforeTaxes(date);
                       //             updateTotalForRow(currentRow);
//
                       //             updatePercentageOfSalesFor(rowId, date);
                       //         } else if (rowId == earningBeforeTaxesId) {
                       //             updateNetProfit(date);
                       //             updateTotalForRow(currentRow);
//
                       //             updatePercentageOfSalesFor(rowId, date);
//
                       //         }
//
                       //     });



                            $(document).on('click', '.save-form', function(e) {
                                e.preventDefault();
                                form = document.getElementById('store-report-form-id');
                                let redirectTo = this.getAttribute('data-redirect-to');
                                var formData = new FormData(form);

                                $.ajax({
                                    type: 'POST'
                                    , url: $(form).attr('action')
                                    , data: formData
                                    , cache: false
                                    , contentType: false
                                    , processData: false
                                    , success: function(res) {
                                        window.location.reload()
                                        if (res.status) {
                                            if (redirectTo) {
                                                window.location.href = redirectTo;
                                            }
                                            Swal.fire({
                                                icon: 'success'
                                                , title: res.message
                                                , text: 'تمت العملية بنجاح',
												  showConfirmButton: false,
												timer: 2000
                                            , }).then(function() {

                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
                                                , text: 'حدث خطا اثناء تنفيذ العملية',
												  showConfirmButton: false,
												timer: 2000
                                            , })
                                        }
                                    }
                                    , error: function(data) {}
                                });

                            })


                            $(document).on('keyup', '.how-many-class', function() {
                                let index = parseInt(this.getAttribute('data-id'));
                                let currentHowMany = parseInt(document.querySelector('.how-many-class[data-id="' + index + '"]').value);
                                let currentHowManyInstances = $('.how-many-item[data-id="' + index + '"]').length;
                                let financialStatementAbleItemId = this.closest('form').getAttribute('data-financial_statement_able_item_id')
                                if (currentHowMany < 1) {
                                    currentHowMany = 1;
                                }
                                if (currentHowManyInstances == currentHowMany) {
                                    return;
                                }
                                if (currentHowManyInstances >= currentHowMany) {
                                    document.querySelectorAll('.how-many-item[data-id="' + index + '"]').forEach(function(val, index) {
                                        var order = index + 1;
                                        if (order > currentHowMany) {
                                            $(val).remove();
                                        }
                                    })
                                } else {
                                    let numberOfNewInstances = currentHowMany - currentHowManyInstances;
                                    for (i = 0; i < numberOfNewInstances; i++) {
                                        var lastInstanceClone = $('.how-many-item[data-id="' + index + '"]:last-of-type').clone(true);
                                        var lastItemIndex = parseInt($('.how-many-item[data-id="' + index + '"]:last-of-type').attr('data-index'));
                                        $(lastInstanceClone).attr('data-index', lastItemIndex + 1);
                                        $(lastInstanceClone).find('.modal-for-quantity').attr('id', 'modal-for-quantity-' + (lastItemIndex + 1))
                                        $(lastInstanceClone).find('.add-sub-item-modal').attr('id', 'add-sub-modal' + (lastItemIndex + 1))
                                        $(lastInstanceClone).find('[data-index]').each(function(loopIndex, dataIndexElement) {
                                            var loopCurrentIndex = $(dataIndexElement).attr('data-index');
                                            if (isNumeric(loopCurrentIndex)) {

                                                $(dataIndexElement).attr('data-index', lastItemIndex + 1)
                                            }
                                        })
                                        lastInstanceClone.find('input,select').each(function(i, v) {
                                            if ($(v).attr('type') == 'text') {
                                                $(v).val('');
                                            }
                                            if (v.tagName.toLowerCase() == 'select') {
                                                var name = $(v).attr('name').replace(lastItemIndex, lastItemIndex + 1);
                                                var sub_items_options = '';
                                                var sub_items_quantity_options = '';

                                                let corporateTaxesId = $('#corporate-taxes-id').val();

                                                if (financialStatementAbleItemId == corporateTaxesId) {
                                                    sub_items_options += '<option value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'
                                                } else {
                                                    window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                        sub_items_options += '<option value="' + MainItemObject.id.toString() + '">' + MainItemObject.name + '</option>'
                                                    })

                                                    window['sales_revenues_quantity_sub_items_names'].forEach(function(MainItemObject) {
                                                        sub_items_quantity_options += '<option value="' + MainItemObject.id.toString() + '">' + MainItemObject.name + '</option>'
                                                    })

                                                }

                                                if (v.closest('.dropdown.bootstrap-select')) {
                                                    v.closest('.dropdown.bootstrap-select').outerHTML = `<select  multiple name="${name}" class="select select2-select2 ${name}"> ${name.includes('is_cost_of_unit_of') ? sub_items_quantity_options :sub_items_options} </select>`
                                                } else {
                                                    if ($(v).attr('name')) {
                                                        $(v).attr('name', $(v).attr('name').replace(lastItemIndex, lastItemIndex + 1));
                                                    }


                                                }

                                            } else {
                                                if ($(v).attr('name')) {
                                                    $(v).attr('name', $(v).attr('name').replace(lastItemIndex, lastItemIndex + 1));

                                                }
                                            }
                                        })
                                        $('.append-names[data-id="' + index + '"]').append(lastInstanceClone);
                                        reinitializeSelect2();

                                    }
                                }
                            });

                        });


                    })(jQuery);

                });

                function getSearchInputSelector(tableId) {
                    return tableId + '_filter' + ' label input';
                }

                function getLastPercentageOfSalesOrCostOfUnitNameOf(mainRowId) {
                    let name = {
                        percentage: null
                        , costOfUnit: null
                    };
                    $('.is-sub-row.maintable-1-row-class' + mainRowId).each(function(index, subRow) {
                        var isPercentage = subRow.getAttribute('data-is-percentage') && subRow.getAttribute('data-is-percentage') != 'false'
                        var isCostOfUnit = subRow.getAttribute('data-is-cost-of-unit') && subRow.getAttribute('data-is-cost-of-unit') != 'false'
                        var subItemName = subRow.getAttribute('data-sub-item-name')
                        if (isPercentage) {
                            name['percentage'] = subItemName;
                        }
                        if (isCostOfUnit) {
                            name['costOfUnit'] = subItemName;
                        }
                    })
                    return name;
                }

                function getLastSubItemOfEachMainRow() {
                    lastPercentageSubItemOfEachMainRow = {}
                    lastCostOfUnitSubItemOfEachMainRow = {}
                    $('.is-main-with-sub-items').each(function(index, mainRow) {
                        var mainRowId = mainRow.getAttribute('data-financial-statement-able-item-id')
                        var lastSubItems = getLastPercentageOfSalesOrCostOfUnitNameOf(mainRowId)
                        lastPercentageSubItemOfEachMainRow[mainRowId] = lastSubItems.percentage
                        lastCostOfUnitSubItemOfEachMainRow[mainRowId] = lastSubItems.costOfUnit
                    })
                }


                function isInEditMode() {
                    return inEditMode;
                }


                function isActualDate(date) {
                    return !!document.querySelector('th[data-date="' + date + '"][data-is-actual="1"]')
                }

                function getFirstDataForecast() {
                    return $('th[data-is-actual="0"]:eq(0)').attr('data-date')
                }

                function updateAllMainsRowPercentageOfSales(dates = null) {
                    if (!dates) {
                        dates = "<?php echo e(json_encode(array_keys($incomeStatement->getIntervalFormatted()))); ?>";
                        dates = dates.replace(/(&quot\;)/g, "\"")
                        dates = JSON.parse(dates);
                    }
                    document.querySelectorAll('.is-main-with-sub-items').forEach(function(val) {
                        var mainRowId = val.getAttribute('data-model-id');
                        dates = Array.isArray(dates) ? dates : JSON.parse(dates);
                        for (date of dates) {

                            updatePercentageOfSalesFor(mainRowId, date, false);
                        }
                    })
                }


                function updatePercentageOfSalesFor(rowId, date, mainRowIsSub = true) {
                    let salesRevenueId = domElements.salesRevenueId;
                    let rateMainRowId = sales_rate_maps[rowId];
                    let mainRowValue = 0;
                    let salesRevenueValue = 0;
                    var mainRow = '';

                    if (mainRowIsSub) {

                        mainRow = document.querySelector('.main-with-no-child[data-model-id="' + rowId + '"]');

                        if (mainRow) {

                            mainRowValue = parseFloat(mainRow.querySelector('input[data-date="' + date + '"]').value);
                            salesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] input[data-date="' + date + '"]').value);

                        }
                    } else {
                        mainRow = document.querySelector('.is-main-with-sub-items[data-model-id="' + rowId + '"]')
                        if (date) {
                            mainRowValue = parseFloat(mainRow.querySelector('input[data-date="' + date + '"]').value);
                            salesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] input[data-date="' + date + '"]').value);

                        }

                    }
                    let salesPercentage = salesRevenueValue ? mainRowValue / salesRevenueValue * 100 : 0;
                    var input = document.querySelector('.main-with-no-child.is-sales-rate[data-model-id="' + rateMainRowId + '"] input[data-date="' + date + '"]');

                    if (input) {
                        input.value = salesPercentage;
                    }
                    var element = document.querySelector('.main-with-no-child.is-sales-rate[data-model-id="' + rateMainRowId + '"] ' + 'td.date-' + date);
                    if (element) {
                        element.innerHTML = number_format(salesPercentage, 2) + ' %';
                    }
                    totalPercentage = mainRow ? mainRow.querySelector('.input-hidden-for-total').value : 0;
                    if (totalPercentage) {
                        totalPercentage = parseFloat((totalPercentage));
                        totalSalesRevenue = parseFloat(number_unformat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] .total-row').innerHTML));

                        if (totalPercentage && totalSalesRevenue) {

                            var element = document.querySelector('.main-with-no-child[data-model-id="' + rateMainRowId + '"] .input-hidden-for-total');
                            if (element) {
                                element.value = (totalPercentage / totalSalesRevenue * 100)
                            }
                            var element = document.querySelector('.main-with-no-child[data-model-id="' + rateMainRowId + '"] .total-row');

                            if (element) {
                                element.innerHTML = (number_format(totalPercentage / totalSalesRevenue * 100, 2) + ' %');
                            }


                        }

                    }

                }

                function formatDatesForInterval(intervalName) {

                    var table = globalTable;
                    const noCols = $('#cols-counter').data('value');
                    globalTable.columns([...Array(noCols).keys()], false).visible(true);



                    const firstDateColumn = $('td.editable-date').eq(0);
                    salesGrowthRateId = domElements.salesGrowthRateId;
                    salesRevenueId = domElements.salesRevenueId;
                    var visiableHeaderDates = [];
                    const allYears = getYearsFromDates(dates);
                    const firstDateColumnIndex = $(firstDateColumn).index();

                    let firstDateString = $(firstDateColumn).attr("class").split(/\s+/).filter(function(classItem) {
                        return classItem.startsWith('date-');
                    })[0];
                    var firstDate = firstDateString.split('date-')[1];
                    var year = firstDate.split('-')[0];
                    var month = firstDate.split('-')[1];
                    var day = firstDate.split('-')[2];

                    let hideColumnsFromMonthMapping = {
                        monthly: {
                            12: []
                            , 11: []
                            , 10: []
                            , "09": []
                            , "08": []
                            , "07": []
                            , "06": []
                            , "05": []
                            , "04": []
                            , "03": []
                            , "02": []
                            , "01": []
                        }
                        , quarterly: {
                            12: ["11", "10"]
                            , 11: ["10"]
                            , 10: []
                            , "09": ["08", "07"]
                            , "08": ["07"]
                            , "07": []
                            , "06": ["05", "04"]
                            , "05": ["04"]
                            , "04": []
                            , "03": ["02", "01"]
                            , "02": ["01"]
                            , "01": []
                        }
                        , "semi-annually": {
                            12: ["11", "10", "09", "08", "07"]
                            , 11: ["10", "09", "08", "07"]
                            , 10: ["09", "08", "07"]
                            , "09": ["08", "07"]
                            , "08": ["07"]
                            , "07": []
                            , "06": ["05", "04", "03", "02", "01"]
                            , "05": ["04", "03", "02", "01"]
                            , "04": ["03", "02", "01"]
                            , "03": ["02", "01"]
                            , "02": ["01"]
                            , "01": []
                        , }
                        , "annually": {
                            12: ["11", "10", "09", "08", "07", "06", "05", "04", "03", "02", "01"]
                            , 11: ["10", "09", "08", "07", "06", "05", "04", "03", "02", "01"]
                            , 10: ["09", "08", "07", "06", "05", "04", "03", "02", "01"]
                            , "09": ["08", "07", "06", "05", "04", "03", "02", "01"]
                            , "08": ["07", "06", "05", "04", "03", "02", "01"]
                            , "07": ["06", "05", "04", "03", "02", "01"]
                            , "06": ["05", "04", "03", "02", "01"]
                            , "05": ["04", "03", "02", "01"]
                            , "04": ["03", "02", "01"]
                            , "03": ["02", "01"]
                            , "02": ["01"]
                            , "01": []
                        , }
                    };

                    if ($('#income-statement-duration-type').val() != intervalName) {
                        $('.add-btn , .edit-btn , .delete-btn').removeClass('d-block').addClass('d-none')
                    } else {

                        if (intervalName == 'monthly') {
                            $('.add-btn , .edit-btn , .delete-btn').addClass('d-block').removeClass('d-none')
                            $('input[type="hidden"][data-date]').each(function(index, inputHidden) {

                                let date = $(inputHidden).data('date');
                                var parentRow = $(this).parent();
                                if (parentRow.hasClass('is-sales-rate') || parentRow.data('model-id') == salesGrowthRateId) {
                                    parentRow.find('td.date-' + date).html(number_format($(inputHidden).val(), 2) + ' %');
                                } else {
                                    parentRow.find('td.date-' + date).html(number_format($(inputHidden).val()));

                                }
                            })

                            return;
                        }

                        $('.add-btn , .edit-btn , .delete-btn').addClass('d-block').removeClass('d-none')
                    }



                    let totalOfVisisableDates = [];
                    let hiddenMonths = [];

                    let hiddenColumnsAtInterval = hideColumnsFromMonthMapping[intervalName];
                    let monthsKeys = orderObjectKeys(hiddenColumnsAtInterval);

                    additionalColumnsToHide = [];


                    for (loopMonth of monthsKeys) {




                        let loopMonths = hideColumnsFromMonthMapping[intervalName][loopMonth];

                        var currentYear = date.split('-')[0];
                        var currentMonth = date.split('-')[1];
                        var currentDay = date.split('-')[2];
                        allYears.sort().reverse();


                        // hide columns 
                        for (loopYear of allYears) {
                            for (removeMonth of loopMonths) {

                                if (!hiddenMonths.includes(loopYear + '-' + removeMonth)) {

                                    if ($('td.date-' + loopYear + '-' + loopMonth + '-' + currentDay).length) {



                                        if (!visiableHeaderDates.includes(loopYear + '-' + loopMonth + '-' + currentDay)) {
                                            visiableHeaderDates.push(loopYear + '-' + loopMonth + '-' + currentDay);
                                        }
                                        var tBody = $('tbody tr[class]:not(.header-tr)')
                                        var tBodyLength = tBody.length
                                        for (rowId = 1; rowId <= tBodyLength; rowId++) {
                                            currentRow = $(tBody[rowId - 1])
                                            var searchRowValue = null;
                                            if (totalOfVisisableDates[rowId] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value']) {
                                                searchRowValue = totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value'];
                                            }

                                            if (searchRowValue != null) {
                                                var val = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                val = val ? val : 0;
                                                totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value'] += val;

                                            } else {

                                                // old problem
                                                var val = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                val = val ? val : 0;

                                                if (totalOfVisisableDates[rowId] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]) {

                                                    totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] = {
                                                        value: val
                                                    }

                                                } else {
                                                    var val = 0;
                                                    // for first time
                                                    if (!totalOfVisisableDates[rowId]) {


                                                        var val1 = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + loopMonth + '-' + currentDay + '"]').val());
                                                        val1 = val1 ? val1 : 0;

                                                        var val2 = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                        val2 = val2 ? val2 : 0;

                                                        val = val1 + val2;




                                                        totalOfVisisableDates[rowId] = {
                                                            [loopYear + '-' + loopMonth + '-' + currentDay]: {
                                                                value: val
                                                            }
                                                        }




                                                    } else {
                                                        // not here
                                                        var val1 = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + loopMonth + '-' + currentDay + '"]').val());
                                                        val1 = val1 ? val1 : 0;
                                                        var val2 = parseFloat($('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                        val2 = val2 ? val2 : 0;

                                                        val = val1 + val2;



                                                        totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] = {
                                                            value: val
                                                        }

                                                    }




                                                }

                                            }

                                            if (currentRow.hasClass('is-sales-rate')) {

                                                // do nothing
                                            } else {
                                                $('tbody tr[class]:not(.header-tr):nth-of-type(' + rowId + ')').find('td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).html(number_format(totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value']));
                                            }
                                        }
                                        hiddenMonths.push(loopYear + '-' + removeMonth);




                                    }




                                }

                            }

                        }

                    }
                    var hiddenIndexes = [];
                    for (hiddenMonth of hiddenMonths) {
                        $('th[data-month-year="' + hiddenMonth + '"]').each(function(i, m) {
                            hiddenIndexes.push($(m).index());
                        })

                    }
                    table.columns(hiddenIndexes).visible(false)

                    updateSalesGrowthRate(visiableHeaderDates.sort());
                    updatePercentageRows(visiableHeaderDates);


                };

            </script>

            <script>
                function updatePercentageRows(visiableHeaderDates) {
                    var percentage = 0;
                    const salesRevenueId = domElements.salesRevenueId;
                    $('tr.is-sales-rate').each(function(index, isSalesRow) {

                        for (visiableHeaderDate of visiableHeaderDates) {



                            var currentRowId = $(isSalesRow).data('model-id');
                            var parentId = getKeyByValue(sales_rate_maps, currentRowId);

                            let parentRowValAtDate = parseFloat(number_unformat($('tbody tr[data-model-id="' + parentId + '"]').find('td.date-' + visiableHeaderDate).html()));
                            let salesRevenueAtDate = parseFloat(number_unformat($('tbody tr[data-model-id="' + salesRevenueId + '"]').find('td.date-' + visiableHeaderDate).html()));
                            if (salesRevenueAtDate) {
                                percentage = parentRowValAtDate / salesRevenueAtDate * 100
                            }

                            var number_formatted = number_format(percentage, 2) + ' %';
                            $('tbody tr[data-model-id="' + currentRowId + '"]').find('td.editable-date.date-' + visiableHeaderDate).html(number_formatted);

                        }



                    })

                }

                function getFinancialIncomeOrExpenseCheckBoxes(editMode, pivot, id) {
                    if (id != domElements.financialIncomeOrExpensesId) {
                        return '';
                    }
                    const isExpense = editMode && pivot.is_financial_expense
                    return `
					<div class="financial-income-or-expense-id only-one-checkbox-parent d-flex mb-2 ${editMode ?'mt-3':''}">
					<div class="d-flex flex-column align-items-center justify-content-center flex-wrap mr-5 ">
					<label ><?php echo e(__('Income')); ?></label>
					<input ${!isExpense ? 'checked' : ''} class="only-one-checkbox"   type="checkbox" value="1" name="sub_items[0][is_financial_income]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
					</div>
					
					<div class="d-flex flex-column align-items-center justify-content-center flex-wrap ">
							<label ><?php echo e(__('Expense')); ?></label>
					<input ${isExpense ? 'checked':''} class="is-financial-expense-class only-one-checkbox" type="checkbox" value="1" name="sub_items[0][is_financial_expense]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
					</div>
					</div>
					
					`;
                }

                function getVatRate(editModel, pivot, data) {
                    if (vars.subItemType != 'forecast') {
                        return '';
                    }

                    var incomeStatementId = data.isSubItem ? data.pivot.financial_statement_able_id : $('#model-id').val();
                    var incomeStatementItemId = data.isSubItem ? data.pivot.financial_statement_able_item_id : data.id;
                    var oldVatRate = editModel && pivot.vat_rate ? pivot.vat_rate : 0;
                    var isDeductable = editModel ? pivot.is_deductible : 0
                    isDeductable = +isDeductable;
                    let hasVatRate = vatRateMaps[incomeStatementItemId].has_vat_rate;

                    let canBeDeductable = vatRateMaps[incomeStatementItemId].can_be_dedictiable;

                    var deductableCheckbox = canBeDeductable ? `<label for="dedictiable-for-${incomeStatementId}-element2-${incomeStatementItemId}" class="label" style="margin-right:5px;margin-bottom:0"><?php echo e(__('Is Deductible')); ?></label>
																	<input ${isDeductable ? 'checked'  : false } id="dedictiable-for-${incomeStatementId}-element2-${incomeStatementItemId}" class="form-control vat-rate-value " type="checkbox" value="1" name="sub_items[0][is_deductible]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">` : '';
                    var spacer = editModel ? `<div style="height:20px"></div>` : ''
                    var vatFields = hasVatRate ? ` ${spacer} <div class="checkboxes-vat">
																<div class="checkboxes-vat-content d-flex align-items-center"> 
																	<label for="dedictiable-for-${incomeStatementId}-element-${incomeStatementItemId}" class="label" style="margin-bottom:0"><?php echo e(__('Vat Rate %')); ?></label>
																	<input id="dedictiable-for-${incomeStatementId}-element-${incomeStatementItemId}"  style="margin-right:10px;width:70px;margin-left:15px;" type="text" class="form-control only-percentage-allowed" value="${oldVatRate}" name="sub_items[0][vat_rate]">
																		${deductableCheckbox}
																 </div>
															</div>` : '';


                    return vatFields;

                }

                function getSalesRevenueModal(editModal, pivot = null, id) {

                    let salesRevenueQuantityDateValues = editModal && pivot && pivot.quantityPivot ? pivot.quantityPivot : {}
                    let datesFormatted = "<?php echo e(json_encode(($incomeStatement->getIntervalFormatted()))); ?>"
                    let pivotFormatted = editModal && pivot && pivot.payload ? JSON.parse(pivot.payload) : {}
                    let subItemName = editModal && pivot && pivot.payload ? pivot.sub_item_name : 'new';
                    let currentValueForValueOrQuantityOrPrice = editModal && pivot && pivot.payload && pivot.payload.is_value_quantity_price ? pivot.payload.is_value_quantity_price : 'value';
                    datesFormatted = JSON.parse(datesFormatted.replace(/(&quot\;)/g, "\""))
                    let thsForHeader = '<th class="text-white"> <?php echo e(__("Item")); ?> <input type="text" style="height:0;overflow:hidden;width:0;background-color:transparent;border:none;color:transparent;" class="value_quantity_price-id" value="' + currentValueForValueOrQuantityOrPrice + '" name="sub_items[0][is_value_quantity_price]"> </th>';
                    let thdClass = 'view-table-th header-th  text-nowrap sorting_disabled  reset-table-width cursor-pointer sub-text-bg text-capitalize';
                    let tdForBodyValue = '<td><?php echo e(__("Value")); ?></td>';
                    let tdForBodyQuantity = '<td><?php echo e(__("Quantity")); ?></td>';
                    let tdForBodyPrice = '<td><?php echo e(__("Price")); ?> </td>';

                    for (date of dates) {
                        var salesQuantityAtDate = editModal && salesRevenueQuantityDateValues[date] ? salesRevenueQuantityDateValues[date] : 0;
                        salesQuantityAtDate = parseFloat(salesQuantityAtDate)
                        var valueAtDate = editModal && pivotFormatted[date] ? pivotFormatted[date] : 0;
                        valueAtDate = parseFloat(valueAtDate)
                        var priceAtDate = editModal && salesQuantityAtDate ? valueAtDate / salesQuantityAtDate : 0;
					
                        thsForHeader += '<th class="' + thdClass + '" data-date="' + date + '">' + datesFormatted[date] + '</th>'
                        tdForBodyValue += `<td class="" data-type="value"  data-date="${date}">
							<input data-in-edit-mode="${editModal}"  style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type="value" class="val-input hidden-for-popup form-control blured-item" type="text"  value="${number_format(valueAtDate,0)}" > 
							<input data-in-edit-mode="${editModal}"  style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type="value" class="val-input hidden-for-popup pr-0" type="hidden" name="sub_items[0][val][${date}]" value="${valueAtDate}" > 
							<i class="fa fa-ellipsis-h repeat-row" data-column-index="${date}" data-index="value" data-parent-query="tr"  title="<?php echo e(__('Repeat Right')); ?>"></i>
							
						  </td> `
                        tdForBodyQuantity += `<td class="" data-type="quantity"  data-date="${date}"> 
						
						<input data-current-value="${salesQuantityAtDate}" data-in-edit-mode="${editModal}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type="quantity" class="quantity-input hidden-for-popup form-control blured-item" type="text"  value="${salesQuantityAtDate}" >
						<input data-current-value="${salesQuantityAtDate}" data-in-edit-mode="${editModal}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type="quantity" class="quantity-input hidden-for-popup" type="hidden" name="sub_items[0][quantity][${date}]" value="${salesQuantityAtDate}" >
						<i class="fa fa-ellipsis-h repeat-row" data-column-index="${date}" data-index="value" data-parent-query="tr"  title="<?php echo e(__('Repeat Right')); ?>"></i>
						
						</td> `
                        tdForBodyPrice += `<td class="" data-type="price"  data-date="${date}">
						
						<input data-current-value="${priceAtDate}" data-in-edit-mode="${editModal}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" class="price-input hidden-for-popup form-control blured-item"  data-type="price" type="text"  value="${number_format(priceAtDate,0)}" >
						<input data-current-value="${priceAtDate}" data-in-edit-mode="${editModal}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" class="price-input hidden-for-popup" data-type="price" type="hidden" name="sub_items[0][price][${date}]" value="${priceAtDate}" >
						<i class="fa fa-ellipsis-h repeat-row" data-column-index="${date}" data-index="value" data-parent-query="tr"  title="<?php echo e(__('Repeat Right')); ?>"></i>
						
						</td> 
						`;
                    }
                    thsForHeader += "<th class='text-white text-center'><?php echo e(__('Total')); ?></th>";


                    tdForBodyPrice += `<td class="" data-type="price"> 
					<input readonly type="text" class="form-control pr-0 total-for-price" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';"> 
					<i style="visibility:hidden" class="fa fa-ellipsis-h" ></i>
						
						
					</td>`

                    tdForBodyPrice = '<tr data-equation="value / quantity" data-number-format="2" class="price" data-type="price" >' + tdForBodyPrice + '</tr>'


                    tdForBodyQuantity += `<td class="" data-type="quantity"> <input readonly type="text" class="form-control pr-0 total-for-quantity" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';">
						<i style="visibility:hidden" class="fa fa-ellipsis-h " ></i>
					 </td>`

                    tdForBodyQuantity = '<tr data-equation="value / price" data-number-format="0" class="quantity" data-type="quantity">' + tdForBodyQuantity + '</tr>'
                    tdForBodyValue += `<td class="" data-type="value"> <input readonly type="text" class="form-control pr-0 total-for-value" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';"> 
					<i style="visibility:hidden" class="fa fa-ellipsis-h " ></i>
					
					</td>`
                    tdForBodyValue = '<tr data-equation="quantity * price" data-number-format="0" class="value" data-type="value">' + tdForBodyValue + '</tr>'
                    editModal = editModal ? 1 : 0;
                    if (!salesRevenueModalTdData[editModal]) {
                        salesRevenueModalTdData[editModal] = {
                            [subItemName]: {
                                price: tdForBodyPrice
                                , quantity: tdForBodyQuantity
                                , value: tdForBodyValue
                            }
                        }
                    } else if (!salesRevenueModalTdData[editModal][subItemName]) {
                        salesRevenueModalTdData[editModal][subItemName] = {
                            price: tdForBodyPrice
                            , quantity: tdForBodyQuantity
                            , value: tdForBodyValue
                        }
                    }
					else  {
                        salesRevenueModalTdData[editModal][subItemName] = {
                            price: tdForBodyPrice
                            , quantity: tdForBodyQuantity
                            , value: tdForBodyValue
                        }
                    }

                    return `
					<div class="quantity-section ">
						<div class="checkboxes-for-quantity only-two-checkbox-parent mt-4">
							<div class="quantity-checkbox-div">
							<label ><?php echo e(__('Value')); ?></label>
								<input data-sub-item-name="${editModal ? pivot.sub_item_name : 'new'}" data-in-edit-mode="${editModal }" class="only-two-checkbox 	" type="checkbox" value="value"  style="width:16px;height:16px;" name="sub_items[0][is_quantity]" ${editModal && pivot.is_value_quantity_price&& pivot.is_value_quantity_price.includes('value') ? 'checked' : '' } ${!editModal ? '' : ''}>
							</div>
							<div class="quantity-checkbox-div">
								<label ><?php echo e(__('Quantity')); ?></label>
								<input data-sub-item-name="${editModal ? pivot.sub_item_name : 'new'}" data-in-edit-mode="${editModal }" class="only-two-checkbox can-trigger-quantity-modal" type="checkbox" value="quantity"  style="width:16px;height:16px;" name="sub_items[0][is_quantity]" ${editModal &&  pivot.is_value_quantity_price&& editModal && pivot.is_value_quantity_price.includes('quantity') ? 'checked' : ''}>
							</div>
							<div class="quantity-checkbox-div">
								<label ><?php echo e(__('Price')); ?></label>
								<input data-sub-item-name="${editModal ? pivot.sub_item_name : 'new'}" data-in-edit-mode="${editModal}" class="only-two-checkbox can-trigger-quantity-modal" type="checkbox" value="price"  style="width:16px;height:16px;" name="sub_items[0][is_quantity]" ${editModal && pivot.is_value_quantity_price&& pivot.is_value_quantity_price.includes('price') ? 'checked' : ''}>
							</div>
						</div>
						
						
						<div id="modal-for-quantity-0" class="modal fade modal-for-quantity" data-index="0"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl "  role="document">
    <div class="modal-content" style="overflow-x:scroll">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Values And Quantities</h5>
        <button type="button" class="close-inner-modal close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped-  table-hover table-checkable position-relative dataTable no-footer dtr-inline">
			<thead>
				<tr class="header-tr">
					${thsForHeader}
				</tr>
			</thead>
			<tbody class="append-sales-revenue-modal-table-body" data-id="${id}" data-index="0">
				
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-inner-modal" >Close</button>
        <button type="button" class="btn btn-primary close-inner-modal">Save</button>
      </div>
    </div>
  </div>
</div>

					</div>
					
					
					
					
					`;
                }




                function getNonRepeatingModal(editModal, pivot = null, id) {
                    //return '';
                    let datesFormatted = "<?php echo e(json_encode(($incomeStatement->getIntervalFormatted()))); ?>"
                    let pivotFormatted = editModal && pivot && pivot.payload ? JSON.parse(pivot.payload) : {}
                    let subItemName = editModal && pivot && pivot.payload ? pivot.sub_item_name : 'new';
                    var isDeductable = editModal && pivot && pivot.payload ? pivot.is_deductible : 0
                    let vatRate = editModal && pivot && pivot.payload && !isDeductable ? pivot.vat_rate : 0;
                    datesFormatted = JSON.parse(datesFormatted.replace(/(&quot\;)/g, "\""))
                    let thsForHeader = '<th class="text-white"> <?php echo e(__("Item")); ?>  </th>';
                    let thdClass = 'view-table-th header-th  text-nowrap sorting_disabled  reset-table-width cursor-pointer sub-text-bg text-capitalize';
                    let tdForBodyValue = '<td><?php echo e(__("Value")); ?></td>';

                    for (date of dates) {

                        var valueAtDate = editModal && pivotFormatted[date] ? pivotFormatted[date] : 0;
                        valueAtDate = parseFloat(valueAtDate)
						valueAtDate = editModal ? valueAtDate / (1+(vatRate/100)) : valueAtDate;
                        thsForHeader += '<th class="' + thdClass + '" data-date="' + date + '">' + datesFormatted[date] + '</th>'

                        tdForBodyValue += `<td data-id="${id}" class="" data-type="value"  data-date="${date}">
							<input data-id="${id}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type-non-repeating="value" class="val-input hidden-for-popup-non-repeating blured-item-non-repeating form-control " type="text"  value="${number_format(valueAtDate,0)}" > 
							<input data-id="${id}" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';" data-date="${date}" data-type-non-repeating="value" class="val-input hidden-for-popup-non-repeating pr-0" type="hidden" name="sub_items[0][non_repeating_popup][${date}]" value="${valueAtDate}" > 
							<i class="fa fa-ellipsis-h repeat-row" data-column-index="${date}" data-index="value" data-parent-query="tr"  title="<?php echo e(__('Repeat Right')); ?>"></i>
							
						  </td> `

                    }
                    thsForHeader += "<th class='text-white text-center'><?php echo e(__('Total')); ?></th>";






                    tdForBodyValue += `<td class="" data-type="value"> <input readonly type="text" class="form-control pr-0 total-for-non-repeating-value" style="min-width: 80px" onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" onblur="this.style.width = ((this.value.length + 1) * 10) + 'px';" onkeyup="this.style.width = ((this.value.length + 1) * 10) + 'px';"> 
					<i style="visibility:hidden" class="fa fa-ellipsis-h " ></i>
					
					</td>`
                    tdForBodyValue = '<tr data-number-format="0" class="value" data-type="value">' + tdForBodyValue + '</tr>'
                    editModal = editModal ? 1 : 0;
                    if (!nonRepeatingModalTdData[editModal]) {
                        nonRepeatingModalTdData[editModal] = {
                            [subItemName]: {
                                value: tdForBodyValue
                            }
                        }
                    } else if (!nonRepeatingModalTdData[editModal][subItemName]) {
                        nonRepeatingModalTdData[editModal][subItemName] = {

                            value: tdForBodyValue
                        }
                    }

                 


                    let result = `<div class="non-repeating-section ">
						
						
						<div id="modal-for-non-repeating-0" data-edit-model="${editModal}" class="modal fade modal-for-non-repeating" data-index="0"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl "  role="document">
    <div class="modal-content" style="overflow-x:scroll">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Non Repeating</h5>
        <button type="button" class="close-inner-modal close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped-  table-hover table-checkable position-relative dataTable no-footer dtr-inline">
			<thead>
				<tr class="header-tr">
					${thsForHeader}
				</tr>
			</thead>
			<tbody class="append-non-repeating-modal-table-body" data-id="${id}" data-index="0">
				${tdForBodyValue}
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-inner-modal" >Close</button>
        <button type="button" class="btn btn-primary close-inner-modal">Save</button>
      </div>
    </div>
  </div>
</div>

					</div>`;
                    return result;
                }


                function getCollectionPolicyHtml(editMode, pivot = null, id) {
                    let valueOfCustom = [];
                    let isCustom = pivot && pivot && pivot.has_collection_policy && pivot.collection_policy_type == 'customize'
                    let isSystemDefault = pivot && pivot.has_collection_policy && pivot.collection_policy_type == 'system_default'
                    let collectionOrPayment = id == domElements.salesRevenueId ? 'Collection' : 'Payment'
                    if (isCustom) {
                        valueOfCustom = JSON.parse(pivot.collection_policy_value)
                    }
                    let collectionRates = ``
                    let dueInDays = ``

                    for (let i = 0; i < 5; i++) {
                        collectionRates += `<div class="collection-rate-item mb-3">
												<input class="form-control collection_rate_input" type="text" name="sub_items[0][collection_policy][type][customize][value][rate][${i}]" style="width:100px;" value="${isCustom && valueOfCustom.rate && valueOfCustom.rate[i]?valueOfCustom.rate[i] :0 }">
											</div>`
                        dueInDays += `<div class="collection-rate-item mb-3">
												<select name="sub_items[0][collection_policy][type][customize][value][due_in_days][${i}]" class="form-control">
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==0?'selected':'' } value="0">0</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==15 ? 'selected' :''} value="15">15</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==30 ? 'selected' :''} value="30">30</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==45 ? 'selected' :''} value="45">45</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==60 ? 'selected' :''} value="60">60</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==75 ? 'selected' :''} value="75">75</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==90 ? 'selected' :''} value="90">90</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==120? 'selected' :'' } value="120">120</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==150? 'selected' :'' } value="150">150</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==180? 'selected' :'' } value="180">180</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==210? 'selected' :'' } value="210">210</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==240? 'selected' :'' } value="240">240</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==270? 'selected' :'' } value="270">270</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==300? 'selected' :'' } value="300">300</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==330? 'selected' :'' } value="330">330</option>
													<option ${isCustom && valueOfCustom.due_in_days && valueOfCustom.due_in_days[i] && valueOfCustom.due_in_days[i]==360? 'selected' :'' } value="360">360</option>
												</select>
											</div>`
                    }

                    return `
					<div class="collection-policy d-flex flex-wrap w-100 mt-3 ${id == domElements.salesRevenueId && editMode  ? 'pl-25' :''}">
						<div class="collection-policy-header basis-100 mb-4">
							<div class="check-boxes">
								<div class="checkbox-item d-flex ">
									<label class="form-label label  mr-3"><?php echo e(__('Has ${collectionOrPayment} Policy')); ?></label>
									<input ${pivot && pivot.has_collection_policy ? 'checked' : ''} type="checkbox" style="width:16px;height:16px;" name="" class="checkbox has-collection-policy-class form-control"  value="1">
									<input type="hidden" class="has_collection_policy_input" name="sub_items[0][collection_policy][has_collection_policy]" value="${pivot && pivot.has_collection_policy ? 1 : 0}">
								</div>
							</div>
						</div>
						<div class="collection-policy-content basis-100 d-none only-one-checked-parent">
							<div class="collection-policy-wrapper ">
								<div class="collection-policy-checkboxes d-flex parent-for-checkbox">
									<div class="checkbox-item d-flex mr-3">
									<label class="form-label label  mr-3"><?php echo e(__('System Default')); ?></label>
									<input data-index="0" ${isSystemDefault ? 'checked' : ''} type="checkbox" style="width:16px;height:16px;" class="checkbox only-one-checked form-control checkedbox checkbox-for-policy system_default" name="sub_items[0][collection_policy][type][name]" value="system_default">
								</div>
								
								<div class="checkbox-item d-flex ">
									<label class="form-label label  mr-3"><?php echo e(__('Customize')); ?></label>
									<input data-index="0" ${isCustom ? 'checked' : ''} type="checkbox" style="width:16px;height:16px;" class="checkbox only-one-checked form-control checkedbox  checkbox-for-policy customize" name="sub_items[0][collection_policy][type][name]"  value="customize">
								</div>
								
								</div>
								
							</div>
							
							<div class="checkboxes-content d-flex mt-4">
								<div class="basis-100 for-only-one-checked d-none" data-item="system_default">
										<div class="system-default-select">
											<select name="sub_items[0][collection_policy][type][system_default][value]" class="select form-control">
												<option ${pivot && pivot.has_collection_policy && pivot.collection_policy_type =='system_default' && pivot.collection_policy_value =='monthly' ? 'selected' : ''} value="monthly"><?php echo e(__('Cash')); ?></option>
												<option ${pivot && pivot.has_collection_policy && pivot.collection_policy_type =='system_default' && pivot.collection_policy_value =='quarterly' ? 'selected' : ''} value="quarterly"><?php echo e(__('Quarterly')); ?></option>
												<option ${pivot && pivot.has_collection_policy && pivot.collection_policy_type =='system_default' && pivot.collection_policy_value =='semi-annually' ? 'selected' : ''} value="semi-annually"><?php echo e(__('Semi-annually')); ?></option>
												<option ${pivot && pivot.has_collection_policy && pivot.collection_policy_type =='system_default' && pivot.collection_policy_value =='annually' ? 'selected' : ''} value="annually"><?php echo e(__('Annually')); ?></option>
											</select>
										</div>
								</div>
								<div class="basis-100 for-only-one-checked d-none" data-item="customize">
									<div class="customize-content" style="display:flex;gap:50px;">
										<div class="collection-rate d-flex flex-column ">
											<h5 class="mb-3 label form-label"><?php echo e(__('${collectionOrPayment} Rate %')); ?> </h5>
											${collectionRates}
											<label class="label form-label"><?php echo e(__('Total')); ?></label>
											<input style="width:100px;" value="0" disabled class="form-control collection_rate_total_class" name="sub_items[0][collection_rate_total][]">
										</div>
										<div class="due-in-days d-flex flex-column">
											<h5 class="label form-label mb-3"><?php echo e(__('Due In Days')); ?></h5>
											${dueInDays}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					`;
                }

                function updateSalesGrowthRate(visiableHeaderDates) {
                    const salesRevenueId = domElements.salesRevenueId;
                    const salesGrowthRateId = domElements.salesGrowthRateId;
                    for (visiableHeaderDate of visiableHeaderDates) {
                        previousDate = getPreviousElementInArray(visiableHeaderDates, visiableHeaderDate);
                        if (previousDate) {

                            var currentSalesRevenueValue = number_unformat($('tbody tr[data-model-id="' + salesRevenueId + '"] td.editable-date.date-' + visiableHeaderDate).html());
                            var previousSalesRevenueValue = number_unformat($('tbody tr[data-model-id="' + salesRevenueId + '"] td.editable-date.date-' + previousDate).html());
                            if (previousSalesRevenueValue) {
                                $('tbody tr[data-model-id="' + salesGrowthRateId + '"] td.editable-date.date-' + visiableHeaderDate).html(number_format((currentSalesRevenueValue - previousSalesRevenueValue) / previousSalesRevenueValue * 100, 2) + ' %');
                            } else {
                                $('tbody tr[data-model-id="' + salesGrowthRateId + '"] td.editable-date.date-' + visiableHeaderDate).html(number_format(0, 2) + ' %');

                            }


                        } else {
                            $('tbody tr[data-model-id="' + salesGrowthRateId + '"] td.editable-date.date-' + visiableHeaderDate).html(number_format(0, 2) + ' %');
                        }
                    }


                }

                function getYearsFromDates(dates) {
                    years = [];
                    for (date of dates) {
                        years.push(date.split('-')[0]);
                    }
                    return uniqueArray(years);
                }

                function uniqueArray(a) {
                    return a.filter(function(item, pos) {
                        return a.indexOf(item) == pos;
                    });

                }

            </script>
            <script>


            </script>


         <?php $__env->endSlot(); ?>

     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
</div>
<?php /**PATH E:\projects\veroo\resources\views/admin/income-statement/report/view-table.blade.php ENDPATH**/ ?>