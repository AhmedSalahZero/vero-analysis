 <a data-toggle="modal" data-target="#edit-fees-modal-<?php echo e($currentStatementId); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Edit Commission Fees')); ?>" href="#"><i class="fa fa-pen"></i></a>
 <div class="modal fade" id="edit-fees-modal-<?php echo e($currentStatementId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('update.commission.fees',['company'=>$company->id ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Please Confirm Commission Fees Date & Amount ?')); ?></h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">

                         
						 <input type="hidden" name="statement_model_name" value="<?php echo e($statementModelName); ?>">
						 <input type="hidden" name="statement_id" value="<?php echo e($currentStatementId); ?>">
                         <div class="col-md-6 mb-4">
                             <label><?php echo e(__('Amount')); ?> </label>
                             <div class="kt-input-icon">
                                 <input  value="<?php echo e($currentCredit); ?>" type="text" name="credit" class="form-control text-center only-greater-than-or-equal-zero-allowed">
                             </div>
                         </div>

                         <div class="col-md-6 mb-4">
                             <label><?php echo e(__('Commission Date')); ?></label>
                             <div class="kt-input-icon">
                                 <div class="input-group date">
                                     <input required type="text" name="date" value="<?php echo e(formatDateForDatePicker($currentDate)); ?>" class="form-control" readonly placeholder="Select date" id="kt_datepicker_2" />
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/modals/edit-commissions-fees.blade.php ENDPATH**/ ?>