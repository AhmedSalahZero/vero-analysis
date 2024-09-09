<?php
use App\Models\MoneyReceived ;
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
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar justify-content-between flex-grow-1">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!Request('active') || Request('active') == MoneyReceived::CONTRACTS_WITH_DOWN_PAYMENTS ?'active':''); ?>" data-toggle="tab" href="#<?php echo e(MoneyReceived::CONTRACTS_WITH_DOWN_PAYMENTS); ?>" role="tab">
                        <i class="fa fa-money-check-alt"></i> <?php echo e($tableTitle); ?>

                    </a>
                </li>




            </ul>

            <div class="flex-tabs">
                <a href="<?php echo e(route('loans.create',['company'=>$company->id,MoneyReceived::CONTRACTS_WITH_DOWN_PAYMENTS])); ?>" class="btn  active-style btn-icon-sm align-self-center">
                    <i class="fas fa-plus"></i>
                    <?php echo e(__('Create')); ?>

                </a>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content  kt-margin-t-20">

            <?php
            $currentType = MoneyReceived::CONTRACTS_WITH_DOWN_PAYMENTS ;
            ?>
            <!--Begin:: Tab Content-->
            <div class="tab-pane <?php echo e(!Request('active') || Request('active') == $currentType ?'active':''); ?>" id="<?php echo e($currentType); ?>" role="tabpanel">
                <div class="kt-portlet kt-portlet--mobile">
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.table-title.with-two-dates','data' => ['type' => $currentType,'title' => $title,'startDate' => $filterDates[$currentType]['startDate']??'','endDate' => $filterDates[$currentType]['endDate']??'']]); ?>
<?php $component->withName('table-title.with-two-dates'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentType),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'startDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['startDate']??''),'endDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterDates[$currentType]['endDate']??'')]); ?>
                        
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
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Down Payment Amount')); ?></th>
                                    <th><?php echo e(__('Settlement Amount')); ?></th>
                                    <th><?php echo e(__('Net Amount')); ?></th>
                                    <th><?php echo e(__('Currency')); ?></th>
                                    <th><?php echo e(__('Contract Code')); ?></th>
                                    <th><?php echo e(__('Contract Amount')); ?></th>
                                    <th><?php echo e(__('Control')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
								$index = 0 ;
							?>
                                <?php $__currentLoopData = $models[$currentType]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php $__currentLoopData = $model->{$moneyModelName}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moneyReceived): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($index+1); ?>

                                    </td>

                                    <td class="text-nowrap"><?php echo e($moneyReceived->getReceivingDateFormatted()); ?></td>
                                    <td><?php echo e($currentReceivedAmount=$moneyReceived->getReceivedAmountFormatted()); ?></td>
                                    <td><?php echo e($currentTotalSettlementAmount=$moneyReceived->getTotalSettlementAmountFormatted()); ?></td>
                                    <td><?php echo e(number_format($moneyReceived->getTotalSettlementsNetBalance())); ?></td>
                                    <td><?php echo e($moneyReceived->getCurrency()); ?></td>
                                    <td><?php echo e($model->getCode()); ?></td>
                                    <td><?php echo e($model->getAmountFormatted()); ?></td>
                                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="<?php echo e(__('Start Settlement')); ?>" href="<?php echo e(route('view.down.payment.settlement',['company'=>$company->id,'downPaymentId'=>$moneyReceived->id,'modelType'=>$modelType])); ?>"><i class="fa fa-dollar-sign"></i></a>
                                            
                                        </span>
                                    </td>
                                </tr>
								<?php
									$index++;
								?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/contracts-money-received-down-payment/index.blade.php ENDPATH**/ ?>