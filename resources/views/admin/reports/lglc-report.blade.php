@extends('layouts.dashboard')
@section('css')
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('dash_nav')
<style>
    .chartdiv_two_lines {
        width: 100%;
        height: 275px;
    }

    .chartDiv {
        max-height: 275px !important;
    }

    .margin__left {
        border-left: 2px solid #366cf3;
    }

    .sky-border {
        border-bottom: 1.5px solid #CCE2FD !important;
    }

    .kt-widget24__title {
        color: black !important;
    }

</style>

@endsection
@section('css')
<link href="{{ url('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

    /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

</style>
@endsection
@section('content')
<div class="kt-portlet">

    <form action="{{ route('view.lglc.dashboard',['company'=>$company->id]) }}" class="kt-portlet__head w-full sky-border" style="">
        <div class="kt-portlet__head-label w-full">
            <h3 class="kt-portlet__head-title head-title text-primary w-full">


                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="visibility-hidden"> {{__('Currency')}}
                            @include('star')
                        </label>
                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-nowrap" style=""> {{ __('Dashboard Results') }}</h3>

                    </div>
                    <div class="col-md-2">
                        <label class="visibility-hidden"> {{__('Currency')}}
                            @include('star')
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input id="js-date" type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control" max="{{ date('Y-m-d') }}" placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 kt-align-right">

                        <label class="visibility-hidden"> {{__('Currency')}}
                            @include('star')
                        </label>

                        <div class="input-group">
                            <button type="submit" class="btn active-style save-form">{{__('Save')}}</button>
                        </div>
                    </div>

                </div>



            </h3>
        </div>
    </form>

    <div class="kt-portlet__body" style="padding-bottom:0 !important;">
        <ul style="margin-bottom:0 ;" class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
            @php
            $index = 0 ;
            @endphp
            @foreach($selectedCurrencies as $currencyUpper=>$currency)

            <li class="nav-item @if($index ==0 ) active @endif">
                <a class="nav-link @if($index ==0 ) active @endif" data-toggle="tab" href="#kt_apps_contacts_view_tab_main{{ $index }}" role="tab">
                    <i class="flaticon2-checking icon-lg"></i>
                    <span style="font-size:18px !important;">{{ $currency }}</span>
                </a>
            </li>

            @php
            $index++;
            @endphp
            @endforeach
        </ul>
    </div>
</div>

