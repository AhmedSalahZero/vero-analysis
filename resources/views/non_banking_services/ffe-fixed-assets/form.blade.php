@extends('layouts.dashboard')
@php
use App\Models\NonBankingService\Expense;
@endphp
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/expenses.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">

@endsection
@section('sub-header')

<x-main-form-title :id="'main-form-title'" :class="''">{{ $title  }}</x-main-form-title>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">



        <div class="kt-portlet " style="margin-bottom:5px;">


            <div class="kt-portlet__body">


                <div class="">
                    @php
                    // $index = 0 ;
                    @endphp
                    <div class="d-flex align-items-center justify-content-start " style="margin-right:auto">
                        {{-- @foreach(getManpowerTypesForValuesForNonBanking() as $typeElement) --}}
                        <button data-value="ffe-fixed-assets" class="btn mb-5 js-type-btn type-btn btn btn-outline-info active">{{ __('FFE Fixed Assets') }}</button>
                        @php
                        // $index++;
                        @endphp
                        {{-- @endforeach --}}
                    </div>




                </div>


            </div>
        </div>

        {{-- @foreach(count($departments)? $departments : [null] as $department) --}}
        @php
        $tableId = 'ffe-fixed-assets';
        $cardId = $tableId;
        $repeaterId = $tableId.'_repeater';
        @endphp
        @include('non_banking_services.ffe-fixed-assets._repeater')

        {{-- @php
        $tableId = 'new_departments';
        $repeaterId = $tableId.'_repeater';

        $cardId = 'departments';
        @endphp --}}
        {{-- @endforeach --}}
        {{-- @if(session()->get('addNewDepartment') && $departments->last())
        @include('non_banking_services.manpower._department_card',[
        'departments'=>[],
        'department'=>null,
        'initialDepartmentIndex'=>$departments->last()->id + 1
        ])
        @endif --}}




        <!--end::Form-->

        <!--end::Portlet-->


        <div class="kt-portlet " style="margin-bottom:5px;">


            <div class="kt-portlet__body">

                {{-- start of FFE Funding Structure   --}}
                <div class="kt-portlet " id="new-funding-id">
                    <div class="kt-portlet__body">
                        <div class="row">

                            <div class="col-md-10">
                                <div class="d-flex align-items-center ">
                                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style="">
                                        {{ __('FFE Funding Structure') }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <x-show-hide-btn :query="'.new-portfolio-funding'"></x-show-hide-btn>
                            </div>
                        </div>
                        <div class="row">
                            <hr style="flex:1;background-color:lightgray">
                        </div>
                        <div class="row new-portfolio-funding">
                            @php
                            $rowIndex = 0;
                            @endphp


                            <x-tables.repeater-table :removeActionBtn="true" :removeRepeater="true" :initialJs="false" :repeater-with-select2="true" :canAddNewItem="false" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="''" :repeaterId="''" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                                <x-slot name="ths">
                                    <x-tables.repeater-table-th class=" category-selector-class header-border-down " :title="__('Item')"></x-tables.repeater-table-th>
                                    @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                    <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Yr-') . $yearIndexWithYear[$year] "></x-tables.repeater-table-th>
                                    @endforeach
                                </x-slot>
                                <x-slot name="trs">

                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>




                                        <td>
                                            <input value="{{ __('Direct FFE Amounts') }}" disabled class="form-control text-left mt-2" type="text">

                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">

                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :readonly="true" :removeThreeDots="true" :inputHiddenAttributes="''" :currentVal="$study->getTotalDirectFactoringNewPortfolioAmountsAtYearIndex($year)" :classes="'js-recalculate-equity-funding-value total-loans-hidden'" :is-percentage="false" :name="''" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>



                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>




                                        <td>
                                            <input value="{{ __('Equity Funding Rate (%)') }}" disabled class="form-control text-left mt-2" type="text">

                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">

                                                <x-repeat-right-dot-inputs :inputHiddenAttributes="'js-recalculate-equity-funding-value'" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingRatesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed equity-funding-rates equity-funding-rate-input-hidden-class'" :is-percentage="true" :name="'directFactoringNewPortfolioFundingStructure['.'equity_funding_rates'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>



                                    <tr data-repeat-formatting-decimals="0" data-repeater-style {{-- @if($isRepeater) data-repeater-item @endif --}}>

                                        <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">


                                        <td>
                                            <input value="{{ __('Equity Funding Value') }}" disabled class="form-control text-left mt-2" type="text">

                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp
                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getEquityFundingValuesAtYearIndex($year):0" :classes="'only-greater-than-or-equal-zero-allowed '" :formatted-input-classes="'equity-funding-formatted-value-class'" :is-percentage="false" :name="'directFactoringNewPortfolioFundingStructure['.'equity_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp
                                        @endforeach



                                    </tr>



                                    <tr data-repeat-formatting-decimals="2" data-repeater-style>
                                        <td>
                                            <input disabled value="{{ __('Loans Funding Rate (%)') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="text" data-column-index="{{ $columnIndex }}" readonly class="form-control expandable-percentage-input new-loan-function-rates-js" name="directFactoringNewPortfolioFundingStructure[new_loans_funding_rates][{{ $year }}]" value="{{ $model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingRatesAtYearIndex($year):0 }}"> <span class="ml-2">%</span>
                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>






                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>


                                        <td>
                                            <input disabled value="{{ __('Loans Funding Value') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>


                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                        <td>
                                            <input disabled value="{{ __('Loans Tenor ( Months )') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :mark="'Mth'" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>


                                    <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                        <td>
                                            <input disabled value="{{ __('Grace Period ( Months )') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :mark="'Mth'" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>
									
									 <tr data-repeat-formatting-decimals="2" data-repeater-style>

                                        <td>
                                            <input disabled value="{{ __('Interest Rate %') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <x-repeat-right-dot-inputs :numberFormatDecimals="0" :mark="'%'" :formatted-input-classes="'new-loans-funding-formatted-value-class'" :currentVal="$model->directFactoringNewPortfolioFundingStructure ? $model->directFactoringNewPortfolioFundingStructure->getNewLoansFundingValuesAtYearIndex($year):0 " :classes="'only-greater-than-or-equal-zero-allowed'" :is-percentage="false" :name="'directFactoringNewPortfolioFundingStructure['.'new_loans_funding_values'.']['.$year.']'" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>

                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>
									
									 <tr data-repeat-formatting-decimals="0" data-repeater-style>

                                        <td>
                                            <input disabled value="{{ __('IInstallment Interval') }}" class="form-control text-left" type="text">
                                        </td>
                                        @php
                                        $columnIndex = 0 ;
                                        @endphp

                                        @foreach($yearsWithItsMonths as $year=>$monthsForThisYearArray)


                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                              <x-form.select :required="true" :label="''" :pleaseSelect="false" :selectedValue="isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly'" :options="[['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]]" :add-new="false" class="select2-select  repeater-select  "  :all="false" name="installment_interval"></x-form.select>
                                            </div>
                                        </td>
                                        @php
                                        $columnIndex++;
                                        @endphp

                                        @endforeach



                                    </tr>
									
									
                                </x-slot>




                            </x-tables.repeater-table>
                            {{-- end of fixed monthly repeating amount --}}


                        </div>

                    </div>
                </div>
                {{-- end of FFE Funding Structure   --}}
            </div>
        </div>

    </div>


</div>

</div>




</div>









</div>
</div>
{{-- </form> --}}

</div>
@endsection
@section('js')
<x-js.commons></x-js.commons>

<script>
    $(document).on('change', '.financial-statement-type', function() {
        validateDuration();
    })
    $(document).on('change', 'select[name="duration_type"]', function() {
        validateDuration();
    })
    $(document).on('change', '#duration', function() {
        validateDuration();
    })

    function validateDuration() {
        let type = $('input[name="type"]:checked').val();
        let durationType = $('select[name="duration_type"]').val();
        let duration = $('#duration').val();
        let isValid = true;
        let allowedDuration = 24;
        if (type == 'forecast' && durationType == 'monthly') {
            allowedDuration = 24;
            isValid = duration <= allowedDuration;
        }
        if (type == 'forecast' && durationType == 'quarterly') {
            allowedDuration = 8;
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'semi-annually') {
            allowedDuration = 4
            isValid = duration <= allowedDuration
        }
        if (type == 'forecast' && durationType == 'annually') {
            allowedDuration = 2;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'monthly') {
            allowedDuration = 36;
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'quarterly') {
            allowedDuration = 12
            isValid = duration <= allowedDuration;
        }
        if (type == 'actual' && durationType == 'semi-annually') {
            allowedDuration = 6;
            isValid = duration <= allowedDuration
        }
        if (type == 'actual' && durationType == 'annually') {
            allowedDuration = 3
            isValid = duration <= allowedDuration
        }
        let allowedDurationText = "{{ __('Allowed Duration') }}";

        $('#allowed-duration').html(allowedDurationText + '  ' + allowedDuration)

        if (!isValid) {
            Swal.fire({
                icon: 'error'
                , title: 'Invalid Duration. Allowed [ ' + allowedDuration + ' ]'
            , })

            $('#duration').val(allowedDuration).trigger('change');

        }


    }

    $(function() {
        $('.financial-statement-type').trigger('change')

    })

</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            let form = $(this).closest('form')[0];
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);
            let addNewDepartment = $(this).attr('data-save-and-add-new-department');
            addNewDepartment = addNewDepartment ? addNewDepartment : 0;
            formData.append('addNewDepartment', addNewDepartment)

            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {
                    $('.save-form').prop('disabled', false);
                    $('.submit-form-btn-new').prop('disabled', false)
                    Swal.fire({
                        icon: 'error'
                        , title: res.responseJSON.message
                    , });
                }
            });
        }
    })

