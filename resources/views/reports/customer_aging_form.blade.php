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
{{ __('Customer Aging Form') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{ route('result.customer.aging.analysis',['company'=>$company->id ]) }}" enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet" style="overflow-x:hidden">

                <div class="kt-portlet__body">
                


                    <div class="form-group row">
					
					 <div class="col-md-3">
                            <label>{{ __('Aging Date') }} <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <input type="date" class="form-control" name="again_date" value="{{ now() }}">
                                </div>
                            </div>
                        </div>
						
						
						<div class="col-md-3">
                            <label>{{ __('Select Business Unit') }} <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="business_units">
                                    <select data-live-search="true" data-actions-box="true" name="business_units[]" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select ajax-business-unit" multiple>
                                         @foreach($businessUnits as $businessUnit)
                                        <option value="{{ $businessUnit }}"> {{ __($businessUnit) }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                        </div>
						
						 <div class="col-md-3">
                            <label>{{ __('Select Currency') }}   </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="currencies">
                                    <select  data-live-search="true" data-actions-box="true" name="currencies[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name" >
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>{{ __('Select Customers') }} <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="customers">
                                    <select data-live-search="true" data-actions-box="true" name="customers[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select ajax-customer-name" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
						
						     
						
						
						
						
						
                <x-submitting />
						
						
						
				
						
                        
						
                    </div>

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
<script>
	$('select.ajax-business-unit').on('change',function(){
		const businessUnits = $(this).val();

		$.ajax({
			url:"{{ route('get.currencies.from.business.units',['company'=>$company->id]) }}",
			data:{
				businessUnits
			},
			type:'get'
		}).then(function(res){
			let select = '<select  data-live-search="true" data-actions-box="true" name="currencies[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name"  > ';
			const currencies = res.data.currencies ;
			let options = '';
			for(index in currencies  ){
				options += '<option value="'+ currencies[index].currency +'">'+ currencies[index].currency +'</option>'
			}
			select = select + options  +  ' </select>';
			$('#currencies').empty().append(select);
			reinitializeSelect2()

		})
	})
	
	$(document).on('change','select.ajax-currency-name',function(){
		const businessUnits = $('select.ajax-business-unit').val();
		const currencies = $(this).val();

		$.ajax({
			url:"{{ route('get.customers.from.business.units.currencies',['company'=>$company->id]) }}",
			data:{
				businessUnits,
				currencies
			},
			type:'get'
		}).then(function(res){
			let select = '<select data-live-search="true" data-actions-box="true" name="customers[]" required class="form-control kt-bootstrap-select select2-select kt_bootstrap_select ajax-customer-name" multiple > ';
			const customersInvoices = res.data.customer_names ;
			console.log(customersInvoices);
			let options = '';
			for(index in customersInvoices  ){
				options += '<option value="'+ customersInvoices[index].customer_name +'">'+ customersInvoices[index].customer_name +'</option>'
			}
			select = select + options  +  ' </select>';
			console.log(select);
			$('#customers').empty().append(select);
			reinitializeSelect2()

		})
	})
	
</script>
@endsection
