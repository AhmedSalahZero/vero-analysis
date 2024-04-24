@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
.kt-portlet{
	overflow:visible !important ;
}
</style>
@endsection
@section('sub-header')
{{ __('Weekly Cash Flow Report') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{ route('result.weekly.cashflow.report',['company'=>$company->id ]) }}" enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet" style="overflow-x:hidden">

                <div class="kt-portlet__body">
                


                    <div class="form-group row">
					
					 <div class="col-md-3">
                            <label>{{ __('Start Date') }} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="start_date">
                                    <input type="date" class="form-control" name="start_date" value="{{ now() }}">
                                </div>
                            </div>
                        </div>
						
						
							 <div class="col-md-3">
                            <label>{{ __('End Date') }}</span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="end_date">
                                    <input type="date" class="form-control" name="end_date" value="{{ now() }}">
                                </div>
                            </div>
							
                        </div>
						
						 <div class="col-md-3">
        <label>{{__('Select Currency')}} <span class="required">*</span></label>

        <div class="kt-input-icon">
            <div class="input-group date">
                <select name="currency" class="form-control current-currency ajax-get-invoice-numbers">
                    <option value="" selected>{{__('Select')}}</option>
                    @foreach(isset($currencies) ? $currencies : getBanksCurrencies () as $currencyId=>$currentName)
								@php
									$selected = isset($model) ?  $model->getCurrency()  == $currencyId  :  $currentName == $company->getMainFunctionalCurrency() ;
									$selected = $selected ? 'selected':'';
								@endphp
                                <option  {{ $selected }} value="{{ $currencyId }}">{{ touppercase($currentName) }}</option>
                                @endforeach
                </select>
            </div>
        </div>
    </div>
	
						
						
						
						{{-- <div class="col-md-4">
                            <label>{{ __('Cash Beginning Balance') }}  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_persons">
                                   <input type="text" class="only-greater-than-zero-allowed form-control" name="cash_beginning_balance" value="0" >
                                </div>
                            </div>
                        </div> --}}
						

                 
						
						
						
						
						
						
						
				
						
                        
						
                    </div>
                <x-submitting />

                </div>
                {{-- @dd($name_of_selector_label) --}}
            </div>





        </form>

        <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>
{{-- @dd(get_defined_vars()) --}}
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
