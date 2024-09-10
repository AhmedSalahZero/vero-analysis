@extends('layouts.dashboard')
@php
use Carbon\Carbon;
@endphp

@section('css')
<x-styles.commons></x-styles.commons>
<style>
    .max-w-invoice-date {
        width: 25% !important;
        min-width: 25% !important;
        max-width: 25% !important;
    }

    .max-w-16 {
        width: 16.5% !important;
        min-width: 16.5% !important;
        max-width: 16.5% !important;
    }


    .max-w-action {
        width: 25% !important;
        min-width: 25% !important;
        max-width: 25% !important;
    }

    .max-w-serial {
        width: 5% !important;
        min-width: 5% !important;
        max-width: 5% !important;
    }

    .dt-buttons.btn-group.flex-wrap {
        margin-bottom: 5rem !important;
    }

    #DataTables_Table_0_filter {
        display: none !important;
    }

    .dataTables_scrollHeadInner {
        width: 100% !important;
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
<x-main-form-title :id="'main-form-title'" :class="''">{{ __('Foreign Exchange Rates') }}</x-main-form-title>
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









                <div class="row">
                    <div class="col-md-12">
                       @include('admin.foreign-exchange-rate._form')
                    </div>
                </div>

                <div class="kt-portlet">

                    <div class="kt-portlet__body with-scroll pt-0">

                        <div class="table-custom-container position-relative  ">


                            <div>




                                <div class="responsive">
                                    <table class="table kt_table_with_no_pagination_no_collapse table-for-currency  table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class-for-currency dataTable no-footer">
                                        <thead>

                                            <tr class="header-tr ">

                                                <th class="view-table-th max-w-serial  header-th  align-middle text-center">
                                                    {{ __('#') }}
                                                </th>

                                                <th class="view-table-th   max-w-16  align-middle text-center">
                                                    {{ __('Date') }}
                                                </th>

                                                <th class="view-table-th max-w-16    header-th  align-middle text-center">
                                                    {{ __('From Currency') }}
                                                </th>

                                                <th class="view-table-th max-w-16    header-th  align-middle text-center">
                                                    {{ __('To Currency') }}
                                                </th>

                                                <th class="view-table-th  max-w-16  header-th  align-middle text-center">
                                                    {{ __('Exchange Rate') }}
                                                </th>
                                                <th class="view-table-th  max-w-16  header-th  align-middle text-center">
                                                    {{ __('Reciprocal Exchange Rate') }}
                                                </th>

                                                <th class="view-table-th  max-w-action  header-th  align-middle text-center">
                                                    {{ __('Actions') }}
                                                </th>







                                            </tr>

                                        </thead>
                                        <tbody>
                                            @php
                                            $previousDate = null ;
                                            @endphp
                                            @foreach($foreignExchangeRates as $index => $foreignExchangeRate)
                                            <tr class=" parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   ">
                                                <td class="sub-text-bg max-w-serial text-center   ">{{ ++$index }}</td>
                                                <td class="sub-text-bg max-w-16  text-center   ">{{ $currentDueDate = $foreignExchangeRate->getDateFormatted() }} </td>
                                                <td class="sub-text-bg  max-w-16 text-center   ">{{ $foreignExchangeRate->getFromCurrency() }}</td>
                                                @php
                                                $previousDate = $foreignExchangeRate->getDate();
                                                @endphp
                                                <td class="sub-text-bg max-w-16  text-center  ">{{ $foreignExchangeRate->getToCurrency() }}</td>
                                                <td class="sub-text-bg max-w-16  text-center  ">{{ number_format($foreignExchangeRate->getExchangeRate(),4) }}</td>
                                                <td class="sub-text-bg max-w-16  text-center  ">{{ number_format(1/$foreignExchangeRate->getExchangeRate(),4) }}</td>
                                                <td class="sub-text-bg   text-center max-w-action   ">
                                                    @if($loop->first)
                                                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{route('edit.foreign.exchange.rate',[$company,$foreignExchangeRate->id])}}"><i class="fa fa-pen-alt"></i></a>
                                                    <a class="btn btn-secondary btn-outline-hover-danger btn-icon  " href="#" data-toggle="modal" data-target="#modal-delete-{{ $foreignExchangeRate['id']}}" title="Delete"><i class="fa fa-trash-alt"></i>
                                                    </a>
                                                    @endif

                                                    <div id="modal-delete-{{ $foreignExchangeRate['id'] }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">{{ __('Delete Due Date History ' .$foreignExchangeRate->getDateFormatted()) }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3>{{ __('Are You Sure To Delete This Item ? ') }}</h3>
                                                                </div>
                                                                <form action="{{ route('delete.foreign.exchange.rate',[$company,$foreignExchangeRate->id]) }}" method="post" id="delete_form">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-danger">
                                                                            {{ __('Delete') }}
                                                                        </button>
                                                                        <button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">
                                                                            {{ __('Close') }}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            @push('js')
                            <script>
                                $('.table-for-currency').DataTable({
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
        $(document).on('change', 'select.js-change-currency', function() {
            const fromCurrency = $('select#from-currency').val();
            const toCurrency = $('select#to-currency').val();
            $('input#from-currency-input').val('1 ' + fromCurrency + ' = ')
            $('input#to-currency-input').val(toCurrency)
        })
        $('select.js-change-currency').trigger('change')

    </script>

    @endsection
