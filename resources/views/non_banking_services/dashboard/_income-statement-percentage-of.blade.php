<x-tables.repeater-table :table-class="'col-md-6 margin__left'" :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                                <x-slot name="ths">
                                    <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Item')"></x-tables.repeater-table-th>
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$year.'-'"></x-tables.repeater-table-th>
                                    @endforeach
                                </x-slot>
                                <x-slot name="trs">

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>



                                        <td>
                                            <div class="">
                                                <input value="{{ __('Operating Months') }}" disabled class="form-control text-left " type="text">
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







                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>



                                        <td>
                                            <div class="">
                                                <input value="{{ __('Growth Rate %') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;

                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['growth_rate'][$year] ?? 0;
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :disabled="true" numberFormatDecimals="2" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>
















                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>



                                        <td>
                                            <div class="">
                                                <input value="{{ __('% / REV.') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;


                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['gross_profit_percentage_of_sales'][$year] ?? 0;
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
                                            <div class="">
                                                <input value="{{ __('% / REV.') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['ebitda_percentage_of_sales'][$year] ?? 0;
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>







                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                        <td>
                                            <div class="">
                                                <input value="{{ __('% / REV.') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;

                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['ebit_percentage_of_sales'][$year] ?? 0;
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>







                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>



                                        <td>
                                            <div class="">
                                                <input value="{{ __('% / REV.') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;


                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['ebt_percentage_of_sales'][$year] ?? 0;
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>








                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>



                                        <td>
                                            <div class="">
                                                <input value="{{ __('% / REV.') }}" disabled class="form-control text-left " type="text">
                                            </div>


                                        </td>
                                        @php
                                        $columnIndex = 0 ;


                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        @php
                                        $currentVal = $formattedResult['net_profit_percentage_of_sales'][$year] ?? 0;
                                        @endphp

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="1" :removeThreeDotsClass="true" :removeThreeDots="true" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>







                                </x-slot>




                            </x-tables.repeater-table>
