<a data-toggle="modal" data-target="#cancel-deposit-modal-{{ $model->id }}" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="{{ __('Apply payment') }}" href="#"><i class="fa fa-coins"></i></a>
 <div class="modal fade" id="cancel-deposit-modal-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="{{ route('make.letter.of.credit.issuance.as.paid',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource() ]) }}" method="post">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Do You Want To Pay This LC ?') }}</h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         <div class="col-md-6 mb-4">
                             <label>{{__('Bank Name')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getFinancialInstitutionBankName()  }}" type="text" class="form-control">
                             </div>
                         </div>

                         <div class="col-md-2 mb-4">
                             <label>{{__('LC Amount')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  number_format($model->getLcAmount() ) . ' ' . $model->getLcCurrency()  }}" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
						 <div class="col-md-2 mb-4">
                             <label>{{__('Exchange Rate')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  number_format($model->getExchangeRate(),2 )  }}" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
						 <div class="col-md-2 mb-4">
                             <label>{{__('Amount In Main Currency')}} </label>
                             <div class="kt-input-icon">
                                 <input disabled value="{{  $model->getAmountInMainCurrencyFormatted()  }}" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
                         <div class="col-md-3 mb-4">
                             <label>{{__('Date')}}</label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="payment_date" value="{{ formatDateForDatePicker($model->getDueDate()) }}" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
						 
									@php
										$invoices = \App\Models\SupplierInvoice::onlyCompany($company->id)->onlyForPartner($model->getBeneficiaryId())->where('net_balance','>',0)->onlyCurrency($model->getLcCurrency())->get();
									@endphp
									
									  <div class="col-md-3">
                                        <label>{{ __('Invoice') }} <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select  name="supplier_invoice_id" class="form-control update-net-balance-inputs">
                                                    @foreach($invoices as  $invoice)
                                                    <option data-currency="{{ $invoice->getCurrency() }}" data-invoice-net-balance="{{ $invoice->getNetBalance() }}" data-exchange-rate="{{ $invoice->getExchangeRate() }}" data-invoice-net-balance-in-main-currency="{{ $invoice->getNetBalanceInMainCurrency() }}"   value="{{ $invoice->id }}">{{ $invoice->getInvoiceNumber() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
										 <div class="col-md-2 mb-4">
											<label>{{__('Net Balance')}} </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control net-balance text-center">
											</div>
										</div>
										
										 <div class="col-md-2 mb-4">
											<label>{{__('Exchange Rate')}} </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control exchange-rate text-center">
											</div>
										</div>
										
										 <div class="col-md-2 mb-4">
											<label>{{__('NB In Main Currency')}} </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control net-balance-in-main-currency text-center">
											</div>
										</div>
									
									
									
						 
                     </div>
                 </div>

			
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					 @if(!isset($disabled))
                     <button type="submit" class="btn btn-danger">{{ __('Confirm') }}</button>
					 @endif
                 </div>

             </form>
         </div>
     </div>
 </div>
