@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    hr {}

    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
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

    .kt-portlet {}

    input.form-control[disabled],
    input.form-control:not(.is-date-css)[readonly]:not(#kt_datepicker_2) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Financial Institution Account Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="{{ route('update.financial.institutions.account',['company'=>$company->id , 'financialInstitutionAccount'=>$model->id]) }}" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
            <input id="js-money-received-id" type="hidden" name="id" value="{{ isset($model) ? $model->id : 0 }}">
            {{-- <input type="hidden" id="ajax-invoice-item" data-single-model="{{ $singleModel ? 1 : 0 }}" value="{{ $singleModel ? $invoiceNumber : 0 }}"> --}}
            @csrf
            @if(isset($model))
            @method('put')
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <x-sectionTitle :title="__((isset($model) ? 'Edit' : 'Add') . ' Financial Institution Account')"></x-sectionTitle>
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
                                        <x-sectionTitle :title="__('Company Account Information')"></x-sectionTitle>
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <label>{{__('Account Number')}} @include('star')</label>
                                        <div class="kt-input-icon">
                                            <input type="text" value="{{ isset($model) ? $model->getAccountNumber() : old('account_number') }}" name="account_number" class="form-control" placeholder="{{__('Account Number')}}">
                                        </div>
                                    </div>


                                    <div class="col-2">
                                        <label class="form-label font-weight-bold">{{ __('Balance Amount') }}
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group">
                                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="{{ number_format(isset($model) ? $model->getBalanceAmount() : old('balance_amount',0)) }}">
                                                <input type="hidden" value="{{ (isset($model) ? $model->getBalanceAmount() : old('balance_amount',0)) }}" name="balance_amount">
                                            </div>
                                        </div>
                                    </div>





                                    @if(!$model->isMainAccount())
                                    <div class="col-md-3">
                                        <label>{{__('Select Currency')}} </label>
                                        <div class="input-group">
                                            <select name="currency" class="form-control repeater-select">
                                                <option selected>{{__('Select')}}</option>
                                                @foreach(getCurrencies() as $currencyName => $currencyValue )
                                                <option value="{{ $currencyName }}" @if(isset($model) && $model->getCurrency() == $currencyName ) selected @endif > {{ $currencyValue }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif


                                    <div class="col-2">
                                        <label class="form-label font-weight-bold">{{ __('IBAN') }}
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group">
                                                <input name="iban" type="text" class="form-control " value="{{ isset($model) ? $model->getIban() : old('iban',0) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <label class="form-label font-weight-bold">{{ __('Exhange Rate') }}
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group">
                                                <input type="text" class="form-control only-greater-than-or-equal-zero-allowed trigger-change-repeater" value="{{ number_format(isset($model) ? $model->getExchangeRate() : old('exchange_rate',0)) }}">
                                                <input type="hidden" value="{{ (isset($model) ? $model->getExchangeRate() : old('exchange_rate',0)) }}" name="exchange_rate">
                                            </div>
                                        </div>
                                    </div>



                        


                            </div>

                    
                            <div class="form-group row" style="flex:1;">
                                <div class="col-md-12 mt-3">



                                    <div class="" style="width:100%">

                                        <div id="m_repeater_0" class="cash-and-banks-repeater">
                                            <div class="form-group  m-form__group row  ">
                                                <div data-repeater-list="account_interests" class="col-lg-12">
                                                    @if(isset($model) )
                                                    @foreach($model->accountInterests as $accountInterest)
                                                    @include('reports.financial-institution-account.repeater' , [
                                                    'accountInterest'=>$accountInterest,

                                                    ])

                                                    @endforeach
                                                    @else
                                                    @include('reports.financial-institution-account.repeater' , [
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



                <x-submitting />
        </form>

        <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>

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
    $(document).on('change', '#type', function() {
        if ($(this).val() == 'bank') {
            $('.banks_view').removeClass('hidden');
            $('.bank_class').removeClass('hidden')
            $('.financial-institution-name').addClass('hidden')
        } else {
            $('.banks_view').addClass('hidden');
            $('.bank_class').addClass('hidden');
            $('.financial-institution-name').removeClass('hidden')


        }
    });
    $('#type').trigger('change')

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
            $(this).parent().find('input[type="hidden"]').val(val)

        }
    })

</script>
@endsection
