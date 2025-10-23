@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\Expense;
@endphp
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/expenses.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/select2.css">
<style>
    .expenses-table {
        min-height: 50vh !important;
    }

</style>
@endsection
@section('sub-header')

<x-main-form-title :id="'main-form-title'" :class="''">{{ $title  }}</x-main-form-title>
@endsection
@section('content')
@php
$months = $study->getMicrofinanceMonths() ;
@endphp
<div class="row">
    <div class="col-md-12">
        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
            @csrf
            <input type="hidden" name="model_id" value="{{ $model->id ?? 0  }}">
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="model_name" value="Study">
            {{-- <input type="hidden" name="expense_type" value="{{ $expenseType }}"> --}}
            <input type="hidden" name="study_id" id="study-id-js" value="{{ $study->id }}">
            <input type="hidden" id="study-start-date" value="{{ $study->getStudyStartDate() }}">
            <input type="hidden" id="study-end-date" value="{{ $study->getStudyEndDate() }}">




            {{-- start of New Branches Product Mix  --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                        {{ __('Monthly Loan Amounts By Product') }}
                    </h3>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row reserve-and-profit-distribution-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! __('Product <br> Name') !!}</th>
                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! $yearOrMonthFormatted .' <br> ' . __('Loan <br> Amount') !!}</th>
                                        @endforeach
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{{ __('Total') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @php
                                    $monthlyLoanAmounts = $salesProjectsPerProducts[$product->id] ?? [];
									if(!count($monthlyLoanAmounts)){
										continue;
									}
                                    @endphp


                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ $product->getName() }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            @php
                                            $currentVal = $monthlyLoanAmounts[$yearOrMonthAsIndex]??0;
                                            $columnsTotals[$yearOrMonthAsIndex] = isset($columnsTotals[$yearOrMonthAsIndex] ) ? $columnsTotals[$yearOrMonthAsIndex] +$currentVal : $currentVal;
                                            $rowsTotals[$product->id] = isset($rowsTotals[$product->id] ) ? $rowsTotals[$product->id] +$currentVal : $currentVal;
                                            @endphp
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$currentVal" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$rowsTotals[$product->id]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>
                                    @endforeach

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ __('Totals') }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$columnsTotals[$yearOrMonthAsIndex]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="array_sum($rowsTotals??[])" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>





                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
			
			
			
			
			
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
                            <x-show-hide-btn :query="'.direct-factoring-revenue-projection-by-category'"></x-show-hide-btn>

                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row factoring-revenue-projection-by-category">
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

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

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
                                            <x-repeat-right-dot-inputs :currentVal=" $eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getAdminFeesRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'admin_fees_rates['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>


                                <tr data-repeat-formatting-decimals="0" data-repeater-style>


                                    <td>
                                        <input disabled value="{{ __('Expected Credit Loss Rate (ECL %)') }}" class="form-control min-width-300 text-left" type="text">

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
			
			
			
			   @foreach($salesProjectsPerTypes as $type => $salesProjectsPerProducts)

            @php
            $rowsTotals =[];
            $columnsTotals =[];
            $titleFormatted = [
            'all-branches'=>__('Existing Branches'),
            'new-branches'=>__('New Branches')
            ][$type];
            @endphp
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                        {{ __('Monthly Loan Amounts ') . $titleFormatted }}
                    </h3>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row reserve-and-profit-distribution-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! __('Product <br> Name') !!}</th>
                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! $yearOrMonthFormatted .' <br> ' . __('Loan <br> Amount') !!}</th>
                                        @endforeach
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{{ __('Total') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @php
                                    $monthlyLoanAmounts = $salesProjectsPerProducts[$product->id] ?? [];
									if(!count($monthlyLoanAmounts)){
										continue;
									}
									
                                    @endphp


                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ $product->getName() }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            @php
                                            $currentVal = $monthlyLoanAmounts[$yearOrMonthAsIndex]??0;
                                            $columnsTotals[$yearOrMonthAsIndex] = isset($columnsTotals[$yearOrMonthAsIndex] ) ? $columnsTotals[$yearOrMonthAsIndex] +$currentVal : $currentVal;
                                            $rowsTotals[$product->id] = isset($rowsTotals[$product->id] ) ? $rowsTotals[$product->id] +$currentVal : $currentVal;
                                            @endphp
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$currentVal" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$rowsTotals[$product->id]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>
                                    @endforeach

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ __('Totals') }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$columnsTotals[$yearOrMonthAsIndex]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="array_sum($rowsTotals??[])" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>





                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            @endforeach




            @foreach($salesProjectsPerFundedBy as $fundedBy => $salesProjectsPerProducts)

            @php
            $rowsTotals =[];
            $columnsTotals =[];
            $fundedByFormatted = [
            'by-odas'=>__('By ODAs'),
            'by-mtls'=>__('By MTLs')
            ][$fundedBy];
            @endphp
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                        {{ __('Monthly Loan Amounts ') . $fundedByFormatted }}
                    </h3>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row reserve-and-profit-distribution-assumption">


                        <div class="table-responsive">
                            <table class="table table-white repeater-class repeater ">
                                <thead>
                                    <tr>
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! __('Product <br> Name') !!}</th>
                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{!! $yearOrMonthFormatted .' <br> ' . __('Loan <br> Amount') !!}</th>
                                        @endforeach
                                        <th class=" form-label font-weight-bold text-center align-middle  header-border-down">{{ __('Total') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    @php
                                    $monthlyLoanAmounts = $salesProjectsPerProducts[$product->id] ?? [];
									if(!count($monthlyLoanAmounts)){
										continue;
									}
                                    @endphp


                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ $product->getName() }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            @php
                                            $currentVal = $monthlyLoanAmounts[$yearOrMonthAsIndex]??0;
                                            $columnsTotals[$yearOrMonthAsIndex] = isset($columnsTotals[$yearOrMonthAsIndex] ) ? $columnsTotals[$yearOrMonthAsIndex] +$currentVal : $currentVal;
                                            $rowsTotals[$product->id] = isset($rowsTotals[$product->id] ) ? $rowsTotals[$product->id] +$currentVal : $currentVal;
                                            @endphp
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$currentVal" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>
                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$rowsTotals[$product->id]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>
                                    @endforeach

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                        <td class="td-classes">
                                            <div>

                                                <input value="{{ __('Totals') }}" disabled="" class="form-control text-left min-w-300" type="text">
                                            </div>

                                        </td>




                                        @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="$columnsTotals[$yearOrMonthAsIndex]??0" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                        @endforeach

                                        <td>

                                            <x-repeat-right-dot-inputs :disabled="true" :numberFormatDecimals="0" :formattedInputClasses="' '" :mark="''" :removeThreeDots="true" :removeCurrency="true" :currentVal="array_sum($rowsTotals??[])" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                        </td>


                                    </tr>





                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
			
			
			
			
			  <div class="kt-portlet " >
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Microfinance New Portfolio Funding Structure') . ' [ ' . $fundedByFormatted . ' ]' }}
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
                                <x-tables.repeater-table-th class="  header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class="  header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                                <x-tables.repeater-table-th class="  header-border-down " :title="__('Total')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="0" data-repeater-style total-row-tr data-row-total>




                                    <td>
                                        <input value="{{ __('Microfinance New Portfolio Amounts') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :numberFormatDecimals="0" :readonly="true" :removeThreeDots="true" :inputHiddenAttributes="''" :currentVal="$columnsTotals[$yearOrMonthAsIndex]??0" :classes="'js-recalculate-equity-funding-value total-loans-hidden'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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



                                <tr data-repeat-formatting-decimals="0" data-repeater-style>




                                    <td>
                                        <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getEquityFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'equity_funding_rates['.$fundedBy.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
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
                                        <input value="{{ __('Equity Funding Value') }}" disabled class="form-control min-width-300 text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :readonly="true" :numberFormatDecimals="0" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getEquityFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'equity_funding_values['.$fundedBy.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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



                                <tr data-repeat-formatting-decimals="0" data-repeater-style>
                                    <td>
                                        <input disabled value="{{ __('New Loans Funding Rate (%)') }}" class="form-control text-left" type="text">
                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)


                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="new_loans_funding_rates[{{ $yearOrMonthAsIndex }}]" value="{{ $eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):100 }}"> <span class="ml-2">%</span>
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
                                        <input disabled value="{{ __('New Loans Funding Value') }}" class="form-control text-left" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp

                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true" :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$eclAndNewPortfolioFundingRate ? $eclAndNewPortfolioFundingRate->getNewLoansFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'new_loans_funding_values['.$fundedBy.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
			

            @endforeach







         











            <x-save-or-continue-btn />




            <!--end::Form-->

            <!--end::Portlet-->
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
    $(document).on('change', '.financial-statement-type', function() {
        validateDuration();
    })
    $(document).on('change', 'select[name="duration_type"]', function() {
        validateDuration();
    })
    $(document).on('change', '#duration', function() {
        validateDuration();
    })

    function validateDuration() {
        let type = $('input[name="type"]:checked').val();
        let durationType = $('select[name="duration_type"]').val();
        let duration = $('#duration').val();
        let isValid = true;
        let allowedDuration = 24;
        if (type == 'forecast' && durationType == 'monthly') {
            allowedDuration = 24;
            isValid = duration <= allowedDuration;
        }
        if (type == 'forecast' && durationType == 'quarterly') {
            allowedDuration = 8;
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'semi-annually') {
            allowedDuration = 4
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'annually') {
            allowedDuration = 2;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'monthly') {
            allowedDuration = 36;
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'quarterly') {
            allowedDuration = 12
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'semi-annually') {
            allowedDuration = 6;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'annually') {
            allowedDuration = 3
            isValid = duration <= allowedDuration
        }
        let allowedDurationText = "{{ __('Allowed Duration') }}";

        $('#allowed-duration').html(allowedDurationText + '  ' + allowedDuration)

        if (!isValid) {
            Swal.fire({
                icon: 'error'
                , title: 'Invalid Duration. Allowed [ ' + allowedDuration + ' ]'
            , })

            $('#duration').val(allowedDuration).trigger('change');

        }


    }

    $(function() {
        $('.financial-statement-type').trigger('change')

    })

