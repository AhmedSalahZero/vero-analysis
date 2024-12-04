<?php
use App\Models\MediumTermLoan ;
?>
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
<?php echo e(__('Medium Term Loan')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.back-to-bank-header-btn','data' => ['createPermissionName' => 'create medium term loan','createRoute' => route('loans.create',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,MediumTermLoan::RUNNING])]]); ?>
<?php $component->withName('back-to-bank-header-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['create-permission-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('create medium term loan'),'create-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('loans.create',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,MediumTermLoan::RUNNING]))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
	
	
	<div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <?php
            $currentType = MediumTermLoan::RUNNING ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentType,'title' => __('Medium Term Loan'),'startDate' => $filterDates[$currentType]['startDate']??'','endDate' => $filterDates[$currentType]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Medium Term Loan')),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['endDate']??'')]); ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-loans','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields[$currentType],'moneyReceivedType' => $currentType,'hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('loans.create',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-loans'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields[$currentType]),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('loans.create',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                     <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Limit')); ?></th>
                                    <th><?php echo e(__('Account Number')); ?></th>
                                    <th><?php echo e(__('Borrowing Rate')); ?></th>
                                    <th><?php echo e(__('Margin Rate')); ?></th>
                                    <th><?php echo e(__('Duration')); ?></th>
                                    <th><?php echo e(__('Installment Interval')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>

                                    <td class="text-nowrap"><?php echo e($model->getName()); ?></td>
                                    <td><?php echo e($model->getStartDateFormatted()); ?></td>
                                    <td><?php echo e($model->getEndDateFormatted()); ?></td>
                                    <td><?php echo e($model->getCurrencyFormatted()); ?></td>
                                    <td><?php echo e($model->getLimitFormatted()); ?></td>
                                    <td><?php echo e($model->getAccountNumber()); ?></td>
                                    <td><?php echo e($model->getBorrowingRateFormatted()); ?></td>
                                    <td><?php echo e($model->getMarginRateFormatted()); ?></td>
                                    <td class="text-uppercase"><?php echo e($model->getDurationFormatted()); ?></td>
                                    <td class="text-transform"><?php echo e($model->getPaymentInstallmentIntervalFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
										<?php if(hasAuthFor('create medium term loan')): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="<?php echo e(__('Upload Loan Schedule')); ?>" href="<?php echo e(route('view.uploading',['company'=>$company->id,'loanId'=>$model->id,'model'=>'LoanSchedule'])); ?>"><i class="fa fa-dollar-sign"></i></a>
											<?php endif; ?> 
											<?php if(hasAuthFor('update medium term loan')): ?>
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('loans.edit',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'mediumTermLoan'=>$model->id])); ?>"><i class="fa fa-pen-alt"></i></a>
											<?php endif; ?> 
											<?php if(hasAuthFor('delete medium term loan')): ?>
                                            <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($model->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                            <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($model->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?php echo e(route('loans.destroy',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'mediumTermLoan'=>$model->id ])); ?>" method="post">
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
											<?php endif; ?> 
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
    $(document).on('click', '.js-close-modal', function() {
        $(this).closest('.modal').modal('hide');
    })

</script>
<script>
    $(document).on('change', '.js-search-modal', function() {
        const searchFieldName = $(this).val();
        const popupType = $(this).attr('data-type');
        const modal = $(this).closest('.modal');
        if (searchFieldName === 'transfer_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Transfer Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/loans/index.blade.php ENDPATH**/ ?>