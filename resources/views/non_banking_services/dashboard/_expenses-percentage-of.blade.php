@php
	$tableClasses = 'col-md-12';
@endphp
<x-tables.repeater-table :table-class="$tableClasses" :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
     <x-slot name="ths">
        <x-tables.repeater-table-th class="  header-border-down first-column-th-class max-250-w" :title="__('Item')"></x-tables.repeater-table-th>
        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
        <x-tables.repeater-table-th class="  header-border-down" :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
        @endforeach
    </x-slot>
    <x-slot name="trs">
		@if($isYearsStudy)
        <tr data-repeat-formatting-decimals="0" data-repeater-style>



            <td>
                <div class="max-w-255">
                    <input value="{{ __('Operating Months') }}" disabled class="form-control  text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;
            @endphp
            @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

            <td>
                <div class="form-group three-dots-parent">
                    <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                        <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="{{ sumNumberOfOnes($yearsWithItsMonths,$year,$datesIndexWithYearIndex) }}" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
                        <span class="ml-2">
                            <b style="visibility:hidden">%</b>
                        </span>
                    </div>
                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach


        </tr>
		@endif







        <tr data-repeat-formatting-decimals="2" data-repeater-style>


            @php
            $currentExpenseType = 'cost-of-service';

            @endphp
            <td>
                <div class="max-w-255">
                    <input value="{{ __('Cost Of Service % / REV') }}" disabled class="form-control   text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;


            @endphp
            @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
            @php
            $currentExpense = $formattedExpenses['cost-of-service']['total'][$yearOrMonthAsIndex]??0;
            $currentSalesRevenue = $formattedResult['sales_revenue'][$yearOrMonthAsIndex]??0 ;
            $currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
            @endphp
            <td>
                <div class="d-flex align-items-center justify-content-center">
                    <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach



        </tr>

        <tr data-repeat-formatting-decimals="2" data-repeater-style>



            <td>
                <div class="max-w-255">
                    <input value="{{ __('Other OPEX % / REV.') }}" disabled class="form-control text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;


            @endphp
            @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
            @php
            $currentExpense = $formattedExpenses['other-operation-expense']['total'][$yearOrMonthAsIndex]??0;
            $currentSalesRevenue = $formattedResult['sales_revenue'][$yearOrMonthAsIndex]??0 ;
            $currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;

            @endphp
            <td>
                <div class="d-flex align-items-center justify-content-center">
                    <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach



        </tr>







        <tr data-repeat-formatting-decimals="2" data-repeater-style>



            <td>
                <div class="max-w-255">
                    <input value="{{ __('Marketing Exp. % / REV.') }}" disabled class="form-control text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;

            @endphp
            @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

            @php
            $currentExpense = $formattedExpenses['marketing-expense']['total'][$yearOrMonthAsIndex]??0;
            $currentSalesRevenue = $formattedResult['sales_revenue'][$yearOrMonthAsIndex]??0 ;
            $currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
            @endphp
            <td>
                <div class="d-flex align-items-center justify-content-center">
                    <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach



        </tr>







        <tr data-repeat-formatting-decimals="2" data-repeater-style>



            <td>
                <div class="max-w-255">
                    <input value="{{ __('Sales Exp. % / REV.') }}" disabled class="form-control text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;

            @endphp
            @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
            @php
            $currentExpense = $formattedExpenses['sales-expense']['total'][$yearOrMonthAsIndex]??0;
            $currentSalesRevenue = $formattedResult['sales_revenue'][$yearOrMonthAsIndex]??0 ;
            $currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
            @endphp

            <td>
                <div class="d-flex align-items-center justify-content-center">
                    <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach



        </tr>








        <tr data-repeat-formatting-decimals="2" data-repeater-style>



            <td>
                <div class="max-w-255">
                    <input value="{{ __('G&A Exp. % / REV.') }}" disabled class="form-control text-left " type="text">
                </div>


            </td>
            @php
            $columnIndex = 0 ;
            @endphp
            @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
            @php
            $currentExpense = $formattedExpenses['general-expense']['total'][$yearOrMonthAsIndex]??0;
            $currentSalesRevenue = $formattedResult['sales_revenue'][$yearOrMonthAsIndex]??0 ;
            $currentVal = $currentSalesRevenue ? $currentExpense / $currentSalesRevenue * 100 : 0 ;
            @endphp

            <td>
                <div class="d-flex align-items-center justify-content-center">
                    <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </div>
            </td>
            @php
            $columnIndex++;
            @endphp
            @endforeach



        </tr>







    </x-slot>




</x-tables.repeater-table>
