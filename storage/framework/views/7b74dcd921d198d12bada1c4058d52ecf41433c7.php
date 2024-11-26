
<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e(__('Income Statement Planning / Actual')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">

        <form id="form-id" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($disabled) && $disabled ? '#' : (isset($model) ? route('admin.update.financial.statement',[$company->id , $model->id]) : $storeRoute)); ?>">

            <?php echo csrf_field(); ?>
            <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
            <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">
            <div class="kt-portlet">


                <div class="kt-portlet__body">

                    <h2 for="" class="d-bloxk mb-4"><?php echo e(__('Information:')); ?></h2>



                    <div class="form-group row">

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group">
                                    <label style="font-size:18px;margin-right:25px;" for="forecast"><?php echo e(__('Forecast & Actual')); ?></label>
                                    <input style="width:20px;height:16px;margin-right:20px;position:initial !important" id="forecast" value="forecast" class="form-check-input financial-statement-type" type="radio" name="type" checked>

                                    <label style="font-size:18px;margin-right:25px;" for="actual"><?php echo e(__('Actual')); ?></label>
                                    <input style="width:20px;height:16px;position:initial !important" id="actual" value="actual" class="form-check-input financial-statement-type" type="radio" name="type">

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Name')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group">
                                    <input id="name" type="text" required class="form-control" name="name" value="<?php echo e(isset($model) ? $model->getName() : old('name')); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2 mb-4">
                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.select','data' => ['options' => $durationTypes,'addNew' => false,'label' => __('Duration Type'),'class' => 'select2-select   ','dataFilterType' => ''.e($type).'','all' => false,'name' => 'duration_type','id' => ''.e($type.'_'.'duration_type').'','selectedValue' => isset($model) ? $model->getDurationType() : 0]]); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($durationTypes),'add-new' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Duration Type')),'class' => 'select2-select   ','data-filter-type' => ''.e($type).'','all' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'name' => 'duration_type','id' => ''.e($type.'_'.'duration_type').'','selected-value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(isset($model) ? $model->getDurationType() : 0)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        </div>


                        <div class="col-md-2 mb-4">
                            <label class="form-label font-weight-bold"><?php echo e(__('Duration')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group">
                                    <input title="<?php echo e(__('Allowed Duration 24')); ?>" id="duration" type="number" class="form-control only-greater-than-zero-allowed" name="duration" value="<?php echo e(isset($model) ? $model->getDuration() : old('duration')); ?>" step="1">
								</div>
                                  <label id="allowed-duration" class="form-label"> Allowed Duration 24 </label>
                            </div>
                        </div>




                        <div class="col-md-2 mb-4">

                             <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['class' => 'label form-label font-weight-bold','id' => 'test-id']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('label form-label font-weight-bold'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('test-id')]); ?><?php echo e(__('Start From')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="text" name="start_from" class="form-control" value="<?php echo e(isset($model) ? $model->getStartFrom() : getCurrentDateForFormDate('date')); ?>" id="kt_datepicker_3" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 kt-align-right">
                            <button type="submit" class="btn active-style save-form"><?php echo e(__('Create')); ?></button>
                            
                        </div>








                        <br>
                        <hr>

                    </div>
                </div>
            </div>

            



            <!--end::Form-->

            <!--end::Portlet-->
    </div>


</div>

</div>




</div>









</div>
</div>
</form>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

<script>
$(document).on('change','.financial-statement-type',function(){
	validateDuration();
})
$(document).on('change','select[name="duration_type"]',function(){
	validateDuration();
})
$(document).on('change','#duration',function(){
	validateDuration();
})
function validateDuration()
{
	let type = $('input[name="type"]:checked').val();
	let durationType = $('select[name="duration_type"]').val();
	let duration = $('#duration').val();
	let isValid = true ; 
	let allowedDuration = 24 ;
	if(type == 'forecast' && durationType == 'monthly'){
		allowedDuration = 24 ;  
		isValid = duration <= allowedDuration;
	}
	if(type == 'forecast' && durationType == 'quarterly'){
		allowedDuration = 8;
		isValid = duration <= allowedDuration  
	}
	if(type == 'forecast' && durationType == 'semi-annually'){
		allowedDuration = 4 
		isValid = duration <= allowedDuration  
	}
	if(type == 'forecast' && durationType == 'annually'){
		allowedDuration = 2 ;
		isValid = duration <= allowedDuration  
	}
	if(type == 'actual' && durationType == 'monthly'){
		allowedDuration = 36 ;  
		isValid = duration <= allowedDuration;
	}
	if(type == 'actual' && durationType == 'quarterly'){
		allowedDuration = 12 
		isValid = duration <= allowedDuration;  
	}
	if(type == 'actual' && durationType == 'semi-annually'){
		allowedDuration = 6 ;
		isValid = duration <= allowedDuration  
	}
	if(type == 'actual' && durationType == 'annually'){
		allowedDuration =3 
		isValid = duration <= allowedDuration 
	}
	let allowedDurationText = "<?php echo e(__('Allowed Duration')); ?>";
	
	$('#allowed-duration').html(allowedDurationText + '  '+ allowedDuration)
	
	if(!isValid){
		Swal.fire({
                        icon: 'error'
                        , title: 'Invalid Duration. Allowed [ ' +allowedDuration + ' ]'
                    , })
					
		$('#duration').val(allowedDuration).trigger('change');
		
	}
	
	
}

$(function(){
	$('.financial-statement-type').trigger('change')
	
})
</script>

<script>
    $(document).on('click', '.save-form', function(e) {
        e.preventDefault(); {

            let form = document.getElementById('form-id');
            var formData = new FormData(form);
            $('.save-form').prop('disabled', true);

            $.ajax({
                cache: false
                , contentType: false
                , processData: false
                , url: form.getAttribute('action')
                , data: formData
                , type: form.getAttribute('method')
                , success: function(res) {
                    $('.save-form').prop('disabled', false)

                    Swal.fire({
                        icon: 'success'
                        , title: res.message,

                    });

                    window.location.href = res.redirectTo;




                }
                , complete: function() {
                    $('#enter-name').modal('hide');
                    $('#name-for-calculator').val('');

                }
                , error: function(res) {
                    $('.save-form').prop('disabled', false);
                    $('.submit-form-btn-new').prop('disabled', false)
                    Swal.fire({
                        icon: 'error'
                        , title: res.responseJSON.message
                    , });
                }
            });
        }
    })

</script>
<script>
    $(document).find('.datepicker-input').datepicker({
        dateFormat: 'mm-dd-yy'
        , autoclose: true
    })

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/admin/financial-statement/create.blade.php ENDPATH**/ ?>