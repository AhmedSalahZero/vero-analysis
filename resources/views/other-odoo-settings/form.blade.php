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

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
@endsection
@section('sub-header')
{{ __('Other Odoo Settings') }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="{{ route('odoo-settings.store',['company'=>$company->id]) }}" class="kt-form kt-form--label-right">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    <x-sectionTitle :title="__('Please Insert Odoo Chart Of Account Number')"></x-sectionTitle>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title head-title text-primary">
                                    {{__('Settings')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
							<div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Suspense Account')" :type="'text'" :placeholder="__('Suspense Account')" :name="'suspense_account_code'" :required="false"></x-form.input>
                                </div>
								
                                <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Notes/Cheques Receivables')" :type="'text'" :placeholder="__('Notes/Cheques Receivables')" :name="'cheques_receivable_code'" :required="false"></x-form.input>
                                </div>
                                <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Notes/Cheques Payables')" :type="'text'" :placeholder="__('Notes/Cheques Payables')" :name="'cheques_payable_code'" :required="false"></x-form.input>
                                </div>
								
								 <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Bid LG Cash Cover')" :type="'text'" :placeholder="__('Bid LG Cash Cover')" :name="'bid_lg_cash_cover_code'" :required="false"></x-form.input>
                                </div>
								
								 <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Final LG Cash Cover')" :type="'text'" :placeholder="__('Final LG Cash Cover')" :name="'final_lg_cash_cover_code'" :required="false"></x-form.input>
                                </div>
								
								 <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Advanced LG Cash Cover')" :type="'text'" :placeholder="__('Advanced LG Cash Cover')" :name="'advanced_lg_cash_cover_code'" :required="false"></x-form.input>
                                </div>
								
								 <div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Performance LG Cash Cover')" :type="'text'" :placeholder="__('Performance LG Cash Cover')" :name="'performance_lg_cash_cover_code'" :required="false"></x-form.input>
                                </div>
								
								<div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Sight Lc Cash Cover')" :type="'text'" :placeholder="__('Sight Lc Cash Cover')" :name="'sight_lc_cash_cover_code'" :required="false"></x-form.input>
                                </div>
								
								<div class="col-md-3 ">
                                    <x-form.input :default-value="null" :model="$model??null" :label="__('Deferred Lc Cash Cover')" :type="'text'" :placeholder="__('Deferred Lc Cash Cover')" :name="'deferred_lc_cash_cover_code'" :required="false"></x-form.input>
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
                        $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)

                    }
                })

            </script>


            @endsection
