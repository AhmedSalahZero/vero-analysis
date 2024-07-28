@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
.kt-portlet__body{
	padding-top:0 !important;
}
.hover-color-black:hover i{
	color:black !important;
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

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Financial Institutions') }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == 'bank' ?'active':'' }}" data-toggle="tab" href="#bank" role="tab">
                        <i class="kt-menu__link-icon fa fa-university"></i> {{ __('Banks Table') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'leasing_companies' ? 'active':''  }}" data-toggle="tab" href="#leasing_companies" role="tab">
                        <i class="kt-menu__link-icon fa fa-university"></i> {{ __('Leasing Companies Table') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'factoring_companies' ? 'active':''  }}" data-toggle="tab" href="#factoring_companies" role="tab">
                        <i class="kt-menu__link-icon fa fa-university"></i>{{ __('Factoring Companies Table') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request('active') == 'mortgage_companies' ? 'active':''  }}" data-toggle="tab" href="#mortgage_companies" role="tab">
                        <i class="kt-menu__link-icon fa fa-university"></i>{{ __('Mortgage Companies Table') }}
                    </a>
                </li>
            </ul>

           <div class="flex-tabs">
		    <a href="{{route('create.financial.institutions',['company'=>$company->id])}}" class="btn  active-style btn-icon-sm align-self-center">
                <i class="fas fa-plus"></i>
                {{ __('New Record') }}
            </a>
            {{-- <a href="" class="btn  active-style btn-icon-sm  align-self-center ">
				<i class="fas fa-plus"></i>
				<span>{{ __('New Record') }}</span>
            </a> --}}
		   </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
            <div class="tab-pane {{ !Request('active') || Request('active') == 'bank' ?'active':'' }}" id="bank" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
					<x-table-title.title :title="__('Banks Table')" :icon="'fa-university'">
                        <x-export-financial-institution :search-fields="$companiesSearchFields" :money-received-type="'bank'" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.financial.institutions',['company'=>$company->id])}}" />
					</x-table-title.title>
                    {{-- <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-dark btn-outline-hover-danger kt-menu__link-icon fa fa-university "></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                            </h3>
                        </div>
                    </div> --}}
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('#') }}</th>
                                    <th class="bank-max-width">{{ __('Bank') }}</th>
                                    <th>{{ __('Branch Name') }}</th>
                                    <th>{{ __('Company Account Number') }}</th>
                                    {{-- <th>{{ __('Swift Code') }}</th> --}}
                                    {{-- <th>{{ __('IBAN Code') }}</th> --}}
                                    {{-- <th>{{ __('Current Account Number') }}</th> --}}
                                    {{-- <th>{{ __('Balance Amount') }}</th> --}}
                                    {{-- <th>{{ __('Balance Date') }}</th> --}}
                                    <th>{{ __('Control') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($financialInstitutionsBanks as $index=>$financialInstitutionBank)
                                <tr>
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td class="bank-max-width">{{ $financialInstitutionBank->getBankName() }}</td>
                                    <td class="text-nowrap">{{ $financialInstitutionBank->getBranchName() }}</td>
                                    <td>{{ $financialInstitutionBank->getCompanyAccountNumber() }}</td>
                                    {{-- <td>{{ $financialInstitutionBank->getSwiftCode() }}</td> --}}
                                    {{-- <td class="text-transform">{{ $financialInstitutionBank->getIbanCode() }}</td> --}}
                                    {{-- <td >{{ $financialInstitutionBank->getCurrentAccountNumber() }}</td> --}}
                                    {{-- <td class="text-nowrap">{{ $financialInstitutionBank->getBalanceAmountFormatted() }}</td> --}}
                                    {{-- <td>{{ $financialInstitutionBank->getBalanceDateFormatted() }}</td> --}}
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                     

                                        <span style="overflow: visible; position: relative; width: 110px;">
                                        @include('reports.financial-institution.dropdown-actions')
                                         
                                        </span>
                                    </td>
									
									<td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                     

                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-success btn-outline-hover-success btn-icon hover-color-black"  title="{{ __('Show All Account') }}" href="{{ route('view.all.bank.accounts',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}"><i class="fa fa-eye"></i></a>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.financial.institutions',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $financialInstitutionBank->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $financialInstitutionBank->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.financial.institutions',['company'=>$company->id,'financialInstitution'=>$financialInstitutionBank->id]) }}" method="post">
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




            @foreach($financialInstitutionCompanies as $id => $companyArr)

            <div class="tab-pane {{ Request('active') == $id ? 'active':''  }}" id="{{ $id }}" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ $companyArr['title'] }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-financial-institution :search-fields="$companyArr['searchFieldsArr']" :money-received-type="$id" :has-search="1" :has-batch-collection="0" :banks="$banks" :selectedBanks="$selectedBanks" href="{{route('create.financial.institutions',['company'=>$company->id])}}" />

                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th class="align-middle">{{ __('#') }}</th>
                                    <th class="align-middle">{{ __('Name') }}</th>
                                    <th class="align-middle">{{ __('Branch Name') }}</th>
                                    <th class="align-middle">{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companyArr['financialInstitutionCompanies'] as $index=>$financialInstitutionCompany)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $financialInstitutionCompany->getName() }}</td>
                                    <td>{{ $financialInstitutionCompany->getBranchName() }}</td>

                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
									@include('reports.financial-institution.dropdown-actions')
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.financial.institutions',['company'=>$company->id,'financialInstitution'=>$financialInstitutionCompany->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $financialInstitutionCompany->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $financialInstitutionCompany->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.financial.institutions',['company'=>$company->id,'financialInstitution'=>$financialInstitutionCompany->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            {{-- <div class="modal-body">
                                                            ...
                                                        </div> --}}
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
            @endforeach





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
	$('button[data-dismiss-modal="inner-modal"]').click(function () {
		$(this).closest('.modal').modal('hide');
	});

    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ {{ __("Balance Date") }} ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ {{ __("Created At") }} ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
@endsection
@push('js')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
