 <?php if(!$model->isReviewed() && auth()->user()->can(getReviewPermissionName(getModelNameWithoutNamespace($model)))): ?>
 <a data-toggle="modal" data-target="#review-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-success btn-icon" title="<?php echo e(__('Reviewed')); ?>" href="#"><i class="fa fa-check"></i></a>
 <div class="modal fade" id="review-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="<?php echo e(route('confirmed.review',['company'=>$company->id,'model'=>$model->id])); ?>" method="post">
                 <?php echo csrf_field(); ?>
					<input type="hidden" name="model_name" value="<?php echo e(getModelNameWithoutNamespace($model)); ?>" >
					<input type="hidden" name="table_name" value="<?php echo e($model->getTable()); ?>" >
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Mark This As Reviewed ?')); ?></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/_review_modal.blade.php ENDPATH**/ ?>