
                        {{-- start of fixed monthly repeating amount --}}
                        @php
                        $tableId = 'percentage_of_sales';
                        $repeaterId = 'percentage_of_sales_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                        <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Existing <br> Expense')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('New <br> Expense Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Percentage <br> Of')" :helperTitle="__('Percentage Of')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Revenue <br> Stream')" :helperTitle="__('Revenue Stream')"></x-tables.repeater-table-th>

                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th>

                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="header-border-down rate-class" :title="__('Monthly <br> (%)')" :helperTitle="__('Please insert percentage excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                {{-- <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> To')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> Value A')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Conditional <br> Value B')"></x-tables.repeater-table-th> --}}
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>





                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof Expense) ){
                                unset($subModel);
                                }

                                @endphp

                                <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>



                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
                                    </td>

                                    <td>
                                        <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPercentageOf() : 'service'" :options="getExpensesPercentageOfForSelect2()" :multiple="false" :add-new="false" class="select2-select repeater-select percentage-of-stream-type-js  " :all="false" name="@if($isRepeater) percentage_of @else {{ $tableId }}[0][percentage_of] @endif"></x-form.select>

                                    </td>

                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getRevenueStreamTypes() : 'service'" :options="$revenueStreamTypes" :multiple="true" :add-new="false" class="select2-select repeater-select revenue-stream-type-js  " :all="false" name="@if($isRepeater) revenue_stream_type @else {{ $tableId }}[0][revenue_stream_type] @endif"></x-form.select>

                                    </td>

                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategoryIds() : ''" :multiple="true" :options="[]" :add-new="false" class="select2-select repeater-select stream-category-class " :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                                    </td>




                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                                    </td>
                                    <td>

                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getMonthlyPercentage(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getMonthlyPercentage() : 2) }}" @if($isRepeater) name="monthly_percentage" @else name="{{ $tableId }}[0][monthly_percentage]" @endif>
                                        </div>
                                    </td>
                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar>
                                    </td>



                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                        <x-modal.custom-collection :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 2) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 2) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                                        </div>
                                    </td>





                                </tr>
                                @endforeach

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed monthly repeating amount --}}














                        {{-- start of fixed cost per unit --}}
                        @php
                        $tableId = 'cost_per_unit';
                        $repeaterId = 'cost_per_unit_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                        <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="''" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Existing <br> Expense')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('New <br> Expense Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Revenue <br> Stream')" :helperTitle="__('Revenue Stream')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Stream <br> Category')"></x-tables.repeater-table-th>

                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Cost <br> Per Unit')" :helperTitle="__('Please insert Cost Per Unit excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('End <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof Expense) ){
                                unset($subModel);
                                }

                                @endphp
                                <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>


                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
                                    </td>

                                    <td>
                                        <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                                    </td>

                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getRevenueStreamTypes() : 'service'" :options="$revenueStreamTypes" :multiple="true" :add-new="false" class="select2-select repeater-select  revenue-stream-type-js" :all="false" name="@if($isRepeater) revenue_stream_type @else {{ $tableId }}[0][revenue_stream_type] @endif"></x-form.select>
                                    </td>


                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getStreamCategory() : ''" :options="getAllocationsBases()" :multiple="true" :add-new="false" class="select2-select repeater-select  stream-category-class" :all="false" name="@if($isRepeater) stream_category_ids @else {{ $tableId }}[0][stream_category_ids] @endif"></x-form.select>

                                    </td>




                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                                    </td>
                                    <td>
                                        <input value="{{ (isset($subModel) ? number_format($subModel->getMonthlyCostOfUnit(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getMonthlyCostOfUnit() : 0) }}" @if($isRepeater) name="monthly_cost_of_unit" @else name="{{ $tableId }}[0][monthly_cost_of_unit]" @endif>

                                    </td>


                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getEndDateFormatted() : $study->getStudyEndDate() " :id="'end_date'" name="end_date"></x-calendar>
                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                        <x-modal.custom-collection :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection>


                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 2) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 2) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 2) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

                                        </div>
                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

                                    </td>


                                </tr>
                                @endforeach

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of fixed cost per unit --}}













                        {{-- start of fixed cost per unit --}}
                        @php
                        $tableId = 'expense_per_employee';
                        $repeaterId = 'expense_per_employee_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                        <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Existing <br> Expense')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('New <br> Expense Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Department')" :helperTitle="__('Department')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Employee <br> Position')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Start <br> Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Monthly Cost <br> Per Unit')" :helperTitle="__('Please insert Cost Per Unit excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Increase <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Increase <br> Interval')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof Expense) ){
                                unset($subModel);
                                }

                                @endphp
                                <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>



                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>

                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>
                                    </td>

                                    <td>
                                        <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                                    </td>

                                    <td>
                                        {{-- this must be multiselect --}}
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getDepartment() : 'department'" :options="[]" :add-new="false" class="select2-select repeater-select  " :all="false" name="@if($isRepeater) department @else {{ $tableId }}[0][department] @endif"></x-form.select>

                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getEmployee() : 'employee'" :options="[]" :add-new="false" class="select2-select repeater-select  " :all="false" name="@if($isRepeater) employee @else {{ $tableId }}[0][employee] @endif"></x-form.select>

                                    </td>
                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                                    </td>
                                    <td>
                                        <input value="{{ (isset($subModel) ? number_format($subModel->getMonthlyCostOfUnit(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getMonthlyCostOfUnit() : 0) }}" @if($isRepeater) name="monthly_cost_of_unit" @else name="{{ $tableId }}[0][monthly_cost_of_unit]" @endif>

                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select  payment_terms" :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                        <x-modal.custom-collection :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection>


                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 2) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 2) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getIncreaseRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getIncreaseRate() : 2) }}" @if($isRepeater) name="increase_rate" @else name="{{ $tableId }}[0][increase_rate]" @endif>

                                        </div>
                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getIncreaseInterval() : 'annually' " :options="getDurationIntervalTypesForSelectExceptMonthly()" :add-new="false" class="select2-select   repeater-select" :all="false" name="@if($isRepeater) increase_interval @else {{ $tableId }}[0][increase_interval] @endif" id="{{$type.'_'.'duration_type' }}"></x-form.select>

                                    </td>


                                </tr>
                                @endforeach

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of expense per employee --}}









                        {{-- start of one time expense --}}
                        @php
                        $tableId = 'one_time_expense';
                        $repeaterId = 'one_time_expense_repeater';

                        @endphp
                        <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                        <x-tables.repeater-table :repeater-with-select2="true" :parentClass="'js-toggle-visibility'" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                            <x-slot name="ths">
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Existing <br> Expense')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('New <br> Expense Name')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Date')" :helperTitle="__('Default date is Income Statement start date, if else please select a date')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Amount')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-2 header-border-down" :title="__('Payment <br> Terms')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('VAT <br> Rate')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down" :title="__('Is <br> Deductible')"></x-tables.repeater-table-th>
                                <x-tables.repeater-table-th class="col-md-1 header-border-down rate-class" :title="__('Withhold <br> Tax Rate')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th>
                            </x-slot>
                            <x-slot name="trs">
                                @php
                                $rows = isset($model) ? $model->generateRelationDynamically($tableId,$expenseType)->get() : [-1] ;
                                @endphp
                                @foreach( count($rows) ? $rows : [-1] as $subModel)
                                @php
                                if( !($subModel instanceof Expense) ){
                                unset($subModel);
                                }

                                @endphp
                                <tr @if($isRepeater) data-repeater-item data-repeater-style @endif>
                                    <td class="text-center">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>

                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseCategory() : 'cash'" :options="getExpenseCategoriesForSelect2()" :add-new="false" class="select2-select repeater-select expense_category " :all="false" name="@if($isRepeater) expense_category @else {{ $tableId }}[0][expense_category] @endif"></x-form.select>

                                    </td>
                                    <td>
                                        <input value="{{ isset($subModel) ?  $subModel->getName() : old('name') }}" class="form-control" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif type="text">
                                    </td>

                                    <td>
                                        <x-calendar :value="isset($subModel) ? $subModel->getStartDateFormatted() : $study->getStudyStartDate() " :id="'start_date'" name="start_date"></x-calendar>
                                    </td>
                                    <td>
                                        <input value="{{ (isset($subModel) ? number_format($subModel->getAmount(),0) : 0) }}" class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
                                        <input type="hidden" value="{{ (isset($subModel) ? $subModel->getAmount() : 0) }}" @if($isRepeater) name="amount" @else name="{{ $tableId }}[0][amount]" @endif>

                                    </td>
                                    <td>
                                        <x-form.select :selectedValue="isset($subModel) ? $subModel->getPaymentTerm() : 'cash'" :options="getPaymentTerms()" :add-new="false" class="select2-select repeater-select payment_terms " :all="false" name="@if($isRepeater) payment_terms @else {{ $tableId }}[0][payment_terms] @endif"></x-form.select>
                                        <x-modal.custom-collection :subModel="isset($subModel) ? $subModel : null " :tableId="$tableId" :isRepeater="$isRepeater" :id="$repeaterId.'test-modal-id'"></x-modal.custom-collection>


                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getVatRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getVatRate() : 2) }}" @if($isRepeater) name="vat_rate" @else name="{{ $tableId }}[0][vat_rate]" @endif>

                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input @if($isRepeater) name="is_deductible" @else name="{{ $tableId }}[0][is_deductible]" @endif class="form-control max-w-checkbox  text-center" value="1" @if(isset($subModel) ? $subModel->isDeductible() : false) checked @endif type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getWithholdTaxRate(),PERCENTAGE_DECIMALS) : "0.00" }}" type="text">
                                            <span style="margin-left:3px	">%</span>
                                            <input type="hidden" value="{{ (isset($subModel) ? $subModel->getWithholdTaxRate() : 2) }}" @if($isRepeater) name="withhold_tax_rate" @else name="{{ $tableId }}[0][withhold_tax_rate]" @endif>
                                        </div>
                                    </td>




                                </tr>
                                @endforeach

                            </x-slot>




                        </x-tables.repeater-table>
                        {{-- end of one time expense --}}
