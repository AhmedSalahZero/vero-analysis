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
    .js-parent-to-table {
        min-height: 50vh !important;
    }

</style>
@endsection
@section('sub-header')

<x-main-form-title :id="'main-form-title'" :class="''">{{ $title  }}</x-main-form-title>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{ route('store.expenses',['company'=>$company->id,'study'=>$study->id ]) }}">
            @csrf
            <input type="hidden" name="model_id" value="{{ $model->id ?? 0  }}">
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="model_name" value="Study">
            <input type="hidden" name="expense_type" value="{{ $expenseType }}">
            <input type="hidden" name="study_id" id="study-id-js" value="{{ $study->id }}">
            <input type="hidden" id="study-start-date" value="{{ $study->getStudyStartDate() }}">
            <input type="hidden" id="study-end-date" value="{{ $study->getStudyEndDate() }}">

            <div class="kt-portlet">


                <div class="kt-portlet__body">


                    <div class="form-group row justify-content-center">
                        @php
                        $index = 0 ;
                        @endphp
                        <div class="d-flex align-items-center justify-content-start " style="margin-right:auto">
                            @foreach(getTypesForValuesForNonBanking() as $typeElement)
                            <button data-value="{{ $typeElement['value'] }}" class="btn mb-5 js-type-btn type-btn btn btn-outline-info {{ $index == 0 ? 'active' :''  }}">{{ $typeElement['title'] }}</button>
                            @php
                            $index++;
                            @endphp
                            @endforeach
                        </div>



                        {{-- start of fixed monthly repeating amount --}}
                        @php
                        $tableId = 'fixed_monthly_repeating_amount';
                        $repeaterId = 'fixed_monthly_repeating_amount_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                        <x-tables.repeater-table :removeRepeater="false" :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Category')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down " :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Monthly <br> Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                {{-- <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th> --}}
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Annual <br> Increase%')"></x-tables.repeater-table-th>
                                {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th> --}}
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof Expense) ){
                                unset($subModel);
                                }

                                @endphp

                                <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>
                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>


                                    <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
                                    </td>

                                    <td>
                                        <x-form.select data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="@if($isRepeater) expense_name_id @else {{ $tableId }}[0][expense_name_id] @endif"></x-form.select>
                                    </td>

                                    <td>
                                        <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'start_date',
                                            'value'=>isset($subModel) ? $subModel->getStartDateYearAndMonth() : $study->getOperationStartDateYearAndMonth()
                                            ])

                                        </div>
                                        {{-- <x-form.label :class="'label'" :id="'test-id'">{{ __('Study Start Date') }} @include('star') </x-form.label> --}}

                                        {{-- <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar> --}}
                                    </td>
                                    <td>
                                        <input value="{{ (isset($subModel) ? number_format($subModel->getAmount(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getAmount() : 0) }}" @if($isRepeater) name="amount" @else name="{{ $tableId }}[0][amount]" @endif>

                                    </td>
                                    <td>
                                        <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'end_date',
                                            'value'=>isset($subModel) ? $subModel->getEndDateYearAndMonth() : $study->getStudyEndDateYearAndMonth()
                                            ])
                                        </div>

                                        {{-- <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar> --}}
                                    </td>
                                    <td>
									<div class="max-w-150">
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select payment_terms repeater-select  " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                        <x-modal.custom-collection :size="'sm'" :title="__('Payment Terms')" :subModel="isset($subModel) ? $subModel : null " :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection>
									
									</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS):0  }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                                        </div>
                                    </td>


                                    {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                    </div>
                    </td> --}}

                    <td>
                        <div class="d-flex align-items-center">
                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                            <span style="margin-left:3px	">%</span>
                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                        </div>
                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                            <span style="margin-left:3px	">%</span>
                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 0) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

                        </div>
                    </td>
                    {{-- <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif"></x-form.select>
                    </td> --}}


                    </tr>
                    @endforeach

                    </x-slot>




                    </x-tables.repeater-table>
                    {{-- end of fixed monthly repeating amount --}}



                    {{-- start of varying amount --}}
                    {{-- @php
                        $tableId = 'varying_amount';
                        $repeaterId = 'varying_amount_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                    <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                        <x-slot name="ths">
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                            @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                            <x-tables.repeater-table-th class="header-border-down col-md-2" :title="$yearIndexWithYear[$year] . ' <br> ' . __('Amount (Monthly)')"></x-tables.repeater-table-th>
                            @endforeach

                        </x-slot>
                        <x-slot name="trs">
                            @php
                            $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                            @endphp
                            @foreach( count($rows) ? $rows : [-1] as $subModel)
                            @php
                            if( !($subModel instanceof Expense) ){
                            unset($subModel);
                            }

                            @endphp
                            <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>
                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">
                                <td>
                                    <input value="{{ isset($subModel) ?  $subModel->getName() : '' }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                                </td>



                                <td>

                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select payment_terms repeater-select  " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                    <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                                    </div>
                                </td>
                                @php
                                $columnIndex = 0 ;
                                @endphp
                                @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                @php
                                $currentVal = 0;
                                @endphp
                                <td>
                                    <x-repeat-right-dot-inputs :currentVal="number_format($currentVal,1)" :classes="'only-greater-than-zero-allowed'" :is-percentage="false" :name="'payload'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                </td>

                                @php
                                $columnIndex++ ;
                                @endphp

                                @endforeach






                            </tr>
                            @endforeach

                        </x-slot>




                    </x-tables.repeater-table> --}}
                    {{-- end of varying amount --}}

                    {{-- start of fixed monthly repeating amount --}}
                    @php
                    $tableId = 'percentage_of_sales';
                    $repeaterId = 'percentage_of_sales_repeater';

                    @endphp
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                    <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                        <x-slot name="ths">
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Category')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Percentage <br> Of')" :helperTitle="__('Percentage Of')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-6 header-border-down" :title="__('Revenue <br> Stream')" :helperTitle="__('Revenue Stream')"></x-tables.repeater-table-th>

                            {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th> --}}

                            <x-tables.repeater-table-th class="col-md-1 header-border-down " :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="header-border-down rate-class" :title="__('Monthly <br> (%)')" :helperTitle="__('Please insert percentage excluding VAT')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                            {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> To')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> Value A')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> Value B')"></x-tables.repeater-table-th> --}}
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                            {{-- <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th> --}}





                            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                            {{-- <x-tables.repeater-table-th class="col-md-1" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class="col-md-2" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th> --}}
                        </x-slot>
                        <x-slot name="trs">
                            @php
                            $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                            @endphp
                            @foreach( count($rows) ? $rows : [-1] as $subModel)
                            @php
                            if( !($subModel instanceof Expense) ){
                            unset($subModel);
                            }

                            @endphp

                            <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}

                                <td>
								<div class="max-w-150">
                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
								
								</div>
                                    {{-- <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new> --}}
                                </td>

                                <td>
								<div class="max-w-150">
                                    <x-form.select data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="@if($isRepeater) expense_name_id @else {{ $tableId }}[0][expense_name_id] @endif"></x-form.select>
								</div>
                                </td>
                                <td>
                               <div class="max-w-125">
							        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPercentageOf() : 'service'" :options="getExpensesPercentageOfForSelect2()" :multiple="false" :add-new="false" class="select2-select repeater-select percentage-of-stream-type-js  " :all="false" name="@if($isRepeater) percentage_of @else {{ $tableId }}[0][percentage_of] @endif"></x-form.select>
							   </div>

                                </td>

                                <td>
								<div class="max-w-200">
								
                                    <x-select.multi-layer-for-repeater :selectedMainOptions="isset($subModel) ? $subModel->getRevenueStreamTypes() : []" :selectedSubOptions="isset($subModel) ? $subModel->getStreamCategoryIds() : []" :mainItemsName="'revenue_stream_type'" :subItemsName="'stream_category_ids'" :options="$revenueStreams"></x-select.multi-layer-for-repeater>
								</div>
                                </td>

                                {{-- <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategoryIds() : ''" :multiple="true" :options="[]" :add-new="false" class="select2-select repeater-select stream-category-class " :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                                </td> --}}


<td>

  <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'start_date',
                                            'value'=>isset($subModel) ? $subModel->getStartDateYearAndMonth() : $study->getOperationStartDateYearAndMonth()
                                            ])
                                        </div>
										