</script>

<script>
    function reinitalizeMonthYearInput(dateInput) {
        var currentDate = $(dateInput).val();
        var startDate = "{{ isset($studyStartDate) && $studyStartDate ? $studyStartDate : -1 }}";
        startDate = startDate == '-1' ? '' : startDate;
        var endDate = "{{ isset($studyEndDate) && $studyEndDate? $studyEndDate : -1 }}";
        endDate = endDate == '-1' ? '' : endDate;
        if (startDate && endDate) {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
                .datepicker('setStartDate', new Date(startDate))
                .datepicker('setEndDate', new Date(endDate))
        } else {
            $(dateInput).datepicker({
                    viewMode: "year"
                    , minViewMode: "year"
                    , todayHighlight: false
                    , clearBtn: true,


                    autoclose: true
                    , format: "yyyy-mm-01"
                , })
                .datepicker('setDate', new Date(currentDate))
        }



    }

    $(function() {

        $('.only-month-year-picker').each(function(index, dateInput) {
            //     reinitalizeMonthYearInput(dateInput)
        })
    });
    //  $(document).on('change', '#expense_type', function() {
    //      $('.js-parent-to-table').hide();
    //      let tableId = '.' + $(this).val();
    //      $(tableId).closest('.js-parent-to-table').show();
    //
    //  }) 
    $(document).on('click', '.js-type-btn', function(e) {
        e.preventDefault();
        const mainCardId = $(this).attr('data-value')
        $('.js-parent-to-table').show();
        $('.js-type-btn').removeClass('active');
        $(this).addClass('active');
        $('.parent-card').hide();
        console.log(mainCardId)
        $('[data-card-id="' + mainCardId + '"]').show();
    })
    $(function() {
        $('#expense_type').trigger('change')
        $('.js-type-btn.active').trigger('click')
    })

    $(function() {
        $(document).on('click', '.js-show-all-categories-trigger', function() {
            const elementToAppendIn = $(this).parent().find('.js-append-into');
            const texts = [];
            let lis = '';
            text = '<u><a href="#" data-close-new class="text-decoration-none mb-2 d-inline-block text-nowrap ">' + 'Add New' + '</a></u>'
            lis += '<li >' + text + '</li>'
            $(this).closest('table').find('.js-show-all-categories-popup').each(function(index, element) {
                let text = $(element).val().trim();
                if (text && !texts.includes(text)) {
                    texts.push(text)
                    text = '<a href="#" data-add-new class="text-decoration-none mb-2 d-inline-block">' + text + '</a>'
                    lis += '<li >' + text + '</li>'
                }
            })




            elementToAppendIn.removeClass('d-none');
            elementToAppendIn.find('ul').empty().append(lis);
        })


    })
    $(document).on('click', '[data-add-new]', function(e) {
        e.preventDefault();
        let content = $(this).html();
        $(this).closest('.js-common-parent').find('input').val(content);
    })
    $(document).on('click', '[data-close-new]', function(e) {
        e.preventDefault();
        $(this).closest('.js-append-into').addClass('d-none');
        $(this).closest('.js-common-parent').find('input').val('').focus();
    })
    $(document).on('click', function(e) {
        let closestParent = $(e.target).closest('.js-append-into').length;
        if (!closestParent && !$(e.target).hasClass('js-show-all-categories-trigger')) {
            $('.js-append-into').addClass('d-none');
        }
    })
    $(function() {
        // alert($('.reapter-select').length)
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-delete]').trigger('click');
        $('.repeater-with-select2').closest('.repeater-class').find('[data-repeater-create]').trigger('click');
    });

