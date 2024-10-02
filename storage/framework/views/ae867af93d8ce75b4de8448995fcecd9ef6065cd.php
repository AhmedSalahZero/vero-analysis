<div class="modal fade " id="<?php echo e($modalId.$currency); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="#" class="modal-content" method="post">


            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#0741A5 !important" id="exampleModalLongTitle"> <?php echo e($title); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="customize-elements">
                    <table class="table">
                        <thead>
                            <tr>


                                <th class="text-center w-40-percentage text-capitalize th-main-color"><?php echo e(__('Financial Institution')); ?></th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"><?php echo e(__('Account Number')); ?></th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"> <?php echo __('Amount'); ?> </th>
                                <th class="text-center w-20-percentage text-capitalize th-main-color"> <?php echo __('Blocked Against'); ?> </th>



                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $total = 0 ;


                            ?>
                            <?php $__currentLoopData = $detailItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                            <tr>
                                <td class="w-40-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" step="0.1" class="form-control ignore-global-style" value="<?php echo e($detailItem['financial_institution_name']); ?>">
                                        </div>
                                    </div>
                                </td>
                                <td class="w-20-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e($detailItem['account_number']); ?>">
                                        </div>
                                    </div>
                                </td>


                                <td class="w-20-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e(number_format($detailItem['amount'])); ?>">
                                            <?php
                                            $total +=$detailItem['amount'];
                                            ?>
                                        </div>
                                    </div>
                                </td>


                                <td class="w-20-percentage">
                                    <div class="kt-input-icon ">
                                        <div class="input-group">
                                            <input disabled type="text" class="form-control text-center ignore-global-style" value="<?php echo e($detailItem['blocked'] ?? '-'); ?>">

                                        </div>
                                    </div>
                                </td>









                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>

                                </td>

                                <td>

                                </td>


                                <td class="text-center">

                                    <?php echo e(number_format($total)); ?>

                                </td>
                                <td></td>


                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary 
				
				" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/details_modal.blade.php ENDPATH**/ ?>