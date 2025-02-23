
					
					 <tr class=" @if($customerName == __('Total Cash Inflow') || $customerName == __('Total Cash Outflow') ||  $customerName == __('Total Cash')) bg-lighter @else  @endif  parent-tr reset-table-width text-nowrap  cursor-pointer sub-text-bg text-capitalize is-close   " data-model-id="{{ $rowIndex }}">
                                    <td class="red reset-table-width text-nowrap trigger-child-row-1 cursor-pointer sub-text-bg text-capitalize main-tr is-close"> @if($hasSubRows) + @endif  </td>
                                    <td class="sub-text-bg   editable-text  max-w-classes-name is-name-cell ">{{ $customerName }}</td>
                                    <td class="  sub-numeric-bg text-center editable-date"> 
										@if($customerName == __('Customers Past Due Invoices'))
										<button   class="btn btn-sm btn-warning text-white js-show-customer-due-invoices-modal">{{ __('View') }}</button>
                                                <x-modal.due-invoices :report-interval="$reportInterval" :currentInvoiceType="'CustomerInvoice'" :dates="$dates" :weeks="$weeks" :pastDueCustomerInvoices="$pastDueCustomerInvoices" :id="'test-modal-id'"></x-modal.due-invoices>
										
										@endif 
										
											@if($customerName == 'Suppliers Past Due Invoices')
												<button   class="btn btn-sm btn-warning text-white js-show-customer-due-invoices-modal">{{ __('View') }}</button>
                                                <x-modal.due-invoices :report-interval="$reportInterval" :currentInvoiceType="'SupplierInvoice'" :dates="$dates" :weeks="$weeks" :pastDueCustomerInvoices="$pastDueSupplierInvoices" :id="'test-modal-id'"></x-modal.due-invoices>
										
											@endif 
									
									 </td>
                                    @foreach($weeks as $weekAndYear => $week)
                                    @php
								
									$year = explode('-',$weekAndYear)[1];
									
                                    $currentValue = 0 ;
										$currentMainRowTotal = $result[$mainReportKey][$parentKeyName]['total']['total_of_total']??0;
									if(isset($result[$mainReportKey][$parentKeyName]['weeks'][$weekAndYear]))
									{
										$currentValue = $result[$mainReportKey][$parentKeyName]['weeks'][$weekAndYear];
									}
									if(isset($isTotalRow) && isset($result[$mainReportKey][$parentKeyName]['total'][$weekAndYear])){
										$currentValue = $result[$mainReportKey][$parentKeyName]['total'][$weekAndYear];
									}
									if($customerName == __('Customers Past Due Invoices') )
									{
										$startDate = $dates[$weekAndYear]['start_date'] ;
										$currentRow = $customerDueInvoices->where('week_start_date',$startDate)->first() ;
										$currentValue =$currentRow ?  $currentRow->amount : 0;
										
									
									}
									if($customerName == __('Suppliers Past Due Invoices') )
									{
										$startDate = $dates[$weekAndYear]['start_date'] ;
										$currentRow = $supplierDueInvoices->where('week_start_date',$startDate)->first() ;
										$currentValue =$currentRow ?  $currentRow->amount : 0;
									}
                                    @endphp
									
                                    <td class="  sub-numeric-bg text-center editable-date">{{ number_format($currentValue,0) }}</td>
                                    @endforeach
									
                                   
                                    <td class="  sub-numeric-bg text-center editable-date">{{ number_format(  $currentMainRowTotal ) }}  </td>

                                </tr>
								
				
					
					