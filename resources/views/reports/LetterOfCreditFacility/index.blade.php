@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 200px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style) {
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Letter Of Credit Facility ['. $financialInstitution->getName() . ' ]')  }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lc nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == 'letter-of-credit-facilities' ?'active':'' }}" data-toggle="tab" href="#letter-of-credit-facilities" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Letter Of Credit Facility Table') }}
                    </a>
                </li>

            </ul>

            <div class="flex-tabs">
                <a href="{{ route('create.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id]) }}" class="btn  active-style btn-icon-sm align-self-center">
                    <i class="fas fa-plus"></i>
                    {{ __('New Record') }}
                </a>

            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active') || Request('active') == 'letter-of-credit-facilities' ?'active':'' }}" id="bank" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lc p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Letter Of Credit Facility Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-letter-of-credit-facility :financialInstitution="$financialInstitution" :search-fields="$searchFields" :money-received-type="'letter-of-credit-facilities'" :has-search="1" :has-batch-collection="0" href="{{route('create.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])}}" />
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Limit') }}</th>
                                    <th>{{ __('Outstanding Amount') }}</th>
                                    <th>{{ __('Terms') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($letterOfCreditFacilities as $index=>$letterOfCreditFacility)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td class="text-nowrap">{{ $letterOfCreditFacility->getContractStartDateFormatted() }}</td>
                                    <td class="text-nowrap">{{ $letterOfCreditFacility->getContractEndDateFormatted() }}</td>
                                    <td class="text-uppercase">{{ $letterOfCreditFacility->getCurrency() }}</td>
                                    <td class="text-transform">{{ $letterOfCreditFacility->getLimitFormatted() }}</td>
                                    <td class="text-transform">{{ $letterOfCreditFacility->getOutstandingAmountFormatted() }}


                                    </td>
                                    <td>









                                        <button data-toggle="modal" data-target="#letter_of_credit_terms_and_conditions{{ $letterOfCreditFacility->id }}" type="button" class="btn btn-outline-brand btn-elevate btn-pill"><i class="fa fa-tag"></i> Click Here</button>

                                        <div class="modal fade " id="letter_of_credit_terms_and_conditions{{ $letterOfCreditFacility->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                <form action="#" class="modal-content" method="post">


                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color:#0741A5 !important">{{ __('LCs Terms And Conditions') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="customize-elements">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">{!! __('LC Type') !!} </th>
                                                                        <th class="text-center">{!! __('Cash Cover') !!} </th>
                                                                        <th class="text-center"> {!! __('Commission %') !!} </th>
                                                                        {{-- <th class="text-center">{{ __('Commission Interval') }}</th> --}}
                                                                        <th class="text-center"> {!! __('Min Commission Fees') !!} </th>
                                                                        <th class="text-center"> {!! __('Issuance Fees') !!} </th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    @foreach($letterOfCreditFacility->termAndConditions as $termAndCondition)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" step="0.1" class="form-control" value="{{ $termAndCondition->getLcTypeFormatted() }}">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="{{  $termAndCondition->getCashCoverRate() . ' %' }}">
                                                                                </div>
                                                                            </div>
                                                                        </td>


                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="{{ $termAndCondition->getCommissionRate() . ' %' }}">

                                                                                </div>
                                                                            </div>
                                                                        </td>



                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="{{ number_format($termAndCondition->getMinCommissionFees())  }}">

                                                                                </div>
                                                                            </div>
                                                                        </td>


                                                                        <td>
                                                                            <div class="kt-input-icon">
                                                                                <div class="input-group">
                                                                                    <input disabled type="text" class="form-control text-center" value="{{ number_format($termAndCondition->getIssuanceFees())  }}">
                                                                                </div>
                                                                            </div>
                                                                        </td>





                                                                    </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary " data-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </td>

                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">




                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'letterOfCreditFacility'=>$letterOfCreditFacility->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $letterOfCreditFacility->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $letterOfCreditFacility->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.letter.of.credit.facility',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'letterOfCreditFacility'=>$letterOfCreditFacility]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-danger">{{ __('Confirm Delete') }}</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>










            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
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
<script>

</script>
<script>


</script>



{{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/validation/form-widgets.js') }}" type="text/javascript">
</script> --}}

{{-- <script>
    $(function() {
        $('#firstColumnId').trigger('change');
    })

</script> --}}

<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'contract_start_date') {
            modal.find('.data-type-span').html('[ {{ __("Contract Start Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ {{ __("Contract End Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ {{ __("Balance Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ {{ __("Contract Start Date") }} ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
@endsection
@push('js')
<script>
    $(document).on('change', '.recalculate-amount-in-main-currency', function() {
        const parent = $(this).closest('.modal-body');
        const amount = parseFloat($(parent).find('.amount-js').val())
        const exchangeRate = parseFloat($(parent).find('.exchange-rate-js').val())
        const amountInMainCurrency = parseFloat(amount * exchangeRate);
        $(parent).find('.amount-in-main-currency-js-hidden').val(amountInMainCurrency)
        $(parent).find('.amount-in-main-currency-js').val(number_format(amountInMainCurrency))
    })

</script>
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