<div class="tab-content  kt-margin-t-20">
    @php
    $index = 0 ;
    @endphp

    @foreach($selectedCurrencies as $name=>$currency)

    <div class="tab-pane  @if($index == 0) active @endif" id="kt_apps_contacts_view_tab_main{{ $index }}" role="tabpanel">
        <div class="kt-portlet">
            <div class="kt-portlet__head sky-border">
                <div class="kt-portlet__head-label">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{__('Letters Of Guarantee Position')}}</h3>


                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
					@php
						$lgOrLcType ='lg';
					@endphp
					@foreach([
						'limit'=>[
						'title'=>__('LGs Limits'),
						'bg-color'=>'kt-bg-brand'
						],
						'outstanding_balance'=>
						[
							'title'=>__('LGs Outstanding Balance'),
							'bg-color'=>'kt-bg-warning'
						],
						'room'=>[
							'title'=>__('LGs Room'),
							'bg-color'=>'kt-bg-success'
							],
							'cash_cover'=>[
							'title'=>__('LGs Cash Cover'),
							'bg-color'=>'kt-bg-primary'
							]
						
						] as $currentColType=>$currentColOptions )
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info w-100">
                                    <h4 class="kt-widget24__title font-size text-uppercase d-flex justify-content-between align-items-center">
                                        {{ $currentColOptions['title']  . ' [ ' . $currency . ' ]' }}
										@php
											$currentModalId = $currentColType . $lgOrLcType;
										@endphp
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white @if($currentColType != 'limit') visibility-hidden  @endif "   data-toggle="modal" data-target="#{{ $currentModalId.$currency }}">{{ __('Details') }}</button>
										@if($currentColType == 'limit')
										@include('admin.dashboard.lg-lc-details',['detailItems'=> $details[$name][$lgOrLcType]  , 'modalId'=>$currentModalId ,'title'=>__('Details')])
										@endif 
                                    </h4>

                                </div>
                            </div>

                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                    {{ number_format($reports[$lgOrLcType][$currency][$currentColType] ?? 0 ) }} 
                                </span>
                            </div>

                            <div class="progress progress--sm">
                                <div class="progress-bar {{ $currentColOptions['bg-color'] }}" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::Total Profit-->
                    </div>
                   @endforeach
                  

                </div>
            </div>
        </div>
        <!--end:: Widgets/Stats-->


     
		
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{ __('Total Cash Facilities') }}
                            </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#">{{ __('Limit') }}</a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4>{{ number_format($totalCard[$currency]['limit'] ?? 0,0) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#">{{ __('Outstanding') }}</a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4> {{ number_format($totalCard[$currency]['outstanding']??0,0) }} </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#">{{ __('Available') }}</a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4>{{ number_format($totalCard[$currency]['room']??0,0) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#">{{ __('Interest') }}</a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4>{{ number_format($totalCard[$currency]['interest_amount']??0,0) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">

            {{-- Fully Secured Overdraft  --}}
            {{-- @if($hasFullySecuredOverdraft[$currency]??false) --}}
            <div class="col-md-3">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ __('LG Outstanding Types') }} </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                   {{-- <h4 class="visibility-hidden"> {{ __('Per Lg Type') }} </h4> --}}
                                        <div id="outstanding_per_lg_typechartdiv_available_room_{{$currency}}" class="chartDiv"></div>
                                    <input type="hidden" id="outstanding_per_lg_typetotal_available_room_{{$currency}}" data-total="{{ json_encode($charts['outstanding_per_lg_type'][$currency] ?? [] ) }}">
                            </div>
                 
                        </div>
                       
                        {{-- Chart --}}
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="chartdiv" id="chartdiv2"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Fully Secured Overdraft  Chart --}}
			 <div class="col-md-3">
                <div class="kt-portlet kt-portlet--tabs">
                     <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ __('LG Per Bank') }} </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body pt-0">
                        <select class="current-currency hidden">
                            <option value="{{ $currency }}"></option>
                        </select>

                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1_{{$currency}}" role="tabpanel">

                                {{-- Monthly Chart --}}
                                <div class="row">
                                    <div class="col-md-12">

                                        {{-- <h4 c> {{ __('Available Room') }} </h4> --}}
                                               <div id="outstanding_per_financial_institutionchartdiv_available_room_{{$currency}}" class="chartDiv"></div>
                                    <input type="hidden" id="outstanding_per_financial_institutiontotal_available_room_{{$currency}}" data-total="{{ json_encode($charts['outstanding_per_financial_institution'][$currency] ?? [] ) }}">
                                    </div>



                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
			
			
            <div class="col-md-6">
                <div class="kt-portlet kt-portlet--tabs">
                     <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ __('LGs Details') }} </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body pt-0">
                        <select class="current-currency hidden">
                            <option value="{{ $currency }}"></option>
                        </select>

                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1_{{$currency}}" role="tabpanel">

                                {{-- Monthly Chart --}}
                                <div class="row">
                                   



                                    <div class="col-md-12  margin__left">

                                        <div class="row ">
                                            {{-- <div class="col-12">
                                                <h4> {{ __('Bank Movement') }} </h4>
                                            </div> --}}
                                            <div class="col-md-6">
                                                <select data-currency="{{ $currency }}" data-table="FullySecuredOverdraft"  class="form-control bank-id-js">
														<option value="0">{{ __('All') }}</option>
												
                                                    @foreach($allFullySecuredOverdraftBanks as $bank)
                                                    <option value="{{ $bank->id }}"> {{ $bank->getName() }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="col-md-3">
                                                <select name="lg_type" class="form-control">
														<option value="0">{{ __('All') }}</option>
													@foreach($lgTypes as $lgTypeId => $lgTypeTitle)
														<option value="{{ $lgTypeId }}">{{ $lgTypeTitle }}</option>
													@endforeach 
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <select name="lg_source" class="form-control">
														<option value="0">{{ __('All') }}</option>
													@foreach($lgSources as $lgSourceId => $lgSourceTitle)
														<option value="{{ $lgSourceId }}">{{ $lgSourceTitle }}</option>
													@endforeach 
                                                </select>
                                            </div>
											
											<div class="col-md-12 mt-4">
											  <x-table :tableClass="'kt_table_with_no_pagination_no_scroll_no_entries'">
                                                @slot('table_header')
                                                <tr class="table-active text-center">
                                                    <th class="text-center">{{ __('Bank Name') }}</th>
                                                    <th class="text-center ">{{ __('Type') }}</th>
                                                    <th class="text-center ">{{ __('Source') }}</th>
                                                    <th class="text-center ">{{ __('Outstanding') }}</th>
                                                    <th class="text-center ">{{ __('Room') }}</th>
                                                </tr>
                                                @endslot
                                                @slot('table_body')


<tr>

                                                    <td class="">1</td>
                                                    <td class="">1</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">4</td>
                                                </tr>
                                                @foreach ($totalRoomForEachFullySecuredOverdraftId[$currency] ??[] as $key => $item)
                                                {{-- <tr>

                                                    <td class="">1</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">4</td>
                                                </tr> --}}
                                                @endforeach

                                                <tr class="table-active text-center">
                                                    <td>{{__('Total')}}</td>
                                                    <td>5</td>
                                                    <td>5</td>
                                                    <td>6</td>
                                                    <td>7</td>

                                                </tr>
                                                @endslot
                                            </x-table>
											</div>

                                        </div>
                                        <div class="chartdiv_two_lines" id="FullySecuredOverdraftchartdiv_two_lines_{{ $currency }}"></div>
                                    </div>
                                </div>

                            </div>

                           
                        </div>
                    </div>
                </div>

            </div>
            {{-- End Fully Secured Overdraft --}}
























        </div>
        {{-- Title --}}
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{ __('Long Term Cash Facilities Position') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin:: Widgets/Stats-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Medium Term Loans Position') }}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Limit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Limit') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                  -
                                </span>
                            </div>


                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Outstanding') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning">
                                    -
                                </span>
                            </div>

                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Next Due Amount') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-danger">
                                  -
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Date') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success">
                                  -
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Stats-->

        <!--begin:: Widgets/Stats-->
        {{-- <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Leasing Facilitiess Position') }}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Limit') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                    50,000,000
                                </span>
                            </div>


                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Outstanding') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning">
                                    42,500,000
                                </span>
                            </div>

                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Next Due Amount') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-danger">
                                    1,250,000
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        {{ __('Date') }}
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success">
                                    01-June-2024
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

    @php
    $index++;
    @endphp
    @endforeach
</div>
@endsection
@section('js')
<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>








<!--begin::Page Scripts(used by this page) -->
<script src="{{url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/jquery.repeater/src/lib.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/jquery.repeater/src/jquery.input.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/jquery.repeater/src/repeater.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')}}" type="text/javascript"></script>
@foreach(['outstanding_per_lg_type','outstanding_per_financial_institution'] as $currentChartType)
@foreach($selectedCurrencies as $currencyUpper=>$currency)
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("{{ $currentChartType }}" + "chartdiv_available_room_" + "{{$currency}}", am4charts.PieChart);

        // Add data
        chart.data = $('#' + "{{ $currentChartType }}" + 'total_available_room_' + "{{$currency}}").data('total');

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "outstanding";
        pieSeries.dataFields.category = "type";
        pieSeries.innerRadius = am4core.percent(50);
        // arrow
        pieSeries.ticks.template.disabled = true;
        //number
        pieSeries.labels.template.disabled = true;

        var rgm = new am4core.RadialGradientModifier();
        rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
        pieSeries.slices.template.fillModifier = rgm;
        pieSeries.slices.template.strokeModifier = rgm;
        pieSeries.slices.template.strokeOpacity = 0.4;
        pieSeries.slices.template.strokeWidth = 0;
        // chart.legend = new am4charts.Legend();
        //        chart.legend.position = "right";
        //    chart.legend.scrollable = true;


    }); // end am4core.ready()

