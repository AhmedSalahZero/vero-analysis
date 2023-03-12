@php
$tableId = 'kt_table_1';
@endphp


<style>
    .width-66 {
        width: 70% !important;
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
        background-color: rgb(238, 238, 238) !important;
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
        background-color: #0e96cd !important;
        color: white !important;

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
@csrf

<input type="hidden" id="editable-by-btn" value="1">
@if(in_array($reportType,['modified','adjusted']))
<input type="hidden" id="fixed-column-number" value="2">
@else
<input type="hidden" id="fixed-column-number" value="3">
@endif
<input type="hidden" id="sub-item-type" value="{{ $reportType }}">
<div class="table-custom-container position-relative  ">
    <input type="hidden" value="{{ $incomeStatement->id }}" id="model-id">
    <input type="hidden" id="income-statement-duration-type" value="{{ $incomeStatement->duration_type ?? '' }}">

    <input type="hidden" id="cost-of-goods-id" value="{{ \App\Models\IncomeStatementItem::COST_OF_GOODS_ID }}">
    <input type="hidden" id="sales-growth-rate-id" value="{{ \App\Models\IncomeStatementItem::SALES_GROWTH_RATE_ID }}">
    <input type="hidden" id="sales-revenue-id" value="{{ \App\Models\IncomeStatementItem::SALES_REVENUE_ID }}">
    <input type="hidden" id="gross-profit-id" value="{{ \App\Models\IncomeStatementItem::GROSS_PROFIT_ID }}">
    <input type="hidden" id="market-expenses-id" value="{{ \App\Models\IncomeStatementItem::MARKET_EXPENSES_ID }}">
    <input type="hidden" id="sales-and-distribution-expenses-id" value="{{ \App\Models\IncomeStatementItem::SALES_AND_DISTRIBUTION_EXPENSES_ID }}">
    <input type="hidden" id="general-expenses-id" value="{{ \App\Models\IncomeStatementItem::GENERAL_EXPENSES_ID }}">
    <input type="hidden" id="earning-before-interest-taxes-depreciation-amortization-id" value="{{ \App\Models\IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_DEPRECIATION_AMORTIZATION_ID }}">
    <input type="hidden" id="earning-before-interest-taxes-id" value="{{ \App\Models\IncomeStatementItem::EARNING_BEFORE_INTEREST_TAXES_ID }}">
    <input type="hidden" id="financial-income-or-expenses-id" value="{{ \App\Models\IncomeStatementItem::FINANCIAL_INCOME_OR_EXPENSE_ID }}">
    <input type="hidden" id="earning-before-taxes-id" value="{{ \App\Models\IncomeStatementItem::EARNING_BEFORE_TAXES_ID }}">
    <input type="hidden" id="corporate-taxes-id" value="{{ \App\Models\IncomeStatementItem::CORPORATE_TAXES_ID }}">
    <input type="hidden" id="net-profit-id" value="{{ \App\Models\IncomeStatementItem::NEXT_PROFIT_ID }}">
    <input type="hidden" id="sales-rate-maps" value="{{ json_encode(\App\Models\IncomeStatementItem::salesRateMap()) }}">
    <script>
        let sales_rates_maps = document.getElementById('sales-rate-maps').value;
        const sales_rate_maps = JSON.parse(sales_rates_maps);
        let lastInputValue = 0

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



    <x-tables.basic-view :redirect-route="route('admin.view.financial.statement', getCurrentCompanyId())" :save-and-return="true" :form-id="'store-report-form-id'" :wrap-with-form="true" :form-action="route('admin.store.income.statement.report',['company'=>getCurrentCompanyId()])" class="position-relative table-with-two-subrows main-table-class" id="{{ $tableId }}">
        <x-slot name="filter">
            @include('admin.income-statement.report.filter' , [
            'type'=>'filter'
            ])
        </x-slot>

        <x-slot name="export">
            @include('admin.income-statement.report.export' , [
            'type'=>'export'
            ])
        </x-slot>


        <x-slot name="headerTr">
            <input type="hidden" name="sub_item_type" value="{{ getReportNameFromRouteName(Request()->route()->getName()) }}">

            <tr class="header-tr " data-model-name="{{ $modelName }}">
                <th class="view-table-th header-th trigger-child-row-1 expand-all is-open-parent text-nowrap">
                    {{ __('Expand') }}
                    <span>+</span>
                </th>

                <th class="view-table-th header-th" data-db-column-name="id" data-is-relation="0" class="header-th" data-is-json="0">
                    {{ __('Actions') }}
                </th>
                <th class="view-table-th header-th" data-is-collection-relation="0" data-collection-item-id="0" data-db-column-name="name" data-relation-name="BussinessLineName" data-is-relation="1" class="header-th" data-is-json="0">
                    {{ __('Name') }}
                    {{-- {!!  !!} --}}
                </th>
                <input type="hidden" name="dates" value="{{ json_encode(array_keys($incomeStatement->getIntervalFormatted())) }}" id="dates">
                @foreach($incomeStatement->getIntervalFormatted() as $defaultDateFormate=>$interval)
                <th data-is-actual="{{ (int)isActualDate($defaultDateFormate) }}" data-date="{{ $defaultDateFormate }}" data-month-year="{{explode('-',$defaultDateFormate)[0].'-'.explode('-',$defaultDateFormate)[1]}}" class="view-table-th header-th" data-is-collection-relation="0" data-collection-item-id="0" data-db-column-name="name" data-relation-name="ServiceCategory" data-is-relation="1" class="header-th" data-is-json="0">
                    {{ $interval }}
                    @if(isActualDate($defaultDateFormate) && $reportType != 'forecast')
                    <br>({{ __('Actual') }})
                    @elseif($reportType != 'forecast')
                    <br>({{ __('Forecast') }})
                    @endif
                </th>
                @endforeach
                <th class="view-table-th header-th">
                    {{ __('Total') }}
                </th>

                <div hidden type="hidden" id="cols-counter" data-value="0"> </div>
                <script>
                    countHeadersInPage('.main-table-class th', '#cols-counter');

                </script>

            </tr>

        </x-slot>

        <x-slot name="js">
            <script>
                let inAddOrEditModal = false;
                let canRefreshPercentages = false;
                window.addEventListener('DOMContentLoaded', function() {
                    (function($) {

                        $(document).on('change', '.is-sub-row input', function(e) {
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
                            if (date && parentModelId) {
                                updateParentMainRowTotal(parentModelId, date);
                            }

                            if (parentModelId == salesRevenueId || parentModelId == costOfGoodsId) {

                                updateGrowthRateForSalesRevenue(date);
                                updateTotalForRow(currentRow);
                                updateGrossProfit(date);

                                if (parentModelId == salesRevenueId && canRefreshPercentages) {
                                    refreshPercentagesThatDependsOnSalesRevenueValue(date)
                                }

                            }
                            if (parentModelId == marketExpensesId || parentModelId == salesAndDistributionExpensesId || parentModelId == generalExpensesId) {
                                updateEarningBeforeIntersetTaxesDepreciationAmortization(date);
                            }
                            if (parentModelId == financialIncomeOrExpenses) {
                                updateEarningBeforeTaxes(date);
                            }
                            if (parentModelId == corporateTaxesId) {
                                updateNetProfit(date);
                            }
                            updateTotalForRow(currentRow);
                            updatePercentageOfSalesFor(parentModelId, date);
                            updateAllMainsRowPercentageOfSales([date])
                        });

                        const refreshPercentagesThatDependsOnSalesRevenueValue = (date) => {
                            document.querySelectorAll('tr[data-is-percentage="true"] td.date-' + date).forEach((td) => {
                                td.dispatchEvent(new Event('blur', {
                                    'bubbles': true
                                }))
                            });
                        }



                        function updateNetProfit(date) {
                            let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                            let corporateTaxesId = domElements.corporateTaxesId;
                            let netProfitId = domElements.netProfitId;
                            let netProfitRow = document.querySelector('.main-with-no-child[data-model-id="' + netProfitId + '"]');
                            let earningBeforeTaxesValueAtDate = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeTaxesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            let corporateTaxesValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + corporateTaxesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            netprofitAtDate = earningBeforeTaxesValueAtDate - corporateTaxesValueAtDate;
                            netProfitRow.querySelector('td.date-' + date).innerHTML = number_format(netprofitAtDate);
                            var input = netProfitRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]');
                            input.value = netprofitAtDate;
                            // input.dispatchEvent(new Event('change', {
                            //     'bubbles': true
                            // }))
                            updateTotalForRow(netProfitRow);
                            updatePercentageOfSalesFor(domElements.netProfitId, date);
                        }

                        function updateEarningBeforeTaxes(date) {
                            let earningBeforeInterstTaxesId = domElements.earningBeforeInterestTaxesId;
                            let financialIncomeOrExpensesId = domElements.financialIncomeOrExpensesId;
                            let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                            let earningBeforeTaxesIdRow = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeTaxesId + '"]');
                            let earningBeforeInterstTaxesValueAtDate = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeInterstTaxesId + '"]' + ' td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            let financialIncomeOrExpensesValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + financialIncomeOrExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            earningBeforeTaxesAtDate = parseFloat(earningBeforeInterstTaxesValueAtDate) + parseFloat(financialIncomeOrExpensesValueAtDate);
                            earningBeforeTaxesIdRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeTaxesAtDate);
                            var input = earningBeforeTaxesIdRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]');
                            input.value = earningBeforeTaxesAtDate;
                            input.dispatchEvent(new Event('change', {
                                'bubbles': true
                            }))
                            updateTotalForRow(earningBeforeTaxesIdRow);
                            updateNetProfit(date);
                        }

                        function updateEarningBeforeIntersetTaxesDepreciationAmortization(date) {
                            let grossProfitId = domElements.growthProfitId;
                            let marketExpensesId = domElements.marketExpensesId;
                            let salesAndDistributionExpensesId = domElements.salesAndDistributionExpensesId;
                            let generalExpensesId = domElements.generalExpensesId;
                            let costOfGoodsId = domElements.costOfGoodsId;
                            let earningBeforeInterstTaxesDepreciationAmortizationId = domElements.earningBeforeInterestTaxesDepreciationAmor;
                            let earningBeforeInterestTaxesDepreciationAmortizationRow = document.querySelector('.main-with-no-child[data-model-id="' + earningBeforeInterstTaxesDepreciationAmortizationId + '"]');
                            let grossProfitAtDate = parseFloat(document.querySelector('.main-with-no-child[data-model-id="' + grossProfitId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            let marketExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + marketExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            let salesAndDistributionExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesAndDistributionExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            let generalExpensesAtDate = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + generalExpensesId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            var mainWithSubItemsCostOfGoods = document.querySelector('.is-main-with-sub-items[data-model-id="' + costOfGoodsId + '"]')

                            let depreciationForCostOfGoodsSold = [...myNextAll(mainWithSubItemsCostOfGoods, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + costOfGoodsId)]

                            let totalDepreciationForCostOfGoodsSoldAtDate = 0;
                            for (depreciationRow of depreciationForCostOfGoodsSold) {
                                totalDepreciationForCostOfGoodsSoldAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            }

                            var mainWithSubItemsMarketExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + marketExpensesId + '"]')
                            let depreciationForMarketExpenses = [...myNextAll(mainWithSubItemsMarketExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + marketExpensesId)]

                            let totalDepreciationForMarketExpensesAtDate = 0;
                            for (depreciationRow of depreciationForMarketExpenses) {
                                totalDepreciationForMarketExpensesAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            }

                            var mainWithSubItemsSalesAndDistrubtionExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + salesAndDistributionExpensesId + '"]')

                            let depreciationForSalesAndDistributionExpense = [...myNextAll(mainWithSubItemsSalesAndDistrubtionExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + salesAndDistributionExpensesId)];
                            let totalDepreciationForSalesAndDistributionExpenseAtDate = 0;
                            for (depreciationRow of depreciationForSalesAndDistributionExpense) {
                                totalDepreciationForSalesAndDistributionExpenseAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            }
                            var mainWithSubItemsGeneralExpenses = document.querySelector('.is-main-with-sub-items[data-model-id="' + generalExpensesId + '"]')
                            let depreciationForGeneralExpenses = [...myNextAll(mainWithSubItemsGeneralExpenses, 'tr.is-depreciation-or-amortization.maintable-1-row-class' + generalExpensesId)];
                            let totalDepreciationForGeneralExpensesAtDate = 0;
                            for (depreciationRow of depreciationForGeneralExpenses) {
                                totalDepreciationForGeneralExpensesAtDate += parseFloat(depreciationRow.querySelector('td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value);
                            }
                            let totalDepreciationsAtDate = totalDepreciationForGeneralExpensesAtDate + totalDepreciationForSalesAndDistributionExpenseAtDate + totalDepreciationForMarketExpensesAtDate + totalDepreciationForCostOfGoodsSoldAtDate
                            let earningBeforeInterestTaxesAtDate = grossProfitAtDate - marketExpensesAtDate - salesAndDistributionExpensesAtDate - generalExpensesAtDate;
                            let earningBeforeInterstTaxesDepreciationAmortizationAtDate = earningBeforeInterestTaxesAtDate + totalDepreciationsAtDate;
                            earningBeforeInterestTaxesDepreciationAmortizationRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeInterstTaxesDepreciationAmortizationAtDate);
                            var input = earningBeforeInterestTaxesDepreciationAmortizationRow.querySelector('input[data-date="' + date + '"]')

                            input.value = earningBeforeInterstTaxesDepreciationAmortizationAtDate
                            input.dispatchEvent(new Event('change', {
                                'bubbles': true
                            }));
                            updateTotalForRow(earningBeforeInterestTaxesDepreciationAmortizationRow);

                            updateEarningBeforeInterestTaxesDepreciationAmortizationId(earningBeforeInterestTaxesAtDate, date)

                        }

                        function updateEarningBeforeInterestTaxesDepreciationAmortizationId(earningBeforeInterestTaxesWithoutDepreciationAtDate, date) {
                            let EarningBeforeInterestTaxesId = domElements.earningBeforeInterestTaxesId;
                            let earningBeforeInterestTaxesRow = document.querySelector('.main-with-no-child[data-model-id="' + EarningBeforeInterestTaxesId + '"]');
                            earningBeforeInterestTaxesRow.querySelector('td.date-' + date).innerHTML = number_format(earningBeforeInterestTaxesWithoutDepreciationAtDate);
                            var input = earningBeforeInterestTaxesRow.querySelector('input[data-date="' + date + '"]')

                            input.value = earningBeforeInterestTaxesWithoutDepreciationAtDate
                            input.dispatchEvent(new Event('change', {
                                'bubbles': true
                            }));
                            updateTotalForRow(earningBeforeInterestTaxesRow);

                        }

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
                                var isQuantity = 0;
                                var percentageOrFixed = formDataObject['sub_items[' + i + '][percentage_or_fixed]'];
                                var isPercentage = percentageOrFixed == 'percentage';
                                var isPercentageOf = isPercentage && formDataObject['sub_items[' + i + '][is_percentage_of][]'] ? "[" + formDataObject['sub_items[' + i + '][is_percentage_of][]'].toString() + "]" : '';
                                var isRepeatingFixed = percentageOrFixed == 'repeating_fixed';
                                var isNoneRepeatingFixed = percentageOrFixed == 'non_repeating_fixed';
                                var canTriggerChange = isRepeatingFixed || isPercentage;
                                var tdValue = 0;
                                var valuesOfDates = [];
                                if (isRepeatingFixed) {
                                    tdValue = formDataObject['sub_items[' + i + '][repeating_fixed_value]'];
                                    value = tdValue;
                                    dates.forEach((date) => {
                                        valuesOfDates.push({
                                            date
                                            , value
                                        })
                                    })
                                } else if (isPercentage) {

                                    let financialStatementAbleItemId = formDataObject.financial_statement_able_item_id;
                                    let corporateTaxesId = domElements.corporateTaxesId;
                                    let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                                    let salesRevenueId = domElements.salesRevenueId;
                                    if (!isPercentageOf.length) {
                                        rows = null;
                                        alert('Please Enter Percentage Items For ' + subItemName);
                                        return;
                                    }

                                    var percentageValue = formDataObject['sub_items[' + i + '][percentage_value]'];
                                    tdValue = percentageValue ? percentageValue : 0;
                                    var originPercentageValue = tdValue


                                    var percentage_of_array = isPercentageOf;

                                    if (!Array.isArray(percentage_of_array)) {

                                        percentage_of_array = percentage_of_array ? percentage_of_array.replace(/\[|\]/g, '').split(',') : [];
                                    }
                                    var salesRevenueRowId = domElements.salesRevenueId;

                                    var total = 0;
                                    var percentageElementId = financialStatementAbleItemId == corporateTaxesId ? earningBeforeTaxesId : salesRevenueRowId;
















                                    dates.forEach(function(date) {
                                        var currentDate = date

                                        total = 0;
                                        percentage_of_array.forEach(function(subItemName) {

                                            var valOfCurrentSubItem = 0;
                                            if (financialStatementAbleItemId == corporateTaxesId) {
                                                valOfCurrentSubItem = parseFloat(document.querySelector('input[data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value);
                                                if (valOfCurrentSubItem < 0) {
                                                    valOfCurrentSubItem = 0;
                                                }
                                            } else {
                                                valOfCurrentSubItem = document.querySelector('tr[data-sub-item-name=' + subItemName + '] input[type="hidden"][data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value;
                                            }
                                            total += parseFloat(valOfCurrentSubItem);

                                        });
                                        var percentageValue = inAddOrEditModal ? originPercentageValue : parseFloat(tdElement.getAttribute('data-percentage-value'));
                                        var currentVal = inAddOrEditModal ? originPercentageValue : parseFloat(tdElement.getAttribute('data-percentage-value'));
                                        currentValue = total ? currentVal / 100 * total : 0;
                                        value = currentValue;
                                        tdValue = currentValue
                                        valuesOfDates.push({
                                            date
                                            , value // not change value name
                                        });
                                    });
                                }
                                rows += getRowForSubItemsTr('kt_table_1', dates, percentageValue, incomeStatementId, incomeStatementItemId, subItemName, isDepreciationOrAmortization, isQuantity, canBePercentage, percentageOrFixed, isPercentage, isRepeatingFixed, isNoneRepeatingFixed, valuesOfDates, canTriggerChange, isPercentageOf);
                            }

                            formattedTable = formateRowsForInsertaionIntoDom(rows)
                            insertTableIntoDom(formattedTable);
                            // triggerBlurForEditableTd();
                            return formattedTable;
                        }


                        function updateGrossProfit(date) {
                            let grossProfitId = domElements.growthProfitId;
                            let costOfGoodsId = domElements.costOfGoodsId;
                            let salesReveueId = domElements.salesRevenueId;
                            let grossProfitRow = document.querySelector('.main-with-no-child[data-model-id="' + grossProfitId + '"]');
                            let salesRevenueValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + salesReveueId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            let costOfGoodsValueAtDate = document.querySelector('.is-main-with-sub-items[data-model-id="' + costOfGoodsId + '"] ' + 'td.date-' + date).parentElement.querySelector('input[data-date="' + date + '"]').value;
                            grossProfitAtDate = salesRevenueValueAtDate - costOfGoodsValueAtDate;

                            grossProfitRow.querySelector('td.date-' + date).innerHTML = number_format(grossProfitAtDate);
                            var input = grossProfitRow.querySelector('input[data-date="' + date + '"]')
                            input.value = grossProfitAtDate

                            input.dispatchEvent(new Event('change', {
                                'bubbles': true
                            }));

                            updateTotalForRow(grossProfitRow);

                        }

                        function getRowForSubItemsTr(tableId, dates, percentageValue, incomeStatementId, incomeStatementItemId, subItemName, isDepreciationOrAmortization, isQuantity, canBePercentageOrFixed, fixedOrPercentage, isPercentage, isRepeatingFixed, isNoneRepeatingFixed, valuesOfDates, canTriggerChange, isPercentageOf) {
                            let row = `<tr   data-financial-statement-able-item-id="${incomeStatementItemId}" class="d-none edit-info-row add-sub maintable-1-row-class${incomeStatementItemId} is-sub-row even" data-sub-item-name="${subItemName}" data-is-trigger-change="${canTriggerChange}" data-can-be-percentage-or-fixed="${canBePercentageOrFixed}" data-percentage-or-fixed="${fixedOrPercentage}" data-is-percentage="${isPercentage}" data-is-percentage-of="${isPercentageOf}"  data-is-repeating-fixed="${isRepeatingFixed}" data-is-none-repeating-fixed="${isNoneRepeatingFixed}">
																<td class="red reset-table-width trigger-child-row-1 cursor-pointer  sub-text-bg dtfc-fixed-left" style="left: 0px; position: sticky;"></td>
																<td class="cursor-pointer sub-text-bg dtfc-fixed-left" style="left: 70.25px; position: sticky;">
												<div class="d-flex align-items-center justify-content-between">
													<a data-is-subitem="1" class="d-block edit-btn mb-2 text-white " href="#" data-toggle="modal" data-is-depreciation-or-amortization="${isDepreciationOrAmortization}" data-income-statement-id="${incomeStatementId}" data-target="#edit-sub-modal${incomeStatementItemId}${subItemName}"> <i class="fa fa-pen-alt"></i> </a> <a class="d-block  delete-btn text-white mb-2 text-danger" href="#" data-toggle="modal" data-target="#delete-sub-modal${incomeStatementId}${subItemName}">
														<i class="fas fa-trash-alt"></i>

													</a>
												</div>
											</td>
											<td class="sub-text-bg text-nowrap editable editable-text is-name-cell dtfc-fixed-left" data-income-statement-id="${incomeStatementId}" data-main-model-id="${incomeStatementItemId}" data-income-statement-item-id="${incomeStatementItemId}" data-main-row-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}" data-table-id="${tableId}" data-is-quantity="${isQuantity}" style="left: 141.417px; position: sticky;" contenteditable="true" title="{{ __('Click To Edit') }}">${subItemName}</td><input type="hidden" class="text-input-hidden" name="financialStatementAbleItemName[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]" value="${subItemName}">`;
                            dates.forEach(function(date) {
                                var currentValueIndex = valuesOfDates.findIndex((item) => item.date == date)
                                var currentValue = 0;
                                if (currentValueIndex >= 0) {
                                    var currentValue = valuesOfDates[currentValueIndex].value;
                                }
                                row += `<td class="sub-numeric-bg text-nowrap editable editable-date date-${date}" data-income-statement-id="${incomeStatementId}" data-main-model-id="${incomeStatementId}" data-income-statement-item-id="${incomeStatementItemId}" data-main-row-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}" data-table-id="${tableId}" data-is-quantity="${isQuantity}" contenteditable="true" title="{{ __('Click To Edit') }}" data-percentage-value="${percentageValue}">${currentValue}</td>

								<input type="hidden" name="value[${incomeStatementId}][${incomeStatementItemId}][${subItemName}][${date}]" data-date="${date}" data-parent-model-id="${incomeStatementItemId}" value="${currentValue}">`;
                            })

                            row += `<td class="  sub-numeric-bg text-nowrap total-row" data-financial-statement-able-item-id="${incomeStatementItemId}" data-sub-item-name="${subItemName}">0</td>
										<input type="hidden" class="input-hidden-for-total" name="subTotals[${incomeStatementId}][${incomeStatementItemId}][${subItemName}]" data-parent-model-id="${incomeStatementItemId}" value="0">
										</tr>`;

                            return row;
                        }

                        function updateTotalForRow(row) {
                            const salesRevenueId = domElements.salesRevenueId
                            var total = 0;
                            row.querySelectorAll('input[data-date]').forEach(function(input, index) {
                                total += parseFloat(input.value);
                            });

                            if (row.getAttribute('data-model-id') == domElements.netProfitId) {
                                var earningBeforeTaxesTotalValue = parseFloat(document.querySelector('.main-with-no-child[data-financial-statement-able-item-id="' + domElements.earningBeforeTaxesId + '"] input.input-hidden-for-total').value)
                                var corporateTaxesTotalValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-financial-statement-able-item-id="' + domElements.corporateTaxesId + '"] input.input-hidden-for-total').value)
                                var totalOfNetProfit = earningBeforeTaxesTotalValue - corporateTaxesTotalValue;
                                row.querySelector('.input-hidden-for-total').value = totalOfNetProfit;
                                row.querySelector('td.total-row').innerHTML = number_format(totalOfNetProfit);
                            } else if (row.getAttribute('data-model-id') == domElements.corporateTaxesId) {
                                var earningBeforeTaxesTotalValue = parseFloat(document.querySelector('.main-with-no-child[data-financial-statement-able-item-id="' + domElements.earningBeforeTaxesId + '"] input.input-hidden-for-total').value)
                                row.querySelector('.input-hidden-for-total').value = earningBeforeTaxesTotalValue;
                                row.querySelector('td.total-row').innerHTML = number_format(earningBeforeTaxesTotalValue);
                            } else {
                                row.querySelector('.input-hidden-for-total').value = total;
                                row.querySelector('td.total-row').innerHTML = number_format(total);

                            }
                        }
                        $(document).on('focus', '.editable-date', function() {
                            lastInputValue = $(this).html()
                            $(this).html('<br>')
                        })

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
                            console.log(changedInputs)

                            for (var i = 0; i < changedInputs.length; i++) {
                                changedInputs[i].dispatchEvent(new Event('change', {
                                    'bubbles': true
                                }))
                            }

                        });

                        function updateGrowthRateForSalesRevenue(currentDate) {
                            let dates = getDates();

                            let previousDate = getPreviousDate(dates, currentDate);
                            if (previousDate) {
                                let salesRevenueId = domElements.salesRevenueId;
                                let salesGrowthRateId = domElements.salesGrowthRateId;
                                let currentTotalSalesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] ' + 'input[data-date="' + currentDate + '"]').value);
                                let previousTotalSalesRevenueValue = parseFloat(document.querySelector('.is-main-with-sub-items[data-model-id="' + salesRevenueId + '"] ' + 'input[data-date="' + previousDate + '"]').value);
                                var salesRevenueGrowthRate = 0;
                                if (previousTotalSalesRevenueValue) {
                                    salesRevenueGrowthRate = currentTotalSalesRevenueValue ? ((currentTotalSalesRevenueValue - previousTotalSalesRevenueValue) / previousTotalSalesRevenueValue) * 100 : 0;
                                }
                                var input = document.querySelector('.main-with-no-child[data-model-id="' + salesGrowthRateId + '"] ' + 'input[data-date="' + currentDate + '"]');
                                if (input) {
                                    input.value = salesRevenueGrowthRate;
                                    input.dispatchEvent(new Event('change', {
                                        'bubbles': true
                                    }))
                                    document.querySelector('.main-with-no-child[data-model-id="' + salesGrowthRateId + '"] ' + 'td.date-' + currentDate).innerHTML = number_format(salesRevenueGrowthRate, 2) + ' %';

                                }

                            }

                            return number_format(0, 2) + ' %';


                        }

                        function getPreviousDate(dates, currentDate) {
                            let index = dates.indexOf(currentDate);
                            if (index == 0) {
                                return null;
                            }
                            return dates[index - 1];

                        }

                        function getDates() {
                            var dates = "{{ json_encode(array_keys($incomeStatement->getIntervalFormatted())) }}";
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

                        function updateEditableInputs(tdElement) {
                            var inputs = []
                            let reportType = vars.subItemType;
                            let financialStatementAbleItemId = tdElement.closest('tr').getAttribute('data-financial-statement-able-item-id');
                            let corporateTaxesId = domElements.corporateTaxesId;
                            let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                            let salesRevenueId = domElements.salesRevenueId;
                            let firstDateString = $(tdElement).attr("class").split(/\s+/).filter(function(classItem) {
                                return classItem.startsWith('date-');
                            })[0];
                            if (firstDateString) {
                                var firstDate = firstDateString.split('date-')[1]
                                var value = tdElement.innerHTML.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "");
                                var input = tdElement.parentElement.querySelector('input[data-date="' + firstDate + '"]');
                                input.value = value;
                                let is_repeating_fixed = tdElement.closest('tr').getAttribute('data-is-repeating-fixed');
                                is_repeating_fixed = is_repeating_fixed == 'true' || is_repeating_fixed == 1;

                                let is_percentage = tdElement.closest('tr').getAttribute('data-is-percentage');
                                is_percentage = is_percentage == 'true' || is_percentage == 1
                                let is_percentage_or_fixed = tdElement.closest('tr').getAttribute('data-can-be-percentage-or-fixed');
                                is_percentage_or_fixed = is_percentage_or_fixed == 'true' || is_percentage_or_fixed == 1;
                                let currentVal = tdElement.innerHTML.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "").replace(/[%]/g, '');
                                currentVal = parseFloat(currentVal);
                                inputs.push(input)
                                if (is_percentage_or_fixed && is_repeating_fixed) {

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
                                            // input.dispatchEvent(new Event('change', {
                                            //     'bubbles': true
                                            // }));


                                            inputs.push(input)

                                        })

                                        return inputs


                                    }
                                }

                                if (is_percentage_or_fixed && is_percentage) {
                                    // ?? 
                                    if (financialStatementAbleItemId != corporateTaxesId) {
                                        currentVal = tdElement.getAttribute('data-percentage-value')
                                    }

                                    // end of ?? 
                                    var percentage_of_array = tdElement.closest('tr').getAttribute('data-is-percentage-of');

                                    if (!Array.isArray(percentage_of_array)) {
                                        percentage_of_array = percentage_of_array ? percentage_of_array.replace(/\[|\]/g, '').split(',') : [];
                                    }
                                    var salesRevenueRowId = domElements.salesRevenueId;
                                    if (percentage_of_array && percentage_of_array.length) {
                                        var loopDates;
                                        loopDates = inAddOrEditModal ? dates : [firstDate];
                                        if (reportType == 'modified') {
                                            loopDates = getDatesLargerThanDate(firstDate, dates)
                                        }
                                        var total = 0;
                                        var percentageElementId = financialStatementAbleItemId == corporateTaxesId ? earningBeforeTaxesId : salesRevenueRowId;
                                        loopDates.forEach((currentDate) => {
                                            total = 0;
                                            percentage_of_array.forEach(function(subItemName) {

                                                var valOfCurrentSubItem = 0;
                                                if (financialStatementAbleItemId == corporateTaxesId) {
                                                    valOfCurrentSubItem = parseFloat(document.querySelector('input[data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value);
                                                    if (valOfCurrentSubItem < 0) {
                                                        valOfCurrentSubItem = 0;
                                                    }
                                                } else {
                                                    valOfCurrentSubItem = document.querySelector('tr[data-sub-item-name=' + subItemName + '] input[type="hidden"][data-parent-model-id="' + percentageElementId + '"][data-date="' + currentDate + '"]').value;
                                                }
                                                total += parseFloat(valOfCurrentSubItem);

                                            });

                                            currentVal = inAddOrEditModal ? currentVal : parseFloat(tdElement.getAttribute('data-percentage-value'));

                                            currentValue = total ? currentVal / 100 * total : 0;
                                            tdElement.closest('tr').querySelector('td.editable-date.date-' + currentDate).innerHTML = number_format(currentValue, 2);
                                            var input = tdElement.closest('tr').querySelector('input[data-date][data-date="' + currentDate + '"]')
                                            input.value = currentValue
                                            inputs.push(input)

                                        })
                                        return inputs
                                    }

                                } else {
                                    var val = tdElement.innerHTML.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "").replace(/[%]/g, '');
                                    var input = tdElement.parentElement.querySelector('input[data-date="' + firstDate + '"]')
                                    input.value = val
                                    inputs.push(input)
                                    return inputs
                                }


                            } else {
                                var val = tdElement.innerHTML.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "");
                                var input = tdElement.parentElement.querySelector('input.text-input-hidden')
                                input.value = val
                                inputs.push(input)
                                return inputs

                            }
                            $('.main-table-class').DataTable().columns.adjust();

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

                        $(document).on('click', '.can_be_percentage_or_fixed_class', function() {
                            let val = $(this).val();
                            $(this).closest('.how-many-item').find('.non-repeating-fixed-sub,.repeating-fixed-sub,.percentage-sub').removeClass('d-flex').addClass('d-none');
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
                                $('.main-table-class').DataTable().columns.adjust();
                            } else if (!subRows.length) {
                                // if parent row has no sub rows then remove + or - 
                                parentRow.find('td.trigger-child-row-1').html('×');
                            } else {
                                parentRow.find('td.trigger-child-row-1').addClass('is-open').removeClass('is-close').html('-');
                                $('.main-table-class').DataTable().columns.adjust();

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

                                    var tableId = '#' + "{{ $tableId }}";
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
                                        , className: 'trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize is-close text-nowrap'
                                        , render: function(d, b, row) {
                                            if (!row.isSubItem && row.has_sub_items) {

                                                return '+';
                                            } else if (row.isSubItem && row.pivot && row.pivot.can_be_percentage_or_fixed) {
                                                return row.pivot.percentage_or_fixed.replaceAll(/[_]/g, ' ')
                                            }
                                            return '';
                                        }
                                    });
                                    columns.push({
                                        render: function(d, b, row) {
                                            let modelId = $('#model-id').val();



                                            if (!row.isSubItem && row.has_sub_items) {
                                                elements = `<a data-is-subitem="0" data-income-statement-item-id="${row.id}" data-income-statement-id="${modelId}" class="d-block add-btn mb-2" href="#" data-toggle="modal" data-target="#add-sub-modal${row.id}">{{ __('Add') }}</a> `;
                                                if (row.sub_items.length) {}
                                                return elements;
                                            } else if (row.isSubItem && (row.pivot.created_from == row.pivot.sub_item_type)) {
                                                return `
											<div class="d-flex align-items-center justify-content-between">
												<a  data-is-subitem="1" data-income-statement-item-id="${row.pivot.financial_statement_able_item_id}" data-income-statement-id="${row.pivot.financial_statement_able_id}" class="d-block edit-btn mb-2 text-white " href="#" data-toggle="modal" data-is-depreciation-or-amortization="${row.pivot.is_depreciation_or_amortization}" data-income-statement-id="${row.pivot.financial_statement_able_id}" data-target="#edit-sub-modal${row.pivot.financial_statement_able_item_id + row.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-') }"> <i class="fa fa-pen-alt"></i>  </a> <a data-income-statement-item-id="${row.pivot.financial_statement_able_item_id}" data-income-statement-id="${row.pivot.financial_statement_able_id}" class="d-block  delete-btn text-white mb-2 text-danger" href="#" data-toggle="modal" data-target="#delete-sub-modal${row.pivot.financial_statement_able_item_id + row.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-') }">
													<i class="fas fa-trash-alt"></i>
													
													</a>
													</div>
											`
                                            }
                                            return '';
                                        }
                                        , data: 'id'
                                        , className: 'cursor-pointer sub-text-bg '
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
                                        , className: 'sub-text-bg text-nowrap editable editable-text is-name-cell'
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
                                            , className: 'sub-numeric-bg text-nowrap editable editable-date date-' + data[i]

                                        });




                                    }

                                    columns.push({
                                        render: function(d, b, row, setting) {
                                            var subTotal = row.main_rows && row.main_rows[0] ? row.main_rows[0].pivot.total : 0
                                            return subTotal;

                                        }
                                        , data: 'id'
                                        , className: 'sub-numeric-bg text-nowrap total-row'

                                    })



                                    // begin first table
                                    table.DataTable({


                                            dom: 'Bfrtip',
                                            // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                            "ajax": {
                                                "url": "{{ $getDataRoute }}"
                                                , "type": "post"
                                                , "dataSrc": "data", // they key in the jsom response from the server where we will get our data
                                                "data": function(d) {
                                                    d.search_input = $(getSearchInputSelector(tableId)).val();
                                                    d.sub_item_type = $('#sub-item-type').val()
                                                }

                                            }
                                            , "processing": false
                                            , "scrollX": true
                                            , "ordering": false
                                            , 'paging': false
                                            , "fixedColumns": {
                                                left: getFixedColumnNumbers()
                                            }
                                            , "serverSide": true
                                            , "responsive": false
                                            , "pageLength": 25
                                            , "columns": columns
                                            , columnDefs: [{
                                                targets: 0
                                                , defaultContent: 'salah'
                                                , className: 'red reset-table-width'
                                            }]
                                            , buttons: [{
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<svg style="margin-right:10px;position:relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"/></g></svg>' + '{{ __("Analysis") }}'
                                                    , 'className': 'btn btn-bold btn-secondary filter-table-btn  flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away'
                                                    , "action": function() {
                                                        window.location.href = "{{ route('dashboard.breakdown.incomeStatement',[$company->id,$reportType,$incomeStatement->id]) }}"
                                                    }
                                                },

                                                {
                                                    "attr": {
                                                        'data-table-id': tableId.replace('#', ''),
                                                        // 'id':'test'
                                                    }
                                                    , "text": '<svg style="margin-right:10px;position:relative;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"/></g></svg>' + '{{ __("Interval View") }}'
                                                    , 'className': 'btn btn-bold btn-secondary filter-table-btn ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away'
                                                    , "action": function() {
                                                        $('#filter_form-for-' + tableId.replace('#', '')).toggleClass('d-none');
                                                    }
                                                }
                                                , {
                                                    "text": '<svg style="margin-right:10px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="bound" x="0" y="0" width="24" height="24"/><path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" id="Path-103" fill="#000000" fill-rule="nonzero" opacity="0.3"/><rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="2" width="2" height="12" rx="1"/><path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" id="Path-104" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000) "/></g></svg>' + '{{ __("Export") }}'
                                                    , 'className': 'btn btn-bold btn-secondary  flex-1 flex-grow-0 btn-border-radius ml-2 do-not-close-when-click-away'
                                                    , "action": function() {
                                                        let form = $('form#store-report-form-id');
                                                        let oldFormAction = form.attr('action');
                                                        let exportFormAction = "{{ route('admin.export.income.statement.report',$company->id) }}";
                                                        form.attr('action', exportFormAction);
                                                        form.submit();
                                                        form.attr('action', oldFormAction);

                                                        // $('#export_form-for-'+tableId.replace('#','')).toggleClass('d-none');
                                                    }
                                                },

                                            ]
                                            , createdRow: function(row, data, dataIndex, cells) {

                                                let reportType = vars.subItemType;
                                                let salesGrowthRateId = domElements.salesGrowthRateId;
                                                let costOfGoodsId = domElements.costOfGoodsId;
                                                let corporateTaxesId = domElements.corporateTaxesId;
                                                let salesReveueId = domElements.salesRevenueId;
                                                if (data.id == salesReveueId) {
                                                    sales_revenues_sub_items_names = [];
                                                    data.sub_items.forEach(function(subItemParent) {
                                                        if (subItemParent.pivot.is_quantity == 0) {
                                                            sales_revenues_sub_items_names.push(subItemParent.pivot.sub_item_name)
                                                        }
                                                    });
                                                    window['sales_revenues_sub_items_names'] = sales_revenues_sub_items_names;
                                                }
                                                if (data.id == costOfGoodsId) {
                                                    cost_of_goods_sub_items_names = [];
                                                    data.sub_items.forEach(function(subItemParent) {
                                                        if (subItemParent.pivot.is_quantity == 0) {
                                                            cost_of_goods_sub_items_names.push(subItemParent.pivot.sub_item_name)
                                                        }
                                                    });
                                                    window['cost_of_goods_sub_items_names'] = cost_of_goods_sub_items_names;
                                                }
                                                var totalOfRowArray = [];

                                                var incomeStatementId = data.isSubItem ? data.pivot.financial_statement_able_id : $('#model-id').val();
                                                var incomeStatementItemId = data.isSubItem ? data.pivot.financial_statement_able_item_id : data.id;
                                                var subItemName = data.isSubItem ? data.pivot.sub_item_name : '';
                                                let is_quantity = false;

                                                $(cells).filter(".editable").attr('contenteditable', true)
                                                    .attr('data-income-statement-id', incomeStatementId)
                                                    .attr('title', "{{ __('Click To Edit') }}")
                                                    .attr('data-main-model-id', incomeStatementId)
                                                    .attr('data-income-statement-item-id', incomeStatementItemId)
                                                    .attr('data-financial-statement-able-item-id', incomeStatementItemId)
                                                    .attr('data-main-row-id', incomeStatementItemId)
                                                    .attr('data-sub-item-name', subItemName)
                                                    .attr('data-table-id', "{{$tableId}}")
                                                    .attr('data-is-quantity', data.isSubItem ? data.pivot.is_quantity : false)
                                                    .attr('data-percentage-value', data.isSubItem && data.pivot.percentage_or_fixed == 'percentage' ? data.pivot.percentage_value : -1)
                                                if (data.isSubItem) {




                                                    let has_percentage_or_fixed_sub_items = '';

                                                    if (data.pivot.can_be_percentage_or_fixed && reportType != 'actual') {
                                                        sub_items_options = '';
                                                        var checkedPercentages = [];
                                                        if (data.pivot.percentage_value) {
                                                            checkedPercentages = JSON.parse(data.pivot.is_percentage_of);
                                                        }
                                                        if (data.pivot.financial_statement_able_item_id == corporateTaxesId) {
                                                            sub_items_options = '<option selected value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'

                                                        } else {
                                                            window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                                var isCurrentChecked = checkedPercentages.includes(MainItemObject) ? ' selected' : ' ';
                                                                sub_items_options += '<option ' + isCurrentChecked + ' value="' + MainItemObject + '">' + MainItemObject + '</option>'
                                                            })
                                                        }

                                                        var nonRepeatingFixedisChecked = '';
                                                        var repeatingFixedisChecked = '';
                                                        var percentageisChecked = '';
                                                        var nonRepeatingFixedDisplay = 'd-none';
                                                        var repeatingFixedDisplay = 'd-none';
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

                                                        }

                                                        var repeating = `<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label >{{ __('Non-Repeating Fixed Amount') }}</label>
															
															<input ${nonRepeatingFixedisChecked} class="can_be_percentage_or_fixed_class non-repeating-fixed" type="checkbox" value="non_repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
															</div>
															</div>
															<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label >{{ __('Repeating Fixed Amount') }}</label>
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

                                                        has_percentage_or_fixed_sub_items =
                                                            `
															<br>
															<div class="flex-checkboxes how-many-item" data-id="0">
																<div class="form-check mt-2">
															
															${repeating}
															
														<div class="form-group custom-divs-class">
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																<label >{{ __('% Of Sales') }}</label>
															<input ${percentageisChecked} class="can_be_percentage_or_fixed_class percentage-of-sales" type="checkbox" value="percentage" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
															
															</div>
															
															<div class="non-repeating-fixed-sub ${nonRepeatingFixedDisplay}">
															</div>
															<div class="repeating-fixed-sub ${repeatingFixedDisplay}">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label class="form-label flex-self-start">{{ __('Amount') }}</label>
																	<input type="text" class="form-control" name="sub_items[0][repeating_fixed_value]" value="${data.pivot.repeating_fixed_value ? data.pivot.repeating_fixed_value : 0}">
																</div>
															</div>
															
															<div class="percentage-sub ${percentageDisplay}">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																		<label class="form-label flex-self-start">{{ __('% Of') }}</label>
																	
																	<select multiple
																class="form-select select select2-select sub_select" data-actions-box="true"  name="sub_items[0][is_percentage_of][]">
																	${sub_items_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																		<label class="flex-self-start">{{ __('Percentage Value') }}</label>
																		<div>
																			<input value="${data.pivot.percentage_value?data.pivot.percentage_value:0}" type="text" class="form-control" name="sub_items[0][percentage_value]"
																			</div>	
																	</div>
															</div>
															
															
															<input type="hidden" name="sub_items[0][can_be_percentage_or_fixed]" value="1">
																</div>`;



                                                    }

                                                    let Depreciation = '';

                                                    var quantity = '';
                                                    if (data.pivot && data.pivot.can_be_quantity) {
                                                        let checkedQuantity = '';
                                                        if (data.pivot.is_quantity) {
                                                            checkedQuantity = ' checked ';
                                                        }
                                                        quantity = `
   				         					<label>{{ __('Is Qauntity ? ') }}</label>
                            
                           				 <input ${checkedQuantity} class="" type="checkbox" value="1" name="is_quantity"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">`
                                                    }
                                                    if (data.pivot && data.pivot.can_be_depreciation) {
                                                        let checkedDepreciation = '';
                                                        if (data.pivot.is_depreciation_or_amortization) {
                                                            checkedDepreciation = ' checked ';
                                                        }
                                                        Depreciation = `
								<label>{{ __('Is Depreciation Or Amortization ? ') }}</label>
									
									<input ${checkedDepreciation} class="" type="checkbox" value="1" name="is_depreciation_or_amortization"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">`
                                                    }

                                                    $(row).append(
                                                        `
                            
                            
									<div class="modal fade" id="edit-sub-modal${data.pivot.financial_statement_able_item_id + data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-')}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content modal-xl">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Sub Item For') }} ${data.pivot.sub_item_name} </h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form data-financial-statement-able-item-id="${data.pivot.financial_statement_able_item_id}" id="edit-sub-item-form${data.pivot.financial_statement_able_item_id + data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-')  }" class="edit-submit-sub-item" action="{{ route('admin.update.income.statement.report',['company'=>getCurrentCompanyId()]) }}">
														<input type="hidden" name="sub_item_type" value="{{ getReportNameFromRouteName(Request()->route()->getName()) }}">
														<input type="hidden" name="financial_statement_able_item_id"  value="${data.pivot.financial_statement_able_item_id}">
														<input  type="hidden" name="financial_statement_able_id"  value="{{ $incomeStatement->id }}">
														<input  type="hidden" name="sub_item_name"  value="${data.pivot.sub_item_name}">
														<label>{{ __('name') }}</label>
														<input name="new_sub_item_name"  class="form-control   only-greater-than-zero-allowed mb-2" type="text" value="${data.pivot.sub_item_name}">
														${Depreciation}
														${quantity}
														${has_percentage_or_fixed_sub_items}
													<div class="mt-2">
														<label>{{ __('Sub Of') }}</label>
														<select  name="sub_of_id" class="form-control main-row-select" data-selected-main-row="${data.pivot.financial_statement_able_item_id}">
															
														</select>
														</div>
													
													</form>
												</div>
												<div class="modal-footer" style="border-top:0 !important">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')  }}</button>
													<button type="button" class="btn btn-primary save-sub-item-edit" data-id="${data.pivot.financial_statement_able_item_id}" data-sub-item-name="${data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-') }">{{ __('Edit') }}</button>
												</div>
												</div>
											</div>
												</div>
												`
                                                    )


                                                    $(row).append(
                                                        `
                            
                            
											<div class="modal fade" id="delete-sub-modal${data.pivot.financial_statement_able_item_id + data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-')}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content ">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLongTitle">{{ __('Delete Sub Item ') }} ${data.pivot.sub_item_name} </h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<form id="delete-sub-item-form${data.pivot.financial_statement_able_item_id+data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-') }" class="delete-submit-sub-item" action="{{ route('admin.destroy.income.statement.report',['company'=>getCurrentCompanyId()]) }}">
																<input type="hidden" name="sub_item_type" value="{{ getReportNameFromRouteName(Request()->route()->getName()) }}">
																
																<input type="hidden" name="financial_statement_able_item_id"  value="${data.pivot.financial_statement_able_item_id}">
																<input  type="hidden" name="financial_statement_able_id"  value="{{ $incomeStatement->id }}">
																<input  type="hidden" name="sub_item_name"  value="${data.pivot.sub_item_name}">
																<p>{{ __('Are You Sure To Delete ') }} ${data.pivot.sub_item_name}  ? </p>
															
															
															</form>
														</div>
														<div class="modal-footer" style="border-top:0 !important">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')  }}</button>
															<button type="button" class="btn btn-primary save-sub-item-delete" data-id="${data.pivot.financial_statement_able_item_id}" data-sub-item-name="${data.pivot.sub_item_name.replaceAll('/','-').replaceAll('&','-').replaceAll('%','-').replaceAll(' ','-').replaceAll('(','-').replaceAll(')','-') }" >{{ __('Delete') }}</button>
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

                                                    if (data.pivot.can_be_percentage_or_fixed) {
                                                        $(row).attr('data-can-be-percentage-or-fixed', data.pivot.can_be_percentage_or_fixed)
                                                        $(row).attr('data-is-percentage-of', data.pivot.is_percentage_of)
                                                        $(row).attr('data-percentage-or-fixed', data.pivot.percentage_or_fixed)
                                                        $(row).attr('data-is-percentage', data.pivot.percentage_or_fixed == 'percentage')
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
                                                        totalOfRowArray.push(parseFloat($(dateDt).html().replace(/(<([^>]+)>)/gi, "").replace(/,/g, "")));


                                                        var hiddenInput = `<input type="hidden" name="value[${incomeStatementId}][${incomeStatementItemId}][${subItemName}][${filterDate}]" data-date="${filterDate}" data-parent-model-id="${incomeStatementItemId}" value="${($(dateDt).html().replace(/(<([^>]+)>)/gi, "").replace(/,/g, ""))}" > `;
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

                                                            var hiddenInput = `<input type="hidden" name="valueMainRowWithoutSubItems[${incomeStatementId}][${incomeStatementItemId}][${filterDate}]" data-date="${filterDate}" data-parent-model-id="${incomeStatementItemId}" value="${($(dateDt).html().replace(/(<([^>]+)>)/gi, "").replace(/,/g, ""))}" > `;
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
                                                            totalOfRowArray.push(parseFloat($(dateDt).html().replace(/(<([^>]+)>)/gi, "").replace(/,/g, "")));

                                                            var hiddenInput = `<input type="hidden" class="main-row-that-has-sub-class" name="valueMainRowThatHasSubItems[${incomeStatementId}][${incomeStatementItemId}][${filterDate}]" data-date="${filterDate}" data-parent-model-id="${incomeStatementItemId}" value="${($(dateDt).html().replace(/(<([^>]+)>)/gi, "").replace(/,/g, ""))}" > `;
                                                            $(dateDt).after(hiddenInput);
                                                        });
                                                        var subTotal = data.main_rows && data.main_rows[0] ? data.main_rows[0].pivot.total : 0

                                                        $(row).append(
                                                            `<input type="hidden" class="input-hidden-for-total" name="totals[${incomeStatementId}][${incomeStatementItemId}]"  data-parent-model-id="${incomeStatementItemId}" value="${subTotal}" >`
                                                        );

                                                        $(cells).each(function(index, cell) {
                                                            $(cell).removeClass('editable').removeClass('editable-text').attr('contenteditable', false).attr('title', '')
                                                        });

                                                        let has_percentage_or_fixed_sub_items = '';

                                                        if (data.has_percentage_or_fixed_sub_items && reportType != 'actual') {
                                                            sub_items_options = '';
                                                            let corporateTaxesId = $('#corporate-taxes-id').val();

                                                            if (data.id == corporateTaxesId) {
                                                                sub_items_options = '<option value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'
                                                            } else {
                                                                window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                                    sub_items_options += '<option value="' + MainItemObject + '">' + MainItemObject + '</option>'
                                                                })

                                                            }
                                                            var hideRepeating = false;

                                                            if (parseInt(data.id) == parseInt(corporateTaxesId.trim())) {
                                                                hideRepeating = true
                                                            }
                                                            var repeating = `<div class="form-group custom-divs-class">
															
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label >{{ __('Non-Repeating Fixed Amount') }}</label>
															
															<input class="can_be_percentage_or_fixed_class non-repeating-fixed" type="checkbox" value="non_repeating_fixed" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">	
															</div>
															</div>
															<div class="form-group custom-divs-class">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label >{{ __('Repeating Fixed Amount') }}</label>
																	
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
															<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																<label >{{ __('% Of Sales') }}</label>
															<input class="can_be_percentage_or_fixed_class percentage-of-sales" type="checkbox" value="percentage" name="sub_items[0][percentage_or_fixed]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															</div>
															</div>
															
															</div>
															
															<div class="non-repeating-fixed-sub d-none">
															</div>
															<div class="repeating-fixed-sub d-none">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<label class="form-label flex-self-start">{{ __('Amount') }}</label>
																	<input type="text" class="form-control" name="sub_items[0][repeating_fixed_value]" value="0">
																</div>
															</div>
															
															<div class="percentage-sub d-none">
																<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																		<label class="form-label flex-self-start">{{ __('% Of') }}</label>
																	
																	<select multiple
																class="form-select select select2-select sub_select" data-actions-box="true"  name="sub_items[0][is_percentage_of][]">
																	${sub_items_options}
																</select>
																	</div>
																	</div>
																	<div class="d-flex flex-column align-items-center justify-content-center flex-wrap">
																		<label class="flex-self-start">{{ __('Percentage Value') }}</label>
																		<div>
																			<input type="text" class="form-control" name="sub_items[0][percentage_value]"
																			</div>	
																	</div>
															</div>
															<input type="hidden" name="sub_items[0][can_be_percentage_or_fixed]" value="1">
																</div>
															`;
                                                        }

                                                        let quantityCheckbox = '';

                                                        quantityCheckbox = `<div class="form-check mt-2">
															<label class="form-check-label"  style="margin-top:3px" >
																{{ __('Add Quantity') }}
															</label>

															<input class="" type="checkbox" value="1" name="sub_items[0][is_quantity]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															<input class="" type="hidden" value="1" name="sub_items[0][can_be_quantity]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
															
															`;
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
											<div >
													<label class="form-label">{{ __('Name') }}</label>
													<input  name="sub_items[0][name]" type="text" value="" class="form-control  " required>
												</div>
												<div class="form-check mt-2 text-center ">
												<label class="form-check-label"  style="margin-top:3px;display:block" >
													{{ __('Is Depreciation Or Amortization ?') }}
												</label>

												<input class="" type="checkbox" value="1" name="sub_items[0][is_depreciation_or_amortization]"  style="width:16px;height:16px;margin-left:-0.05rem;left:50%;">
												</div>
												` + has_percentage_or_fixed_sub_items + `
												</div>
															</div> `;
                                                        } else {
                                                            if (data.id == domElements.financialIncomeOrExpensesId) {
                                                                quantityCheckbox = ''
                                                                increaseNameWidth = true
                                                            }
                                                            nameAndDepreciationIfExist = ` <div class="append-names mt-2" data-id="${data.id}">

															<div class="form-group how-many-item d-flex flex-wrap text-nowrap justify-content-between align-items-center border-bottom-popup" data-id="${data.id}" data-index="0">
																<div class="${increaseNameWidth ? 'width-66' : ''}"><label class="form-label">{{ __('Name') }}</label>
																<input name="sub_items[0][name]" type="text" value="" class="form-control" required></div>
																` + quantityCheckbox + `
																` + has_percentage_or_fixed_sub_items + `
															</div>
														</div> `;

                                                        }
                                                        $(row).addClass('edit-info-row').addClass('add-sub maintable-1-row-class' + (data.id)).attr('data-model-id', data.id).attr('data-model-name', '{{ $modelName }}')
                                                            .append(`
                    <div class="modal fade" id="add-sub-modal${data.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-xl">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Sub Item For') }} ${data.name} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  data-financial-statement-able-item-id="${data.id}" id="add-sub-item-form${data.id}" class="submit-sub-item" action="{{ route('admin.store.income.statement.report',['company'=>getCurrentCompanyId()]) }}">
            
            <label class="label ">{{ __('How Many Items ?') }}</label>
			<input type="hidden" name="sub_item_type" value="{{ getReportNameFromRouteName(Request()->route()->getName()) }}">
            <input type="hidden" name="financial_statement_able_item_id"  value="${data.id}">
            <input  type="hidden" name="financial_statement_able_id"  value="{{ $incomeStatement->id }}">

            <input data-id="${data.id}" class="form-control how-many-class only-greater-than-zero-allowed" name="how_many_items" type="number" value="1">
          
           ${nameAndDepreciationIfExist}
		
        </form>
      </div>
      <div class="modal-footer" style="border-top:0 !important">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')  }}</button>
        <button type="button" class="btn btn-primary save-sub-item" data-redirect-to='' data-id="${data.id}">{{ __('Save') }}</button>
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
                                                let corporateTaxesId = document.getElementById('corporate-taxes-id').value;
                                                $('tr[data-percentage-or-fixed="percentage"] td.editable').attr('contenteditable', false).attr('title', '');


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

                                                reinitializeSelect2();

                                                // handle data for intervals 
                                            }
                                            , initComplete: function(settings, json) {

                                                var reportType = vars.subItemType;
                                                let actualDates = [];
                                                // alert($('.dataTables_scrollHeadInner .main-table-class:eq(0) th.is-actual').length)
                                                // alert(document.querySelectorAll('.dataTables_scrollHeadInner .main-table-class:first-of-type th.is-actual').length)
                                                document.querySelectorAll('.dataTables_scrollHeadInner .main-table-class:first-of-type th.is-actual').forEach(function(th, index) {
                                                    if (!actualDates.includes($(th).data('date'))) {
                                                        actualDates.push($(th).data('date'));
                                                    }
                                                })

                                                if (reportType == 'actual') {
                                                    const table = $('.main-table-class').DataTable();
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
                                                    const table = $('.main-table-class').DataTable();
                                                    table.column(1).visible(false);
                                                    $('.kt-portlet__foot').css('display', 'none');
                                                    $('#store-report-form-id .kt-portlet').append(`<div class='single-btn'><button style="float:right" type="submit" class="btn active-style redirect-btn" data-redirect-to="{{ route('admin.view.financial.statement',getCurrentCompanyId()) }}"> Back To Financial Statement </button></div>`);
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
                                                    const table = $('.main-table-class').DataTable();
                                                    table.column(1).visible(false);
                                                    document.querySelectorAll('.is-name-cell[contenteditable]').forEach(function(td, index) {
                                                        td.setAttribute('contenteditable', false);
                                                        td.setAttribute('title', '')
                                                    })
                                                    actualDates.forEach(function(actualDate) {
                                                        // $('.dataTables_scrollHead .main-table-class th.header-th[data-date="' + actualDate + '"]').append('<span> <br> {{ __("(Actual)") }} </span>');
                                                        document.querySelectorAll('.editable-date.date-' + actualDate).forEach(function(td, index) {
                                                            td.setAttribute('contenteditable', false);
                                                            td.setAttribute('title', '')
                                                        })
                                                    })
                                                }

                                                $('.main-table-class').DataTable().columns.adjust();
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

                            $(document).on('click', '.save-sub-item', function(e) {
                                const salesRevenueId = domElements.salesRevenueId
                                const salesRevenueSubItem = window['sales_revenues_sub_items_names'].length ? window['sales_revenues_sub_items_names'][0] : null

                                const costOfGoodsId = domElements.costOfGoodsId
                                const costOfGoodsSubItem = window['cost_of_goods_sub_items_names'].length ? window['cost_of_goods_sub_items_names'][0] : null


                                let submitBtn = $(this);
                                submitBtn.attr('disabled', true);

                                e.preventDefault();
                                inAddOrEditModal = true;
                                let id = $(this).data('id');
                                let form = document.getElementById('add-sub-item-form' + id);
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
                                    for (date of dates) {
                                        // do not update anything if you add sales renuve sub item because it will be 0 anyway
                                        if (id != salesRevenueId) {
                                            inAddOrEditModal = false
                                            var updateElement = updateCurrentRow ? triggerBlurForEditableTd(date) : document.querySelector('.maintable-1-row-class' + updateRowId + '[data-sub-item-name="' + updateSubItem + '"] td.date-' + date)
                                            if (updateElement) {
                                                xyzz = true
                                                updateElement.dispatchEvent(new Event('blur', {
                                                    'bubbles': true
                                                }))
                                            }
                                        }

                                    }
                                    dataForm = document.getElementById('store-report-form-id');
                                    dataForm = new FormData(dataForm);
                                    for (var pair of formData.entries()) {
                                        dataForm.append(pair[0], pair[1]);
                                    }

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
                                            $('.main-table-class').DataTable().ajax.reload(null, false)
                                            if (res.status) {
                                                Swal.fire({
                                                    icon: 'success'
                                                    , title: res.message
                                                , })
                                            } else {
                                                submitBtn.attr('disabled', true);
                                                Swal.fire({
                                                    icon: 'error'
                                                    , title: res.message
                                                    , text: 'حدث خطا اثناء تنفيذ العملية'
                                                })
                                            }
                                        }
                                        , error: function(res) {
                                            submitBtn.attr('disabled', false);
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
                                            Swal.fire({
                                                icon: 'error'
                                                , title: "{{ __('Something Went Wrong') }}"
                                                , text: message,
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        }
                                    });
                                }
                                submitBtn.attr('disabled', false);

                                $('.append-table-into-dom').remove();

                                inAddOrEditModal = false;
                            });



                            $(document).on('click', '.save-sub-item-edit', function(e) {
                                e.preventDefault();
                                inAddOrEditModal = true;
                                const btn = $(this);
                                btn.prop('disabled', true);
                                let id = $(this).data('id');
                                let subItemName = $(this).data('sub-item-name');
                                let form = document.getElementById('edit-sub-item-form' + id + subItemName);
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
                                    var is_non_repeating_fixed = percentage_or_fixed == 'non_repeating_fixed';
                                    var is_repeating_fixed = percentage_or_fixed == 'repeating_fixed';
                                    var is_percentage_of = is_percentage ? "[" + formDataObject['sub_items[0][is_percentage_of][]'].toString() + "]" : '';
                                    var percentage_value = is_percentage ? formDataObject['sub_items[0][percentage_value]'] : 0;
                                    var repeating_value = is_repeating_fixed ? formDataObject['sub_items[0][repeating_fixed_value]'] : 0;
                                    var tdValue = 0;
                                    if (is_percentage) {
                                        tdValue = percentage_value;
                                    } else if (is_repeating_fixed) {
                                        tdValue = repeating_value;
                                    }

                                    $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"]').attr('data-financial-statement-able-item-id', incomeStatementItemId).attr('data-is-percentage-of', is_percentage_of).attr('data-percentage-or-fixed', percentage_or_fixed).attr('data-is-percentage', is_percentage).attr('data-is-repeating-fixed', is_repeating_fixed).attr('data-is-none-repeating-fixed', is_non_repeating_fixed).attr('data-is-trigger-change', 'true');

                                    $('tr.maintable-1-row-class' + incomeStatementItemId + '[data-sub-item-name="' + oldSubItemName + '"] td.editable-date:eq(0)').html(number_format(tdValue)).trigger('blur');

                                }



                                // refresh formdata object 
                                formData = document.getElementById('edit-sub-item-form' + id + subItemName)
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
                                        $('.main-table-class').DataTable().ajax.reload(null, false)
                                        if (res.status) {

                                            Swal.fire({
                                                icon: 'success'
                                                , title: res.message,
                                                // text: 'تمت العملية بنجاح',
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
                                                , text: 'حدث خطا اثناء تنفيذ العملية',
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        }
                                    }
                                    , error: function(data) {
                                        // $(this).prop('disabled',false);

                                    }
                                });

                                inAddOrEditModal = false;
                            });




                            $(document).on('click', '.save-sub-item-delete', function(e) {
                                e.preventDefault();
                                let id = $(this).data('id');
                                let subItemName = $(this).data('sub-item-name');

                                $(this).prop('disabled', true);
                                document.querySelectorAll('tr[data-financial-statement-able-item-id="' + id + '"][data-sub-item-name="' + subItemName + '"] td.editable-date').forEach((editableDateTd) => {
                                    editableDateTd.innerHTML = 0
                                    editableDateTd.dispatchEvent(new Event('blur'));
                                })

                                let form = document.getElementById('delete-sub-item-form' + id + subItemName);

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

                                        $('.main-table-class').DataTable().ajax.reload(null, false)
                                        if (res.status) {

                                            Swal.fire({
                                                icon: 'success'
                                                , title: res.message,
                                                // text: 'تمت العملية بنجاح',
                                                // footer: '<a href="">Why do I have this issue?</a>'
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
                                                , text: 'حدث خطا اثناء تنفيذ العملية',

                                            })
                                        }
                                    }
                                    , error: function(data) {
                                        $(this).prop('disabled', false);

                                    }
                                });
                            });




                            $(document).on('change', '.main-with-no-child input', function(e) {

                                // console.log('with-no-child')

                                let rowId = this.getAttribute('data-parent-model-id');
                                const currentRow = this.closest('tr')
                                let grossProfitId = domElements.growthProfitId;
                                let earningBeforeInterestTaxesDepreciationAmortizationId = domElements.earningBeforeInterestTaxesDepreciationAmor;
                                let earningBeforeInterestTaxesId = domElements.earningBeforeInterestTaxesId;
                                let earningBeforeTaxesId = domElements.earningBeforeTaxesId;
                                let date = this.getAttribute('data-date');

                                if (rowId == grossProfitId) {
                                    updateEarningBeforeIntersetTaxesDepreciationAmortization(date);
                                    updateTotalForRow(currentRow);
                                    updatePercentageOfSalesFor(rowId, date);

                                } else if (rowId == earningBeforeInterestTaxesId) {
                                    updateEarningBeforeTaxes(date);
                                    updateTotalForRow(currentRow);
                                    updatePercentageOfSalesFor(rowId, date);
                                } else if (rowId == earningBeforeTaxesId) {
                                    updateNetProfit(date);
                                    updateTotalForRow(currentRow);
                                    updatePercentageOfSalesFor(rowId, date);

                                }

                            });



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
                                        $('.main-table-class').DataTable().ajax.reload(null, false)
                                        if (res.status) {
                                            if (redirectTo) {
                                                window.location.href = redirectTo;
                                            }
                                            Swal.fire({
                                                icon: 'success'
                                                , title: res.message
                                                , text: 'تمت العملية بنجاح'
                                            , }).then(function() {

                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error'
                                                , title: res.message
                                                , text: 'حدث خطا اثناء تنفيذ العملية'
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
                                        lastInstanceClone.find('input,select').each(function(i, v) {
                                            if ($(v).attr('type') == 'text') {
                                                $(v).val('');
                                            }
                                            if (v.tagName.toLowerCase() == 'select') {
                                                var name = $(v).attr('name').replace(lastItemIndex, lastItemIndex + 1);
                                                var sub_items_options = '';

                                                let corporateTaxesId = $('#corporate-taxes-id').val();

                                                if (financialStatementAbleItemId == corporateTaxesId) {
                                                    sub_items_options += '<option value="Earning Before Taxes - EBT" selected>Earning Before Taxes - EBT</option>'
                                                } else {
                                                    window['sales_revenues_sub_items_names'].forEach(function(MainItemObject) {
                                                        sub_items_options += '<option value="' + MainItemObject + '">' + MainItemObject + '</option>'
                                                    })
                                                }

                                                if (v.closest('.dropdown.bootstrap-select')) {
                                                    v.closest('.dropdown.bootstrap-select').outerHTML = `<select data-actions-box="true" multiple name="${name}" class="select select2-select ${name}"> ${sub_items_options} </select>`

                                                }

                                            } else {
                                                $(v).attr('name', $(v).attr('name').replace(lastItemIndex, lastItemIndex + 1));

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

                function updateAllMainsRowPercentageOfSales(dates = null) {
                    if (!dates) {
                        dates = "{{ json_encode(array_keys($incomeStatement->getIntervalFormatted())) }}";
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
                    const table = $('.main-table-class').DataTable();

                    const noCols = $('#cols-counter').data('value');
                    table.columns([...Array(noCols).keys()], false).visible(true);



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
                                    currentColumn = $('th.date-' + loopYear + '-' + removeMonth + '-' + currentDay);

                                    if ($('td.date-' + loopYear + '-' + loopMonth + '-' + currentDay).length) {
                                        if (!visiableHeaderDates.includes(loopYear + '-' + loopMonth + '-' + currentDay)) {
                                            visiableHeaderDates.push(loopYear + '-' + loopMonth + '-' + currentDay);
                                        }
                                        var tBodyLength = $('tbody tr').length
                                        for (rowId = 1; rowId <= tBodyLength; rowId++) {
                                            currentRow = $('tbody tr:nth-of-type(' + rowId + ')');
                                            var searchRowValue = -1;
                                            if (totalOfVisisableDates[rowId] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value']) {
                                                searchRowValue = totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value'];
                                            }



                                            if (searchRowValue >= 0) {
                                                var val = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                val = val ? val : 0;
                                                totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value'] += val;


                                            } else {
                                                var val = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                val = val ? val : 0;


                                                if (totalOfVisisableDates[rowId] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] && totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]) {

                                                    totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay] = {
                                                        value: val
                                                    }

                                                } else {
                                                    var val = 0;

                                                    if (!totalOfVisisableDates[rowId]) {


                                                        var val1 = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + loopMonth + '-' + currentDay + '"]').val());
                                                        val1 = val1 ? val1 : 0;

                                                        var val2 = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                        val2 = val2 ? val2 : 0;


                                                        val = val1 + val1;

                                                        totalOfVisisableDates[rowId] = {
                                                            [loopYear + '-' + loopMonth + '-' + currentDay]: {
                                                                value: val
                                                            }
                                                        }

                                                    } else {
                                                        var val1 = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + loopMonth + '-' + currentDay + '"]').val());
                                                        val1 = val1 ? val1 : 0;
                                                        var val2 = parseFloat($('tbody tr:nth-of-type(' + rowId + ') td.editable-date.date-' + loopYear + '-' + removeMonth + '-' + currentDay).parent().find('input[data-date="' + loopYear + '-' + removeMonth + '-' + currentDay + '"]').val());
                                                        val2 = val2 ? val2 : 0;
                                                        val = val1 + val2;

                                                        totalOfVisisableDates[rowId][
                                                            [loopYear + '-' + loopMonth + '-' + currentDay]
                                                        ] = {
                                                            value: val

                                                        }
                                                    }




                                                }

                                            }

                                            if (currentRow.hasClass('is-sales-rate')) {

                                                // do nothing
                                            } else {
                                                $('tbody tr:nth-of-type(' + rowId + ')').find('td.editable-date.date-' + loopYear + '-' + loopMonth + '-' + currentDay).html(number_format(totalOfVisisableDates[rowId][loopYear + '-' + loopMonth + '-' + currentDay]['value']));
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

        </x-slot>

    </x-tables.basic-view>
</div>
