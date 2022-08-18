<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-secondary btn-outline-hover-danger flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    <?php echo e('Sections Table'); ?>

                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">
                            <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="la la-download"></i> <?php echo e(__('Export')); ?>

                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="kt-nav">
                                    <li class="kt-nav__section kt-nav__section--first">
                                        <span class="kt-nav__section-text"><?php echo e(__('Choose an option')); ?></span>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-print"></i>
                                            <span class="kt-nav__link-text"><?php echo e(__('Print')); ?></span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-copy"></i>
                                            <span class="kt-nav__link-text"><?php echo e(__('Copy')); ?></span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                            <span class="kt-nav__link-text"><?php echo e(__('Excel')); ?></span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-text-o"></i>
                                            <span class="kt-nav__link-text"><?php echo e(__('CSV')); ?></span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                            <span class="kt-nav__link-text"><?php echo e(__('PDF')); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        &nbsp;
                        <a href="<?php echo e(route('section.create')); ?>" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            <?php echo e(__('New Record')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable text-center kt_table_1">
                <thead>
                    <tr class="table-standard-color">
                        <th><?php echo e(__('Order')); ?></th>
                        <th><?php echo e(__('Section Name')); ?></th>
                        <th><?php echo e(__('Section Side')); ?></th>
                        <th><?php echo e(__('Icon')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Controll')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->order); ?></td>
                            <td><?php echo e($item->name[$lang]); ?></td>
                            <td><?php echo e(strtoupper($item->section_side)); ?></td>
                            <td>
                                <div class="kt-demo-icon">
                                    <div class="kt-demo-icon__preview">
                                        <i class="<?php echo e($item->icon); ?>"></i>
                                    </div>
                                    <div class="kt-demo-icon__class">
                                        <?php echo e($item->icon); ?> </div>
                                </div>
                            </td>
                            <td><?php echo e($item->sub_of == 0 ? 'Main' : $item->parent->name[$lang]); ?></td>

                            <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions"
                                data-autohide-disabled="false"><span style="overflow: visible; position: relative; width: 110px;">
                                    
                                    
                                    <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" href="<?php echo e(route('section.edit',$item)); ?>"><i class="fa fa-edit"></i></a>
                                    <a type="button" class="btn btn-secondary btn-outline-hover-danger btn-icon"><i class="fa fa-trash"></i></a>
                                    <button type="button" class="btn btn-secondary btn-outline-hover-warning btn-icon"><i class="fa fa-eye"></i></button>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/super_admin_view/sections/index.blade.php ENDPATH**/ ?>