</script>
@endsection



@push('js_end')

<script>
    $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
        if (!$(this).hasClass('exclude-text')) {
            let val = $(this).val()
            val = number_unformat(val)
            if (isNumber(val)) {
                $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)
            }

        }
    })
    $(document).on('click', '.repeat-to-r', function() {
        const columnIndex = $(this).data('column-index');
        const digitNumber = $(this).data('digit-number');
        const val = $(this).parent().find('input[type="hidden"]').val();
        $(this).closest('tr').find('.can-be-repeated-parent').each(function(index, parent) {
            if (index > columnIndex) {
                $(parent).find('.can-be-repeated-text').val(val);
                $(parent).find('.can-be-repeated-text').val(number_format(val, digitNumber));

            }
        })
    })


    $('select.js-condition-to-select').change(function() {
        const value = $(this).val();
        const conditionalValueTwoInput = $(this).closest('tr').find('input.conditional-b-input');
        if (value == 'between-and-equal' || value == 'between') {
            conditionalValueTwoInput.prop('disabled', false).trigger('change');
        } else {
            conditionalValueTwoInput.prop('disabled', true).trigger('change');
        }
    })

    $('select.js-condition-to-select').trigger('change');
    $(document).on('change', '.conditional-input', function() {
        if (!$(this).closest('tr').find('conditional-b-input').prop('disabled')) {
            const conditionalA = $(this).closest('tr').find('.conditional-a-input').val();
            const conditionalB = $(this).closest('tr').find('.conditional-b-input').val();
            if (conditionalA >= conditionalB) {
                if (conditionalA == 0 && conditionalB == 0) {
                    return;
                }
                Swal.fire('conditional a must be less than conditional b value');
                $(this).closest('tr').find('.conditional-a-input').val($(this).closest('tr').find('.conditional-b-input').val() - 1);
            }
        }

    })

</script>
<script>
    const handlePaymentTermModal = function() {
        const parentTermsType = $(this).closest('select').val();
        const tableId = $(this).closest('table').attr('id');
        if (parentTermsType == 'customize') {
            $(this).closest('tr').find('#' + tableId + 'test-modal-id').modal('show')
        }



    };
    $(document).on('change', 'select.payment_terms', handlePaymentTermModal)


    //$(document).on('click','option',handlePaymentTermModal)
    $(document).on('change', '.rate-element', function() {
        let total = 0;
        const parent = $(this).closest('tbody');
        parent.find('.rate-element-hidden').each(function(index, element) {
            total += parseFloat($(element).val());
        });
        parent.find('td.td-for-total-payment-rate').html(number_format(total, 2) + ' %');

    })
    $(function() {
        $('.rate-element').trigger('change');
    })

</script>
<script src="/custom/js/non-banking-services/common.js"></script>
<script>


</script>
@endpush
