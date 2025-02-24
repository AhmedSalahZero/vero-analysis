@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\Study;
use App\Models\NonBankingService\PortfolioMortgageBreakdown;
@endphp
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">

@endsection
@section('sub-header')
<x-main-form-title :id="'main-form-title'" :class="''">{{ $title }}</x-main-form-title>

{{-- <x-navigators-dropdown :navigators="$navigators"></x-navigators-dropdown> --}}

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">


        <form id="factoring-loans" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{  isset($disabled) && $disabled ? '#' :  $storeRoute  }}">

            @csrf
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="creator_id" value="{{ \Auth::id()  }}">
            <input type="hidden" name="study_id" value="{{ $study->id }}">


            {{-- start of Factoring Revenue Projection By Category   --}}

            {{-- start of Factoring New Portfolio Funding Structure   --}}
            <div class="kt-portlet " id="salah">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Portfolio Mortgage Revenue Projection - Please Choose Duration ') }}
                                </h3>
                                <div class="form-group mb-0 d-flex w-10" style="margin-right:auto;gap:20px;">
                                    <select name="portfolio_mortgage_duration" class="form-control blue-select  seasonlity-select main-seasonality-select">
                                        @for($i = 5 ; $i <= 10 ; $i++) <option value="{{ $i }}"> {{ $i }} {{ __('Years') }} </option>
                                            @endfor
                                    </select>



                                </div>

                            </div>



                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.revenue-projection-by-category'"></x-show-hide-btn>
                        </div>
                    </div>
					
					
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row revenue-projection-by-category">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Item')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Spread <br> Rate')"></x-tables.repeater-table-th>
                                @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Yr-') . $yearIndexWithYear[$year] "></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Operating Months Per Year') }}" disabled class="form-control text-left mt-2" type="text">
                                        </div>
                                    <td></td>

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

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">

                                    <td>
                                        <div class="">
                                            <input value="{{ __('Growth Rate %') }}" disabled class="form-control text-left mt-2" type="text">

                                        </div>
                                    </td>
                                    <td></td>
                                    @php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;

                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageRevenueProjectionByCategory ? $model->portfolioMortgageRevenueProjectionByCategory->getGrowthRateAtYearIndex($year) : 0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'PortfolioMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>









                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                        <input value="{{ __('Portfolio Mortgage Transactions Projection') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>
                                    <td></td>

                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal = $model->portfolioMortgageRevenueProjectionByCategory ? $model->portfolioMortgageRevenueProjectionByCategory->getPortfolioMortgageTransactionProjectionAtYearIndex($year) : 0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :number-format-decimals="0" :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value'" :is-percentage="false" :name="'PortfolioMortgageRevenueProjectionByCategory['.'portfolio_mortgage_transactions_projections'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>





                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <td>
                                        <div class="">
                                            <input value="{{ __('Monthly Due Cheques %') }}" disabled class="form-control text-left mt-2" type="text">
                                            <i class="fa fa-ellipsis-h pull-left "></i>
                                        </div>
                                    </td>

                                    <td>
                                        <x-repeat-right-dot-inputs :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getMonthlyMarginRate():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'monthly_margin_rate'" :columnIndex="null"></x-repeat-right-dot-inputs>
                                    </td>
                                    @php
                                    $columnIndex = 0 ;


                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageRevenueProjectionByCategory ? $model->portfolioMortgageRevenueProjectionByCategory->getMonthlyDueChequesPercentagesAtYearIndex($year) : 0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'PortfolioMortgageRevenueProjectionByCategory['.'monthly_due_cheques_percentages'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                            <input value="{{ __('Quarterly Due Cheques %') }}" disabled class="form-control text-left mt-2" type="text">
                                            <i class="fa fa-ellipsis-h pull-left "></i>
                                        </div>
                                    </td>

                                    <td>
                                        <x-repeat-right-dot-inputs :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getQuarterlyMarginRate():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'quarterly_margin_rate'" :columnIndex="null"></x-repeat-right-dot-inputs>
                                    </td>
                                    @php
                                    $columnIndex = 0 ;


                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageRevenueProjectionByCategory ? $model->portfolioMortgageRevenueProjectionByCategory->getQuarterlyDueChequesPercentagesAtYearIndex($year) : 0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'PortfolioMortgageRevenueProjectionByCategory['.'quarterly_due_cheques_percentages'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                            <input value="{{ __('Annually Due Cheques %') }}" disabled class="form-control text-left mt-2" type="text">
                                            <i class="fa fa-ellipsis-h pull-left "></i>
                                        </div>
                                    </td>

                                    <td>
                                        <x-repeat-right-dot-inputs :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getAnnuallyMarginRate():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'annually_margin_rate'" :columnIndex="null"></x-repeat-right-dot-inputs>
                                    </td>
                                    @php
                                    $columnIndex = 0 ;


                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageRevenueProjectionByCategory ? $model->portfolioMortgageRevenueProjectionByCategory->getAnnuallyDueChequesPercentagesAtYearIndex($year) : 0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'PortfolioMortgageRevenueProjectionByCategory['.'annually_due_cheques_percentages'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>
								
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
									<div class="row">
										<div class="col-md-12">
											{{-- <div class="text-right">
												 <input type="submit" name="save-and-continue" class="btn active-style save-form" value="{{  __('Add New Portfolio Mortgage') }}">
											</div> --}}
											<div class="text-center">
												 <input type="submit" name="save-and-continue" class="btn btn-danger text-white save-form" value="{{  __('Delete') }}">
											</div>
											
										</div>
										
									</div>
									</td>
									<td>
									<div class="row">
										<div class="col-md-12">
											<div class="text-right">
												 <input type="submit" name="save-and-continue" class="btn active-style save-form" value="{{  __('Add New Portfolio Mortgage') }}">
											</div>
											{{-- <div class="text-left">
												 <input type="submit" name="save-and-continue" class="btn active-style save-form" value="{{  __('Delete') }}">
											</div> --}}
											
										</div>
										
									</div>
									 
									</td>
								</tr>
								
								

















                            </x-slot>
							




                        </x-tables.repeater-table>





                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
			
            {{-- end of Factoring New Portfolio Funding Structure   --}}


            {{-- end of Factoring Revenue Projection By Category   --}}








            {{-- start of Administration Fees Rate & ECL Rate   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Administration Fees Rate & ECL Rate') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.revenue-projection-by-category'"></x-show-hide-btn>

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row revenue-projection-by-category">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Yr-') . $yearIndexWithYear[$year] "></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}


                                    <td>
                                        <input value="{{ __('Administration Fees Rate') }}" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">


                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageAdminFeesRate ? $model->portfolioMortgageAdminFeesRate->getAdminFeeRatesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'portfolioMortgageAdminFeesRate['.'admin_fees_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>


                                <tr data-repeat-formatting-decimals="2" data-repeater-style>


                                    <td>
                                        <input disabled value="{{ __('Expected Credit Loss Rate (ECL %)') }}" class="form-control text-left" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->portfolioMortgageAdminFeesRate ? $model->portfolioMortgageAdminFeesRate->getEclRatesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'portfolioMortgageAdminFeesRate['.'ecl_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp

                                    @endforeach



                                </tr>


                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Administration Fees Rate & ECL Rate   --}}




            {{-- start of Factoring New Portfolio Funding Structure   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Portfolio Mortgage New Portfolio Funding Structure') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.new-portfolio-funding'"></x-show-hide-btn>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row new-portfolio-funding">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Yr-') . $yearIndexWithYear[$year] "></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style {{-- @if($isRepeater) data-repeater-item @endif --}}>

                                    {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}


                                    <td>
                                        <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$model->portfolioMortgageNewPortfolioFundingStructure ? $model->portfolioMortgageNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'portfolioMortgageNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>



                                <tr data-repeat-formatting-decimals="0" data-repeater-style {{-- @if($isRepeater) data-repeater-item @endif --}}>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <input value="{{ __('Equity Funding Value') }}" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :numberFormatDecimals="0" :currentVal="$model->portfolioMortgageNewPortfolioFundingStructure ? $model->portfolioMortgageNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'portfolioMortgageNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>



                                <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                    <td>
                                        <input disabled value="{{ __('New Loans Funding Rate (%)') }}" class="form-control text-left" type="text">
                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="portfolioMortgageNewPortfolioFundingStructure[new_loans_funding_rates][{{ $year }}]" value="{{ $model->portfolioMortgageNewPortfolioFundingStructure ? $model->portfolioMortgageNewPortfolioFundingStructure->getNewLoansFundingRatesAtYearIndex($year):0 }}"> <span class="ml-2">%</span>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp

                                    @endforeach



                                </tr>






                                <tr data-repeat-formatting-decimals="0" data-repeater-style>


                                    <td>
                                        <input disabled value="{{ __('New Loans Funding Value') }}" class="form-control text-left" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->portfolioMortgageNewPortfolioFundingStructure ? $model->portfolioMortgageNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'portfolioMortgageNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp

                                    @endforeach



                                </tr>

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Factoring New Portfolio Funding Structure   --}}

            <x-save-or-back />





























    </div>

