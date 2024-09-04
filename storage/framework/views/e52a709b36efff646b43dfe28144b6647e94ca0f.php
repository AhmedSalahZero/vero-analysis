<div class="modal fade inner-modal-class" id="edit-rates-<?php echo e($rate->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('fully-secured-overdraft-edit-rates',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'rate'=>$rate->id ])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit' )); ?></h5>
                    <button data-dismiss="modal" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <div class="row mb-3 closest-parent">
                        <?php echo $__env->make('reports.fully-secured-overdraft.rates-form',[
                        'rate'=>$rate
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button data-url="<?php echo e(route('fully-secured-overdraft-edit-rates',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'rate'=>$rate->id])); ?>" type="submit" class="btn btn-primary submit-form-btn"><?php echo e(__('Confirm')); ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade inner-modal-class" id="delete-rates-<?php echo e($rate->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                    <a href="<?php echo e(route('fully-secured-overdraft-delete-rate',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'rate'=>$rate->id ])); ?>" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></a>
                </div>

            </form>
        </div>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/fully-secured-overdraft/rate-modal.blade.php ENDPATH**/ ?>