</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            let form = document.getElementById('form-id');
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);
            var saveAndContinue = $(this).attr('data-save-and-continue');
            formData.append('saveAndContinue', saveAndContinue);
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
    function reinitalizeMonthYearInput(dateInput) {
        var currentDate = $(dateInput).val();
        var startDate = "{{ isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1 }}";
        startDate = startDate == '-1' ? '' : startDate;
        var endDate = "{{ isset($studyEndDate) && $studyEndDate? $studyEndDate : -1 }}";
        endDate = endDate == '-1' ? '' : endDate;
        if (startDate && endDate) {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
                .datepicker('setStartDate', new Date(startDate))
                .datepicker('setEndDate', new Date(endDate))
        } else {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
        }



    }


    //  $(document).on('change', '#expense_type', function() {
    //      $('.js-parent-to-table').hide();
    //      let tableId = '.' + $(this).val();
    //      $(tableId).closest('.js-parent-to-table').show();
    //
    //  }) 



    $(function() {
        $('#expense_type').trigger('change')
        $('.js-type-btn.active').trigger('click')
    })

    $(function() {
        $(document).on('click', '.js-show-all-categories-trigger', function() {
            const elementToAppendIn = $(this).parent().find('.js-append-into');
            const texts = [];
            let lis = '';
            text = '<u><a href="#" data-close-new class="text-decoration-none mb-2 d-inline-block text-nowrap ">' + 'Add New' + '</a></u>'
            lis += '<li >' + text + '</li>'
            $(this).closest('table').find('.js-show-all-categories-popup').each(function(index, element) {
                let text = $(element).val().trim();
                if (text && !texts.includes(text)) {
                    texts.push(text)
                    text = '<a href="#" data-add-new class="text-decoration-none mb-2 d-inline-block">' + text + '</a>'
                    lis += '<li >' + text + '</li>'
                }
            })




            elementToAppendIn.removeClass('d-none');
            elementToAppendIn.find('ul').empty().append(lis);
        })


    })
    $(document).on('click', '[data-add-new]', function(e) {
        e.preventDefault();
        let content = $(this).html();
        $(this).closest('.js-common-parent').find('input').val(content);
    })
    $(document).on('click', '[data-close-new]', function(e) {
        e.preventDefault();
        $(this).closest('.js-append-into').addClass('d-none');
        $(this).closest('.js-common-parent').find('input').val('').focus();
    })
    $(document).on('click', function(e) {
        let closestParent = $(e.target).closest('.js-append-into').length;
        if (!closestParent && !$(e.target).hasClass('js-show-all-categories-trigger')) {
            $('.js-append-into').addClass('d-none');
        }
    })
    $(function() {
        // alert($('.reapter-select').length)
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-delete]').trigger('click');
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-create]').trigger('click');
    });

