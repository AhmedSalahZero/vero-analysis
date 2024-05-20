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
{{ __('Down Payments Form') }}
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
<form method="post" action="{{ isset($model) ?  route('update.money.receive',['company'=>$company->id,'moneyReceived'=>$model->id]) :route('store.money.receive',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
    <input id="js-in-edit-mode" type="hidden" name="in_edit_mode" value="{{ isset($model) ? 1 : 0 }}">
    <input id="js-down-payment-id" type="hidden" name="down_payment_id" value="{{ isset($model) ? $model->id : 0 }}">
    <input type="hidden" id="ajax-sales-order-item" data-single-model="{{ $singleModel ? 1 : 0 }}" value="{{ $singleModel ? $salesOrderId : 0 }}">
    @csrf
    @if(isset($model))
    @method('put')
    @endif
    {{-- Money Received --}}
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Down Payment')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-md-2">
                    <label>{{__('Select Money Type')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select required name="type" id="type" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>

                                <option @if(isset($model) && $model->isCashInSafe() ) selected @endif value="{{ MoneyReceived::CASH_IN_SAFE }}">{{__('Cash In Safe')}}</option>
                                <option @if(isset($model) && $model->isCashInBank() ) selected @endif value="{{ MoneyReceived::CASH_IN_BANK }}">{{__('Bank Deposit')}}</option>
                                <option @if(isset($model) && $model->isCheque() ) selected @endif value="{{ MoneyReceived::CHEQUE }}">{{__('Cheque')}}</option>
                                <option @if(isset($model) && $model->isIncomingTransfer()) selected @endif value="{{ MoneyReceived::INCOMING_TRANSFER }}">{{__('Incoming Transfer')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal fade" id="js-choose-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select Bank') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <select id="js-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                        @foreach($banks as $bankId => $bankEnAndAr)
                                        <option data-name="{{ $bankEnAndAr }}" value="{{ $bankId }}">{{ $bankEnAndAr }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button id="js-append-bank-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>







                    <div class="modal fade" id="js-choose-receiving-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select receiving Bank') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <select id="js-receiving-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                        @foreach($banks as $bankId => $bankEnAndAr)
                                        <option data-name="{{ $bankEnAndAr }}" value="{{ $bankId }}">{{ $bankEnAndAr }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button id="js-append-receiving-bank-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="modal fade" id="js-choose-receiving-branch-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Branch') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="js-receiving-branch-names" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button id="js-append-receiving-branch-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>

                <div class="col-md-4">
                    <label>{{__('Customer Name')}}
                        @include('star')
                    </label>
                    <div class="kt-input-icon">
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select id="customer_name" data-live-search="true" data-actions-box="true" name="customer_id" class="form-control select2-select ajax-get-contracts-for-customer ajax-get-sales-orders-for-contract">
                                    {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                    @foreach($customers as $customerId => $customerName)
                                    <option @if($singleModel) selected @endif @if(isset($model) && $model->getCustomerName() == $customerName ) selected @endif value="{{ $customerId }}">{{$customerName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="col-md-1">
                    <label>{{__('Currency')}}
                        @include('star')
                    </label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select id="currency" name="currency" class="form-control ajax-get-contracts-for-customer current-currency ajax-get-sales-orders-for-contract">
                                <option value="" selected>{{__('Select')}}</option>
                               @foreach(isset($currencies) ? $currencies : getBanksCurrencies () as $currencyId=>$currentName)
							   @php
								$selected = isset($model) ?  $model->getCurrency()  == $currencyId  :  $currentName == $company->getMainFunctionalCurrency() ;
									$selected = $selected ? 'selected':'';
							   @endphp
                                <option {{ $selected }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <label>{{__('Contract Name')}}
                        @include('star')
                    </label>
                    <div class="kt-input-icon">
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select id="contract-id" name="contract_id" class="form-control ajax-get-sales-orders-for-contract">
                                    <option value="" selected>{{__('Select')}}</option>
                                    @foreach($contracts as $index => $contract)
                                    <option @if(isset($model) && $model->getContractId() == $contract->id ) selected @endif value="{{ $contract->id }}">{{$contract->getName()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label>{{__('Receiving Date')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="receiving_date" value="{{ isset($model) ? formatDateForDatePicker($model->getReceivingDate()) : formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
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

    {{-- Cash In Safe Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyReceived::CASH_IN_SAFE }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Cash Information')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45 ">
                        <label>{{__('Select Receiving Branch')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="receiving_branch_id" class="form-control">
                                    <option value="-1">{{__('New Branch')}}</option>
                                    @foreach($selectedBranches as $branchId=>$branchName)
                                    <option value="{{ $branchId }}" {{ isset($model) && $model->getCashInSafeReceivingBranchId() == $branchId ? 'selected' : '' }}>{{ $branchName }}</option>
                                    @endforeach
                                </select>
                                <button id="js-receiving-branch" class="btn btn-sm btn-primary">{{ __('Add New Branch') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{__('Received Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getReceivedAmount() :0 }}" name="received_amount[{{ MoneyReceived::CASH_IN_SAFE }}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyReceived::CASH_IN_SAFE .'-received-amount' }}" placeholder="{{__('Received Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Receipt Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number" value="{{ isset($model) ?  $model->getCashInSafeReceiptNumber()  : '' }}" class="form-control" placeholder="{{__('Receipt Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyReceived::CASH_IN_SAFE }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Bank Deposit Information--}}
    {{-- Incoming Transfer Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyReceived::CASH_IN_BANK }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Bank Deposit Information')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label>{{__('Select Receiving Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="receiving_bank_id[{{ MoneyReceived::CASH_IN_BANK  }}]" class="form-control ">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getCashInBankReceivingBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <label>{{__('Deposit Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getReceivedAmount():0 }}" name="received_amount[{{ MoneyReceived::CASH_IN_BANK }}]" class="form-control greater-than-or-equal-zero-allowed {{ 'js-'. MoneyReceived::CASH_IN_BANK .'-received-amount' }}" placeholder="{{__('Insert Amount')}}">
                        </div>
                    </div>



                    <div class="col-md-2 width-12">
                        <label>{{__('Account Type')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[{{ MoneyReceived::CASH_IN_BANK }}]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected>{{__('Select')}}</option>
                                    @foreach($accountTypes as $index => $accountType)
                                    <option value="{{ $accountType->id }}" @if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id) selected @endif>{{ $accountType->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label>{{__('Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getCashInBankAccountNumber(): 0 }}" name="account_number[{{ MoneyReceived::CASH_IN_BANK }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyReceived::CASH_IN_BANK }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>




















    {{-- Cheques Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyReceived::CHEQUE }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Cheque Information')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label>{{__('Select Drawee Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                {{-- drawee_bank_id
							**					هو البنك اللي العميل جابلي منه الشيك وبالتالي مش شرط يكون من بنوك لانة ممكن يكون من بنك خاص بالعميل

                                 --}}
                                <select name="drawee_bank_id" class="form-control ">
                                    @foreach($selectedBanks as $bankId=>$bankName)
                                    <option value="{{ $bankId }}" {{ isset($model) && $model->cheque && $model->cheque->getDraweeBankId() == $bankId ? 'selected':'' }}>{{ $bankName }}</option>
                                    @endforeach
                                </select>
                                <button id="js-drawee-bank" class="btn btn-sm btn-primary">{{ __('Add New Bank') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label>{{__('Cheque Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="{{ isset($model) ? $model->getReceivedAmount() : 0 }}" placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="received_amount[{{ MoneyReceived::CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyReceived::CHEQUE .'-received-amount' }}">
                        </div>
                    </div>




                    <div class="col-md-2 width-12">
                        <label>{{__('Due Date')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" value="{{ isset($model) && $model->cheque ? formatDateForDatePicker($model->cheque->getDueDate()):formatDateForDatePicker(now()->format('Y-m-d')) }}" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2 width-12">
                        <label>{{__('Cheque Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" value="{{ isset($model) && $model->cheque ? $model->cheque->getChequeNumber() : 0 }}" class="form-control" placeholder="{{__('Cheque Number')}}">
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyReceived::CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>

    {{-- Incoming Transfer Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyReceived::INCOMING_TRANSFER }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Incoming Transfer Information')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label>{{__('Select Receiving Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="receiving_bank_id[{{ MoneyReceived::INCOMING_TRANSFER }}]" class="form-control ">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getIncomingTransferReceivingBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <label>{{__('Incoming Transfer Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getReceivedAmount():0 }}" name="received_amount[{{ MoneyReceived::INCOMING_TRANSFER }}]" class="form-control greater-than-or-equal-zero-allowed {{ 'js-'. MoneyReceived::INCOMING_TRANSFER .'-received-amount' }}" placeholder="{{__('Insert Amount')}}">
                        </div>
                    </div>



                    <div class="col-md-2 width-12">
                        <label>{{__('Account Type')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="account_type[{{ MoneyReceived::INCOMING_TRANSFER }}]" class="form-control js-update-account-number-based-on-account-type">
                                    <option value="" selected>{{__('Select')}}</option>
                                    @foreach($accountTypes as $index => $accountType)
                                    <option value="{{ $accountType->id }}" @if(isset($model) && $model->getIncomingTransferAccountTypeId() == $accountType->id) selected @endif>{{ $accountType->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 width-12">
                        <label>{{__('Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getIncomingTransferAccountNumber() : 0 }}" name="account_number[{{ MoneyReceived::INCOMING_TRANSFER }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyReceived::INCOMING_TRANSFER }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
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
                    {{__('Recevied Amount Information')}}
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

                            <div class="col-md-4">
                                <label>{{__('SO Number')}} </label>
                                <div class="kt-input-icon">
                                    <input name="sales_orders_amounts[][sales_order_name]" type="text" readonly class="form-control js-sales-order-name">
                                    <input name="sales_orders_amounts[][sales_order_id]" type="hidden" readonly class="form-control js-sales-order-number">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>{{__('Amount')}} </label>
                                <div class="kt-input-icon">
                                    <input name="sales_orders_amounts[][net_invoice_amount]" type="text" disabled class="form-control js-amount">
                                </div>
                            </div>






                            <div class="col-md-2">
                                <label>{{__('Received Amount')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input name="sales_orders_amounts[][received_amounts]" placeholder="{{ __('Received Amount') }}" type="text" class="form-control js-received-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

            {{-- <hr> --}}
            {{-- <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2 width-12 ml-auto mr-4">
                    <label class="label">{{ __('Unapplied Amount') }}</label>
            <input id="remaining-settlement-js" class="form-control" placeholder="{{ __('Unapplied Amount') }}" type="text" name="unapplied_amount" value="0">
        </div>
    </div> --}}
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
<script>
    $(document).on('change', '.ajax-get-contracts-for-customer', function(e) {
        e.preventDefault()
        const customerId = $('#customer_name').val()
        const currency = $('#currency').val()
        if (customerId && currency) {
            $.ajax({
                url: "{{ route('get.contracts.for.customer',['company'=>$company->id]) }}"
                , data: {
                    customerId
                    , currency
                }
                , success: function(res) {
                    let options = '';
                    for (id in res.contracts) {
                        options += `<option value="${id}">${res.contracts[id]}</option>`
                    }
                    $('#contract-id').empty().append(options);
					$('#contract-id').trigger('change')
                }
            })
        }
    })

</script>

<script>
$('select#customer_name').trigger('change')
</script>
@endsection
