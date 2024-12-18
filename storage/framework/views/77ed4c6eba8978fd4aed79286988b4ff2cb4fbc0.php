<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-portlet {
        overflow: visible !important;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__('LG & LC Bank Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">


        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('result.lg.lc.bank.statement',['company'=>$company->id ])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('Start Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="start_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('End Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input required type="date" class="form-control" name="end_date" value="<?php echo e(now()->addYear()); ?>">
                                </div>
                            </div>
                        </div>





                        <div class="col-md-2 mb-4">
                            <label><?php echo e(__('Select Currency')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select js-when-change-trigger-change-account-type data-live-search="true" data-actions-box="true" name="currency" required class="form-control current-currency  kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name">
                                        <?php $__currentLoopData = getCurrency(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency=>$currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($currency == $selectedCurrency): ?>  selected <?php endif; ?> value="<?php echo e($currency); ?>"><?php echo e(touppercase($currencyName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 width-45">
                            <label><?php echo e(__('Select Bank')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">

                                    <select required js-when-change-trigger-change-account-type data-financial-institution-id name="financial_institution_id" js-get-lc-facility-based-on-financial-institution id="financial-instutition-id" class="form-control ">
                                        <?php $__currentLoopData = $financialInstitutionBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$financialInstitutionBank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($financialInstitutionBank->id); ?>" <?php echo e(isset($model) && $model->getCashInBankReceivingBankId() == $financialInstitutionBank->id ? 'selected' : ''); ?>><?php echo e($financialInstitutionBank->getName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label><?php echo e(__('Report Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required name="report_type" class="form-control update-lc-or-lg-type">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        <?php $__currentLoopData = [
											'LetterOfCreditIssuance'=>__('Letter Of Credit Bank Statement')
											 , 'LetterOfGuaranteeIssuance'=>__('Letter Of Guarantee Bank Statement'),
											 'LCOverdraft'=>__('Letter Of Credit Overdraft Bank Statement')
											 
											 ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableName => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($tableName); ?>" > <?php echo e($title); ?> </option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 width-12" id="source-div-js">
                            <label><?php echo e(__('Source')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required  name="source" class="form-control sources-js">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="col-md-3 width-12" id="type-div-js">
                            <label><?php echo e(__('Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required  name="type" class="form-control types-js">
                                       
                                    </select>
                                </div>
                            </div>
                        </div>
						
						
						 <div class="col-md-3" id="lc-facility-div-id" style="display:none">
                                        <label><?php echo e(__('LC Facility')); ?>

                                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select  js-update-outstanding-balance-and-limits data-current-selected="<?php echo e(isset($model) ? $model->getLcFacilityId() : 0); ?>" id="lc-facility-id" name="lc_facility_id" class="form-control">
                                                </select>
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







                    </div>

                </div>
          
            </div>





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
<script src="/custom/money-receive.js">

</script>
<script>
	$(document).on('change','select.update-lc-or-lg-type',function(){
		const lcOrLg = $(this).val();
		if(lcOrLg == 'LCOverdraft'){
			$('#lc-facility-div-id').show()
		}else{
			$('#lc-facility-div-id').hide()
			
		}
		if(lcOrLg){
			$.ajax({
				url:"<?php echo e(route('get.lc.or.lg.types',['company'=>$company->id])); ?>",
				data:{
					lcOrLg
				},
				success:function(res){
					
					var options = ''
					
					for(var id in res.types){
						options += `<option value="${id}">${res.types[id]}</option> `
					}
					$('select.types-js').empty().append(options).trigger('change')
					
					
							var options = ''
					for(var id in res.sources){
						options += `<option value="${id}">${res.sources[id]}</option> `
					}
					$('select.sources-js').empty().append(options).trigger('change')
					
					
					if(!Object.keys(res.sources).length){
						$('#source-div-js').hide();
						$('#source-div-js select').prop('required',false);
					}else{
						$('#source-div-js').show()
						$('#source-div-js select').prop('required',true);
					
					}
					if(!Object.keys(res.types).length){
						$('#type-div-js').hide();
						$('#type-div-js select').prop('required',false);
					}else{
			
						$('#type-div-js').show()
						$('#type-div-js select').prop('required',true);
					}
					
				}
			})
		}
	})
	
$(document).on('change','select[js-get-lc-facility-based-on-financial-institution]',function(){
	const financialInstitutionId = $('#financial-instutition-id').val();
	const currentSelected = $('select#lc-facility-id').attr('data-current-selected');

	$.ajax({
		url:"<?php echo e(route('get.lc.facility.based.on.financial.institution',['company'=>$company->id])); ?>",
		data:{
			financialInstitutionId
		},
		success:function(res){
			const lcFacilities = res.letterOfCreditFacilities ;
			let options='<option value=""><?php echo e(__("Select")); ?></option>';
		
			for(id in lcFacilities){
				var name =lcFacilities[id]; 
				options+=`<option ${currentSelected == id ? 'selected' : '' } value="${id}"  >${name}</option>`
			}
			console.log(options)
			$('select#lc-facility-id').empty().append(options).trigger('change')
		}
	})
})

$('select[js-get-lc-facility-based-on-financial-institution]').trigger('change')

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/lg_lc_statement_form.blade.php ENDPATH**/ ?>