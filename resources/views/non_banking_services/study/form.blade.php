@extends('layouts.dashboard')
@section('css')
<x-styles.commons></x-styles.commons>
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/select2.css">
<style>
    .ui-datepicker-calendar {
        display: none;
    }

</style>
@endsection
@section('sub-header')
<x-main-form-title :id="'main-form-title'" :class="''">{{ $title }}</x-main-form-title>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{  isset($model) ? route('update.study',[$company->id , $model->id]) : $storeRoute  }}">
            @csrf
            @if(isset($model))
            @method('put')
            @endif
            <input type="hidden" name="company_id" value="{{ getCurrentCompanyId()  }}">
            <input type="hidden" name="creator_id" value="{{ \Auth::id()  }}">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> {{ $isBusinessPlan ? __('Business Plan Main Information') :  __('Annual Plan Main Information') }} </h3>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>

                    <div class="form-group  mt-3">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Study Name') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="{{ __('Please Enter Study Name') }}" name="name" value="{{ isset($model) ? $model->getName() : null }}" required>
                                    </div>
                                </div>
                            </div>

                            @php
                            $mainCurrencies[] = $currencies[0]??[];
                            @endphp
                            <div class="col-md-2 mb-4">
                                <x-form.select :is-select2="false" :is-required="true" :options="[['title'=>__($company->getMainFunctionalCurrency()) , 'value'=>$company->getMainFunctionalCurrency()]]" :add-new="false" :label="__('Main Functional Currency')" class=" main_functional_currency" :all="false" name="main_functional_currency" :selected-value="isset($model) ? $model->getMainFunctionalCurrency() : 0"></x-form.select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <x-form.select :is-select2="false" :is-required="true" :options="[['title'=>__('Existing Company' ) , 'value'=>'existing'] , ['title'=>__('New Company') ,'value'=>'new']]" :add-new="false" :label="__('Company Nature')" class=" " :all="false" name="company_nature" :selected-value="isset($model) ? $model->getCompanyNature() : 0"></x-form.select>
                            </div>

                            <div class="col-md-4 mb-4">
                                <x-form.select :options="[
																	
																	  ]" :add-new="false" :is-required="false" :label="__('To Be Consolidated To Financial Plan: (Optional)')" class="select2-select   " :all="false" name="to_be_consolidated_from_study_id" :selected-value="isset($model) ? $model->getPropertyStatus() : 0"></x-form.select>
                            </div>




                            <div class="col-md-2 mb-4">
                                <x-form.label :class="'label'" :id="'test-id'">{{ __('Study Start Date') }} @include('star') </x-form.label>
                                @include('components.calendar-month-year',[
                                'name'=>'study_start_date',
                                'value'=>$model ? $model->getStudyStartDateYearAndMonth() : now()->format('Y-m'),
                                'class'=>'recalc-study-end-date study-start-date'
                                ])
                            </div>




                            <div class="col-md-2 mb-4">
                                <x-form.select :options="$isBusinessPlan ? [
																		
																		2=>['title'=>2 ,'value'=>'2'],
																		3=>['title'=>3 ,'value'=>'3'],
																		4=>['title'=>4 ,'value'=>'4'],
																		5=>['title'=>5 ,'value'=>'5'],
																		6=>['title'=>6 ,'value'=>'6'],
																		7=>['title'=>7 ,'value'=>'7'],
																	
																	  
																	  ] :
																	  [
																		1=>['title'=>1 ,'value'=>'1'],
																		
																	  ]
																	  
																	   " :add-new="false" :is-required="true" :label="__('Study Duration In Years')" class="select2-select recalc-study-end-date study-duration" :all="false" name="duration_in_years" :selected-value="isset($model) ? $model->getDurationInYears() : 0"></x-form.select>
                            </div>





                            <div class="col-md-2 ">
                                <x-form.label :class="'label'" :id="'test-id'">{{ __('Study End Date') }} </x-form.label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input id="study-end-date" type="hidden" name="study_end_date" class=" form-control" readonly value="{{ isset($model) ? $model->getStudyEndDate() : getCurrentDateForFormDate('date') }}" />
                                        <input id="study-end-date-text" type="text" class=" form-control" readonly value="{{ isset($model) ? $model->getStudyEndDate() : getCurrentDateForFormDate('date') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>








                            <div class="col-md-2 mb-4">
                                <x-form.label :class="'label'" :id="'test-id'">{{ __('Operation Start Date') }} @include('star') </x-form.label>
                                @include('components.calendar-month-year',[
                                'name'=>'operation_start_date',
                                'value'=>$model ? $model->getOperationStartDateYearAndMonth() : now()->format('Y-m'),
                                ])
                            </div>







                            <div class="col-md-4 mb-4">
                                <x-form.select :is-select2="false" :is-required="true" :options="getFinancialMonthsForSelect()" :add-new="false" :label="__('Financial Year Start Month')" class="" :all="false" name="financial_year_start_month" :selected-value="isset($model) ? $model->financialYearStartMonth() : 'january'"></x-form.select>
                            </div>


                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Corporate Taxes Rate %') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="corporate_taxes_rate" value="{{ isset($model) ? $model->getCorporateTaxesRate() : 0 }}" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Salary Taxes Rate %') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="salary_taxes_rate" value="{{ isset($model) ? $model->getSalaryTaxesRate() : 0 }}" step="0.1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Social Insurance Rate %') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="social_insurance_rate" value="{{ isset($model) ? $model->getSocialInsuranceRate() : 0 }}" step="0.1">
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Revenues Multiplier') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="investment_return_rate" value="{{ isset($model) ? $model->getInvestmentReturnRate() : 1 }}" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('EBITDA Multiplier') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="perpetual_growth_rate" value="{{ isset($model) ? $model->getPerpetualGrowthRate() : 0 }}" step="0.1">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2 mb-4">
                                <label class="form-label font-weight-bold">{{ __('Shareholder Equity Multiplier') }} @include('star') </label>
                                <div class="kt-input-icon">
                                    <div class="input-group">
                                        <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="shareholder_equity_multiplier" value="{{ isset($model) ? $model->getShareholderEquityMultiplier() : 0 }}" step="0.1">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <br>
                        <hr>

                    </div>
                </div>
            </div>












            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> {{ __('Choose Revenue Stream Types') }} </h3>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row">

                        <div class="form-group row" style="flex:1;">
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-12 mb-0 mt-4 text-left">
                                        <div class="form-group d-inline-block">
                                            <div class="kt-radio-inline">
                                                <label class="mr-3">

                                                </label>
                                                <label class="kt-radio kt-radio--success text-black font-size-14px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_leasing" @if(isset($model) && $model->hasLeasing()) checked @endisset
                                                    > {{ __('Leasing') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-14px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_direct_factoring" @if(isset($model) && $model->hasDirectFactoring()) checked @endisset
                                                    > {{ __('Direct Factoring') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--primary text-black font-size-14px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_reverse_factoring" @if(isset($model) && $model->hasReverseFactoring()) checked @endisset
                                                    > {{ __('Reverse Factoring') }}
                                                    <span></span>
                                                </label>






                                                <label class="kt-radio kt-radio--success text-black font-size-14px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_ijara_mortgage" @if(isset($model) && $model->hasIjaraMortgage()) checked @endisset
                                                    > {{ __('Ijara Mortgage') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-14px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_portfolio_mortgage" @if(isset($model) && $model->hasPortfolioMortgage()) checked @endisset
                                                    > {{ __('Portfolio Mortgage') }}
                                                    <span></span>
                                                </label>





                                                <label class="kt-radio kt-radio--success text-black font-size-14px font-weight-bold">

                                                    <input type="checkbox" value="1" name="has_securitization" @if(isset($model) && $model->hasSecuritization()) checked @endisset
                                                    > {{ __('Securitization') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--danger text-black font-size-14px font-weight-bold">
                                                    <input type="checkbox" value="1" name="has_consumer_finance" @if(isset($model) && $model->hasConsumerFinance()) checked @endisset
                                                    > {{ __('Consumer Finance') }}
                                                    <span></span>
                                                </label>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> {{ __('Choose Microfinance') }} </h3>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr style="flex:1;background-color:lightgray">
                    </div>
                    <div class="row">

                        <div class="form-group row" style="flex:1;">
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-12 mb-0 mt-4 text-left">
                                        <div class="form-group d-inline-block">
                                            <div class="kt-radio-inline">
                                                <label class="mr-3">
                                                </label>
                                                <label class="kt-radio kt-radio--primary text-black font-size-14px font-weight-bold">
                                                    <input class="microfinance-checkbox-js" type="checkbox" value="1" name="has_micro_finance" @if(isset($model) && $model->hasMicroFinance()) checked @endisset
                                                    > {{ __('Micro Finance') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--success text-black font-size-14px font-weight-bold show-only-with-microfinance ">
                                                    <input class=" microfinance-sub-checkbox-js is-whole-company" type="radio" value="whole-company" name="microfinance_type" @if(isset($model) && $model->isWholeCompanyMicrofinance()) checked @endisset
                                                    > {{ __('All Branches') }}
                                                    <span></span>
                                                </label>

                                                <label class="kt-radio kt-radio--warning text-black font-size-14px font-weight-bold show-only-with-microfinance ">
                                                    <input class=" microfinance-sub-checkbox-js is-by-branch" type="radio" value="by-branch" name="microfinance_type" @if(isset($model) && $model->isByCompanyMicrofinance()) checked @endisset
                                                    > {{ __('By Branch') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group d-inline-block ml-3 no-branch-div hidden min-w-400">
                                            <x-form.select :multiple="true" name="microfinance_branch_ids[]" :selectedValue="isset($model) ? $model->getMicrofinanceBranches() : ''" :options="$formattedExistingBranches" :add-new="false" class="select2-select repeater-select  " :all="false"></x-form.select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 mb-0 mt-4 text-left">
                                        <div class="form-group d-inline-block">
                                            <div class="kt-radio-inline">
                                                <label class="mr-3">
                                                </label>
                                                <label class="kt-radio kt-radio--primary text-black font-size-14px font-weight-bold show-only-with-microfinance">
                                                    {{ __('Do You Want To Create Product Mix') }}
                                                </label>

                                                <label class="kt-radio kt-radio--success  text-black font-size-14px font-weight-bold show-only-with-microfinance ">
                                                    <input class=" create-product-or-existing-branch-js" type="radio" value="product-mix" name="microfinance_product_mix_or_existing_branch" @if(isset($model) && $model->isMicrofinanceProductMix()) checked @endisset
                                                    > {{ __('Yes') }}
                                                    <span></span>
                                                </label>
												
												 {{-- <div class="col-md-1 "> --}}
                                        {{-- <label class="form-label font-weight-bold">{{ __('Products Mix Count') }} @include('star') </label> --}}
										<div class="d-inline-block hidden product-mix-count-parent-js mr-2">
												<span class="text-black font-weight-bold">{{ __('Insert Count') }}</span>
										</div>
                                        <div class="kt-input-icon max-w-100 d-inline-block hidden product-mix-count-parent-js">
                                            <div class="input-group">
                                                <input placeholder="{{ __('Product Mix Count') }}" type="text" class="form-control only-greater-than-zero-allowed" name="microfinance_product_mix_count" value="{{ isset($model) ? $model->getMicrofinanceProductMixCount() : 1 }}">
                                            </div>
                                        </div>
                                    {{-- </div> --}}

                                                <label class="kt-radio kt-radio--primary text-black font-size-14px font-weight-bold show-only-with-microfinance">
                                                    {{ __('Each Existing Branch Has Its Own') }}

                                                </label>

                                                <label class="kt-radio kt-radio--warning text-black font-size-14px font-weight-bold show-only-with-microfinance ">
                                                    <input class="create-product-or-existing-branch-js" type="radio" value="existing-branch" name="microfinance_product_mix_or_existing_branch" @if(isset($model) && $model->isMicrofinanceExistingBranch()) checked @endisset
                                                    > {{ __('Yes') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group d-inline-block ml-3 no-branch-div hidden min-w-400">
                                            <x-form.select :multiple="true" name="microfinance_branch_ids[]" :selectedValue="isset($model) ? $model->getMicrofinanceBranches() : ''" :options="$formattedExistingBranches" :add-new="false" class="select2-select repeater-select  " :all="false"></x-form.select>
                                        </div> --}}
                                    </div>
                                </div>

                                {{-- <div class="row">
                                   
                                </div> --}}

                            </div>
                        </div>
                    </div>

                </div>
            </div>


            {{-- <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="d-flex align-items-center ">
                                <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> {{ __('Existing Branches Info') }} </h3>
    </div>
</div>

</div>
<div class="row">
    <hr style="flex:1;background-color:lightgray">
</div>
<div class="row">

    <div class="form-group row" style="flex:1;">
        <div class="col-md-3 mb-4">
            <label class="form-label font-weight-bold">{{ __('Microfinance Branches Count') }} </label>
            <div class="kt-input-icon">
                <div class="input-group">
                    <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="microfinance_branches_count" value="{{ isset($model) ? $model->getMicrofinanceBranchesCount() : 0 }}" step="1">
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <label class="form-label font-weight-bold">{{ __('Microfinance Loan Officer Count') }} </label>
            <div class="kt-input-icon">
                <div class="input-group">
                    <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="microfinance_loan_officer_count" value="{{ isset($model) ? $model->getMicrofinanceLoanOfficerCount() : 0 }}" step="1">
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <label class="form-label font-weight-bold">{{ __('Consumer Finance Branches Count') }} </label>
            <div class="kt-input-icon">
                <div class="input-group">
                    <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="consumerfinance_branches_count" value="{{ isset($model) ? $model->getConsumerfinanceBranchesCount() : 0 }}" step="1">
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <label class="form-label font-weight-bold">{{ __('Consumer Finance Loan Officer Count') }} </label>
            <div class="kt-input-icon">
                <div class="input-group">
                    <input type="number" class="form-control only-greater-than-or-equal-zero-allowed" name="consumerfinance_loan_officer_count" value="{{ isset($model) ? $model->getConsumerfinanceLoanOfficerCount() : 0 }}" step="1">
                </div>
            </div>
        </div>


    </div>
</div>

</div>
</div> --}}




<div class="kt-portlet">
    <div class="kt-portlet__body">
        <x-save-or-back :btn-text="__('Create')" />
    </div>
</div>




<!--end::Form-->

<!--end::Portlet-->
</div>


</div>

</div>




</div>









</div>
</div>
</form>

</div>
@endsection
@section('js')
<x-js.commons></x-js.commons>
<script src="/custom/js/non-banking-services/common.js"></script>
<script src="/custom/js/non-banking-services/select2.js"></script>
<script>
    $(document).on('change', '.recalc-study-end-date', function(e) {
        e.preventDefault()
        let startDate = $('.study-start-date').val() + '-01';
        const studyStartDate = new Date($('.study-start-date').val());
        const studyDuration = parseFloat($('.study-duration option:selected').attr('value'));
        if (studyDuration || studyDuration == '0') {
            const numberOfMonths = (studyDuration * 12) - 1
            let studyEndDate = studyStartDate.addMonths(numberOfMonths)
            let dateFormattedForView = new Date(studyEndDate.getFullYear(), studyEndDate.getMonth() + 1, 0)
            $('#study-end-date-text').val(convertDateToDefaultDateFormat(formatDate(dateFormattedForView)))
            studyEndDate = convertDateToDefaultDateFormat(formatDate(studyEndDate))
            $('#study-end-date').val(studyEndDate).trigger('change')

        }

    })

    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {
            let form = document.getElementById('form-id');
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);

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

@endsection
