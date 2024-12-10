@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    label {
        white-space: nowrap !important
    }

    [class*="col"] {
        margin-bottom: 1.5rem !important;
    }

    label {
        text-align: left !important;
    }

    .width-8 {
        max-width: initial !important;
        width: 8% !important;
        flex: initial !important;
    }

    .width-10 {
        max-width: initial !important;
        width: 10% !important;
        flex: initial !important;
    }

    .width-12 {
        max-width: initial !important;
        width: 13.5% !important;
        flex: initial !important;
    }

    .width-45 {
        max-width: initial !important;
        width: 45% !important;
        flex: initial !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Overdraft Against Commercial Paper Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        {{-- <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('Money Received')}}
        </h3>
    </div>
</div>
</div> --}}
<form method="post" action="{{ isset($model) ?  route('update.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'overdraftAgainstCommercialPaper'=>$model->id]) :route('store.overdraft.against.commercial.paper',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id]) }}" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
    <input id="js-money-received-id" type="hidden" name="id" value="{{ isset($model) ? $model->id : 0 }}">
    {{-- <input type="hidden" name="financial_institutions_id" value="{{ $financialInstitution->id }}"> --}}
    @csrf
    @if(isset($model))
    @method('put')
    @endif

    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{ __((isset($model) ? 'Edit' : 'Add') . ' Overdraft Against Commercial Paper')}}
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="kt-form kt-form--label-right">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{__('Contract Main Information')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">



                        <div class="form-group row">
                            <div class="col-md-4 ">
                                <label>{{__('Financial Institution Name')}} </label>
                                <div class="kt-input-icon">
                                    <input disabled value="{{ $financialInstitution->getName()  }}" type="text" class="form-control" placeholder="{{__('Financial Institution Name')}}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <x-form.date :label="__('Contract Start Date')" :required="true" :model="$model??null" :name="'contract_start_date'" :placeholder="__('Contract Start Date')"></x-form.date>
                            </div>
                            <div class="col-md-2">
                                <x-form.date :label="__('Contract End Date')" :required="true" :model="$model??null" :name="'contract_end_date'" :placeholder="__('Contract End Date')"></x-form.date>
                            </div>


                            <div class="col-md-2 ">
                                <x-form.input :model="$model??null" :label="__('Account Number')" :type="'text'" :placeholder="__('Account Number')" :name="'account_number'" :required="true"></x-form.input>
                            </div>

                            <div class="col-md-2">
                                <label>{{__('Select Currency')}} @include('star')</label>
                                <div class="input-group">
                                    <select required name="currency" class="form-control repeater-select">
                                        <option value="" selected>{{__('Select')}}</option>
                                        @foreach(getCurrencies() as $currencyName => $currencyValue )
                                        <option value="{{ $currencyName }}" @if(isset($model) && $model->getCurrency() == $currencyName ) selected @endif > {{ $currencyValue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{__('Terms & Conditions')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :label="__('Limit')" :type="'text'" :placeholder="__('Limit')" :name="'limit'" :class="'only-greater-than-zero-allowed'" :required="true"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :label="__('Outstanding Balance')" :type="'text'" :placeholder="__('Outstanding Balance')" :name="'outstanding_balance'" :class="'only-greater-than-or-equal-zero-allowed'" :required="true"></x-form.input>
                            </div>

                            <div class="col-md-4">
                                <x-form.date  :label="__('Balance Date')" :required="true" :model="$model??null" :name="'balance_date'" :placeholder="__('Select Balance Date')"></x-form.date>
                            </div>
								@if(!isset($model))
                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Borrowing Rate (%)')" :type="'text'" :placeholder="__('Borrowing Rate (%)')" :name="'borrowing_rate'" :required="true"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Bank Margin Rate (%)')" :placeholder="__('Bank Margin Rate (%)')" :name="'margin_rate'" :required="true" :type="'text'"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Interest Rate (%)')" :placeholder="__('Interest Rate (%)')" :name="'interest_rate'" :required="true" :type="'text'"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Min Intrest Rate (%)')" :placeholder="__('Min Intrest Rate (%)')" :name="'min_interest_rate'" :required="true" :type="'text'"></x-form.input>
                            </div>
							@endif
                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Highest Debt Balance Rate (%)')" :placeholder="__('Highest Debt Balance Rate (%)')" :name="'highest_debt_balance_rate'" :required="true" :type="'text'"></x-form.input>
                            </div>
                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :class="'only-percentage-allowed'" :label="__('Admin Fees Rate (%)')" :placeholder="__('Admin Fees Rate (%)')" :name="'admin_fees_rate'" :required="true" :type="'text'"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :label="__('Setteled Max Within (Days)')" :type="'text'" :placeholder="__('Setteled Max Within (Days)')" :name="'to_be_setteled_max_within_days'" :class="'only-greater-than-or-equal-zero-allowed'" :required="true"></x-form.input>
                            </div>

                            <div class="col-md-4 ">
                                <x-form.input :default-value="0" :model="$model??null" :label="__('Max Lending Limit Per Customer')" :type="'text'" :placeholder="__('Max Lending Limit Per Customer')" :name="'max_lending_limit_per_customer'" :class="'only-greater-than-or-equal-zero-allowed'" :required="true"></x-form.input>
                            </div>









                        </div>






                        <div class="form-group row" style="flex:1;">

                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        {{__('Lending Information')}}
                                    </h3>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">



                                <div class="" style="width:100%;overflow:hidden">

                                    <div id="m_repeater_0" class="cash-and-banks-repeater">
                                        <div class="form-group  m-form__group row  ">
                                            <div data-repeater-list="infos" class="col-md-12">

                                                @if(isset($model) )
                                                @foreach($model->lendingInformation as $info)
                                                @include('reports.overdraft-against-commercial-paper.repeater' , [
                                                'infos'=>$info,
                                                ])
                                                @endforeach
                                                @else
                                                @include('reports.overdraft-against-commercial-paper.repeater' , [
                                                ])
                                                @endif






                                            </div>
                                        </div>
                                        <div class="m-form__group form-group row">

                                            <div class="col-md-6">
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
                                    </div>


                                </div>



                            </div>

                        </div>





                    </div>
                </div>

                {{-- <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{__('Lending Information')}}
                </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-group row" style="flex:1;">
            <div class="col-md-12 mt-3">



                <div class="" style="width:100%;overflow:hidden">

                    <div id="m_repeater_0" class="cash-and-banks-repeater">
                        <div class="form-group  m-form__group row  ">
                            <div data-repeater-list="infos" class="col-md-12">

                                @if(isset($model) )
                                @foreach($model->lendingInformation as $info)
                                @include('reports.overdraft-against-commercial-paper.repeater' , [
                                'infos'=>$info,
                                'customers'=>$customers

                                ])
                                @endforeach
                                @else
                                @include('reports.overdraft-against-commercial-paper.repeater' , [
                                'customers'=>$customers
                                ])
                                @endif






                            </div>
                        </div>
                        <div class="m-form__group form-group row">

                            <div class="col-md-6">
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
                    </div>


                </div>



            </div>

        </div>






    </div>
    </div> --}}

    <!--end::Form-->


    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Outstanding Breakdown')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group row" style="flex:1;">
                <div class="col-md-12 mt-3">



                    <div class="" style="width:100%">

                        <div id="m_repeater_1" class="cash-and-banks-repeater">
                            <div class="form-group  m-form__group row  ">
                                <div data-repeater-list="outstanding_breakdowns" class="col-lg-12">
                                    @if(isset($model) && count($model->outstandingBreakdowns) )
                                    @foreach($model->outstandingBreakdowns as $outstandingBreakdown)
                                    @include('outstanding-breakdown.repeater' , [
                                    'outstandingBreakdown'=>$outstandingBreakdown,
                                    ])

                                    @endforeach
                                    @else
                                    @include('outstanding-breakdown.repeater' , [
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
                        </div>


                    </div>



                </div>

            </div>

        </div>
    </div>

    <!--end::Portlet-->
    </div>
    </div>

    <x-submitting-by-ajax />
</form>
@endsection
@section('js')
<!--begin::Page Scripts(used by this page) -->
<script src="{{ url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
<script>

</script>

<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })
    $('#m_repeater_0').repeater({
        initEmpty: false
        , isFirstItemUndeletable: true
        , defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
            $('input.trigger-change-repeater').trigger('change')
            $(document).find('.datepicker-input').datepicker({
                dateFormat: 'mm-dd-yy'
                , autoclose: true
            })
            $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                reinitalizeMonthYearInput(dateInput)
            });
            $('input:not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");

        },

        hide: function(deleteElement) {
            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement, function() {

                        deleteElement();
                        $('input.trigger-change-repeater').trigger('change')

                    });
                }
            }
        }
    });

