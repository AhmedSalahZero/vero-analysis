@extends('layouts.dashboard')
@section('css')
<x-styles.commons></x-styles.commons>
<style>
   

    .max-w-name {
        width: 40% !important;
        min-width: 40% !important;
        max-width: 40% !important;
    }

    .max-w-currency {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }
	    .max-w-invoice-number {
        width: 10% !important;
        min-width: 10% !important;
        max-width: 10% !important;
    }
	.max-w-invoice-date {
        width: 10% !important;
        min-width: 10% !important;
        max-width: 10% !important;
    }
	    .max-w-currency {
        width: 8% !important;
        min-width: 8% !important;
        max-width: 8% !important;
    }
    .max-w-amount {
        width: 12% !important;
        min-width: 12% !important;
        max-width: 12% !important;
    }

    .max-w-report-btn {
        width: 10% !important;
        min-width: 10% !important;
        max-width: 10% !important;
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
<x-main-form-title :id="'main-form-title'" :class="''">{{ __('Balance In '  ) . ' ' . __($currency) }}</x-main-form-title>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="kt-portlet">


            <div class="kt-portlet__body">

                @php

                $tableId = 'kt_table_1';
                @endphp


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
                        background-color: #0e96cd !important;
                        color: white !important;


                        background-color: #E2EFFE !important;
                        color: black !important
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
                @csrf


        <div class="table-custom-container position-relative  ">


            <div>




                <div class="responsive">
                    <table class="table kt_table_with_no_pagination_no_collapse table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                        <thead>

                            <tr class="header-tr ">

                                <th class="view-table-th max-w-serial  header-th  align-middle text-center">
                                    {{ __('#') }}
                                </th>

                                <th class="view-table-th    header-th  align-middle text-center">
                                    {{ $clientNameText }}
                                </th>

                                <th class="view-table-th   header-th  align-middle text-center">
                                    {{ __('Invoice Number') }}
                                </th>
                                <th class="view-table-th max-w-invoice-date     header-th  align-middle text-center">
                                    {{ __('Invoice Date') }}
                                </th>

							  <th class="view-table-th     header-th  align-middle text-center">
                                    {{ __('Currency') }}
                                </th>
								
									  <th class="view-table-th header-th  align-middle text-center">
                                    {{ __('Net Balance') }}
                                </th>
								
								
								 <th class="view-table-th     header-th  align-middle text-center">
                                    {{ __('Invoice Due Date') }}
                                </th>
								
								
								 <th class="view-table-th     header-th  align-middle text-center">
                                    {{ __('Status') }}
                                </th>
								
								
								
								
								
								  <th class="view-table-th     header-th  align-middle text-center">
                                    {{ __('Actions') }}
                                </th>
								

                           



                            </tr>

                        </thead>
                        <tbody>
                            <script>
                                let currentTable = null;

                            </script>
							
                            @foreach($invoicesBalances as $index=>$invoiceStdClass)
                            <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                <td class="sub-text-bg max-w-serial   ">{{ $index+1 }}</td>
                                <td class="sub-text-bg  is-name-cell ">{{ $invoiceStdClass->{$clientNameColumnName} }}</td>
                                <td class="sub-text-bg text-center">{{ $invoiceStdClass->invoice_number }}</td>
                                <td class="sub-text-bg text-center ">{{ $invoiceStdClass->invoice_date }}</td>
                                <td class="sub-text-bg text-center ">{{ $invoiceStdClass->currency }}</td>
                                <td class="sub-text-bg text-center ">{{ number_format($invoiceStdClass->net_balance) }}</td>
                                <td class="sub-text-bg text-center ">{{ \Carbon\Carbon::make($invoiceStdClass->invoice_due_date)->format('d-m-Y') }}</td>
                                <td class="sub-text-bg text-center ">{{ snakeToCamel($invoiceStdClass->invoice_status) }}</td>
                                <td class="sub-text-bg  text-center">
                                    <a href="{{ route($moneyReceivedOrPaidUrlName,['company'=>$company->id,'model'=>$invoiceStdClass->id ]) }}" class="btn btn-sm btn-primary">{{ $moneyReceivedOrPaidText }}</a>
                                </td>
                
                            </tr>
							
							@endforeach 








                        </tbody>
                    </table>
                </div>

            </div>

            @push('js')
            <script>
                var table = $(".kt_table_with_no_pagination_no_collapse");






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
                                currentTable = $('.main-table-class').DataTable();
                            }
                            $('.buttons-html5').addClass('btn border-parent btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')
                            $('.buttons-print').addClass('btn border-parent top-0 btn-border-export btn-secondary btn-bold  ml-2 flex-1 flex-grow-0 btn-border-radius do-not-close-when-click-away')

                        },





                    }

                )

            </script>
            @endpush

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
    function getDateFormatted(yourDate) {
        const offset = yourDate.getTimezoneOffset()
        yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000))
        return yourDate.toISOString().split('T')[0]
    }

    am4core.ready(function() {

        // Themes begin



    }); // end am4core.ready()

</script>
<script>
    $(document).on('click', '#show-past-due-detail', function() {
        if (!currentTable) {
            currentTable = $('.main-table-class').DataTable()
        }
        if (currentTable.column(2).visible()) {
            $(this).html("{{ __('Show Details') }}")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(false);
        } else {
            $(this).html("{{ __('Hide Details') }}")
            currentTable.columns([2, 3, 4, 5, 6, 7, 8, 9, 10]).visible(true);
        }
    })

   

</script>

@endsection
