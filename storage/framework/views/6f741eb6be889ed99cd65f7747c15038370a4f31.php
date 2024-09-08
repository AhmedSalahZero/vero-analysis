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
										$lcAmount = $model->getLcAmount();
										$invoices = \App\Models\SupplierInvoice::onlyCompany($company->id)->onlyForPartner($model->getBeneficiaryId())->where('net_balance','>=',$lcAmount)->onlyCurrency($model->getLcCurrency())->get();
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
										
										
										
										
										
										
										
										
										
										
										  <div class="form-group row justify-content-center w-100">
											<?php
											$index = 0 ;
											?>

                        
                        <?php
                        $tableId = 'allocations';

                        $repeaterId = 'm_repeater_9';

                        ?>
                        
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table','data' => ['initialJs' => false,'repeaterWithSelect2' => true,'parentClass' => 'show-class-js','tableName' => $tableId,'repeaterId' => $repeaterId,'relationName' => 'food','isRepeater' => $isRepeater=true]]); ?>
<?php $component->withName('tables.repeater-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['initialJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'repeater-with-select2' => true,'parentClass' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('show-class-js'),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableId),'repeaterId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($repeaterId),'relationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('food'),'isRepeater' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isRepeater=true)]); ?>
                             <?php $__env->slot('ths'); ?> 
                                <?php $__currentLoopData = [
                                __('Customer')=>'th-main-color custom-w-25',
                                __('Contract Name')=>'th-main-color custom-w-25 ',
                                __('Contract Code')=>'th-main-color ',
                                __('Contract Amount')=>'th-main-color',
                                __('Allocate Amount')=>'th-main-color',
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title=>$classes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tables.repeater-table-th','data' => ['class' => ''.e($classes).'','title' => $title]]); ?>
<?php $component->withName('tables.repeater-table-th'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => ''.e($classes).'','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php $__env->endSlot(); ?>
                             <?php $__env->slot('trs'); ?> 
                                <?php
                             
                               $rows = isset($model) ? $model->settlementAllocations :[-1] ;
						
                                ?>
                                <?php $__currentLoopData = count($rows) ? $rows : [-1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlementAllocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
								$fullPath  = new \App\Models\SettlementAllocation;
                                if( !($settlementAllocation instanceof $fullPath) ){
                                unset($settlementAllocation);
                                }
                                ?>
                                <tr <?php if($isRepeater): ?> data-repeater-item <?php endif; ?>>

                                    <td class="text-center">
                                        <input type="hidden" name="company_id" value="<?php echo e($company->id); ?>">
                                        <div class="">
                                            <i data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill trash_icon fas fa-times-circle">
                                            </i>
                                        </div>
                                    </td>
                                    <td>
								
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['insideModalWithJs' => false,'selectedValue' => isset($settlementAllocation) && $settlementAllocation->partner_id ? $settlementAllocation->partner_id : '','options' => formatOptionsForSelect($clientsWithContracts),'addNew' => false,'class' => ' suppliers-or-customers-js ','dataFilterType' => ''.e('create').'','all' => false,'dataName' => 'partner_id','name' => 'partner_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['insideModalWithJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($settlementAllocation) && $settlementAllocation->partner_id ? $settlementAllocation->partner_id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(formatOptionsForSelect($clientsWithContracts)),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => ' suppliers-or-customers-js ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-name' => 'partner_id','name' => 'partner_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </td>

                                    <td>
                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['insideModalWithJs' => false,'dataCurrentSelected' => ''.e(isset($settlementAllocation) ? $settlementAllocation->contract_id : '').'','selectedValue' => isset($settlementAllocation) ? $settlementAllocation->contract_id : '','options' => [],'addNew' => false,'class' => ' contracts-js   ','dataFilterType' => ''.e('create').'','all' => false,'dataName' => 'contract_id','name' => 'contract_id']]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['insideModalWithJs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-current-selected' => ''.e(isset($settlementAllocation) ? $settlementAllocation->contract_id : '').'','selectedValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($settlementAllocation) ? $settlementAllocation->contract_id : ''),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => ' contracts-js   ','data-filter-type' => ''.e('create').'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'data-name' => 'contract_id','name' => 'contract_id']); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    </td>

                                    <td>
                                        <div class="kt-input-icon custom-w-20">
                                            <div class="input-group">
                                                <input disabled type="text" class="form-control contract-code " value="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="kt-input-icon custom-w-15">
                                            <div class="input-group">
                                                <input disabled type="text" class="form-control contract-amount" value="0">
                                            </div>
                                        </div>
                                    </td>
                                  

  										<td>
                                        <div class="kt-input-icon custom-w-15">
                                            <div class="input-group">
                                                <input  type="text" data-name="allocation_amount" name="allocation_amount" class="form-control " value="<?php echo e(isset($settlementAllocation) ? $settlementAllocation->getAmount(): 0); ?>">
                                            </div>
                                        </div>
                                    </td>


                                </tr>
								
							
								
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                             <?php $__env->endSlot(); ?>




                         <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        















































































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