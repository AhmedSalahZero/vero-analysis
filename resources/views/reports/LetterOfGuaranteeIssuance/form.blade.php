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

    input.form-control[disabled],
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Letter Of Gurantee Issuance Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">

        <form method="post" action="{{ isset($model) ?  route('update.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id]) :route('store.letter.of.guarantee.issuance',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
            <input type="hidden" name="id" value="{{ isset($model) ? $model->id : 0 }}">
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
            <input type="hidden" name="company_id" value="{{ $company->id }}">
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
                                    {{ __((isset($model) ? 'Edit' : 'Add') . ' Letter Of Guarantee Issuance')}}
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
                                        {{__('Letter Of Guarntee Type')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <x-form.input :model="$model??null" :label="__('Transaction Name')" :type="'text'" :placeholder="__('Transaction Name')" :name="'transaction_name'" :class="''" :required="true"></x-form.input>
                                    </div>
                                    <div class="col-md-4">
                                        <label> {{ __('Financial Bank') }}
                                            @include('star')
                                        </label>
                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control">
                                            @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                            <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getFinancialInstitutionBankId() == $financialInstitutionBank->id ? 'selected':'' }}>{{ $financialInstitutionBank->getName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 ">
                                        <x-form.input :model="$model??null" :label="__('Total LGs Outstanding Balance')" :type="'text'" :placeholder="__('Total LGs Outstanding Balance')" :name="'total_lg_outstanding_balance'" :class="'only-greater-than-zero-allowed'" :required="true"></x-form.input>
                                    </div>

                                    <div class="col-md-4">
                                        <label> {{ __('LG Type') }}
                                            @include('star')
                                        </label>

                                        <select name="lg_type" class="form-control">
                                            <option selected>{{__('Select')}}</option>
                                            @foreach(getLgTypes() as $name => $nameFormatted )
                                            <option value="{{ $name  }}" @if(isset($model) && $model->getLgType() == $name ) selected @endif > {{ $nameFormatted }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 ">
                                        <x-form.input :model="$model??null" :label="__('LG Type Outstanding Balance')" :type="'text'" :placeholder="__('LG Type Outstanding Balance')" :name="'lg_type_outstanding_balance'" :class="'only-greater-than-zero-allowed'" :required="true"></x-form.input>
                                    </div>
                                    <div class="col-md-4">
                                        <x-form.input :model="$model??null" :label="__('LG Code')" :type="'text'" :placeholder="__('LG Code')" :name="'lg_code'" :class="''" :required="true"></x-form.input>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        {{__('Beneficiary Information')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">

                                    <div class="col-md-3">

                                        <label> {{ __('Beneficiary Name') }}
                                            @include('star')
                                        </label>

                                        <select name="partner_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                            @foreach($beneficiaries as $customer)
                                            <option @if(isset($model) && $model->getBeneficiaryId() == $customer->getId() ) selected @endif value="{{ $customer->getId() }}">{{ $customer->getName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">

                                        <label> {{ __('Contract Reference') }}
                                            @include('star')
                                        </label>
                                        <select name="contract_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                            @foreach($contracts as $contract)
                                            <option @if(isset($model) && $model->getContractId() == $contract->id ) selected @endif value="{{ $contract->getId() }}">{{ $contract->getName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">

                                        <label> {{ __('Purchase Order') }}
                                            @include('star')
                                        </label>

                                        <select name="purchase_order_id" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                            @foreach($purchaseOrders as $purchaseOrder)
                                            <option @if(isset($model) && $model->getPurchaseOrderId() == $purchaseOrder->getId() ) selected @endif value="{{ $purchaseOrder->getId() }}">{{ $purchaseOrder->getName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">

                                        <x-form.date :label="__('Purchase Order Date')" :required="true" :model="$model??null" :name="'purchase_order_date'" :placeholder="__('Select Purchase Order Date')"></x-form.date>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title head-title text-primary">
                                        {{__('Letter Of Guarntee Information')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">


                                <div class="form-group row">

                                    <div class="col-md-3">

                                        <x-form.date :classes="'recalc-renewal-date issuance-date-js'" :label="__('Issuance Date')" :required="true" :model="$model??null" :name="'issuance_date'" :placeholder="__('Select Purchase Order Date')"></x-form.date>
                                    </div>

                                    <div class="col-md-3">
                                        <x-form.input :default-value="1" :model="$model??null" :label="__('LG Duration Months')" :type="'numeric'" :placeholder="__('LG Duration Months')" :name="'lg_duration_months'" :class="'recalc-renewal-date lg-duration-months-js'" :required="true"></x-form.input>
                                    </div>


                                    <div class="col-md-3">

                                        <x-form.date :classes="'renewal-date-js'" :readonly="true" :label="__('Renewal Date')" :required="true" :model="$model??null" :name="'renewal_date'" :placeholder="__('Select Renewal Date')"></x-form.date>
                                    </div>

                                    <div class="col-md-3">
                                        <x-form.input :model="$model??null" :label="__('LG Amount')" :type="'text'" :placeholder="__('LG Amount')" :name="'lg_amount'" :class="'only-greater-than-zero-allowed recalculate-cash-cover-amount-js recalculate-lg-commission-amount-js lg-amount-js'" :required="true"></x-form.input>
                                    </div>

                                    <div class="col-md-3">
                                        <label>{{__('LG Currency')}}
                                            @include('star')
                                        </label>
                                        <div class="input-group">
                                            <select name="lg_currency" class="form-control current-currency" js-when-change-trigger-change-account-type>
                                                <option selected>{{__('Select')}}</option>
                                                @foreach(getCurrencies() as $currencyName => $currencyValue )
                                                <option value="{{ $currencyName }}" @if(isset($model) && $model->getLgCurrency() == $currencyName ) selected @elseif(strtolower($currencyName) == 'egp' ) selected @endif > {{ $currencyValue }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <x-form.input :model="$model??null" :label="__('Cash Cover Rate %')" :type="'text'" :placeholder="__('Cash Cover Rate %')" :name="'cash_cover_rate'" :class="'only-greater-than-or-equal-zero-allowed recalculate-cash-cover-amount-js cash-cover-rate-js'" :required="true"></x-form.input>
                                    </div>


                                    <div class="col-md-3">
                                        <x-form.input :readonly="true" :model="$model??null" :label="__('Cash Cover Amount')" :type="'text'" :placeholder="__('Cash Cover Amount')" :name="'cash_cover_amount'" :class="'only-greater-than-or-equal-zero-allowed cash-cover-amount-js' " :required="true"></x-form.input>
                                    </div>




                                    <div class="col-md-3">
                                        <x-form.input :model="$model??null" :label="__('LG Commission Rate %')" :type="'text'" :placeholder="__('LG Commission Rate %')" :name="'lg_commission_rate'" :class="'only-greater-than-or-equal-zero-allowed recalculate-lg-commission-amount-js lg-commission-rate-js'" :required="true"></x-form.input>
                                    </div>


                                    <div class="col-md-3">
                                        <x-form.input :readonly="true" :model="$model??null" :label="__('LG Commission Amount')" :type="'text'" :placeholder="__('LG Commission Amount')" :name="'lg_commission_amount'" :class="'only-greater-than-or-equal-zero-allowed lg-commission-amount-js'" :required="true"></x-form.input>
                                    </div>


                                    <div class="col-md-3">
                                        <label>{{__('LG Commission Interval')}}
                                            @include('star')
                                        </label>
                                        <div class="input-group">
                                            <select name="lg_commission_interval" class="form-control repeater-select">
                                                <option selected>{{__('Select')}}</option>
                                                @foreach(MonthAndQuarterlyIntervals() as $intervalArr )
                                                <option value="{{ $intervalArr['value'] }}" @if(isset($model) && $model->getLgCommissionInterval() == $intervalArr['value'] ) selected @endif > {{ $intervalArr['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>



                                    <div class="col-md-3">
                                        <label>{{__('Account Type')}}
                                            @include('star')
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select name="cash_cover_deducted_from_account_type" class="form-control js-update-account-number-based-on-account-type">
                                                    <option value="" selected>{{__('Select')}}</option>
                                                    @foreach($accountTypes as $index => $accountType)
                                                    <option value="{{ $accountType->id }}" @if(isset($model) && $model->getCashCoverDeductedFromAccountTypeId() == $accountType->id) selected @endif>{{ $accountType->getName() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>{{__('Deducted From Account # (Cover & Commission)')}}
                                            @include('star')
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select data-current-selected="{{ isset($model) ? $model->getCashCoverDeductedFromAccountNumber(): 0 }}" name="cash_cover_deducted_from_account_number" class="form-control js-account-number">
                                                    <option value="" selected>{{__('Select')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <x-form.input :default-value="1" :model="$model??null" :label="__('Cash Cover Account Naumber')" :type="'numeric'" :placeholder="__('Cash Cover Account Naumber')" :name="'cash_cover_account_number'" :class="''" :required="true"></x-form.input>
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

            <script src="/custom/money-receive.js">

            </script>

            <script>
                $(document).on('change', '.recalc-renewal-date', function(e) {
                    e.preventDefault()
                    let date = $('.issuance-date-js').val();
                    date = date.replaceAll('-', '/')

                    const issuanceDate = new Date(date);
                    const duration = $('.lg-duration-months-js').val();
                    if (issuanceDate || duration == '0') {
                        const numberOfMonths = duration
                        let renewalDate = issuanceDate.addMonths(numberOfMonths)
                        renewalDate = formatDateForSelect2(renewalDate)
                        $('.renewal-date-js').val(renewalDate).trigger('change')
                    }

                })
                $(document).on('change', '.recalculate-cash-cover-amount-js', function() {
                    const lgAmount = number_unformat($('.lg-amount-js').val())
                    const cashCoverRateJs = number_unformat($('.cash-cover-rate-js').val()) / 100
                    const cashCoverAmount = lgAmount * cashCoverRateJs
                    $('.cash-cover-amount-js').val(cashCoverAmount)
                })

                $(document).on('change', '.recalculate-lg-commission-amount-js', function() {
                    const lgAmount = number_unformat($('.lg-amount-js').val())
                    const rate = number_unformat($('.lg-commission-rate-js').val()) / 100
                    const lgCommissionAmount = lgAmount * rate
                    $('.lg-commission-amount-js').val(lgCommissionAmount)
                })

                $('.recalc-renewal-date').trigger('change')
                $('.recalculate-cash-cover-amount-js').trigger('change')
                $('.recalculate-lg-commission-amount-js').trigger('change')

            </script>
            @endsection
