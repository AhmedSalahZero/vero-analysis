
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<?php echo e(__($view_name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">



        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="<?php echo e($submitRouteName); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="kt-portlet" style="overflow-x:hidden">

                <?php
                $column = 6 ;

                ?>

                <input type="hidden" name="type" value="<?php echo e($lastColumnName); ?>">
                
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <div class="<?php echo e($classesBasedOnSelectorCount['data_type']); ?>">
                            <label><?php echo e(__('Data Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="data_type" id="data_type" class="form-control">
                                        <option selected value="value"><?php echo e(__('Value')); ?></option>
                                        <option value="quantity"><?php echo e(__('Quantity')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="<?php echo e($classesBasedOnSelectorCount['report_type']); ?>">
                            <label><?php echo e(__('Report Type')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="report_type" id="report_type" class="form-control ">
                                        <option selected value="trend"><?php echo e(__('Trend')); ?></option>
                                        <option value="comparing"><?php echo e(__('Interval Comparing')); ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>


                       




                        <?php $__env->startPush('js'); ?>

                        <script>
                            $(function() {
                                $('#report_type').on('change', function() {
                                    let reportType = $(this).val();
                                    $('#comparing__id').remove();
                                    $('select[name="interval"]').closest('div[class*="col-"]').removeClass('d-none');
                                    $('select[name="interval"]').attr('required', 'required');

                                    if (reportType == 'comparing') {
                                        $('select[name="interval"]').closest('div[class*="col-"]').addClass('d-none');
                                        $('select[name="interval"]').removeAttr('required');
                                        let clonedField = $('input[name="start_date"]').closest('.row').clone(true);

                                        $(clonedField).find('input').each(function(index, inputField) {
                                            if ($(inputField).attr('type') == 'date') {
                                                var currentValue = $(inputField).attr('value');
                                                if (currentValue) {
                                                    var year = currentValue.split('-')[0] - 1;
                                                    var month = currentValue.split('-')[1];
                                                    var day = currentValue.split('-')[2];

                                                    $(inputField).attr('value', year + '-' + month + '-' + day);

                                                }

                                            }
                                            $(inputField).attr('name', $(inputField).attr('name') + '_second');
                                        })
                                        $(clonedField).find('label.first-interval').each(function(index, inputField) {
                                            $(inputField).html("<?php echo e(__('Second Interval')); ?>");
                                            $(inputField).removeClass('first-interval').addClass('d-block')
                                            $(inputField).addClass('second-interval').addClass('d-block')

                                        })
                                        if (clonedField.length) {

                                            let div = $('<div id="comparing__id"></div>');
                                            $('input[name="start_date"]').closest('.row').after(div);
                                            // alert($(document).find('#comparing__id').length);
                                            $('#comparing__id').empty();
                                            $('#comparing__id').append(clonedField);

                                            $('label.first-interval').closest('div.first-interval').removeClass('d-none').addClass('d-block')
                                            $('label.second-interval').closest('div.first-interval').removeClass('d-none').addClass('d-block')
                                            $('input[type="date"]').trigger('change')

                                        }
                                    } else {
                                        $('label.first-interval').closest('div.first-interval').addClass('d-none').removeClass('d-block')
                                        $('label.second-interval').closest('div.first-interval').addClass('d-none').removeClass('d-block')
                                    }
                                });
                                $('#report_type').trigger('change');
                            })

                        </script>

                        <?php $__env->stopPush(); ?>


                        
<?php if($isComparingReport): ?>
                    </div>
<?php endif; ?> 
					<?php if($isComparingReport): ?>
                    <div class="form-group row">
					<?php endif; ?> 
                        <?php if(isset(get_defined_vars()['__data']['type']) && get_defined_vars()['__data']['type'] !='averagePrices'): ?>
                        <div class="col-md-4  first-interval">
                            <label></label>
                            <div class="flex-center "><label class="first-interval"><?php echo e(__('First Interval')); ?></label></div>

                        </div>
                        <?php endif; ?>

                        <div class="<?php echo e($classesBasedOnSelectorCount['start_date']); ?>">
                            <label><?php echo e(__('Start Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="start_date" value="<?php echo e(getEndYearBasedOnDataUploaded($company)['jan']); ?>" required class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="<?php echo e($classesBasedOnSelectorCount['end_date']); ?>">
                            <label><?php echo e(__('End Date')); ?></label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input type="date" name="end_date" required value="<?php echo e(getEndYearBasedOnDataUploaded($company)['dec']); ?>" class="form-control trigger-update-select-js" placeholder="Select date" />
                                </div>
                            </div>
                        </div>
                        <div class="<?php echo e($classesBasedOnSelectorCount['interval']); ?>">
                            <label><?php echo e(__('Select Interval')); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select name="interval" required class="form-control">
                                        <option value="" selected><?php echo e(__('Select')); ?></option>
                                        
                                        <option value="monthly"><?php echo e(__('Monthly')); ?></option>
                                        <option value="quarterly"><?php echo e(__('Quarterly')); ?></option>
                                        <option value="semi-annually"><?php echo e(__('Semi-Annually')); ?></option>
                                        <option value="annually"><?php echo e(__('Annually')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
				<?php if($isComparingReport): ?>
                    </div>
					<?php endif; ?> 
<?php if($isComparingReport): ?>
                    <div class="form-group row">
					<?php endif; ?> 
                        <div class="<?php echo e($classesBasedOnSelectorCount['first_selector']); ?>">

                            <label><?php echo e(__('Select ' . $firstColumnViewName)); ?> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>



							<input type="hidden" id="filter-table-name-id" name="tableName" value="<?php echo e($tableName); ?>">
                            <input type="hidden" id="first-column-name-id" name="firstColumnName" value="<?php echo e($firstColumn); ?>">
                            <input type="hidden" id="second-column-name-id" name="secondColumnName" value="<?php echo e($secondColumn); ?>">
                            <input type="hidden" id="third-column-name-id" name="thirdColumnName" value="<?php echo e($thirdColumn); ?>">
                            <input type="hidden" name="reportSelectorType" value="<?php echo e($reportSelectorType); ?>">
							
                            <input type="hidden" id="append-to" value="firstColumnData">

                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-column-name="<?php echo e($firstColumn); ?>" name="firstColumnData[]" required data-live-search="true" data-actions-box="true" class="first-column-filter form-control  kt-bootstrap-select select2-select kt_bootstrap_select" id="firstColumnData" multiple>
                                        <?php $__currentLoopData = $firstColumnData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $firstColumnItemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($firstColumnItemName); ?>"> <?php echo e(__($firstColumnItemName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

					<?php if($reportSelectorType == 'two_selector' || $reportSelectorType == 'three_selector'): ?>
                        <div class="<?php echo e($classesBasedOnSelectorCount['second_selector']); ?>">
                            <label><?php echo e(__('Select '.$secondColumnViewName.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="secondColumnData[]" required class="form-control second-column-filter kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
						<?php endif; ?>
					
						<?php if($reportSelectorType == 'three_selector'): ?>
						<div class="<?php echo e($classesBasedOnSelectorCount['third_selector']); ?>">
                            <label><?php echo e(__('Select '.$thirdColumnViewName.' ')); ?> <span class="multi_selection"></span> <?php echo $__env->make('max-option-span', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select data-live-search="true" data-actions-box="true" name="thirdColumnData[]" required class="form-control third-column-filter kt-bootstrap-select select2-select kt_bootstrap_select" multiple>
                                        
                                        
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
						<?php endif; ?>
						
						
                        
						<?php if($isComparingReport): ?>
                    </div>
					<?php endif; ?>

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
$(document).on('change','select.first-column-filter',function(){
	const val = $(this).val()
	const filterTableName = $('#filter-table-name-id').val();
	const mainColumnName = $('#first-column-name-id').val();
	const mainColumnValues = $('select.first-column-filter').val();
	const secondColumnName = $('#second-column-name-id').val();
	const secondColumnValues = $('select.second-column-filter').val();
	const startDate = $('#input[name="start_date"]').val();
	const endDate = $('#input[name="end_date"]').val();
	if(mainColumnName && secondColumnName){
		$.ajax({
			url:"<?php echo e(route('filter.column.based.on.another.column',['company'=>$company->id])); ?>",
			data:{
				filterTableName,
				mainColumnName,
				mainColumnValues,
				secondColumnName,
				secondColumnValues,
				startDate,
				endDate
			},
			success:function(res){
				let options ='';
				for(item of res.result){
					var title = item.second_column ;
					options+='<option value="'+ title +'"> '+ title +' </option>';
				}
				$('select.second-column-filter').empty().append(options).trigger('change')
			}
			
		})
	}
})

$(document).on('change','select.second-column-filter',function(){
	const val = $(this).val()
	const filterTableName = $('#filter-table-name-id').val();
	const mainColumnName = $('#first-column-name-id').val();
	const mainColumnValues = $('select.first-column-filter').val();
	const secondColumnName = $('#second-column-name-id').val();
	const secondColumnValues = $('select.second-column-filter').val();
	const thirdColumnName = $('#third-column-name-id').val();
	const thirdColumnValues = $('select.third-column-filter').val();
	const startDate = $('#input[name="start_date"]').val();
	const endDate = $('#input[name="end_date"]').val();
	if(mainColumnName && secondColumnName){
		$.ajax({
			url:"<?php echo e(route('filter.column.based.on.another.column',['company'=>$company->id])); ?>",
			data:{
				filterTableName,
				mainColumnName,
				mainColumnValues,
				secondColumnName,
				secondColumnValues,
				thirdColumnName,
				thirdColumnValues,
				startDate,
				endDate
			},
			success:function(res){
				let options ='';
				for(item of res.result){
					var title = item.second_column ;
					options+='<option value="'+ title +'"> '+ title +' </option>';
				}
				$('select.third-column-filter').empty().append(options).trigger('change')
			}
			
		})
	}
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/reports/sales_gathering_analysis/expense-against-report.blade.php ENDPATH**/ ?>