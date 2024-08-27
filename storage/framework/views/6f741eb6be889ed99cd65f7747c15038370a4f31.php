<a data-toggle="modal" data-target="#cancel-deposit-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Apply payment')); ?>" href="#"><i class="fa fa-coins"></i></a>
 <div class="modal fade" id="cancel-deposit-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('make.letter.of.credit.issuance.as.paid',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource() ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Pay This LC ?')); ?></h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         <div class="col-md-6 mb-4">
                             <label><?php echo e(__('Bank Name')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e($model->getFinancialInstitutionBankName()); ?>" type="text" class="form-control">
                             </div>
                         </div>

                         <div class="col-md-2 mb-4">
                             <label><?php echo e(__('LC Amount')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e(number_format($model->getLcAmount() ) . ' ' . $model->getLcCurrency()); ?>" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
						 <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Exchange Rate')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e(number_format($model->getExchangeRate(),2 )); ?>" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
						 <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Amount In Main Currency')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e($model->getAmountInMainCurrencyFormatted()); ?>" type="text" class="form-control text-center">
                             </div>
                         </div>
						 
                         <div class="col-md-3 mb-4">
                             <label><?php echo e(__('Date')); ?></label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="payment_date" value="<?php echo e(formatDateForDatePicker($model->getDueDate())); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
						 
									<?php
										$invoices = \App\Models\SupplierInvoice::onlyCompany($company->id)->onlyForPartner($model->getBeneficiaryId())->where('net_balance','>',0)->onlyCurrency($model->getLcCurrency())->get();
									?>
									
									  <div class="col-md-3">
                                        <label><?php echo e(__('Invoice')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select  name="supplier_invoice_id" class="form-control update-net-balance-inputs">
                                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option data-currency="<?php echo e($invoice->getCurrency()); ?>" data-invoice-net-balance="<?php echo e($invoice->getNetBalance()); ?>" data-exchange-rate="<?php echo e($invoice->getExchangeRate()); ?>" data-invoice-net-balance-in-main-currency="<?php echo e($invoice->getNetBalanceInMainCurrency()); ?>"   value="<?php echo e($invoice->id); ?>"><?php echo e($invoice->getInvoiceNumber()); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
										 <div class="col-md-2 mb-4">
											<label><?php echo e(__('Net Balance')); ?> </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control net-balance text-center">
											</div>
										</div>
										
										 <div class="col-md-2 mb-4">
											<label><?php echo e(__('Exchange Rate')); ?> </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control exchange-rate text-center">
											</div>
										</div>
										
										 <div class="col-md-2 mb-4">
											<label><?php echo e(__('NB In Main Currency')); ?> </label>
											<div class="kt-input-icon">
												<input disabled value="0" type="text" class="form-control net-balance-in-main-currency text-center">
											</div>
										</div>
									
									
									
						 
                     </div>
                 </div>

			
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
					 <?php if(!isset($disabled)): ?>
                     <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm')); ?></button>
					 <?php endif; ?>
                 </div>

             </form>
         </div>
     </div>
 </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditIssuance/cancel-issuance-modal.blade.php ENDPATH**/ ?>