<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('dash_nav'); ?>
<style>
    .chartdiv_two_lines {
        width: 100%;
        height: 275px;
    }

    .chartDiv {
        max-height: 275px !important;
    }

    .margin__left {
        border-left: 2px solid #366cf3;
    }

    .sky-border {
        border-bottom: 1.5px solid #CCE2FD !important;
    }

    .kt-widget24__title {
        color: black !important;
    }

</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    table {
        white-space: nowrap;
    }

    /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="kt-portlet">

    <form action="<?php echo e(route('view.customer.invoice.dashboard.cash',['company'=>$company->id])); ?>" class="kt-portlet__head w-full sky-border" style="">
        <div class="kt-portlet__head-label w-full">
            <h3 class="kt-portlet__head-title head-title text-primary w-full">


                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="visibility-hidden"> <?php echo e(__('Currency')); ?>

                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-nowrap" style=""> <?php echo e(__('Dashboard Results')); ?></h3>

                    </div>
                    <div class="col-md-2">
                        <label class="visibility-hidden"> <?php echo e(__('Currency')); ?>

                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>
                        <div class="kt-input-icon">
                            <div class="input-group date">
                                <input id="js-date" type="date" value="<?php echo e(date('Y-m-d')); ?>" name="date" class="form-control" max="<?php echo e(date('Y-m-d')); ?>" placeholder="Select date" id="kt_datepicker_2" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 kt-align-right">

                        <label class="visibility-hidden"> <?php echo e(__('Currency')); ?>

                            <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </label>

                        <div class="input-group">
                            <button type="submit" class="btn active-style save-form"><?php echo e(__('Save')); ?></button>
                        </div>
                    </div>

                </div>



            </h3>
        </div>
    </form>

    <div class="kt-portlet__body" style="padding-bottom:0 !important;">
        <ul style="margin-bottom:0 ;" class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
            <?php
            $index = 0 ;
            ?>
            <?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyUpper=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <li class="nav-item <?php if($index ==0 ): ?> active <?php endif; ?>">
                <a class="nav-link <?php if($index ==0 ): ?> active <?php endif; ?>" data-toggle="tab" href="#kt_apps_contacts_view_tab_main<?php echo e($index); ?>" role="tab">
                    <i class="flaticon2-checking icon-lg"></i>
                    <span style="font-size:18px !important;"><?php echo e($currency); ?></span>
                </a>
            </li>

            <?php
            $index++;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

