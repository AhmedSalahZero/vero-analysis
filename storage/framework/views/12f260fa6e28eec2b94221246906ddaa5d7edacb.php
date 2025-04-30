
<?php $__env->startSection('css'); ?>
<style>
    table {
        white-space: nowrap;

    }

    input.form-control[readonly] {
        background-color: #CCE2FD !important;
        font-weight: bold !important;
    }

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sl-1.4.0/sr-1.1.1/datatables.min.css" />

<style>
    table.dataTable thead tr>.dtfc-fixed-left,
    table.dataTable thead tr>.dtfc-fixed-right {
        background-color: #086691;
    }

    thead * {
        text-align: center !important;
    }

</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
Sales Section
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
$user = auth()->user();
?>
<div class="row">
    <div class="col-lg-12">
        <?php if(session('warning')): ?>
        <div class="alert alert-warning">
            <ul>
                <li><?php echo e(session('warning')); ?></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<form action="<?php echo e(route('admin.store-cash-and-banks',['company'=>$company->id])); ?>" method="post">
<input type="hidden" value="<?php echo e($cashFlowStatementId); ?>" name="cash_flow_statement_id">
<input type="hidden" value="<?php echo e($subItemType); ?>" name="subItemType">
 <?php $__currentLoopData = $datesFormatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateAsIndex => $dateAsString): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<input type="hidden" name="dates[]" value="<?php echo e($dateAsIndex); ?>">
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo csrf_field(); ?>
<div class="kt-portlet">
    <div class="kt-portlet__body d-flex " style="flex-direction:row !important;flex-wrap:nowrap !important;">
        <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5 col-3" style="white-space:nowrap"> <?php echo e(__('Cash & Banks Beginning Balance')); ?> </h3>
        <div class="kt-input-icon">
            <div class="input-group">
                <input type="text" class="form-control col-3 only-greater-than-or-equal-zero-allowed date-value-element" value="<?php echo e(number_format(isset($model) ? $model->getCashAndBanksBeginningBalance($dateAsIndex) : old('cash_and_banks_beginning_balance',0) )); ?>" >
                <input class="date-value-element-hidden" type="hidden" name="cash_and_banks_beginning_balance" value="<?php echo e((isset($model) ? $model->getCashAndBanksBeginningBalance() : old('cash_and_banks_beginning_balance',0))); ?>">
            </div>
        </div>
    </div>
</div>
<?php
	$index=0;
?>
<?php $__currentLoopData = ['receivable'=>__('Receivables & Debtors Opening Balances - [Cash In]'),'payment'=>__('Payments & Creditors Opening Balances - [Cash Out]')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namePrefix=>$title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group row " style="flex:1">
                        <div class="col-md-4 text-left">

                            

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="d-flex align-items-center ">
                    <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e($title); ?> </h3>
                    
                </div>
            </div>

        </div>
        <div class="row">
            <hr style="flex:1;background-color:lightgray">
        </div>
        <div class="row">

            <div class="form-group row" style="flex:1;">
                <div class="col-md-12 mt-3">



                    <div class="" style="width:100%;overflow:scroll">

                        <div id="m_repeater_<?php echo e($index+4); ?>" class="cash-and-banks-repeater">
                            <div class="form-group  m-form__group row  ">
                                <div data-repeater-list="opening_<?php echo e($namePrefix); ?>" class="col-lg-12">
                                    <?php if(isset($receivables_and_payments) && ($namePrefix == 'receivable' && $hasReceivables || $namePrefix == 'payment' && $hasPayments) ): ?>
                                    <?php $__currentLoopData = $receivables_and_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receivable_and_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($receivable_and_payment->getType() == $namePrefix ): ?>
										<?php echo $__env->make('admin.cash-flow-statement.cash-opening-balance.repeater' , [
										'receivable_and_payment'=>$receivable_and_payment,
										'namePrefix'=>$namePrefix
										], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php endif; ?> 
									<?php
										unset($receivable_and_payment);
									?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <?php echo $__env->make('admin.cash-flow-statement.cash-opening-balance.repeater' , [
										'namePrefix'=>$namePrefix
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <?php endif; ?>






                                </div>
                            </div>
                            <div class="m-form__group form-group row">

                                <div class="col-lg-6">
                                    <div data-repeater-create="" class="btn btn btn-sm btn-success m-btn m-btn--icon m-btn--pill m-btn--wide <?php echo e(__('right')); ?>" id="add-row">
                                        <span>
                                            <i class="fa fa-plus"> </i>
                                            <span>
                                                <?php echo e(__('Add')); ?>

                                            </span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>



                </div>

            </div>


        </div>


    </div>
</div>
<?php
	$index++;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="text-right">
            <a href="<?php echo e(route('admin.create.cash.flow.statement.forecast.report',['cashFlowStatement'=>$cashFlowStatementId,'company'=>$company->id])); ?>" class="btn btn-primary mr-2"><?php echo e(__('Skip And Go To Cash Flow')); ?></a>
            <button type="submit" class="btn btn-primary"><?php echo e(__('Save And Go To Cash Flow')); ?></button>
        </div>
    </div>
</div>
</form>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make('js_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>


<script src="<?php echo e(asset('assets/form-repeater.js')); ?>" type="text/javascript"></script>
<script>


 
	//$('#add-row').click(function(){
	//	$('input').trigger('change')
	//})
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js_end'); ?>

<script>
	let oldValForInputNumber = 0;
        $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('focus', function() {
            oldValForInputNumber = $(this).val();
            $(this).val('')
        })
        $('input:not([placeholder]):not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([readonly]):not(.exclude-text):not(.date-input)').on('blur', function() {

            if ($(this).val() == '') {
                $(this).val(oldValForInputNumber)
            }
        })

        $(document).on('change', 'input:not([placeholder])[type="number"],input:not([placeholder])[type="password"],input:not([placeholder])[type="text"],input:not([placeholder])[type="email"],input:not(.exclude-text)', function() {
			if(!$(this).hasClass('exclude-text')){
            let val = $(this).val()
            val = number_unformat(val)
            $(this).parent().find('input[type="hidden"]:not([name="_token"])').val(val)
				
			}
        })
	
	</script>
	
<script>
   $(document).on('change', '.date-value-element', function() {
        let total = 0;
        const parent = $(this).closest('.date-element-parent');
        parent.find('.date-value-element-hidden').each(function(index, hiddenInput) {
            var currentValue = $(hiddenInput).val();
            currentValue = currentValue ? currentValue : 0;
            total += parseFloat(currentValue);
        })
        parent.find('.date-element-total-input').val(number_format(total, 0));



    })
    $('.date-value-element:first-of-type').trigger('change')
	
</script>
	
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/cash-flow-statement/cash-opening-balance/create.blade.php ENDPATH**/ ?>