</script>
@endsection



@push('js_end')
<script src="{{ url('custom/math.js') }}" type="text/javascript"></script>

<script>
</script>
<script>
    $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
        if (!$(this).hasClass('exclude-text')) {
            let val = $(this).val()
            val = number_unformat(val)
            if (isNumber(val)) {
                $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)
            }

        }
    })
    $(document).on('click', '.repeat-to-r', function() {
        const columnIndex = $(this).data('column-index');
        const digitNumber = $(this).data('digit-number');
        const val = $(this).parent().find('input[type="hidden"]').val();
        $(this).closest('tr').find('.can-be-repeated-parent').each(function(index, parent) {
            if (index > columnIndex) {
                $(parent).find('.can-be-repeated-text').val(val);
                $(parent).find('.can-be-repeated-text').val(number_format(val, digitNumber));

            }
        })
    })


    $('select.js-condition-to-select').change(function() {
        const value = $(this).val();
        const conditionalValueTwoInput = $(this).closest('tr').find('input.conditional-b-input');
        if (value == 'between-and-equal' || value == 'between') {
            conditionalValueTwoInput.prop('disabled', false).trigger('change');
        } else {
            conditionalValueTwoInput.prop('disabled', true).trigger('change');
        }
    })

    $('select.js-condition-to-select').trigger('change');
    $(document).on('change', '.conditional-input', function() {
        if (!$(this).closest('tr').find('conditional-b-input').prop('disabled')) {
            const conditionalA = $(this).closest('tr').find('.conditional-a-input').val();
            const conditionalB = $(this).closest('tr').find('.conditional-b-input').val();
            if (conditionalA >= conditionalB) {
                if (conditionalA == 0 && conditionalB == 0) {
                    return;
                }
                Swal.fire('conditional a must be less than conditional b value');
                $(this).closest('tr').find('.conditional-a-input').val($(this).closest('tr').find('.conditional-b-input').val() - 1);
            }
        }

    })

