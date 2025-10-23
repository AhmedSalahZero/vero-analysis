@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\LeasingCategory;
@endphp
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/leasing-revenue-stream-breakdown.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/select2.css">

@endsection
@section('sub-header')
<x-main-form-title :id="'main-form-title'" :class="''">{{ $title }}</x-main-form-title>

{{-- <x-navigators-dropdown :navigators="$navigators"></x-navigators-dropdown> --}}

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">



        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="d-flex align-items-center ">
                            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> {{ __('Leasing Revenue Stream') }} </h3>
                        </div>
                    </div>
                    <div class="col-md-2 text-right">
                        <x-show-hide-btn :query="'.leasing-revenue-stream-category'"></x-show-hide-btn>
                    </div>
                </div>
                <div class="row">
                    <hr style="flex:1;background-color:lightgray">
                </div>
                <div class="row leasing-revenue-stream-category">

                    <div class="form-group row" style="flex:1;">
                        <div class="col-md-12 mt-3" data-repeater-row=".leasing-revenue-stream-category">

                            <form id="{{ LeasingCategory::LEASING_CATEGORY_FORM_ID }}" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{  isset($disabled) && $disabled ? '#' :  $storeRoute  }}">

                                <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
                                <input type="hidden" name="creator_id" value="{{ \Auth::id()  }}">
                                <input type="hidden" name="study_id" value="{{ $study->id }}">

                                <div id="leasingRevenueStreamBreakdown" class="leasing-repeater-parent">
                                    <div class="form-group2  m-form__group2 row">
                                        <div data-repeater-list="leasingRevenueStreamBreakdown" class="col-lg-12">

                                            @include('non_banking_services.leasing-revenue-stream-breakdown._leasing_repeater' , [

                                            'tableId'=>'leasingRevenueStreamBreakdown',
                                            'isRepeater'=>true ,
                                            'canAddNewItem'=>true ,
                                            'model'=>$model


                                            ])



                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                
                                    <div class="col-md-12 text-right">
                                        <input type="submit" name="save-and-continue" class="btn active-style save-form" value="{{  __('Save & Continue') }}">
                                        @include('non_banking_services.buttons.enable-editing',['inEditMode'=>$model->leasingRevenueStreamBreakdown->count()])
                                    </div>

                                </div>
                            </form>

                        </div>


                    </div>

                </div>
            </div>

        </div>

        <form id="leasing-loans" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{  isset($disabled) && $disabled ? '#' :  $storeRoute  }}">

            @csrf
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="creator_id" value="{{ \Auth::id()  }}">
            <input type="hidden" name="study_id" value="{{ $study->id }}">


            @if(count($study->leasingRevenueStreamBreakdown))

            {{-- start of Leasing Revenue Projection By Category   --}}

            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Leasing Revenue Projection By Category') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.leasing-revenue-projection-by-category'"></x-show-hide-btn>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row leasing-revenue-projection-by-category">
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
                                            <input value="{{ __('Operating Months Per Year') }}" disabled class="form-control min-width-hover-300 text-left mt-2" type="text">
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


                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Growth Rate %') }}" disabled class="form-control min-width-hover-300 text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    @php
                                    $columnIndex = 0 ;

                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php


                                    $currentVal = $model->getLeasingGrowthRateAtYearOrMonthIndex($yearOrMonthAsIndex) ;
                                    @endphp

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$currentVal" :classes="'only-greater-than-or-equal-zero-allowed recalculate-gr gr-field'" :is-percentage="true" :name="'growth_rate['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach

                                    <td>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input sum-percentage-css" disabled value="-">
                                        </div>
                                    </td>




                                </tr>




                                @php
                                $currentLoanTotalPerYear = [];
                                @endphp

                                @foreach ($study->leasingRevenueStreamBreakdown as $currentLeasingRevenueStreamBreakdown)


                                <tr data-repeat-formatting-decimals="0" data-repeater-style total-row-tr>

                                    <td>
                                        <div class="">

                                            <input value="{{ $currentLeasingRevenueStreamBreakdown->getReviewForTable() }}" disabled class="form-control min-width-hover-300 text-left mt-2" type="text">
                                        </div>
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php
                                    $currentVal = $currentLeasingRevenueStreamBreakdown ?$currentLeasingRevenueStreamBreakdown->getLoanAmountAtYearOrMonthIndex($yearOrMonthAsIndex) : 0;
                                    $currentLoanTotalPerYear[$yearOrMonthAsIndex] = isset($currentLoanTotalPerYear[$yearOrMonthAsIndex]) ? $currentLoanTotalPerYear[$yearOrMonthAsIndex]+ $currentVal : $currentVal;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :number-format-decimals="0" :currentVal="$currentVal" :formattedInputClasses="'current-growth-rate-result-value-formatted'" :classes="'only-greater-than-or-equal-zero-allowed current-loan-input current-growth-rate-result-value '" :is-percentage="false" :name="'loan_amounts['.$currentLeasingRevenueStreamBreakdown->id.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input sum-total-row sum-percentage-css" disabled value="0">
                                        </div>
                                    </td>
                                </tr>




                                @endforeach


                                <tr data-repeat-formatting-decimals="0" data-repeater-style total-row-tr data-row-total>

                                    <td>
                                        <div class="">

                                            <input value="{{ __('Total') }}" disabled class="form-control text-left mt-2 min-width-hover-300" type="text">
                                        </div>
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php
                                    $currentLoanTotal = $currentLoanTotalPerYear[$yearOrMonthAsIndex] ;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">


                                            <div class="form-group three-dots-parent">
                                                <div class="input-group input-group-sm align-items-center justify-content-center flex-nowrap">
                                                    <div class="input-hidden-parent">
                                                        <input readonly class="form-control copy-value-to-his-input-hidden  expandable-amount-input  repeat-to-right-input-formatted  " type="text" value="{{ number_format($currentLoanTotal,0)  }}" data-column-index="{{ $columnIndex }}">
                                                        <input js-recalculate-equity-funding-value type="hidden" class="repeat-to-right-input-hidden input-hidden-with-name  total-loans-hidden" value="{{ $currentLoanTotal  }}" data-column-index="{{ $columnIndex }}" name="ee">
                                                    </div>

                                                    <span class="ml-2 currency-class">
                                                        {{ $company->getMainFunctionalCurrency() }}
                                                    </span>


                                                </div>

                                            </div>



                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input sum-total-row sum-percentage-css" disabled value="0">
                                        </div>
                                    </td>



                                </tr>




                            </x-slot>




                        </x-tables.repeater-table>



                    </div>

                </div>
            </div>
            {{-- end of Leasing New Portfolio Funding Structure   --}}


            {{-- end of Leasing Revenue Projection By Category   --}}

            @include('seasonality_card')



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
                            <x-show-hide-btn :query="'.leasing-admin'"></x-show-hide-btn>

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row leasing-admin">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden overflow-scroll'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="  header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class="  header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <input value="{{ __('Administration Fees Rate') }}" disabled class="form-control min-width-hover-300 text-left mt-2" type="text">
                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php

                                    $currentAdminFeesRateAtYearIndex = $leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getAdminFeesRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">


                                            <x-repeat-right-dot-inputs :currentVal="$currentAdminFeesRateAtYearIndex" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'admin_fees_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>


                                <tr data-repeat-formatting-decimals="2" data-repeater-style>


                                    <td>
                                        <input disabled value="{{ __('Expected Credit Loss Rate (ECL %)') }}" class="form-control min-width-hover-300 text-left" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    @php
                                    $currentExpectedCreditLossRateAtYearIndex = $leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getEclRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0;

                                    @endphp

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$currentExpectedCreditLossRateAtYearIndex" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'ecl_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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



            {{-- start of Leasing New Portfolio Funding Structure   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Leasing New Portfolio Funding Structure') }}
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
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Total')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control  min-width-hover-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getEquityFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'equity_funding_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input  sum-percentage-css" disabled value="-">
                                        </div>
                                    </td>




                                </tr>



                                <tr data-repeat-formatting-decimals="0" data-repeater-style total-row-tr data-row-total>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <input value="{{ __('Equity Funding Value') }}" disabled class="form-control min-width-hover-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true" :numberFormatDecimals="0" :currentVal="$leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getEquityFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'equity_funding_values['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input sum-total-row sum-percentage-css" disabled value="0">
                                        </div>
                                    </td>



                                </tr>



                                <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                    <td>
                                        <input disabled value="{{ __('New Loans Funding Rate (%)') }}" class="form-control min-width-hover-300 text-left" type="text">
                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-amount-input new-loan-function-rates-js" name="new_loans_funding_rates[{{ $yearOrMonthAsIndex }}]'" value="{{ $leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):100 }}"> <span class="ml-2">%</span>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp

                                    @endforeach

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input  sum-percentage-css" disabled value="-">
                                        </div>
                                    </td>



                                </tr>

                                <tr data-repeat-formatting-decimals="0" data-repeater-style total-row-tr data-row-total>


                                    <td>
                                        <input disabled value="{{ __('New Loans Funding Value') }}" class="form-control min-width-hover-300 text-left" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true" :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$leasingEclAndNewPortfolioFundingRate ? $leasingEclAndNewPortfolioFundingRate->getNewLoansFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'new_loans_funding_values['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp

                                    @endforeach
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" class="form-control expandable-amount-input sum-total-row sum-percentage-css" disabled value="0">
                                        </div>
                                    </td>



                                </tr>

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Leasing New Portfolio Funding Structure   --}}
            <x-save-or-back />
            @endif




























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
    $(document).on('change', '.current-loan-input', function() {
        let total = 0
        let currentLoanIndex = parseInt($(this).attr('data-column-index'))
        $('.current-loan-input[data-column-index="' + currentLoanIndex + '"]').each(function(index, element) {
            total += parseFloat($(element).val())
        })
        $(this).closest('table').find('[data-row-total] .repeat-to-right-input-formatted[data-column-index="' + currentLoanIndex + '"]').val(number_format(total)).trigger('change')

    })

</script>


<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/select2.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>
{{-- <script></script> --}}
@endsection
