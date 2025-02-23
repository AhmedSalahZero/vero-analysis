
					
						<tr class="edit-info-row add-sub maintable-1-row-class{{ $rowIndex }} is-sub-row d-none">
                                            <td class=" reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize is-close "></td>
                                            <td class="sub-text-bg max-w-classes-name is-name-cell ">
											<div class="ml-son">
											{{ $currentSubRowKeyName }}
											</div>
											{{-- {{ $result[$mainReportKey][$parentKeyName][$currentSubRowKeyName]['sub_key'] ?? '-' }} --}}
											
											</td>
                                            <td class="sub-text-bg"></td>
                                            {{-- <td class="sub-text-bg max-w-classes-name editable editable-text is-name-cell ">{{$currentSubRowKeyName }}</td> --}}
                                             @foreach($weeks as $weekAndYear => $week)
											 @php
											 	$currentValue = $result[$mainReportKey][$parentKeyName][$currentSubRowKeyName]['weeks'][$weekAndYear] ?? 0;
												if($currentSubRowKeyName == 'Suppliers Past Due Invoices' )
												{
													$startDate = $dates[$weekAndYear]['start_date'] ;
													$currentRow = $supplierDueInvoices->where('week_start_date',$startDate)->first() ;
													$currentValue =$currentRow ?  $currentRow->amount : 0;
												}
											 @endphp
                                            <td class="  sub-numeric-bg text-center editable-date">{{ number_format($currentValue) }}</td>
                                            @endforeach
											@php
												$currentSubTotal = $result[$mainReportKey][$parentKeyName][$currentSubRowKeyName]['total'] ?? 0 ;
												$currentSubTotal = is_array($currentSubTotal) ? 0 : $currentSubTotal;
											@endphp
                                    <td class="  sub-numeric-bg text-center editable-date">{{ number_format($currentSubTotal) }}</td>
											
                                        
                        </tr>
