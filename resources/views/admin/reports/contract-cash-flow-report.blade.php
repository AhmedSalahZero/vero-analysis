@extends('layouts.dashboard')
@section('css')
@php
use App\Helpers\HArr;
use Carbon\Carbon ;
@endphp
<x-styles.commons></x-styles.commons>
<style>
    .ml-son {
        margin-left: 10px;
        font-weight: 400;
    }

    .bg-lighter,
    .bg-lighter * {
        background-color: #E2EFFE !important;
        color: black !important;
    }

    .max-w-weeks {
        max-width: 100px !important;
        min-width: 100px !important;
        width: 100px !important;
    }

    .is-sub-row.is-total-row td.sub-numeric-bg,
    .is-sub-row.is-total-row td.sub-text-bg {
        background-color: #087383 !important;
        color: white !important;
    }

    .is-name-cell {
        white-space: normal !important;
    }

    .top-0 {
        top: 0 !important;
    }

    .parent-tr td {
        border: 1px solid #E2EFFE !important;
    }

    .dataTables_filter {
        width: 30% !important;
        text-align: left !important;

    }

    .border-parent {
        border: 2px solid #E2EFFE;
    }

    .dt-buttons.btn-group,
    .buttons-print {
        max-width: 30%;
        margin-left: auto;
        position: relative;
        top: 45px;
    }

    .details-btn {
        display: block;
        margin-top: 10px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 600;

    }

    .expand-all {
        cursor: pointer;
    }

    td.editable-date.max-w-fixed,
    th.editable-date.max-w-fixed,
    input.editable-date.max-w-fixed {
        width: 1050px !important;
        max-width: 1050px !important;
        min-width: 1050px !important;

    }

    td.editable-date.max-w-classes-expand,
    th.editable-date.max-w-classes-expand,
    input.editable-date.max-w-classes-expand {
        width: 70px !important;
        max-width: 70px !important;
        min-width: 70px !important;

    }

    td.max-w-classes-name,
    th.max-w-classes-name,
    input.max-w-classes-name {
        width: 350px !important;
        max-width: 350px !important;
        min-width: 350px !important;

    }

    td.max-w-grand-total,
    th.max-w-grand-total,
    input.max-w-grand-total {
        width: 100px !important;
        max-width: 100px !important;
        min-width: 100px !important;

    }

    * {
        box-sizing: border-box !important;
    }

</style>
@endsection
@section('sub-header')
<x-main-form-title :id="'main-form-title'" :class="''">{{ __('Contract Cash Flow Report') }}</x-main-form-title>
@endsection
@section('content')
@php
$moreThan150=\App\ReadyFunctions\InvoiceAgingService::MORE_THAN_150;
@endphp
<script>
    let globalTable = null;

</script>