</script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("{{ $currentChartType }}chartdiv_two_lines_{{$currency  }}", am4charts.XYChart);

        //

        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = [];

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        // Create series
        function createAxisAndSeries(field, name, opposite, bullet) {
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            if (chart.yAxes.indexOf(valueAxis) != 0) {
                valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            }

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            series.dataFields.dateX = "date";
            series.strokeWidth = 2;
            series.yAxis = valueAxis;
            series.name = name;
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            series.tensionX = 0.8;
            series.showOnInit = true;

            var interfaceColors = new am4core.InterfaceColorSet();

            switch (bullet) {
                case "triangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 12;
                    bullet.height = 12;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var triangle = bullet.createChild(am4core.Triangle);
                    triangle.stroke = interfaceColors.getFor("background");
                    triangle.strokeWidth = 2;
                    triangle.direction = "top";
                    triangle.width = 12;
                    triangle.height = 12;
                    break;
                case "rectangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 10;
                    bullet.height = 10;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var rectangle = bullet.createChild(am4core.Rectangle);
                    rectangle.stroke = interfaceColors.getFor("background");
                    rectangle.strokeWidth = 2;
                    rectangle.width = 10;
                    rectangle.height = 10;
                    break;
                default:
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.stroke = interfaceColors.getFor("background");
                    bullet.circle.strokeWidth = 2;
                    break;
            }

            valueAxis.renderer.line.strokeOpacity = 1;
            valueAxis.renderer.line.strokeWidth = 2;
            valueAxis.renderer.line.stroke = series.stroke;
            valueAxis.renderer.labels.template.fill = series.stroke;
            valueAxis.renderer.opposite = opposite;
        }

        createAxisAndSeries("debit", "{{ __('Cash In') }}", false, "circle");
        createAxisAndSeries("credit", "{{ __('Cash Out') }}", true, "triangle");
        createAxisAndSeries("end_balance", "{{ __('End Balance') }}", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()

</script>

@endforeach
@endforeach



<script>
    $(document).on('change', 'select[js-refresh-limits-chart]', function(e) {
        console.log(e.target)
        const modelName = $(this).attr('data-table');
        const currencyName = $(this).attr('data-currency')
        const bankId = $('.bank-id-js[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const accountNumber = $('.js-account-number[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const date = $('#js-date').val();
        const currentChartId = modelName + 'chartdiv_two_lines_' + currencyName
        console.log(currentChartId);
        if (!accountNumber) {
            return;
        }
        $.ajax({
            url: "{{ route('refresh.chart.limits.data',['company'=>$company->id]) }}"
            , data: {
                modelName
                , currencyName
                , bankId
                , date
                , accountNumber
            }
            , type: "get"
            , success: function(res) {
                // update current chart

                am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = res.chart_date
            }
            , error: function(exception) {
                console.warn(exception)
            }
        })

    })

    $('select[js-refresh-limits-chart]').trigger('change')

</script>
<script src="/custom/money-receive.js"></script>

{{-- <script src="{{url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js')}}" type="text/javascript"></script> --}}

<!--end::Page Scripts -->

@endsection
