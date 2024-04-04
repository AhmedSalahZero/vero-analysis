@extends('layouts.dashboard')
@section('css')
@php
use App\Models\MoneyReceived ;
@endphp
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
{{-- {{ dd($company->getMainFunctionalCurrency()) }} --}}
<style>
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
{{ __('Settlement Using Unapplied Amount Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">

        <form method="post" action="{{ isset($model) ?  route('update.money.receive',['company'=>$company->id,'moneyReceived'=>$model->id]) :route('store.settlement.by.unapplied.amounts',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
            <input id="js-money-received-id" type="hidden" name="money_received_id" value="{{ isset($model) ? $model->id : 0 }}">
            <input type="hidden" id="ajax-invoice-item" data-single-model="{{ 1 }}" value="{{ $invoiceNumber }}">
            @csrf
            @if(isset($model))
            @method('put')
            @endif
            {{-- Money Received --}}
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Settlement Using Unapplied Amount')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">


                        <div class="col-md-5">

                            <label>{{__('Customer Name')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select id="customer_name" name="customer_id" class="form-control ajax-get-invoice-numbers">
                                            @foreach($customerInvoices as $customerInvoiceId => $customerName)
                                            <option selected value="{{ $customerInvoiceId }}">{{$customerName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <label>{{__('Select Currency')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select readonly name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                                        <option value="" selected>{{__('Select')}}</option>
                                        @foreach(isset($currencies) ? $currencies : getBanksCurrencies () as $currencyId=>$currentName)
                                <option {{ isset($model) && $model->getCurrency()  == $currencyId ? 'selected': (strtolower($currentName) == strtolower($company->getMainFunctionalCurrency()) ? 'selected':'' ) }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>{{__('Settlement Date')}}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input disabled type="text" name="settlement_date" value="{{ formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Settlement Information "Commen Card" --}}
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Settlement Information')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <div class="js-append-to">
                        <div class="col-md-12 js-duplicate-node">
                          
                        </div>
                    </div>


                    <div class="js-template hidden">
                        <div class="col-md-12 js-duplicate-node">
                            <div class=" kt-margin-b-10 border-class">
                                <div class="form-group row align-items-end">

                                    <div class="col-md-1 width-10">
                                        <label>{{__('Invoice Number')}} </label>
                                        <div class="kt-input-icon">
                                            <div class="kt-input-icon">
                                                <div class="input-group date">
                                                    <input readonly class="form-control js-invoice-number" name="settlements[][invoice_number]" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-1 width-12">
                                        <label>{{__('Invoice Date')}}</label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 width-8">
                                        <label>{{__('Currency')}} </label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][currency]" type="text" disabled class="form-control js-currency">
                                        </div>
                                    </div>

                                    <div class="col-md-1 width-12">
                                        <label>{{__('Net Invoice Amount')}} </label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][net_invoice_amount]" type="text" disabled class="form-control js-net-invoice-amount">
                                        </div>
                                    </div>


                                    <div class="col-md-2 width-12">
                                        <label>{{__('Collected Amount')}} </label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][collected_amount]" type="text" disabled class="form-control js-collected-amount">
                                        </div>
                                    </div>

                                    <div class="col-md-2 width-12">
                                        <label>{{__('Net Balance')}} </label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][net_balance]" type="text" disabled class="form-control js-net-balance">
                                        </div>
                                    </div>



                                    <div class="col-md-2 width-12">
                                        <label>{{__('Settlement Amount')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][settlement_amount]" placeholder="{{ __('Settlement Amount') }}" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
                                        </div>
                                    </div>
                                    <div class="col-md-2 width-12">
                                        <label>{{__('Withhold Amount')}} <span class="required">*</span></label>
                                        <div class="kt-input-icon">
                                            <input name="settlements[][withhold_amount]" placeholder="{{ __('Withhold Amount') }}" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
                                        </div>
                                    </div>

                                </div>

                            </div> 
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        {{-- <div class="col-md-2 width-12 ml-auto mr-4">
                            <label class="label">{{ __('Unapplied Amount') }}</label>
                        <input id="remaining-settlement-js" class="form-control" placeholder="{{ __('Unapplied Amount') }}" type="text" name="unapplied_amount" value="0">
                    </div> --}}
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
    $('#type').change(function() {
        selected = $(this).val();
        $('.js-section-parent').addClass('hidden');
        if (selected) {
            $('#' + selected).removeClass('hidden');

        }


    });
    $('#type').trigger('change')

</script>
<script src="/custom/money-receive.js">

</script>

<script>
    $(document).on('change', '.settlement-amount-class', function() {

    })
    $(function() {
        $('#type').trigger('change');
    })

</script>
{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}
@endsection
