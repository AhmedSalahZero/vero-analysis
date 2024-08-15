<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<style>
    input[type="checkbox"] {
        cursor: pointer;
    }

    th {
        background-color: #0742A6;
        color: white;
    }

    .bank-max-width {
        max-width: 200px !important;
    }

    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style) {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Bank Accounts' )); ?> [<?php echo e($financialInstitution->getName()); ?>]
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == 'bank-accounts' ?'active':''); ?>" 
					
					 href="<?php echo e(route('view.financial.institutions',['company'=>$company->id])); ?>"
					
					 role="tab">
                        <i class="fa fa-arrow-left"></i> <?php echo e(__('Back To Banks Table')); ?>

                    </a>
                </li>

            </ul>
            
        </div>
    </div>
    <div style="padding-top:0 !important " class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == 'bank-accounts' ?'active':''); ?>" id="bank" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
					 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-one-date','data' => ['filterDate' => $filterDate]]); ?>
<?php $component->withName('table-title.with-one-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['filterDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDate)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                            <thead>
                                <tr class="table-standard-color">
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Balance')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$bankAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>
                                    <td><?php echo e($bankAccount->getType()); ?></td>
                                    <td class="text-nowrap"><?php echo e($bankAccount->getAccountNumber()); ?></td>
                                    <td><?php echo e($bankAccount->getCurrencyFormatted()); ?></td>
                                    <td><?php echo e($bankAccount->getBalanceAmountFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">


                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.financial.institutions.account',['company'=>$company->id , 'financialInstitutionAccount'=>$bankAccount->id ])); ?>"><i class="fa fa-pen-alt"></i></a>
                                            <a type="button" class="btn btn-secondary <?php if($bankAccount->isBlocked()): ?> btn-outline-danger <?php else: ?> btn-outline-success <?php endif; ?> btn-icon" title="Edit" href="<?php echo e(route('edit.financial.institutions.account',['company'=>$company->id , 'financialInstitutionAccount'=>$bankAccount->id ])); ?>"><i class="fa <?php if($bankAccount->isBlocked()): ?> fa-lock <?php else: ?> fa-unlock <?php endif; ?>"></i></a>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($bankAccount->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($bankAccount->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('delete.financial.institutions.account',['company'=>$company->id,'financialInstitutionAccount'=>$bankAccount->id])); ?>" method="post">
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
                                                                <button type="submit" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>
                </div>
            </div>










            <!--End:: Tab Content-->



            <!--End:: Tab Content-->
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
<script>

</script>
<script>


</script>







<script>
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'start_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Start Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        }
        //else if(searchFieldName === 'balance_date') {
        //     modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
        //     $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        // }
        else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/bank-accounts/index.blade.php ENDPATH**/ ?>