<style>
    td.editable-date,
    th.editable-date,
    input.editable-date {
        width: 100px !important;
        min-width: 100px !important;
        max-width: 100px !important;
        overflow: hidden;
    }

    .width-66 {


        width: 66% !important;
    }

    .border-bottom-popup {
        border-bottom: 1px solid #d6d6d6;
        padding-bottom: 20px;
    }

    .flex-self-start {
        align-self: flex-start;
    }

    .flex-checkboxes {
        margin-top: 1rem;
        flex: 1;
        width: 100% !important;
    }


    .flex-checkboxes>div {
        width: 100%;
        width: 100% !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .custom-divs-class {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }


    .modal-backdrop {
        display: none !important;
    }

    .modal-content {
        min-width: 600px !important;
    }

    .form-check {
        padding-left: 0 !important;

    }

    .main-with-no-child,
    .main-with-no-child td,
    .main-with-no-child th {
        background-color: #046187 !important;
        color: white !important;
        font-weight: bold;
    }

    .is-sub-row td.sub-numeric-bg,
    .is-sub-row td.sub-text-bg {
        border: 1.5px solid white !important;
        background-color: #f7f8fa !important;
        color: black !important;
        font-weight: 400 !important;
    }



    .sub-numeric-bg {
        text-align: center;

    }



    th.dtfc-fixed-left {
        background-color: #074FA4 !important;
        color: white !important;
    }

    .header-tr,
        {
        background-color: #046187 !important;
    }

    .dt-buttons.btn-group {
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }

    .is-sales-rate,
    .is-sales-rate td,
    .is-sales-growth-rate,
    .is-sales-growth-rate td {
        background-color: #046187 !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTable th,
    .dataTables_wrapper .dataTable td {
        font-weight: bold;
        color: black;
    }

    a[data-toggle="modal"] {
        color: #046187 !important;
    }

    a[data-toggle="modal"].text-white {
        color: white !important;
    }

    .btn-border-radius {
        border-radius: 10px !important;
    }

</style>
<div class="row">
    <div class="col-md-12">

        <div class="kt-portlet kt-portlet--tabs">

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
					@php
						$index = 0 ;
					@endphp
					@foreach($allCurrencies as $currentCurrencyName)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ?'active':'' }}" data-toggle="tab" href="#{{ $currentCurrencyName }}" role="tab">
                                <i class="fa fa-money-check-alt"></i> {{ $currentCurrencyName }}
                            </a>
                        </li>
						@php
							$index++;
						@endphp
						@endforeach 

                        {{-- <li class="nav-item">
                    <a class="nav-link {{ Request('active') == BuyOrSellCurrency::SAFE_TO_BANK ?'active':'' }}" data-toggle="tab" href="#{{ BuyOrSellCurrency::SAFE_TO_BANK }}" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Safe To Bank') }}
                        </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link {{ Request('active') == BuyOrSellCurrency::BANK_TO_SAFE ?'active':'' }}" data-toggle="tab" href="#{{ BuyOrSellCurrency::BANK_TO_SAFE }}" role="tab">
                                <i class="fa fa-money-check-alt"></i> {{ __('Bank To Safe') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request('active') == BuyOrSellCurrency::SAFE_TO_SAFE ?'active':'' }}" data-toggle="tab" href="#{{ BuyOrSellCurrency::SAFE_TO_SAFE }}" role="tab">
                                <i class="fa fa-money-check-alt"></i> {{ __('Safe To Safe') }}
                            </a>
                        </li> --}}

                    </ul>

                </div>
            </div>


            <div class="kt-portlet__body ">
                <div class="tab-content  kt-margin-t-20">
				@php
					$index = -1 ;
				@endphp
				
					@foreach($allCurrencies as $currentCurrencyName)
                    @php
                    $currentType =$currentCurrencyName ;
                    $tableId = 'kt_table_'.$currentCurrencyName;
					$index++;
                    @endphp
                    <div class="tab-pane {{ $index == 0 ? 'active':'' }}" id="{{ $currentType }}" role="tabpanel">
                        <div class="kt-portlet kt-portlet--mobile">


                       
                            <div class="table-custom-container position-relative  ">


                                <div class="responsive">
                                    <table class="table kt_table_with_no_pagination_no_collapse{{ $tableId }} table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class{{ $tableId }} dataTable no-footer">
                                        <thead>
                                            <tr class="header-tr ">
                                                <th rowspan="{{ $noRowHeaders }}" class="view-table-th expand-all is-open-parent header-th editable-date max-w-classes-expand align-middle text-center trigger-child-row-1">
                                                    {{ __('Expand All' ) }} 
                                                    <span>+</span>
                                                </th>
                                                <th rowspan="{{ $noRowHeaders }}" class="view-table-th header-th max-w-classes-name align-middle text-center">
                                                    {{ __('Item') }}
                                                </th>
                                                <th class="view-table-th @if($reportInterval == 'weekly') bg-lighter @endif max-w-weeks header-th  align-middle text-center">
                                                    @if($reportInterval == 'weekly')
                                                    {{ __('Week Num') }}
                                                    @elseif($reportInterval == 'monthly')
                                                    {{ __('Months') }}
                                                    @elseif($reportInterval == 'daily')
                                                    {{ __('Days') }}

                                                    @endif

                                                </th>
                                                @if($reportInterval == 'weekly')
                                                @foreach($weeks as $weekAndYear => $week)
                                                @php
                                                $year = explode('-',$weekAndYear)[1];
                                                @endphp
                                                <th class="view-table-th bg-lighter header-th max-w-weeks align-middle text-center">
                                                    <span class="d-block">{{ __('Week ' .  $week ) }}</span>
                                                    <span class="d-block">{{ '[ ' . $year . ' ]' }}</span>
                                                </th>
                                                @endforeach
                                                @elseif($reportInterval == 'monthly')

                                                @foreach($months as $month)
                                                <th class="view-table-th  header-th max-w-weeks align-middle text-center">
                                                    @if($loop->first || $loop->last)
                                                    <span class="d-block">{{ Carbon::make($month)->format('d-m-Y') }}</span>
                                                    @else
                                                    <span class="d-block">{{ Carbon::make($month)->format('m-Y') }}</span>
                                                    @endif
                                                </th>
                                                @endforeach


                                                @elseif($reportInterval == 'daily')

                                                @foreach($days as $day)
                                                <th class="view-table-th  header-th max-w-weeks align-middle text-center">
                                                    <span class="d-block">{{ Carbon::make($day)->format('d-m-Y') }}</span>
                                                </th>
                                                @endforeach

                                                @endif
                                                <th rowspan="{{ $noRowHeaders }}" class="view-table-th editable-date align-middle text-center header-th max-w-grand-total">
                                                    {{ __('Total') }}
                                                </th>

                                            </tr>
                                            @if($reportInterval == 'weekly')
                                            <tr class="header-tr ">


                                                <th class="view-table-th header-th max-w-weeks  align-middle text-center" class="header-th">
                                                    {{ __('Start Date') }}
                                                </th>
                                                @foreach($dates as $index=>$startAndEndDate)
                                                <th class="view-table-th header-th max-w-weeks text-nowrap  align-middle text-center">{{ $startAndEndDate['start_date'] }}</th>
                                                @endforeach


                                            </tr>


                                            <tr class="header-tr ">

                                                <th class="view-table-th header-th max-w-weeks  align-middle text-center" class="header-th">
                                                    {{ __('End Date') }}
                                                </th>
                                                @foreach($dates as $index=>$startAndEndDate)
                                                <th class="view-table-th header-th text-nowrap max-w-weeks  align-middle text-center">{{ $startAndEndDate['end_date'] }}</th>
                                                @endforeach


                                            </tr>

                                            @endif


                                        </thead>
                                        <tbody>
                                            <script>
                                                let currentTable = null;

                                            </script>
                                            @php
                                            $rowIndex = 0 ;
                                            @endphp

                                            @foreach(['customers','suppliers','cash_expenses'] as $mainReportKey)

                                            @foreach( $finalResult[$currentCurrencyName][$mainReportKey] ?? [] as $parentKeyName => $subRows)
                                            @php
                                            $customerName = $parentKeyName ;
                                            $hasSubRows = true;
                                            if($parentKeyName == __('Customers Past Due Invoices') || $parentKeyName =='Customers Past Due Invoices'
                                            || $parentKeyName == __('Suppliers Past Due Invoices') || $parentKeyName =='Suppliers Past Due Invoices'
                                            || $parentKeyName == __('Net Cash (+/-)')
                                            || $parentKeyName == __('Accumulated Net Cash (+/-)')

                                            || $parentKeyName == __('Total Cash Inflow') || $parentKeyName == __('Total Cash Outflow')
                                            ){
                                            $hasSubRows = false ;
                                            }
                                            $rowIndex = $rowIndex+ 1;
                                            $subRowKeys = HArr::removeKeyFromArrayByValue(array_keys($finalResult[$currentCurrencyName][$mainReportKey][$parentKeyName] ?? []),['total']);
		
                                            @endphp
                                            @include('admin.reports.cash-flow-main-row',['isTotalRow'=>true,'result'=>$finalResult[$currentCurrencyName]??[],'pastDueCustomerInvoices'=>$pastDueCustomerInvoices[$currentCurrencyName]??[] ,'customerDueInvoices'=>$customerDueInvoices[$currentCurrencyName] ?? []])
                                            @foreach($subRowKeys as $currentSubRowKeyName)
                                            {{-- @foreach(['Outgoing Transfers','Cash Payments','Paid Payable Cheques','Under Payment Payable Cheques','Suppliers Invoices'] as $currentSupplierKeyName) --}}
                                            @include('admin.reports.cash-flow-sub-row',['result'=>$finalResult[$currentCurrencyName]])
                                            @endforeach
                                            @endforeach

                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
					
					@push('js')
                    <script>
                        var table = $(".kt_table_with_no_pagination_no_collapse{{ $tableId }}");
                        $(document).on('click', '.trigger-child-row-1', function(e) {
                            const parentId = $(e.target.closest('tr')).data('model-id');
                            var parentRow = $(e.target).parent();
                            var subRows = parentRow.nextAll('tr.add-sub.maintable-1-row-class' + parentId);

                            subRows.toggleClass('d-none');
                            if (subRows.hasClass('d-none')) {
                                parentRow.find('td.trigger-child-row-1').removeClass('is-open').addClass('is-close').html('+');
                                var closedId = parentRow.attr('data-index')


                            } else if (!subRows.length) {
                                // if parent row has no sub rows then remove + or - 
                                parentRow.find('td.trigger-child-row-1').html('×');
                            } else {
                                parentRow.find('td.trigger-child-row-1').addClass('is-open').removeClass('is-close').html('-');



                            }

                            table.DataTable().columns.adjust()

                        });



                        








                       
                        



                        table.DataTable({




                                dom: 'Bfrtip'

                                , "processing": false
                                , "scrollX": true
                                , "scrollY": true
                                , "ordering": false
                                , 'paging': false
                                , "fixedColumns": {
                                    left: 2
                                }
                                , "fixedHeader": {
                                    headerOffset: 60
                                }
                                , "serverSide": false
                                , "responsive": false
                                , "pageLength": 25
                                , drawCallback: function(setting) {
                                    if (!currentTable) {
                                        currentTable = $('.main-table-class{{ $tableId }}').DataTable();
                                    }
                                    $('.buttons-html5').addClass('btn border-parent btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
                                    $('.buttons-print').addClass('btn border-parent top-0 btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')

                                },





                            }

                        )

                    </script>
					
		


                    @endpush
					
					@endforeach 
				
				

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<x-js.commons></x-js.commons>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script> 
if ($('.kt-portlet__body').length) {
                            $('.kt-portlet__body').append(`<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i> <i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>`)
                            $(document).on('click', '.arrow-nav', function() {
                                const scrollLeftOfTableBody = document.querySelector('.kt-portlet__body').scrollLeft
                                const scrollByUnit = 50
                                if (this.classList.contains('arrow-right')) {
                                    document.querySelector('.dataTables_scrollBody').scrollLeft += scrollByUnit

                                } else {
                                    document.querySelector('.dataTables_scrollBody').scrollLeft -= scrollByUnit

                                }
                            })

                        }
$(document).on('click', '.expand-all', function(e) {
                            e.preventDefault();
                            if ($(this).hasClass('is-open-parent')) {
                                $(this).addClass('is-close-parent').removeClass('is-open-parent')
                                $(this).find('span').html('-')

                                $('.main-tr.is-close').trigger('click')
                            } else {
                                $(this).addClass('is-open-parent').removeClass('is-close-parent')
                                $(this).find('span').html('+')

                                $('.main-tr.is-open').trigger('click')
                            }

                        })
						
window.addEventListener('scroll', function() {
                            const top = window.scrollY > 140 ? window.scrollY : 140;

                            $('.arrow-nav').css('top', top + 'px')
                        })
    function getDateFormatted(yourDate) {
        const offset = yourDate.getTimezoneOffset()
        yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000))
        return yourDate.toISOString().split('T')[0]
    }



$(document).on('click', '.js-show-customer-due-invoices-modal', function(e) {
        e.preventDefault();
        $(this).closest('td').find('.modal-item-js').modal('show')
    })
	
</script>

@endsection
