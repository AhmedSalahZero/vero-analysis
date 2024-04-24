@props([
'id',
'pastDueCustomerInvoices',
'weeks',
'dates'
])


<div class="modal fade modal-item-js" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Custom Past Due Invoices') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('Customer Name') }}</th>
                                <th class="text-center">{{ __('Invoice No.') }}</th>
                                <th class="text-center">{{ __('Invoice Amount') }}</th>
                                <th class="text-center">{{ __('Due Date') }}</th>
                                <th class="text-center">{{ __('Collection Weeks') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastDueCustomerInvoices as $pastDueCustomerInvoice)
                            <input type="hidden" name="customer_invoice_id[]" value="{{ $pastDueCustomerInvoice->id }}">
                            <tr>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="numeric" step="0.1" class="form-control" value="{{ $pastDueCustomerInvoice->customer_name }}">
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
                                            <input disabled type="text" class="form-control text-center" value="{{ number_format($pastDueCustomerInvoice->invoice_amount) }}">
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
                                    <select class="form-control">
									
                                      @foreach($weeks as $weekDate => $weekNo )
									  <option class="text-center" value="{{ $dates[$weekDate]['start_date'] }}"> {{ __('Week ') . ' ' . $weekNo }}  </option>
									  @endforeach 
                                    </select>
                                </td>

                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