</td>

                                {{-- <td>
                                    <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                                </td> --}}
                                <td>

                                    <div class="d-flex align-items-center ">
                                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getMonthlyPercentage(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getMonthlyPercentage() : 0) }}" @if($isRepeater) name="monthly_percentage" @else name="{{ $tableId }}[0][monthly_percentage]" @endif>
                                    </div>
                                </td>
								<td>
								  <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'end_date',
                                            'value'=>isset($subModel) ? $subModel->getEndDateYearAndMonth() : $study->getStudyEndDateYearAndMonth()
                                            ])
                                        </div>
								
								</td>
                                {{-- <td>
                                    <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar>
                                </td> --}}

                                {{-- <td>
                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getConditionalTo() : ''" :options="getConditionalToSelect()" :add-new="false" class="select2-select js-condition-to-select repeater-select  "  :all="false" name="@if($isRepeater) conditional_to @else {{ $tableId }}[0][conditional_to] @endif"></x-form.select>

                                </td>


                                <td>
                                    <input value="{{ (isset($subModel) ? number_format($subModel->getConditionalValueA(),0) : 0) }}" class="form-control conditional-input conditional-a-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="{{ (isset($subModel) ? $subModel->getConditionalValueA() : 0) }}" @if($isRepeater) name="conditional_value_a" @else name="{{ $tableId }}[0][conditional_value_a]" @endif>
                                </td>

                                <td>
                                    <input value="{{ (isset($subModel) ? number_format($subModel->getConditionalValueB(),0) : 0) }}" class="form-control conditional-input conditional-b-input text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="{{ (isset($subModel) ? $subModel->getConditionalValueB() : 0) }}" @if($isRepeater) name="conditional_value_b" @else name="{{ $tableId }}[0][conditional_value_b]" @endif>
                                </td> --}}


                                <td class="closest-parent">

                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                    <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>
                                    </div>
                                </td>

                                {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                </div>
                </td> --}}

                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                    </div>
                </td>


                {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),2) : 0 }}" type="text">
                <span style="margin-left:3px	">%</span>
                <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 0) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

            </div>
            </td>
            <td>
                <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

            </td> --}}


            </tr>
            @endforeach

            </x-slot>




            </x-tables.repeater-table>
            {{-- end of fixed monthly repeating amount --}}





            {{-- start of varying percentage --}}
            {{-- @php
                    $tableId = 'varying_percentage_of_sales';
                    $repeaterId = 'varying_percentage_of_sales_repeater';

                    @endphp
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
            <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                <x-slot name="ths">
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Percentage <br> Of')" :helperTitle="__('Percentage Of')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Revenue <br> Stream')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th>


                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="$yearIndexWithYear[$year] . ' <br> ' . __('%')"></x-tables.repeater-table-th>
                    @endforeach
                </x-slot>
                <x-slot name="trs">
                    @php
                    $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                    @endphp
                    @foreach( count($rows) ? $rows : [-1] as $subModel)
                    @php
                    if( !($subModel instanceof Expense) ){
                    unset($subModel);
                    }

                    @endphp
                    <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                        <td class="text-center">
                            <div class="">
                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                </i>
                            </div>
                        </td>


                        <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">
                        <td>
                            <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                        </td>
                        </td>
                        <td>
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getPercentageOf() : 'service'" :options="getExpensesPercentageOfForSelect2()" :multiple="false" :add-new="false" class="select2-select repeater-select percentage-of-stream-type-js  " :all="false" name="@if($isRepeater) revenue_stream_type @else {{ $tableId }}[0][revenue_stream_type] @endif"></x-form.select>
                        </td>

                        <td>
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getRevenueStreamType() : 'service'" :options="$revenueStreamTypes" :multiple="true" :add-new="false" class="select2-select repeater-select  revenue-stream-type-js" :all="false" name="@if($isRepeater) revenue_stream_type @else {{ $tableId }}[0][revenue_stream_type] @endif"></x-form.select>

                        </td>

                        <td>
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategory() : ''" :multiple="true" :options="getAllocationsBases()" :add-new="false" class="select2-select repeater-select  stream-category-class" :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                        </td>



                        <td>
                            <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : null " :id="'start_date'" name="start_date"></x-calendar>
                        </td>

                        <td>
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select payment_terms repeater-select  " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                            <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>


                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                            </div>
                        </td>


                        @php
                        $columnIndex = 0 ;
                        @endphp
                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                        @php
                        $currentVal = 0 ;
                        @endphp
                        <td>
                            <x-repeat-right-dot-inputs :currentVal="number_format($currentVal,1)" :classes="'only-greater-than-zero-allowed'" :is-percentage="true" :name="'payload'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                        </td>

                        @php
                        $columnIndex++ ;
                        @endphp

                        @endforeach




                    </tr>
                    @endforeach

                </x-slot>




            </x-tables.repeater-table> --}}
            {{-- end of varying percentage --}}








            {{-- start of fixed cost per unit --}}
            @php
            $tableId = 'cost_per_unit';
            $repeaterId = 'cost_per_unit_repeater';

            @endphp
            <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
            <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="''" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                <x-slot name="ths">
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Category')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class=" header-border-down" :title="__('Contracts <br> Types')" :helperTitle="__('Revenue Stream')"></x-tables.repeater-table-th>
                    {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th> --}}

                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Cost <br> Per Unit')" :helperTitle="__('Please insert Cost Per Unit excluding VAT')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                    {{-- <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th> --}}
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                    <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Annual <br> Increase%')"></x-tables.repeater-table-th>
                    {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th> --}}
                </x-slot>
                <x-slot name="trs">
                    @php
                    $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                    @endphp
                    @foreach( count($rows) ? $rows : [-1] as $subModel)
                    @php
                    if( !($subModel instanceof Expense) ){
                    unset($subModel);
                    }

                    @endphp
                    <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                        <td class="text-center">
                            <div class="">
                                <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                </i>
                            </div>
                        </td>


                        <td>
							<div class="max-w-150">
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
							
							</div>
                        </td>


                        <td>
						<div class="max-w-150">
                            <x-form.select data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="@if($isRepeater) expense_name_id @else {{ $tableId }}[0][expense_name_id] @endif"></x-form.select>
						
						</div>
                        </td>

                        {{-- <td>
                                    <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                        </td> --}}

                        <td>
							<div class="max-w-200">
                            	<x-select.multi-layer-for-repeater :selectedMainOptions="isset($subModel) ? $subModel->getRevenueStreamTypes() : []" :selectedSubOptions="isset($subModel) ? $subModel->getStreamCategoryIds() : []" :mainItemsName="'revenue_stream_type'" :subItemsName="'stream_category_ids'" :options="$revenueStreams"></x-select.multi-layer-for-repeater>
							</div>
                        </td>
                        {{--
                                <td>
                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategoryIds() : ''" :options="getAllocationsBases()" :multiple="true" :add-new="false" class="select2-select repeater-select  stream-category-class" :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                        </td> --}}




                        <td>
						
						  <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'start_date',
                                            'value'=>isset($subModel) ? $subModel->getStartDateYearAndMonth() : $study->getOperationStartDateYearAndMonth()
                                            ])
                                        </div>
										
                        </td>
                        <td>
                            <input value="{{ (isset($subModel) ? number_format($subModel->getMonthlyCostOfUnit(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getMonthlyCostOfUnit() : 0) }}" @if($isRepeater) name="monthly_cost_of_unit" @else name="{{ $tableId }}[0][monthly_cost_of_unit]" @endif>

                        </td>


                        <td>
						
						<div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'end_date',
                                            'value'=>isset($subModel) ? $subModel->getEndDateYearAndMonth() : $study->getStudyEndDateYearAndMonth()
                                            ])
                                        </div>
										
                            {{-- <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar> --}}
                        </td>
                        <td>
                            <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                            <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>


                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                <span style="margin-left:3px	">%</span>
                                <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                            </div>
                        </td>


                        {{-- <td>
                                    <div class="d-flex align-items-center">
                                        <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
    </div>
    </td> --}}

    <td>
        <div class="d-flex align-items-center">
            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
            <span style="margin-left:3px	">%</span>
            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
        </div>
    </td>


    <td>
        <div class="d-flex align-items-center">
            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
            <span style="margin-left:3px	">%</span>
            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 0) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

        </div>
    </td>
    {{-- <td>
                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

    </td> --}}


    </tr>
    @endforeach

    </x-slot>




    </x-tables.repeater-table>
    {{-- end of fixed cost per unit --}}





    {{-- start of varying cost per unit --}}
    {{-- @php
                    $tableId = 'varying_cost_per_unit';
                    $repeaterId = 'varying_cost_per_unit_repeater';

                    @endphp
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
    <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
        <x-slot name="ths">
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Revenue <br> Type')"></x-tables.repeater-table-th>

            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th>


            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
            @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="$yearIndexWithYear[$year] . ' <br> ' . __('Amount')"></x-tables.repeater-table-th>
            @endforeach
        </x-slot>
        <x-slot name="trs">
            @php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
            @endphp
            @foreach( count($rows) ? $rows : [-1] as $subModel)
            @php
            if( !($subModel instanceof Expense) ){
            unset($subModel);
            }

            @endphp
            <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>


                <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">
                <td>
                    <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                </td>

                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getRevenueStreamType() : 'service'" :options="$revenueStreamTypes" :multiple="true" :add-new="false" class="select2-select repeater-select revenue-stream-type-js " :all="false" name="@if($isRepeater) revenue_stream_type @else {{ $tableId }}[0][revenue_stream_type] @endif"></x-form.select>

                </td>



                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategory() : ''" :multiple="true" :options="getAllocationsBases()" :add-new="false" class="select2-select repeater-select  stream-category-class" :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                </td>




                <td>
                    <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : null " :id="'start_date'" name="start_date"></x-calendar>
                </td>

                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                    <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>

                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                    </div>
                </td>


                @php
                $columnIndex = 0 ;
                @endphp
                @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                @php
                $currentVal=0;
                @endphp
                <td>
                    <x-repeat-right-dot-inputs :currentVal="number_format($currentVal,1)" :classes="'only-greater-than-zero-allowed'" :is-percentage="true" :name="'payload'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                </td>

                @php
                $columnIndex++ ;
                @endphp

                @endforeach




            </tr>
            @endforeach

        </x-slot>




    </x-tables.repeater-table> --}}
    {{-- end of varying cost Per unit --}}












    {{-- start of intervally repeating amount --}}
    {{-- @php
                    $tableId = 'intervally_repeating_amount';
                    $repeaterId = 'intervally_repeating_amount_repeater';

                    @endphp
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
    <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
        <x-slot name="ths">
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Category')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> After')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th>
        </x-slot>
        <x-slot name="trs">
            @php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
            @endphp
            @foreach( count($rows) ? $rows : [-1] as $subModel)
            @php
            if( !($subModel instanceof Expense) ){
            unset($subModel);
            }

            @endphp
            <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>
                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>

                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
                </td>

                <td>
                    <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                </td>

                <td>
                    <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                </td>
                <td>
                    <input value="{{ (isset($subModel) ? number_format($subModel->getAmount(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="{{ (isset($subModel) ? $subModel->getAmount() : 0) }}" @if($isRepeater) name="amount" @else name="{{ $tableId }}[0][amount]" @endif>

                </td>
                <td>
                    <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar>
                </td>
                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                    <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>


                </td>
                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getInterval() : 2" :options="getPaymentIntervals()" :add-new="false" class="select2-select repeater-select  " :all="false" name="@if($isRepeater) interval @else {{ $tableId }}[0][interval] @endif"></x-form.select>

                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                    </div>
                </td>


                <td>
                    <div class="d-flex align-items-center">
                        <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                    </div>
                </td>


                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 0) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

                    </div>
                </td>
                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

                </td>


            </tr>
            @endforeach

        </x-slot>




    </x-tables.repeater-table> --}}
    {{-- end of intervally repeating amount --}}






    {{-- start of one time expense --}}
    @php
    $tableId = 'one_time_expense';
    $repeaterId = 'one_time_expense_repeater';

    @endphp
    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
    <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
        <x-slot name="ths">
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Category')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Amortization <br> Months')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
            {{-- <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th> --}}
            <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
            {{-- <x-tables.repeater-table-th class="col-md-1" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th> --}}
            {{-- <x-tables.repeater-table-th class="col-md-2" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th> --}}
        </x-slot>
        <x-slot name="trs">
            @php
            $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
            @endphp
            @foreach( count($rows) ? $rows : [-1] as $subModel)
            @php
            if( !($subModel instanceof Expense) ){
            unset($subModel);
            }

            @endphp
            <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>
                <td class="text-center">
                    <div class="">
                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                        </i>
                    </div>
                </td>

                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>

                </td>
                {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}
                <td>
                    <x-form.select data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="@if($isRepeater) expense_name_id @else {{ $tableId }}[0][expense_name_id] @endif"></x-form.select>
                </td>

                <td>
				
				 <div class="max-w-150">
                                            @include('components.calendar-month-year',[
                                            'name'=>'start_date',
                                            'value'=>isset($subModel) ? $subModel->getStartDateYearAndMonth() : $study->getOperationStartDateYearAndMonth()
                                            ])
                                        </div>
										
                    {{-- <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar> --}}
                </td>
                <td>
                    <input value="{{ (isset($subModel) ? number_format($subModel->getAmount(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="{{ (isset($subModel) ? $subModel->getAmount() : 0) }}" @if($isRepeater) name="amount" @else name="{{ $tableId }}[0][amount]" @endif>
                </td>
				
				<td>
                    <input value="{{ (isset($subModel) ? number_format($subModel->getAmortizationMonths(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                    <input type="hidden" value="{{ (isset($subModel) ? $subModel->getAmortizationMonths() : 0) }}" @if($isRepeater) name="amortization_months" @else name="{{ $tableId }}[0][amortization_months]" @endif>
                </td>
				
                <td>
                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                    <x-modal.custom-collection-new :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection-new>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                        <span style="margin-left:3px	">%</span>
                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                    </div>
                </td>

                {{-- <td>
                                    <div class="d-flex align-items-center">
                                        <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
</div>
</td> --}}
<td>
    <div class="d-flex align-items-center">
        <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
        <span style="margin-left:3px	">%</span>
        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 0) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
    </div>
