
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>



<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__(isset($roles) ?'Edit Section' : 'Create Section')); ?>

                    </h3>
                </div>
            </div>
        </div>
            <!--begin::Form-->
            <?php $roles_row = isset($roles) ? $roles : old(); ?>
            <form class="kt-form kt-form--label-right" method="POST" action= <?php echo e(isset($role) ? route('roles.permissions.update',[$scope,$role]): route('roles.permissions.store',$scope)); ?> enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo e(isset($role) ?  method_field('POST'): ""); ?>

                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row section">

                                <div class="col-md-12">
                                    <label><?php echo e(__('Role Name')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                    <div class="kt-input-icon">
                                        <input type="text" name="role" value="<?php echo e(isset($role) ? $role->name : old('name')); ?>" class="form-control" placeholder="<?php echo e(__('Role Name')); ?>" required>
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
                                <?php echo e(__('Section Information')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
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
							 <?php $__currentLoopData = getPermissions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permissionArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group kt-checkbox-list">
                                        <div class="row col-md-12">
                                            <label class="col-3 col-form-label text-left text-capitalize"><b> <?php echo e($permissionArray['name']); ?> </b></label>
                                            <div class="col-9">
                                                <div class="kt-checkbox-inline d-flex justify-content-between">
                                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success " cheched="">
                                                        <input type="checkbox" class="view" value="1" name="permissions[<?php echo e($permissionArray['name']); ?>]"
                                                        <?php echo e(isset($role)&&$role->hasPermissionTo($permissionArray['name']) ? 'checked' : ''); ?>

                                                        > <?php echo e($permissionArray['name']); ?>

                                                        <span></span>
                                                    </label>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
                            
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
    <!--end::Page Scripts -->
    <script>
        $('#select_all').change(function(e) {
            if ($(this).prop("checked")) {
                $('.view').prop("checked", true);
                $('.create').prop("checked", true);
                $('.edit').prop("checked", true);
                $('.delete').prop("checked", true);
            } else {
                $('.view').prop("checked", false);
                $('.create').prop("checked", false);
                $('.edit').prop("checked", false);
                $('.delete').prop("checked", false);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/super_admin_view/roles_and_permissions/form.blade.php ENDPATH**/ ?>