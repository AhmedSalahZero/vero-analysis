@php
use App\NotificationSetting ;
@endphp 
@extends('layouts.dashboard')
@section('css')
<link href="{{ url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet .kt-portlet__head {
        border-bottom-color: #CCE2FD !important;
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

    .width-8 {
        max-width: initial !important;
        width: 8% !important;
        flex: initial !important;
    }

    .width-10 {
        max-width: initial !important;
        width: 10% !important;
        flex: initial !important;
    }

    .width-12 {
        max-width: initial !important;
        width: 13.5% !important;
        flex: initial !important;
    }

    .width-45 {
        max-width: initial !important;
        width: 45% !important;
        flex: initial !important;
    }

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
{{ __('Notifications Settings') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="{{ route('notifications-settings.store',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <x-sectionTitle :title="__('Notifications Settings')"></x-sectionTitle>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('Customer Invoices Notifications')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="NotificationSetting::CUSTOMER_COMING_DUES_INVOICES_NOTIFICATIONS_DAYS" :model="$model??null" :label="__('Coming Dues Invoices Notifications Days')" :type="'text'" :placeholder="__('Coming Dues Invoices Notifications Days')" :name="'customer_coming_dues_invoices_notifications_days'" :required="true"></x-form.input>
                                </div>
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="NotificationSetting::CUSTOMER_PAST_DUES_INVOICES_NOTIFICATIONS_DAYS" :model="$model??null" :label="__('Past Dues Invoices Notifications Days')" :type="'text'" :placeholder="__('Past Dues Invoices Notifications Days')" :name="'customer_past_dues_invoices_notifications_days'" :required="true"></x-form.input>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('Cheques In Hand Notifications')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="NotificationSetting::CHEQUES_IN_SAFE_NOTIFICATIONS_DAYS" :model="$model??null" :label="__('Cheques In Safe Notifications Days')" :type="'text'" :placeholder="__('Cheques In Safe Notifications Days')" :name="'cheques_in_safe_notifications_days'" :required="true"></x-form.input>
                                </div>
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="NotificationSetting::CHEQUES_UNDER_COLLECTION_NOTIFICATIONS_DAYS" :model="$model??null" :label="__('Cheques Under Collection Notifications Days')" :type="'text'" :placeholder="__('Cheques Under Collection Notifications Days')" :name="'cheques_under_collection_notifications_days'" :required="true"></x-form.input>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					
					       <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('Suppliers Invoices Notifications')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="3" :model="$model??null" :label="__('Coming Dues Invoices Notifications Days')" :type="'text'" :placeholder="__('Coming Dues Invoices Notifications Days')" :name="'supplier_coming_dues_invoices_notifications_days'" :required="true"></x-form.input>
                                </div>
                                <div class="col-md-4 ">
                                    <x-form.input :default-value="1" :model="$model??null" :label="__('Past Dues Invoices Notifications Days')" :type="'text'" :placeholder="__('Past Dues Invoices Notifications Days')" :name="'supplier_past_dues_invoices_notifications_days'" :required="true"></x-form.input>
                                </div>
                            </div>
                        </div>
                    </div>
					

                </div>
            </div>
            <x-submitting />

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
                $(document).find('.datepicker-input').datepicker({
                    dateFormat: 'mm-dd-yy'
                    , autoclose: true
                })
                $('#m_repeater_0').repeater({
                    initEmpty: false
                    , isFirstItemUndeletable: true
                    , defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function() {
                        $(this).slideDown();
                        $('input.trigger-change-repeater').trigger('change')
                        $(document).find('.datepicker-input').datepicker({
                            dateFormat: 'mm-dd-yy'
                            , autoclose: true
                        })
                        $(this).find('.only-month-year-picker').each(function(index, dateInput) {
                            reinitalizeMonthYearInput(dateInput)
                        });
                        $('input:not([type="hidden"])').trigger('change');
                        $(this).find('.dropdown-toggle').remove();
                        $(this).find('select.repeater-select').selectpicker("refresh");

                    },

                    hide: function(deleteElement) {
                        if ($('#first-loading').length) {
                            $(this).slideUp(deleteElement, function() {

                                deleteElement();
                                //   $('select.main-service-item').trigger('change');
                            });
                        } else {
                            if (confirm('Are you sure you want to delete this element?')) {
                                $(this).slideUp(deleteElement, function() {

                                    deleteElement();
                                    $('input.trigger-change-repeater').trigger('change')

                                });
                            }
                        }
                    }
                });

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

            <script>
                $('input[name="borrowing_rate"],input[name="bank_margin_rate"]').on('change', function() {
                    let borrowingRate = $('input[name="borrowing_rate"]').val();
                    borrowingRate = borrowingRate ? parseFloat(borrowingRate) : 0;
                    let bankMaringRate = $('input[name="bank_margin_rate"]').val();
                    bankMaringRate = bankMaringRate ? parseFloat(bankMaringRate) : 0;
                    const interestRate = borrowingRate + bankMaringRate;
                    $('input[name="interest_rate"]').attr('readonly', true).val(interestRate);
                })
                $('input[name="borrowing_rate"]').trigger('change')

            </script>
            @endsection
