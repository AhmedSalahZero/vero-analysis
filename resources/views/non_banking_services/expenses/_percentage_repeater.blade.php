@foreach(count($expenses) ? $expenses : [null] as $expense)
<div data-repeater-item class="form-group  row align-items-center 
 m-form__group

 repeater_item
common-parent
 ">

    <div class="max-w-13 pr-2 pl-4">

        <x-form.select :label="__('Expense Category')" :selectedValue="isset($subModel) ? $subModel->getCategoryId() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="expense_category"></x-form.select>




    </div>
    <input type="hidden" name="id" value="{{ isset($expense) ? $expense->id:0 }}">
    <div class="col-md-2 pr-2 pl-4">
        <x-form.select :label="__('Expense Name')" data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="expense_name_id"></x-form.select>

    </div>
	


    <div class="max-w-8 pr-2 pl-2">
        <label class="form-label ">{{ __('Expense %') }} </label>
        <div class="kt-input-icon">
            <div class="input-group">
                <input type="text" class="form-control only-percentage-allowed " name="monthly_percentage" value="{{ isset($expense) ? $expense->getMonthlyPercentage() : old('monthly_percentage',0) }}">
            </div>
        </div>
    </div>
	<div class="max-w-10 pr-2 pl-4">
	                                        <x-form.select :label="__('Percentage Of')"  :selectedValue="isset($subModel) ? $subModel->getPercentageOf() : 'service'" :options="getExpensesPercentageOfForSelect2()" :multiple="false" :add-new="false" class="select2-select repeater-select percentage-of-stream-type-js  " :all="false" name="percentage_of"></x-form.select>

        {{-- <x-form.select data-current-selected="{{ isset($subModel) ? $subModel->getExpenseNameId() : '' }}" :selectedValue="isset($subModel) ? $subModel->getExpenseNameId() : ''" :options="[]" :add-new="false" class="select2-select repeater-select expense_name_id " :all="false" name="expense_name_id"></x-form.select> --}}

    </div>
	
    <div class="col-md-2 pr-2 pl-2">
        <label class="form-label ">{{ __('Revenue Streams') }} </label>
        <div class="kt-input-icon">
            <div class="input-group">
			
                <x-select.multi-layer-for-repeater :selectedOptions="$expense ? $expense->getProductArr() : []" :name="'products'" :options="[]"></x-select.multi-layer-for-repeater>
            </div>
        </div>
    </div>



    <div class="pr-2 pl-2">
        <label class="form-label ">{{ __('Start Date') }} </label>

        @include('components.calendar-month-year',[
        'name'=>'start_date',
        'value'=>$expense ? $expense->getStartDateYearAndMonth() : $study->getDefaultStartDateAsYearAndMonth()
        ])

    </div>

    <div class="pr-2 pl-2">
        <label class="form-label ">{{ __('End Date') }} </label>
        @include('components.calendar-month-year',[
        'name'=>'end_date',
        'value'=>$expense ? $expense->getEndDateYearAndMonth() : $study->getDefaultEndDateAsYearAndMonth()
        ])

    </div>


    <div class="pr-2 pl-2 closest-parent">
        <label class="form-label ">{{ __('Payment') }} </label>
        <x-form.select :selectedValue="isset($expense) ? $expense->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="payment_terms"></x-form.select>
        <x-modal.custom-collection :title="__('Custom Payment')" :subModel="isset($expense) ? $expense : null "></x-modal.custom-collection>

    </div>





    <div style="max-width:40px;" class=" ">
        <div class="d-flex flex-column">
            <label for="" class="visibility-hidden">delete</label>
            <input data-repeater-delete type="button" class="btn btn-danger btn-md ml-2" value="{{ __('X') }}">
        </div>
    </div>

</div>

@endforeach
