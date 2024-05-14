@props([
'id',
'pastDueCustomerInvoices',
'weeks',
'dates',
'currentInvoiceType'
])

<div class="modal fade modal-item-js" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="{{ route('adjust.customer.dues.invoices',['company'=>$company->id]) }}" class="modal-content" method="post">
		
								
		@csrf
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle">{{ $currentInvoiceType == 'CustomerInvoice' ?  __('Customer Past Due Invoices') :  __('Supplier Past Due Invoices') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">{{ $currentInvoiceType == 'CustomerInvoice' ? __('Customer Name') : __('Supplier Name') }}</th>
                                <th class="text-center">{{ __('Invoice No.') }}</th>
                                <th class="text-center"> {!! __('Net <br> Balance') !!} </th>
                                <th class="text-center">{{ __('Due Date') }}</th>
                                <th class="text-center"> {!! __('Collection <br> Percentage') !!} </th>
                                <th class="text-center"> {!! __('Collection <br> Weeks') !!} </th>
                            </tr>
                        </thead>
                        <tbody>
						
							@php
								$totalNetBalance = 0 ;
								
								$allIds = $pastDueCustomerInvoices->pluck('id')->toArray() ;
								$dueInvoiceRow = \DB::table('weekly_cashflow_custom_due_invoices')->where('invoice_type',$currentInvoiceType)->where('company_id',$company->id)->whereIn('invoice_id',$allIds)->get();
								
							@endphp
                            @foreach($pastDueCustomerInvoices as $pastDueCustomerInvoice)
							@php
								if($pastDueCustomerInvoice->net_balance_until_date <= 0 ){
									continue;
								}
								$row = $dueInvoiceRow->where('invoice_id',$pastDueCustomerInvoice->id)->first();
								
							@endphp
                            <input type="hidden" name="customer_invoice_id[]" value="{{ $pastDueCustomerInvoice->id }}">
											<input type="hidden" name="invoice_amount[{{ $pastDueCustomerInvoice->id }}]"  value="{{ $pastDueCustomerInvoice->net_balance_until_date }}">
											<input type="hidden" name="invoiceType" value="{{ $currentInvoiceType }}">

                            <tr>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="numeric" step="0.1" class="form-control" value="{{ $pastDueCustomerInvoice->getName() }}">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="{{  $pastDueCustomerInvoice->invoice_number }}">
                                        </div>
                                    </div>
                                </td>


                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="{{ number_format($pastDueCustomerInvoice->net_balance_until_date) }}">
											@php
												$totalNetBalance +=$pastDueCustomerInvoice->net_balance_until_date; 
											@endphp
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center" value="{{ $pastDueCustomerInvoice->invoice_due_date }}">
                                        </div>
                                    </div>
                                </td>
								
								
								            <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input type="text" name="percentage[{{ $pastDueCustomerInvoice->id }}]" class="form-control text-center only-percentage-allowed" value="{{ $row ? $row->percentage : 100 }}">
                                        </div>
                                    </div>
                                </td>
								

                                <td>
                                    <select class="form-control" name="week_start_date[{{ $pastDueCustomerInvoice->id }}]">
									
                                      @foreach($weeks as $weekDate => $weekNo )
									  @php
										$startDate = $dates[$weekDate]['start_date'] ;
									  @endphp
									  <option @if($row && $row->week_start_date == $startDate ) selected @endif  class="text-center" value="{{ $startDate }}"> {{ __('Week ') . ' ' . $weekNo  . ' ( ' . $dates[$weekDate]['start_date'] . ' - ' . $dates[$weekDate]['end_date'] . ' )'}}   </option>
									  @endforeach 
                                    </select>
                                </td>

                            </tr>
                         @endforeach
						 <tr>
						 	<td>
							
							</td>
							
							<td>
								{{ __('Total Past Dues') }}
							</td>
							<td>
							
							{{ number_format($totalNetBalance) }}
							</td>
							<td>
							</td>
							
							<td>
							
							</td>
							<td>
							
							</td>
						 </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary submit-form-btn"
				 {{-- data-dismiss="modal" --}}
				 
				 >{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>
