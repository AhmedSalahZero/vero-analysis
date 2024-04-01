@extends('layouts.dashboard')
@section('css')
@php
use App\Models\MoneyReceived;
@endphp
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
    button[type="submit"],
    button[type="button"] {
        font-size: 1rem !important;

    }

    button[type="submit"] {
        background-color: green !important;
        border: 1px solid green !important;
    }

    .kt-portlet__body {
        padding-top: 0 !important;
    }

    input[type="checkbox"] {
        cursor: pointer;
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
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == MoneyReceived::CHEQUE ?'active':'' }}" data-toggle="tab" href="#{{ MoneyReceived::CHEQUE }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Cheques In Safe') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == MoneyReceived::CHEQUE_UNDER_COLLECTION ? 'active':''  }}" data-toggle="tab" href="#{{ MoneyReceived::CHEQUE_UNDER_COLLECTION }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Cheques Under Collection') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == MoneyReceived::CHEQUE_COLLECTED ? 'active':''  }}" data-toggle="tab" href="#{{ MoneyReceived::CHEQUE_COLLECTED }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Collected Cheques') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{  Request('active') == MoneyReceived::CHEQUE_REJECTED ?'active':'' }}" data-toggle="tab" href="#{{ MoneyReceived::CHEQUE_REJECTED }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Rejected Cheques') }}
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == MoneyReceived::INCOMING_TRANSFER ? 'active':''  }}" data-toggle="tab" href="#{{ MoneyReceived::INCOMING_TRANSFER }}" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Incoming Transfer') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == MoneyReceived::CASH_IN_SAFE ? 'active':''  }}" data-toggle="tab" href="#{{ MoneyReceived::CASH_IN_SAFE }}" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Cash In Safe') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == MoneyReceived::CASH_IN_BANK ? 'active':''  }}" data-toggle="tab" href="#{{ MoneyReceived::CASH_IN_BANK }}" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Bank Deposit') }}
                    </a>
                </li>

            </ul>

            <a href="{{route('create.money.receive',['company'=>$company->id])}}" class="btn  btn-sm active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                {{ __('Money Received') }}
            </a>
			
			  <a href="{{route('create.money.receive',['company'=>$company->id,'type'=>'down-payment'])}}" class="btn btn-sm active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                {{ __('Down Payment') }}
            </a>

        </div>
    </div>
    {{-- {{ dd($start_date) }} --}}
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <!--Begin:: Tab Content-->
            {{-- {{ dd($filterDates[MoneyReceived::CHEQUE]['startDate']) }} --}}
            <div class="tab-pane {{ !Request('active') || Request('active') == MoneyReceived::CHEQUE ?'active':'' }}" id="{{ MoneyReceived::CHEQUE }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="MoneyReceived::CHEQUE" :title="__('Cheques In Safe')" :startDate="$filterDates[MoneyReceived::CHEQUE]['startDate']??''" :endDate="$filterDates[MoneyReceived::CHEQUE]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$chequesReceivedTableSearchFields" :money-received-type="MoneyReceived::CHEQUE" :has-search="1" :has-batch-collection="1" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="align-middle">{{ __('Select') }}</th>
                                    <th class="align-middle">{{ __('Type') }}</th>
                                    <th class="align-middle">{{ __('Customer Name') }}</th>
                                    <th class="align-middle">{!! __('Receiving<br>Date') !!}</th>
                                    <th class="align-middle">{!! __('Cheque<br>Number') !!}</th>
                                    <th class="align-middle">{!! __('Cheque<br>Amount') !!}</th>
                                    <th class="align-middle">{{ __('Currency') }}</th>
                                    <th class="align-middle" class="bank-max-width">{{ __('Drawee Bank') }}</th>
                                    <th class="align-middle">{!! __('Due<br>Date') !!}</th>
                                    <th class="align-middle">{!! __('Due <br> After Days') !!}</th>
                                    <th class="align-middle">{!! __('Status') !!}</th>
                                    <th class="align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedChequesInSafe as $moneyReceived)
                                <tr>
                                    <td>
                                        <input style="max-height:25px;" id="cash-send-to-collection{{ $moneyReceived->id }}" type="checkbox" name="second_to_collection[]" value="{{ $moneyReceived->id }}" data-money-type="{{ MoneyReceived::CHEQUE }}" class="form-control checkbox js-send-to-collection">
                                    </td>
                                    <td>{{ $moneyReceived->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCustomerName() }}</td>
                                    <td class="text-nowrap">{{ $moneyReceived->getReceivingDateFormatted() }}</td>
                                    <td>{{ $moneyReceived->cheque->getChequeNumber() }}</td>
                                    <td>{{ $moneyReceived->getReceivedAmountFormatted() }}</td>
                                    <td class="text-transform" data-currency="{{ $moneyReceived->getCurrency() }}">{{ $moneyReceived->getCurrencyFormatted() }}</td>
                                    <td class="bank-max-width">{{ $moneyReceived->cheque->getDraweeBankName() }}</td>
                                    <td class="text-nowrap">{{ $moneyReceived->cheque->getDueDateFormatted() }}</td>
                                    <td>{{ $moneyReceived->cheque->getDueAfterDays() }}</td>
									@php
										$dueStatus = $moneyReceived->cheque->getDueStatusFormatted() ;
									@endphp
									
                                    <td class="font-weight-bold" style="color:{{ $dueStatus['color'] }}!important">{{ $dueStatus['status'] }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										@if(!$moneyReceived->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}"><i class="fa fa-pen-alt"></i></a>
											@endif 
                                            <a data-id="{{ $moneyReceived->id }}" data-type="single" data-currency="{{ $moneyReceived->getCurrency() }}" data-money-type="{{ MoneyReceived::CHEQUE }}" data-toggle="modal" data-target="#send-to-under-collection-modal{{ MoneyReceived::CHEQUE }}" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-primary btn-icon" title="{{ __('Send Under Collection') }}" href=""><i class="fa fa-money-bill"></i></a>
											@if(!$moneyReceived->isOpenBalance())
                                            <a data-toggle="modal" data-target="#delete-cheque-id-{{ $moneyReceived->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-{{ $moneyReceived->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}" method="post">
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
											@endif 
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




            <div class="tab-pane {{  Request('active') == MoneyReceived::CHEQUE_REJECTED ?'active':'' }}" id="{{ MoneyReceived::CHEQUE_REJECTED }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                    <x-table-title.with-two-dates :type="MoneyReceived::CHEQUE_REJECTED" :title="__('Rejected Cheques')" :startDate="$filterDates[MoneyReceived::CHEQUE_REJECTED]['startDate']??''" :endDate="$filterDates[MoneyReceived::CHEQUE_REJECTED]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$chequesRejectedTableSearchFields" :money-received-type="MoneyReceived::CHEQUE_REJECTED" :has-search="1" :has-batch-collection="1" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Select') }}</th>

                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th>{{ __('Cheque Number') }}</th>
                                    <th>{{ __('Cheque Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th class="bank-max-width">{{ __('Drawee Bank') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedRejectedChequesInSafe as $moneyReceived)
                                <tr>
                                    <td>
                                        <input style="max-height:25px;" id="cash-send-to-collection{{ $moneyReceived->id }}" type="checkbox" name="second_to_collection[]" value="{{ $moneyReceived->id }}" class="form-control checkbox js-send-to-collection" data-money-type="{{ MoneyReceived::CHEQUE_REJECTED }}">
                                    </td>
									   <td>{{ $moneyReceived->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCustomerName() }}</td>
                                    <td class="text-nowrap">{{ $moneyReceived->getReceivingDateFormatted() }}</td>
                                    <td>{{ $moneyReceived->cheque->getChequeNumber() }}</td>
                                    <td>{{ $moneyReceived->getReceivedAmountFormatted() }}</td>
                                    <td class="text-transform" data-currency="{{ $moneyReceived->getCurrency() }}">{{ $moneyReceived->getCurrencyFormatted() }}</td>
                                    <td class="bank-max-width">{{ $moneyReceived->cheque->getDraweeBankName() }}</td>
                                    <td class="text-nowrap">{{ $moneyReceived->cheque->getDueDateFormatted() }}</td>
                                    <td> {{ $moneyReceived->cheque->getStatusFormatted() }} </td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
											@if(!$moneyReceived->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}"><i class="fa fa-pen-alt"></i></a>
											@endif 
                                            <a data-id="{{ $moneyReceived->id }}" data-type="single" data-currency="{{ $moneyReceived->getCurrency() }}" data-id="{{ $moneyReceived->id }}" data-money-type="{{ MoneyReceived::CHEQUE_REJECTED }}" data-toggle="modal" data-target="#send-to-under-collection-modal{{ MoneyReceived::CHEQUE_REJECTED }}" type="button" class="btn js-can-trigger-cheque-under-collection-modal btn-secondary btn-outline-hover-primary btn-icon" title="{{ __('Send Under Collection') }}" href=""><i class="fa fa-money-bill"></i></a>
											@if(!$moneyReceived->isOpenBalance())
                                            <a data-toggle="modal" data-target="#delete-cheque-id-{{ $moneyReceived->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-{{ $moneyReceived->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}" method="post">
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
											@endif
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






            <div class="tab-pane {{ Request('active') == MoneyReceived::CHEQUE_UNDER_COLLECTION ? 'active':''  }}" id="{{ MoneyReceived::CHEQUE_UNDER_COLLECTION }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                    <x-table-title.with-two-dates :type="MoneyReceived::CHEQUE_UNDER_COLLECTION" :title="__('Cheques Under Collection')" :startDate="$filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['startDate']??''" :endDate="$filterDates[MoneyReceived::CHEQUE_UNDER_COLLECTION]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$chequesUnderCollectionTableSearchFields" :money-received-type="MoneyReceived::CHEQUE_UNDER_COLLECTION" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />

                    </x-table-title.with-two-dates>


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">

                                    <th class="align-middle">{!! __('Type') !!}</th>
                                    <th class="align-middle">{!! __('Customer <br> Name') !!}</th>
                                    <th class="align-middle">{!! __('Cheque <br> Number') !!}</th>
                                    <th class="align-middle">{!! __('Cheque <br> Amount') !!}</th>
                                    <th class="align-middle">{!! __('Deposit <br> Date') !!}</th>
                                    <th class="bank-max-width align-middle">{{ __('Drawal Bank') }}</th>
                                    <th class="align-middle">{!! __('Account <br> Number') !!}</th>
                                    <th class="align-middle">{!! __('Cheque <br> Due Date') !!}</th>
                                    <th class="align-middle">{!! __('Clearance <br>Days') !!}</th>
                                    <th class="align-middle">{!! __('Cheque Expected <br> Collection Date') !!}</th>
                                    <th class="align-middle">{!! __('Status') !!}</th>
                                    <th class="align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivedChequesUnderCollection as $moneyReceived)
                                <tr>
  									 <td>{{ $moneyReceived->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCustomerName() }}</td>
                                    <td>{{ $moneyReceived->cheque->getChequeNumber() }}</td>
                                    <td>{{ $moneyReceived->getReceivedAmountFormatted() }}</td>
                                    <td class="text-nowrap"> {{$moneyReceived->cheque->getDepositDateFormatted()}} </td>
                                    <td class="bank-max-width">{{ $moneyReceived->cheque->getDrawlBankName() }}</td>
                                    <td>{{ $moneyReceived->cheque->getAccountNumber() }}</td>
                                    <td> {{ $moneyReceived->cheque->getDueDateFormatted() }} </td>
                                    <td> {{ $moneyReceived->cheque->getClearanceDays() }} </td>
                                    <td> {{ $moneyReceived->cheque->chequeExpectedCollectionDateFormatted() }} </td>
										@php
										$dueStatus = $moneyReceived->cheque->getDueStatusFormatted() ;
									@endphp
                                    <td class="font-weight-bold" style="color:{{ $dueStatus['color'] }}!important">{{ $dueStatus['status'] }}</td>
                                

                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										@if(!$moneyReceived->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}"><i class="fa fa-pen-alt"></i></a>
											@endif 
											@if($moneyReceived->cheque->getDueStatus())
											@if(!$moneyReceived->isOpenBalance())
                                            <a data-toggle="modal" data-target="#apply-collection-modal-{{ $moneyReceived->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Apply Collection') }}" href="#"><i class="fa fa-coins"></i></a>
                                            <div class="modal fade" id="apply-collection-modal-{{ $moneyReceived->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('cheque.apply.collection',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ]) }}" method="post">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Mark This Cheque To Be Collected  ?') }}</h5>
                                                                <button type="button" class="close" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Customr Name')}} </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="{{ $moneyReceived->getCustomerName() }}" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Cheque Number')}} </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="{{ $moneyReceived->cheque->getChequeNumber() }}" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Cheque Amount')}} </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="{{ $moneyReceived->getReceivedAmountFormatted() }}" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Due Date')}} </label>
                                                                        <div class="kt-input-icon">
                                                                            <input value="{{ $moneyReceived->cheque->getDueDateFormatted() }}" type="text" disabled class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Collection Date')}}</label>
                                                                        <div class="kt-input-icon">
                                                                            <div class="input-group date">
                                                                                <input required type="text" name="actual_collection_date" value="{{ formatDateForDatePicker(now()->format('Y-m-d')) }}" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-calendar-check-o"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4 mb-4">
                                                                        <label>{{__('Collection Fees')}} <span class="required">*</span></label>
                                                                        <div class="kt-input-icon">
                                                                            <input required value="0" type="text" name="collection_fees" class="form-control" placeholder="{{__('Collection Fees')}}">
                                                                        </div>
                                                                    </div>



                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">{{ __('Confirm') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											@endif 
											@endif 
                                            <a type="button" class="btn  btn-secondary btn-outline-hover-warning   btn-icon" title="{{ __('Send In Safe') }}" href="{{ route('cheque.send.to.safe',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ]) }}"><i class="fa fa-sync-alt"></i></a>
											@if($moneyReceived->cheque->getDueStatus())
                                            <a type="button" class="btn  btn-secondary btn-outline-hover-danger   btn-icon" title="{{ __('Rejected') }}" href="{{ route('cheque.send.to.rejected.safe',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id ]) }}"><i class="fa fa-undo"></i></a>
                                            <div class="modal fade" id="delete-cheque-id-{{ $moneyReceived->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}" method="post">
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
											@endif
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



            <div class="tab-pane {{ Request('active') == MoneyReceived::CHEQUE_COLLECTED ? 'active':''  }}" id="{{ MoneyReceived::CHEQUE_COLLECTED }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="MoneyReceived::CHEQUE_COLLECTED" :title="__('Collected Cheques')" :startDate="$filterDates[MoneyReceived::CHEQUE_COLLECTED]['startDate']??''" :endDate="$filterDates[MoneyReceived::CHEQUE_COLLECTED]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$collectedChequesTableSearchFields" :money-received-type="MoneyReceived::CHEQUE_COLLECTED" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />

                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">

                                    <th class="align-middle">{{ __('Type') }}</th>
                                    <th class="align-middle">{{ __('Customer Name') }}</th>
                                    <th class="align-middle">{{ __('Cheque Number') }}</th>
                                    <th class="align-middle">{{ __('Cheque Amount') }}</th>
                                    <th class="align-middle">{{ __('Due Date') }}</th>
                                    <th class="align-middle">{{ __('Deposit Date') }}</th>
                                    <th class="bank-max-width align-middle">{{ __('Drawal Bank') }}</th>
                                    <th class="align-middle">{{ __('Account Number') }}</th>
                                    <th class="align-middle">{{ __('Collection Fees') }}</th>
                                    <th class="align-middle">{!! __('Cheque Actual <br> Collection Date') !!}</th>
                                    {{-- <th class="align-middle">{{ __('Control') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collectedCheques as $moneyReceived)
                                <tr>
 									  <td>{{ $moneyReceived->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCustomerName() }}</td>
                                    <td>{{ $moneyReceived->cheque->getChequeNumber() }}</td>
                                    <td>{{ $moneyReceived->getReceivedAmountFormatted() }}</td>
                                    <td class="text-nowrap"> {{$moneyReceived->cheque->getDueDateFormatted()}} </td>
                                    <td class="text-nowrap"> {{$moneyReceived->cheque->getDepositDateFormatted()}} </td>
                                    <td class="bank-max-width">{{ $moneyReceived->cheque->getDrawlBankName() }}</td>
                                    <td>{{ $moneyReceived->cheque->getAccountNumber() }}</td>
                                    <td> {{ $moneyReceived->cheque->getCollectionFeesFormatted() }} </td>
                                    <td> {{ $moneyReceived->cheque->chequeExpectedCollectionDateFormatted() }} </td>
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
            <div class="tab-pane {{ Request('active') == MoneyReceived::INCOMING_TRANSFER ? 'active':''  }}" id="{{ MoneyReceived::INCOMING_TRANSFER }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                    <x-table-title.with-two-dates :type="MoneyReceived::INCOMING_TRANSFER" :title="__('Incoming Transfer')" :startDate="$filterDates[MoneyReceived::INCOMING_TRANSFER]['startDate']??''" :endDate="$filterDates[MoneyReceived::INCOMING_TRANSFER]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$incomingTransferTableSearchFields" :money-received-type="MoneyReceived::INCOMING_TRANSFER" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />
                    </x-table-title.with-two-dates>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th class="bank-max-width">{{ __('Receiving Bank') }}</th>
                                    <th>{{ __('Transfer Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Account Type') }}</th>
                                    <th>{{ __('Account Number') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($receivedTransfer as $money)

                                <tr>
								   <td>{{ $money->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $money->getCustomerName() }}</td>
                                    <td>{{ $money->getReceivingDateFormatted() }}</td>
                                    <td>{{ $money->getIncomingTransferReceivingBankName() }}</td>
                                    <td>{{ $money->getReceivedAmountFormatted() }}</td>
                                    <td data-currency="{{ $money->getCurrency() }}"> {{ $money->getCurrencyFormatted() }}</td>
                                    <td>{{ $money->getIncomingTransferAccountTypeName() }}</td>
                                    <td>{{ $money->getIncomingTransferAccountNumber() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										@if(!$money->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id]) }}"><i class="fa fa-pen-alt"></i></a>
@endif 
@if(!$money->isOpenBalance())
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
											@endif 
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
            <div class="tab-pane {{ Request('active') == MoneyReceived::CASH_IN_SAFE ? 'active':''  }}" id="{{ MoneyReceived::CASH_IN_SAFE }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                    <x-table-title.with-two-dates :type="MoneyReceived::CASH_IN_SAFE" :title="__('Cash In Safe')" :startDate="$filterDates[MoneyReceived::CASH_IN_SAFE]['startDate']??''" :endDate="$filterDates[MoneyReceived::CASH_IN_SAFE]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$cashInSafeReceivedTableSearchFields" :money-received-type="MoneyReceived::CASH_IN_SAFE" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />

                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Type') }}</th>
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
                                @foreach($receivedCashesInSafe as $moneyReceived)

                                <tr>
                                    <td>{{ $moneyReceived->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCustomerName() }}</td>
                                    <td>{{ $moneyReceived->getReceivingDateFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCashInSafeBranchName() }}</td>
                                    <td>{{ $moneyReceived->getReceivedAmountFormatted() }}</td>
                                    <td data-currency="{{ $moneyReceived->getCurrency() }}">{{ $moneyReceived->getCurrencyFormatted() }}</td>
                                    <td>{{ $moneyReceived->getCashInSafeReceiptNumber() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										@if(!$moneyReceived->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-transfer-id-{{ $moneyReceived->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-transfer-id-{{ $moneyReceived->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$moneyReceived->id]) }}" method="post">
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
@endif 
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
            <div class="tab-pane {{ Request('active') == MoneyReceived::CASH_IN_BANK ? 'active':''  }}" id="{{ MoneyReceived::CASH_IN_BANK }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">

                    <x-table-title.with-two-dates :type="MoneyReceived::CASH_IN_BANK" :title="__('Bank Deposit')" :startDate="$filterDates[MoneyReceived::CASH_IN_BANK]['startDate']??''" :endDate="$filterDates[MoneyReceived::CASH_IN_BANK]['endDate']??''">
                        <x-export-money :account-types="$accountTypes" :financialInstitutionBanks="$financialInstitutionBanks" :search-fields="$cashInBankTableSearchFields" :money-received-type="MoneyReceived::CASH_IN_BANK" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.money.receive',['company'=>$company->id])}}" />

                    </x-table-title.with-two-dates>


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Receiving Date') }}</th>
                                    <th class="bank-max-width">{{ __('Receiving Bank') }}</th>
                                    <th>{{ __('Deposit Amount') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Account Type') }}</th>
                                    <th>{{ __('Account Number') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($receivedCashesInBanks as $money)

                                <tr>
								   <td>{{ $money->getMoneyTypeFormatted() }}</td>
                                    <td>{{ $money->getCustomerName() }}</td>
                                    <td>{{ $money->getReceivingDateFormatted() }}</td>
                                    <td>{{ $money->getIncomingTransferReceivingBankName() }}</td>
                                    <td>{{ $money->getReceivedAmountFormatted() }}</td>
                                    <td data-currency="{{ $money->getCurrency() }}"> {{ $money->getCurrencyFormatted() }}</td>
                                    <td>{{ $money->getCashInBankAccountTypeName() }}</td>
                                    <td>{{ $money->getCashInBankAccountNumber() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										@if(!$money->isOpenBalance())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$money->id]) }}"><i class="fa fa-pen-alt"></i></a>

                                            <a data-toggle="modal" data-target="#delete-cash-in-bank-id-{{ $money->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-cash-in-bank-id-{{ $money->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
											@endif 
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


<script src="/custom/money-receive.js">

</script>

<script>
    $(document).on('click', '.js-can-trigger-cheque-under-collection-modal', function(e) {
        e.preventDefault();
        const moneyType = $(this).attr('data-money-type')
        const type = $(this).attr('data-type') // single or multi
        $('#single-or-multi' + moneyType).val(type);
        if (type == 'single') {
            $('#current-single-item' + moneyType).val($(this).attr('data-id'));
            $('#current-currency' + moneyType).val($(this).attr('data-currency'));
        }
    })
    $(document).on('submit', '.ajax-send-cheques-to-collection', function(e) {
        e.preventDefault();
        const url = $(this).attr('action');
        const moneyType = $(this).attr('data-money-type')
        const type = $('#single-or-multi' + moneyType).val();
        const singleId = parseInt($('#current-single-item' + moneyType).val());
        let checked = [];
        $('.js-send-to-collection[data-money-type="' + moneyType + '"]:checked').each(function(index, element) {
            checked.push(parseInt($(element).val()));
        });

        const checkedItems = type == 'multi' ? checked : [singleId];
        let form = document.getElementById('ajax-send-cheques-to-collection-id' + moneyType);
        let formData = new FormData(form);
        formData.append('cheques', checkedItems);
        $('button').prop('disabled', true)
        $.ajax({
            cache: false
            , contentType: false
            , processData: false
            , url: url
            , data: formData
            , type: "post"
        }).then(function(res) {
            Swal.fire({
                text: 'Done'
                , icon: 'success'
                , timer: 2000
            }).then(function() {
                window.location.href = res.pageLink;
            });
        })
    });

</script>
<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })
    $(document).on('click', '#js-drawee-bank', function(e) {
        e.preventDefault();
        $('#js-choose-bank-id').modal('show');
    })

    $(document).on('click', '#js-append-bank-name-if-not-exist', function() {
        const receivingBank = document.getElementById('js-drawee-bank').parentElement;
        const newBankId = $('#js-bank-names').val();
        const newBankName = $('#js-bank-names option:selected').attr('data-name');
        const isBankExist = $(receivingBank).find('select.js-drawl-bank').find('option[value="' + newBankId + '"]').length;
        if (!isBankExist) {
            const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
            $('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
        }
        $('#js-choose-bank-id').modal('hide');
    });

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'due_date') {
            $('.data-type-span').html('[ {{ __("Due Date") }} ]')
            modal.find(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName == 'receiving_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ {{ __("Receiving Date") }} ]')
        } else if (searchFieldName == 'deposit_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ {{ __("Deposit Date") }} ]')
        } else {
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
@endsection
@push('js')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
