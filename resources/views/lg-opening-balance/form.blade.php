@php
use App\Models\LetterOfGuaranteeIssuance ;
@endphp
@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    .css-fix-plus-direction {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-direction: row-reverse;
    }

    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
    }

    .customer-name-width {
        max-width: 250px !important;
        width: 250px !important;
        min-width: 250px !important;
    }

    .drawee-bank-width {
        max-width: 665px !important;
        width: 665px !important;
        min-width: 665px !important;
    }

    .width-8 {
        max-width: 100px !important;
        width: 100px !important;
        min-width: 100px !important;
        flex: initial !important;
    }

    .width-12 {
        max-width: 150px !important;
        width: 150px !important;
        min-width: 150px !important;
        flex: initial !important;
    }



    .width-15 {
        max-width: 170px !important;
        width: 170px !important;
        min-width: 170px !important;
        flex: initial !important;
    }

    thead tr {
        background-color: #CCE2FD !important;

    }

    thead tr th {
        border: 1px solid white !important;
    }

    label {
        white-space: nowrap !important
    }

    [class*="col"] {
        margin-bottom: 1.5rem !important;
    }

    label {
        text-align: left !important;
    }





    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>

<style>
    .show-class-js.js-parent-to-table {
        overflow: scroll !important;
    }

</style>
<style>

