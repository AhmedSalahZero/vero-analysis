@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
label{
	text-align:left !important;
}
.width-8{
	max-width: initial !important;
    width: 8% !important;
    flex: initial !important;
}
.width-10{
	max-width: initial !important;
    width: 10% !important;
    flex: initial !important;
}
.width-12{
	max-width: initial !important;
    width: 13.5% !important;
    flex: initial !important;
}
.width-45{
	max-width: initial !important;
    width: 45% !important;
    flex: initial !important;
}
    .kt-portlet {
        overflow: visible !important;
    }
input.form-control[disabled],
input.form-control:not(.is-date-css)[readonly]
 {
            background-color: #CCE2FD !important;
            font-weight: bold !important;
        }
</style>
@endsection
@section('sub-header')
{{ __('Money Received Form') }}
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
	<input id="js-money-received-id" type="hidden" name="money_received_id" value="{{ isset($model) ? $model->id : 0 }}">
	<input type="hidden" id="ajax-invoice-item" data-single-model="{{ $singleModel ? 1 : 0 }}" value="{{ $singleModel ? $invoiceNumber : 0 }}">
@csrf 
@if(isset($model))
@method('put')
@endif 
    {{-- Money Received --}}
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Money Received')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-md-2">
                    <label>{{__('Select Money Type')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select  name="money_type" id="money_type" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>
                                <option @if(isset($model) && $model->isCash() ) selected  @endif value="cash">{{__('Cash')}}</option>
                                <option @if(isset($model) && $model->isCheque() ) selected  @endif value="cheque">{{__('Cheque')}}</option>
                                <option @if(isset($model) && $model->isIncomingTransfer()) selected  @endif value="incoming_transfer">{{__('Incoming Transfer')}}</option>
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
                                    <input type="text" id="js-receiving-branch-names"  class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    <button id="js-append-receiving-branch-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					
					
                </div>
				{{-- {{ dd($customerInvoices) }} --}}
			 <div class="col-md-5">

                            <label>{{__('Customer Name')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select id="customer_name"  name="customer_id" class="form-control ajax-get-invoice-numbers">
                                            <option value="" selected>{{__('Select')}}</option>
											{{-- {{  }} --}}
                                            @foreach($customerInvoices as $customerInvoiceId => $customerName)
                                            <option @if($singleModel) selected @endif @if(isset($model) && $model->getCustomerName() == $customerName  )  selected @endif value="{{ $customerInvoiceId }}">{{$customerName}}</option>
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
                                <select id="js-currency-id" name="currency" class="form-control ajax-get-invoice-numbers">
                                    <option value="" selected>{{__('Select')}}</option>
									@foreach(getBanksCurrencies() as $currencyId=>$currentName)
                                    <option {{ isset($model) && $model->getCurrency()  == $currencyId ? 'selected':'' }} value="{{ $currencyId }}">{{ $currentName }}</option>
									@endforeach 
                                </select>
                            </div>
                        </div>
                    </div>
					
                <div class="col-md-3">
                    <label>{{__('Receiving Date')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="receiving_date" value="{{ isset($model) ? formatDateForDatePicker($model->getReceivingDate()) : '' }}" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
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

    {{-- Cash Information--}}
    <div class="kt-portlet hidden" id="cash">
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
                                <select  name="receiving_branch_id"  class="form-control">
                                    <option value="-1">{{__('New Branch')}}</option>
									@foreach($selectedBranches as $branchId=>$branchName)
									<option value="{{ $branchId }}"  {{ isset($model) && $model->getReceivingBranchId() == $branchId ? 'selected' : '' }}  >{{ $branchName }}</option>
									@endforeach 
                                </select>
									<button id="js-receiving-branch" class="btn btn-sm btn-primary">{{ __('Add New Branch') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{__('Received Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getReceivedAmount() :0 }}" name="cash_received_amount"  class="form-control only-greater-than-or-equal-zero-allowed js-cash-received-amount" placeholder="{{__('Received Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>		
                    <div class="col-md-3 width-12">
                        <label>{{__('Receipt Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number" value="{{ isset($model) ?  $model->getReceiptNumber()  : '' }}"  class="form-control" placeholder="{{__('Receipt Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
					 <div class="col-md-3 width-12">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input  value="{{ isset($model) ? $model->getExchangeRate() : 0 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="cash_exchange_rate" class="form-control only-greater-than-or-equal-zero-allowed ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cheques Information--}}
    <div class="kt-portlet hidden" id="cheque">
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
                                <select  name="drawee_bank_id" class="form-control ">
                                    {{-- <option value="-1">{{__('New Bank')}}</option> --}}
									@foreach($selectedBanks as $bankId=>$bankName)
									<option value="{{ $bankId }}"  {{ isset($model) && $model->getDraweeBankId() == $bankId ? 'selected':'' }} >{{ $bankName }}</option>
									@endforeach 
                                </select>
								<button id="js-drawee-bank" class="btn btn-sm btn-primary">Add New Bank</button>
                            </div>
                        </div>
                    </div>
                    
				   
					<div class="col-md-2 width-12">
                        <label>{{__('Cheque Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" value="{{ isset($model) ? $model->getReceivedAmount() : 0 }}" placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="cheque_amount" class="form-control only-greater-than-or-equal-zero-allowed js-cheque-received-amount">
                        </div>
                    </div>
					
					
					

                    <div class="col-md-2 width-12">
                        <label>{{__('Due Date')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" value="{{ isset($model) ?$model->getChequeDueDate():0 }}" name="cheque_due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
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
                            <input type="text"  name="cheque_number" value="{{ isset($model) ? $model->getChequeNumber() : 0 }}" class="form-control" placeholder="{{__('Cheque Number')}}">
                        </div>
                    </div>
					
					 <div class="col-md-2 width-12">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input  value="{{ isset($model) ? $model->getExchangeRate() : 0 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="cheque_exchange_rate" class="form-control only-greater-than-or-equal-zero-allowed ">
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

    {{-- Incoming Transfer Information--}}
    <div class="kt-portlet hidden" id="incoming_transfer">
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
                                <select  name="receiving_bank_id" class="form-control">
								         {{-- <option value="-1">{{__('New Receiving Bank')}}</option> --}}
										 
										 		@foreach($selectedBanks as $bankId=>$bankName)
													<option value="{{ $bankId }}"  {{ isset($model) && $model->getReceivingBankName() == $bankName ? 'selected' : '' }} >{{ $bankName }}</option>
												@endforeach 
                                </select>
								<button id="js-receiving-bank" class="btn btn-sm btn-primary">Add New Bank</button>
								
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <label>{{__('Incoming Transfer Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input data-max-cheque-value="0" type="text" value="{{ isset($model) ? $model->getReceivedAmount():old('incoming_transfer_amount',0) }}"  name="incoming_transfer_amount"  class="form-control greater-than-or-equal-zero-allowed js-incoming_transfer-received-amount" placeholder="{{__('Insert Amount')}}">
                        </div>
                    </div>
                    {{-- <div class="col-md-2">
                        <label>{{__('Select Currency')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="income_transfer_currency" class="form-control">
                                    <option value="" selected>{{__('Select')}}</option>
                                    	@foreach(getBanksCurrencies() as $currencyId=>$currentName)
                                   			 <option {{ isset($model) && $model->getCurrency()  == $currencyId ? 'selected' :'' }} value="{{ $currencyId }}">{{ $currentName }}</option>
										@endforeach 
                                </select>
                            </div>
                        </div>
                    </div> --}}
					
					
					
					 <div class="col-md-2 width-12">
                        <label>{{__('Bank Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ? $model->getMainAccountNumber() : 0 }}" type="text" name="main_account_number"  class="form-control greater-than-or-equal-zero-allowed" placeholder="{{__('Bank Main Account')}}">
                         </div>
                    </div>
                    <div class="col-md-2 width-12">
                        <label>{{__('Sub-account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input value="{{ isset($model) ?  $model->getSubAccountNumber() : 0 }}" type="text" name="sub_account_number"  class="form-control greater-than-or-equal-zero-allowed" placeholder="{{__('Sub-account Number')}}">
                        </div>
                    </div>
					
					 <div class="col-md-2 width-10">
                        <label>{{__('Exchange Rate')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input  value="{{ isset($model) ? $model->getExchangeRate() : 0 }}" placeholder="{{ __('Exchange Rate') }}" type="text" name="incoming_transfer_exchange_rate" class="form-control only-greater-than-or-equal-zero-allowed ">
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
                <div  class="col-md-12 js-duplicate-node" >
                    <div  class=" kt-margin-b-10 border-class">
                        <div class="form-group row align-items-end">

                            <div class="col-md-1 width-10">
                                <label>{{__('Invoice Number')}} </label>
                                <div class="kt-input-icon">
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
											<input readonly class="form-control js-invoice-number"  name="settlements[][invoice_number]"  value="0"> 
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
                                    <input name="settlements[][settlement_amount]" placeholder="{{ __('Settlement Amount') }}" type="text"  class="form-control js-settlement-amount only-greater-than-or-equal-zero-allowed settlement-amount-class">
                                </div>
                            </div>
							<div class="col-md-2 width-12">
                                <label>{{__('Withhold Amount')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input name="settlements[][withhold_amount]" placeholder="{{ __('Withhold Amount') }}" type="text"  class="form-control js-withhold-amount only-greater-than-or-equal-zero-allowed ">
                                </div>
                            </div>


                            {{-- <div class="col-md-1 text-center">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-danger btn-elevate btn-circle btn-icon">
                                    <i class="fa fa-trash-alt"></i>
                                </a>
                            </div> --}}


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
				<div class="col-md-2">
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
    $('#money_type').change(function() {
        selected = $(this).val();
        if (selected == 'cash') {
            $('#cheque').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
            $('#cash').removeClass('hidden');
        } else if (selected == 'cheque') {
            $('#incoming_transfer').addClass('hidden');
            $('#cash').addClass('hidden');
            $('#cheque').removeClass('hidden');
        } else if (selected == 'incoming_transfer') {
            $('#cash').addClass('hidden');
            $('#cheque').addClass('hidden');
            $('#incoming_transfer').removeClass('hidden');
        } else if (selected == '') {
            $('#cash').addClass('hidden');
            $('#cheque').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
        }

    });
    $('#money_type').trigger('change')

</script>
<script src="/custom/money-receive.js">

</script>

<script>

	$(document).on('change','.settlement-amount-class',function(){
		
	})
	$(function(){
		$('#money_type').trigger('change');
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
