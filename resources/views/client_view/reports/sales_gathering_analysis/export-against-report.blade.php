@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('sub-header')
{{ __($view_name) }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{ route('result.export.against.report',['company'=>$company->id ]) }}" enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet" style="overflow-x:hidden">

                @php
                $column = 6 ;

                @endphp

                <input type="hidden" name="type" value="{{$secondColumn}}">
                {{-- <input type="hidden" name="view_name" value="{{$view_name}}"> --}}
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label>{{ __('Data Type') }} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="data_type" id="data_type" class="form-control">

                                        <option selected value="value">{{ __('Value') }}</option>
                                        <option value="quantity">{{ __('Quantity') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label>{{ __('Report Type') }} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="report_type" id="report_type" class="form-control ">
                                        <option selected value="trend">{{ __('Trend') }}</option>
                                        <option value="comparing">{{ __('Interval Comparing') }}</option>

                                    </select>
                                </div>
                            </div>
                        </div>


                       	<div class="col-md-4">
                            <label>{{ __('Select Revenue Streams') }} <span class="multi_selection"></span> @include('max-option-span') </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select data-live-search="true" data-actions-box="true" name="revenue_streams[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                        @foreach($revenueStreams as $revenueStream)
                                        {{-- need to be removed to be by ajax --}}
                                        <option value="{{ $revenueStream }}"> {{ __($revenueStream) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>




                        @push('js')

                        <script>
                            $(function() {
                                $('#report_type').on('change', function() {
                                    let reportType = $(this).val();
                                    $('#comparing__id').remove();
                                    $('select[name="interval"]').closest('div[class*="col-"]').removeClass('d-none');
                                    $('select[name="interval"]').attr('required', 'required');

                                    if (reportType == 'comparing') {
                                        $('select[name="interval"]').closest('div[class*="col-"]').addClass('d-none');
                                        $('select[name="interval"]').removeAttr('required');
                                        let clonedField = $('input[name="start_date"]').closest('.row').clone(true);

                                        $(clonedField).find('input').each(function(index, inputField) {
                                            if ($(inputField).attr('type') == 'date') {
                                                var currentValue = $(inputField).attr('value');
                                                if (currentValue) {
                                                    var year = currentValue.split('-')[0] - 1;
                                                    var month = currentValue.split('-')[1];
                                                    var day = currentValue.split('-')[2];

                                                    $(inputField).attr('value', year + '-' + month + '-' + day);

                                                }

                                            }
                                            $(inputField).attr('name', $(inputField).attr('name') + '_second');
                                        })
                                        $(clonedField).find('label.first-interval').each(function(index, inputField) {
                                            $(inputField).html("{{ __('Second Interval') }}");
                                            $(inputField).removeClass('first-interval').addClass('d-block')
                                            $(inputField).addClass('second-interval').addClass('d-block')

                                        })
                                        if (clonedField.length) {

                                            let div = $('<div id="comparing__id"></div>');
                                            $('input[name="start_date"]').closest('.row').after(div);
                                            // alert($(document).find('#comparing__id').length);
                                            $('#comparing__id').empty();
                                            $('#comparing__id').append(clonedField);

                                            $('label.first-interval').closest('div.first-interval').removeClass('d-none').addClass('d-block')
                                            $('label.second-interval').closest('div.first-interval').removeClass('d-none').addClass('d-block')
                                            $('input[type="date"]').trigger('change')

                                        }
                                    } else {
                                        $('label.first-interval').closest('div.first-interval').addClass('d-none').removeClass('d-block')
                                        $('label.second-interval').closest('div.first-interval').addClass('d-none').removeClass('d-block')
                                    }
                                });
                                $('#report_type').trigger('change');
                            })

                        </script>

                        @endpush


                        {{-- @include('comparing_type_selector') --}}

                    </div>


                    <div class="form-group row">
                        @if(isset(get_defined_vars()['__data']['type']) && get_defined_vars()['__data']['type'] !='averagePrices')
                        <div class="col-md-4  first-interval">
                            <label></label>
                            <div class="flex-center "><label class="first-interval">{{ __('First Interval') }}</label></div>

                        </div>
                        @endif

                        <div class="col-md-4">
                            <label>{{ __('Start Date') }}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="start_date" value="{{ getEndYearBasedOnDataUploaded($company)['jan'] }}" required class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('End Date') }}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="end_date" required value="{{ getEndYearBasedOnDataUploaded($company)['dec'] }}" class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('Select Interval') }} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="interval" required class="form-control">
                                        <option value="" selected>{{ __('Select') }}</option>
                                        {{-- <option value="daily">{{ __('Daily') }}</option> --}}
                                        <option value="monthly">{{ __('Monthly') }}</option>
                                        <option value="quarterly">{{ __('Quarterly') }}</option>
                                        <option value="semi-annually">{{ __('Semi-Annually') }}</option>
                                        <option value="annually">{{ __('Annually') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">

                            <label>{{ __('Select ' . $firstColumnViewName) }} @include('max-option-span') </label>




                            <input type="hidden" name="firstColumnName" value="{{ $firstColumn }}">
                            <input type="hidden" name="secondColumnName" value="{{ $secondColumn }}">
                            <input type="hidden" id="append-to" value="firstColumnData">

                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="firstColumnData[]" required data-live-search="true" data-actions-box="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" id="firstColumnData" multiple>
                                        {{-- <option value="{{ json_encode($firstColumnData) }}">{{ __('All Categories') }}</option> --}}
                                        @foreach ($firstColumnData as $firstColumnItemName)
                                        <option value="{{ $firstColumnItemName }}"> {{ __($firstColumnItemName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label>{{ __('Select '.$secondColumnViewName.' ') }} <span class="multi_selection"></span> @include('max-option-span') </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <select data-live-search="true" data-actions-box="true" name="secondColumnData[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                        @foreach($secondColumnData as $secondColumnItemName)
                                        {{-- need to be removed to be by ajax --}}
                                        <option value="{{ $secondColumnItemName }}"> {{ __($secondColumnItemName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						
						
						
						
						<div class="col-md-4">
                            <label>{{ __('Select Currency') }} <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select data-live-search="true" data-actions-box="true" name="currency" required class="form-control kt-bootstrap-select  kt_bootstrap_select" >
                                        @foreach($currencies as $currency)
                                        {{-- need to be removed to be by ajax --}}
                                        <option value="{{ $currency }}"> {{ __($currency) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						
                        
						
                    </div>

                </div>
                <x-submitting />
            </div>





        </form>

        <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>
@endsection
@section('js')
<!--begin::Page Scripts(used by this page) -->
<script src="{{ url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript">
</script>
<script src="{{ url('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}
@endsection
