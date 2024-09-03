@extends('layouts.dashboard')
@section('css')
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('dash_nav')
<style>
 .bank-max-width {
        max-width: 50% !important;
        min-width: 50% !important;
        width: 50% !important;
    }
    .chartdiv_two_lines {
        width: 100%;
        height:275px !important;
    }

    .chartDiv {
        max-height: 350px !important;
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
        @foreach([
			'lg'=>[
				'main_title'=>__('Letters Of Guarantee Position'),
				'limits_title'=>__('LGs Limits'),
				'outstanding_title'=>__('LGs Outstanding Balance'),
				'room_title'=>__('LGs Room'),
				'cash_cover_title'=>__('LGs Cash Cover'),
				'outstanding_types_title'=>__('LG Outstanding Types'),
				'per_bank_title'=>__('LG Per Bank'),
				'details_title'=>__('LGs Details'),
				'lgOrLcTypes'=>$lgTypes,
				'lgOrLcSources'=>$lgSources
				] ,
				'lc'=>[
				'main_title'=>__('Letters Of Credit Position'),
				'limits_title'=>__('LCs Limits'),
				'outstanding_title'=>__('LCs Outstanding Balance'),
				'room_title'=>__('LCs Room'),
				'cash_cover_title'=>__('LCs Cash Cover'),
				'outstanding_types_title'=>__('LC Outstanding Types'),
				'per_bank_title'=>__('LC Per Bank'),
				'details_title'=>__('LCs Details'),
				'lgOrLcTypes'=>$lcTypes,
				'lgOrLcSources'=>$lcSources
				] 
				
				] as $lgOrLcType => $lcOrLgOptionsArr)
		
		<div class="kt-portlet">
            <div class="kt-portlet__head sky-border">
                <div class="kt-portlet__head-label">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ $lcOrLgOptionsArr['main_title'] }} </h3>
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
					
					@foreach([
						'limit'=>[
						'title'=>$lcOrLgOptionsArr['limits_title'],
						'bg-color'=>'kt-bg-brand'
						],
						'outstanding_balance'=>
						[
							'title'=>$lcOrLgOptionsArr['outstanding_title'] ,
							'bg-color'=>'kt-bg-warning'
						],
						'room'=>[
							'title'=>$lcOrLgOptionsArr['room_title'] ,
							'bg-color'=>'kt-bg-success'
							],
							'cash_cover'=>[
							'title'=>$lcOrLgOptionsArr['cash_cover_title'],
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
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white @if($currentColType != 'limit') visibility-hidden  @endif "   data-toggle="modal" data-target="#{{ $currentModalId.$currency.$lgOrLcType }}">{{ __('Details') }}</button>
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


     
		
        <div class="row">

         
            <div class="col-md-6">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ $lcOrLgOptionsArr['outstanding_types_title'] }} </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                   {{-- <h4 class="visibility-hidden"> {{ __('Per Lg Type') }} </h4> --}}
                                        <div id="outstanding_per_{{ $lgOrLcType }}_typechartdiv_available_room_{{$currency}}" class="chartDiv"></div>
                                    <input type="hidden" id="outstanding_per_{{ $lgOrLcType }}_typetotal_available_room_{{$currency}}" data-total="{{ json_encode($charts['outstanding_per_'.$lgOrLcType.'_type'][$currency] ?? [] ) }}">
                            </div>
                 
                        </div>
                       
                        
                    </div>
                </div>
            </div>

			 <div class="col-md-6">
                <div class="kt-portlet kt-portlet--tabs">
                     <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ $lcOrLgOptionsArr['per_bank_title'] }} </h3>

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
                                               <div id="{{ $lgOrLcType }}_outstanding_per_financial_institutionchartdiv_available_room_{{$currency}}" class="chartDiv"></div>
                                    <input type="hidden" id="{{ $lgOrLcType }}_outstanding_per_financial_institutiontotal_available_room_{{$currency}}" data-total="{{ json_encode($charts[$lgOrLcType.'_outstanding_per_financial_institution'][$currency] ?? [] ) }}">
                                    </div>



                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
			
			
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--tabs">
                     <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> {{ $lcOrLgOptionsArr['details_title'] }} </h3>

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

                                        <div class="row common-parent">
										<input type="hidden" class="current_currency" value="{{ $currency }}">
                                          
                                            <div class="col-md-6">
                                                <select {{ 'update-'. $lgOrLcType .'-table-and-charts' }} data-currency="{{ $currency }}"  id="financial_institution_id_{{ $currency }}" class="form-control ">
														<option value="0">{{ __('All') }}</option>
												
                                                    @foreach($financialInstitutions as $bank)
                                                    <option value="{{ $bank->id }}"> {{ $bank->getName() }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="col-md-3"  >
                                                <select  {{ 'update-'.$lgOrLcType.'-table-and-charts' }}  id="{{ $lgOrLcType }}_type_{{ $currency }}"  name="{{ $lgOrLcType }}_type" class="form-control">
														<option value="0">{{ __('All') }}</option>
													@foreach($lcOrLgOptionsArr['lgOrLcTypes'] as $typeId => $typeTitle)
														<option value="{{ $typeId }}">{{ $typeTitle }}</option>
													@endforeach 
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <select name="{{ $lgOrLcType }}_source" class="form-control" id="{{ $lgOrLcType }}_source_{{ $currency }}" {{ 'update-'.$lgOrLcType.'-table-and-charts' }} >
														<option value="0">{{ __('All') }}</option>
													@foreach($lcOrLgOptionsArr['lgOrLcSources'] as $sourceId => $sourceTitle)
														<option value="{{ $sourceId }}">{{ $sourceTitle }}</option>
													@endforeach 
                                                </select>
                                            </div>
											
											<div class="col-md-12 mt-4">
											  <x-table-with-attributes data-currency="{{ $currency }}" :tableClass="'kt_table_with_no_pagination_no_scroll_no_entries remove-max-class '.$lgOrLcType.'-details-table'">
                                                @slot('table_header')
                                                <tr class="table-active text-center">
                                                    <th class="text-center bank-max-width">{{ __('Bank Name') }}</th>
                                                    <th class="text-center ">{{ __('Type') }}</th>
                                                    <th class="text-center ">{{ __('Source') }}</th>
                                                    <th class="text-center ">{{ __('Outstanding') }}</th>
                                                    <th class="text-center ">{{ __('Cash Cover') }}</th>
                                                </tr>
                                                @endslot
                                                @slot('table_body')
												@php
													$totals = [];
												@endphp
												@foreach($tablesData[$lgOrLcType.'_outstanding_for_table'][$currency] ??[ ] as $outstandingArr )
												<tr>
                                                    <td class="text-left bank-max-width" > {{ $outstandingArr['financial_institution_name'] }} </td>
                                                    <td class="text-left">{{ $outstandingArr['type'] }}</td>
                                                    <td class="text-center">{{ $outstandingArr['source'] }}</td>
													@php
														$currentOutstandingBalance = $outstandingArr['outstanding'] ;
														$currentCashCover = $outstandingArr['cash_cover'] ;
														$totals['outstanding'] = isset($totals['outstanding']) ? $totals['outstanding'] + $currentOutstandingBalance : $currentOutstandingBalance;
														$totals['cash_cover'] = isset($totals['cash_cover']) ? $totals['cash_cover'] + $currentCashCover : $currentCashCover;
														
													@endphp
                                                    <td class="text-center">{{ number_format($currentOutstandingBalance) }}</td>
                                                    <td class="text-center">{{ number_format($currentCashCover) }}</td>
                                                </tr>
												@endforeach 
                                                

                                                <tr class="table-active text-center">
                                                    <td>{{__('Total')}}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ number_format($totals['outstanding'] ??0) }}</td>
                                                    <td>{{ number_format($totals['cash_cover']??0) }}</td>

                                                </tr>
                                                @endslot
                                            </x-table-with-attributes>
											</div>

                                        </div>
                                        {{-- <div class="chartdiv_two_lines" id="FullySecuredOverdraftchartdiv_two_lines_{{ $currency }}"></div> --}}
                                    </div>
                                </div>

                            </div>

                           
                        </div>
                    </div>
                </div>

            </div>
            {{-- End Fully Secured Overdraft --}}
























        </div>
		@endforeach 
        {{-- Title --}}
        {{-- <div class="row">
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
@foreach(['outstanding_per_lg_type','lg_outstanding_per_financial_institution','outstanding_per_lc_type','lc_outstanding_per_financial_institution'] as $currentChartType)
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
         chart.legend = new am4charts.Legend();
                chart.legend.position = "right";
            chart.legend.scrollable = true;


    }); // end am4core.ready()

