@extends('layouts.dashboard')
@section('css')
<link href="{{url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('sub-header')
{{-- {{}} --}}
{{ __('Invoices Against ') . __(spaceAfterCapitalLetters(camelize($type))) . __(' Sales Analysis')  }}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action={{ route('invoices.sales.analysis.result',$company) }} enctype="multipart/form-data">
            <input type="hidden" value="{{ $type }}" name="type">
            <input type="hidden" name="view_name" value="{{ $view_name }}">
            @csrf
            <div class="kt-portlet">
                <?php 
                $selects = getTypeFor($type , $company->id , true);
                ?>

                <div class="kt-portlet__body">
                    <div class="form-group row">


                        <div class="col-md-3">
                            <label>{{__('Start Date')}}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="start_date" value="{{ getEndYearBasedOnDataUploaded($company)['jan'] }}" required class="form-control" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
						
                        <div class="col-md-3">
                            <label>{{__('End Date')}}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
								
						
                                    <input  type="date" name="end_date" required value="{{ getEndYearBasedOnDataUploaded($company)['dec'] }}" max="{{getEndYearBasedOnDataUploaded($company)['dec']}}" class="form-control" />
									
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label>{{__('Select') .' '. __(spaceAfterCapitalLetters(camelize($type)) ) }} @include('max-option-span') </label>
                            <div class="kt-input-icon">
                                <div class="input-group date " id="append-main-select">
                                    <select data-live-search="true" data-actions-box="true" data-max-options="{{ maxOptionsForOneSelector() }}" name="branches[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" multiple required>
                                        {{-- <option value="{{json_encode($branches)}}">{{__('All Branches')}}</option> --}}
                                        @foreach ($selects as $select)
                                        <option value="{{$select}}"> {{__($select)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>{{__('Select Interval')}} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="interval" required class="form-control">
                                        <option value="" selected>{{__('Select')}}</option>
                                        {{-- <option value="daily">{{__('Daily')}}</option> --}}
                                        <option value="monthly">{{__('Monthly')}}</option>
                                        <option value="quarterly">{{__('Quarterly')}}</option>
                                        <option value="semi-annually">{{__('Semi-Annually')}}</option>
                                        <option value="annually">{{__('Annually')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <label>{{__('Data Type')}} </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <select name="interval" disabled class="form-control">

                                    <option selected value="value">{{__('Value')}}</option>
                                    <option value="quantity">{{__('Quantity')}}</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
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


<script>

	$(document).on('change','[name="start_date"],[name="end_date"]',function(){
		
		clearTimeout(wto);
		wto = setTimeout(()=>{
		var branches = ['all'] ;
		var type_of_data = "{{ $type }}";
		
		getAnotherSelectValues(branches,type_of_data);			
		},getNumberOfMillSeconds())
		
		

	})
	
	$(function(){
		$('[name="start_date"]').trigger('change');
	})
    function getAnotherSelectValues(branches, type_of_data) {
        if (branches.length) {
            $.ajax({
                type: 'POST'
                , data: {
                    'main_data': branches
                    , 'main_field': 'branch'
                    , 'field': type_of_data
                    , 'start_date': $('input[name="start_date"]').val()
                    , 'end_date': $('input[name="end_date"]').val()
                }
                , url: "{{ route('get.zones.data',$company) }}"
                , dataType: 'json'
                , accepts: 'application/json'

            }).done(function(data) {
                var data_type = 'multiple';

                row = '<select data-live-search="true" data-actions-box="true" name="branches[]" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select" required ' + data_type + '  >\n';


                $.each(data, function(key, val) {
                    row += '<option value*="' + val + '">' + val + '</option>\n';

                });
                row += '</select>';

                $('#append-main-select').html('');
                $('#append-main-select').append(row);
                reinitializeSelect2();
            });
        }

    }

</script>

<!--end::Page Scripts -->
@endsection
