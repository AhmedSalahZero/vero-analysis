@extends('layouts.dashboard')
@push('css')

	<style>
	.dt-buttons.btn-group.flex-wrap{
		float:right;
	}
	.arrow-right{
		right:10px !important;
	}
	.arrow-left{
		left:10px !important;
	}
	
	.dataTables_filter{
		display:none !important;
	}
	.flex-1{
	flex:1 !important;
}
tbody .kt-option{
	border:none ;
	padding: 0 !important;
    position: relative !important;
    top: -20px !important;
    max-width: 30px !important;
    left: 28% !important;
	height:0 !important;
}

	th .kt-checkbox.kt-checkbox--brand > span:after{
		border-color:white !important;
	}
	th .kt-checkbox.kt-checkbox--brand > span{
		border-color:white !important;
	}
	th .kt-checkbox.kt-checkbox--brand.kt-checkbox--bold > input ~ span{
		color:white !important ; 
	}
	</style>
@endpush
@section('css')
<style>

    table {
        white-space: nowrap;

    }

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>
@endsection
@section('sub-header')
{{ camelToTitle($modelName) }} {{ __('Section') }}
<x-navigators-dropdown :navigators="$navigators ?? []"></x-navigators-dropdown>
@endsection
@section('content')
@php
$user = auth()->user();
@endphp
<div class="row">
    <div class="col-lg-12">
        @if (session('warning'))
        <div class="alert alert-warning">
            <ul>
                <li>{{ session('warning') }}</li>
            </ul>
        </div>
        @endif
    </div>
