<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('custom/axios.js')); ?>"></script>

<script>
    setInterval(() => {
        let company_id = "<?php echo e($company->id); ?>"
        axios.get('/removeSessionForRedirect').then(res => {
            if (res.data.status) {
                window.location.href = res.data.url
            }

        })
    }, 2000)

</script>

<div class="row">
    <div class="col-lg-12">
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Please Choose Fields That You Need To Be in Your Excel Sheet')); ?>

                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('table.fields.selection.save', [$company,$model, $modelName])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="model_name" value="<?php echo e($model); ?>">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary ">
                            <?php echo e(__('Fields Names')); ?>

                        </h3>
                    </div>

                </div>
                <div class="kt-portlet__body">
                    <div class="form-group row form-group-marginless">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <label class="kt-option bg-secondary">
                                        <span class="kt-option__control">
                                            <span class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold" checked>
                                                <input type="checkbox" id="select_all" <?php echo e(count($selected_fields) == count($columnsWithViewingNames) ? 'checked' : ''); ?>>
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="kt-option__label">
                                            <span class="kt-option__head">
                                                <span class="kt-option__title">
                                                    <b>
                                                        <?php echo e(__('Select All')); ?>

                                                    </b>
                                                </span>

                                            </span>
                                           
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php $__currentLoopData = $columnsWithViewingNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName => $displayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!hideExportField($fieldName , $columnsWithViewingNames)): ?>
                                <?php
                                            $status_disanbeled_fields = $fieldName == 'net_sales_value' ||  $fieldName == 'invoice_status' || 
                                                            ($fieldName == 'sales_value'  && count(array_intersect($selected_fields, ['quantity_discount','cash_discount','special_discount','other_discounts'])) == 0 );
															$hiddenFields = ['invoice_status','net_balance'];
										if($modelName == 'LoanSchedule'){
											$status_disanbeled_fields = true;
										}
										?>
										
										<?php if(!in_array($fieldName,$hiddenFields)): ?>
                                <div class="col-lg-6">
                                    <label class="kt-option <?php if($status_disanbeled_fields): ?> not_allowed_curser <?php endif; ?>">
                                        <span class="kt-option__control ">

                                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand
                                                        <?php if($status_disanbeled_fields): ?>
                                                            kt-checkbox--disabled
                                                        <?php endif; ?>">
                                                <input type="checkbox" name="fields[]" value="<?php echo e($fieldName); ?>" <?php if($fieldName !='net_sales_value' ): ?> class="fields" <?php endif; ?> <?php if(((false !==$found=array_search($fieldName,$selected_fields)) || $fieldName=='net_sales_value'||$fieldName=='invoice_status'  ) || $modelName == 'LoanSchedule' ): ?> checked <?php endif; ?> <?php if($status_disanbeled_fields): ?> disabled="disabled" style="cursor: not-allowed;" <?php endif; ?> id="<?php echo e($fieldName); ?>">
                                                <span></span>
                                            </label>

                                           
                                        </span>
                                        <span class="kt-option__label">
                                            <span class="kt-option__head">
                                                <span class="kt-option__title">
                                                    <?php echo e(__($displayName)); ?>

                                                    <?php if($fieldName == 'document_type'): ?>
                                                    <span> ( Only Allowed Content
                                                        <u>
                                                            [INV , inv , invoice , INVOICE ,فاتوره ]
                                                        </u> )
                                                    </span>

                                                    <?php endif; ?>
                                                </span>

                                            </span>
                                        </span>
                                    </label>
                                </div>
								<?php endif; ?>
                                <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

             <?php if (isset($component)) { $__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\CustomButtonNameToSubmit::class, ['displayName' => __('Download')]); ?>
<?php $component->withName('custom-button-name-to-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6)): ?>
<?php $component = $__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6; ?>
<?php unset($__componentOriginal2c410a558fece28659f3c2cb5a2dd51c49d779c6); ?>
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

</script>
<!--end::Page Scripts -->
<script>
    $('#select_all').change(function(e) {
        if ($(this).prop("checked")) {
            $('.fields').prop("checked", true);
        } else {
            $('.fields').prop("checked", false);
        }
        $('#date').prop('checked', true)
    });
    $('#quantity_discount,#cash_discount,#special_discount,#other_discounts').change(function(e) {
        if ($('#quantity_discount').prop("checked") || $('#cash_discount').prop("checked") || $('#special_discount').prop("checked") || $('#other_discounts').prop("checked")) {
            $('#sales_value').prop("checked", true);
        } else {
            $('#sales_value').prop("checked", false);
        }
    });

</script>

<script>
    $('#date').on('change', function() {
        $(this).prop('checked', true)
    })
    $('#date').prop('checked', true)

</script>
<script>
$('#product_or_service').on('change',function(){
	const val = $(this).val() ;
	const isChecked = $(this).is(":checked")
	if(isChecked){
		$('#product_item').prop('disabled',false)
	}
	else{
		$('#product_item').prop('checked',false).prop('disabled',true)
	}
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/Exportation/fieldsSelectionToBeExported.blade.php ENDPATH**/ ?>