</script>
<script>
    $(document).on('change', '.rate-element', function() {
        let total = 0;
        const parent = $(this).closest('tbody');
        parent.find('.rate-element-hidden').each(function(index, element) {
            total += parseFloat($(element).val());
        });
        parent.find('td.td-for-total-payment-rate').html(number_format(total, 2) + ' %');

    })

</script>
<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/select2.js"></script>
<script>
    $(document).on('change', 'select.expense_category', function() {
        const parent = $(this).closest('tr');
        const expenseCategoryId = $(this).val();
        const currentSelected = $(parent).find('select.expense_name_id').attr('data-current-selected');
        $.ajax({
            url: "{{ route('get.expense.name.for.category',['company'=>$company->id,'study'=>$study->id]) }}"
            , data: {
                expenseCategoryId
            }
            , success: function(res) {
                let result = res.data;
                let options = '';
                for (index in result) {
                    var row = result[index];
                    options += `<option ${currentSelected==row.id ? 'selected':''} value="${row.id}">${row.name}</option>`;
                }
                $(parent).find('select.expense_name_id').empty().append(options).trigger('change');
            }
        })
    })
    $('select.expense_category').trigger('change')

</script>
<script>
    $(document).on('change', '.recalculate-total-branches', function() {
        var totalBranchesCount = 0;
        $('.recalculate-total-branches').each(function(index, element) {
            var currentBranchCount = parseInt(number_unformat($(element).val()));
            totalBranchesCount += currentBranchCount;
            $(element).closest('tr').find('.total-branches-text').val(totalBranchesCount).trigger('change');
        })
    })
    $(function() {
        //		$('.recalculate-total-branches:eq(0)').trigger('change')
    })

</script>
@endpush
