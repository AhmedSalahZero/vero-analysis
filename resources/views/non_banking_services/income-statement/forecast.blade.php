@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\Study;
@endphp
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
@endsection
@section('sub-header')
{{ $title }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == Study::STUDY ?'active':'' }}" data-toggle="tab" href="#{{Study::STUDY  }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ $tableTitle }}
                    </a>
                </li>
            </ul>



        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            @php
            $currentType = Study::STUDY ;
            @endphp
            <!--Begin:: Tab Content-->
            <div class="tab-pane {{  !Request('active') || Request('active') == $currentType ?'active':'' }}" id="{{ $currentType }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">




                    @php
                    $rowIndex = 0;
                    @endphp
                    <x-tables.repeater-table :tableClasses="'table-condensed table-row-spacing income-class-table'" :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden scrollable-table'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                        <x-slot name="ths">
                            <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('+/-')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="  header-border-down first-column-th-class" :title="__('Name')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Add')"></x-tables.repeater-table-th>
                            @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
                            @php
                            $currentMonthNumber = explode('-',$dateAsString)[1];
                            $currentYear= explode('-',$dateAsString)[0];
                            $currentYearRepeaterIndex = 0 ;
                            @endphp
                            <x-tables.repeater-table-th data-column-index="{{ $dateAsIndex }}" class=" interval-class header-border-down " :title="dateFormatting($dateAsString, 'M\' Y')"></x-tables.repeater-table-th>

                            @if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last)
                            <x-tables.repeater-table-th :icon="true" data-column-index="{{ $dateAsIndex }}" :font-size-class="'font-14px'" class=" interval-class header-border-down {{ 'year-repeater-index-'.$currentYearRepeaterIndex }} collapse-before-me exclude-from-collapse " :title="__('Total Yr.').' <br> '. $currentYear"></x-tables.repeater-table-th>
                            @php
                            $currentYearRepeaterIndex ++;
                            @endphp
                            @endif

                            @endforeach
                            <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Total')"></x-tables.repeater-table-th>
                        </x-slot>
                        <x-slot name="trs">

                            @php
                 //           $currentExpenseType='cost-of-service';
                            @endphp
							@foreach($tableDataFormatted as $tableIndex => $currentTableData) 
							@php
								$subItems = $currentTableData['sub_items']??[] ;
								$hasSubItems = count($subItems);
							@endphp
                            <tr data-is-main-row data-repeat-formatting-decimals="0" data-repeater-style>
                                <td>
									@if($hasSubItems)
                                    <a href="#" class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
                                        <i class="fas fa-angle-double-down expand-icon   exclude-icon"></i>
                                    </a>
									@endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-column " style="gap:10px">
									@php
										$currentIndex = 0 ;
									@endphp
									@foreach($currentTableData['main_items'] as $mainItemId => $mainItemArr)
									
                                        <x-repeat-right-dot-inputs :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="$mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals']" :currentVal="$mainItemArr['options']['title']??$mainItemId" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
										@php
											$currentIndex++;
										@endphp
                                        {{-- <x-repeat-right-dot-inputs :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="__('Growth Rate %')" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs> --}}
										@endforeach 

                                    </div>
                                </td>
                                <td>
								@if($hasSubItems)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a data-toggle="modal" data-target="#add-new-cost-of-good" href="#" class="btn btn-2-bg btn-sm btn-brand btn-pill">{{ __('+') }}</a>


                                        {{-- <div class="modal fade" id="add-new-cost-of-good" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered max-width-modal-income-statement" role="document">
                                                <div class="modal-content modal-content-border">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-black" id="exampleModalLongTitle">{{ __('Do You Want To Add ?') }}</h5>
                                                        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="btn-parent d-flex justify-content-between " style="gap:10px !important">
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="{{ route('view.cost.expenses',['company'=>$company->id ,'study'=>$study->id ]) }}" class="btn btn-outline-info ">{{ __('Cost & Expenses') }}</a>
                                                            </span>
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="{{ route('view.manpower',['company'=>$company->id , 'study'=>$study->id,'expenseType'=>$currentExpenseType]) }}" class="btn btn-outline-info ">{{ __('Manpower Expense') }}</a>
                                                            </span>
                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="{{ route('view.manpower',['company'=>$company->id , 'study'=>$study->id,'expenseType'=>$currentExpenseType]) }}" class="btn btn-outline-info ">{{ __('Expense Per Employee') }}</a>
                                                            </span>

                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="#" class="btn btn-outline-info ">{{ __('Depreciation Expense') }}</a>
                                                            </span>

                                                            <span class="kt-list-timeline__time disable">
                                                                <a href="#" class="btn btn-outline-info ">{{ __('Add New Fixed Asset') }}</a>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary border-green" data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div> --}}

                                    </div>
									@endif
                                </td>
                                @php
                                $currentYearRepeaterIndex = 0 ;
                                @endphp

                                @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
								@php
									// dd($salesRevenuePerTypes);
									//$currentVal = $salesRevenuePerTypes[$dateAsIndex];
								@endphp
                                <td data-column-index="{{ $dateAsIndex }}">

                                    <div data-column-index="{{ $dateAsIndex }}" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
										@php
											$currentIndex = 0 ;
										@endphp
										@foreach($currentTableData['main_items'] as $mainItemTitle => $mainItemArr)
                                        <x-repeat-right-dot-inputs :readonly="false" :classes="$mainItemArr['options']['classes']??$defaultClasses[$currentIndex]['classes']" data-group-index="{{ $currentIndex ==0   ? $currentYearRepeaterIndex : -1 }}"  :formattedInputClasses="$mainItemArr['options']['formatted-input-classes']??$defaultClasses[$currentIndex]['formatted-input-classes']" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="true" :removeThreeDotsClass="true" :numberFormatDecimals="$mainItemArr['options']['number-format-decimals']??$defaultClasses[$currentIndex]['number-format-decimals']"  :currentVal="$mainItemArr['data'][$dateAsIndex]??0"  :is-percentage="$mainItemArr['options']['is-percentage']??$defaultClasses[$currentIndex]['is-percentage']" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs>
										@php
											$currentIndex++;
										@endphp
                                        @endforeach 
										{{-- <x-repeat-right-dot-inputs :removeThreeDots="true" :is-number="true" :removeThreeDotsClass="true" :number-format-decimals="2" :currentVal="0" :classes="''" :is-percentage="true" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs> --}}
										
                                    </div>




                                </td>

                                @php
                                $currentMonthNumber = explode('-',$dateAsString)[1];
                                $currentYear= explode('-',$dateAsString)[0];
                                @endphp
                                @if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last)

                                <td data-column-index="{{ $dateAsIndex }}" class="exclude-from-collapse">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <x-repeat-right-dot-inputs :readonly="true" :removeThreeDots="true" :number-format-decimals="0" :mark="' '" :currentVal="0 " :formattedInputClasses="'exclude-from-collapse repeat-group-year'" :classes="'year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse'" :is-percentage="true" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs>
                                    </div>

                                </td>
                                @php
                                $currentYearRepeaterIndex++;
                                @endphp
                                @endif

                                @endforeach
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <x-repeat-right-dot-inputs :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="true" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="'total-td'" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                    </div>
                                </td>
                            </tr>
							@foreach($subItems as $subItemId => $subItemArr)
                            <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
                                <td>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
                                        <x-repeat-right-dot-inputs :readonly="true" :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="$subItemArr['options']['title']??$subItemId" :classes="''" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                    </div>
                                </td>
                                <td>

                                </td>

                                @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
                                <td data-column-index="{{ $dateAsIndex }}">

                                    <div data-column-index="{{ $dateAsIndex }}" class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                        <x-repeat-right-dot-inputs :readonly="true" :formattedInputClasses="$subItemArr['options']['formatted-input-classes']??$defaultClasses[0]['formatted-input-classes']" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="true" :removeThreeDotsClass="true" :number-format-decimals="$subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals']" :currentVal="$subItemArr['data'][$dateAsIndex]??0" :classes="$subItemArr['options']['classes']??''" :is-percentage="$subItemArr['options']['number-format-decimals']??$defaultClasses[0]['number-format-decimals']" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs>
                                    </div>
                                </td>
                                @php
                                $currentMonthNumber = explode('-',$dateAsString)[1];
                                $currentYear= explode('-',$dateAsString)[0];
                                @endphp

                                @if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last)

                                <td data-column-index="{{ $dateAsIndex }}" class="exclude-from-collapse">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <x-repeat-right-dot-inputs :readonly="true" :removeThreeDots="true" :number-format-decimals="0" :mark="' '" :currentVal="0 " :formattedInputClasses="'exclude-from-collapse '" :classes="'year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse'" :is-percentage="true" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs>
                                    </div>

                                </td>
                                @php
                                $currentYearRepeaterIndex++;
                                @endphp
                                @endif

                                @endforeach
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <x-repeat-right-dot-inputs :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="true" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="'total-td'" :is-percentage="false" :name="''" :columnIndex="-1"></x-repeat-right-dot-inputs>
                                    </div>
                                </td>
                            </tr>
							
							
							@endforeach 
							@endforeach 


                            {{-- @for($i = 0 ; $i<0 ; $i++) <tr data-is-main-row data-repeat-formatting-decimals="0" data-repeater-style>
                                <td>
                                    <a href="#" class="btn btn-1-bg btn-sm btn-brand add-btn-class  text-center add-btn-js">
                                        <i class="fas fa-angle-double-down expand-icon   exclude-icon"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center flex-column " style="gap:10px">
                                        <x-repeat-right-dot-inputs :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="__('Sales Revenues')" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                        <x-repeat-right-dot-inputs :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="__('Sales Growth %')" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>

                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="#" class="btn btn-2-bg btn-sm btn-brand btn-pill">{{ __('+') }}</a>

                                    </div>
                                </td>

                                @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
                                <td>

                                    <div class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                        <x-repeat-right-dot-inputs :formattedInputClasses="'custom-input-numeric-width'" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                        <x-repeat-right-dot-inputs :removeThreeDots="true" :is-number="true" :removeThreeDotsClass="true" :number-format-decimals="2" :currentVal="0" :classes="''" :is-percentage="true" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>

                                    </div>



                                </td>
                                @endforeach
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <x-repeat-right-dot-inputs :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                    </div>
                                </td>
                                </tr>


                                @for($k = 0 ; $k < 5 ; $k++) <tr class="hidden" data-is-sub-row data-repeat-formatting-decimals="0">
                                    <td>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center flex-column ml-5" style="gap:10px">
                                            <x-repeat-right-dot-inputs :readonly="true" :formattedInputClasses="'custom-input-string-width input-text-left '" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="__('Sub Sales Revenues')" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    <td>

                                    </td>

                                    @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
                                    <td>

                                        <div class="d-flex align-items-center justify-content-center flex-column" style="gap:10px">
                                            <x-repeat-right-dot-inputs :readonly="true" :formattedInputClasses="'custom-input-numeric-width'" :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                        </div>



                                    </td>
                                    @endforeach
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <x-repeat-right-dot-inputs :removeThreeDots="true" :removeCurrency="true" :mark="' '" :is-number="false" :removeThreeDotsClass="true" :number-format-decimals="0" :currentVal="0" :classes="''" :is-percentage="false" :name="''" :columnIndex="0"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
                                    </tr>
                                    @endfor

                                    @endfor --}}

                        </x-slot>




                    </x-tables.repeater-table>


                </div>
            </div>




            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
    </div>
</div>

@endsection
@section('js')

<script src="{{ url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"> --}}
{{-- </script> --}}
{{-- <script src="{{ url('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript">
</script>


<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'transfer_date') {
            modal.find('.data-type-span').html('[ {{ __("Transfer Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ {{ __("Contract End Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ {{ __("Balance Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ {{ __("Contract Start Date") }} ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
@endsection
@push('js')
<script src="/custom/js/non-banking-services/common.js"></script>
<script>
$(function(){
	$('[data-group-index]').trigger('change');
})
</script>
@endpush
