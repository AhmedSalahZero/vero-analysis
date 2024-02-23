@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled],
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Cheque Under Collection') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="{{ isset($model) ?  route('cheque.send.to.collection',['company'=>$company->id]) :'#' }}" class="kt-form kt-form--label-right">
            <input type="hidden" name="cheques[]" value="{{ $model->id }}">
            @csrf

            {{-- Money Received --}}
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Cheque Info')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <div class="row mb-3">


                        @foreach([
                        'customer_name'=>['title'=>__('Customer Name'),'value'=>$model->getCustomerName() , 'class'=>'col-md-5'],
                        'cheque_amount'=>['title'=>__('Cheque Amount'),'value'=>$model->getReceivedAmount() , 'class'=>'col-md-3'],
                        'currency'=>['title'=>__('Currency'),'value'=>$model->getCurrency() , 'class'=>'col-md-2'],
                        'cheque_number'=>['title'=>__('Cheque Number'),'value'=>$model->cheque->getChequeNumber() , 'class'=>'col-md-2'],
                        ] as $uniqueName => $field)
                        <div class="{{ $field['class'] }} mb-3">
                            <label>{{$field['title']}} </label>
                            <div class="kt-input-icon">
                                <input readonly type="text" value="{{ $field['value'] }}" class="form-control">
                            </div>
                        </div>
                        @endforeach






                    </div>
                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Cheque Deposit Info')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>{{__('Cheque Deposit Date')}}</label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required value="{{ $model->getChequeDepositDateFormattedForDatePicker() }}" type="text" name="deposit_date" class="form-control" placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 mb-3">
                            <label>{{__('Drawal Bank')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="input-group date ">
                                    <select required name="drawl_bank_id" class="form-control js-drawl-bank">
                                        @foreach($selectedBanks as $bankId=>$bankName)
                                        <option value="{{ $bankId }}" {{ isset($model) && $model->chequeDrawlBankId() == $bankId ? 'selected':'' }}>{{ $bankName }}</option>
                                        @endforeach
                                    </select>
                                    <div class="modal fade" id="js-choose-bank-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Select Bank') }}</h5>
                                                    <button type="button" class="close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <select id="js-bank-names" data-live-search="true" class="form-control kt-bootstrap-select select2-select kt_bootstrap_select">
                                                        @foreach($banks as $bankId => $bankEnAndAr)
                                                        <option data-name="{{ $bankEnAndAr }}" value="{{ $bankId }}">{{ $bankEnAndAr }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary js-close-modal">{{ __('Close') }}</button>
                                                    <button id="js-append-bank-name-if-not-exist" type="button" class="btn btn-primary">{{ __('Save') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="js-drawee-bank" class="btn btn-sm btn-primary">{{ __('Add New Bank') }}</button>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">




                        <div class="col-md-4">
                            <label>{{__('Account Type')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-currency="{{ $model->getCurrency() }}" name="cheque_account_type" class="form-control js-update-account-number-based-on-account-type">
                                        <option value="" selected>{{__('Select')}}</option>
                                        @foreach($accountTypes as $index => $accountType)
                                        <option value="{{ $accountType->getId() }}" @if($id==$model->chequeAccountType() ) selected @endif>{{ $accountType->getName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>{{__('Account Number')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <input value="{{ $model->cheque&&$model->cheque->getAccountNumber() }}" required type="text" name="account_number" class="form-control" placeholder="{{__('Main Account Number')}}">
                                <x-tool-tip title="{{__('Kash Vero')}}" />
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>{{__('Account Balance')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <input value="{{ $model->cheque->getAccountBalance() }}" required value="0" readonly type="text" name="cheque_account_balance" class="form-control" placeholder="{{__('Account Balance')}}">
                                <x-tool-tip title="{{__('Kash Vero')}}" />
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{__('Clearance Days')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <input value="{{ $model->cheque->getClearanceDays() }}" required name="clearance_days" step="any" min="0" class="form-control only-greater-than-zero-or-equal-allowed" placeholder="{{__('Clearance Days')}}">
                                <x-tool-tip title="{{__('Kash Vero')}}" />
                            </div>
                        </div>


                    </div>
                </div>
            </div>




            <div class="kt-portlet hidden" id="cheque">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            {{__('Cheque Information')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{__('Select Drawee Bank')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="drawee_bank_id" class="form-control ">
                                            {{-- <option value="-1">{{__('New Bank')}}</option> --}}
                                            @foreach($selectedBanks as $bankId=>$bankName)
                                            <option value="{{ $bankId }}" {{ isset($model) && $model->cheque && $model->cheque->getDraweeBankId() == $bankId ? 'selected':'' }}>{{ $bankName }}</option>
                                            @endforeach
                                        </select>
                                        <button id="js-drawee-bank" class="btn btn-sm btn-primary">Add New Bank</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>{{__('Cheque Amount')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" value="{{ isset($model) ? $model->getReceivedAmount() : 0 }}" placeholder="{{ __('Please insert the cheque amount') }}" type="text" name="cheque_amount" class="form-control only-greater-than-or-equal-zero-allowed js-cheque-received-amount">
                                    <x-tool-tip title="{{__('Please insert the cheque amount')}}" />
                                </div>
                            </div>


                            <div class="col-md-2">
                                <label>{{__('Cheque Due Date')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="text" value="{{ isset($model) ?$model->cheque->getDueDate():0 }}" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <label>{{__('Cheque Number')}} <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="cheque_number" value="{{ isset($model) ? $model->cheque->getChequeNumber() : 0 }}" class="form-control" placeholder="{{__('Cheque Number')}}">
                                    <x-tool-tip title="{{__('Kash Vero')}}" />
                                </div>
                            </div>


                            {{-- <div class="col-md-4">
                        <label>{{__('Select Currency')}} <span class="required">*</span></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="currency" class="form-control">
                                        <option value="" selected>{{__('Select')}}</option>
                                        <option>EGP</option>
                                        <option>USD</option>
                                        <option>EURO</option>
                                        <option>GBP</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
    </div>



    <x-submitting />

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




<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })
    $(document).on('click', '#js-drawee-bank', function(e) {
        e.preventDefault();
        $('#js-choose-bank-id').modal('show');
    })

    $(document).on('click', '#js-append-bank-name-if-not-exist', function() {
        const receivingBank = document.getElementById('js-drawee-bank').parentElement;
        const newBankId = $('#js-bank-names').val();
        const newBankName = $('#js-bank-names option:selected').attr('data-name');
        const isBankExist = $(receivingBank).find('select.js-drawl-bank').find('option[value="' + newBankId + '"]').length;
        console.log(isBankExist, newBankId, $(receivingBank).find('option[value="' + newBankId + '"]')[0]);
        if (!isBankExist) {
            const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
            $('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
        }
        $('#js-choose-bank-id').modal('hide');
    });

</script>

@endsection
