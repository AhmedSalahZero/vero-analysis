@extends('layouts.dashboard')
@php
 use App\Models\NonBankingService\Study;
 use App\Models\NonBankingService\MicrofinanceBreakdown;
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


			  {{-- start of Microfinance Revenue Projection By Category   --}}
             <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Microfinance Branches & Loan Cases Info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <x-show-hide-btn :query="'.microfinance-branches-loan-cases-info'"></x-show-hide-btn>
                        </div>
                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row microfinance-branches-loan-cases-info">
                        @php
                        $rowIndex = 0;
                        @endphp


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Operating Months Per Year') }}" disabled class="form-control text-left mt-2" type="text">
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
								
								
								  <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="{{ __('Branches Count') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal =0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true"  :removeCurrency="true" :removeThreeDotsClass="true" :removeThreeDots="true" :number-format-decimals="0"  :currentVal="$currentVal" :formattedInputClasses="''" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>
								
								
								 <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="{{ __('Loan Officers Count') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal =0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true" :removeCurrency="true" :removeThreeDotsClass="true" :removeThreeDots="true" :number-format-decimals="0"  :currentVal="$currentVal" :formattedInputClasses="''" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>
								


                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="{{ __('Total Loan Case Count') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal =  0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true" :removeCurrency="true" :removeThreeDotsClass="true" :removeThreeDots="true" :number-format-decimals="0"  :currentVal="$currentVal" :formattedInputClasses="''" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>






                            </x-slot>




                        </x-tables.repeater-table>
						
						
						
						
						
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Microfinance Revenue Projection By Category   --}}
			

            {{-- start of Factoring Revenue Projection By Category   --}}

            {{-- start of Microfinance Revenue Projection By Category   --}}
             <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Microfinance Revenue Projection By Category') }}
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
                                <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Item')"></x-tables.repeater-table-th>
                               @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">

                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Operating Months Per Year') }}" disabled class="form-control text-left mt-2" type="text">
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

                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                    <td>
                                        <div class="">
                                            <input value="{{ __('Growth Rate %') }}" disabled class="form-control text-left mt-2" type="text">
                                        </div>


                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;
							
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->microfinanceRevenueProjectionByCategory ? $model->microfinanceRevenueProjectionByCategory->getGrowthRateAtYearOrMonthIndex($yearOrMonthAsIndex) : 0" :classes="'only-greater-than-or-equal-zero-allowed recalculate-gr gr-field'" :is-percentage="true" :name="'MicrofinanceRevenueProjectionByCategory['.'growth_rates'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>




                             

                                


                                <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="{{ __('Avg Loan Case Amount') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal = $model->microfinanceRevenueProjectionByCategory ? $model->microfinanceRevenueProjectionByCategory->getLoanAmountsAtYearIndex($year) : 0;
							
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :number-format-decimals="0"  :currentVal="$currentVal" :formattedInputClasses="'current-growth-rate-result-value-formatted'" :classes="'only-greater-than-or-equal-zero-allowed total-loans-hidden js-recalculate-equity-funding-value factoring-projection-amount recalculate-factoring current-growth-rate-result-value'" :is-percentage="false" :name="'MicrofinanceRevenueProjectionByCategory['.'loan_case_amounts'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>
								
								      <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                    <td>
                                            <input value="{{ __('Total Loan Case Amount') }}" disabled class="form-control text-left mt-2" type="text">
                                    </td>


                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    @php
                                    $currentVal =  0;
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :readonly="true"  :removeThreeDotsClass="true" :removeThreeDots="true" :number-format-decimals="0"  :currentVal="$currentVal" :formattedInputClasses="''" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex++ ;
                                    @endphp

                                    @endforeach


                                </tr>
								






                            </x-slot>




                        </x-tables.repeater-table>
						
						
						
						
						
                        {{-- end of fixed monthly repeating amount --}}


                    </div>

                </div>
            </div>
            {{-- end of Microfinance Revenue Projection By Category   --}}


            {{-- end of Factoring Revenue Projection By Category   --}}

				
				
				 {{-- start of Microfinance Breakdown   --}}
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                    {{ __('Microfinance Breakdown') }}
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
                        $relationName ='microfinanceBreakdowns';
                        $repeaterId =$relationName.'repeater';
						@endphp
                        <x-tables.repeater-table :tableName="$relationName" :repeaterId="$repeaterId" :removeActionBtn="false" :removeRepeater="false" :initialJs="true" :repeater-with-select2="true" :canAddNewItem="true" :parentClass="'js-remove-hidden scrollable-table'" :hide-add-btn="true" :relationName="$relationName" :isRepeater="true">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" category-selector-class header-border-down w-header-400" :title="__('Product / Installment Interval')"></x-tables.repeater-table-th>
                                     <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Tenor <br> (Months)')"></x-tables.repeater-table-th>
                                     <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Funded')"></x-tables.repeater-table-th>
                                     {{-- <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Funded <br> ODAs')"></x-tables.repeater-table-th> --}}
                                <x-tables.repeater-table-th class=" tenor-selector-class header-border-down " :title="__('Info')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class=" interval-class header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
                                @endforeach
                            </x-slot>
                            <x-slot name="trs">
								@php
                            $rows = count($model->microfinanceBreakdowns) ? $model->microfinanceBreakdowns : [-1] ;
                            @endphp
                             @foreach( count($rows) ? $rows : [-1] as $subModel)
                            @php
                             if( !($subModel instanceof MicrofinanceBreakdown) ){
                             unset($subModel);
                             }
                            @endphp
					
                                <tr 
								
								data-repeater-item
								
								data-repeat-formatting-decimals="2" data-repeater-style>
									
									<td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>
								
                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">

                                    <td>
                           				 <x-form.select :required="true" :label="''" :pleaseSelect="false" :selectedValue="isset($subModel) ? $subModel->getMicrofinanceProductId() : ''" :options="$microfinanceProductsFormatted" :add-new="false" class="select2-select  repeater-select  "  :all="false" name="microfinance_product_id"></x-form.select>
                           				 <x-form.select :required="true" :label="''" :pleaseSelect="false" :selectedValue="isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly'" :options="[['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]]" :add-new="false" class="select2-select  repeater-select  "  :all="false" name="installment_interval"></x-form.select>
										  {{-- <input value="{{ __('Microfinance Projection') }}" disabled class="form-control text-left mt-2" type="text"> --}}
										  
                                    </td>
										 <td>
                                                                                   <x-repeat-right-dot-inputs number-format-decimals="0" :mark="'Mth'" :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getTenor():12" :classes="'only-greater-than-zero-allowed'" :is-percentage="true" :name="'tenor'" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td>
									  <td class="text-center">

                 <div class="form-group d-inline-block">
                     <div class="kt-radio-inline">
                         <label class="mr-3">

                         </label>
                         <label class="kt-radio kt-radio--success text-black font-size-18px font-weight-bold">

                             <input type="radio" value="1" name="is_funding_by_mtl" @if(isset($subModel) && $subModel->isMtl()) checked @endisset
                             > {{ __('MTLs') }}
                             <span></span>
                         </label>

                         <label class="kt-radio kt-radio--danger text-black font-size-18px font-weight-bold">
                             <input type="radio" value="0" name="is_funding_by_mtl" @if(isset($subModel) && $subModel->isOda()) checked @endisset
                             > {{ __('ODAs') }}
                             <span></span>
                         </label>
                     </div>
                 </div>

             </td>
									 {{-- <td>
                                                                                   <x-repeat-right-dot-inputs number-format-decimals="0" :mark="'Mth'" :remove-three-dots="true" :currentVal="isset($subModel) ? $subModel->getGracePeriod():0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'grace_period'" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td> --}}
									 <td>
                                                                                   <x-repeat-right-dot-inputs :removeCurrency="true" :readonly="true" :remove-three-dots="true" :currentVal="__('Contribution %')" :classes="''" :is-number="false" :is-percentage="false" :name="''" :columnIndex="null"></x-repeat-right-dot-inputs>
                                                                                   <x-repeat-right-dot-inputs :removeCurrency="true" :readonly="true" :remove-three-dots="true" :currentVal="__('Loan Amount')" :classes="''" :is-number="false" :is-percentage="false" :name="''" :columnIndex="null"></x-repeat-right-dot-inputs>
                                                                                   <x-repeat-right-dot-inputs :removeCurrency="true" :readonly="true" :remove-three-dots="true" :currentVal="__('Flat Rate')" :classes="''" :is-number="false" :is-percentage="false" :name="''" :columnIndex="null"></x-repeat-right-dot-inputs>

                                    </td>
											
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    <td>
                                            <x-repeat-right-dot-inputs :multiple="true" :currentVal="isset($subModel) ? $subModel->getContributionPercentageAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed recalculate-factoring factoring-rate'" :is-percentage="true" :name="'contribution_percentages'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                            <x-repeat-right-dot-inputs  :multiple="true" :number-format-decimals="0" :currentVal="isset($subModel) ? $subModel->getLoanAmountPayloadAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed current-loan-input factoring-value'" :is-percentage="false" :name="'loan_amounts'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                            <x-repeat-right-dot-inputs :multiple="true" :currentVal="isset($subModel) ? $subModel->getFlatRateAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed '" :is-percentage="true" :name="'flat_rates'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
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
            {{-- end of Microfinance Breakdown   --}}
			
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


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class=" header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                <x-tables.repeater-table-th class="  header-border-down " :title="$yearOrMonthFormatted"></x-tables.repeater-table-th>
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
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                   
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :currentVal="$model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getAdminFeesRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'microfinanceAdminFeesRate['.'admin_fees_rates'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
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
                                            <x-repeat-right-dot-inputs :currentVal="$model->microfinanceAdminFeesRate ? $model->microfinanceAdminFeesRate->getEclRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="true" :name="'microfinanceAdminFeesRate['.'ecl_rates'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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


                        <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
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
                                        <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control text-left mt-2" type="text">

                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    @endphp
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">

                                            <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'microfinanceNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                    @foreach($yearOrMonthsIndexes as $yearOrMonthAsIndex=>$yearOrMonthFormatted)
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs  :readonly="true" :numberFormatDecimals="0" :currentVal="$model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getEquityFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'microfinanceNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
                                            <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="microfinanceNewPortfolioFundingStructure[new_loans_funding_rates][{{ $yearOrMonthAsIndex }}]" value="{{ $model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getNewLoansFundingRatesAtYearOrMonthIndex($yearOrMonthAsIndex):0 }}"> <span class="ml-2">%</span>
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
                                            <x-repeat-right-dot-inputs :readonly="true" :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->microfinanceNewPortfolioFundingStructure ? $model->microfinanceNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearOrMonthIndex($yearOrMonthAsIndex):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'microfinanceNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$yearOrMonthAsIndex.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

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
 


   


</script>

<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/select2.js"></script>
<script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>
{{-- <script></script> --}}
@endsection
