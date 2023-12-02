@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
input[type="checkbox"]{
	cursor:pointer;
}
    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 200px !important;
    }

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

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1" >
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == 'cheques-in-safe' ?'active':'' }}" data-toggle="tab" href="#cheques-in-safe" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Cheques In Safe Table') }}
                    </a>
                </li>
				 <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'cheques-under-collection' ? 'active':''  }}" data-toggle="tab" href="#cheques-under-collection" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Cheques Under Collection Table') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'money-transfer' ? 'active':''  }}" data-toggle="tab" href="#money-transfer" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Incoming Transfer Table') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'cash' ? 'active':''  }}" data-toggle="tab" href="#cash" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Cash Received Table') }}
                    </a>
                </li>
            </ul>
			
			<a href="{{route('create.money.receive',['company'=>$company->id])}}" class="btn  active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                {{ __('New Record') }}
            </a>
			{{-- <a href="" class="btn  active-style btn-icon-sm  align-self-center ">
				<i class="fas fa-plus"></i>
				<span>{{ __('New Record') }}</span>
			</a> --}}
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active') || Request('active') == 'cheques-in-safe' ?'active':'' }}" id="cheques-in-safe" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Cheques Received Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-money :search-fields="$chequesReceivedTableSearchFields" :money-received-type="'cheques-in-safe'"  :has-search="1" :has-batch-collection="1" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Select') }}</th>
								
                                    <th>{{ __('Customer Name') }}</th>
                                    {{-- <th>{{ __('Invoice/Contract') }}</th> --}}
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th>{{ __('Cheque Number') }}</th>
                                    <th>{{ __('Cheque Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th class="bank-max-width">{{ __('Drawee Bank') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                    <th>{{ __('Due After Days') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedChequesInSave as $cheque)
                                <tr>
									<td>
										<input style="max-height:25px;" id="cash-send-to-collection-{{ $cheque->id }}" type="checkbox" name="second_to_collection[]" value="{{ $cheque->id }}"  class="form-control checkbox js-send-to-collection" >
									</td>
                                    <td>{{ $cheque->getCustomerName() }}</td>
                                    {{-- <td>{{ $cheque->id }}</td> --}}
                                    <td class="text-nowrap">{{ $cheque->getReceivingDateFormatted() }}</td>
                                    <td>{{ $cheque->getChequeNumber() }}</td>
                                    <td>{{ $cheque->getReceivedAmountFormatted() }}</td>
                                    <td class="text-transform">{{ $cheque->getCurrencyFormatted() }}</td>
                                    <td class="bank-max-width">{{ $cheque->getDraweeBankName() }}</td>
                                    <td class="text-nowrap">{{ $cheque->getChequeDueDateFormatted() }}</td>
                                    <td>{{ $cheque->getChequeDueAfterDays() }}</td>
                                    <td> {{ $cheque->getChequeStatusFormatted() }} </td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$cheque->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-type="single" data-id="{{ $cheque->id }}" data-toggle="modal" data-target="#send-to-under-collection-modal" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-warning btn-icon" title="{{ __('Send Under Collection') }}" href=""><i class="fa fa-sync-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-cheque-id-{{ $cheque->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-{{ $cheque->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$cheque->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            {{-- <div class="modal-body">
                                                            ...
                                                        </div> --}}
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			
			
			
			
			
			
			<div class="tab-pane {{ Request('active') == 'cheques-under-collection' ? 'active':''  }}" id="cheques-under-collection" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Cheques Under Collection Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-money :search-fields="$chequesUnderCollectionTableSearchFields" :money-received-type="'cheques-under-collection'" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
						
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
								
                                    <th class="align-middle">{{ __('Customer Name') }}</th>
                                    {{-- <th>{{ __('Receiving Date') }}</th> --}}
                                    <th class="align-middle">{{ __('Cheque Number') }}</th>
                                    <th class="align-middle">{{ __('Cheque Amount') }}</th>
                                    <th class="align-middle">{{ __('Deposit Date') }}</th>
                                    <th class="bank-max-width align-middle">{{ __('Drawal Bank') }}</th>
                                    {{-- <th>{{ __('Main Account Number') }}</th> --}}
                                    <th class="align-middle">{{ __('Sub Account Number') }}</th>
                                    <th class="align-middle">{{ __('Clearance Days') }}</th>
                                    <th class="align-middle">{!! __('Cheque Expected <br> Collection Date') !!}</th>
                                    <th class="align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedChequesUnderCollection as $cheque)
                                <tr>
									
                                    <td>{{ $cheque->getCustomerName() }}</td>
                                    {{-- <td>{{ $cheque->id }}</td> --}}
                                    {{-- <td>{{ $cheque->getReceivingDateFormatted() }}</td> --}}
                                    <td>{{ $cheque->getChequeNumber() }}</td>
                                    <td>{{ $cheque->getReceivedAmountFormatted() }}</td>
                                    <td class="text-nowrap"> {{$cheque->getChequeDepositDate()}} </td>
                                    <td class="bank-max-width">{{ $cheque->chequeDrawlBankName() }}</td>
                                    {{-- <td>{{ $cheque->chequeMainAccountNumber() }}</td> --}}
                                    <td>{{ $cheque->chequeSubAccountNumber() }}</td>
                                    <td> {{ $cheque->chequeClearanceDays() }} </td>
                                    <td> {{ $cheque->chequeExpectedCollectionDateFormatted() }} </td>
									
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$cheque->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a  type="button" class="btn  btn-secondary btn-outline-hover-warning btn-icon" title="{{ __('Send In Safe') }}" href="{{ route('cheque.send.to.safe',['company'=>$company->id,'moneyReceived'=>$cheque->id ]) }}"><i class="fa fa-sync-alt"></i></a>
                                            <a  type="button" class="btn  btn-secondary btn-outline-hover-warning btn-icon" title="{{ __('Rejected') }}" href="{{ route('cheque.send.to.rejected.safe',['company'=>$company->id,'moneyReceived'=>$cheque->id ]) }}"><i class="fa fa-undo"></i></a>
                                            <a data-toggle="modal" data-target="#delete-cheque-id-{{ $cheque->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-{{ $cheque->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$cheque->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            {{-- <div class="modal-body">
                                                            ...
                                                        </div> --}}
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
			
			
			
			
			
            <!--End:: Tab Content-->

            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ Request('active') == 'money-transfer' ? 'active':''  }}" id="money-transfer" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Incoming Transfer Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-money :search-fields="$incomingTransferTableSearchFields" :money-received-type="'money-transfer'" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Customer Name') }}</th>
                                    {{-- <th>{{ __('Invoice/Contract') }}</th> --}}
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th class="bank-max-width">{{ __('Receiving Bank') }}</th>
                                    <th>{{ __('Transfer Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    {{-- <th>{{ __('Payment Bank') }}</th> --}}
                                    {{-- <th>{{ __('Main Bank Account') }}</th> --}}
                                    <th>{{ __('Sub-account Number') }}</th>
                                    {{-- <th>{{ __('Status') }}</th> --}}
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedTransfer as $money)
                                <tr>
                                    <td>{{ $money->getCustomerName() }}</td>
                                    {{-- <td>COD2025</td> --}}
                                    <td>{{ $money->getReceivingDateFormatted() }}</td>
                                    <td>{{ $money->getReceivingBankName() }}</td>
                                    <td>{{ $money->getReceivedAmountFormatted() }}</td>
                                    <td>{{ $money->getCurrencyFormatted() }}</td>
                                    {{-- <td class="bank-max-width">{{ $money->getTransferMoneyDueAfterDays() }}</td> --}}
                                    {{-- <td>{{ $money->getMainAccountNumber() }}</td> --}}
                                    <td>{{ $money->getSubAccountNumber() }}</td>
                                    {{-- <td>{{ $money->getTransferMoneyStatus() }}</td> --}}
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id]) }}"><i class="fa fa-pen-alt"></i></a>

                                            <a data-toggle="modal" data-target="#delete-transfer-id-{{ $money->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-{{ $money->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                           
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>

            <!--End:: Tab Content-->


            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ Request('active') == 'cash' ? 'active':''  }}" id="cash" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Cash Received Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-money :search-fields="$cashReceivedTableSearchFields" :money-received-type="'cash'" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('Received Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Receipt Number') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
							@foreach($receivedCashes as $cash)
                                <tr>
                                    <td>{{ $cash->getCustomerName() }}</td>
                                    <td>{{ $cash->getReceivingDateFormatted() }}</td>
                                    <td>{{ $cash->getCashBranchName() }}</td>
                                    <td>{{ $cash->getReceivedAmountFormatted() }}</td>
                                    <td>{{ $cash->getCurrencyFormatted() }}</td>
                                    <td>{{ $cash->getReceiptNumber() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                         <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$cash->id]) }}"><i class="fa fa-pen-alt"></i></a>

                                            <a data-toggle="modal" data-target="#delete-transfer-id-{{ $cash->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-{{ $cash->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$cash->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                           
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
								@endforeach 
                            




                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>

            <!--End:: Tab Content-->
        </div>
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
<script>
$(document).on('click','.js-can-trigger-cheque-under-collection-modal',function(e){
	e.preventDefault();
	const type = $(this).attr('data-type') // single or multi
	$('#single-or-multi').val(type);
	if(type == 'single'){
		$('#current-single-item').val($(this).attr('data-id'));
	}
})
$(document).on('submit','.ajax-send-cheques-to-collection',function(e){
	e.preventDefault();
	const url = $(this).attr('action');
	const type = $('#single-or-multi').val();
	const singleId = parseInt($('#current-single-item').val());
	let checked = [];
	$('.js-send-to-collection:checked').each(function(index,element){
		checked.push(parseInt($(element).val()));
	});
	const checkedItems = type == 'multi' ? checked : [singleId] ;
	let form = document.getElementById('ajax-send-cheques-to-collection-id') ;
	  let formData = new FormData(form);
	   formData.append('cheques',checkedItems);
	   $('button').prop('disabled',true)
	 $.ajax({
		    cache: false
                , contentType: false
                , processData: false,
	 	url:url,
	 	data:formData,
	 	type:"post"
	 }).then(function(res){
		Swal.fire({
			text:'Done',
			icon:'success',
			timer:2000
		}).then(function(){
			window.location.reload();
		});
	 })
});
</script>
<script>
$(document).on('click','.js-close-modal',function(){
	$(this).closest('.modal').modal('hide');
})
$(document).on('click','#js-drawee-bank',function(e){
	e.preventDefault();
	$('#js-choose-bank-id').modal('show');
})

