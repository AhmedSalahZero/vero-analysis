 <?php if($model->hasComment() ): ?>
 <a data-toggle="modal" data-target="#user-comment-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-success btn-icon" title="<?php echo e(__('User Comment')); ?>" href="#"><i class="fa fa-comment"></i></a>
 <div class="modal fade" id="user-comment-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <form action="#" method="post">
                 <?php echo csrf_field(); ?>
	
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('User Comment')); ?></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
				 <div class="modal-body">
				 	<h2 class="text-wrap <?php echo e(isArabic($model->getUserComment()) ? 'text-right' : 'text-left'); ?>"><?php echo e($model->getUserComment()); ?></h2>
				 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     
                 </div>

             </form>
         </div>
     </div>
 </div>
<?php endif; ?> 
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/_user_comment_modal.blade.php ENDPATH**/ ?>