<div class="tab-content  kt-margin-t-20">
    <?php
    $index = 0 ;
    ?>

    <?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="tab-pane  <?php if($index == 0): ?> active <?php endif; ?>" id="kt_apps_contacts_view_tab_main<?php echo e($index); ?>" role="tabpanel">
        <div class="kt-portlet">
            <div class="kt-portlet__head sky-border">
                <div class="kt-portlet__head-label">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Current Cash Position')); ?></h3>


                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">

                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info w-100">
                                    <h4 class="kt-widget24__title font-size text-uppercase d-flex justify-content-between align-items-center">
                                        <?php echo e(__('Cash & Banks' )  . ' [ ' . $currency . ' ]'); ?>

										
									
									
									
									
									
										<?php
											$currentModalId = 'safe';
										?>
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId.$currency); ?>"><?php echo e(__('Details')); ?></button>
										<?php echo $__env->make('admin.dashboard.details_cash_in_safe_modal',['detailItems'=> array_merge($details[$name]['cash_in_safe'] ?? [],$details[$name]['current_account'])  , 'modalId'=>$currentModalId ,'title'=>__('Cash  Details')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									
									
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                    <?php echo e(number_format($reports['cash_and_banks'][$currency] ?? 0 )); ?>

                                </span>
                            </div>

                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info w-100">
                                    <h4 class="kt-widget24__title font-size  text-uppercase d-flex justify-content-between align-items-center">
                                        <?php echo e(__('Time Deposit') . ' [ ' . $currency . ' ]'); ?>

										<?php
											$currentModalId = 'time_of_deposits_details';
										?>
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId.$currency); ?>"><?php echo e(__('Details')); ?></button>
										
										<?php echo $__env->make('admin.dashboard.details_modal',['detailItems'=>$details[$name]['time_of_deposits'] ?? [] , 'modalId'=>$currentModalId ,'title'=>__('Time Of Deposits Details')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										
										
										
										
                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning text-uppercase">
                                    <?php echo e(number_format($reports['time_deposits'][$currency] ?? 0 )); ?>

									
									
                                </span>
                            </div>
                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info w-100">
                                    <h4 class="kt-widget24__title font-size text-uppercase d-flex justify-content-between align-items-center">
                                        <?php echo e(__('Certificate Of Deposit') . ' [ ' . $currency . ' ] '); ?>

										<?php
											$currentModalId = 'certificate_of_deposits_details';
										?>
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId.$currency); ?>"><?php echo e(__('Details')); ?></button>
										
										<?php echo $__env->make('admin.dashboard.details_modal',['detailItems'=>$details[$name]['certificate_of_deposits'] ?? [] , 'modalId'=>$currentModalId ,'title'=>__('Certificate Of Deposits Details')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									
										
                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-danger text-uppercase">
                                    <?php echo e(number_format($reports['certificate_of_deposits'][$currency] ?? 0 )); ?>

                                </span>
                            </div>
                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Total')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success text-uppercase">
                                    <?php echo e(number_format($reports['total'][$currency] ?? 0 )); ?>

                                </span>
                            </div>
                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::New Users-->
                    </div>

                </div>
            </div>
        </div>
        <!--end:: Widgets/Stats-->


        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                <?php echo e(__('Short Term Cash Facilities Position')); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
		  <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
               
						   <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Total Cash Facilities')); ?> </h3>
                   
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Limit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Limit')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
                                    <?php echo e(number_format($totalCard[$currency]['limit'] ?? 0,0)); ?>

                                </span>
                            </div>


                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Outstanding')); ?>

                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning">
                                    <?php echo e(number_format($totalCard[$currency]['outstanding']??0,0)); ?>

                                </span>
                            </div>

                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Available')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-danger">
                                    <?php echo e(number_format($totalCard[$currency]['room']??0,0)); ?>

                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                     <?php echo e(__('Interest')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success">
                                   <?php echo e(number_format($totalCard[$currency]['interest_amount']??0,0)); ?>

                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>
                </div>
            </div>
        </div>
		
        
        <div class="row">

            
            <?php if($hasFullySecuredOverdraft[$currency]??false): ?>
            <div class="col-md-4">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Fully Secured Overdraft')); ?> </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Limit')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($fullySecuredOverdraftCardData[$currency]['limit'] ?? 0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Outstanding')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4> <?php echo e(number_format($fullySecuredOverdraftCardData[$currency]['outstanding']??0,0)); ?> </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Available')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($fullySecuredOverdraftCardData[$currency]['room']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Interest')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($fullySecuredOverdraftCardData[$currency]['interest_amount']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-toolbar w-full">
                            <ul class="w-full nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#FullySecuredOverdraftchartkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon-line-graph"></i> &nbsp; Charts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#FullySecuredOverdraftkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon2-checking"></i>Reports Table
                                    </a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.bank.statement',['company'=>$company->id,'accountType'=>'FullySecuredOverdraft','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Bank Statement Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.withdrawals.settlement.report',['company'=>$company->id,'accountType'=>'FullySecuredOverdraft','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Withdrawal Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body pt-0">
                        <select class="current-currency hidden">
                            <option value="<?php echo e($currency); ?>"></option>
                        </select>

                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tabpanel">

                                
                                <div class="row">
                                    <div class="col-md-4">

                                        <h4> <?php echo e(__('Available Room')); ?> </h4>
                                        <div id="FullySecuredOverdraftchartdiv_available_room_<?php echo e($currency); ?>" class="chartDiv"></div>
                                    </div>



                                    <div class="col-md-8 margin__left">

                                        <div class="row">
                                            <div class="col-12">
                                                <h4> <?php echo e(__('Bank Movement')); ?> </h4>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-financial-institution-id js-when-change-trigger-change-account-type data-currency="<?php echo e($currency); ?>" data-table="FullySecuredOverdraft" js-refresh-limits-chart class="form-control bank-id-js">
                                                    <?php $__currentLoopData = $allFullySecuredOverdraftBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($bank->id); ?>"> <?php echo e($bank->getName()); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 hidden">
                                                <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select class="form-control js-update-account-number-based-on-account-type">
                                                            <?php $__currentLoopData = $fullySecuredOverdraftAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option selected value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <select data-currency="<?php echo e($currency); ?>" data-table="FullySecuredOverdraft" js-refresh-limits-chart class="form-control js-account-number">

                                                </select>
                                            </div>

                                        </div>
                                        <div class="chartdiv_two_lines" id="FullySecuredOverdraftchartdiv_two_lines_<?php echo e($currency); ?>"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="FullySecuredOverdraftkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="kt-portlet kt-portlet--mobile">

                                        <div class="kt-portlet__body">

                                            <!--begin: Datatable -->
                                            <?php
                                               
                                                $availableRoomTotal = array_sum(array_column(($totalRoomForEachFullySecuredOverdraftId[$currency]??[]),'available_room'));$key=0;
                                                $limitTotal = array_sum(array_column(($totalRoomForEachFullySecuredOverdraftId[$currency]??[]),'limit'));$key=0;
                                                $endBalanceTotal = array_sum(array_column(($totalRoomForEachFullySecuredOverdraftId[$currency]??[]),'end_balance'));$key=0;
                                            ?>

                                             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_entries']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                <?php $__env->slot('table_header'); ?>
                                                <tr class="table-active text-center">
                                                    <th class="text-center max-w-300"><?php echo e(__('Bank Name')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Limit')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Outstanding')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Room')); ?></th>
                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                                <?php $__env->slot('table_body'); ?>


                                                <?php $__currentLoopData = $totalRoomForEachFullySecuredOverdraftId[$currency] ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>

                                                    <td class=" max-w-300"><?php echo e($item['item']?? '-'); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['limit']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['end_balance']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['available_room']??0)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <tr class="table-active text-center">
                                                    <td><?php echo e(__('Total')); ?></td>
                                                    <td><?php echo e(number_format($limitTotal)); ?></td>
                                                    <td><?php echo e(number_format($endBalanceTotal)); ?></td>
                                                    <td><?php echo e(number_format($availableRoomTotal)); ?></td>

                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            <!--end: Datatable -->
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="FullySecuredOverdrafttotal_available_room_<?php echo e($currency); ?>" data-total="<?php echo e(json_encode($totalRoomForEachFullySecuredOverdraftId[$currency] ?? [] )); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>
            








            
            <?php if($hasCleanOverdraft[$currency] ?? false ): ?>
            <div class="col-md-4">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Clean Overdraft')); ?> </h3>

                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Limit')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($cleanOverdraftCardData[$currency]['limit'] ?? 0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Outstanding')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4> <?php echo e(number_format($cleanOverdraftCardData[$currency]['outstanding']??0,0)); ?> </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Available')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($cleanOverdraftCardData[$currency]['room']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Interest')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($cleanOverdraftCardData[$currency]['interest_amount']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-toolbar w-full">
                            <ul class="w-full nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#CleanOverdraftkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon-line-graph"></i> &nbsp; Charts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#CleanOverdraftkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon2-checking"></i>Reports Table
                                    </a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.bank.statement',['company'=>$company->id,'accountType'=>'CleanOverdraft','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Bank Statement Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.withdrawals.settlement.report',['company'=>$company->id,'accountType'=>'CleanOverdraft','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Withdrawal Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body pt-0">
                        <select class="current-currency hidden">
                            <option value="<?php echo e($currency); ?>"></option>
                        </select>

                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="CleanOverdraftkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tabpanel">

                                
                                <div class="row">
                                    <div class="col-md-4">

                                        <h4> <?php echo e(__('Available Room')); ?> </h4>
                                        <div id="CleanOverdraftchartdiv_available_room_<?php echo e($currency); ?>" class="chartDiv"></div>
                                    </div>



                                    <div class="col-md-8 margin__left">

                                        <div class="row">
                                            <div class="col-12">
                                                <h4> <?php echo e(__('Bank Movement')); ?> </h4>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-financial-institution-id js-when-change-trigger-change-account-type data-currency="<?php echo e($currency); ?>" data-table="CleanOverdraft" js-refresh-limits-chart class="form-control bank-id-js">
                                                    <?php $__currentLoopData = $allCleanOverdraftBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($bank->id); ?>"> <?php echo e($bank->getName()); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 hidden">
                                                <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select class="form-control js-update-account-number-based-on-account-type">
                                                            <?php $__currentLoopData = $cleanOverdraftAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option selected value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <select data-currency="<?php echo e($currency); ?>" data-table="CleanOverdraft" js-refresh-limits-chart class="form-control js-account-number">

                                                </select>
                                            </div>

                                        </div>
                                        <div class="chartdiv_two_lines" id="CleanOverdraftchartdiv_two_lines_<?php echo e($currency); ?>"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="CleanOverdraftkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="kt-portlet kt-portlet--mobile">

                                        <div class="kt-portlet__body">

                                            <!--begin: Datatable -->
                                            <?php
                                               
                                                $availableRoomTotal = array_sum(array_column(($totalRoomForEachCleanOverdraftId[$currency]??[]),'available_room'));$key=0;
                                                $limitTotal = array_sum(array_column(($totalRoomForEachCleanOverdraftId[$currency]??[]),'limit'));$key=0;
                                                $endBalanceTotal = array_sum(array_column(($totalRoomForEachCleanOverdraftId[$currency]??[]),'end_balance'));$key=0;
                                            ?>

                                             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_entries']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                <?php $__env->slot('table_header'); ?>
                                                <tr class="table-active text-center">
                                                    <th class="text-center max-w-300"><?php echo e(__('Bank Name')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Limit')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Outstanding')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Room')); ?></th>
                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                                <?php $__env->slot('table_body'); ?>


                                                <?php $__currentLoopData = $totalRoomForEachCleanOverdraftId[$currency] ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>

                                                    <td class=" max-w-300"><?php echo e($item['item']?? '-'); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['limit']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['end_balance']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['available_room']??0)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <tr class="table-active text-center">
                                                    <td><?php echo e(__('Total')); ?></td>
                                                    <td><?php echo e(number_format($limitTotal)); ?></td>
                                                    <td><?php echo e(number_format($endBalanceTotal)); ?></td>
                                                    <td><?php echo e(number_format($availableRoomTotal)); ?></td>

                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            <!--end: Datatable -->
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="CleanOverdrafttotal_available_room_<?php echo e($currency); ?>" data-total="<?php echo e(json_encode($totalRoomForEachCleanOverdraftId[$currency] ?? [] )); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>
            







            
            <?php if($hasOverdraftAgainstCommercialPaper[$currency] ?? false ): ?>
            <div class="col-md-4">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label col-8">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Overdraft Against Commercial Paper')); ?> </h3>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Limit')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($overdraftAgainstCommercialPaperCardData[$currency]['limit'] ?? 0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Outstanding')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4> <?php echo e(number_format($overdraftAgainstCommercialPaperCardData[$currency]['outstanding']??0,0)); ?> </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Available')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($overdraftAgainstCommercialPaperCardData[$currency]['room']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                                    <div class="kt-portlet__body">
                                        <div class="kt-iconbox__body">
                                            <div class="kt-iconbox__desc">
                                                <h3 class="kt-iconbox__title">
                                                    <a class="kt-link" onclick="return false" href="#"><?php echo e(__('Interest')); ?></a>
                                                </h3>
                                                <div class="kt-iconbox__content text-primary  ">
                                                    <h4><?php echo e(number_format($overdraftAgainstCommercialPaperCardData[$currency]['interest_amount']??0,0)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-toolbar w-full">
                            <ul class="w-full nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#OverdraftAgainstCommercialPaperkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon-line-graph"></i> &nbsp; Charts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#OverdraftAgainstCommercialPaperkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tab">
                                        <i class="flaticon2-checking"></i>Reports Table
                                    </a>
                                </li>
                                <li class="nav-item ml-auto">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.bank.statement',['company'=>$company->id,'accountType'=>'OverdraftAgainstCommercialPaper','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Bank Statement Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="kt-portlet__head-label ">
                                        <div class="kt-align-right">
                                            <a href="<?php echo e(route('view.withdrawals.settlement.report',['company'=>$company->id,'accountType'=>'OverdraftAgainstCommercialPaper','currency'=>$currency])); ?>" type="button" class="btn btn-sm btn-brand btn-elevate btn-pill text-white"><i class="fa fa-chart-line"></i> <?php echo e(__('Withdrawal Report')); ?> </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body pt-0">
                        <select class="current-currency hidden">
                            <option value="<?php echo e($currency); ?>"></option>
                        </select>

                        <div class="tab-content  kt-margin-t-20">

                            <div class="tab-pane active" id="OverdraftAgainstCommercialPaperkt_apps_contacts_view_tab_1_<?php echo e($currency); ?>" role="tabpanel">

                                
                                <div class="row">
                                    <div class="col-md-4">

                                        <h4> <?php echo e(__('Available Room')); ?> </h4>
                                        <div id="OverdraftAgainstCommercialPaperchartdiv_available_room_<?php echo e($currency); ?>" class="chartDiv"></div>
                                    </div>



                                    <div class="col-md-8 margin__left">

                                        <div class="row">
                                            <div class="col-12">
                                                <h4> <?php echo e(__('Bank Movement')); ?> </h4>
                                            </div>
                                            <div class="col-md-9">
                                                <select data-financial-institution-id js-when-change-trigger-change-account-type data-currency="<?php echo e($currency); ?>" data-table="OverdraftAgainstCommercialPaper" js-refresh-limits-chart class="form-control bank-id-js">
                                                    <?php $__currentLoopData = $allOverdraftAgainstCommercialPaperBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($bank->id); ?>"> <?php echo e($bank->getName()); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 hidden">
                                                <label><?php echo e(__('Account Type')); ?> <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></label>
                                                <div class="kt-input-icon">
                                                    <div class="input-group date">
                                                        <select class="form-control js-update-account-number-based-on-account-type">
                                                            <?php $__currentLoopData = $overdraftAgainstCommercialPaperAccountTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $accountType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option selected value="<?php echo e($accountType->id); ?>" <?php if(isset($model) && $model->getCashInBankAccountTypeId() == $accountType->id): ?> selected <?php endif; ?>><?php echo e($accountType->getName()); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <select data-currency="<?php echo e($currency); ?>" data-table="OverdraftAgainstCommercialPaper" js-refresh-limits-chart class="form-control js-account-number">

                                                </select>
                                            </div>

                                        </div>
                                        <div class="chartdiv_two_lines" id="OverdraftAgainstCommercialPaperchartdiv_two_lines_<?php echo e($currency); ?>"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="OverdraftAgainstCommercialPaperkt_apps_contacts_view_tab_2_<?php echo e($currency); ?>" role="tabpanel">
                                <div class="col-md-12">
                                    <div class="kt-portlet kt-portlet--mobile">

                                        <div class="kt-portlet__body">

                                            <!--begin: Datatable -->
                                            <?php
                                               
                                                $availableRoomTotal = array_sum(array_column(($totalRoomForEachOverdraftAgainstCommercialPaperId[$currency]??[]),'available_room'));$key=0;
                                                $limitTotal = array_sum(array_column(($totalRoomForEachOverdraftAgainstCommercialPaperId[$currency]??[]),'limit'));$key=0;
                                                $endBalanceTotal = array_sum(array_column(($totalRoomForEachOverdraftAgainstCommercialPaperId[$currency]??[]),'end_balance'));$key=0;
                                            ?>

                                             <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['tableClass' => 'kt_table_with_no_pagination_no_scroll_no_entries']); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                                <?php $__env->slot('table_header'); ?>
                                                <tr class="table-active text-center">
                                                    <th class="text-center max-w-300"><?php echo e(__('Bank Name')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Limit')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Outstanding')); ?></th>
                                                    <th class="text-center "><?php echo e(__('Room')); ?></th>
                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                                <?php $__env->slot('table_body'); ?>


                                                <?php $__currentLoopData = $totalRoomForEachOverdraftAgainstCommercialPaperId[$currency] ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>

                                                    <td class=" max-w-300"><?php echo e($item['item']?? '-'); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['limit']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['end_balance']??0)); ?></td>
                                                    <td class="text-center"><?php echo e(number_format($item['available_room']??0)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <tr class="table-active text-center">
                                                    <td><?php echo e(__('Total')); ?></td>
                                                    <td><?php echo e(number_format($limitTotal)); ?></td>
                                                    <td><?php echo e(number_format($endBalanceTotal)); ?></td>
                                                    <td><?php echo e(number_format($availableRoomTotal)); ?></td>

                                                </tr>
                                                <?php $__env->endSlot(); ?>
                                             <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                                            <!--end: Datatable -->
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="OverdraftAgainstCommercialPapertotal_available_room_<?php echo e($currency); ?>" data-total="<?php echo e(json_encode($totalRoomForEachOverdraftAgainstCommercialPaperId[$currency] ?? [] )); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>
            









        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet ">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap">
                                <?php echo e(__('Long Term Cash Facilities Position')); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--begin:: Widgets/Stats-->
		<?php $__currentLoopData = $mediumTermLoansArr[$currency] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mediumTermLoan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        <?php echo e(__('Loans Position')); ?>

					[ 	<?php echo e($mediumTermLoan->getFinancialInstitutionName()); ?> ] 
					[ <?php echo e($mediumTermLoan->getName()); ?> ]
                    </h3>
                </div>
            </div>
			
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::Limit-->
						
				
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Limit')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-brand">
								<?php echo e($mediumTermLoan->getLimitFormatted()); ?>

                                </span>
                            </div>


                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Outstanding')); ?>

                                    </h4>
                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-warning">
                                    <?php echo e($mediumTermLoan->getEndBalanceForDate($date)); ?>

                                </span>
                            </div>

                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Next Due Amount')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-danger">
                                  -
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">

                        <!--begin::New Users-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title font-size">
                                        <?php echo e(__('Date')); ?>

                                    </h4>

                                </div>
                            </div>
                            <div class="kt-widget24__details">
                                <span class="kt-widget24__stats kt-font-success">
                                  -
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>
                </div>
            </div>
        </div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <!--end:: Widgets/Stats-->

        <!--begin:: Widgets/Stats-->
        

    </div>

    <?php
    $index++;
    ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>








<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/lib.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/jquery.input.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/vendors/general/jquery.repeater/src/repeater.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js')); ?>" type="text/javascript"></script>
<?php $__currentLoopData = ['FullySecuredOverdraft','CleanOverdraft','OverdraftAgainstCommercialPaper' ,'OverdraftAgainstAssignmentOfContract']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overdraftType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $selectedCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyUpper=>$currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("<?php echo e($overdraftType); ?>" + "chartdiv_available_room_" + "<?php echo e($currency); ?>", am4charts.PieChart);

        // Add data
        chart.data = $('#' + "<?php echo e($overdraftType); ?>" + 'total_available_room_' + "<?php echo e($currency); ?>").data('total');

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "available_room";
        pieSeries.dataFields.category = "item";
        pieSeries.innerRadius = am4core.percent(50);
        // arrow
        pieSeries.ticks.template.disabled = true;
        //number
        pieSeries.labels.template.disabled = true;

        var rgm = new am4core.RadialGradientModifier();
        rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
        pieSeries.slices.template.fillModifier = rgm;
        pieSeries.slices.template.strokeModifier = rgm;
        pieSeries.slices.template.strokeOpacity = 0.4;
        pieSeries.slices.template.strokeWidth = 0;
        // chart.legend = new am4charts.Legend();
        //        chart.legend.position = "right";
        //    chart.legend.scrollable = true;


    }); // end am4core.ready()

