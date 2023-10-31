@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }
input.form-control[disabled] {
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
<!--begin::Form-->
<form class="kt-form kt-form--label-right">
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
                <div class="col-md-4">
                    <label>{{__('Select Money Type')}} <span class="required">*</span></label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <select name="money_type" id="money_type" class="form-control">
                                <option value="" selected>{{__('Select')}}</option>
                                <option value="cash">{{__('Cash')}}</option>
                                <option value="cheques">{{__('Cheques')}}</option>
                                <option value="incoming_transfer">{{__('Incoming Transfer')}}</option>
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
                                        @foreach($banks as $bankEnAndAr => $bankEn)
                                        <option value="{{ $bankEnAndAr }}">{{ $bankEnAndAr }}</option>
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
                                        @foreach($banks as $bankEnAndAr => $bankEn)
                                        <option value="{{ $bankEnAndAr }}">{{ $bankEnAndAr }}</option>
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
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select Branch') }}</h5>
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
				
			 <div class="col-md-4">

                            <label>{{__('Customer Name')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select id="ajax-get-invoice-numbers" name="customer_name" class="form-control">
                                            <option value="" selected>{{__('Select')}}</option>
                                            @foreach($customers as $customerId => $customerName)
                                            <option value="{{ $customerId }}">{{$customerName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
			
                <div class="col-md-4">
                    <label>{{__('Receiving Date')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="text" name="receiving_date" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
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
                    <div class="col-md-3">
                        <label>{{__('Select Receiving Branch')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select id="js-receiving-branch" name="receiving_branch" class="form-control">
                                    <option value="-1">{{__('New Branch')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{__('Received Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="received_amount"  class="form-control only-greater-than-or-equal-zero-allowed" placeholder="{{__('Received Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-3">
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
                    </div>
                    <div class="col-md-3">
                        <label>{{__('Receipt Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="receipt_number"  class="form-control" placeholder="{{__('Receipt Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cheques Information--}}
    <div class="kt-portlet hidden" id="cheques">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title head-title text-primary">
                    {{__('Cheques Information')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>{{__('Select Drawee Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select id="js-drawee-bank" name="drawee_bank" class="form-control ">
                                    <option value="-1">{{__('New Bank')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>{{__('Cheque Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="cheque_amount" class="form-control only-greater-than-or-equal-zero-allowed">
                            <x-tool-tip title="{{__('Please insert the cheque amount')}}" />
                        </div>
                    </div>


                    <div class="col-md-2">
                        <label>{{__('Cheque Due Date')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input type="text" name="cheque_due_date" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <label>{{__('Cheque Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="cheque_number" class="form-control" placeholder="{{__('Cheque Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
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
                    <div class="col-md-4">
                        <label>{{__('Select Receiving Bank')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select id="js-receiving-bank" name="receiving_bank" class="form-control">
								         <option value="-1">{{__('New Receiving Bank')}}</option>
										 {{-- @foreach($oldBanks??[] as $oldBank) --}}
										 {{-- @endforeach  --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>{{__('Incoming Transfer Amount')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="incoming_transfer_amount"  class="form-control greater-than-or-equal-zero-allowed" placeholder="{{__('Insert Amount')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    </div>
					
					 <div class="col-md-2">
                        <label>{{__('Bank Main Account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="main_account_number"  class="form-control greater-than-or-equal-zero-allowed" placeholder="{{__('Bank Main Account')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>{{__('Sub-account Number')}} <span class="required">*</span></label>
                        <div class="kt-input-icon">
                            <input type="text" name="subaccount_number"  class="form-control greater-than-or-equal-zero-allowed" placeholder="{{__('Sub-account Number')}}">
                            <x-tool-tip title="{{__('Kash Vero')}}" />
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
                {{-- <div class="form-group "> --}}
                <div  class="col-md-12 js-duplicate-node" >
                    <div  class=" kt-margin-b-10 border-class">
                        {{-- Date --}}
                        <div class="form-group row align-items-end">

                            <div class="col-md-3">
                                <label>{{__('Invoice Number')}} </label>
                                <div class="kt-input-icon">
                                    <div class="kt-input-icon">
                                        <div class="input-group date">
											<input disabled class="form-control js-invoice-number"  name="invoice_number[]"  value="0"> 
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <label>{{__('Invoice Date')}}</label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="text" class="form-control js-invoice-date" disabled />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-3">
                                <label>{{__('Net Invoice Amount')}} </label>
                                <div class="kt-input-icon">
                                    <input type="text" disabled class="form-control js-net-invoice-amount">
                                    {{-- <x-tool-tip title="{{__('Kash Vero')}}" /> --}}
                                </div>
                            </div>



                            <div class="col-md-3">
                                <label>{{__('Settlement Amount')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input placeholder="{{ __('insert the Settlement Amount') }}" type="text" name="settlement_amount" class="form-control only-greater-than-or-equal-zero-allowed">
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
                {{-- </div> --}}
                {{-- <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col">
                        <div data-repeater-create="" class="btn btn btn-primary">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Add</span>
                            </span>
                        </div>
                    </div>
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
    $('#money_type').change(function() {
        selected = $(this).val();
        if (selected == 'cash') {
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
            $('#cash').removeClass('hidden');
        } else if (selected == 'cheques') {
            $('#incoming_transfer').addClass('hidden');
            $('#cash').addClass('hidden');
            $('#cheques').removeClass('hidden');
        } else if (selected == 'incoming_transfer') {
            $('#cash').addClass('hidden');
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').removeClass('hidden');
        } else if (selected == '') {
            $('#cash').addClass('hidden');
            $('#cheques').addClass('hidden');
            $('#incoming_transfer').addClass('hidden');
        }

    });
    $('#money_type').trigger('change')

</script>
<script src="/custom/money-receive.js">

</script>
{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}
@endsection
