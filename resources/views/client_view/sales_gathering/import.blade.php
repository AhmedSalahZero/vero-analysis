@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
    .table-bordered.table-hover.table-checkable.dataTable.no-footer.fixedHeader-floating {
        display: none
    }

    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>
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
                        {{ __('Sales Gathering') }}
                    </h3>
                </div>
            </div>
        </div>


        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action={{ route('salesGatheringImport', $company) }} enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{ __('Sales Gathering Import') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>{{ __('Import File') }} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <input required type="file" name="excel_file" class="form-control" placeholder="{{ __('Import File') }}">
                                <x-tool-tip title="{{ __('Kash Vero') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Date Formatting') }} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <select name="format" class="form-control" required>
                                    <option value="">{{ __('Select') }}</option>
                                    <option value="d-m-Y">{{ __('Day-Month-Year') }}</option>
                                    <option value="m-d-Y">{{ __('Month-Day-Year') }}</option>
                                    <option value="Y-m-d">{{ __('Year-Month-Day') }}</option>
                                    <option value="Y-d-m">{{ __('Year-Day-Month') }}</option>
                                </select>
                                <x-tool-tip title="{{ __('Kash Vero') }}" />
                            </div>
                        </div>
                    </div>
                    <?php $active_job = App\Models\ActiveJob::where('company_id', $company->id)
                            ->where('status', 'test_table')
                            ->where('model_name', 'SalesGatheringTest')
                            ->first(); ?>
                    @php $active_job_for_saving = App\Models\ActiveJob::where('company_id', $company->id)
                    ->where('status', 'save_to_table')
                    ->where('model_name', 'SalesGatheringTest')
                    ->first(); @endphp
                    @if(! $active_job_for_saving && cache(getShowCompletedTestMessageCacheKey($company->id)) && ! Cache(getCanReloadUploadPageCachingForCompany($company->id)))
                    {{-- @if(! $active_job_for_saving && cache(getShowCompletedTestMessageCacheKey($company->id))) --}}
                    <h4 id="please-review-and-click-save" class="text-center alert alert-info " style="text-transform:capitalize;justify-content:center">{{ __('Please review And Click Save') }}</h4>
                    @endif
                    @if ($active_job)


                    <div class="kt-section__content uploading_div">
                        <label class="text-success text-xl-center"> <b> {{ __('Uploading') }}</b> <span class="required">*</span></label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated  bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <x-custom-button-name-to-submit :displayName="__('Upload')" />

        </form>
        <!--end::Form-->
        <form action="{{ route('deleteMultiRowsFromCaching', [$company]) }}" method="POST">
            {{-- <form action="{{ route('multipleRowsDelete', [$company, 'SalesGatheringTest']) }}" method="POST"> --}}
            @csrf
            @method('DELETE')

            <x-table :tableTitle="__('Sales Gathering Table')" :href="route('salesGatheringTest.insertToMainTable',$company)" :icon="__('file-import')" :firstButtonName="__('Save Data')" :tableClass="'kt_table_with_no_pagination'" :truncateHref="route('deleteAllCaches',[$company,'SalesGatheringTest'])">

                @slot('table_header')

                @if ($active_job_for_saving)
                <div class="row uploading_div_for_saving_data mb-5">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="kt-section__content text-center ">
                            <label id="saving_data" class="text-success text-xl-center"> <b> {{ __('Saving Data') }}</b> <span class="required">*</span></label>
                            <div class="progress ">
                                <div id="progress_id" class="progress-bar progress-bar-striped progress-bar-animated  bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>


                            </div>
                            <span id="percentage_value" style="display: block;margin-top:10px;font-size:1.5rem;color:#1dc9b7 !important;font-weight:bold;"> 0 % </span>
                        </div>
                    </div>
                </div>

                <br>
                @endif
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
                {{-- @dd($salesGatherings) --}}
                @foreach ($salesGatherings->take(20) as $index=> $item)

                {{-- @dd($item) --}}
                <tr>
                    <td class="text-center">
                        <label class="kt-option">
                            <span class="kt-option__control">
                                <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                    <input class="rows" type="checkbox" name="rows[]" value="{{ $item['id'] ?? 0 }}">
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
                        {{ isset($item[$name]) ? date('d-M-Y', strtotime($item[$name])) : '-' }}</td>
                    @else
                    <td class="text-center">{{ $item[$name] ?? '-' }}</td>
                    @endif
                    @endforeach

                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                        <span class="d-flex justify-content-center" style="overflow: visible; position: relative; width: 110px;">
                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" {{-- href="{{ route('salesGatheringTest.edit', [$company, $item]) }}" --}}><i class="fa fa-pen-alt"></i></a>
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
                {{ $salesGatherings->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('js_datatable')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript">
</script>
@if($active_job_for_saving)
<script>
    setInterval(() => {
        if (!$('#please-review-and-click-save').length) {
            $('.kt-portlet__head-actions > a').each((index, a) => {
                $(a).addClass('disabled');
            })
        } else {
            $('.kt-portlet__head-actions > a').each((index, a) => {
                $(a).removeClass('disabled');
            })
        }
    }, 1000);

</script>
@endif
@if ($active_job)
<script>
    var row = '1';
    $(document).ready(function() {

        setInterval(function() {

            $.ajax({
                type: 'GET'
                , data: {
                    'id': "{{ $active_job->id }}"
                }
                , url: "{{ route('active.job', $company) }}"
                , dataType: 'json'
                , accepts: 'application/json'
            }).done(function(data) {

                if (data == '0' && row == '1') {
                    $('.uploading_div').fadeOut(300);
                    location.reload();
                }
                row = data;
            });
        }, 3000);

    });

</script>
@endif


@if ($active_job_for_saving )
<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                type: 'post'
                , url: "/get-uploading-percentage/" + "{{$company->id}}"
                , data: {
                    '_token': "{{csrf_token()}}"
                , },

                success: function(data) {
                    $('#progress_id').css('width', (data.totalPercentage) + '%');
                    $('#percentage_value').html(data.totalPercentage.toFixed(2) + ' %');
                    if (parseFloat(data.totalPercentage) >= 100) {
                        $('#saving_data').html("{{ __('Parsing Data .. Please Wait') }}");
                        Swal.fire(
                            'Done!'
                            , '{{ __("Uploading Proccess Has Completed Successfully !") }}'
                            , 'success'
                        ).then(function() {
                            window.location.href = "{{ route('dashboard',getCurrentCompanyId()) }}"
                        })

                    }
                    // console.log('reload ? ' + data.reloadPage);
                    if (data.reloadPage) {
                        // window.location.reload();
                    }
                }
                , error: function(reject) {}
            });
        }, 5000)
    })
    //     var row = '1';
    //     $(document).ready(function() {

    //         setInterval(function() {

    //             $.ajax({
    //                 type: 'GET',
    //                 data: {
    //                     'id': "{{ $active_job_for_saving->id }}"
    //                 },
    //                 url: '{{ route('active.job', $company) }}',
    //                 dataType: 'json',
    //                 accepts: 'application/json'
    //             }).done(function(data) {

    //                 if (data == '0' && row == '1') {
    //                     $('.uploading_div_for_saving_data').fadeOut(300);
    //                     location.reload();
    //                 }
    //                 row = data;
    //             });
    //         }, 3000);

    //     });
    // 

</script>
@endif

<script>
    $('#select_all').change(function(e) {
        if ($(this).prop("checked")) {
            $('.rows').prop("checked", true);
        } else {
            $('.rows').prop("checked", false);
        }
    });
    $(function() {
        $("td").dblclick(function() {
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

</script>
@endsection
