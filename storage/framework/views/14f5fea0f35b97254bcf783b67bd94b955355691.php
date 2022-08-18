<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css" />

    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__(isset($section) ?'Edit Section' : 'Create Section')); ?>

                    </h3>
                </div>
            </div>
        </div>
            <!--begin::Form-->
            <?php $section_row = isset($section) ? $section : old(); ?>
            <form class="kt-form kt-form--label-right" method="POST" action= <?php echo e(isset($section) ? route('section.update',$section): route('section.store')); ?> enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo e(isset($section) ?  method_field('PUT'): ""); ?>

                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row section">
                            <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-6">
                                    <label><?php echo e(__('Section Name ') . $lang_row->name); ?> <span class="required">*</span></label>
                                    <div class="kt-input-icon">
                                        <input type="text" name="name[<?php echo e($lang_row->code); ?>]" value="<?php echo e(@$section_row['name'][$lang_row->code]); ?>" class="form-control" placeholder="<?php echo e(__('Section Name ') . $lang_row->name); ?>" required>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label><?php echo e(__('Route')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="route" value="<?php echo e(@$section_row['route']); ?>"  class="form-control" placeholder="<?php echo e(__('Route')); ?>" >
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
                            <div class="col-lg-6">
                                <label><?php echo e(__('Sub Of')); ?> <span class="required">*</span>    </label>
                                <div class="kt-input-icon">
                                    <div class="input-group date">
                                        <select name="sub_of" class="form-control kt-select2" id="kt_select2_5"  required>
                                            <optgroup label="Main Routes">
                                                <option value="0"  <?php echo e(@$section_row['sub_of'] == 0 ? 'selected' : ''); ?>><?php echo e(__('Main')); ?></option>
                                                <?php $__currentLoopData = $main_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e(@$item->id); ?>" <?php echo e(@$section_row['sub_of'] == @$item->id ? 'selected' : ''); ?>><?php echo e($item->name[$lang]); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <optgroup label="Sub Routes">
                                                <?php $__currentLoopData = $sub_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e(@$item->id); ?>" <?php echo e(@$section_row['sub_of'] == @$item->id ? 'selected' : ''); ?>><?php echo e($item->name[$lang]); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label><?php echo e(__('Icon')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="text" name="icon" value="<?php echo e(@$section_row['icon']); ?>" class="form-control" placeholder="<?php echo e(__('Icon')); ?>" required>
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
                            <div class="col-lg-6">
                                <label><?php echo e(__('Order')); ?> <span class="required">*</span></label>
                                <div class="kt-input-icon">
                                    <input type="number" name="order" value="<?php echo e(@$section_row['order']); ?>" class="form-control" placeholder="<?php echo e(__('Order')); ?>" required>
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
                        <div class="form-group row form-group-marginless">
                            <label class="col-lg-1 col-form-label">Section Side</label>
                            <div class="col-lg-11">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="kt-option">
                                            <span class="kt-option__control">
                                                <span class="kt-radio kt-radio--bold kt-radio--brand kt-radio--check-bold" checked>
                                                    <input type="radio" name="section_side" value="admin" <?php echo e(@$section_row['section_side'] == 'admin' ? 'checked' : ''); ?>>
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="kt-option__label">
                                                <span class="kt-option__head">
                                                    <span class="kt-option__title">
                                                        <?php echo e(__('Admin Side')); ?>

                                                    </span>

                                                </span>
                                                <span class="kt-option__body">
                                                    <?php echo e(__('This Section Will Be Added In The Client Side')); ?>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="kt-option">
                                            <span class="kt-option__control">
                                                <span class="kt-radio kt-radio--bold kt-radio--brand">
                                                    <input type="radio" name="section_side" value="client" <?php echo e(@$section_row['section_side'] == 'client' ? 'checked' : ''); ?>>
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="kt-option__label">
                                                <span class="kt-option__head">
                                                    <span class="kt-option__title">
                                                        <?php echo e(__('Client Side')); ?>

                                                    </span>

                                                </span>
                                                <span class="kt-option__body">
                                                    <?php echo e(__('This Section Will Be Added In The Client Side')); ?>

                                                </span>
                                            </span>
                                        </label>
                                    </div>
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
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/select2.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/select2.js')); ?>" type="text/javascript"></script>
    <!--end::Page Scripts -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/super_admin_view/sections/form.blade.php ENDPATH**/ ?>