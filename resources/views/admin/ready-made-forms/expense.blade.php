@extends('layouts.dashboard')
@section('css')
<x-styles.commons></x-styles.commons>
@endsection
@section('sub-header')
<style>
    .icon-for-selector {
        background-color: white;
        color: #0742A8;
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: 3px;
        transition: all 0.5s;
    }

    .icon-for-selector:hover {
        transform: scale(1.2);

    }

    .filter-option {
        text-align: center !important;
    }


    td input,
    td select,
    .filter-option {
        border: 1px solid #CCE2FD !important;
        margin-left: auto;
        margin-right: auto;
        color: black;
        font-weight: 400;
    }

    th {
        border-bottom: 1px solid #CCE2FD !important;
    }

    tr:last-of-type {}

    .table tbody+tbody {
        border-top: 1px solid #CCE2FD;
    }

</style>
<x-main-form-title :id="'main-form-title'" :class="''">{{ $pageTitle  }}</x-main-form-title>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{  isset($disabled) && $disabled ? '#' : (isset($model) ? route('admin.update.financial.statement',[$company->id , $model->id]) : $storeRoute)  }}">

            @csrf
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="creator_id" value="{{ \Auth::id()  }}">
            <div class="kt-portlet">


                <div class="kt-portlet__body">


                    <div class="form-group row">
                        <div class="col-md-4 ">
                            <x-form.select :options="getTypesForValues()" :add-new="false" :label="__('Please Select Expense Type')" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="duration_type" id="{{'expense_type' }}" :selected-value="isset($model) ? $model->getDurationType() : 0"></x-form.select>
                        </div>
                        {{-- start of fixed monthly repeating amount --}}
                        <x-tables.repeater-table :parentClass="'js-toggle-visiability'" :tableName="'fixed_monthly_repeating_amount'" :repeaterId="'m_repeater_4'" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Expense <br> Category')" :helperTitle="__('If you have different expense items under the same category, please insert Category Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('Start <br> Date')" :helperTitle="__('Defualt date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('Monthly <br> Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="tds">
                                <td>
                                    <input class="form-control" @if($isRepeater) name="expense_name" @else name="expenses[0][expense_name]" @endif type="text">
                                </td>
                                <td>
									
									  <div class="d-flex align-items-center js-common-parent">
                                        <input class="form-control js-show-all-categories-popup" @if($isRepeater) name="expense_category" @else name="expenses[0][expense_category]" @endif type="text">
                                        @include('ul-to-trigger-popup')
                                    </div>
                                </td>
                                <td>
                                    <x-calendar :id="'start_date'" name="'start_date'"></x-calendar>
                                </td>
                                <td>
                                    <input @if($isRepeater) name="monthly_amount" @else name="expenses[0][monthly_amount]" @endif class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="{{ (isset($model) ? $model->get() : 0) }}" @if($isRepeater) name="monthly_amount" @else name="expenses[0][monthly_amount]" @endif>

                                </td>
                                <td>
                                    <x-form.select :selectedValue="'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="@if($isRepeater) payment_terms @else expenses[0][payment_terms] @endif" id="{{$type.'_'.'payment_terms' }}"></x-form.select>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($model) ? $model->getVatRate() : 0) }}" @if($isRepeater) name="vat_rate" @else name="expenses[0][vat_rate]" @endif>

                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($model) ? $model->getWithholdRate() : old('withhold_rate',0)) }}" @if($isRepeater) name="withhold_rate" @else name="expenses[0][withhold_rate]" @endif>

                                    </div>
                                </td>


                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($model) ? $model->getIncreaseRate() : old('increse_rate',0)) }}" @if($isRepeater) name="increase_rate" @else name="expenses[0][increase_rate]" @endif>

                                    </div>
                                </td>
                                <td>
                                    <x-form.select :selectedValue="'annually'" :options="getDurationIntervalTypesForSelect()" :add-new="false" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="@if($isRepeater) increase_interval @else expenses[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

                                </td>
                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}


                        {{-- start of Varying Amount --}}
                        <x-tables.repeater-table :parentClass="'js-toggle-visiability'" :tableName="'varying_amount'" :repeaterId="'m_repeater_5'" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Expense <br> Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Expense <br> Category')" :helperTitle="__('If you have different expense items under the same category, please insert Category Name')"></x-tables.repeater-table-th>
                                {{-- <x-tables.repeater-table-th class="col-md-1" :title="__('Start <br> Date')" :helperTitle="__('Defualt date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th> --}}
                                {{-- <x-tables.repeater-table-th class="col-md-1" :title="__('Monthly <br> Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th> --}}
                                <x-tables.repeater-table-th class="col-md-2" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                                @foreach($dates as $index => $fullDate)
                                <x-tables.repeater-table-th class="col-md-1" :title="formatDateForView($fullDate) . ' <br> ' . __('Amount')"></x-tables.repeater-table-th>
                                @endforeach
                                {{-- <x-tables.repeater-table-th class="col-md-2" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th> --}}
                            </x-slot>
                            <x-slot name="tds">
                                <td>
                                    <input class="form-control" @if($isRepeater) name="expense_name" @else name="expenses[0][expense_name]" @endif type="text">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center js-common-parent">
                                        <input class="form-control js-show-all-categories-popup" @if($isRepeater) name="expense_category" @else name="expenses[0][expense_category]" @endif type="text">
                                        @include('ul-to-trigger-popup')
                                    </div>
                                </td>
                                {{-- <td>
                                    <x-calendar :id="'start_date'" name="'start_date'"></x-calendar>
                                </td> --}}
                                {{-- <td>
                                    <input @if($isRepeater) name="monthly_amount" @else name="expenses[0][monthly_amount]" @endif class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                    <input type="hidden" value="{{ (isset($model) ? $model->getReceivableBalanceAmount() : old('receivable_balance_amount',0)) }}" @if($isRepeater) name="monthly_amount" @else name="expenses[0][monthly_amount]" @endif>

                                </td> --}}
                                <td>
                                    <x-form.select :selectedValue="'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="@if($isRepeater) payment_terms @else expenses[0][payment_terms] @endif" id="{{$type.'_'.'payment_terms' }}"></x-form.select>

                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($model) ? $model->getVatRate() : old('vat_rate',0)) }}" @if($isRepeater) name="vat_rate" @else name="expenses[0][vat_rate]" @endif>

                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <span style="margin-left:3px	">%</span>
                                        <input type="hidden" value="{{ (isset($model) ? $model->getWithholdRate() : old('withhold_rate',0)) }}" @if($isRepeater) name="withhold_rate" @else name="expenses[0][withhold_rate]" @endif>

                                    </div>
                                </td>

                                @foreach($dates as $index => $fullDate)
                                <td>

                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-center" value="0" type="text">
                                        <input type="hidden" value="{{ (isset($model) ? $model->getVaringAmountPayloadAtDate($fullDate) : old('varing_amount_payload',0)) }}" @if($isRepeater) name="varing_amount_payload" @else name="expenses[0][varing_amount_payload]" @endif>

                                    </div>
                                </td>
                                @endforeach
                                {{-- <td>
                                    <x-form.select :selectedValue="'annually'" :options="getDurationIntervalTypesForSelect()" :add-new="false" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="@if($isRepeater) increase_interval @else expenses[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

                                </td> --}}
                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of Varying Amount --}}















                    </div>




                    {{-- <div id="m_repeater_4" class="cash-and-banks-repeater">
                        <div class="form-group  m-form__group row  ">
                            <div data-repeater-list="expenses" class="col-lg-12">

                                @if(isset($model) && $model->foods->count() )
                                @foreach($model->foods as $food)
                                @include('admin.ready-made-forms.repeater-table' , [
                                'receivableexpenses'=>$food
                                ])
                                @endforeach
                                @else
                                @include('admin.ready-made-forms.repeater-table' , [
                                ])

                                @endif






                            </div>
                        </div>
                        <div class="m-form__group form-group row">

                            <div class="col-lg-6">
                                <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide {{__('right')}}" id="add-row">
                    <span>
                        <i class="fa fa-plus"> </i>
                        <span>
                            {{ __('Add') }}
                        </span>
                    </span>
                </div>
            </div>

    </div>
</div> --}}




