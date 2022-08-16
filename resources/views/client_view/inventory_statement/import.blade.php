@extends('layouts.dashboard')
@section('css')
    <link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        table {
            white-space: nowrap;
        }

        .bg-table-head {
            background-color: #075d96;
            color: white !important;
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{ __('Inventory Statement') }}
                        </h3>
                    </div>
                </div>
            </div>


            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" method="POST"
                action={{ route('inventoryStatementImport',$company) }} enctype="multipart/form-data">
                @csrf
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                {{ __('Inventory Statement Import') }}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>{{ __('Import File') }} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="file" name="excel_file" class="form-control"
                                        placeholder="{{ __('Import File') }}">
                                    <x-tool-tip title="{{ __('Kash Vero') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>{{ __('Date Formatting') }} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <select name="format" class="form-control" required>
                                        <option value="">{{__('Select')}}</option>
                                        <option value="d-m-Y" >{{__('Day-Month-Year')}}</option>
                                        <option value="m-d-Y">{{__('Month-Day-Year')}}</option>
                                        <option value="Y-m-d" >{{__('Year-Month-Day')}}</option>
                                        <option value="Y-d-m">{{__('Year-Day-Month')}}</option>
                                    </select>
                                    <x-tool-tip title="{{ __('Kash Vero') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <x-custom-button-name-to-submit :displayName="__('Upload')" />

            </form>
            <!--end::Form-->
            <form action="{{ route('multipleRowsDelete', [$company, 'InventoryStatementTest']) }}" method="POST">
                @csrf
                <x-table :tableTitle="__('Inventory Statement Test Table')"
                    :href="route('inventoryStatementTest.insertToMainTable',$company)" :icon="__('file-import')"
                    :firstButtonName="__('Save Data')" :tableClass="'kt_table_with_no_pagination'"
                    :truncateHref="route('truncate',[$company,'InventoryStatementTest'])">
                    @slot('table_header')
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <label class="kt-option bg-secondary">
                                        <span class="kt-option__control">
                                            <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                checked>
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
                                                    <i class="fas fa-trash-alt"></i>
                                                    {{ __('Delete Selected Rows') }}
                                                </button>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <tr class="table-active text-center">
                            <th>Select To Delete </th>
                            @foreach ($viewing_names as $name)
                                <th>{{ __($name) }}</th>
                            @endforeach
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    @endslot
                    @slot('table_body')
                        @foreach ($inventoryStatements as $item)
                            <tr>
                                <td class="text-center">
                                    <label class="kt-option">
                                        <span class="kt-option__control">
                                            <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                checked>
                                                <input class="rows" type="checkbox" name="rows[]" value="{{ $item->id }}">
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="kt-option__label">
                                            <span class="kt-option__head">

                                            </span>
                                            {{-- <span class="kt-option__body">
                                            {{ __('This Section Will Be Added In The Client Side') }}
                                        </span> --}}
                                        </span>
                                    </label>
                                </td>
                                @foreach ($db_names as $name)
                                    @if ($name == 'date')
                                        <td class="text-center">
                                            {{ isset($item->$name) ? date('d-M-Y', strtotime($item->$name)) : '-' }}</td>
                                    @else
                                        <td class="text-center">{{ $item->$name ?? '-' }}</td>
                                    @endif
                                @endforeach

                                <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                    data-autohide-disabled="false">
                                    <span class="d-flex justify-content-center"
                                        style="overflow: visible; position: relative; width: 110px;">
                                        {{-- <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit"
                                            href="{{ route('inventoryStatement.edit', [$company, $item]) }}"><i
                                                class="fa fa-pen-alt"></i></a> --}}
                                        <form method="post" action="{{ route('inventoryStatement.destroy', [$company, $item->id]) }}"
                                            style="display: inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-outline-hover-danger btn-icon"
                                                title="Delete" href=""><i class="fa fa-trash-alt"></i></button>
                                        </form>
                                        {{-- <a type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon"
                                            href="{{ route('adjustedCollectionDate.create', [$company]) }}"
                                            title="Adjusted Collection Date" href=""><i class="fa fa-sliders-h"></i></a> --}}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endslot
                </x-table>
            </form>
            <!--end::Portlet-->
        </div>
        <div class="kt-portlet text-center">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label d-flex justify-content-start">
                   {{ $inventoryStatements->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript">
    </script>
    <script>
        $('#select_all').change(function(e) {
            if ($(this).prop("checked")) {
                $('.rows').prop("checked", true);
            } else {
                $('.rows').prop("checked", false);
            }
        });
        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                $(this).addClass("cellEditing");
                $(this).html("<input type='text' value='" + OriginalContent + "' />");
                $(this).children().first().focus();
                $(this).children().first().keypress(function (e) {
                    if (e.which == 13) {
                        var newContent = $(this).val();
                        $(this).parent().text(newContent);
                        $(this).parent().removeClass("cellEditing");
                    }
                });
            $(this).children().first().blur(function(){
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
                $(this).find('input').dblclick(function(e){
                    e.stopPropagation();
                });
            });
        });
    </script>
@endsection
