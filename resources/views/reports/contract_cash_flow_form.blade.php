@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Contract Cash Flow Report') }}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{ route('result.contract.cashflow.report',['company'=>$company->id ]) }}" enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet" style="overflow-x:hidden">

                <div class="kt-portlet__body closest-parent-tr">



                    <div class="form-group row">


                        <div class="col-md-2 mb-3">
                            <label>{{__('Report Interval')}} @include('star')</label>

                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="report_interval" class="form-control " required>
									     <option value="">{{ __('Select') }}</option>
                                        <option value="daily">{{__('Daily')}}</option>
                                        <option value="weekly" >{{__('Weekly')}}</option>
                                        <option value="monthly">{{__('Monthly')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <x-form.select :label="__('Customer')" :pleaseSelect="false"  :selectedValue="isset($currentContract) && $currentContract->client ? $currentContract->client->id : ''" :options="formatOptionsForSelect($clientsWithContracts)" :add-new="false" class="select2-select suppliers-or-customers-js repeater-select  " data-filter-type="{{ 'create' }}" :all="false" name="partner_id"></x-form.select>
                        </div>
                        <div class="col-md-3">
                            <x-form.select :label="__('Contract')" :pleaseSelect="false" data-current-selected="{{ isset($currentContract) ? $currentContract->id : '' }}" :selectedValue="isset($currentContract) ? $currentContract->id : ''" :options="[]" :add-new="false" class="select2-select  contracts-js repeater-select  " data-filter-type="{{ 'create' }}" :all="false" name="contract_id"></x-form.select>
                        </div>



                        <div class="col-md-2">
                            <label>{{__('Contract Code')}} @include('star')</label>
                            <div class="input-group">
                                <input disabled type="text" class="form-control contract-code" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>{{__('Contract Amount')}} @include('star')</label>
                            <div class="input-group">
                                <input disabled type="text" class="form-control contract-amount" value="0">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label>{{__('Contract Start Date')}} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required disabled type="date" value="" class="form-control contract-start-date-class" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('Contract End Date')}} </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required disabled type="date" value="" class="form-control contract-end-date-class" />
                                </div>
                            </div>
                        </div>









                        <div class="col-md-3">
                            <label>{{ __('Report Start Date') }}  @include('star') </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="start_date">
                                    <input required type="date" class="form-control" name="start_date" value="{{ now() }}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label>{{ __('Report End Date') }} @include('star') </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="end_date">
                                    <input required type="date" class="form-control" name="end_date" value="{{ now() }}">
                                </div>
                            </div>

                        </div>



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

<script>
    $(document).on('change', 'select.contracts-js', function() {
        const parent = $(this).closest('.closest-parent-tr')
        const code = $(this).find('option:selected').data('code')
        const amount = $(this).find('option:selected').data('amount')
        const currency = $(this).find('option:selected').data('currency') ? $(this).find('option:selected').data('currency').toUpperCase() : ''
        const startDate = $(this).find('option:selected').data('start-date')
        const endDate = $(this).find('option:selected').data('end-date')
        $(parent).find('.contract-code').val(code)
        $(parent).find('.contract-amount').val(number_format(amount) + ' ' + currency)
        $(parent).find('.contract-start-date-class').val(startDate)
        $(parent).find('.contract-end-date-class').val(endDate)


    })

    $(document).on('change', 'select.suppliers-or-customers-js', function() {
        const parent = $(this).closest('.closest-parent-tr')
        const partnerId = parseInt($(this).val())
        const model = 'Customer'
        let inEditMode = 0;

        $.ajax({
            url: "{{ route('get.contracts.for.customer.or.supplier',['company'=>$company->id]) }}"
            , data: {
                partnerId
                , model
                , inEditMode
            }
            , type: "get"
            , success: function(res) {
                let contracts = '';
                const currentSelected = $(parent).find('select.contracts-js').data('current-selected')
                for (var contract of res.contracts) {
                    contracts += `<option ${currentSelected ==contract.id ? 'selected' :'' } value="${contract.id}" data-code="${contract.code}" data-amount="${contract.amount}" data-start-date="${contract.start_date}" data-end-date="${contract.end_date}" data-currency="${contract.currency}" >${contract.name}</option>`;
                }
                parent.find('select.contracts-js').empty().append(contracts).trigger('change')
            }
        })
    })
    $(function() {
        $('select.suppliers-or-customers-js').trigger('change')
    })

</script>

@endsection
