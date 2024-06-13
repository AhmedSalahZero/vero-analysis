@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
    button[type="submit"],
    button[type="button"] {
        font-size: 1rem !important;

    }

    button[type="submit"] {
        background-color: green !important;
        border: 1px solid green !important;
    }

    .kt-portlet__body {
        padding-top: 0 !important;
    }

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

    input.form-control[disabled] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Unapplied Amount Settlements') }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#eeee" role="tab">
                        <i class="fa fa-money-check-alt"></i>{{ __('Unapplied Amounts Settlements') }}
                    </a>
                </li>



            </ul>

          <div class="flex-tabs">
		    {{-- <a href="#" class="btn  active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                {{ __('New Record') }}
            </a> --}}
		  </div>

        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">
            <!--Begin:: Tab Content-->
            <div class="tab-pane active" id="eeee" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <x-table-title.with-two-dates :title="__('Unapplied Amount')" :startDate="$filterStartDate" :endDate="$filterEndDate">
                        <x-search-unapplied-amounts :partnerId="$partnerId" :search-fields="$searchFields" :money-received-type="'unapplied'" :has-search="1" :has-batch-collection="0" />
                    </x-table-title.with-two-dates>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('Invoice Number') }}</th>
                                    <th>{{ __('Settlement Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Withhold Amount') }}</th>
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($models as $model)
                                <tr>
                                    <td>{{ $model->getInvoiceNumber() }}</td>
                                    <td class="text-nowrap">{{ $model->getSettlementDateFormatted() }}</td>
                                    <td>{{ $model->getSettlementAmountFormatted() }}</td>
                                    <td>{{ $model->getWithholdAmountFormatted() }}</td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            {{-- <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.money.receive',['company'=>$company->id,'moneyReceived'=>$model->id]) }}"><i class="fa fa-pen-alt"></i></a> --}}

                                            {{-- <a data-toggle="modal" data-target="#delete-transfer-id-{{ $model->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a> --}}
                                            <div class="modal fade" id="delete-transfer-id-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.money.receive',['company'=>$company->id,'moneyReceived'=>$model->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'due_date') {
            $('.data-type-span').html('[ {{ __("Due Date") }} ]')
            modal.find(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName == 'settlement_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ {{ __("Settlement Date") }} ]')
        } else if (searchFieldName == 'deposit_date') {
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
            modal.find('.data-type-span').html('[ {{ __("Deposit Date") }} ]')
        } else {
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

            $('.js-search-modal').trigger('change')

        })
        </script>
    @endsection
    @push('js') 
@endpush
