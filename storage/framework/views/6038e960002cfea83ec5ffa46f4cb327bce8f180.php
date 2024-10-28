
<?php $__env->startPush('js'); ?>
	<script>
		$(document).on('click','[data-show-notification-modal="<?php echo e($notificationMainType); ?>"]',function(e){
			e.preventDefault();
			$('.<?php echo e($notificationMainType); ?>-modal').modal('show');
		})
	</script>
<?php $__env->stopPush(); ?>

<?php
	$customerPastDues = $company->notifications->where('data.type',$notificationMainType);
	$notificationHeaders = $customerPastDues->first() ? array_keys($customerPastDues->first()->data['data_array']) : [];
	

?>


<div class="modal fade notification-modal <?php echo e($notificationMainType); ?>-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">


            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"><?php echo e($notificationMainTitle); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>
								<?php $__currentLoopData = $notificationHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificationHeader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="text-center"> <?php echo __($notificationHeader); ?> </th>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $__currentLoopData = $customerPastDues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerPastDue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
							
								<?php $__currentLoopData = $notificationHeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificationHeader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <div class="kt-input-icon">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e($customerPastDue['data']['data_array'][$notificationHeader] ??'---'); ?>">
                                        </div>
                                    </div>
                                </td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 




                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/notifications/popup.blade.php ENDPATH**/ ?>