</script>


@endforeach
@endforeach



<script>
    $(document).on('change', 'select[js-refresh-limits-chart]', function(e) {
        const modelName = $(this).attr('data-table');
        const currencyName = $(this).attr('data-currency')
        const bankId = $('.bank-id-js[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const accountNumber = $('.js-account-number[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const date = $('#js-date').val();
        const currentChartId = modelName + 'chartdiv_two_lines_' + currencyName
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
<script>
$(document).on('change','[update-lg-table-and-charts]',function(){
	const currentCurrency = $(this).closest('.common-parent').find('.current_currency').val();
	const lgOutstandingPerLgTypeChartId = 'outstanding_per_lg_typechartdiv_available_room_'+currentCurrency;
	const lgOutstandingPerLgFinancialInstitutionChartId = 'lg_outstanding_per_financial_institutionchartdiv_available_room_'+currentCurrency;
	const financialInstitutionId = $('select#financial_institution_id_'+currentCurrency).val();
	const lgType = $('select#lg_type_'+currentCurrency).val();
	const lgSource = $('select#lg_source_'+currentCurrency).val();
	$.ajax({
		url:"{{ route('view.lglc.dashboard',['company'=>$company->id]) }}",
		data:{
			financialInstitutionId,
			lgType,
			lgSource,
			currencies:[currentCurrency]
		},
		success:function(res){
			// format table 
			$('table.lg-details-table[data-currency="'+ currentCurrency +'"] tbody').empty();
			if(res.tablesData.lg_outstanding_for_table){
				var tableData =  res.tablesData.lg_outstanding_for_table[currentCurrency] ; 
				var mainRows = ' ';
				var totalOutstanding = 0 ;
				var totalCashCover = 0 ;
				for(var row of tableData){
					var currentOutstanding = row.outstanding ;
					totalOutstanding +=currentOutstanding;
					var currentCashCover = row.cash_cover ;
					totalCashCover += currentCashCover ;
					mainRows+= `<tr> <td class="text-left bank-max-width">${row.financial_institution_name}</td> <td class="text-left">${row.type}</td> <td>${row.source}</td> <td>${number_format(currentOutstanding)}</td> <td>${number_format(currentCashCover)}</td> </tr>`;
				}
				// total row 
				 mainRows += `<tr class="table-active text-center"> <td>-</td> <td>-</td> <td> - </td> <td>${number_format(totalOutstanding)}</td>	<td>${number_format(totalCashCover)}</td> </tr>`
				$('table.lg-details-table[data-currency="'+ currentCurrency +'"] tbody').empty().append(mainRows)
			}
			am4core.registry.baseSprites.find(c => c.htmlContainer.id === lgOutstandingPerLgTypeChartId).data = res.charts.outstanding_per_lg_type ? res.charts.outstanding_per_lg_type[currentCurrency] : []
			am4core.registry.baseSprites.find(c => c.htmlContainer.id === lgOutstandingPerLgFinancialInstitutionChartId).data = res.charts.lg_outstanding_per_financial_institution ? res.charts.lg_outstanding_per_financial_institution[currentCurrency] : []

			
		}
	})
})
$(document).on('change','[update-lc-table-and-charts]',function(){
	const currentCurrency = $(this).closest('.common-parent').find('.current_currency').val();
	const lcOutstandingPerLcTypeChartId = 'outstanding_per_lc_typechartdiv_available_room_'+currentCurrency;
	const lcOutstandingPerLcFinancialInstitutionChartId = 'lc_outstanding_per_financial_institutionchartdiv_available_room_'+currentCurrency;
	const financialInstitutionId = $('select#financial_institution_id_'+currentCurrency).val();
	const lcType = $('select#lc_type_'+currentCurrency).val();
	const lcSource = $('select#lc_source_'+currentCurrency).val();
	$.ajax({
		url:"{{ route('view.lglc.dashboard',['company'=>$company->id]) }}",
		data:{
			financialInstitutionId,
			lcType,
			lcSource,
			currencies:[currentCurrency]
		},
		success:function(res){
			// format table 
			$('table.lc-details-table[data-currency="'+ currentCurrency +'"] tbody').empty();
			if(res.tablesData.lc_outstanding_for_table){
				var tableData =  res.tablesData.lc_outstanding_for_table[currentCurrency] ; 
				var mainRows = ' ';
				var totalOutstanding = 0 ;
				var totalCashCover = 0 ;
				for(var row of tableData){
					var currentOutstanding = row.outstanding ;
					totalOutstanding +=currentOutstanding;
					var currentCashCover = row.cash_cover ;
					totalCashCover += currentCashCover ;
					mainRows+= `<tr> <td class="text-left bank-max-width">${row.financial_institution_name}</td> <td class="text-left">${row.type}</td> <td>${row.source}</td> <td>${number_format(currentOutstanding)}</td> <td>${number_format(currentCashCover)}</td> </tr>`;
				}
				// total row 
				 mainRows += `<tr class="table-active text-center"> <td>-</td> <td>-</td> <td> - </td> <td>${number_format(totalOutstanding)}</td>	<td>${number_format(totalCashCover)}</td> </tr>`
				$('table.lc-details-table[data-currency="'+ currentCurrency +'"] tbody').empty().append(mainRows)
			}
			am4core.registry.baseSprites.find(c => c.htmlContainer.id === lcOutstandingPerLcTypeChartId).data = res.charts.outstanding_per_lc_type ? res.charts.outstanding_per_lc_type[currentCurrency] : []
			am4core.registry.baseSprites.find(c => c.htmlContainer.id === lcOutstandingPerLcFinancialInstitutionChartId).data = res.charts.lc_outstanding_per_financial_institution ? res.charts.lc_outstanding_per_financial_institution[currentCurrency] : []

			
		}
	})
})
</script>
{{-- <script src="{{url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js')}}" type="text/javascript"></script> --}}

<!--end::Page Scripts -->

@endsection