$(document).on('click','#js-append-bank-name-if-not-exist',function(){
	const receivingBank = document.getElementById('js-drawee-bank').parentElement;
	const newBankId = $('#js-bank-names').val();
	const newBankName = $('#js-bank-names option:selected').attr('data-name');
	const isBankExist =  $(receivingBank).find('select.js-drawl-bank').find('option[value="'+newBankId+'"]').length ;
	console.log(isBankExist,newBankId,$(receivingBank).find('option[value="'+newBankId+'"]')[0]);
	if(!isBankExist){
		const option = '<option selected value="'+newBankId+'">'+newBankName+'</option>'
		$('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
	}
	$('#js-choose-bank-id').modal('hide');
});
</script>
<script>
$(document).on('change','.js-search-modal',function(){
	const searchFieldName = $(this).val();
	const popupType = $(this).attr('data-type');
	const modal = $(this).closest('.modal');
	if(searchFieldName === 'due_date'){
		$('.data-type-span').html('[ {{ __("Due Date") }} ]')
		modal.find(modal).find('.search-field').val('').trigger('change').prop('disabled',true);
	}else if(searchFieldName=='receiving_date'){
		$(modal).find('.search-field').val('').trigger('change').prop('disabled',true);
		modal.find('.data-type-span').html('[ {{ __("Receiving Date") }} ]')
	}else if(searchFieldName=='cheque_deposit_date'){
		$(modal).find('.search-field').val('').trigger('change').prop('disabled',true);
		modal.find('.data-type-span').html('[ {{ __("Deposit Date") }} ]')
	}else{
		$(modal).find('.search-field').prop('disabled',false);
	}
})
$(function(){

	$('.js-search-modal').trigger('change')
	
})

</script>
@endsection
@push('js')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
