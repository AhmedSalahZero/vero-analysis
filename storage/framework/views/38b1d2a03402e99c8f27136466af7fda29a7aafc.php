<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
.kt-portlet{
	overflow:visible !important ;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e(route('result.aging.analysis',['company'=>$company->id ,'modelType'=>$modelType ])); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">
                <div class="kt-portlet__body">
                    <div class="form-group row">
					 <div class="col-md-3 mb-4">
                            <label><?php echo e(__('Aging Date')); ?> <span class="multi_selection"></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" id="sales_channels">
                                    <input type="date" class="form-control" name="again_date" value="<?php echo e(now()); ?>">
                                </div>
                            </div>
                        </div>
						
						<?php if(count($businessUnits)): ?>
						<div class="col-md-3 mb-4">
                            <label><?php echo e(__('Select Business Unit')); ?> <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="business_units[]" class="form-control business-unit-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-refresh-customers" multiple>
                                         <?php $__currentLoopData = $businessUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($businessUnit); ?>"> <?php echo e(__($businessUnit)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
						<?php endif; ?> 
						<?php if(count($salesPersons)): ?>
						<div class="col-md-3 mb-4">
                            <label><?php echo e(__('Select Sales Person')); ?> <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="sales_persons[]" class="form-control sales-person-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-refresh-customers" multiple>
                                         <?php $__currentLoopData = $salesPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesPerson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($salesPerson); ?>"> <?php echo e(__($salesPerson)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
						<?php endif; ?> 
						<?php if(count($businessSectors)): ?>
							<div class="col-md-3 mb-4">
                            <label><?php echo e(__('Select Business Sectors')); ?> <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="business_sectors[]" class="form-control business-sector-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-refresh-customers" multiple>
                                         <?php $__currentLoopData = $businessSectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessSector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($businessSector); ?>"> <?php echo e(__($businessSector)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
						<?php endif; ?>
						
					
						 <div class="col-md-3 mb-4">
                            <label><?php echo e(__('Select Currency')); ?>   </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="currencies[]" required class="form-control currency-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-currency-name ajax-refresh-customers" >
										<?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($currencyName); ?>"><?php echo e(touppercase($currencyName)); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label><?php echo e($customersOrSupplierText); ?> <span class="multi_selection"></span>  </label>
                            <div class="kt-input-icon">
                                <div class="input-group date" >
                                    <select  data-live-search="true" data-actions-box="true" name="clients[]" required class="form-control customers-js kt-bootstrap-select select2-select kt_bootstrap_select ajax-customer-name" multiple>
									<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($invoice->getName()); ?>"><?php echo e($invoice->getName()); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
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
<script>
	
	$(document).on('change','select.ajax-refresh-customers',function(){
		const businessUnits = $('select.business-unit-js').val();
		const salesPersons = $('select.sales-person-js').val();
		const businessSectors = $('select.business-sector-js').val();
		const currencies = $('select.currency-js').val();

		$.ajax({
			url:"<?php echo e(route('get.customers.or.suppliers.from.business.units.currencies',['company'=>$company->id,'modelType'=>$modelType])); ?>",
			data:{
				business_units:businessUnits,
				business_sectors:businessSectors,
				sales_persons:salesPersons,
				currencies,
				
			},
			type:'get'
		}).then(function(res){
			let currenciesOptions = '';
			for (var currencyName of res.data.currencies_names){
				currenciesOptions += `<option ${currencies == currencyName ? 'selected' : '' } value="${currencyName}">${currencyName}</option>`
			}
			let customersOptions = '';
	
			for (var customerName of res.data.customer_names){
				customersOptions += ` <option value="${customerName}">${customerName}</option> `
			}
			$('select.currency-js').selectpicker('destroy');
			$('select.currency-js').empty().append(currenciesOptions)
			$('select.currency-js').selectpicker("refresh")
			
			$('select.customers-js').selectpicker('destroy');
			$('select.customers-js').empty().append(customersOptions)
			$('select.customers-js').selectpicker("refresh")
		})
	})
	
	$('select.ajax-refresh-customers:eq(0)').trigger('change')
	
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\veroo\resources\views/reports/aging_form.blade.php ENDPATH**/ ?>