 {{-- start of fixed monthly repeating amount --}}
 
                    @php
                    $repeaterId = $tableId.'_repeater';
					use App\Formatter\Select2Formatter; 
					use App\Models\NonBankingService\Position;
                    @endphp
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                    <x-tables.repeater-table :removeRepeater="false" :repeater-with-select2="true" :canAddNewItem="$canAddNewItem" :parentClass="'js-remove-hidden'" :hide-add-btn="true" :tableName="$tableId" :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                        <x-slot name="ths">
                            <x-tables.repeater-table-th class=" category-selector-class header-border-down  " :title="__('Position Name')"></x-tables.repeater-table-th>
                            {{-- <x-tables.repeater-table-th class="category-selector-class header-border-down " :title="__('Expense <br> Type')" :helperTitle="__('If you have different expense items under the same category, please insert Category Name')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class="loan-type-class header-border-down " :title="__('Loan <br> Type')" :helperTitle="__('Please insert amount excluding VAT')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" rate-class header-border-down " :title="__('Position <br> Counts')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" rate-class header-border-down " :title="__('Grace <br> Period')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" rate-class header-border-down " :title="__('Spread <br> Rate')" :helperTitle="__('You can either choose one of the system default terms (cash, quarterly, semi-annually, or annually), if else please choose Customize to insert your payment terms')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" rate-class header-border-down " :title="__('Pricing <br> Rate')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Installment <br> Interval')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" rate-class header-border-down " :title="__('Step <br> Rate (+/-)')" :helperTitle="__('Withhold Tax rate will be calculated based on Monthly Amount excluding VAT')"></x-tables.repeater-table-th> --}}
                            {{-- <x-tables.repeater-table-th class=" interval-class header-border-down " :title="__('Step <br> Interval')"></x-tables.repeater-table-th> --}}
                        </x-slot>
                        <x-slot name="trs">
                            @php
                            $rows = isset($model) ? $model->positions : [-1] ;
                            @endphp
                            @foreach( count($rows) ? $rows : [-1] as $subModel)
                            @php
                            if( !($subModel instanceof Position) ){
                            unset($subModel);
                            }
                            @endphp
                            <tr data-repeater-style="{{ $isRepeater ? 1 : -1 }}" @if($isRepeater) data-repeater-item @endif>
                                <td class="text-center">
                                    <div class="">
                                        <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                        </i>
                                    </div>
                                </td>


                                <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}">
								
								    <td>
 									<input value="{{ (isset($subModel) ?$subModel->getName() : '') }}" @if($isRepeater) name="name" @else name="{{ $tableId }}[0][name]" @endif class="form-control text-center " type="text">
                                </td>
                                {{-- <td>
                                    <div class="d-flex align-items-center ">
									  <x-form.select :selectedValue="isset($subModel) ? $subModel->getExpenseTypeId() : '' " :options="Select2Formatter::formatForIndexedArr(getExpenseTypes())" :add-new="false" class="select2-select   repeater-select"  :all="false" name="{{ $isRepeater ? 'expense_type':$tableId.'[0][expense_type]' }}" ></x-form.select>
                                    </div>
                                </td>
                              
                                <td>
                                    <input value="{{ (isset($subModel) ? number_format($subModel->getNoPositions(),0) : 12) }}" @if($isRepeater) name="no_positions" @else name="{{ $tableId }}[0][no_positions]" @endif class="form-control text-center only-greater-than-zero-allowed" type="text">

                                </td> --}}
                                {{-- <td>
								 <input value="{{ (isset($subModel) ? number_format($subModel->getGracePeriod(),0) : 0) }}" @if($isRepeater) name="grace_period" @else name="{{ $tableId }}[0][grace_period]" @endif class="form-control text-center only-greater-than-or-equal-zero-allowed" type="text">
							    </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input @if($isRepeater) name="margin_rate" @else name="{{ $tableId }}[0][margin_rate]" @endif class="form-control only-percentage-allowed text-center" value="{{ isset($subModel) ? number_format($subModel->getMarginRate(),PERCENTAGE_DECIMALS):0  }}" type="text">
                                        <span style="margin-left:3px	">%</span>

                                    </div>
                                </td>



                                <td>
                                     <x-form.select :selectedValue="isset($subModel) ? $subModel->getInstallmentInterval() : 'monthly' " :options="[['title'=>__('Monthly'),'value'=>'monthly'],['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')]]" :add-new="false" class="select2-select   repeater-select"  :all="false" name="{{ $isRepeater ? 'installment_interval':$tableId.'[0][installment_interval]' }}" ></x-form.select>
                                </td>


                                <td>
                                    <div class="d-flex align-items-center">
                                        <input @if($isRepeater) name="step_rate" @else name="{{ $tableId }}[0][step_rate]" @endif class="form-control only-percentage-allowed-between-minus-plus-hundred text-center" value="{{ isset($subModel) ? $subModel->getStepRate() : 0 }}" type="text">
                                        <span style="margin-left:3px	">%</span>

                                    </div>
                                </td>
                                <td>
                                    <x-form.select :selectedValue="isset($subModel) ? $subModel->getStepInterval() : 'annually' " :options="[['title'=>__('Quarterly'),'value'=>'quartly'],['value'=>'semi annually','title'=>__('Semi-annually')],['title'=>__('Annually'),'value'=>'annually']]" :add-new="false" class="select2-select   repeater-select"  :all="false" name="{{ $isRepeater ? 'step_interval':$tableId.'[0][step_interval]' }}" ></x-form.select>
                                </td> --}}


                            </tr>
                            @endforeach

                        </x-slot>




                    </x-tables.repeater-table>
                    {{-- end of fixed monthly repeating amount --}}
