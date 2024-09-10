@extends('layouts.dashboard')
@section('css')
@php
use App\Models\MoneyPayment ;
use App\Models\SupplierInvoice;
$banks =[];
$selectedBanks = [];
@endphp
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    input,
    select,
    .dropdown-toggle.bs-placeholder {
        border: 1px solid #CCE2FD !important
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #f7f8fa;
        opacity: 1;
    }

    .action-class {
        color: white !important;
        background-color: #0742A6 !important;
    }

    label {
        text-align: left !important;
    }

    .max-w-6 {
        max-width: initial !important;
        width: 6% !important;
        flex: initial !important;
    }

    .max-w-11 {
        max-width: initial !important;
        width: 11% !important;
        flex: initial !important;
    }

    .width-8 {
        max-width: initial !important;
        width: 8% !important;
        flex: initial !important;
    }
.width-9-5 {
        max-width: initial !important;
        width: 9% !important;
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
{{ __('Supplier Payment Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        {{-- <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('Supplier Payment')}}
        </h3>
    </div>
</div>
</div> --}}
<form method="post" action="{{ isset($model) ?  route('update.money.payment',['company'=>$company->id,'moneyPayment'=>$model->id]) :route('store.money.payment',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
    <input id="js-money-payment-id" type="hidden" name="money_payment_id" value="{{ isset($model) ? $model->id : 0 }}">
    <input type="hidden" id="ajax-invoice-item" data-single-model="{{ $singleModel ? 1 : 0 }}" value="{{ $singleModel ? $invoiceNumber : 0 }}">
    @csrf
    @if(isset($model))
    @method('put')
    @endif
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Supplier Payment')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-md-3">
                    <label>{{__('Payment Date')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="delivery_date" value="{{ isset($model) ? formatDateForDatePicker($model->getDeliveryDate()) : formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control exchange-rate-date update-exchange-rate is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $currentPaymentCurrency = null ;
                @endphp

                <div class="col-md-2">
                    <label>{{__('Select Invoice Currency')}} @include('star')</label>

                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="currency" class="form-control
							
							invoice-currency-class
							currency-class update-exchange-rate 
							 current-invoice-currency  ajax-get-invoice-numbers">
                                {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                @foreach(isset($currencies) ? $currencies : getBanksCurrencies () as $currencyId=>$currentName)
                                @php
                                $selected = isset($model) ? $model->getCurrency() == $currencyId : $currentName == $company->getMainFunctionalCurrency() ;
                                $selected = $selected ? 'selected':'';
                                if($selected || (isset($singleModel) && $singleModel) ){
                                $currentPaymentCurrency = $currencyId ;
                                }
                                @endphp
                                <option {{ $selected }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">

                    <label>{{__('Supplier Name')}} @include('star')</label>
                    <div class="kt-input-icon">
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-live-search="true" data-actions-box="true" id="supplier_name" name="supplier_id" class="form-control select2-select ajax-get-invoice-numbers">
                                    {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                    {{-- {{  }} --}}
                                    @foreach($suppliers as $supplierId => $supplierName)
                                    <option @if($singleModel) selected @endif @if(isset($model) && $model->getSupplierName() == $supplierName ) selected @endif value="{{ $supplierId }}">{{$supplierName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- {{ dd($currentPaymentCurrency) }} --}}
                <div class="col-md-2">
                    <label>{{__('Select Payment Currency')}} @include('star')</label>

                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select when-change-trigger-account-type-change name="payment_currency" class="form-control
							
							currency-class
							receiving-currency-class
							update-exchange-rate
							 current-currency">
                                {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                @foreach(getCurrencies() as $currencyId=>$currentName)
                                @php
                                $selected = isset($model) ? $model->getPaymentCurrency() == $currencyId : false;
                                $selected = $selected ? 'selected':'';
                                if(!$selected && $currentPaymentCurrency == $currencyId){
                                $selected = 'selected';
                                }
                                @endphp
                                <option {{ $selected }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-2">
                    <label>{{__('Select Money Type')}} @include('star')</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select required name="type" id="type" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>
                                <option @if(isset($model) && $model->isCashPayment() ) selected @endif value="{{ MoneyPayment::CASH_PAYMENT }}">{{__('Cash Payment')}}</option>
                                <option @if(isset($model) && $model->isPayableCheque() ) selected @endif value="{{ MoneyPayment::PAYABLE_CHEQUE }}">{{__('Payable Cheques')}}</option>
                                <option @if(isset($model) && $model->isOutgoingTransfer()) selected @endif value="{{ MoneyPayment::OUTGOING_TRANSFER }}">{{__('Outgoing Transfer')}}</option>
                            </select>
                        </div>
                    </div>



                    <div class="modal fade" id="js-choose-delivery-branch-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Branch') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="js-delivery-branch-names" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button id="js-append-delivery-branch-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>




            </div>
        </div>
    </div>

    {{-- Cash In Safe Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyPayment::CASH_PAYMENT}}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Cash Payment Information')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45 ">
                        <label>{{__('Paying Branch')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="delivery_branch_id" class="form-control">
                                    <option value="-1">{{__('New Branch')}}</option>
                                    @foreach($selectedBranches as $branchId=>$branchName)
                                    <option value="{{ $branchId }}" {{ isset($model) && $model->getCashPaymentBranchId() == $branchId ? 'selected' : '' }}>{{ $branchName }}</option>
                                    @endforeach
                                </select>
                                <button id="js-delivery-branch" class="btn btn-sm btn-primary">{{ __('Add New Branch') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>{{__('Paid Amount')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getPaidAmount() :0 }}" name="paid_amount[{{ MoneyPayment::CASH_PAYMENT}}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::CASH_PAYMENT.'-paid-amount' }}  main-amount-class recalculate-amount-class" data-type="{{ MoneyPayment::CASH_PAYMENT }}" placeholder="{{__('Paid Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Receipt Number')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number" value="{{ isset($model) ?  $model->getCashPaymentReceiptNumber()  : '' }}" class="form-control" placeholder="{{__('Receipt Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Exchange Rate')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::CASH_PAYMENT }}]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="{{ MoneyPayment::CASH_PAYMENT }}">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label>{{__('Amount')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input readonly value="{{ 0 }}" type="text" name="amount_in_paying_currency[{{ MoneyPayment::CASH_PAYMENT }}]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="{{ MoneyPayment::CASH_PAYMENT }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





















    {{-- Cheques Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyPayment::PAYABLE_CHEQUE }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label flex-1">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Payable Cheque Information')}}
                </h3>
                <div class=" flex-1 d-flex justify-content-end pt-3">
                    <div class="col-md-3 mb-3">
                        <label>{{__('Balance')}} <span class="balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control balance-js" placeholder="{{__('Account Balance')}}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>{{__('Net Balance')}} <span class="net-balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control net-balance-js" placeholder="{{__('Net Balance')}}">
                            {{-- <x-tool-tip title="{{__('Kash Vero')}}" /> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6  mb-3">
                        <label> {!! __('Payment Bank') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[{{ MoneyPayment::PAYABLE_CHEQUE  }}]" class="form-control financial-institution-id">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getPayableChequePaymentBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>
                                {{-- <button id="js-delivery-bank" class="btn btn-sm btn-primary">{{ __('Add New Bank') }}</button> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label> {!! __('Account Type') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected>{{__('Select')}}</option>
                                    @foreach($accountTypes as $index => $accountType)
                                    <option value="{{ $accountType->id }}" @if(isset($model) && $model->getPayableChequeAccountTypeId() == $accountType->id) selected @endif>{{ $accountType->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2 width-12">
                        <label> {!! __('Account Number') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getPayableChequeAccountNumber() : 0 }}" name="account_number[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>{{__('Cheque Amount')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="{{ isset($model) ? $model->getPaidAmount() : 0 }}" placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="paid_amount[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::PAYABLE_CHEQUE .'-paid-amount' }}  main-amount-class recalculate-amount-class" data-type="{{ MoneyPayment::PAYABLE_CHEQUE }}">
                        </div>
                    </div>



                    <div class="col-md-3">
                        <label>{{__('Due Date')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" value="{{ isset($model) && $model->payableCheque ? formatDateForDatePicker($model->payableCheque->getDueDate()):formatDateForDatePicker(now()->format('Y-m-d')) }}" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <label>{{__('Cheque Number')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" value="{{ isset($model) && $model->payableCheque ? $model->payableCheque->getChequeNumber() : 0 }}" class="form-control" placeholder="{{__('Cheque Number')}}">
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label>{{__('Exchange Rate')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="{{ MoneyPayment::PAYABLE_CHEQUE }}">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label>{{__('Amount')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input readonly value="{{ 0 }}" type="text" name="amount_in_paying_currency[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="{{ MoneyPayment::PAYABLE_CHEQUE }}">
                        </div>
                    </div>



                    {{-- <div class="col-md-4">
                        <label>{{__('Select Currency')}} @include('star')</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="currency" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>
                                <option>EGP</option>
                                <option>USD</option>
                                <option>EURO</option>
                                <option>GBP</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </div>
    </div>

    {{-- Outgoing Transfer Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyPayment::OUTGOING_TRANSFER }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label flex-1">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Outgoing Transfer Information')}}
                </h3>

                <div class=" flex-1 d-flex justify-content-end pt-3">
                    <div class="col-md-3 mb-3">
                        <label>{{__('Balance')}} <span class="balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control balance-js" placeholder="{{__('Account Balance')}}">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>{{__('Net Balance')}} <span class="net-balance-date-js"></span> </label>
                        <div class="kt-input-icon">
                            <input value="0" type="text" disabled class="form-control net-balance-js" placeholder="{{__('Net Balance')}}">
                            {{-- <x-tool-tip title="{{__('Kash Vero')}}" /> --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label> {!! __('Payment <br> Bank') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control financial-institution-id">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getOutgoingTransferDeliveryBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 max-w-11">
                        <label> {!! __('Outgoing <br> Transfer Amount') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getPaidAmount():0 }}" name="paid_amount[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::OUTGOING_TRANSFER .'-paid-amount' }}  main-amount-class recalculate-amount-class" data-type="{{ MoneyPayment::OUTGOING_TRANSFER }}" placeholder="{{__('Insert Amount')}}">
                        </div>
                    </div>



                    <div class="col-md-3">
                        <label> {!! __('Account <br> Type') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected>{{__('Select')}}</option>
                                    @foreach($accountTypes as $index => $accountType)
                                    <option value="{{ $accountType->id }}" @if(isset($model) && $model->getOutgoingTransferAccountTypeId() == $accountType->id) selected @endif>{{ $accountType->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label> {!! __('Account <br> Number') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getOutgoingTransferAccountNumber() : 0 }}" name="account_number[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1 max-w-6">
                        <label>{!! __('Exchange <br> Rate') !!} @include('star')</label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control only-greater-than-or-equal-zero-allowed exchange-rate-class recalculate-amount-class" data-type="{{ MoneyPayment::OUTGOING_TRANSFER }}">
                        </div>
                    </div>

                    <div class="col-md-1 mt-4 show-only-when-invoice-currency-not-equal-receiving-currency hidden">
                        <label>{{__('Amount')}} @include('star')</label>
                        <div class="kt-input-icon">
                            <input readonly value="{{ 0 }}" type="text" name="amount_in_paying_currency[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control only-greater-than-or-equal-zero-allowed amount-after-exchange-rate-class" data-type="{{ MoneyPayment::OUTGOING_TRANSFER }}">
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
                        <div class="form-group row align-items-end settlement-row-parent">

                            <div class="col-md-1 width-10">
                                <label> {{ __('Invoice Number') }} </label>
                                <div class="kt-input-icon">
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
                                            <input readonly class="form-control js-invoice-number" name="settlements[][invoice_number]" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 width-9">
                                <label> {{ __('Invoice Date') }} </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input name="settlements[][invoice_date]" type="text" class="form-control js-invoice-date" disabled />

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 width-9">
                                <label> {{ __('Due Date') }} </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input name="settlements[][invoice_due_date]" type="text" class="form-control js-invoice-due-date" disabled />

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-1 width-8">
                                <label> {{ __('Currency') }} </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][currency]" type="text" disabled class="form-control js-currency">
                                </div>
                            </div>

                            <div class="col-md-1 width-12">
                                <label> {{ __('Net Invoice Amount') }} </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][net_invoice_amount]" type="text" disabled class="form-control js-net-invoice-amount">
                                </div>
                            </div>


                            <div class="col-md-2 width-12">
                                <label> {{ __('Paid Amount') }} </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][paid_amount]" type="text" disabled class="form-control js-paid-amount">
                                </div>
                            </div>

                            <div class="col-md-2 width-12">
                                <label> {{ __('Net Balance') }} </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][net_balance]" type="text" readonly class="form-control js-net-balance">
                                </div>
                            </div>



                            <div class="col-md-1 width-9-5">
                                <label> {{ __('Settlement Amount') }} <span class="text-danger ">*</span></label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][settlement_amount]" placeholder="" type="text" class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
                                </div>
                            </div>
                            <div class="col-md-1 width-9-5">
                                <label> {{ __('Withhold Amount') }} <span class="text-danger ">*</span> </label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][withhold_amount]" placeholder="" type="text" class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="add-new btn btn-primary d-block" data-toggle="modal" data-target="#add-new-customer-modal--0">
                                    {{ __('Allocate') }}
                                </button>

                                <div class="modal fade modal-class-js" id="add-new-customer-modal--0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Allocate') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group row justify-content-center">
                                                    @php
                                                    $index = 0 ;
                                                    @endphp

                                                    {{-- start of fixed monthly repeating amount --}}
                                                    @php
                                                    $tableId = 'allocations';

                                                    $repeaterId = 'm_repeater--0';

                                                    @endphp
                                                    {{-- <input type="hidden" name="tableIds[]" value="{{ $tableId }}"> --}}
                                                    <x-tables.repeater-table :initialJs="false" :repeater-with-select2="true" :parentClass="'show-class-js'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=true">
                                                        <x-slot name="ths">
                                                            @foreach([
                                                            __('Customer')=>'th-main-color',
                                                            __('Contract Name')=>'th-main-color',
                                                            __('Contract Code')=>'th-main-color',
                                                            __('Contract Amount')=>'th-main-color',
                                                            __('Allocate Amount')=>'th-main-color',
                                                            ] as $title=>$classes)
                                                            <x-tables.repeater-table-th class="{{ $classes }}" :title="$title"></x-tables.repeater-table-th>
                                                            @endforeach
                                                        </x-slot>
                                                        <x-slot name="trs">
                                                            @php
                                                            $rows = [-1] ;
                                                            /// $rows = isset($model) ? $model->settlementAllocations :[-1] ;

                                                            @endphp
                                                            @foreach( count($rows) ? $rows : [-1] as $settlementAllocation)
                                                            @php
                                                            $fullPath = new \App\Models\SettlementAllocation;
                                                            if( !($settlementAllocation instanceof $fullPath) ){
                                                            unset($settlementAllocation);
                                                            }
                                                            @endphp
                                                            <tr @if($isRepeater) data-repeater-item @endif>

                                                                <td class="text-center">
                                                                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                                                                    <div class="">
                                                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                                        </i>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <x-form.select :insideModalWithJs="true" :selectedValue="isset($settlementAllocation) && $settlementAllocation->partner_id ? $settlementAllocation->partner_id : ''" :options="formatOptionsForSelect($clientsWithContracts)" :add-new="false" class=" suppliers-or-customers-js custom-w-25" data-filter-type="{{ 'create' }}" :all="false" data-name="partner_id" name="partner_id"></x-form.select>
                                                                </td>

                                                                <td>
                                                                    <x-form.select :insideModalWithJs="true" data-current-selected="{{ isset($settlementAllocation) ? $settlementAllocation->id : '' }}" :selectedValue="isset($settlementAllocation) ? $settlementAllocation->contract_id : ''" :options="[]" :add-new="false" class=" contracts-js   custom-w-25" data-filter-type="{{ 'create' }}" :all="false" data-name="contract_id" name="contract_id"></x-form.select>
                                                                </td>

                                                                <td>
                                                                    <div class="kt-input-icon custom-w-20">
                                                                        <div class="input-group">
                                                                            <input disabled type="text" class="form-control contract-code " value="">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="kt-input-icon custom-w-15">
                                                                        <div class="input-group">
                                                                            <input disabled type="text" class="form-control contract-amount" value="0">
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                                <td>
                                                                    <div class="kt-input-icon custom-w-15">
                                                                        <div class="input-group">
                                                                            <input type="text" data-name="allocation_amount" name="allocation_amount" class="form-control " value="{{ isset($settlementAllocation) ? $settlementAllocation->getAmount(): 0 }}">
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>



                                                            @endforeach

                                                        </x-slot>




                                                    </x-tables.repeater-table>
                                                    {{-- end of fixed monthly repeating amount --}}















































































                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                {{-- <button type="button" class="btn btn-primary ">{{ __('Save') }}</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-1 width-10"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-8"></div>
                <div class="col-md-1 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12"></div>
                <div class="col-md-2 width-12">
                    <label class="label">{{ __('Unapplied Amount') }}</label>
                    <input id="remaining-settlement-js" class="form-control" placeholder="{{ __('Unapplied Amount') }}" type="text" name="unapplied_amount" value="0">
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
    $('#type').change(function() {
        selected = $(this).val();
        $('.js-section-parent').addClass('hidden');
        if (selected) {
            $('#' + selected).removeClass('hidden');

        }


    });
    $('#type').trigger('change')

</script>
<script src="/custom/money-payment.js">

</script>

<script>
    $(document).on('change', '.settlement-amount-class', function() {

    })
    $(function() {
        $('#type').trigger('change');
    })

    $(document).on('change', 'select#type', function(e) {
        const moneyType = $(this).val();
        const activeClass = 'js-' + moneyType + '-received-amount';
        const invoiceCurrency = $('select.invoice-currency-class').val();
        const receivingCurrency = $('select.receiving-currency-class').val();
        //  if (invoiceCurrency != receivingCurrency) {
        //      $('.main-amount-class[data-type="' + moneyType + '"]').removeClass(activeClass)
        //      $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').addClass(activeClass)
        //  } else {
        //      $('.main-amount-class[data-type="' + moneyType + '"]').addClass(activeClass)
        //      $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').removeClass(activeClass)
        //  }
    })
    $(document).on('change', 'select.currency-class', function() {
        const invoiceCurrency = $('select.invoice-currency-class').val();
        const receivingCurrency = $('select.receiving-currency-class').val();
        const moneyType = $('select#type').val();
        if (invoiceCurrency != receivingCurrency) {
            $('.show-only-when-invoice-currency-not-equal-receiving-currency').removeClass('hidden')

        } else {
            // hide 

            $('.show-only-when-invoice-currency-not-equal-receiving-currency').addClass('hidden')
        }

    })
    $(document).on('change', '.recalculate-amount-class', function() {
        const moneyType = $(this).attr('data-type')
        const amount = $('.main-amount-class[data-type="' + moneyType + '"]').val();
        const exchangeRate = $('.exchange-rate-class[data-type="' + moneyType + '"]').val();
        const amountAfterExchangeRate = amount * exchangeRate;
        $('.amount-after-exchange-rate-class[data-type="' + moneyType + '"]').val(amountAfterExchangeRate).trigger('change')
        $('.js-settlement-amount:eq(0)').trigger('change')
    })
    $(document).on('change', 'select[when-change-trigger-account-type-change]', function(e) {
        $('select.js-update-account-number-based-on-account-type').trigger('change')
    });

</script>
<script>
    $(document).on('change', '.js-account-number', function() {
        const parent = $(this).closest('.js-section-parent');
        const financialInstitutionId = parent.find('select.financial-institution-id').val()
        const accountNumber = $(this).val();
        const accountType = parent.find('select.js-update-account-number-based-on-account-type').val();
        $.ajax({
            url: "{{ route('update.balance.and.net.balance.based.on.account.number',['company'=>$company->id]) }}"
            , data: {
                accountNumber
                , accountType
                , financialInstitutionId
            }
            , type: "get"
            , success: function(res) {
                if (res.balance_date) {
                    $(parent).find('.balance-date-js').html('[ ' + res.balance_date + ' ]')
                }
                if (res.net_balance_date) {
                    $(parent).find('.net-balance-date-js').html('[ ' + res.net_balance_date + ' ]')
                }
                $(parent).find('.net-balance-js').val(number_format(res.net_balance))
                $(parent).find('.balance-js').val(number_format(res.balance))

            }
        })
    })
    $(function() {
        $('select.currency-class').trigger('change')
        $('.recalculate-amount-class').trigger('change')
    })

</script>


<script>
    $(document).on('change', 'select.suppliers-or-customers-js', function() {
        const parent = $(this).closest('tr')
        const partnerId = parseInt($(this).val())
        const model = $('#model_type').val()
        let inEditMode = "{{ $inEditMode ?? 0 }}";

        $.ajax({
            url: "{{ route('get.contracts.for.customer.or.supplier',['company'=>$company->id]) }}"
            , data: {
                partnerId
                , model
                , inEditMode
            }
            , type: "get"
            , success: function(res) {
                let contracts = '';
                const currentSelected = $(parent).find('select.contracts-js').data('current-selected')
                for (var contract of res.contracts) {
                    contracts += `<option ${currentSelected ==contract.id ? 'selected' :'' } value="${contract.id}" data-code="${contract.code}" data-amount="${contract.amount}" data-currency="${contract.currency}" >${contract.name}</option>`;
                }
                parent.find('select.contracts-js').empty().append(contracts).trigger('change')
                parent.find('select.contracts-js').selectpicker("refresh")
            }
        })
    })
    $(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('tr')
        const code = $(this).find('option:selected').data('code')
        const amount = $(this).find('option:selected').data('amount')
        const currency = $(this).find('option:selected').data('currency').toUpperCase()
        $(parent).find('.contract-code').val(code)
        $(parent).find('.contract-amount').val(number_format(amount) + ' ' + currency)

    })
    $(function() {
        $('select.suppliers-or-customers-js').trigger('change')
    })

</script>
@endsection
