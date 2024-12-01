
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('SECTIONS')); ?>

                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <?php $row = isset($companySection) ? $companySection : old(); ?>

        <form class="kt-form kt-form--label-right" method="POST" action=<?php if(isset($company_row)): ?> <?php if(isset($companySection) ): ?> <?php echo e(route('edit.admin.company',[$company_row,$companySection])); ?> <?php else: ?> <?php echo e(route('admin.company',$company_row)); ?> <?php endif; ?> <?php elseif(isset($companySection) ): ?> <?php echo e(route('companySection.update',$companySection)); ?> <?php else: ?> <?php echo e(route('companySection.store')); ?> <?php endif; ?> enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo e(isset($companySection) ?  method_field('PUT'): ""); ?>

            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <div class="form-group row col-12">
                        <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6">
                            <label><?php echo e(__('Company Name ') . $lang_row->name); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <input type="text" name="name[<?php echo e($lang_row->code); ?>]" value="<?php echo e(@$row['name'][$lang_row->code]); ?>" class="form-control" placeholder="<?php echo e(__('Company Name ') . $lang_row->name); ?>" required>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Company Information')); ?>

                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">



                    <div class="form-group row col-12">
                        <div class="col-md-4">
                            <label><?php echo e(__('Systems')); ?> <span class=""></span> </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <select required id="role-id" name="systems[]" multiple data-live-search="true" data-actions-box="true" class="select2-select form-control kt-bootstrap-select kt_bootstrap_select">
                                        <?php $__currentLoopData = \App\Models\CompanySystem::getAllSystemNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentSystemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currentSystemName); ?>" <?php if(in_array($currentSystemName,old('systems',[]))): ?> selected <?php elseif(isset($companySection) && $companySection->hasSystem($currentSystemName) ): ?> selected <?php endif; ?> ><?php echo e(str_to_upper($currentSystemName)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <label><?php echo e(__('Main Functional Currency') . $lang_row->name); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                            <div class="kt-input-icon">
                                <select name="main_functional_currency" class="form-control">
                                    <?php $__currentLoopData = getCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyName => $currencyNameFormatted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($currencyName); ?>"> <?php echo e($currencyNameFormatted); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <label><?php echo e(__('Company Image')); ?></label>
                            <div class="kt-input-icon">
                                <input type="file" class="form-control" name="image">
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
			
			
			
			
			
			 <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title head-title text-primary">
                            <?php echo e(__('Oddo Integration')); ?>

                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body">



                    <div class="form-group row col-12">
                 

  <div class="col-3">
                            <label><?php echo e(__('Database URL')); ?></label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_url" value="<?php echo e(@$row['oddo_db_url']); ?>" class="form-control" placeholder="<?php echo e(__('Oddo  Database URL')); ?>" >
                            </div>
                        </div>
						  <div class="col-3">
                            <label><?php echo e(__('Database Name')); ?></label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_name" value="<?php echo e(@$row['oddo_db_name']); ?>" class="form-control" placeholder="<?php echo e(__('Oddo  Database Name')); ?>" >
                            </div>
                        </div>
                    <div class="col-3">
                            <label><?php echo e(__('User Name')); ?></label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_username" value="<?php echo e(@$row['oddo_username']); ?>" class="form-control" placeholder="<?php echo e(__('Oddo  User Name')); ?>" >
                            </div>
                        </div>
						
						 
						
						<div class="col-3">
                            <label><?php echo e(__('Password')); ?></label>
                            <div class="kt-input-icon">
                                <input type="text" name="oddo_db_password" value="<?php echo e(@$row['oddo_db_password']); ?>" class="form-control" placeholder="<?php echo e(__('Oddo  Database Password')); ?>" >
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
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script>
    $('.company_type').change(function() {
        val = $(this).val();
        if (val == 'single') {
            $('#num_of_companies').addClass('hidden');
            $('.num_of_companies').val('');
        } else {
            $('#num_of_companies').removeClass('hidden');
        }
    });

</script>
<!--end::Page Scripts -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/super_admin_view/companies/form.blade.php ENDPATH**/ ?>