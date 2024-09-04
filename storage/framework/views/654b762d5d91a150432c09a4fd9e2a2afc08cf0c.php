<?php
use App\Models\MoneyReceived;
?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

    input.form-control[disabled]:not(.ignore-global-style),
    input.form-control:not(.is-date-css)[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('Cheque Under Collection')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->

        <form method="post" action="<?php echo e(isset($model) ?  route('cheque.send.to.collection',['company'=>$company->id]) :'#'); ?>" class="kt-form kt-form--label-right">
            <input type="hidden" name="cheques[]" value="<?php echo e($model->id); ?>">
			<input type="hidden" name="is_from_under_collection_form" value="1">
            <?php echo csrf_field(); ?>

            
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Cheque Info')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <div class="row mb-3">
                        <input type="hidden" class="current-currency" value="<?php echo e($model->getCurrency()); ?>">
                        <?php $__currentLoopData = [
                        'customer_name'=>['title'=>__('Customer Name'),'value'=>$model->getCustomerName() , 'class'=>'col-md-5'],
                        'cheque_amount'=>['title'=>__('Cheque Amount'),'value'=>$model->getReceivedAmount() , 'class'=>'col-md-3'],
                        'currency'=>['title'=>__('Currency'),'value'=>$model->getCurrency() , 'class'=>'col-md-2'],
                        'cheque_number'=>['title'=>__('Cheque Number'),'value'=>$model->cheque->getChequeNumber() , 'class'=>'col-md-2'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uniqueName => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="<?php echo e($field['class']); ?> mb-3">
                            <label><?php echo e($field['title']); ?> </label>
                            <div class="kt-input-icon">
                                <input readonly type="text" value="<?php echo e(strtoupper($field['value'])); ?>" class="form-control">
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Cheque Deposit Info')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label><?php echo e(__('Cheque Deposit Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required value="<?php echo e($model->getChequeDepositDateFormattedForDatePicker()); ?>" type="text" name="deposit_date" class="form-control" placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						

                        <div class="col-md-9 mb-3">
                            <label><?php echo e(__('Drawal Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date ">
                                    <select js-when-change-trigger-change-account-type data-financial-institution-id name="receiving_bank_id[<?php echo e(MoneyReceived::CHEQUE_UNDER_COLLECTION); ?>]" class="form-control js-drawl-bank">
                                        <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->cheque->drawl_bank_id == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>


                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
	
                        <div class="col-md-4">
                            <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-currency="<?php echo e($model->getCurrency()); ?>" name="account_type[<?php echo e(MoneyReceived::CHEQUE_UNDER_COLLECTION); ?>]" class="form-control js-update-account-number-based-on-account-type">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>

                                        <?php $__currentLoopData = $accountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($accountType->getId()); ?>" <?php if($accountType->getId() ==$model->getChequeAccountType() ): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 width-12">
                            <label><?php echo e(__('Account Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-current-selected="<?php echo e($model->getChequeAccountNumber()); ?>" name="account_number[<?php echo e(MoneyReceived::CHEQUE_UNDER_COLLECTION); ?>]" class="form-control js-account-number">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('Account Balance')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <input value="<?php echo e($model->cheque->getAccountBalance()); ?>" required value="0" readonly type="text" name="cheque_account_balance" class="form-control" placeholder="<?php echo e(__('Account Balance')); ?>">
                                 <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('Clearance Days')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <input value="<?php echo e($model->cheque->getClearanceDays()); ?>" required name="clearance_days" step="any" min="0" class="form-control only-greater-than-zero-or-equal-allowed" placeholder="<?php echo e(__('Clearance Days')); ?>">
                                 <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            </div>
                        </div>


                    </div>
                </div>
            </div>




            <div class="kt-portlet hidden" id="cheque">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Cheque Information')); ?>

                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label><?php echo e(__('Select Drawee Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="drawee_bank_id" class="form-control ">
                                            
                                            <?php $__currentLoopData = $selectedBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankId=>$bankName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bankId); ?>" <?php echo e(isset($model) && $model->cheque && $model->cheque->getDraweeBankId() == $bankId ? 'selected':''); ?>><?php echo e($bankName); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <button id="js-drawee-bank" class="btn btn-sm btn-primary">Add New Bank</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label><?php echo e(__('Cheque Amount')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input data-max-cheque-value="0" value="<?php echo e(isset($model) ? $model->getReceivedAmount() : 0); ?>" placeholder="<?php echo e(__('Please insert the cheque amount')); ?>" type="text" name="cheque_amount" class="form-control only-greater-than-or-equal-zero-allowed js-cheque-received-amount">
                                     <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Please insert the cheque amount')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </div>
                            </div>


                            <div class="col-md-2">
                                <label><?php echo e(__('Cheque Due Date')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <input type="text" value="<?php echo e(isset($model) ?$model->cheque->getDueDate():0); ?>" name="due_date" class="form-control is-date-css" readonly placeholder="Select date" id="kt_datepicker_2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <label><?php echo e(__('Cheque Number')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="cheque_number" value="<?php echo e(isset($model) ? $model->cheque->getChequeNumber() : 0); ?>" class="form-control" placeholder="<?php echo e(__('Cheque Number')); ?>">
                                     <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                </div>
                            </div>


                            
                    </div>
                </div>

            </div>
    </div>



     <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

    </form>
    <!--end::Form-->

    <!--end::Portlet-->
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
    $(document).on('click', '#js-drawee-bank', function(e) {
        e.preventDefault();
        $('#js-choose-bank-id').modal('show');
    })

    $(document).on('click', '#js-append-bank-name-if-not-exist', function() {
        const receivingBank = document.getElementById('js-drawee-bank').parentElement;
        const newBankId = $('#js-bank-names').val();
        const newBankName = $('#js-bank-names option:selected').attr('data-name');
        const isBankExist = $(receivingBank).find('select.js-drawl-bank').find('option[value="' + newBankId + '"]').length;
        if (!isBankExist) {
            const option = '<option selected value="' + newBankId + '">' + newBankName + '</option>'
            $('#js-drawee-bank').parent().find('select.js-drawl-bank').append(option);
        }
        $('#js-choose-bank-id').modal('hide');
    });

</script>
<script src="/custom/money-receive.js">

</script>
<script>

$(function(){
		$('select.currency-class').trigger('change')
		$('.recalculate-amount-class').trigger('change')
	})
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/reports/moneyReceived/edit-cheque-under-collection.blade.php ENDPATH**/ ?>