</script>


<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("<?php echo e($overdraftType); ?>chartdiv_two_lines_<?php echo e($currency); ?>", am4charts.XYChart);

        //

        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = [];

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        // Create series
        function createAxisAndSeries(field, name, opposite, bullet) {
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            if (chart.yAxes.indexOf(valueAxis) != 0) {
                valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            }

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            series.dataFields.dateX = "date";
            series.strokeWidth = 2;
            series.yAxis = valueAxis;
            series.name = name;
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            series.tensionX = 0.8;
            series.showOnInit = true;

            var interfaceColors = new am4core.InterfaceColorSet();

            switch (bullet) {
                case "triangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 12;
                    bullet.height = 12;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var triangle = bullet.createChild(am4core.Triangle);
                    triangle.stroke = interfaceColors.getFor("background");
                    triangle.strokeWidth = 2;
                    triangle.direction = "top";
                    triangle.width = 12;
                    triangle.height = 12;
                    break;
                case "rectangle":
                    var bullet = series.bullets.push(new am4charts.Bullet());
                    bullet.width = 10;
                    bullet.height = 10;
                    bullet.horizontalCenter = "middle";
                    bullet.verticalCenter = "middle";

                    var rectangle = bullet.createChild(am4core.Rectangle);
                    rectangle.stroke = interfaceColors.getFor("background");
                    rectangle.strokeWidth = 2;
                    rectangle.width = 10;
                    rectangle.height = 10;
                    break;
                default:
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.stroke = interfaceColors.getFor("background");
                    bullet.circle.strokeWidth = 2;
                    break;
            }

            valueAxis.renderer.line.strokeOpacity = 1;
            valueAxis.renderer.line.strokeWidth = 2;
            valueAxis.renderer.line.stroke = series.stroke;
            valueAxis.renderer.labels.template.fill = series.stroke;
            valueAxis.renderer.opposite = opposite;
        }

        createAxisAndSeries("debit", "<?php echo e(__('Cash In')); ?>", false, "circle");
        createAxisAndSeries("credit", "<?php echo e(__('Cash Out')); ?>", true, "triangle");
        createAxisAndSeries("end_balance", "<?php echo e(__('End Balance')); ?>", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()

</script>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<script>
    $(document).on('change', 'select[js-refresh-limits-chart]', function(e) {
        const modelName = $(this).attr('data-table');
        const currencyName = $(this).attr('data-currency')
        const bankId = $('.bank-id-js[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const accountNumber = $('.js-account-number[data-currency="' + currencyName + '"][data-table="' + modelName + '"]').val();
        const date = $('#js-date').val();
        const currentChartId = modelName + 'chartdiv_two_lines_' + currencyName
        if (!accountNumber) {
            return;
        }
        $.ajax({
            url: "<?php echo e(route('refresh.chart.limits.data',['company'=>$company->id])); ?>"
            , data: {
                modelName
                , currencyName
                , bankId
                , date
                , accountNumber
            }
            , type: "get"
            , success: function(res) {
                // update current chart

                am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = res.chart_date
            }
            , error: function(exception) {
                console.warn(exception)
            }
        })

    })

    $('select[js-refresh-limits-chart]').trigger('change')

</script>
<script src="/custom/money-receive.js"></script>



<!--end::Page Scripts -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/cash.blade.php ENDPATH**/ ?>