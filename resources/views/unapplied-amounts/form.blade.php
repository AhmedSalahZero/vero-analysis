@extends('layouts.dashboard')
@section('css')
@php
use App\Models\CustomerInvoice;
use App\Models\MoneyReceived ;
use App\Models\SupplierInvoice;
$fullClassName = '\App\Models\\'.$modelType ;
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
        width: 12.5% !important;
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
{{ __('Settlement Using Unapplied Amount Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">

        <form method="post" action="{{ isset($model) ?  route('update.settlement.by.unapplied.amounts',['company'=>$company->id,'modelType'=>$modelType,'unappliedAmountId'=>$model->id,'settlementId'=>$settlement->id]) :route('store.settlement.by.unapplied.amounts',['company'=>$company->id,'modelType'=>$modelType]) }}" class="kt-form kt-form--label-right">
	
            <input type="hidden" name="invoiceId" value="{{ $invoiceId }}">
            <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
            {{-- <input id="js-money-received-id" type="hidden" name="money_received_id" value="{{ isset($model) ? $model->id : 0 }}"> --}}
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
                            <label>{{$customerNameText}} @include('star')</label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select id="{{ $customerNameColumnName }}" name="{{ $customerIdColumnName }}" class="form-control ajax-get-invoice-numbers">
                                            @foreach($customerInvoices as $partnerId => $customerName)
                                            <option selected value="{{ $partnerId }}">{{$customerName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-2">
                            <label>{{__('Select Currency')}} @include('star')</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select readonly name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                                        <option value="" selected>{{__('Select')}}</option>
                                        @foreach(isset($currencies) ? $currencies : getBanksCurrencies () as $currencyId=>$currentName)

                                        @php
                                        $selected = isset($model) ? $model->getCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                        $selected = $selected ? 'selected':'';
                                        @endphp

                                        <option {{ $selected }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>{{__('Settlement Date')}}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input  type="text" name="settlement_date" value="{{ $settlementDate }}" class="form-control is-date-css"  placeholder="Select date" id="kt_datepicker_2" />
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
                    <div class="js-template 
					
					{{-- @if(isset($model)) hidden @endif --}}
					
					 ">
                        <div class="col-md-12 js-duplicate-node">
							{!! $fullClassName::getSettlementsTemplate($invoiceNumber , $dueDateFormatted  , $invoiceDueDateFormatted,$invoiceCurrency,$netInvoiceAmountFormatted,$collectedAmountFormatted,$netBalanceFormatted,$settlementAmount,$withholdAmount) !!}
							
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>

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
    $('#type').change(function() {
        selected = $(this).val();
        $('.js-section-parent').addClass('hidden');
        if (selected) {
            $('#' + selected).removeClass('hidden');
        }
    });
    $('#type').trigger('change')

</script>
{{-- @if(!isset($model))
<script src="/custom/{{ $jsFile }}">
</script>
@endif  --}}

<script>
    
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
<script>
    $(function() {

        $('select.ajax-get-invoice-numbers').trigger('change')
    })

</script>
@endsection