{{-- <div class="form-group row">

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold">{{ __('Type') }} </label>
<div class="kt-input-icon">
    <div class="input-group">
        <label style="font-size:18px;margin-right:25px;" for="forecast">{{ __('Forecast & Actual') }}</label>
        <input style="width:20px;height:16px;margin-right:20px;position:initial !important" id="forecast" value="forecast" class="form-check-input financial-statement-type" type="radio" name="type" checked>

        <label style="font-size:18px;margin-right:25px;" for="actual">{{ __('Actual') }}</label>
        <input style="width:20px;height:16px;position:initial !important" id="actual" value="actual" class="form-check-input financial-statement-type" type="radio" name="type">

    </div>

</div>

</div>

<div class="col-md-3 mb-4">
    <label class="form-label font-weight-bold">{{ __('Name') }} </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input id="name" type="text" required class="form-control" name="name" value="{{ isset($model) ? $model->getName() : old('name') }}">
        </div>
    </div>
</div>


<div class="col-md-2 mb-4">
    <x-form.select :options="$durationTypes" :add-new="false" :label="__('Duration Type')" class="select2-select   " data-filter-type="{{ $type }}" :all="false" name="duration_type" id="{{$type.'_'.'duration_type' }}" :selected-value="isset($model) ? $model->getDurationType() : 0"></x-form.select>
</div>


<div class="col-md-2 mb-4">
    <label class="form-label font-weight-bold">{{ __('Duration') }} </label>
    <div class="kt-input-icon">
        <div class="input-group">
            <input title="{{ __('Allowed Duration 24') }}" id="duration" type="number" class="form-control only-greater-than-zero-allowed" name="duration" value="{{ isset($model) ? $model->getDuration() : old('duration') }}" step="1">
        </div>
        <label id="allowed-duration" class="form-label"> Allowed Duration 24 </label>
    </div>
</div>




<div class="col-md-2 mb-4">

    <x-form.label :class="'label form-label font-weight-bold'" :id="'test-id'">{{ __('Start From') }}</x-form.label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input type="text" name="start_from" class="form-control" value="{{ isset($model) ? $model->getStartFrom() : getCurrentDateForFormDate('date') }}" id="kt_datepicker_3" />
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="la la-calendar"></i>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-12 kt-align-right">
    <button type="submit" class="btn active-style save-form">{{ __('Create') }}</button>
</div>








<br>
<hr>

</div> --}}
</div>
</div>