</script>

<script>
    let oldValForInputNumber = 0;
    $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('focus', function() {
        oldValForInputNumber = $(this).val();
        $(this).val('')
    })
    $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('blur', function() {

        if ($(this).val() == '') {
            $(this).val(oldValForInputNumber)
        }
    })

    $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
        if (!$(this).hasClass('exclude-text')) {
            let val = $(this).val()
            val = number_unformat(val)
            $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)

        }
    })

    $('#m_repeater_1').repeater({
        initEmpty: false
        , isFirstItemUndeletable: true
        , defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
            $('input.trigger-change-repeater').trigger('change')
            $(document).find('.datepicker-input').datepicker({
                dateFormat: 'mm-dd-yy'
                , autoclose: true
            })
            $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                reinitalizeMonthYearInput(dateInput)
            });
            $('input:not([type="hidden"])').trigger('change');
            $(this).find('.dropdown-toggle').remove();
            $(this).find('select.repeater-select').selectpicker("refresh");

        },

        hide: function(deleteElement) {
            if ($('#first-loading').length) {
                $(this).slideUp(deleteElement, function() {

                    deleteElement();
                    //   $('select.main-service-item').trigger('change');
                });
            } else {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement, function() {

                        deleteElement();
                        $('input.trigger-change-repeater').trigger('change')

                    });
                }
            }
        }
    });

</script>

<script>
    $('input[name="borrowing_rate"],input[name="margin_rate"]').on('change', function() {
        let borrowingRate = $('input[name="borrowing_rate"]').val();
        borrowingRate = borrowingRate ? parseFloat(borrowingRate) : 0;
        let bankMaringRate = $('input[name="margin_rate"]').val();
        bankMaringRate = bankMaringRate ? parseFloat(bankMaringRate) : 0;
        const interestRate = borrowingRate + bankMaringRate;
        $('input[name="interest_rate"]').attr('readonly', true).val(interestRate);
    })
    $('input[name="borrowing_rate"]').trigger('change');
</script>


@endsection