</style>
@endsection
@section('sub-header')
{{ __('Letter Of Guarantee Opening Balance') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <form method="post" action="{{ isset($model) ? route('lg-opening-balance.update',['company'=>$company->id,'lg_opening_balance'=>$model->id]) : route('lg-opening-balance.store',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
            @csrf
            @if(isset($model))
            @method('put')
            @endif
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <x-sectionTitle :title="__('Letter Of Guarantee Opening Balance')"></x-sectionTitle>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->

                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('LG Opening Balance Date')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-md-4 ">
                                    <x-form.date :type="'text'" :classes="'datepicker-input'" :default-value="formatDateForDatePicker(isset($model)  ? $model->getDate() : now())" :model="$model??null" :label="__('LG Opening Balance Date')" :type="'text'" :placeholder="__('')" :name="'date'" :required="true"></x-form.date>
                                </div>
                            </div>
                        </div>
                    </div>



















                    <div class="kt-portlet">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('100% Cash Cover Begining Balance ')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                @php
                                $index = 0 ;
                                @endphp



                                {{-- start of Cheques Under Collection --}}
                                @php
                                $tableId = 'LgHundredPercentageCashCoverOpeningBalance'; // name of relationship
                                $repeaterId = 'm_repeater_8';

                                @endphp
                                <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                                <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'show-class-js modal-parent--js is-customer-class'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=true">
                                    <x-slot name="ths">
                                        @foreach([
                                            __('Currency')=>'width-8',
                                            __('Bank <br> Name')=>'drawee-bank-width',
                                            __('Account <br> Type')=>'customer-name-width',
                                            __('Account <br> Number')=>'customer-name-width',
                                            __('LG Amount')=>'width-15',
                                            __('LG <br> Type')=>'width-15',
                                            __('LG <br> Expiry Date')=>'width-12'
                                        ] as $title=>$classes)
                                        <x-tables.repeater-table-th class="{{ $classes }}" :title="$title"></x-tables.repeater-table-th>
                                        @endforeach
                                    </x-slot>
                                    <x-slot name="trs">
                                        @php
                                        $rows = isset($model) ? $model->LgHundredPercentageCashCoverOpeningBalance :[-1] ;
                                        @endphp
                                        @foreach( count($rows) ? $rows : [-1] as $LgHundredPercentageCashCoverOpeningBalance)
                                        @php
                                        if( !($LgHundredPercentageCashCoverOpeningBalance instanceof \App\Models\LgHundredPercentageCashCoverOpeningBalance) ){
                                        unset($LgHundredPercentageCashCoverOpeningBalance);
                                        }
                                        @endphp
                                        <tr @if($isRepeater) data-repeater-item @endif>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="{{ isset($LgHundredPercentageCashCoverOpeningBalance) ? $LgHundredPercentageCashCoverOpeningBalance->id : 0 }}">
                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        {{-- <option selected>{{__('Select')}}</option> --}}
                                                        @foreach(getCurrencies() as $currencyName => $currencyValue )
                                                        <option value="{{ $currencyName }}" @if(isset($LgHundredPercentageCashCoverOpeningBalance) && $LgHundredPercentageCashCoverOpeningBalance->getCurrency() == $currencyName ) selected @elseif($currencyName == 'EGP' ) selected @endif > {{ $currencyValue }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control js-drawl-bank">
                                                            @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                                            <option value="{{ $financialInstitutionBank->id }}" >{{ $financialInstitutionBank->getName() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            @foreach($accountTypes as $index => $accountType)
                                                            <option value="{{ $accountType->id }}">{{ $accountType->getName() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="{{ isset($LgHundredPercentageCashCoverOpeningBalance) ? $LgHundredPercentageCashCoverOpeningBalance->getCurrentAccountNumber(): 0 }}" name="current_account_number" class="form-control js-account-number">
                                                            <option value="" selected>{{__('Select')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>



                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="amount" type="text" class="form-control " value="{{ number_format(isset($LgHundredPercentageCashCoverOpeningBalance) ? $LgHundredPercentageCashCoverOpeningBalance->getAmount() : old('amount',0)) }}">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="lg_type" class="form-control">
                                                            {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                                            @foreach($lgTypes as $lgTypeId => $lgTypeTitle)
                                                            <option value="{{ $lgTypeId }}" @if(isset($LgHundredPercentageCashCoverOpeningBalance) && $LgHundredPercentageCashCoverOpeningBalance->getLgType() == $lgTypeId) selected @endif>{{ $lgTypeTitle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="date-max-width">
                                                    <x-calendar :onlyMonth="false" :showLabel="false" :value="isset($LgHundredPercentageCashCoverOpeningBalance) ?  formatDateForDatePicker($LgHundredPercentageCashCoverOpeningBalance->getExpiryDate()) :  formatDateForDatePicker(now())" :label="__('Expiry Date')" :id="'lg_expiry_date'" name="lg_expiry_date"></x-calendar>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </x-slot>




                                </x-tables.repeater-table>
                                {{-- end of fixed monthly repeating amount --}}















































































                            </div>


                        </div>
                    </div>






                    <div class="kt-portlet">

                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('Against CD Or TD')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">


                            <div class="form-group row justify-content-center">
                                @php
                                $index = 0 ;
                                @endphp



                                {{-- start of Cheques Under Collection --}}
                                @php
                                $tableId = 'LgAgainstCertificateOfDepositOrTimeOfDepositOpeningBalances'; // name of relationship
                                $repeaterId = 'm_repeater_9';

                                @endphp
                                <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                                <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'show-class-js modal-parent--js is-customer-class'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=true">
                                    <x-slot name="ths">
                                        @foreach([
                                            __('Currency')=>'width-8',
                                            __('Bank <br> Name')=>'drawee-bank-width',
                                            __('Account <br> Type')=>'customer-name-width',
                                            __('Account <br> Number')=>'customer-name-width',
                                            __('LG Amount')=>'width-15',
                                            __('LG <br> Type')=>'width-15',
                                            __('LG <br> End Date')=>'width-12'
                                        ] as $title=>$classes)
                                        <x-tables.repeater-table-th class="{{ $classes }}" :title="$title"></x-tables.repeater-table-th>
                                        @endforeach
                                    </x-slot>
                                    <x-slot name="trs">
                                        @php
                                        $rows = isset($model) ? $model->{$tableId}:[-1] ;
                                        @endphp
                                        @foreach( count($rows) ? $rows : [-1] as $lgAgainstTdOrCdOpeningBalance)
                                        @php
                                        if( !($lgAgainstTdOrCdOpeningBalance instanceof \App\Models\LgAgainstTdOrCdOpeningBalance) ){
                                        unset($lgAgainstTdOrCdOpeningBalance);
                                        }
                                        @endphp
                                        <tr @if($isRepeater) data-repeater-item @endif>
                                            <td class="text-center">
                                                <div class="">
                                                    <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                    </i>
                                                </div>
                                            </td>


                                            <input type="hidden" name="id" value="{{ isset($lgAgainstTdOrCdOpeningBalance) ? $lgAgainstTdOrCdOpeningBalance->id : 0 }}">
                                            <td>

                                                <div class="input-group">
                                                    <select name="currency" class="form-control current-currency ajax-get-invoice-numbers" js-when-change-trigger-change-account-type>
                                                        {{-- <option selected>{{__('Select')}}</option> --}}
                                                        @foreach(getCurrencies() as $currencyName => $currencyValue )
                                                        <option value="{{ $currencyName }}" @if(isset($lgAgainstTdOrCdOpeningBalance) && $lgAgainstTdOrCdOpeningBalance->getCurrency() == $currencyName ) selected @elseif($currencyName == 'EGP' ) selected @endif > {{ $currencyValue }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date ">
                                                        <select js-when-change-trigger-change-account-type data-financial-institution-id required name="financial_institution_id" class="form-control js-drawl-bank">
                                                            @foreach($financialInstitutionBanks as $index=>$financialInstitutionBank)
                                                            <option value="{{ $financialInstitutionBank->id }}" >{{ $financialInstitutionBank->getName() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="account_type" class="form-control js-update-account-number-based-on-account-type">
                                                            @foreach($cdOrTdAccountTypes as $index => $accountType)
                                                            <option @if(isset($lgAgainstTdOrCdOpeningBalance) && $lgAgainstTdOrCdOpeningBalance->getAccountType() == $accountType->id) selected @endif value="{{ $accountType->id }}">{{ $accountType->getName() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select data-current-selected="{{ isset($lgAgainstTdOrCdOpeningBalance) ? $lgAgainstTdOrCdOpeningBalance->getAccountNumber(): 0 }}" name="account_number" class="form-control js-account-number">
                                                            <option value="" selected>{{__('Select')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>



                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group">
                                                        <input name="amount" type="text" class="form-control " value="{{ number_format(isset($lgAgainstTdOrCdOpeningBalance) ? $lgAgainstTdOrCdOpeningBalance->getAmount() : old('amount',0)) }}">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select name="lg_type" class="form-control">
                                                            {{-- <option value="" selected>{{__('Select')}}</option> --}}
                                                            @foreach($lgTypes as $lgTypeId => $lgTypeTitle)
                                                            <option value="{{ $lgTypeId }}" @if(isset($lgAgainstTdOrCdOpeningBalance) && $lgAgainstTdOrCdOpeningBalance->getLgType() == $lgTypeId) selected @endif>{{ $lgTypeTitle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="date-max-width">
                                                    <x-calendar :onlyMonth="false" :showLabel="false" :value="isset($lgAgainstTdOrCdOpeningBalance) ?  formatDateForDatePicker($lgAgainstTdOrCdOpeningBalance->getEndDate()) :  formatDateForDatePicker(now())" :label="__('End Date')" :id="'lg_expiry_date'" name="lg_end_date"></x-calendar>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </x-slot>




                                </x-tables.repeater-table>
                                {{-- end of fixed monthly repeating amount --}}















































































                            </div>


                        </div>
                    </div>


                </div>
            </div>
            <x-submitting />

            @endsection
            @section('js')
            <script>
                function reinitalizeMonthYearInput(dateInput) {
                    var currentDate = $(dateInput).val();
                    var startDate = "{{ isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1 }}";
                    startDate = startDate == '-1' ? '' : startDate;
                    var endDate = "{{ isset($studyEndDate) && $studyEndDate? $studyEndDate : -1 }}";
                    endDate = endDate == '-1' ? '' : endDate;

                    $(dateInput).datepicker({
                            viewMode: "year"
                            , minViewMode: "year"
                            , todayHighlight: false
                            , clearBtn: true
                            , autoclose: true
                            , format: "mm/01/yyyy"
                        , })
                        .datepicker('setDate', new Date(currentDate))
                        .datepicker('setStartDate', new Date(startDate))
                        .datepicker('setEndDate', new Date(endDate))
                }

            </script>
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
            {{-- <script src="{{ url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script> --}}
            {{-- <script src="{{asset('assets/form-repeater.js')}}" type="text/javascript"></script> --}}
            <script>

            </script>

            <script>
                $(document).find('.datepicker-input').datepicker({
                    dateFormat: 'mm-dd-yy'
                    , autoclose: true
                })

            </script>

            <script>
                let oldValForInputNumber = 0;
                $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('focus', function() {
                    oldValForInputNumber = $(this).val();
                    $(this).val('')
                })
                $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('blur', function() {

                    if ($(this).val() == '') {
                        $(this).val(oldValForInputNumber)
                    }
                })

                $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
                    if (!$(this).hasClass('exclude-text')) {
                        let val = $(this).val()
                        val = number_unformat(val)
                        $(this).parent().find('input[type="hidden"]').val(val)

                    }
                })

            </script>

            

            <script src="/custom/money-receive.js"></script>


            <script>
                var openedSelect = null;
                var modalId = null



                $(document).on('click', '.trigger-add-new-modal', function() {
                    var additionalName = '';
                    if ($(this).attr('data-previous-must-be-opened')) {
                        const previosSelectorQuery = $(this).attr('data-previous-select-selector');
                        const previousSelectorValue = $(previosSelectorQuery).val()
                        const previousSelectorTitle = $(this).attr('data-previous-select-title');
                        if (!previousSelectorValue) {
                            Swal.fire({
                                text: "{{ __('Please Select') }}" + ' ' + previousSelectorTitle
                                , icon: 'warning'
                            })
                            return;
                        }
                        const previousSelectorVal = $(previosSelectorQuery).val();
                        const previousSelectorHtml = $(previosSelectorQuery).find('option[value="' + previousSelectorVal + '"]').html();
                        additionalName = "{{' '. __('For')  }}  [" + previousSelectorHtml + ' ]'
                    }
                    const parent = $(this).closest('label').parent();
                    parent.find('select');
                    const type = $(this).attr('data-modal-title')
                    const name = $(this).attr('data-modal-name')
                    $('.modal-title-add-new-modal-' + name).html("{{ __('Add New ') }}" + type + additionalName);
                    parent.find('.modal').modal('show')
                })
                $(document).on('click', '.store-new-add-modal', function() {
                    const that = $(this);
                    $(this).attr('disabled', true);
                    const modalName = $(this).attr('data-modal-name');
                    const modalType = $(this).attr('data-modal-type');


                    const modal = $(this).closest('.modal');
                    const value = modal.find('input.name-class-js').val();
                    const previousSelectorSelector = $(this).attr('data-previous-select-selector');
                    const previousSelectorValue = previousSelectorSelector ? $(previousSelectorSelector).val() : null;
                    const previousSelectorNameInDb = $(this).attr('data-previous-select-name-in-db');

                    const additionalColumn = $(this).attr('data-additional-column')
                    const additionalColumnValue = $(this).attr('data-additional-column-value')
					let route = "{{ route('add.new.partner.type',['company'=>$company->id , 'type'=>'replace_with_actual_type']) }}"
					let isSupplier = $(this).closest('.modal-parent--js.is-supplier-class').length ;
					let isCustomer = $(this).closest('.modal-parent--js.is-customer-class').length ;
					let type = isSupplier > 0 ?'Supplier':'Customer';
					route = 	route.replace('replace_with_actual_type',modalName);

                    $.ajax({
                        url: route
                        , data: {
							value,
							type
                        }
                        , type: "POST"
                        , success: function(response) {
                            $(that).attr('disabled', false);
                            modal.find('input').val('');
                            $('.modal').modal('hide')
                            if (response.status) {

                                const allSelect = $(that).closest('.kt-portlet').find('select[data-modal-name="' + modalName + '"][data-modal-type="' + modalType + '"]');
                                const allSelectLength = allSelect.length;
                                allSelect.each(function(index, select) {
                                    var isSelected = '';
                                    if (index == (allSelectLength - 1)) {
                                        isSelected = 'selected';
                                    }
                                    $(select).append(`<option ` + isSelected + ` value="` + response.id + `">` + response.value + `</option>`).selectpicker('refresh').trigger('change')
                                })

                            }
                        }
                        , error: function(response) {}
                    });
                })



            </script>
            <script>


                $('.js-drawl-bank').trigger('change')
            </script>
            @endsection