{{-- <x-create :btn-text="__('Create')" /> --}}



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
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })

</script>
<script>
    $(function() {
        $('.only-month-year-picker').each(function(index, dateInput) {
            var currentDate = $(dateInput).val();
            var startDate = "{{ isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1 }}";
            startDate = startDate == '-1' ? '' : startDate;
            var endDate = "{{ isset($studyEndDate) && $studyEndDate? $studyEndDate : -1 }}";
            endDate = endDate == '-1' ? '' : endDate;

            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "mm/01/yyyy"
                , })
                .datepicker('setDate', new Date(currentDate))
                .datepicker('setStartDate', new Date(startDate))
                .datepicker('setEndDate', new Date(endDate))
        })


    });
    $(document).on('change', '#expense_type', function() {
        $('.js-parent-to-table').hide();
        let tableId = '.' + $(this).val();
        $(tableId).closest('.js-parent-to-table').show();

    })
    $(function() {
        $('#expense_type').trigger('change')
    })

    $(function() {
        $(document).on('click', '.js-show-all-categories-trigger', function() {
            const elementToAppendIn = $(this).parent().find('.js-append-into');
            let lis = '';
            text = '<u><a href="#" data-close-new class="text-decoration-none mb-2 d-inline-block text-nowrap ">' + 'Add New' + '</a></u>'
            lis += '<li >' + text + '</li>'

            $(this).closest('table').find('.js-show-all-categories-popup').each(function(index, element) {

                let text = $(element).val();
                if (text) {
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

</script>
@endsection
