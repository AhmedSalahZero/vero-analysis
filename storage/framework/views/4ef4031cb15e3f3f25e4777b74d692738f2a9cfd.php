
<style>
.kt-portlet__body{
	padding-top:0 !important;
}
.hover-color-black:hover i{
	color:black !important;
}
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

<div class="form-group-marginless">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-12 " >
                                        <label class="kt-option bg-secondary">
                                            <span class="kt-option__control">
                                                <span
                                                    class="kt-checkbox kt-checkbox--bold kt-checkbox--brand kt-checkbox--check-bold"
                                                    checked>
                                                    <input type="checkbox" id="select_all"  >
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="kt-option__label">
                                                <span class="kt-option__head">
                                                    <span class="kt-option__title"><b> <?php echo e(__('Select All')); ?> </b> </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
							
							 <table class="table  table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
							 	<thead>
							 	<tr>
									<th class="text-left">
										<b><?php echo e(__('Name')); ?></b>
									</th>
									<th class="text-left">
										<b><?php echo e(__('Actions')); ?></b>
									</th>
								</tr>
								
								</thead>
								
								<tbody>
							 <?php
								$groupIndex = 0 ;
							 ?>
							 <?php $__currentLoopData = formatArrayAsGroup(getPermissions($user->getSystemsNames())); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName=>$permissionArrays): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							 <tr>
							 	<td class="text-left text-capitalize">
								<?php echo e($groupIndex+1); ?>

								 <div class="kt-checkbox-inline d-flex  ">
                                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success text-capitalize" cheched="">
                                                        <input data-group-index="<?php echo e($groupIndex); ?>" type="checkbox" class="checkbox-for-row" value="1" 
                                                        checked
                                                        > 
                                                        <span></span>
													<b><?php echo e($groupName); ?></b>
                                                    </label>
                                                    
                                                </div>     
												
									
								</td>
								<td>
									<div class="row pt-5 pl-4">
									
									<?php $__currentLoopData = $permissionArrays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permissionArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="kt-checkbox-inline d-flex justify-content-between mr-4 mb-5 ">
                                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success text-capitalize" cheched="">
                                                        <input type="checkbox" class="view checkbox-for-permission" value="1" name="permissions[<?php echo e($permissionArray['name']); ?>]"
                                                        <?php echo e($user->can($permissionArray['name']) ? 'checked' : ''); ?>

                                                        > <?php echo e($permissionArray['view-name']); ?>

                                                        <span></span>
                                                    </label>
                                                    
                                                </div>    
												
												<?php
								$groupIndex++;
							 ?>        
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
									</div>
								</td>
							 </tr>

                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
							 </table>
							
                        </div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/super_admin_view/roles_and_permissions/permissions-radio.blade.php ENDPATH**/ ?>