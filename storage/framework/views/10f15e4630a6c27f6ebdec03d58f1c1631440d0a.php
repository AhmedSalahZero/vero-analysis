
<?php $__env->startSection('css'); ?>
    <style>
        table {
            white-space: nowrap;
        }
        
    </style>

    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
    <?php echo e(__($section->name[lang()])); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
	$user = auth()->user();
?>
<div class="col-md-12">

    <!--begin:: Widgets/Tasks -->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                   <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainName=>$options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
                       
                       <li class="nav-item">
							<?php
							
								$mainIsActive = $loop->first ;
								$mainNameAsId=convertStringToClass($mainName);
							?>
                                    <a class="nav-link <?php echo e($mainIsActive ?'active':''); ?>" onclick="return false" data-toggle="tab" href="#kt_widget2_tab1_content_<?php echo e($mainNameAsId); ?>" role="tab">
                                        <i
                                        class="kt-menu__ver-arrow <?php echo e($options['icon']); ?>"></i><span class="kt-menu__link-text">
											<?php echo e($options['view_name']); ?>											
                                            </span>
                                    </a>
                                </li>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
                  <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainName=>$options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
							$subIsActive = $loop->first ;
							$mainNameAsId=convertStringToClass($mainName);
						?>
                        <div class="tab-pane <?php echo e($subIsActive ? 'active':''); ?>" id="kt_widget2_tab1_content_<?php echo e($mainNameAsId); ?>">
                            <div class="kt-widget2">
                                <div class="row">
                                    

                                    <?php $__currentLoopData = $options['subTabs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subTabArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$route = $subTabArr['route'];
										$subName = $subTabArr['view_name'];
									?>


                                                <div class="col-md-4">
                                                    <div class="kt-widget2__item kt-widget2__item--primary">
                                                        <div class="kt-widget2__checkbox">
                                                        </div>
                                                      
														
                                                        <div class="kt-widget2__info">
                                                            <a href="<?php echo e($route); ?>" class="kt-widget2__title">
															<?php echo e($subName); ?>

                                                            </a>

                                                        </div>
                                                        <div class="kt-widget2__actions">

                                                        </div>
                                                    </div>
                                                </div>
											

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!--end:: Widgets/Tasks -->
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/list_expense_analysis.blade.php ENDPATH**/ ?>