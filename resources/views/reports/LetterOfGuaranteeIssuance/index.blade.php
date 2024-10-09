@extends('layouts.dashboard')
@section('css')
@php
use App\Enums\LgTypes;
use App\Models\LetterOfGuaranteeIssuance;

$bidbondType = LgTypes::BID_BOND ;
$finalLGSType = LgTypes::FINAL_LGS ;
$advancedPaymentLgsType = LgTypes::ADVANCED_PAYMENT_LGS;
$performanceLgType = LgTypes::PERFORMANCE_LG ; 
$allLgs = LgTypes::getAll() ;
$currentActiveTab = isset($currentActiveTab) ? $currentActiveTab : null ;


@endphp
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
    input[type="checkbox"] {
        cursor: pointer;
    }
.bg-expired{
	background-color:red;
	color:white !important;
	 font-weight: bold !important;
}
.bg-cancelled{
	background-color:orange;
	color:white !important;
	 font-weight: bold !important;
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

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Letter Of Guarantee Issuance ')  }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                @php
                $index = 0 ;
                @endphp
                @foreach($allLgs as $type => $name)
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active',$currentActiveTab) && $index==0 || Request('active',$currentActiveTab) == $type ?'active':'' }}" data-toggle="tab" href="#{{ $type }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{$name .' '. __('Table') }}
                    </a>
                </li>
                @php
                $index = $index+1;
                @endphp
                @endforeach

            </ul>
			@if(hasAuthFor('create letter of guarantee issuance'))
            <div class="flex-tabs">
				<a href="{{ route('create.letter.of.guarantee.issuance',['company'=>$company->id,'source'=>LetterOfGuaranteeIssuance::LG_FACILITY  ]) }}" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					{{ __('From LG Facility') }}
				</a>
				<a href="{{ route('create.letter.of.guarantee.issuance',['company'=>$company->id,'source'=>LetterOfGuaranteeIssuance::AGAINST_CD  ]) }}" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					{{ __('LG Agnist CDs') }}
				</a>
				<a href="{{ route('create.letter.of.guarantee.issuance',['company'=>$company->id,'source'=>LetterOfGuaranteeIssuance::AGAINST_TD  ]) }}" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					{{ __('LG Agnist TDs') }}
				</a>
				<a href="{{ route('create.letter.of.guarantee.issuance',['company'=>$company->id,'source'=>LetterOfGuaranteeIssuance::HUNDRED_PERCENTAGE_CASH_COVER]) }}" class="btn btn-sm active-style btn-icon-sm align-self-center">
					<i class="fas fa-plus"></i>
					{{ __('LG 100% Cash Cover') }}
				</a>
			</div >

        </div>
		@endif 
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            @php
            $currentTab = $bidbondType ;
            @endphp
            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active',$currentActiveTab) && $currentTab == $bidbondType  || Request('active',$currentActiveTab) == $currentTab ?'active':'' }}" id="{{ $currentTab }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="$currentTab" :title="$allLgs[$currentTab] . ' ' .__('Table') " :startDate="$filterDates[$currentTab]['startDate']" :endDate="$filterDates[$currentTab]['endDate']">
                        <x-export-letter-of-guarantee-issuance :search-fields="$searchFields[$currentTab]" :type="$currentTab" href="{{route('create.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfGuaranteeIssuance::LG_FACILITY])}}" />
                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle">{{ __('#') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Name') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Source') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Status') !!} </th>
									
                                    <th class="text-center align-middle">{{ __('Bank Name') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Code') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Reference') !!} </th>
                                    <th class="text-center align-middle">{{ __('LG Amount') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Order Date') !!} </th>
                                    <th class="text-center align-middle">{{ __('Issuance Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Renewal Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
							@php
								$index = 0 ;
							@endphp
                                @foreach($models[$currentTab] as $model)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td>{{ $model->getTransactionName() }}</td>
                                    <td class="text-transform">{{ $model->getSourceFormatted() }}</td>
                                    <td class="text-transform
									
									@if($model->isExpired())
									bg-expired
									
									@elseif($model->isCancelled())
									bg-cancelled
									@endif 
									
									">{{ $model->getStatusFormatted() }}</td>
                                    <td class="text-nowrap">{{ $model->getFinancialInstitutionBankName() }}</td>
                                    <td class="text-uppercase">{{ $model->getLgCode() }}</td>
                                    <td class="text-transform">{{ $model->getTransactionReference() }}</td>
                                    <td class="text-transform">{{ $model->getLgAmountFormatted() }} <br> {{ $model->getLgCurrency() }} </td>
                                    <td class="text-transform text-nowrap">{{ $model->getTransactionDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getIssuanceDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getRenewalDateFormatted() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                          @include('reports.LetterOfGuaranteeIssuance.actions')
                                          @include('reports.LetterOfGuaranteeIssuance.renewal-date._renew_modal')
										@if(!$model->isCancelled())
											@if(hasAuthFor('update letter of guarantee issuance'))
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}"><i class="fa fa-pen-alt"></i></a>
											@endif 
												@if(hasAuthFor('delete letter of guarantee issuance'))
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $model->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
											@endif 
											@endif 
                                        </span>
                                    </td>
                                </tr>
								@php
									$index++;
								@endphp
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>











            @php
            $currentTab = $finalLGSType ;
            @endphp
            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active',$currentActiveTab) && $currentTab == $bidbondType  || Request('active',$currentActiveTab) == $currentTab ?'active':'' }}" id="{{ $currentTab }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="$currentTab" :title="$allLgs[$currentTab] . ' ' .__('Table') " :startDate="$filterDates[$currentTab]['startDate']" :endDate="$filterDates[$currentTab]['endDate']">
                        <x-export-letter-of-guarantee-issuance :search-fields="$searchFields[$currentTab]" :type="$currentTab" href="{{route('create.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfGuaranteeIssuance::LG_FACILITY])}}" />
                    </x-table-title.with-two-dates>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle">{{ __('#') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Name') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Source') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Status') !!} </th>
                                    <th class="text-center align-middle">{{ __('Bank Name') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Code') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Amount') }}</th>
							
                                    <th class="text-center align-middle"> {!! __('Purchase <br> Order Date') !!} </th>
                                    <th class="text-center align-middle">{{ __('Issuance Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Renewal Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
							@php
								$index = 0 ;
							@endphp
                                @foreach($models[$currentTab] as $index=>$model)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td>{{ $model->getTransactionName() }}</td>
                                    <td>{{ $model->getSourceFormatted() }}</td>
                                    <td class="
									@if($model->isExpired())
									bg-expired
									@elseif($model->isCancelled())
									bg-cancelled
									@endif 
									
									"> {{ $model->getStatusFormatted() }}</td>
                                    <td class="text-nowrap">{{ $model->getFinancialInstitutionBankName() }}</td>
                                    <td class="text-uppercase">{{ $model->getLgCode() }}</td>
                                    <td class="text-transform">{{ $model->getLgAmountFormatted() }}  <br> {{ $model->getLgCurrency() }} </td>
                                    <td class="text-transform text-nowrap">{{ $model->getPurchaseOrderDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getIssuanceDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getRenewalDateFormatted() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                          @include('reports.LetterOfGuaranteeIssuance.actions')
										  @include('reports.LetterOfGuaranteeIssuance.renewal-date._renew_modal')
											@if(!$model->isCancelled())
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $model->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
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
								@php
									$index++;
								@endphp
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>








            @php
            $currentTab = $advancedPaymentLgsType ;
            @endphp
            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active',$currentActiveTab) && $currentTab == $advancedPaymentLgsType  || Request('active',$currentActiveTab) == $currentTab ?'active':'' }}" id="{{ $currentTab }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="$currentTab" :title="$allLgs[$currentTab] . ' ' .__('Table') " :startDate="$filterDates[$currentTab]['startDate']" :endDate="$filterDates[$currentTab]['endDate']">
                        <x-export-letter-of-guarantee-issuance :search-fields="$searchFields[$currentTab]" :type="$currentTab" href="{{route('create.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfGuaranteeIssuance::LG_FACILITY])}}" />
                    </x-table-title.with-two-dates>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle">{{ __('#') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Name') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Source') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Status') !!} </th>
                                    <th class="text-center align-middle">{{ __('Bank Name') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Code') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Amount') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Current Amount') }}</th>
                                    <th class="text-center align-middle"> {!! __('Purchase <br> Order Date') !!} </th>
                                    <th class="text-center align-middle">{{ __('Issuance Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Renewal Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
							@php
								$index = 0 ;
							@endphp
                                @foreach($models[$currentTab] as $index=>$model)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td>{{ $model->getTransactionName() }}</td>
									<td>{{ $model->getSourceFormatted() }}</td>
									<td class="
									@if($model->isExpired())
									bg-expired
									@elseif($model->isCancelled())
									bg-cancelled
									@endif 
									
									">{{ $model->getStatusFormatted() }}</td>
                                    <td class="text-nowrap">{{ $model->getFinancialInstitutionBankName() }}</td>
                                    <td class="text-uppercase">{{ $model->getLgCode() }}</td>
                                    <td class="text-transform">{{ $model->getLgAmountFormatted() }}  <br> {{ $model->getLgCurrency() }} </td>
                                    <td class="text-transform">{{ $model->getLgCurrentAmountFormatted() }} <br> {{ $model->getLgCurrency() }} </td>
                                    <td class="text-transform text-nowrap">{{ $model->getPurchaseOrderDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getIssuanceDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getRenewalDateFormatted() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                        	  @include('reports.LetterOfGuaranteeIssuance.actions')
											  @include('reports.LetterOfGuaranteeIssuance.renewal-date._renew_modal')
											  
											@if(!$model->advancedPaymentHistories->count() && !$model->isCancelled())  
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}">
											<i class="fa fa-pen-alt"></i>
											</a>
											@endif
											@if(!$model->isCancelled())
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $model->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
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
								@php
									$index++;
								@endphp
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>







            @php
            $currentTab = $performanceLgType ;
            @endphp
            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active',$currentActiveTab) && $currentTab == $performanceLgType  || Request('active',$currentActiveTab) == $currentTab ?'active':'' }}" id="{{ $currentTab }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :type="$currentTab" :title="$allLgs[$currentTab] . ' ' .__('Table') " :startDate="$filterDates[$currentTab]['startDate']" :endDate="$filterDates[$currentTab]['endDate']">
                        <x-export-letter-of-guarantee-issuance :search-fields="$searchFields[$currentTab]" :type="$currentTab" href="{{route('create.letter.of.guarantee.issuance',['company'=>$company->id,'active'=>$currentTab,'source'=>LetterOfGuaranteeIssuance::LG_FACILITY])}}" />
                    </x-table-title.with-two-dates>


                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="text-center align-middle">{{ __('#') }}</th>
                                    <th class="text-center align-middle"> {!! __('Transaction <br> Name') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Source') !!} </th>
                                    <th class="text-center align-middle"> {!! __('Status') !!} </th>
                                    <th class="text-center align-middle">{{ __('Bank Name') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Code') }}</th>
                                    <th class="text-center align-middle">{{ __('LG Amount') }}</th>
                                    <th class="text-center align-middle">{!! __('Purchase <br> Order Date') !!} </th>
                                    <th class="text-center align-middle">{{ __('Issuance Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Renewal Date') }}</th>
                                    <th class="text-center align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
					@php
						$index = 0 ;
					@endphp
                                @foreach($models[$currentTab] as $index=>$model)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td>{{ $model->getTransactionName() }}</td>
                                    <td>{{ $model->getSourceFormatted() }}</td>
                                    <td class="
									@if($model->isExpired())
									bg-expired
									@elseif($model->isCancelled())
									bg-cancelled
									@endif 
									
									">{{ $model->getStatusFormatted() }}</td>
                                    <td class="text-nowrap">{{ $model->getFinancialInstitutionBankName() }}</td>
                                    <td class="text-uppercase">{{ $model->getLgCode() }}</td>
                                    <td class="text-transform">{{ $model->getLgAmountFormatted() }}  <br> {{ $model->getLgCurrency() }} </td>

                                    <td class="text-transform text-nowrap">{{ $model->getPurchaseOrderDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getIssuanceDateFormatted() }}</td>
                                    <td class="text-transform text-nowrap">{{ $model->getRenewalDateFormatted() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                          @include('reports.LetterOfGuaranteeIssuance.actions')
										  @include('reports.LetterOfGuaranteeIssuance.renewal-date._renew_modal')

					@if(!$model->isCancelled())
                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}"><i class="fa fa-pen-alt"></i></a>
                    <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $model->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                    <div class="modal fade" id="delete-financial-institution-bank-id-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('delete.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
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
					@php
						$index++;
					@endphp
                    @endforeach
                    </tbody>
                    </table>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>


        <!--End:: Tab Content-->



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


</script>



{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}

<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'purchase_order_date') {
            modal.find('.data-type-span').html('[{{ __("Purchase Order Date") }}]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'issuance_date') {
            modal.find('.data-type-span').html('[ {{ __("Issuance Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ {{ __("Issuance Date") }} ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {
        $('.js-search-modal').trigger('change')
    })


$("button[data-dismiss=modal2]").click(function(){
    $(this).closest('.modal').modal('hide');
});

</script>
@endsection
@push('js')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
