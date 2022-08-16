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
            <?php $user_row = isset($user) ? $user : old(); ?>

            <form class="kt-form kt-form--label-right" method="POST" action= <?php echo e(isset($user) ? route('user.update',$user): route('user.store')); ?> enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo e(isset($user) ?  method_field('PUT'): ""); ?>

                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row col-12 col-12">
                            <div class="col-12">
                                <label><?php echo e(__('Name')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="name" value="<?php echo e(@$user_row['name']); ?>" class="form-control" placeholder="<?php echo e(__('Name')); ?>" required>
                                    <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
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
                                <?php echo e(__('User Information')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="form-group row col-12">
                            <div class="col-6">
                                <label><?php echo e(__('Email')); ?> <span class="required">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                    <input type="email" name="email" value="<?php echo e(@$user_row['email']); ?>" class="form-control" placeholder="<?php echo e(__('Email')); ?>" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-6">
                                <label><?php echo e(__('User Image')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="file" class="form-control" name="avatar" >
                                    <?php if (isset($component)) { $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\ToolTip::class, ['title' => ''.e(__('Kash Vero')).'']); ?>
<?php $component->withName('tool-tip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3)): ?>
<?php $component = $__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3; ?>
<?php unset($__componentOriginalffdb2b47423986c543526403ae50ad342b26dbd3); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if(!isset($user)): ?>
                        <div class="form-group row col-12">
                            <div class="col-6">
                                <label><?php echo e(__('Password')); ?> <span class="required">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-key"></i></span></div>
                                    <input id="password" type="password" name="password"  value="<?php echo e(@$user_row['email']); ?>" class="form-control" placeholder="<?php echo e(__('Password')); ?>" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-6">
                                <label><?php echo e(__('Confirm Password')); ?> <span class="required">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-key"></i></span></div>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo e(__('Password')); ?>" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                <?php echo e(__('Assign Companies To This User')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="form-group row col-12">

                            <div class="col-6">
                                <label><?php echo e(__('Select Companies - (Multi Selection)')); ?> </label>
                                <select name="companies[]" class="form-control kt-selectpicker" multiple>
                                    <?php $selectedcompanies = isset($user) ?  $user->companies->pluck('id')->toArray() : []; ?>
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(old('companies') == $item->id || in_array($item->id, $selectedcompanies) ? 'selected' : ''); ?>  value="<?php echo e($item->id); ?>"><?php echo e($item->name[$lang]); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                            <div class="col-6">
                                <label><?php echo e(__('Role')); ?> </label>
                                <select name="role" class="form-control kt-selectpicker"  >
                                    <option value=""><?php echo e(__('Select')); ?></option>
                                    <option <?php echo e((isset($user) && $user->hasRole('super-admin')) ? 'selected' : ''); ?>  value="super-admin"><?php echo e(__("Super Admin")); ?></option>
                                    <option <?php echo e((isset($user) && $user->hasRole('Admin') )? 'selected' : ''); ?>  value="Admin"><?php echo e(__("Admin")); ?></option>

                                </select>

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
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/super_admin_view/users/form.blade.php ENDPATH**/ ?>