</div>

</div>




</div>









</div>
</div>
</form>

</div>
@endsection
@section('js')
<x-js.commons></x-js.commons>

<script>


</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            const hasSalesChannel = $('#add-sales-channels-share-discount-id:checked').length

            let canSubmitForm = true;
            let errorMessage = '';
            let messageTitle = 'Oops...';



            if (!canSubmitForm) {
                Swal.fire({
                    icon: "warning"
                    , title: messageTitle
                    , text: errorMessage
                , })

                return;
            }

            let formId = $(this).closest('form').attr('id')

            let form = document.getElementById(formId);
            var formData = new FormData(form);
            formData.append('submitBtnType', formId)

            $('.save-form').prop('disabled', true);


            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {
                    $('.save-form').prop('disabled', false);
                    $('.submit-form-btn-new').prop('disabled', false)
                    Swal.fire({
                        icon: 'error'
                        , title: res.responseJSON.message
                    , });
                }
            });
        }
    })

</script>

<script>
    $('.use-rooms:checked').trigger('change');

</script>

<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })
    $(document).on('change', '.can-not-be-removed-checkbox', function() {
        $(this).prop('checked', true)
    })

    $(document).on('click', '.show-hide-repeater', function() {
        const query = this.getAttribute('data-query')
        $(query).fadeToggle(300)

    })
    $(document).on('change', '.not-allowed-duplication-in-selection-inside-repeater', function() {
        const val = $(this).val()
        const currentSelect = this
        const currentSelectedOption = $(currentSelect).find('option[value="' + val + '"]')
        const commonParent = $(this).closest('[data-repeater-list]')
        // let selectItems = []
        // $(commonParent).find('select').each(function(index,select){
        // 	selectItems.push($(select).val())
        // })
        $(commonParent).find('select').each(function(index, select) {
            if (select != currentSelect) {
                if ($(select).find('option[value="' + val + '"]:selected').length) {
                    alert('This Item has been choosen before')
                    $(currentSelect).val('').trigger('change')

                }

                //.prop('disabled',true).attr('title','This Item has been choosen before')
            } else {}
        })
    })

    $(document).on('change', '.can-be-toggle-show-repeater-btn', function() {
        let val = $(this).is(':checked')
        let repeaterQuery = $(this).attr('data-repeater-query')
        if (!val) {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').addClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeOut(300)
            $(this).val(0)
        } else {
            $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').removeClass('disabled');
            $('[data-repeater-row="' + repeaterQuery + '"]').fadeIn(300)
            $(this).val(1)

        }

    })
    $('.can-be-toggle-show-repeater-btn').trigger('change')

</script>

<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>
<script>
   // const clone = $('#salah').clone();
  //  $('#factoring-loans').append(clone)
    $(document).on('click', '.delete-class', function() {
        // $(this).closest('.kt-portlet').remove();
    })

</script>
{{-- <script></script> --}}
@endsection