</div>
<form  action="{{ route('multipleRowsDelete', [$company, $modelName]) }}" method="POST">
    @csrf
    @method('delete')
    {{-- {{ dd($notPeriodClosedCustomerInvoices) }} --}}
    <x-table :instructions-icon="1" :notPeriodClosedCustomerInvoices="$notPeriodClosedCustomerInvoices??[]" :tableTitle="camelToTitle($modelName).' '.__(' Table')" :tableClass="'kt_table_with_no_pagination '" href="#" :importHref="$user->can($uploadPermissionName) ? route('salesGatheringImport',['company'=>$company->id , 'model'=>$modelName]) : '#'" :exportHref="$user->can($exportPermissionName) ? route('salesGathering.export',['company'=>$company->id , 'model'=>$modelName]):'#' " :exportTableHref="$user->can($uploadPermissionName)?route('table.fields.selection.view',[$company,$modelName,'sales_gathering']) : '#'" :truncateHref="$user->can($deletePermissionName)?route('truncate',[$company,$modelName]):'#' ">
        @slot('table_header')
        {{-- <button >sdasd</button> --}}
        {{-- @if($user->can($deletePermissionName))
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12 ">
                    <label class="kt-option bg-secondary">
                        <span class="kt-option__control">
                            <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                <input class="rows" type="checkbox" id="select_all">
                                <span></span>
                            </span>
                        </span>
                        <span class="kt-option__label d-flex">
                            <span class="kt-option__head mr-auto p-2">
                                <span class="kt-option__title">
                                    <b>
                                        {{ __('Select All') }}
        </b>
        </span>

        </span>

        <span class="kt-option__body p-2">
            <button type="submit" class="btn active-style btn-icon-sm">
                <i class="fas fa-trash"></i>
                {{ __('Delete Selected Rows') }}
            </button>
        </span>
        </span>
        </label>
        </div>
        </div>
        </div>
        @endif --}}
        <tr class="table-active text-center">
            @if($user->can($deletePermissionName))
            <th class="">

                    <label style="top:-10px;right:-7px" class="kt-option d-inline-flex border-none p-0 mt-[-15px] top-[-10] position-relative" >
                        <span class="kt-option__control">
                            <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                <input class="rows" type="checkbox" id="select_all">
                                <span></span>
                            </span>
                        </span>


                    </label>


            </th>
            @endif
            @foreach ($viewing_names as $name)

            <th>{{ __($name) }}</th>
            @endforeach
            <th>{{ __('Actions') }}</th>
        </tr>
        @endslot
        @slot('table_body')
        @foreach ($salesGatherings as $item)
        <tr>
            @if($user->can($deletePermissionName))
            <td class="text-center">
                <label class="kt-option">
                    <span class="kt-option__control">
                        <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>

                            <input class="rows" type="checkbox" name="rows[]" value="{{ $item->id }}">
                            <span></span>
                        </span>
                    </span>
                    <span class="kt-option__label">
                        <span class="kt-option__head">

                        </span>

                    </span>
                </label>
            </td>
            @endif
            @foreach ($db_names as $name)

            @if ($name == 'date'  || $name=='invoice_due_date' || $name == 'invoice_date')
            <td class="text-center">{{ isset($item->$name) ? date('d-M-Y',strtotime($item->$name)):  '-' }}</td>
            @elseif($name == 'invoice_amount' || $name == 'vat_amount' || $name == 'withhold_amount' || $name == 'collected_amount' || $name=='net_balance'|| $name=='net_invoice_amount')
            <td class="text-center">{{ number_format($item->$name?:0 ,2 ) }}</td>
			@else 
            <td class="text-center">{{ $item->$name ?? '-' }}</td>
            @endif
            @endforeach

            <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                <span class="d-flex justify-content-center" style="overflow: visible; position: relative; width: 110px;">
                    {{-- <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{route('salesGathering.edit',[$company,$item])}}"><i class="fa fa-pen-alt"></i></a> --}}
                    <form class="kt-portlet__body" method="post" action="{{route('salesGathering.destroy',[$company,$item->id])}}" style="display: inline">
                        @method('DELETE')
                        @csrf
                        @if ($modelName == 'CustomerInvoice')
                        <a class="btn btn-secondary btn-outline-hover-primary btn-icon" title="Money Receive" href="{{route('create.money.receive',['company'=>$company->id,'model'=>$item->id ])}}"><i class="fa fa-book"></i></a>
                        @endif
                        <a class="btn btn-secondary btn-outline-hover-primary btn-icon" title="Edit" href="{{route('edit.sales.form',['company'=>$company->id,'model'=>$modelName , 'modelId'=>$item->id])}}"><i class="fa fa-edit"></i></a>
                        <button type="submit" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href=""><i class="fa fa-trash-alt"></i></button>
                    </form>
                    {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon" href="{{route('adjustedCollectionDate.create',[$company])}}" title="Adjusted Collection Date" href=""><i class="fa fa-sliders-h"></i></a> --}}
                </span>
            </td>
        </tr>

        @endforeach
        @endslot
    </x-table>
</form>
<div class="kt-portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label d-flex justify-content-start">
            {{ $salesGatherings->links() }}
        </div>
    </div>
</div>
@if($user->can('upload sales gathering data'))
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__("Instructions")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p class="pop-up-font">
                    <b> 1. Click on Template Download button </b>
                </p>
                <p class="pop-up-font">
                    <b> 2. Select the fields that suits your sales data structure </b>
                </p>
                <p class="pop-up-font">
                    <b> 3. Click download </b>
                </p>
                <p class="pop-up-font">
                    <b> 4. Fill your excel template </b>
                </p>
                <p class="pop-up-font">
                    <b> 5. Click Upload Data, choose your excel file then select date format finally click save </b>
                </p>
                <p class="pop-up-font">
                    <b> 6. Review your data, and then click Save Table </b>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
@include('js_datatable')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<script>
    $(document).on('click', '#open-instructions', function(e) {
        e.preventDefault();
        $('#kt_modal_2').modal('show');
    })

    $('#select_all').change(function(e) {
        if ($(this).prop("checked")) {
            $('.rows').prop("checked", true);
        } else {
            $('.rows').prop("checked", false);
        }
    });
    $(function() {
        $("td:not(.not-editable)").dblclick(function() {
            var OriginalContent = $(this).text();
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");
                }
            });
            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
            $(this).find('input').dblclick(function(e) {
                e.stopPropagation();
            });
        });
    });








  window.addEventListener('scroll', function() {
                            const top = window.scrollY > 140 ? window.scrollY + 210 : 250;

                            $('.arrow-nav').css('top', top + 'px')
                        })
                        if ($('div.kt-portlet__body').length) {

                            $('div.kt-portlet__body').append(`
								<i class="cursor-pointer text-dark arrow-nav  arrow-left fa fa-arrow-left"></i>
								<i class="cursor-pointer text-dark arrow-nav arrow-right fa  fa-arrow-right"></i>
								`)

						
                            $(document).on('click', '.arrow-nav', function() {
                                const scrollLeftOfTableBody = document.querySelector('.kt-portlet__body').scrollLeft
                                const scrollByUnit = 500
                                if (this.classList.contains('arrow-right')) {
                                    document.querySelector('.dataTables_scrollBody').scrollLeft += scrollByUnit

                                } else {
                                    document.querySelector('.dataTables_scrollBody').scrollLeft -= scrollByUnit

                                }
                            })
							
							window.dispatchEvent(new Event('scroll'));

                        }
				
						
</script>


@endsection
