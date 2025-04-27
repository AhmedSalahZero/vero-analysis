<a data-toggle="modal" data-target="#apply-rate-for-<?php echo e($overdraftAgainstCommercialPaper->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Update Interest Rate	')); ?>" href="#"><i class=" fa fa-balance-scale"></i></a>
                                        <div class="modal fade" id="apply-rate-for-<?php echo e($overdraftAgainstCommercialPaper->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="<?php echo e(route('overdraft-against-commercial-paper-apply.rates',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'overdraftAgainstCommercialPaper'=>$overdraftAgainstCommercialPaper->id ])); ?>" method="post">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Rates Information' )); ?></h5>
                                                            <button type="button" class="close" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>


                                                        <div class="modal-body">

                                                            <div class="row mb-3 closest-parent">
<?php if(hasAuthFor('create overdraft against commercial paper')): ?>
                                                                <?php echo $__env->make('reports.overdraft-against-commercial-paper.rates-form' , [

                                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?> 



                                                                <div class="col-md-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><?php echo e(__('#')); ?></th>
                                                                                    <th><?php echo e(__('Date')); ?></th>
                                                                                    <th><?php echo e(__('Borrowing Rate')); ?></th>
                                                                                    <th><?php echo e(__('Margin Rate')); ?></th>
                                                                                    <th><?php echo e(__('Interest Rate')); ?></th>
                                                                                    <th><?php echo e(__('Actions')); ?></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $__currentLoopData = $overdraftAgainstCommercialPaper->rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <tr>
                                                                                    <td> <?php echo e(++$index); ?> </td>

                                                                                    <td> <?php echo e($rate->getDateFormatted()); ?> </td>
                                                                                    <td> <?php echo e($rate->getBorrowingRateFormatted()); ?> </td>
                                                                                    <td> <?php echo e($rate->getMarginRateFormatted()); ?> </td>
                                                                                    <td> <?php echo e($rate->getInterestRateFormatted()); ?> </td>
                                                                                    <td>
                                                                                        <?php if($loop->last): ?>
																						<?php if(hasAuthFor('update overdraft against commercial paper')): ?>
                                                                                        <a data-toggle="modal" data-target="#edit-rates-<?php echo e($rate->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="#"><i class="fa fa-pen-alt"></i></a>
																						<?php endif; ?> 
																						<?php if(hasAuthFor('delete overdraft against commercial paper')): ?>
                                                                                        <a data-toggle="modal" data-target="#delete-rates-<?php echo e($rate->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
																						<?php endif; ?>
                                                                                        <?php endif; ?>

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
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/overdraft-against-commercial-paper/apply-rate.blade.php ENDPATH**/ ?>