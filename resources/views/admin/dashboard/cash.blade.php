@extends('layouts.dashboard')
@section('css')
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('dash_nav')
<style>
    .chartdiv {
        width: 100%;
        height: 250px;
    }

    .chartdivdonut {
        width: 100%;
        height: 500px;
    }

    .chartdivchart {
        width: 100%;
        height: 500px;
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
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title head-title text-primary">
                {{ __('Dashboard Results') }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-md-3">
                <label>{{ __('Date') }}</label>
                <div class="kt-input-icon">
                    <div class="input-group date">
                        <input type="text" value="{{ date('d/m/Y') }}" name="invoice_date" class="form-control" max="{{ date('d/m/Y') }}" readonly placeholder="Select date" id="kt_datepicker_2" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label>{{__('Financial Institution')}} @include('star') </label>
                <div class="kt-input-icon">
                    <div class="input-group date ">
                        <select data-live-search="true" data-actions-box="true" js-when-change-trigger-change-account-type data-financial-institution-id name="financial_institution_ids[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple required>
                            @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                            <option value="{{ $financialInstitutionBank->id }}" {{ in_array($financialInstitutionBank->id , $selectedFinancialInstitutionsIds) ? 'selected':'' }}>{{ $financialInstitutionBank->getName() }}</option>
                            @endforeach
                        </select>


                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label>{{__('Currency')}}
                    @include('star')
                </label>
                <div class="input-group">
                    <select data-live-search="true" data-actions-box="true" name="currencies[]" class="form-control current-currency select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple js-when-change-trigger-change-account-type>
                        @foreach(getCurrencies() as $currencyName => $currencyValue )
                        <option value="{{ $currencyName }}" @if( in_array($currencyName,$currencies) ) selected @elseif(strtolower($currencyName) == 'egp' ) selected @endif > {{ $currencyValue }}</option>
                        @endforeach
                    </select>
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
                {{ __('Current Cash Position') }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body  kt-portlet__body--fit">
        <div class="row row-no-padding row-col-separator-xl">
            @foreach($currencies as $currency)
            <div class="col-md-6 col-lg-3 col-xl-3">

                <!--begin::Total Profit-->
                <div class="kt-widget24 text-center">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size text-uppercase">
                                {{ __('Cash & Banks' )  . ' [ ' . $currency . ' ]' }}
                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-brand">
                            {{ number_format($reports['cash_and_banks'][$currency] ?? 0 ) }}
                        </span>
                    </div>

                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                </div>

                <!--end::Total Profit-->
            </div>
            <div class="col-md-6 col-lg-3 col-xl-3">

                <!--begin::New Feedbacks-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size  text-uppercase">
                                {{ __('Time & Certificate Of Deposit') . ' [ ' . $currency . ' ]' }}
                            </h4>
                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-warning text-uppercase">
                            {{ number_format($reports['certificate_of_deposits'][$currency] ?? 0 ) }}
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                </div>

                <!--end::New Feedbacks-->
            </div>
            <div class="col-md-6 col-lg-3 col-xl-3">

                <!--begin::New Orders-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size text-uppercase">
                                {{ __('Credit Facilities Room') . ' [ ' . $currency . ' ] ' }}
                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-danger text-uppercase">
                            {{ number_format($reports['credit_facilities_room'][$currency] ?? 0 ) }}
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                {{ __('Total') }}
                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-success text-uppercase">
                            {{ number_format($reports['total'][$currency] ?? 0 ) }}
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                </div>

                <!--end::New Users-->
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--end:: Widgets/Stats-->

{{-- Title --}}
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Short Term Cash Facilities Position') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- First Section --}}
<div class="row">
    {{-- Total Facilities --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Total Cash Facilities') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
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
                                            <a class="kt-link" href="#">Limit</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Outstanding</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Available</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Clean Overdraft --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Clean Overdraft') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">{{ __('Limit') }}</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>{{ number_format($cleanOverdraftCardData['limit'] ?? 0,0) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">{{ __('Outstanding') }}</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4> {{ number_format($cleanOverdraftCardData['outstanding']??0,0) }} </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">{{ __('Room') }}</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>{{ number_format($cleanOverdraftCardData['room']??0,0) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Overdraft Aganist Commercial Papers --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Overdraft Aganist Commercial Papers') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Limit</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Outstanding</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Available</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Second Section --}}
<div class="row">
    {{-- Overdraft Aganist Contract Assignment --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Overdraft Aganist Contract Assignment') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
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
                                            <a class="kt-link" href="#">Limit</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Outstanding</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Available</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
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
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Discounting Cheques --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Discounting Cheques') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Limit</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Outstanding</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Available</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--success kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Invoices Factoring --}}
    <div class="col-md-4">
        <div class="kt-portlet ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{ __('Invoices Factoring') }}
                    </h3>
                </div>
                <div class="kt-portlet__head-label col-4">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-sm btn-brand btn-elevate btn-pill"><i class="fa fa-chart-line"></i> {{ __('Report') }} </button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Limit</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Outstanding</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Available</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                            <div class="kt-portlet__body">
                                <div class="kt-iconbox__body">
                                    <div class="kt-iconbox__desc">
                                        <h3 class="kt-iconbox__title">
                                            <a class="kt-link" href="#">Interest Rate %</a>
                                        </h3>
                                        <div class="kt-iconbox__content text-primary  ">
                                            <h4>0 %</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="chartdiv" id="chartdiv6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            25,000,000
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
                            15,000,000
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
                            750,000
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
                            01-October-2024
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
<div class="kt-portlet">
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
</div>
@endsection
@section('js')
<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>



<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv1", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv2", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv3", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv4", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv5", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv6", am4charts.PieChart);
        chart.startAngle = 160;
        chart.endAngle = 380;

        // Let's cut a hole in our Pie chart the size of 40% the radius
        chart.innerRadius = am4core.percent(40);

        // Add data
        chart.data = [{
            "country": "Outstanding"
            , "litres": 0
            , "bottles": 30000000
        }, {
            "country": "Available"
            , "litres": 20000000
            , "bottles": 20000000
        }];

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";
        pieSeries.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries.slices.template.strokeWidth = 1;
        pieSeries.slices.template.strokeOpacity = 1;

        // Disabling labels and ticks on inner circle
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        // Disable sliding out of slices
        pieSeries.slices.template.states.getKey("hover").properties.shiftRadius = 0;
        pieSeries.slices.template.states.getKey("hover").properties.scale = 1;
        pieSeries.radius = am4core.percent(40);
        pieSeries.innerRadius = am4core.percent(30);

        var cs = pieSeries.colors;
        cs.list = [am4core.color(new am4core.ColorSet().getIndex(0))];

        cs.stepOptions = {
            lightness: -0.05
            , hue: 0
        };
        cs.wrap = false;


        // Add second series
        var pieSeries2 = chart.series.push(new am4charts.PieSeries());
        pieSeries2.dataFields.value = "bottles";
        pieSeries2.dataFields.category = "country";
        pieSeries2.slices.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        pieSeries2.slices.template.strokeWidth = 1;
        pieSeries2.slices.template.strokeOpacity = 1;
        pieSeries2.slices.template.states.getKey("hover").properties.shiftRadius = 0.05;
        pieSeries2.slices.template.states.getKey("hover").properties.scale = 1;

        pieSeries2.labels.template.disabled = true;
        pieSeries2.ticks.template.disabled = true;


        var label = chart.seriesContainer.createChild(am4core.Label);
        label.textAlign = "middle";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.adapter.add("text", function(text, target) {
            return "[font-size:18px]Available[/]:\n[bold font-size:30px]" + pieSeries.dataItem.values
                .value.sum + "[/]";
        })

    }); // end am4core.ready()

</script>
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
{{-- <script src="{{url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js')}}" type="text/javascript"></script> --}}

<!--end::Page Scripts -->

@endsection
