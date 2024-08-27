 <?php if($model->isRunning()): ?>



 <a data-toggle="modal" data-target="#apply-expense-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Expenses')); ?>" href="#"><i class=" fa fa-balance-scale"></i></a>
 <div class="modal fade" id="apply-expense-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('apply.lc.issuance.expense',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Apply Expenses' )); ?></h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


                 <div class="modal-body">
                     <div class="row mb-3">


                         <?php echo $__env->make('reports.LetterOfCreditIssuance.popup-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>







                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th><?php echo e(__('#')); ?></th>
                                             <th><?php echo e(__('Expense Name')); ?></th>
                                             <th><?php echo e(__('Date')); ?></th>
                                             <th><?php echo e(__('Amount')); ?></th>
                                             <th><?php echo e(__('Actions')); ?></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $__currentLoopData = $model->expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                             <td> <?php echo e(++$index); ?> </td>
                                             <td><?php echo e($expense->getName()); ?></td>
                                             <td class="text-nowrap"><?php echo e($expense->getDateFormatted()); ?></td>
                                             <td> <?php echo e($expense->getAmountFormatted()); ?> </td>
                                             <td>
                                                 <a data-toggle="modal" data-target="#edit-expense-<?php echo e($expense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource()])); ?>"><i class="fa fa-pen-alt"></i></a>










                                                 <a data-toggle="modal" data-target="#delete-lc-issuance-expense<?php echo e($expense->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>


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

             <?php $__currentLoopData = $model->expenses->sortBy('date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <div class="modal fade" id="edit-expense-<?php echo e($expense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">


                 <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="<?php echo e(route('update.lc.issuance.expense',['company'=>$company->id,'expense'=>$expense->id ])); ?>" method="post">
                             <?php echo csrf_field(); ?>
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Expenses To' )); ?></h5>
                                 <button data-dismiss="modal2" type="button" class="close" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>


                             <div class="modal-body">
                                 <div class="row mb-3">

                                     <?php echo $__env->make('reports.LetterOfCreditIssuance.popup-form',['submodel'=>$expense], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



                                 </div>
                             </div>


                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal2"><?php echo e(__('Close')); ?></button>
                                 <button type="submit" class="btn btn-primary submit-form-btn"><?php echo e(__('Confirm')); ?></button>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>





             <div class="modal fade" id="delete-lc-issuance-expense<?php echo e($expense->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <form action="" method="post">
                             <?php echo csrf_field(); ?>
                             <?php echo method_field('delete'); ?>
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Do You Want To Delete This Item ?')); ?></h5>
                                 <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal2"><?php echo e(__('Close')); ?></button>

                                 <a href="<?php echo e(route('delete.lc.issuance.expense',['company'=>$company->id,'expense'=>$expense->id])); ?>" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></a>
                             </div>

                         </form>
                     </div>
                 </div>
             </div>

             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

           
         </div>
     </div>
 </div>





 <?php echo $__env->make('reports.LetterOfCreditIssuance.cancel-issuance-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php elseif($model->isPaid()): ?>
 <?php echo $__env->make('reports.LetterOfCreditIssuance.cancel-issuance-modal',['disabled'=>false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <a data-toggle="modal" data-target="#back-to-running-modal-<?php echo e($model->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Back To Running')); ?>" href="#"><i class="fa fa fa-undo"></i></a>

 <div class="modal fade" id="back-to-running-modal-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('back.to.running.letter.of.credit.issuance',['company'=>$company->id,'letterOfCreditIssuance'=>$model->id,'source'=>$model->getSource() ])); ?>" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="modal-header">
                     <h5 class="modal-title d-flex w-100" id="exampleModalLongTitle"><?php echo e(__('Do You Want Cancel LC Payment ?')); ?>

					 
                     <div class="ml-auto d-inline-block">
						<button type="submit" class="btn btn-success"><?php echo e(__('Confirm')); ?></button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
					 </div>
					 </h5>
                     <button type="button" class="close" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>


              

             </form>
         </div>
     </div>
 </div>


 <?php endif; ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/LetterOfCreditIssuance/actions.blade.php ENDPATH**/ ?>