<div data-card-id="{{ $cardId }}" class="kt-portlet parent-card ">
            <div class="kt-portlet__body">
 @php
                            $numberOfPositions = $department ? $department->no_positions : 1 ;
							$initialDepartmentIndex = isset($initialDepartmentIndex) ? $initialDepartmentIndex :  0 ; 
						
							
                            @endphp
                <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="{{ $storeDepartmentPositionsRoute }}">
                    @include('non_banking_services.manpower._input-hidden')
                    {{-- start of fixed monthly repeating amount --}}

                
                    <input type="hidden" name="tableIds[]" value="{{ $tableId }}">
                    
                    <x-tables.repeater-table :addExpenseType="true" :initEmpty="false" :removeActionBtn="true" :first-element-deletable="false" :font-size-class="'font-14px'" :department="$department" :departmentId="is_object($department) ? $department->id :$initialDepartmentIndex" :showRows="is_object($department)" :add-expense-name="true" :append-save-or-back-btn="true" :repeater-with-select2="false" :parentClass="'js-toggle-visibility-----'" :tableName="$department ? $tableId.$department->id : $tableId " :repeaterId="$repeaterId" :relationName="'food'" :isRepeater="$isRepeater=!(isset($removeRepeater) && $removeRepeater)">
                        <x-slot name="ths">
                            <x-tables.repeater-table-th :font-size-class="'font-14px'" class="  header-border-down first-column-th-class" :title="__('Actions')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th :font-size-class="'font-14px'" class="  header-border-down first-column-th-class" :title="__('Position')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th :font-size-class="'font-14px'" class=" tenor-selector-class header-border-down " :title="__('Existing <br> Count')"></x-tables.repeater-table-th>
                            <x-tables.repeater-table-th :font-size-class="'font-14px'" class=" tenor-selector-class header-border-down " :title="__('Monthly Net <br> Salary')"></x-tables.repeater-table-th>
                            @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)
							@php
								$currentMonthNumber = explode('-',$dateAsString)[1];
								$currentYear= explode('-',$dateAsString)[0];
								$currentYearRepeaterIndex = 0 ;
							@endphp
								
                            <x-tables.repeater-table-th  data-column-index="{{ $dateAsIndex }}" :font-size-class="'font-14px'" class=" interval-class header-border-down " :title="dateFormatting($dateAsString, 'M\' Y') . ' <br> ' .__('Hiring #')"></x-tables.repeater-table-th>
								@if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last)
									  <x-tables.repeater-table-th :icon="true" data-column-index="{{ $dateAsIndex }}" :font-size-class="'font-14px'" class=" tenor-selector-class header-border-down {{ 'year-repeater-index-'.$currentYearRepeaterIndex }} collapse-before-me exclude-from-collapse" :title="__('Total Yr.').' <br> '. $currentYear"></x-tables.repeater-table-th>
									  @php
										$currentYearRepeaterIndex ++;
									  @endphp
								@endif 
								
                            @endforeach
                        </x-slot>
                        <x-slot name="trs">
                           
                            @for($rowIndex = 0 ; $rowIndex< $numberOfPositions ; $rowIndex++ ) 
							@php $departmentId=$department ? $department->id : $initialDepartmentIndex ;
                                $currentPosition = isset($department->positions[$rowIndex]) ? $department->positions[$rowIndex] : null ;

                                @endphp
                                <tr {{-- data-repeater-item --}} data-repeat-formatting-decimals="2" data-repeater-style>

                                    <td class="text-center">
                                        @if($currentPosition)
                                        <div class="">
                                            <a href="{{ route('delete.single.position',['company'=>$company->id,'position'=>$currentPosition->id , 'study'=>$study->id]) }}">
                                                <i class="btn-sm btn cursor-pointer btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                                </i>
                                            </a>
                                        </div>
                                        @endif
                                    </td>

                                    <input type="hidden" name="departments[{{ $departmentId }}][positions][{{ $rowIndex	 }}][id]" value="{{ $currentPosition ? $currentPosition->id : 0 }}">
                                    {{-- <input type="hidden" name="id" value="{{ isset($subModel) ? $subModel->id : 0 }}"> --}}

                                    <td>
                                        <div class="">
                                            <input value="{{ $currentPosition ? $currentPosition->getName() : '' }}" name="departments[{{ $departmentId }}][positions][{{ $rowIndex	 }}][name]" class="form-control text-left mt-2" type="text">

                                        </div>
                                    </td>
                                    <td>


                                        <div class="">
                                            <input value="{{ $currentPosition ? $currentPosition->getExistingCount():0 }}" name="departments[{{ $departmentId }}][positions][{{ $rowIndex}}][existing_count]" class="form-control expandable-percentage-input text-left mt-2" type="text">

                                        </div>
                                    </td>
                                    <td>


                                        <div class="">
                                            <input value="{{ $currentPosition ? $currentPosition->getMonthlyNetSalary() : 0 }}" name="departments[{{ $departmentId }}][positions][{{ $rowIndex}}][monthly_net_salary]" class="form-control expandable-amount-input text-left mt-2" type="text">
                                        </div>
                                    </td>
                                    @php
                                    $columnIndex = 0 ;
                                    $currentVal = 0 ;
									$currentYearRepeaterIndex =  0 ;
                                    @endphp
								
                                    @foreach($studyMonthsForViews as $dateAsIndex=>$dateAsString)

                                    <td data-column-index="{{ $dateAsIndex }}">
                                        <div class="d-flex align-items-center justify-content-center">
                                            @php
                                            $name = "departments[$departmentId][positions][$rowIndex][hiring_counts][$dateAsIndex]";
                                            @endphp
                                            <x-repeat-right-dot-inputs :number-format-decimals="0" :mark="' '" :currentVal="$currentPosition ? $currentPosition->getHiringCountsAtDateIndex($dateAsIndex) : 0 " data-group-index="{{ $currentYearRepeaterIndex }}" :classes="'repeater-with-collapse-input only-greater-than-or-equal-zero-allowed '" :is-percentage="true" :name="$name" :columnIndex="$columnIndex"></x-repeat-right-dot-inputs>
                                        </div>
                                    </td>
									@php
											$currentMonthNumber = explode('-',$dateAsString)[1];
											$currentYear= explode('-',$dateAsString)[0];
										@endphp
										
							
							@if($financialYearEndMonthNumber == $currentMonthNumber || $loop->last)
							         <td data-column-index="{{ $dateAsIndex }}" class="exclude-from-collapse">
                                        <div class="d-flex align-items-center justify-content-center">
									      <x-repeat-right-dot-inputs :readonly="true" :removeThreeDots="true" :number-format-decimals="0" :mark="' '" :currentVal="0 " :formattedInputClasses="'exclude-from-collapse'" :classes="'year-repeater-index-'.$currentYearRepeaterIndex.' ' .'only-greater-than-or-equal-zero-allowed exclude-from-collapse'" :is-percentage="true" :name="''" :columnIndex="$dateAsIndex"></x-repeat-right-dot-inputs>
										  </div>	
										  
										  </td>
										  @php
											$currentYearRepeaterIndex++;
										  @endphp
								@endif 
								
                                    @php
                                    $columnIndex++;
                                    @endphp
                                    @endforeach



                                </tr>
                                @endfor
                        </x-slot>





                    </x-tables.repeater-table>
                



                    {{-- end of fixed monthly repeating amount --}}
                </form>


            </div>
    </div> 
