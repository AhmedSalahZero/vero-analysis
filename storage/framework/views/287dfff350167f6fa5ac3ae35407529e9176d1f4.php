
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
<h1 class="kt-infobox__title" style="color: white"><?php echo e(__("WELCOME TO  ".$company->name['en']." COMPANY")); ?></h1>
<div class="kt-infobox__content" style="color: white">
    <?php echo e(__("IT IS NOT ABOUT NUMBERS, IT IS ABOUT THE STORY BEHIND THE NUMBERS")); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>




<div class="row" id="first_card">
    
    <div class="kt-portlet kt-iconbox kt-iconbox--animate">
        <div class="kt-portlet__body">
            <div class="kt-iconbox__body">
                <div class="kt-iconbox__desc">
                    <h3 class="kt-iconbox__title"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000"></path>
                            </g>
                        </svg> <?php echo e(__('Where do you want to go ?')); ?>

                    </h3>
                    <br><br>
                    <div class="kt-iconbox__content d-flex align-items-start flex-column">
                        
                        <div class="kt-portlet__body">
                            <div class="kt-list-timeline">
							
							<?php $__currentLoopData = getUploadParamsFromType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $elementModelName => $params): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(in_array($elementModelName,['ExportAnalysis','LabelingItem','CustomerInvoice','SupplierInvoice'])): ?>
							<?php continue; ?>
							<?php endif; ?> 
							
							<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($params['viewPermissionName'])): ?>
                                <div class="kt-list-timeline__items">

                                    <div class="kt-list-timeline__item ">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(getUploadDataText($params['typePrefixName'])); ?> </h4>
                                        </span>
                                        <span class="kt-list-timeline__time "> <a href="<?php echo e(route('view.uploading',['company'=>$company->id , 'model'=>$elementModelName])); ?>" class="btn btn-outline-info"> <b><?php echo e(__('Go')); ?></b></a></span>
                                    </div>
                                </div>
								<?php endif; ?>
								<br>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
								
								
										

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view financial statement')): ?>



                                <div class="kt-list-timeline__items">
                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("Income Statement Planning / Actual")); ?> </h4>
                                        </span>

                                        <span class="kt-list-timeline__time disable"> <a href="<?php echo e(route('admin.view.financial.statement',['company'=>$company->id])); ?>" class="btn btn-outline-info"><b><?php echo e(__('GO')); ?></b></a></span>
                                    </div>
                                </div>
									<br>
									
                                <?php endif; ?> 
								
								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view cash management')): ?>


                                <div class="kt-list-timeline__items">
                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("View Cash Management")); ?> </h4>
                                        </span>

                                        <span class="kt-list-timeline__time disable"> <a href="<?php echo e(route('view.financial.institutions',['company'=>$company->id])); ?>" class="btn btn-outline-info"><b><?php echo e(__('GO')); ?></b></a></span>
                                    </div>
                                </div>
                                <?php endif; ?>
								
								
								   <br>


								
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="kt-widget6__action kt-align-left">
                <a href="#" onclick="return false;" id="skip" class="btn btn-outline-info"><b><?php echo e(__('Go To Sales Analysis')); ?></b></a>
            </div>
        </div>
    </div>
    
</div>
<div class="row" style="display: none" id="second_card">
    
    <div class="kt-portlet kt-iconbox kt-iconbox--animate">
        <div class="kt-portlet__body">
            <div class="kt-iconbox__body">
                <div class="kt-iconbox__desc">
                    <h3 class="kt-iconbox__title"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000"></path>
                            </g>
                        </svg>
                        <?php echo e(__('Please choose where do you want to go?')); ?>

                    </h3>
                    <br><br>
                    <div class="kt-iconbox__content d-flex align-items-start flex-column">
                        



                        <div class="kt-portlet__body">
                            <div class="kt-list-timeline">
						<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales dashboard')): ?>
                                <div class="kt-list-timeline__items">

                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("Sales Dashboard")); ?> </h4>
                                        </span>
                                        <span class="kt-list-timeline__time"><a href="<?php echo e(route('dashboard', $company)); ?>" class="btn btn-label-info btn-pill"> <b>Go</b></a></span>
                                    </div>
                                </div>
                                <br>
								<?php endif; ?>
								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales breakdown analysis report')): ?>
                                <div class="kt-list-timeline__items">

                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("Sales Breakdown Analysis")); ?> </h4>
                                        </span>
                                        <span class="kt-list-timeline__time"> <a href="<?php echo e(route('sales.breakdown.analysis',$company)); ?>" class="btn btn-label-info btn-pill"><b>Go</b></a></span>
                                    </div>
                                </div>
                                <br>
								<?php endif; ?>
								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales trend analysis')): ?>
									
                                <div class="kt-list-timeline__items">

                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("Sales Trend Analysis")); ?> </h4>
                                        </span>
                                        <span class="kt-list-timeline__time"> <a href="<?php echo e(route('sales.trend.analysis',$company)); ?>" class="btn btn-label-info btn-pill"><b>Go</b></a></span>
                                    </div>
                                </div>
                                <br>
								<?php endif; ?>
								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales report')): ?>
                                <div class="kt-list-timeline__items">

                                    <div class="kt-list-timeline__item">
                                        <span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
                                        <span class="kt-list-timeline__text">
                                            <h4> <?php echo e(__("Sales Report")); ?> </h4>
                                        </span>
                                        <span class="kt-list-timeline__time"><a href="<?php echo e(route('salesReport.view',$company)); ?>" class="btn btn-label-info btn-pill"><b>Go</b></a></span>
                                    </div>
                                </div>
								<?php endif; ?> 
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    
</div>














































<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript">
</script>
<script>
    $(function() {
        $('#skip').on('click', function(e) {
            e.preventDefault();
            $('#first_card').fadeOut("slow", function() {
                $('#second_card').fadeIn(500);
            });
        });

    })

</script>
<!-- Resources -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/homePage.blade.php ENDPATH**/ ?>