
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
<?php echo e(__('Overdraft Against Assignment Of Contract '. $financialInstitution->getName())); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="kt-portlet kt-portlet--tabs">

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.back-to-bank-header-btn','data' => ['createPermissionName' => 'create overdraft against assignment of contract','createRoute' => route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])]]); ?>
<?php $component->withName('back-to-bank-header-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['create-permission-name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('create overdraft against assignment of contract'),'create-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id]))]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
   
<div class="kt-portlet__body">
    <div class="tab-content  kt-margin-t-20">

        <!--Begin:: Tab Content-->
        <div class="tab-pane <?php echo e(!Request('active') || Request('active') == 'overdraft-against-assignment-of-contract' ?'active':''); ?>" id="bank" role="tabpanel">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg p-0">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-secondary btn-outline-hover-danger fa fa-layer-group"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            <?php echo e(__('Overdraft Against Assignment Of Contract Table')); ?>

                        </h3>
                    </div>
                    
                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.export-overdraft-against-assignment-of-contract','data' => ['financialInstitution' => $financialInstitution,'searchFields' => $searchFields,'moneyReceivedType' => 'overdraft-against-assignment-of-contract','hasSearch' => 1,'hasBatchCollection' => 0,'href' => ''.e(route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']]); ?>
<?php $component->withName('export-overdraft-against-assignment-of-contract'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['financialInstitution' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($financialInstitution),'search-fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchFields),'money-received-type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('overdraft-against-assignment-of-contract'),'has-search' => 1,'has-batch-collection' => 0,'href' => ''.e(route('create.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id])).'']); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Datatable -->
                    <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                        <thead>
                            <tr class="table-standard-color">
                                <th><?php echo e(__('#')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Account Number')); ?></th>
                                <th><?php echo e(__('Currency')); ?></th>
                                <th><?php echo e(__('Limit')); ?></th>
                                <th><?php echo e(__('Borrowing Rate')); ?></th>
                                <th><?php echo e(__('Margin Rate')); ?></th>
                                <th><?php echo e(__('Intreset Rate')); ?></th>
                                
                                
                                <th><?php echo e(__('Control')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $odAgainstAssignmentOfContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$odAgainstAssignmentOfContract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="closest-parent-tr " data-currency="<?php echo e($odAgainstAssignmentOfContract->getCurrency()); ?>">
                                <td>
                                    <?php echo e($index+1); ?>

                                </td>
                                <td class="text-nowrap"><?php echo e($odAgainstAssignmentOfContract->getContractStartDateFormatted()); ?></td>
                                <td class="text-nowrap"><?php echo e($odAgainstAssignmentOfContract->getContractEndDateFormatted()); ?></td>
                                <td><?php echo e($odAgainstAssignmentOfContract->getAccountNumber()); ?></td>
                                <td class="text-uppercase"><?php echo e($odAgainstAssignmentOfContract->getCurrency()); ?></td>
                                <td class="text-transform"><?php echo e($odAgainstAssignmentOfContract->getLimitFormatted()); ?></td>
                                <td class="bank-max-width"><?php echo e($odAgainstAssignmentOfContract->getBorrowingRateFormatted() . ' %'); ?></td>
                                <td class="text-nowrap"><?php echo e($odAgainstAssignmentOfContract->getMarginRateFormatted() . ' %'); ?></td>
                                <td><?php echo e($odAgainstAssignmentOfContract->getInterestRateFormatted() . ' %'); ?></td>
                                
                                
                                <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                                    <?php echo $__env->make('reports.overdraft-against-assignment-of-contract.apply-rate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if(hasAuthFor('update overdraft against assignment of contract')): ?>
                                    <a data-toggle="modal" data-target="#apply-expense-<?php echo e($odAgainstAssignmentOfContract->id); ?>" type="button" class="btn  btn-secondary btn-outline-hover-success   btn-icon" title="<?php echo e(__('Assign Contract')); ?>" href="#"><i class=" fa fa-file"></i></a>
                                    <?php endif; ?>
                                    <?php if(hasAuthFor('create overdraft against assignment of contract')): ?>
                                    <div class="modal fade" id="apply-expense-<?php echo e($odAgainstAssignmentOfContract->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('lending.information.apply.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract->id ])); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Lending Information' )); ?></h5>
                                                        <button type="button" class="close" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>


                                                    <div class="modal-body">

                                                        <div class="row mb-3 ">

                                                            <?php echo $__env->make('reports.overdraft-against-assignment-of-contract.lending-rate-form' , [

                                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><?php echo e(__('#')); ?></th>
                                                                                <th><?php echo e(__('Customer')); ?></th>
                                                                                <th><?php echo e(__('Contract')); ?></th>
                                                                                <th><?php echo e(__('Amount')); ?></th>
                                                                                <th><?php echo e(__('Start Date')); ?></th>
                                                                                <th><?php echo e(__('End Date')); ?></th>
                                                                                <th><?php echo e(__('Lending %')); ?></th>
                                                                                <th><?php echo e(__('Lending Amount')); ?></th>
                                                                                <th><?php echo e(__('Actions')); ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $__currentLoopData = $odAgainstAssignmentOfContract->lendingInformation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$lendingInformationAgainstAssignmentOfContract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <tr>
                                                                                <td> <?php echo e(++$index); ?> </td>
                                                                                <td class="text-nowrap"><?php echo e($lendingInformationAgainstAssignmentOfContract->getCustomerName()); ?></td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getContractName()); ?> </td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getContractAmountFormatted()); ?> </td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getContractStartDate()); ?> </td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getContractEndDate()); ?> </td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getLendingRateFormatted() . ' %'); ?> </td>
                                                                                <td> <?php echo e($lendingInformationAgainstAssignmentOfContract->getLendingAmountFormatted()); ?> </td>
                                                                                <td>

                                                                                    <a data-toggle="modal" data-target="#edit-lending-information-<?php echo e($lendingInformationAgainstAssignmentOfContract->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-primary btn-icon" type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="#"><i class="fa fa-pen-alt"></i></a>

                                                                                    <a data-toggle="modal" data-target="#delete-lending-information-<?php echo e($lendingInformationAgainstAssignmentOfContract->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>


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
                                    <?php endif; ?>

                                    <span style="overflow: visible; position: relative; width: 110px;">
                                        <?php if(hasAuthFor('update overdraft against assignment of contract')): ?>
                                        <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('edit.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract->id])); ?>"><i class="fa fa-pen-alt"></i></a>
                                        <?php endif; ?>
                                        <?php if(hasAuthFor('delete overdraft against assignment of contract')): ?>
                                        <a data-toggle="modal" data-target="#delete-financial-institution-bank-id-<?php echo e($odAgainstAssignmentOfContract->id); ?>" type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon" title="Delete" href="#"><i class="fa fa-trash-alt"></i></a>
                                        <div class="modal fade" id="delete-financial-institution-bank-id-<?php echo e($odAgainstAssignmentOfContract->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="<?php echo e(route('delete.overdraft.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'odAgainstAssignmentOfContract'=>$odAgainstAssignmentOfContract])); ?>" method="post">
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



                                    <?php $__currentLoopData = $odAgainstAssignmentOfContract->lendingInformation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$lendingInformationAgainstAssignmentOfContract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="modal fade inner-modal-class" id="edit-lending-information-<?php echo e($lendingInformationAgainstAssignmentOfContract->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('lending.information.edit.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ])); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit' )); ?></h5>
                                                        <button data-dismiss="modal" type="button" class="close" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>


                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <?php echo $__env->make('reports.overdraft-against-assignment-of-contract.lending-rate-form',[
                                                            'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract
                                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                                                        <button data-url="<?php echo e(route('lending.information.edit.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ])); ?>" type="submit" class="btn btn-primary submit-form-btn"><?php echo e(__('Confirm')); ?></button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade inner-modal-class" id="delete-lending-information-<?php echo e($lendingInformationAgainstAssignmentOfContract->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                                                        <a href="<?php echo e(route('lending.information.delete.for.against.assignment.of.contract',['company'=>$company->id,'financialInstitution'=>$financialInstitution->id,'lendingInformation'=>$lendingInformationAgainstAssignmentOfContract->id ])); ?>" class="btn btn-danger"><?php echo e(__('Confirm Delete')); ?></a>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    <?php $__currentLoopData = $odAgainstAssignmentOfContract->rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('reports.overdraft-against-assignment-of-contract.rate-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        if (searchFieldName === 'contract_start_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'contract_end_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract End Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else if (searchFieldName === 'balance_date') {
            modal.find('.data-type-span').html('[ <?php echo e(__("Balance Date")); ?> ]')
            $(modal).find('.search-field').val('').trigger('change').prop('disabled', true);
        } else {
            modal.find('.data-type-span').html('[ <?php echo e(__("Contract Start Date")); ?> ]')
            $(modal).find('.search-field').prop('disabled', false);
        }
    })
    $(function() {

        $('.js-search-modal').trigger('change')

    })

</script>
<script>
    $(document).on('change', 'select.ajax-get-contracts-for-customer-create', function() {
        const customerId = $(this).val()
        const parent = $(this).closest('.closest-parent-tr');
        const currency = parent.data('currency')
        $.ajax({
            url: "<?php echo e(route('get.contracts.for.customer.with.start.and.end.date',['company'=>$company->id])); ?>"
            , data: {
                customerId
                , currency
            }
            , success: function(res) {
                let options = '';
                for (index in res.contracts) {
                    var contract = res.contracts[index];
                    options += `<option data-amount="${number_format(contract.amount)}"  data-start-date="${contract.start_date}" data-end-date="${contract.end_date}" value="${contract.id}">${contract.name}</option>`
                }
                parent.find('.append-contracts-create').empty().append(options);
                parent.find('.append-contracts-create').trigger('change')
            }
        })
    })
    $(document).on('change', 'select.append-contracts-create', function() {
        const parent = $(this).closest('.closest-parent-tr');
        const selectedOption = $(this).find('option:selected')
        $(parent).find('.contract-start-date-class-create').val($(selectedOption).data('start-date'))
        $(parent).find('.contract-end-date-class-create').val($(selectedOption).data('end-date'))
        $(parent).find('.contract-amount-class-create').val($(selectedOption).data('amount'))

    })
    $('select.ajax-get-contracts-for-customer-create').trigger('change')

</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/overdraft-against-assignment-of-contract/index.blade.php ENDPATH**/ ?>