</td>


{{-- <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),0) : 0 }}" type="text">
<span style="margin-left:3px	">%</span>
<input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 0) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

</div>
</td>
<td>
    <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

</td> --}}


</tr>
@endforeach

</x-slot>




</x-tables.repeater-table>
{{-- end of one time expense --}}













































</div>


</div>
</div>
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


    $(document).on('click', '.js-type-btn', function(e) {
        e.preventDefault();
        $('.js-type-btn').removeClass('active');
        $(this).addClass('active');
        $('.js-parent-to-table').hide();
        let tableId = '.' + $(this).attr('data-value');
        $(tableId).closest('.js-parent-to-table').show();

    })
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



    $(function() {
        $('.rate-element').trigger('change');
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
    $(function() {
        //	$('button.js-type-btn[data-value="percentage_of_sales"]').trigger('click')
    })

</script>
<script>
    $(function() {
        $('.only-month-year-picker').each(function(index, dateInput) {
            var $input = $(dateInput);
            var currentDate = $input.val();

            var startDate = "{{ isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1 }}";
            startDate = startDate == '-1' ? '' : startDate;

            var endDate = "{{ isset($studyEndDate) && $studyEndDate ? $studyEndDate : -1 }}";
            endDate = endDate == '-1' ? '' : endDate;

            var options = {
                viewMode: "years"
                , minViewMode: "months"
                , todayHighlight: false
                , clearBtn: true
                , autoclose: true
                , format: "yyyy-mm-01"
            , };

            if (startDate && endDate) {
                options.startDate = new Date(startDate);
                options.endDate = new Date(endDate);
            }

            $input.datepicker(options);

            // ✅ معالجة القيمة الافتراضية
            if (currentDate) {
                try {
                    let date = new Date(currentDate);
                    let year = date.getFullYear();
                    let month = String(date.getMonth() + 1).padStart(2, '0');

                    let displayValue = `${year}-${month}`;
                    let fullValue = `${year}-${month}-01`;

                    // عرض السنة والشهر فقط
                    $input.val(displayValue);
                    $input.data('full-date', fullValue);

                    // تعيين التاريخ للـ datepicker
                    $input.datepicker('setDate', new Date(fullValue));
                } catch (e) {
                    console.warn('Invalid default date:', currentDate);
                }
            }

            // ✅ عند تغيير التاريخ
            $input.on('changeDate', function(e) {
                if (e.date) {
                    let year = e.date.getFullYear();
                    let month = String(e.date.getMonth() + 1).padStart(2, '0');

                    let displayValue = `${year}-${month}`;
                    let fullValue = `${year}-${month}-01`;

                    setTimeout(() => {
                        $input.val(displayValue);
                        $input.data('full-date', fullValue);
                    }, 10);
                }
            });
            $input.on('blur', function() {
                let val = $input.val();
                // إذا كانت الصيغة مثل 2025-06-01
                if (/^\d{4}-\d{2}-01$/.test(val)) {
                    let parts = val.split('-');
                    let year = parts[0];
                    let month = parts[1];
                    let fullDate = `${year}-${month}-01`;
                    let displayDate = `${year}-${month}`;

                    $input.val(displayDate); // نعرض السنة والشهر فقط
                    $input.data('full-date', fullDate); // نخزن التاريخ الكامل
                }
            });

        });




        // ✅ قبل إرسال النموذج، نُعيد القيم الكاملة
        $('form').on('submit', function() {
            $('.only-month-year-picker').each(function(_, input) {
                var $input = $(input);
                var fullDate = $input.data('full-date');

                if (fullDate) {
                    $input.val(fullDate);
                }
            });
        });


    })

</script>
<script>
    $(document).on('changed.bs.select', 'select.js-due_in_days', function(e, clickedIndex, isSelected, previousValue) {
        if (isSelected) {
            let currentValue = $(this).find('option').eq(clickedIndex).val();

            setTimeout(() => {
                $(this).selectpicker('val', [currentValue]).selectpicker('refresh');
            }, 0);
        }
    });

</script>
@endpush
