@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\Study;
use App\Models\NonBankingService\IjaraMortgageBreakdown;
@endphp
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/select2.css">

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

            {{-- start of Ijara Mortgage Revenue Projection By Category   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Ijara Mortgage Revenue Projection By Category') }}
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


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden overflow-scroll'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
								<x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Total')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">
	 							@if($isYearsStudy)
                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Operating Months Per Year') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="form-group three-dots-parent">
                                            <div class="input-group input-group-sm align-items-center justify-content-center div-for-percentage">
                                                <input type="text" style="max-width: 60px;min-width: 60px;text-align: center" value="{{ sumNumberOfOnes($yearsWithItsMonths,$yearOrMonthAsIndex,$datesIndexWithYearIndex) }}" readonly onchange="this.style.width = ((this.value.length + 1) * 10) + 'px';" class="form-control target_repeating_amounts only-percentage-allowed size" data-date="#" data-section="target" aria-describedby="basic-addon2">
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


                                <tr total-row-tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Growth Rate %') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;

                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->ijaraMortgageRevenueProjectionByCategory ? $model->ijaraMortgageRevenueProjectionByCategory->getGrowthRateAtYearOrMonthIndex($yearOrMonthAsIndex) : 0" :classes="'only-greater-than-or-equal-zero-allowed recalculate-gr gr-field'" :is-percentage="true" :name="'IjaraMortgageRevenueProjectionByCategory['.'growth_rates'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach
									
									 <td>
								
                                        <div class="d-flex align-items-center justify-content-center">
											<input type="text" class="form-control expandable-percentage-input sum-total-row sum-percentage-css" disabled value="0"> <span class="ml-2 d-inline-block"> %</span>
                                        </div>
                                    </td>
									



                                </tr>









                                <tr total-row-tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                        <input value="{{ __('Ijara Projection') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php
                                    $currentVal = $model->ijaraMortgageRevenueProjectionByCategory ? $model->ijaraMortgageRevenueProjectionByCategory->getIjaraMortgageTransactionProjectionAtYearIndex($yearOrMonthAsIndex) : 0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :number-format-decimals="0" :currentVal="$currentVal" :formattedInputClasses="'current-growth-rate-result-value-formatted'" :classes="'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value factoring-projection-amount recalculate-factoring current-growth-rate-result-value'" :is-percentage="false" :name="'IjaraMortgageRevenueProjectionByCategory['.'ijara_mortgage_transactions_projections'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach
									
									
									 <td>
                                        <div class="d-flex align-items-center justify-content-center">
											<input type="text" class="form-control expandable-amount-input sum-total-row sum-percentage-css" disabled value="0"> <span class="ml-2 d-inline-block"> </span>  
                                        </div>
                                    </td>
									


                                </tr>






                            </x-slot>




                        </x-tables.repeater-table>





                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Ijara Mortgage Revenue Projection By Category   --}}


            {{-- end of Factoring Revenue Projection By Category   --}}



            {{-- start of Ijara Mortgage Breakdown   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Ijara Mortgage Breakdown') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.admin-fees'"></x-show-hide-btn>

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row admin-fees">
                        @php
                        $rowIndex = 0;
                        $relationName ='ijaraMortgageBreakdowns';
                        $repeaterId =$relationName.'repeater';
                        @endphp
                        <x-tables.repeater-table :tableName="$relationName" :repeaterId="$repeaterId" :removeActionBtn="false" :removeRepeater="false" :initialJs="true" :repeater-with-select2="true" :canAddNewItem="true" :parentClass="'js-remove-hidden overflow-scroll'" :hide-add-btn="true" :relationName="$relationName" :isRepeater="true">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Installment Interval')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Tenor <br> (Months)')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Grace <br> Period')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Spread <br> Rate')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = count($model->ijaraMortgageBreakdowns) ? $model->ijaraMortgageBreakdowns : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof IjaraMortgageBreakdown) ){
                                unset($subModel);
                                }
                                @endphp

                                <tr data-repeater-item data-repeat-formatting-decimals="2" data-repeater-style>

                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <x-form.select :required="true" :label="''" :pleaseSelect="false" :selectedValue="isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly'" :options="[['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]]" :add-new="false" class="select2-select  repeater-select  " :all="false" name="installment_interval"></x-form.select>
                                        <input value="{{ __('Ijara Projection') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    <td>
                                        <x-repeat-right-dot-inputs number-format-decimals="0" :mark="'Mth'" :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getTenor():12" :classes="'only-greater-than-zero-allowed'" :is-percentage="true" :name="'tenor'" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td>
                                    <td>
                                        <x-repeat-right-dot-inputs number-format-decimals="0" :mark="'Mth'" :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getGracePeriod():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'grace_period'" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td>
                                    <td>
                                        <x-repeat-right-dot-inputs :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getMarginRate():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'margin_rate'" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td>

                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <x-repeat-right-dot-inputs :multiple="true" :currentVal="isset($subModel) ? $subModel->getPercentageAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed recalculate-factoring factoring-rate'" :is-percentage="true" :name="'percentage_payload'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        <x-repeat-right-dot-inputs :multiple="true" :number-format-decimals="0" :currentVal="isset($subModel) ? $subModel->getLoanAmountPayloadAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed current-loan-input factoring-value'" :is-percentage="false" :name="'loan_amounts'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>
                                @endforeach





                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Ijara Mortgage Breakdown   --}}





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
                            <x-show-hide-btn :query="'.admin-fees'"></x-show-hide-btn>

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row admin-fees">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden overflow-scroll'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}


                                    <td>
                                        <input value="{{ __('Administration Fees Rate') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getAdminFeesRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'admin_fees_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
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

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getEclRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'ecl_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                    {{ __('Factoring New Portfolio Funding Structure') }}
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


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden overflow-scroll'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style {{-- @if($isRepeater) data-repeater-item @endif --}}>

                                    {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}


                                    <td>
                                        <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getEquityFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'equity_funding_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                        <input value="{{ __('Equity Funding Value') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :numberFormatDecimals="0" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getEquityFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'equity_funding_values['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="new_loans_funding_rates[{{ $yearOrMonthAsIndex }}]" value="{{ $eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0 }}"> <span class="ml-2">%</span>
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

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getNewLoansFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'new_loans_funding_values['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
<script src="/custom/js/non-banking-services/select2.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>
{{-- <script></script> --}}
@endsection
