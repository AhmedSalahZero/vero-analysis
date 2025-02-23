<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .kt-list-timeline__items {
        margin-bottom: 2rem !important;
        width: 100%;
    }

    .kt-iconbox .kt-iconbox__body .kt-iconbox__desc {
        flex: 1;
    }

    .accordion .card .card-header .card-title {
        font-size: 1.5rem !important;
        font-weight: 500;
        color: black !important;

    }

    .subtitle-card-header {
        font-size: 1.25rem !important;
        color: #5578eb !important;
    }

    .with-padding {
        padding-left: 60px !important;
    }

    .repeater_item {
        border: dotted 1px #ccc;
        padding: 10px;
        margin: 10px;
        position: relative;
    }

    .repeater_item .trash_icon {
        position: absolute;
        top: 0px;
        right: 0px;
        cursor: pointer;
    }

    #add-row {
        background: #084BA6;
        border: #084BA6;
        cursor: pointer;
    }  
	.add-row {
        background: #084BA6;
        border: #084BA6;
        cursor: pointer;
    }

    .disabled-custom {
        background-color: #ececec !important;
    }

    html body .kt-list-timeline__items .kt-portlet__body .card div.card-title:not(.collapsed) {
        background-color: #046187 !important;
        color: white !important;
    }

    .card-title span {
        font-size: 22px !important;
    }

    .card-title.collapsed span {
        color: #366cf3 !important;
    }

    .card-title.collapsed i,
    .card-title.collapsed::after {
        color: #366cf3 !important
    }

    .card-title:not(.collapsed) i,
    .card-title:not(.collapsed)::after,
    .card-title:not(.collapsed) span {
        color: white !important;
    }

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
                        </svg> <?php echo e(__('Where You Want To Go :')); ?>

                    </h3>
                    <br><br>
                    <div class="kt-iconbox__content d-flex align-items-start flex-column">
                        <div class="kt-list-timeline__items">



                            <div class="kt-portlet__body">
                                <div class="kt-list-timeline">
                                    <div class="accordion  accordion-toggle-arrow" id="veroanalysisId">
                                        <?php if(auth()->user()->can('upload sales gathering data') || auth()->user()->can('upload expense analysis data') || auth()->user()->can('view sales breakdown analysis report') || auth()->user()->can(viewExpenseAnalysisData)): ?>
                                        <div class="card">
                                            <div class="card-header" id="headingOne44">
                                                <div class="card-title" data-toggle="collapse" data-target="#collapseVeroanalysisId" aria-expanded="true" aria-controls="collapseOne44">
                                                    <i class="flaticon2-layers-1"></i> <?php echo e(__('Vero Analysis ')); ?>

                                                </div>
                                            </div>
                                            <div id="collapseVeroanalysisId" class="collapse show" aria-labelledby="headingOne" data-parent="#veroanalysisId">
                                                <div class="card-body with-padding">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('upload sales gathering data')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.uploading',['company'=>$company->id,'model'=>'SalesGathering'])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.uploading',['company'=>$company->id,'model'=>'SalesGathering']))]); ?><?php echo e(__('Upload Sales Data')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales breakdown analysis report')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('sales.breakdown.analysis', ['company'=>$company->id])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('sales.breakdown.analysis', ['company'=>$company->id]))]); ?><?php echo e(__('Sales Breakdown Analysis Report')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales trend analysis')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('sales.trend.analysis', ['company'=>$company->id])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('sales.trend.analysis', ['company'=>$company->id]))]); ?><?php echo e(__('Sales Trend Analysis Report')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales report')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('salesReport.view', ['company'=>$company->id])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('salesReport.view', ['company'=>$company->id]))]); ?><?php echo e(__('Sales Report')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales dashboard')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('dashboard', $company->id)]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard', $company->id))]); ?><?php echo e(__('Sales Dashboard')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('upload expense analysis data')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.uploading',['company'=>$company->id,'model'=>'ExpenseAnalysis'])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.uploading',['company'=>$company->id,'model'=>'ExpenseAnalysis']))]); ?><?php echo e(__('Upload Expenses Data')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(viewExpenseAnalysisData)): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('sales.expense.analysis', ['company'=>$company->id])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('sales.expense.analysis', ['company'=>$company->id]))]); ?><?php echo e(__('Expense Analysis Report')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>




                                        <?php if(auth()->user()->can('uploadCustomerInvoiceData') || auth()->user()->can('uploadSupplierInvoiceData') || auth()->user()->can('view financial institutions') ): ?>
                                        <div class="card">
                                            <div class="card-header" id="cashveroSection">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseCashveroSection" aria-expanded="true" aria-controls="collapseOne4">
                                                    <i class="flaticon2-layers-1"></i> <?php echo e(__('Cash Vero')); ?>

                                                </div>
                                            </div>
                                            <div id="collapseCashveroSection" class="collapse" aria-labelledby="headingOne" data-parent="#cashveroSection">
                                                <div class="card-body with-padding">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(uploadCustomerInvoiceData)): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.uploading', ['company'=>$company->id , 'model'=>'CustomerInvoice'])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.uploading', ['company'=>$company->id , 'model'=>'CustomerInvoice']))]); ?><?php echo e(__('Upload Customer Invoices')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(uploadSupplierInvoiceData)): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.uploading', ['company'=>$company->id , 'model'=>'SupplierInvoice'])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.uploading', ['company'=>$company->id , 'model'=>'SupplierInvoice']))]); ?><?php echo e(__('Upload Supplier Invoices')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view financial institutions')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.financial.institutions', ['company'=>$company->id ])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.financial.institutions', ['company'=>$company->id ]))]); ?><?php echo e(__('Go To Cash Vero')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php if(auth()->user()->can('view income statement planning')): ?>
                                        <div class="card">
                                            <div class="card-header" id="incomestatementSection">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseIncomestatementSection" aria-expanded="true" aria-controls="collapseOne4">
                                                    <i class="flaticon2-layers-1"></i> <?php echo e(__('Income Statement Planning')); ?>

                                                </div>
                                            </div>
                                            <div id="collapseIncomestatementSection" class="collapse" aria-labelledby="headingOne" data-parent="#incomestatementSection">
                                                <div class="card-body with-padding">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view income statement planning')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('admin.view.financial.statement', ['company'=>$company->id ])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.view.financial.statement', ['company'=>$company->id ]))]); ?><?php echo e(__('Go To Planning')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>


                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>


                                        <?php if(auth()->user()->id == 1): ?>
                                        <div class="card">
                                            <div class="card-header" id="nonbankingserviceSection">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseNonbankingserviceSection" aria-expanded="true" aria-controls="collapseOne4">
                                                    <i class="flaticon2-layers-1"></i> <?php echo e(__('Non Banking Financial Service Planning')); ?>

                                                </div>
                                            </div>
                                            <div id="collapseNonbankingserviceSection" class="collapse" aria-labelledby="headingOne" data-parent="#nonbankingserviceSection">
                                                <div class="card-body with-padding">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view income statement planning')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.study', ['company'=>$company->id ])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.study', ['company'=>$company->id ]))]); ?><?php echo e(__('Go To Studies')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>


                                                </div>
                                            </div>
                                        </div>
										
										 <div class="card">
                                            <div class="card-header" id="financialplanning">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFinancialplanning" aria-expanded="true" aria-controls="collapseOne4">
                                                    <i class="flaticon2-layers-1"></i> <?php echo e(__('Financial Planning')); ?>

                                                </div>
                                            </div>
                                            <div id="collapseFinancialplanning" class="collapse" aria-labelledby="headingOne" data-parent="#financialplanning">
                                                <div class="card-body with-padding">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view income statement planning')): ?>
                                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('view.financial.planning.study', ['company'=>$company->id ])]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('view.financial.planning.study', ['company'=>$company->id ]))]); ?><?php echo e(__('Go To Studies')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    <?php endif; ?>


                                                </div>
                                            </div>
                                        </div>
										
                                        <?php endif; ?>

                                        <?php if(Auth()->user()->id ==1): ?>
                                        <div class="card">
                                            <div class="card-header" id="loanCalculatorId">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseLoanCalculatorId" aria-expanded="false" aria-controls="collapseThree4">
                                                    <i class="flaticon2-bell-alarm-symbol"></i> <?php echo e(__("Loan Calculator")); ?>

                                                </div>
                                            </div>
                                            <div id="collapseLoanCalculatorId" class="collapse" aria-labelledby="headingThree1" data-parent="#loanCalculatorId">
                                                <div class="card-body">
                                                    <div class="card-body with-padding">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('fixed.loan.fixed.at.end',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fixed.loan.fixed.at.end',$company->getIdentifier()))]); ?><?php echo e(__('Fixed Payments At The End')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('fixed.loan.fixed.at.beginning',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fixed.loan.fixed.at.beginning',$company->getIdentifier()))]); ?><?php echo e(__('Fixed Payments At The Begining')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('calc.loan.amount',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('calc.loan.amount',$company->getIdentifier()))]); ?><?php echo e(__('Calculate Loan Amount')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('calc.interest.percentage',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('calc.interest.percentage',$company->getIdentifier()))]); ?><?php echo e(__('Calculate Interest Percentage')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-header" id="collapseLoanCalculatorIdphp">
                                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseLoanCalculatorIdphp" aria-expanded="false" aria-controls="collapseThree4">
                                                    <i class="flaticon2-bell-alarm-symbol"></i> <?php echo e(__("Loan Calculator[PHP]")); ?>

                                                </div>
                                            </div>
                                            <div id="collapseLoanCalculatorIdphp" class="collapse" aria-labelledby="headingThree1" data-parent="#collapseLoanCalculatorIdphp">
                                                <div class="card-body">
                                                    <div class="card-body with-padding">
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('fixed.loan.fixed.at.end.and.beginning',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('fixed.loan.fixed.at.end.and.beginning',$company->getIdentifier()))]); ?><?php echo e(__('Fixed Payments At The End / Beginning Loan Calculator')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.quick-nav','data' => ['link' => route('variable.loan',$company->getIdentifier())]]); ?>
<?php $component->withName('quick-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('variable.loan',$company->getIdentifier()))]); ?><?php echo e(__('Variable Payment Loan Calculator')); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                                    </div>
                                                </div>
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
                            Please choose where do you want to go?
                        </h3>
                        <br><br>
                        <div class="kt-iconbox__content d-flex align-items-start flex-column">
                            



                            <div class="kt-portlet__body">
                                <div class="kt-list-timeline">
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