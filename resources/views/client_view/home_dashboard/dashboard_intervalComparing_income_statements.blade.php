@extends('layouts.dashboard')
@section('dash_nav')
@include('client_view.home_dashboard.main_navs-income-statement',['active'=>'interval_dashboard'])

@endsection
@section('css')
<link href="{{ url('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />


<style>
    .modal-backdrop {
        display: none !important;
    }

    .main-with-no-child {
        background-color: rgb(238, 238, 238) !important;
        font-weight: bold;
    }

    .is-sub-row td.sub-text-bg {
        background-color: #aedbed !important;
        color: black !important;

    }

    .sub-numeric-bg {
        text-align: center;

    }

    .is-sub-row td.sub-numeric-bg,
    .is-sub-row td.sub-text-bg {
        background-color: #0e96cd !important;
        color: white !important;

    }

    .header-tr {
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


<style>
    table {
        white-space: nowrap;
    }

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
        <form action="{{route('dashboard.intervalComparing.incomeStatement',$company)}}" method="POST">
            @csrf
            <div class="form-group row ">
                <div class="col-md-3">
                    <label style="margin-right: 10px;"><b>{{__('Comparing Types')}}</b></label>
                </div>
                <div class="col-md-9">
                    <div class="input-group date">
                        <select data-actions-box="true" data-live-search="true" data-max-options="0" name="types[]" required class="form-control select2-select form-select form-select-2 form-select-solid fw-bolder select-all" multiple>
                            {{-- <option disabled value="0
                                            ">{{ __('Types (Two Options As Maxium)') }}</option> --}}
                            @foreach ($permittedTypes as $id=>$name)
                            <option value="{{ $id }}" @if(in_array($id , $selectedTypes )) selected @endif> {{ $name }} </option>
                            {{-- <option value="{{ $name }}"> {{ __($zone) }}</option> --}}
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
            <div class="form-group row ">

                <div class="col-md-3">
                    <label><b>{{__('First Inteval')}}</b></label>
                </div>
                <div class="col-md-3">
                    <label>{{__('Income Statement')}}</label>

                    <select data-live-search="true" data-max-options="2" name="income_statement_first_interval" required class="form-control select2-select form-select form-select-2 form-select-solid fw-bolder" {{-- multiple --}}>
                        @foreach($incomeStatements as $incomeSatatement)
                        <option value="{{ $incomeSatatement->id }}" @if($firstIncomeStatement->id == $incomeSatatement->id ) selected @endif > {{ $incomeSatatement->name  }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-3">
                    <label>{{__('Start Date One')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="start_date_one" required value="{{$start_date_0}}" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>{{__('End Date One')}}</label>
                    <div class="kt-input-icon">
                        <div class="input-group date">
                            <input type="date" name="end_date_one" required value="{{$end_date_0}}" max="{{date('Y-m-d')}}" class="form-control" placeholder="Select date" />
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <label>{{__('Note')}} </label>
                <div class="kt-input-icon">
                    <div class="input-group ">
                        <input type="text" class="form-control" disabled value="{{__('The Report Will Show Max Top 50')}}">
                    </div>
                </div>
            </div> --}}
    </div>
    <div class="form-group row ">
        <div class="col-md-3">
            <label><b>{{__('Second Inteval')}}</b></label>
        </div>
        <div class="col-md-3">
            <label>{{__('Income Statement')}}</label>
            <select data-live-search="true" data-max-options="2" name="income_statement_second_interval" required class="form-control select2-select form-select form-select-2 form-select-solid fw-bolder" {{-- multiple --}}>
                @foreach($incomeStatements as $incomeStatement)
                <option value="{{ $incomeStatement->id }}" @if($secondIncomeStatement->id == $incomeStatement->id ) selected @endif > {{ $incomeStatement->name }}</option>
                @endforeach

            </select>

        </div>
        <div class="col-md-3">
            <label>{{__('Start Date Two')}}</label>
            <div class="kt-input-icon">
                <div class="input-group date">
                    <input type="date" name="start_date_two" required value="{{$start_date_1}}" class="form-control" placeholder="Select date" />
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label>{{__('End Date Two')}}</label>
            <div class="kt-input-icon">
                <div class="input-group date">
                    <input type="date" name="end_date_two" required value="{{$end_date_1}}" max="{{date('Y-m-d')}}" class="form-control" placeholder="Select date" />
                </div>
            </div>
        </div>



        {{-- <div class="col-md-3">
                    <label>{{__('Data Type')}} </label>
        <div class="kt-input-icon">
            <div class="input-group ">
                <input type="text" class="form-control" disabled value="{{__('Value')}}">
            </div>
        </div>
    </div> --}}
</div>



{{-- <div class="form-group row ">
                <div class="col-md-3">
                    <label><b>{{__('Third Inteval')}}</b></label>
</div>
<div class="col-md-3">
    <label>{{__('Start Date Three')}}</label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input type="date" name="start_date_three" required value="{{$start_date_2}}" class="form-control" placeholder="Select date" />
        </div>
    </div>
</div>
<div class="col-md-3">
    <label>{{__('End Date Three')}}</label>
    <div class="kt-input-icon">
        <div class="input-group date">
            <input type="date" name="end_date_three" required value="{{$end_date_2}}" max="{{date('Y-m-d')}}" class="form-control" placeholder="Select date" />
        </div>
    </div>
</div>



<div class="col-md-3">
    <label>{{__('Data Type')}} </label>
    <div class="kt-input-icon">
        <div class="input-group ">
            <input type="text" class="form-control" disabled value="{{__('Value')}}">
        </div>
    </div>
</div>
</div> --}}

<x-submitting />
</form>
</div>
</div>

{{-- Title --}}
{{-- <div class="row">
    <div class="kt-portlet ">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        {{__('Products Items Sales Interval Comparing Analysis')}}
</h3>
</div>
</div>
</div>
</div> --}}

{{-- FIRST CARD --}}
<div class="row">




    <div class="row w-100" {{-- style="order:{{ ++$i }}" --}}>
        {{--
          <div style="width:100%" class=" text-center mt-3 mb-3">
                        <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary " style="text-transform: capitalize">
                                    <b>{{ (ucfirst(str_replace('_',' ' ,$theType))) . ' IncomeStatement Interval Comparing Analysis ' }}</b>
        </h3>
    </div>
</div>
</div>
</div> --}}
{{-- {{ dd($intervalComparing) }} --}}
{{-- {{ dd($intervalComparing) }} --}}
<div class="col-md-12
            ">
    <div class="kt-portlet kt-portlet--mobile">

        {{-- @include('interval_date' , ['k'=>$k % 2 ]) --}}

        <div class="kt-portlet__body dataTables_wrapper dt-bootstrap4 no-footer">
            <table class="table table-striped- table-bordered table-hover table-checkable position-relative table-with-two-subrows main-table-class dataTable no-footer">
                <thead>
                    <tr class="header-tr ">
                        <th class="text-center view-table-th header-th sorting_disabled sub-text-bg text-nowrap editable editable-text is-name-cell">#</th>
                        <th class="text-center view-table-th header-th sorting_disabled sub-text-bg text-nowrap editable editable-text is-name-cell">Name</th>
                        {{-- {{ dd() }} --}}
                        @foreach ($intervals as $intervalName )
                        <th class="text-center view-table-th header-th sorting_disabled sub-text-bg text-nowrap editable editable-text is-name-cell"> {{ __('Value') }} ({{ getIntervalFromString($intervalName) }})</th>
                        @endforeach
                        <th class="text-center view-table-th header-th sorting_disabled sub-text-bg text-nowrap editable editable-text is-name-cell">{{ __('Variance') }}</th>
                        <th class="text-center view-table-th header-th sorting_disabled sub-text-bg text-nowrap editable editable-text is-name-cell">{{ __('Percentage') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($intervalComparing as $theType => $intervals)

                    <tr class="sub-numeric-bg text-nowrap" data-model-id="{{ str_replace(['#','/',' ' ,'(',')','&','%','$'] , '-',$theType) }}">
                        <td class=" reset-table-width trigger-child-row-1 cursor-pointer sub-text-bg">+</td>
                        <td class="sub-text-bg text-nowrap is-name-cell text-left" style="text-align: left !important;">{{ $theType }}</td>
                        @php
                        $currentValue =[ ]
                        @endphp
                        @foreach ($intervals as $intervalName => $data )
                        @php
                        $currentValue[] = sum_all_keys($intervalComparing[$theType][$intervalName]) ;
                        @endphp
                        <td class="sub-numeric-bg text-nowrap "> {{ number_format( sum_all_keys($intervalComparing[$theType][$intervalName]) ) }} </td>
                        @endforeach
                        @php
                        $val = $currentValue[1] - $currentValue[0] ;
                        @endphp
                        <td class="sub-numeric-bg text-nowrap ">{{ number_format($val)  }}</td>
                        <td class="sub-numeric-bg text-nowrap ">
                            {{ isset($currentValue[0]) && $currentValue[0] ? number_format($val/ $currentValue[0] * 100    , 2) . ' %' : number_format(0,2). ' %' }}
                        </td>

                    </tr>
                    @php
                    $currentValue=[];
                    @endphp
                    {{-- {{ dd($intervalComparing) }} --}}

                    {{-- @foreach ($intervalComparing[$theType][$intervalName] as $subItemName => $subItemValue  ) --}}
                    {{-- {{ dd($subItemName , $subItemValue) }} --}}
                    @foreach(getSubItemsNames($intervalComparing[$theType]) as $subItemName=>$values )
                    <tr class="edit-info-row add-sub maintable-1-row-class{{ str_replace(['#','/',' ' ,'(',')','&','%','$'] , '-',$theType) }} is-sub-row even d-none">
                        <td class="sub-text-bg text-nowrap editable editable-text is-name-cell"> </td>
                        <td class="sub-text-bg text-nowrap editable editable-text is-name-cell">{{ $subItemName }}</td>
                        @php
                        $currentValues =[];
                        @endphp
                        @foreach($intervals as $newIntervalName => $intervalValue)
                        @php
                        $salesValue = $values[$newIntervalName] ?? 0;
                        $currentValues[] = $salesValue ;
                        @endphp
                        <td class=" sub-numeric-bg sub-text-bg text-nowrap editable editable-text is-name-cell"> {{ number_format($salesValue) }} </td>
                        @endforeach
                        <td class="sub-numeric-bg   text-nowrap editable editable-text is-name-cell">
                            @php
                            $val = $currentValues[1] - $currentValues[0] ;
                            @endphp
                            {{ number_format($val ) }}
                        </td>
                        <td class="sub-numeric-bg   text-nowrap editable editable-text is-name-cell">
                            {{ isset($currentValues[0]) && $currentValues[0] ? number_format($val/ $currentValues[0] *100 , 2)  . ' %' : number_format(0,2). ' %' }}
                        </td>
                        @endforeach


                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- @endforeach --}}





</div>


@endsection
@section('js')

<script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>

<script src="{{ url('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
<script>
    reinitializeSelect2();

</script>
<script>
    $(document).on('click', '.trigger-child-row-1', function(e) {
        const parentId = $(e.target.closest('tr')).data('model-id');
        var parentRow = $(e.target).parent();
        var subRows = parentRow.nextAll('tr.add-sub.maintable-1-row-class' + parentId);

        subRows.toggleClass('d-none');
        if (subRows.hasClass('d-none')) {
            parentRow.find('td.trigger-child-row-1').html('+');
        } else if (!subRows.length) {
            // if parent row has no sub rows then remove + or - 
            parentRow.find('td.trigger-child-row-1').html('×');
        } else {
            parentRow.find('td.trigger-child-row-1').html('-');
        }

    });

</script>

@endsection