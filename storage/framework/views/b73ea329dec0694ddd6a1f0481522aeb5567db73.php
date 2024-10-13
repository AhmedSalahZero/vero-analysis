<?php if($model->isRunning() || $model->isExpired()): ?>

 <a data-toggle="modal" data-target="#cancel-deposit-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Cancel Letter')); ?>" href="#"><i class="fa fa-ban"></i></a>
 <div class="modal fade" id="cancel-deposit-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('cancel.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource() ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Cancel This Letter ?')); ?></h5>
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

                         <div class="col-md-3 mb-4">
                             <label><?php echo e(__('LG Amount')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e($model->getLgAmount()); ?>" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>

                         <div class="col-md-3 mb-4">
                             <label><?php echo e(__('Cancellation Date')); ?></label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="cancellation_date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm')); ?></button>
                 </div>

             </form>
         </div>
     </div>
 </div>

<?php endif; ?>
 <?php if($model->isRunning()): ?>
 <?php if($model->isAdvancedPayment()): ?>
 
 <a data-toggle="modal" data-target="#amount-to-be-decreased-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Amount To Be Decreased')); ?>" href="#"><i class=" fa fa-balance-scale"></i></a>
 <div class="modal fade" id="amount-to-be-decreased-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('advanced.lg.payment.apply.amount.to.be.decreased',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource() ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Amount To Be Decreased To' ) . ' ' . $model->getTransactionName()); ?></h5>
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
                             <label><?php echo e(__('LG Amount')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e($model->getLgAmount()); ?>" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>

                         <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Date')); ?></label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="date" value="<?php echo e(formatDateForDatePicker(now()->format('Y-m-d'))); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                     <div class="input-group-append">
                                         <span class="input-group-text">
                                             <i class="la la-calendar-check-o"></i>
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-2 mb-4">
                             <label><?php echo e(__('Amount To Be Decreased')); ?> </label>
                             <div class="kt-input-icon">
                                 <input name="amount" value="<?php echo e(0); ?>" type="text" class="form-control only-greater-than-zero-allowed">
                             </div>
                         </div>

                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th><?php echo e(__('#')); ?></th>
                                             <th><?php echo e(__('Date')); ?></th>
                                             <th><?php echo e(__('Amount')); ?></th>
                                             <th><?php echo e(__('Actions')); ?></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $__currentLoopData = $model->advancedPaymentHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$advancedPaymentHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                             <td> <?php echo e(++$index); ?> </td>
                                             <td class="text-nowrap"><?php echo e($advancedPaymentHistory->getDateFormatted()); ?></td>
                                             <td> <?php echo e($advancedPaymentHistory->getAmountFormatted()); ?> </td>
                                             <td>
                                                 <a data-toggle="modal" data-target="#edit-advanced-payment-lg-<?php echo e($advancedPaymentHistory->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource()])); ?>"><i class="fa fa-pen-alt"></i></a>
                                                 <a data-toggle="modal" data-target="#delete-advanced-payment-lg-<?php echo e($advancedPaymentHistory->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                             </td>
                                         </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>

                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     <button type="submit" class="btn btn-primary"><?php echo e(__('Confirm')); ?></button>
                 </div>

             </form>

           
         </div>
     </div>
 </div>
 
   <?php $__currentLoopData = $model->advancedPaymentHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$advancedPaymentHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <div class="modal fade inner-modal-class" id="edit-advanced-payment-lg-<?php echo e($advancedPaymentHistory->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="<?php echo e(route('advanced.lg.payment.edit.amount.to.be.decreased',['company'=>$company->id,'lgAdvancedPaymentHistory'=>$advancedPaymentHistory->id,'source'=>$model->getSource() ])); ?>" method="post">
                             <?php echo csrf_field(); ?>
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Amount To Be Decreased To' ) . ' ' . $model->getTransactionName()); ?></h5>
                                 <button data-dismiss="modal" type="button" class="close" aria-label="Close">
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
                                         <label><?php echo e(__('LG Amount')); ?> </label>
                                         <div class="kt-input-icon">
                                             <input disabled value="<?php echo e($model->getLgAmount()); ?>" type="text" class="form-control only-greater-than-or-equal-zero-allowed">
                                         </div>
                                     </div>

                                     <div class="col-md-2 mb-4">
                                         <label><?php echo e(__('Date')); ?></label>
                                         <div class="kt-input-icon">
                                             <div class="input-group date">
                                                 <input required type="text" name="decrease_date" value="<?php echo e($advancedPaymentHistory ?formatDateForDatePicker($advancedPaymentHistory->getDate()) : null); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
                                                 <div class="input-group-append">
                                                     <span class="input-group-text">
                                                         <i class="la la-calendar-check-o"></i>
                                                     </span>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-md-2 mb-4">
                                         <label><?php echo e(__('Amount To Be Decreased')); ?> </label>
                                         <div class="kt-input-icon">
                                             <input name="amount_to_be_decreased" value="<?php echo e($advancedPaymentHistory->getAmount()); ?>" type="text" class="form-control only-greater-than-zero-allowed">
                                         </div>
                                     </div>



                                 </div>
                             </div>


                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                 <button type="submit" class="btn btn-primary submit-form-btn"><?php echo e(__('Confirm')); ?></button>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>
             <div class="modal fade inner-modal-class" id="delete-advanced-payment-lg-<?php echo e($advancedPaymentHistory->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="" method="post">
                             <?php echo csrf_field(); ?>
                             <?php echo method_field('delete'); ?>
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>

                                 <a href="<?php echo e(route('delete.lg.advanced.payment',['company'=>$company->id,'lgAdvancedPaymentHistory'=>$advancedPaymentHistory->id])); ?>" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></a>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			 
 <?php endif; ?>

 <?php elseif($model->isCancelled()): ?>

 <a data-toggle="modal" data-target="#back-to-running-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Back To Running')); ?>" href="#"><i class="fa fa fa-undo"></i></a>

 <div class="modal fade" id="back-to-running-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('back.to.running.letter.of.guarantee.issuance',['company'=>$company->id,'letterOfGuaranteeIssuance'=>$model->id,'source'=>$model->getSource() ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Change LG Status Back To Running Status ?')); ?></h5>
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

                         <div class="col-md-3 mb-4">
                             <label><?php echo e(__('LG Amount')); ?> </label>
                             <div class="kt-input-icon">
                                 <input disabled value="<?php echo e(number_format($model->getLgAmount())); ?>" type="text" class="form-control text-center">
                             </div>
                         </div>
                     </div>
                 </div>


                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     <button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
                 </div>

             </form>
         </div>
     </div>
 </div>


 <?php endif; ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfGuaranteeIssuance/actions.blade.php ENDPATH**/ ?>