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

    input.form-control[disabled]:not(.ignore-global-style)
	{
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Overdraft Against Assignment Of Contract '. $financialInstitution->getName()) }}
@endsection
@section('content')

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !Request('active') || Request('active') == 'overdraft-against-assignment-of-contract' ?'active':'' }}" data-toggle="tab" href="#overdraft-against-assignment-of-contract" role="tab">
                        <i class="fa fa-money-check-alt"></i> {{ __('Overdraft Against Assignment Of Contract Table') }}
                    </a>
                </li>

            </ul>

            <div class="flex-tabs">
                <a href="{{ route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id]) }}" class="btn  active-style btn-icon-sm align-self-center">
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
            <div class="tab-pane {{ !Request('active') || Request('active') == 'overdraft-against-assignment-of-contract' ?'active':'' }}" id="bank" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg p-0">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('Overdraft Against Assignment Of Contract Table') }}
                            </h3>
                        </div>
                        {{-- Export --}}
                        <x-export-overdraft-against-assignment-of-contract :financialInstitution="$financialInstitution" :search-fields="$searchFields" :money-received-type="'overdraft-against-assignment-of-contract'" :has-search="1" :has-batch-collection="0" href="{{route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])}}" />
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Account Number') }}</th>
                                    <th>{{ __('Currency') }}</th>
                                    <th>{{ __('Limit') }}</th>
                                    <th>{{ __('Borrowing Rate') }}</th>
                                    <th>{{ __('Margin Rate') }}</th>
                                    <th>{{ __('Intreset Rate') }}</th>
                                    {{-- <th>{{ __('Max Lending Limit Per Customer') }}</th> --}}
                                    {{-- <th>{{ __('Max Settlement Days') }}</th> --}}
                                    <th>{{ __('Control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($odAgainstAssignmentOfContracts as $index=>$odAgainstAssignmentOfContract)
                                <tr class="closest-parent-tr " data-currency="{{ $odAgainstAssignmentOfContract->getCurrency() }}">
                                    <td>
                                        {{ $index+1 }}
                                    </td>
                                    <td class="text-nowrap">{{ $odAgainstAssignmentOfContract->getContractStartDateFormatted() }}</td>
                                    <td class="text-nowrap">{{ $odAgainstAssignmentOfContract->getContractEndDateFormatted() }}</td>
                                    <td>{{ $odAgainstAssignmentOfContract->getAccountNumber() }}</td>
                                    <td class="text-uppercase">{{ $odAgainstAssignmentOfContract->getCurrency() }}</td>
                                    <td class="text-transform">{{ $odAgainstAssignmentOfContract->getLimitFormatted()  }}</td>
                                    <td class="bank-max-width">{{ $odAgainstAssignmentOfContract->getBorrowingRateFormatted() . ' %'  }}</td>
                                    <td class="text-nowrap">{{ $odAgainstAssignmentOfContract->getMarginRateFormatted() . ' %'  }}</td>
                                    <td>{{ $odAgainstAssignmentOfContract->getInterestRateFormatted() . ' %'  }}</td>
                                    {{-- <td>{{ $odAgainstAssignmentOfContract->getMaxLendingLimitPerCustomer() }}</td> --}}
                                    {{-- <td>{{ $odAgainstAssignmentOfContract->getMaxSettlementDays() }}</td> --}}
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">


                                        <a data-toggle="modal" data-target="#apply-expense-{{ $odAgainstAssignmentOfContract->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Assign Contract') }}" href="#"><i class=" fa fa-balance-scale"></i></a>
                                        <div class="modal fade" id="apply-expense-{{ $odAgainstAssignmentOfContract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('lending.information.apply.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract->id ]) }}" method="post">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Lending Information' )  }}</h5>
                                                            <button type="button" class="close" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>


                                                        <div class="modal-body">
														
														<div class="row mb-3 ">

                                                                @include('reports.overdraft-against-assignment-of-contract.lending-rate-form' , [
																	
																])





                                                                <div class="col-md-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>{{ __('#') }}</th>
                                                                                    <th>{{ __('Customer') }}</th>
                                                                                    <th>{{ __('Contract') }}</th>
                                                                                    <th>{{ __('Amount') }}</th>
                                                                                    <th>{{ __('Start Date') }}</th>
                                                                                    <th>{{ __('End Date') }}</th>
                                                                                    <th>{{ __('Lending %') }}</th>
                                                                                    <th>{{ __('Lending Amount') }}</th>
                                                                                    <th>{{ __('Actions') }}</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($odAgainstAssignmentOfContract->lendingInformation as $index=>$lendingInformationAgainstAssignmentOfContract)
                                                                                <tr>
                                                                                    <td> {{ ++$index }} </td>
                                                                                    <td class="text-nowrap">{{$lendingInformationAgainstAssignmentOfContract->getCustomerName() }}</td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getContractName() }} </td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getContractAmountFormatted() }} </td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getContractStartDate() }} </td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getContractEndDate() }} </td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getLendingRateFormatted() . ' %' }} </td>
                                                                                    <td> {{ $lendingInformationAgainstAssignmentOfContract->getLendingAmountFormatted() }} </td>
                                                                                    <td>
                                                                                        <a 
																						{{-- data-toggle="modal" --}}
																						 href="{{ route('apply.against.lending',['company'=>$company->id , 'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id]) }}"
																						 data-target="#apply-lending-information-{{ $lendingInformationAgainstAssignmentOfContract->id }}" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="{{ __('Apply Against Lending') }}"><i class="fa fa-balance-scale"></i></a>
                                                                                        <a data-toggle="modal" data-target="#edit-lending-information-{{ $lendingInformationAgainstAssignmentOfContract->id }}" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="#"><i class="fa fa-pen-alt"></i></a>

                                                                                        <div class="modal fade" id="edit-lending-information-{{ $lendingInformationAgainstAssignmentOfContract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                                                                <div class="modal-content">
                                                                                                    <form action="{{ route('lending.information.edit.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ]) }}" method="post">
                                                                                                        @csrf
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit' )  }}</h5>
                                                                                                            <button data-dismiss="modal2" type="button" class="close" aria-label="Close">
                                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                            </button>
                                                                                                        </div>


                                                                                                        <div class="modal-body">
                                                                                                            <div class="row mb-3">

                                                                                                                @include('reports.overdraft-against-assignment-of-contract.lending-rate-form',[
																													'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract
																												])



                                                                                                            </div>
                                                                                                        </div>


                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal2">{{ __('Close') }}</button>
                                                                                                            <button data-url="{{  route('lending.information.edit.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ]) }}" type="submit" class="btn btn-primary submit-form-btn">{{ __('Confirm') }}</button>
                                                                                                        </div>

                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>








                                                                                        <a data-toggle="modal" data-target="#delete-lending-information-{{ $lendingInformationAgainstAssignmentOfContract->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                                                                        <div class="modal fade" id="delete-lending-information-{{ $lendingInformationAgainstAssignmentOfContract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                                <div class="modal-content">
                                                                                                    <form action="" method="post">
                                                                                                        @csrf
                                                                                                        @method('delete')
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Delete This Item ?') }}</h5>
                                                                                                            <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal2">{{ __('Close') }}</button>

                                                                                                            <a href="{{ route('lending.information.delete.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ]) }}" class="btn btn-danger">{{ __('Confirm Delete') }}</a>
                                                                                                        </div>

                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="{{ route('edit.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract->id]) }}"><i class="fa fa-pen-alt"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-{{ $odAgainstAssignmentOfContract->id }}" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-{{ $odAgainstAssignmentOfContract->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract]) }}" method="post">
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
	<script>
	$(document).on('change','select.ajax-get-contracts-for-customer-create',function(){
		const customerId = $(this).val()
		const parent = $(this).closest('.closest-parent-tr') ;
		const currency  = parent.data('currency')
		console.log(currency)
		$.ajax({
			url:"{{ route('get.contracts.for.customer.with.start.and.end.date',['company'=>$company->id]) }}",
			data:{
				customerId,
				currency
			},
			success: function(res) {
                    let options = '';
                    for (index in res.contracts) {
						var contract = res.contracts[index] ;
                        options += `<option data-amount="${number_format(contract.amount)}"  data-start-date="${contract.start_date}" data-end-date="${contract.end_date}" value="${contract.id}">${contract.name}</option>`
                    }
                    parent.find('.append-contracts-create').empty().append(options);
					parent.find('.append-contracts-create').trigger('change')
                }
		})
	})
	$(document).on('change','select.append-contracts-create',function(){
				const parent = $(this).closest('.closest-parent-tr') ;
				const selectedOption = $(this).find('option:selected')
				$(parent).find('.contract-start-date-class-create').val($(selectedOption).data('start-date'))
				$(parent).find('.contract-end-date-class-create').val($(selectedOption).data('end-date'))
				$(parent).find('.contract-amount-class-create').val($(selectedOption).data('amount'))
				
	})
	$('select.ajax-get-contracts-for-customer-create').trigger('change')
	</script>
@endsection
@push('js')
{{-- <script src="{{ url('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/js/demo1/pages/crud/datatables/basic/paginations.js') }}" type="text/javascript"></script> --}}
@endpush
