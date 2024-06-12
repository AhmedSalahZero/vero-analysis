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

    input.form-control[disabled],
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Money Payment Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        {{-- <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('Money Payment')}}
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
                    {{__('Money Payment')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                 <div class="col-md-3">
                    <label>{{__('Payment Date')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="delivery_date" value="{{ isset($model) ? formatDateForDatePicker($model->getDeliveryDate()) : formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
				
			 <div class="col-md-2">
                    <label>{{__('Select Currency')}} <span class="required">*</span></label>

                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                                {{-- <option value="" selected>{{__('Select')}}</option> --}}
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

                <div class="col-md-5">

                    <label>{{__('Supplier Name')}} <span class="required">*</span></label>
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

             	<div class="col-md-2">
                    <label>{{__('Select Money Type')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select required name="type" id="type" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>
                                <option @if(isset($model) && $model->isCashPayment() ) selected @endif value="{{ MoneyPayment::CASH_PAYMENT }}">{{__('Cash In Safe')}}</option>
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
                        <label>{{__('Select Delivery Branch')}} <span class="required">*</span></label>
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
                    <div class="col-md-3">
                        <label>{{__('Paid Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getPaidAmount() :0 }}" name="paid_amount[{{ MoneyPayment::CASH_PAYMENT}}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::CASH_PAYMENT.'-paid-amount' }}" placeholder="{{__('Paid Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Receipt Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number" value="{{ isset($model) ?  $model->getCashPaymentReceiptNumber()  : '' }}" class="form-control" placeholder="{{__('Receipt Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3 width-12">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::CASH_PAYMENT}}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Bank Deposit Information--}}
    {{-- Outgoing Transfer Information--}}
    {{-- <div class="kt-portlet js-section-parent hidden" id="{{ MoneyPayment::CASH_IN_BANK }}">
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
                    <label>{{__('Select Delivery Bank')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">

                            <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[{{ MoneyPayment::CASH_IN_BANK  }}]" class="form-control ">
                                @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getCashInBankDeliveryBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <label>{{__('Deposit Amount')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getPaidAmount():0 }}" name="paid_amount[{{ MoneyPayment::CASH_IN_BANK }}]" class="form-control greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::CASH_IN_BANK .'-received-amount' }}" placeholder="{{__('Insert Amount')}}">
                    </div>
                </div>



                <div class="col-md-2 width-12">
                    <label>{{__('Account Type')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="account_type[{{ MoneyPayment::CASH_IN_BANK }}]" class="form-control js-update-account-number-based-on-account-type">
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
                            <select data-current-selected="{{ isset($model) ? $model->getCashInBankAccountNumber(): 0 }}" name="account_number[{{ MoneyPayment::CASH_IN_BANK }}]" class="form-control js-account-number">
                                <option value="" selected>{{__('Select')}}</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-1">
                    <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::CASH_IN_BANK }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                    </div>
                </div>


            </div>
        </div>

    </div>
    </div> --}}




















    {{-- Cheques Information--}}
    <div class="kt-portlet js-section-parent hidden" id="{{ MoneyPayment::PAYABLE_CHEQUE }}">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Payable Cheque Information')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6  mb-3">
                        <label>{{__('Select Payment Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[{{ MoneyPayment::PAYABLE_CHEQUE  }}]" class="form-control ">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getPayableChequePaymentBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>
                                {{-- <button id="js-delivery-bank" class="btn btn-sm btn-primary">{{ __('Add New Bank') }}</button> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label>{{__('Account Type')}} <span class="required">*</span></label>
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


                    <div class="col-md-2 ">
                        <label>{{__('Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getPayableChequeAccountNumber() : 0 }}" name="account_number[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>{{__('Cheque Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="{{ isset($model) ? $model->getPaidAmount() : 0 }}" placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="paid_amount[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::PAYABLE_CHEQUE .'-paid-amount' }}">
                        </div>
                    </div>



                    <div class="col-md-3">
                        <label>{{__('Due Date')}} <span class="required">*</span></label>
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


                    <div class="col-md-2">
                        <label>{{__('Cheque Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" value="{{ isset($model) && $model->payableCheque ? $model->payableCheque->getChequeNumber() : 0 }}" class="form-control" placeholder="{{__('Cheque Number')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::PAYABLE_CHEQUE }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>



                    {{-- <div class="col-md-4">
                        <label>{{__('Select Currency')}} <span class="required">*</span></label>
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
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Outgoing Transfer Information')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 width-45">
                        <label>{{__('Select Payment Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">

                                <select js-when-change-trigger-change-account-type data-financial-institution-id name="delivery_bank_id[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control ">
                                    @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                    <option value="{{ $financialInstitutionBank->id }}" {{ isset($model) && $model->getOutgoingTransferDeliveryBankId() == $financialInstitutionBank->id ? 'selected' : '' }}>{{ $financialInstitutionBank->getName() }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <label>{{__('Outgoing Transfer Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getPaidAmount():0 }}" name="paid_amount[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control greater-than-or-equal-zero-allowed {{ 'js-'. MoneyPayment::OUTGOING_TRANSFER .'-paid-amount' }}" placeholder="{{__('Insert Amount')}}">
                        </div>
                    </div>



                    <div class="col-md-2 width-12">
                        <label>{{__('Account Type')}} <span class="required">*</span></label>
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
                        <label>{{__('Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select data-current-selected="{{ isset($model) ? $model->getOutgoingTransferAccountNumber() : 0 }}" name="account_number[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control js-account-number">
                                    <option value="" selected>{{__('Select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-1">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getExchangeRate() : 1}}" placeholder="{{ __('Exchange Rate') }}" type="text" name="exchange_rate[{{ MoneyPayment::OUTGOING_TRANSFER }}]" class="form-control only-greater-than-or-equal-zero-allowed ">
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
                    {!! SupplierInvoice::getSettlementsTemplate() !!}
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

</script>

@endsection
