<?php
	use MathPHP\Statistics\Correlation ;
	use App\Helpers\HArr;
	use App\Helpers\HMath;
?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('dash_nav'); ?>
<style>
    .chartdiv_two_lines {
        width: 100%;
        height: 400px;
    }

    .chartDiv {
        max-height: 400px !important;
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

    <form action="<?php echo e(route('view.expense.analysis.dashboard',['company'=>$company->id])); ?>" class="kt-portlet__head w-full sky-border" style="">
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
                        <div class="d-flex  align-items-center mt-4">
                            <label class="label text-nowrap mr-2"> <?php echo e(__('End Date')); ?>

                                <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input id="js-start-date" type="date" value="<?php echo e(isset($startDate) ? $startDate: date('Y-m-d')); ?>" name="start_date" class="form-control" placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
					
					  <div class="col-md-2">
                        <div class="d-flex  align-items-center mt-4">
                            <label class="label text-nowrap mr-2"> <?php echo e(__('End Date')); ?>

                                <?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </label>
                            <div class="kt-input-icon">
                                <div class="input-group date">
                                    <input id="js-end-date" type="date" value="<?php echo e(isset($endDate) ? $endDate: date('Y-m-d')); ?>" name="end_date" class="form-control" placeholder="Select date" id="kt_datepicker_2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
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
            

            <li class="nav-item 
			 active 
			
			
			">
                <a class="nav-link 
				 active 
				
				
				" data-toggle="tab" href="#kt_apps_contacts_view_tab_main"  role="tab">
                    <i class="flaticon2-checking icon-lg"></i>
                    <span style="font-size:18px !important;">
                        
                        <?php echo e(__('Expense Analysis')); ?>

                    </span>
                </a>
            </li>

            
        </ul>
    </div>
</div>

<div class="tab-content  kt-margin-t-20">
    <?php
    $index = 0 ;
    ?>

    

    <div class="tab-pane  
	 active 
	
	
	"  id="kt_apps_contacts_view_tab_main" role="tabpanel">
	
	
	<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
		 <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Expenses Results')); ?></h3>
           
        </div>
    </div>
    <div class="kt-portlet__body  kt-portlet__body--fit">
        <div class="row row-no-padding row-col-separator-xl">
            
           
            
            <div class="col-md-3 ">

                <!--begin::New Orders-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            
                            <h4 class="kt-widget24__title font-size">


                                <?php echo e(__('Current Month')); ?> :
                                <?php echo e(\Carbon\Carbon::make($endDate)->format('M - Y')); ?>

                                
                                

                            </h4>

                            

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-danger">
                            <?php echo e(number_format($currentMonthExpenses)); ?>

                        </span>
                    </div>

                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-danger" role="progressbar" style="width: <?php echo e($percentage); ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">
                            <?php echo e(__('Change')); ?>

                        </span>
                        <span class="kt-widget24__number">
                            
                            
                            <?php echo e(number_format($percentage , 2)); ?> %
                        </span>
                    </div>
                </div>

                <!--end::New Orders-->
            </div>
			
            <div class="col-md-3">

                <!--begin::New Feedbacks-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Previous Month')); ?> : ( <?php echo e(\Carbon\Carbon::make($endDate)->startOfMonth()->subMonth(1)->format('M')); ?> ) (<?php echo e($yearOfEndDate ?? ''); ?>)
                            </h4>
                            
                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-warning">
                            <span class="text-red"></span>
                            <?php echo e(number_format($previousMonthExpenses)); ?>

                            
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">

                        </span>
                        <span class="kt-widget24__number">

                        </span>
                    </div>
                </div>

                <!--end::New Feedbacks-->
            </div>
          
            
            <div class="col-md-3 ">

                <!--begin::Total Profit-->
                <div class="kt-widget24 text-center">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">

                            
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Previous 3 Months')); ?> : ( <?php echo e(\Carbon\Carbon::make($endDate)->startOfMonth()->subMonth(3)->format('M') 
                                    . ' - ' . \Carbon\Carbon::make($endDate)->startOfMonth()->subMonth(2)->format('M') . ' - ' .
                                     \Carbon\Carbon::make($endDate)->startOfMonth()->subMonth(1)->format('M')); ?> )

                                (<?php echo e($yearOfEndDate); ?>)

                            </h4>
                            

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-brand">
                            
                        
                        <?php echo e(number_format($perviousThreeMonthsExpenses)); ?>

                        </span>
                    </div>

                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">
                        <span class="kt-widget24__change">

                        </span>
                        <span class="kt-widget24__number">

                        </span>
                    </div>
                </div>

                <!--end::Total Profit-->
            </div>
			
			  
            <div class="col-md-3">

                <!--begin::New Users-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title font-size">
                                <?php echo e(__('Year To Date Expenses')); ?>

                                (<?php echo e($yearOfEndDate); ?>)
					
                            </h4>

                        </div>
                    </div>
                    <div class="kt-widget24__details">
                        <span class="kt-widget24__stats kt-font-success">
                            <?php echo e(number_format($expensesToDate)); ?>

							<?php if($totalSales): ?>
								 [ 
									
										<?php echo e(number_format($expensesToDate / $totalSales * 100,2) . ' % / Rev'); ?>

								 ]
										<?php endif; ?>
                            
                            
                        </span>
                    </div>
                    <div class="progress progress--sm">
                        <div class="progress-bar kt-bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="kt-widget24__action">

                    </div>
                </div>

                <!--end::New Users-->
            </div>
			
            
        </div>
    </div>
</div>













        <div class="kt-portlet">
            <div class="kt-portlet__head sky-border">
                <div class="kt-portlet__head-label">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Year To Date Expense Breakdown')); ?></h3>
                </div>
            </div>
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-xl">

					<?php
						$mainCategoriesNames = [];
							$subItemNames= [];
							$expensesMonthlyTotals = [];
							$fixedVariableExpenseCoefficientCorrelations = [];
					?>

                    <?php $__currentLoopData = $result['report_data']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $subItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$subItems =  HArr::sortBySumOfKeyWithoutPreservingOriginalArray($subItems,'Avg. Prices') ;
						
						
					?>
				
					<?php if($name == 'Growth Rate %'): ?>
						<?php continue; ?>
					<?php endif; ?> 
					
					<?php
						$currentModalId = convertStringToClass($name);
					
						$cardTotal = array_sum($subItems['Total'] ?? []) ;
					
						if($name != 'Total'){
						foreach($subItems as $subItemName => $subItemValueArr)
						{
							$chartData['pie'][$name][] = ['name'=>$subItemName , 'value'=>number_format(array_sum($subItemValueArr['Avg. Prices'] ?? []))];
						
						
								if($subItemName != 'Total'  && $subItemName != 'Growth Rate %'){
								$subItemNames[$name][]=$subItemName;
									
								}
								$currentLoopItems = $subItemValueArr['Avg. Prices']??[] ;
								$currentLoopItems = $subItemValueArr['Avg. Prices']??[] ;
								if(count($currentLoopItems) != count(array_keys($monthlySalesForSalesGathering))){
									$currentLoopItems = HArr::fillMissingKeyInOneDimArrWith($currentLoopItems,array_keys($monthlySalesForSalesGathering));
								}
								
									if(array_sum($currentLoopItems) && array_sum($monthlySalesForSalesGathering) && $subItemName !='Total' && $subItemName != 'Growth Rate %'){

$fixedVariableExpenseCoefficientCorrelations[$name][$subItemName] = 0;
								    try{
								    	$fixedVariableExpenseCoefficientCorrelations[$name][$subItemName]  = Correlation::r($currentLoopItems, $monthlySalesForSalesGathering);
								    }
								    catch(\Exception $e){
								  
								    }									
									
									
									}elseif($subItemName !='Total' && $subItemName != 'Growth Rate %'){
										$fixedVariableExpenseCoefficientCorrelations[$name][$subItemName] = 0;
									}
								
								if($subItemName == 'Total'){
									$currentLoopItems = $subItemValueArr;
								}
							
							
						
								foreach( $currentLoopItems?? [] as $d => $v){
									
										if($subItemName !='Total' && $subItemName != 'Growth Rate %'){
										$expensesMonthlyTotals[$d] = isset($expensesMonthlyTotals[$d]) ? $expensesMonthlyTotals[$d] + $v : $v; 
										}
									$currentSalesValue = $monthlySalesForSalesGathering[$d]??0;
									$currentGrowthRate = $result['report_data'][$name][$subItemName]['Growth Rate %'][$d]??0 ;
									if($subItemName =='Total' ){
										$currentGrowthRate =$result['report_data'][$name]['Growth Rate %'][$d]??0;
									}
									$chartData['three_lines'][$name][$subItemName][] =[
										'date'=>formatDateForChart($d) ,
										'monthly_expense_value'=>number_format($v)
										,'growth_rate'=> number_format($currentGrowthRate,2),
										'revenue_percentage'=>$currentSalesValue ? number_format($v /$currentSalesValue   * 100,2) : 0
										];
								}
							
							
						}	
						}
					
							$currentLoopItems = $name == 'Total' ? $subItems : array_get($subItems,'Total') ;
						foreach($currentLoopItems as $currentDate => $currentValue){
								$currentSalesValue = $monthlySalesForSalesGathering[$currentDate]??0;
								$currentGrowthRate = $result['report_data']['Growth Rate %'][$currentDate] ?? 0 ;
								$chartData['three_lines']['general'][$name][] =['date'=> formatDateForChart($currentDate) , 'monthly_expense_value'=>number_format($currentValue),
								'revenue_percentage'=>$currentSalesValue ? number_format($currentValue /$currentSalesValue   * 100,2) : 0
								 , 'growth_rate'=>number_format($currentGrowthRate,2)  ];
							}
						if($name != 'Total' && $name != 'Growth Rate %'){
							$chartData['pie']['general'][] = ['name'=>$name , 'value'=>number_format($cardTotal)] ;
							$mainCategoriesNames[] =$name; 
							
						}
					?>
					<?php if($name !='Total'): ?>
                    <div class="col-md-6 col-lg-3 col-xl-3">
                        <!--begin::Total Profit-->
                        <div class="kt-widget24 text-center">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info w-100">
                                    <h4 class="kt-widget24__title font-size text-uppercase d-flex justify-content-between align-items-center">
                                        <?php echo e($name); ?>

                                        <?php
                                        // $currentModalId = 'cost_of_sales';
                                        ?>
										<?php if($name !='Total'): ?>
                                        <button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" data-toggle="modal" data-target="#<?php echo e($currentModalId); ?>"><?php echo e(__('Details')); ?></button>
										<?php endif; ?>
										
                                        <?php echo $__env->make('admin.dashboard.expense_modal',['detailItems'=> $subItems ,'cardTotal'=>$cardTotal , 'modalId'=>$currentModalId ,'title'=>$name], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </h4>

                                </div>
                            </div>
							
							
                            <div class="kt-widget24__details">
								<?php
									$currentExpenseTotal = 0 ;
								?>
                                <span class="kt-widget24__stats kt-font-brand text-left">
									
									<?php
										$currentExpenseTotal = $cardTotal
									?>
                                    <?php echo e(number_format($currentExpenseTotal)); ?>

							
									<?php if($totalSales): ?>
									<br>
									<br>
									<span class="text-green">[<?php echo e(number_format($currentExpenseTotal / $totalSales * 100,2) . ' % / Rev'); ?>]</span>
									<?php endif; ?> 
                                </span>
                            </div>

                            <div class="progress progress--sm">
                                <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>

                        <!--end::Total Profit-->
                    </div>
					<?php endif; ?> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                </div>
            </div>
        </div>
		
		  <div class="kt-portlet">
            <div class="kt-portlet__head sky-border">
                <div class="kt-portlet__head-label">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e(__('Auto calculated Sales Breakeven Value = ' . number_format(HMath::calculateBreakevenPoint($monthlySalesForSalesGathering,$expensesMonthlyTotals)) )); ?></h3>
                </div>
            </div>
            </div>
			
		
        <!--end:: Widgets/Stats-->

        


        
            



<div class="row">



  
    
  

    
    <div class="col-md-12">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar w-full">
                    <ul class="w-full nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tab">
                                <i class="flaticon-line-graph"></i> &nbsp; <?php echo e(__('Charts')); ?>

                            </a>
                        </li>
                        
                        <li class="nav-item ml-auto">
                            <div class="kt-portlet__head-label ">
                                <div class="kt-align-right">
									<form   target="_blank"  method="post" action="<?php echo e(route('one.selector.expense.report.result',['company'=>$company->id])); ?>">
										<?php echo csrf_field(); ?>
										<input type="hidden" name="data_type" value="value">
										<input type="hidden" name="report_type" value="trend">
										<input type="hidden" name="interval" value="monthly">
										<input type="hidden" name="table_name" value="expense_analysis">
										<input type="hidden" name="firstColumnName" value="category_name">
										<input type="hidden" name="type" value="category_name">
										<input type="hidden" name="reportSelectorType" value="one_selector">
										<?php $__currentLoopData = $mainCategoriesNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<input type="hidden" name="firstColumnData[]" value="<?php echo e($categoryName); ?>">
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<input type="hidden" name="start_date" value="<?php echo e($startDate); ?>">
										<input type="hidden" name="end_date" value="<?php echo e($endDate); ?>">
										<button class="btn btn-sm btn-brand btn-elevate btn-pill text-white" type="submit"><?php echo e(__('Expense Category Trend Report')); ?></button>
									</form>
                                </div>
                            </div>
                        </li>

                        

                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body pt-0">
                <select class="current-currency hidden">
                    
                </select>

                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">

                        
                        <div class="row">
                            <div class="col-md-4">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" > <?php echo e(__('Category Breakdown')); ?> </h3>

                                
                                <div id="pie-chart-general-id" class="chartDiv"></div>
								<input type="hidden" id="pie-chart-general-data-id" data-chart-data="<?php echo e(json_encode($chartData['pie']['general']??[])); ?>">
                            </div>



                            <div class="col-md-8 margin__left">

                                <div class="row mb-3 ml-4">
                                    <div class="col-12">
									 <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" > <?php echo e(__('Monthly Expense Trend')); ?> </h3>
                                    </div>
                                    <div class="col-md-6 ">
                                        <select  js-refresh-three-line-chart class="form-control" data-type="general" id="general-three-line-chart-select">
                                            <option value="Total"> <?php echo e('All'); ?> </option>
                                            <?php $__currentLoopData = $mainCategoriesNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($mainCategoryName); ?>"> <?php echo e($mainCategoryName); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>



                                </div>
								
                                <div class="chartdiv_two_lines" id="three-line-chart-general-id"></div>
								
								<?php $__currentLoopData = $chartData['three_lines']['general']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $currentChartData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					
								<input type="hidden" class="three-line-chart-general-data-class"  data-chart-name="<?php echo e($chartName); ?>"  data-chart-data="<?php echo e(json_encode($currentChartData)); ?>">
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                    </div>

                    
                </div>
            </div>
        </div>

    </div>
    
    
	

    
   <?php $__currentLoopData = $mainCategoriesNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategoriesName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 " >
        <div class="kt-portlet " style="height:97% ">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label col-8">
                    <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" style=""> <?php echo e($mainCategoriesName . ' ' . __('Category')); ?> </h3>
                </div>

            </div>
            <div class="kt-portlet__body">
                <div class="row">
					<div class="col-md-12">

						<?php echo $__env->make('admin.dashboard.avg_min_max_dashboard_table',[
							'avg'=>$avgMinMaxOutliers[$mainCategoriesName.' - '.$mainCategoriesName]['Average Value']??0 ,
							'min'=>$avgMinMaxOutliers[$mainCategoriesName.' - '.$mainCategoriesName]['Min Value']['value']??0,
							'max'=>$avgMinMaxOutliers[$mainCategoriesName.' - '.$mainCategoriesName]['Max Value']['value']??0,
							'fixedVariableExpenseCoefficientCorrelations'=>$fixedVariableExpenseCoefficientCorrelations[$mainCategoriesName]??[]
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                            <a class="nav-link active" data-toggle="tab" href="#FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tab">
                                <i class="flaticon-line-graph"></i> &nbsp; <?php echo e(__('Charts')); ?>

                            </a>
                        </li>
                        
					
                        <li class="nav-item ml-auto">
                            <div class="kt-portlet__head-label ">
                                <div class="kt-align-right">
									<form target="_blank" method="post" action="<?php echo e(route('result.expense.against.report',['company'=>$company->id])); ?>">
										<?php echo csrf_field(); ?>
										<input type="hidden" name="type" value="expense_name"  >
										<input type="hidden" name="data_type" value="value"  >
										<input type="hidden" name="report_type" value="trend"  >
										<input type="hidden" name="start_date" value="<?php echo e($startDate); ?>"  >
										<input type="hidden" name="end_date" value="<?php echo e($endDate); ?>"  >
										<input type="hidden" name="interval" value="monthly"  >
										<input type="hidden" name="tableName" value="expense_analysis"  >
										<input type="hidden" name="firstColumnName" value="category_name"  >
										<input type="hidden" name="secondColumnName" value="sub_category_name"  >
										<input type="hidden" name="thirdColumnName" value="expense_name"  >
										<input type="hidden" name="reportSelectorType" value="three_selector"  >
										<input type="hidden" name="firstColumnData[]" value="<?php echo e($mainCategoriesName); ?>"  >
										<?php $__currentLoopData = $subItemNames[$mainCategoriesName]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<input type="hidden" name="thirdColumnData[]" value="<?php echo e($subItemName); ?>"  >
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
										
										
										
										<button type="submit" class="btn btn-sm btn-brand btn-elevate btn-pill text-white" ><?php echo e(__('Expense Trend Report')); ?></button>
									</form>
                                    
                                </div>
                            </div>
                        </li>

                        

                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body pt-0">
                <select class="current-currency hidden">
                    
                </select>

                <div class="tab-content  kt-margin-t-20">

                    <div class="tab-pane active" id="FullySecuredOverdraftchartkt_apps_contacts_view_tab_1" role="tabpanel">

                        
                        <div class="row">
                            <div class="col-md-4">
				<h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" > <?php echo e(__('Expense Item Breakdown')); ?> </h3>
                          
								<div id="<?php echo e('pie-chart-'.convertStringToClass($mainCategoriesName).'-id'); ?>" class="chartDiv"></div>
								<input type="hidden" id="<?php echo e('pie-chart-'.convertStringToClass($mainCategoriesName).'-data-id'); ?>" data-chart-data="<?php echo e(json_encode($chartData['pie'][$mainCategoriesName]??[])); ?>">
										
								
                            </div>



						  
                            <div class="col-md-8 margin__left">
                                <div class="row mb-3 ml-4">
                                    <div class="col-12">
									 <h3 class="font-weight-bold text-black form-label kt-subheader__title small-caps mr-5 text-primary text-nowrap" > <?php echo e(__('Monthly Expense Trend')); ?> </h3>
                                    </div>
                                    <div class="col-md-6 ">
                                        <select  js-refresh-three-line-chart class="form-control" data-type="<?php echo e(convertStringToClass($mainCategoriesName)); ?>" id="<?php echo e(convertStringToClass($mainCategoriesName)); ?>-three-line-chart-select">
                                            <option value="Total"> <?php echo e('All'); ?> </option>
                                            <?php $__currentLoopData = $subItemNames[$mainCategoriesName]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subItemName); ?>"> <?php echo e($subItemName); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>



                                </div>
                                <div class="chartdiv_two_lines" id="three-line-chart-<?php echo e(convertStringToClass($mainCategoriesName)); ?>-id"></div>
								
								<?php $__currentLoopData = $chartData['three_lines'][$mainCategoriesName]??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartName => $currentChartData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<input type="hidden" class="three-line-chart-<?php echo e(convertStringToClass($mainCategoriesName)); ?>-data-class"   data-chart-name="<?php echo e($chartName); ?>" data-chart-data="<?php echo e(json_encode($currentChartData)); ?>">
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
							
                        </div>

                    </div>

                    
                </div>
            </div>
        </div>

    </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    


</div>

<!--end:: Widgets/Stats-->


</div>


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

<script>
 am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-general-id", am4charts.PieChart);

        // Add data
        chart.data = $('#pie-chart-general-data-id').data('chart-data');
	
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "name";
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
         chart.legend = new am4charts.Legend();
                chart.legend.position = "bottom";
            chart.legend.scrollable = true;


    }); 
	
	
	//three lines chart
	
	
	  am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("three-line-chart-general-id", am4charts.XYChart);
		var data = [];
        //
        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = data;

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

        createAxisAndSeries("monthly_expense_value", "<?php echo e(__('Monthly Expense Value')); ?>", false, "circle");
        createAxisAndSeries("growth_rate", "<?php echo e(__('Growth Rate %')); ?>", true, "triangle");
         createAxisAndSeries("revenue_percentage", "<?php echo e(__('Revenue %')); ?>", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()
	

</script>


<?php $__currentLoopData = $chartData['pie']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pieChartName => $pieChartValueArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($pieChartName == 'general'): ?>

<?php continue; ?>
<?php endif; ?> 
<?php
	$pieChartNameAsClass = convertStringToClass($pieChartName);
	$pieChartId = "pie-chart-".$pieChartNameAsClass."-id";
	$pieChartDataId = "pie-chart-".$pieChartNameAsClass."-data-id";
?>
<script>
 am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("<?php echo e($pieChartId); ?>", am4charts.PieChart);

        // Add data
        chart.data = $('#<?php echo e($pieChartDataId); ?>').data('chart-data');
	
        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "value";
        pieSeries.dataFields.category = "name";
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
         //chart.legend = new am4charts.Legend();
          //      chart.legend.position = "right";
          //  chart.legend.scrollable = true;


    }); 
	

</script>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 













<?php $__currentLoopData = $chartData['three_lines']??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $threeLineChartName => $pieChartValueArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($threeLineChartName == 'general'): ?>

<?php continue; ?>
<?php endif; ?> 
<?php
	$threeLineChartNameAsClass = convertStringToClass($threeLineChartName);
	$threeLineChartId = "three-line-chart-".$threeLineChartNameAsClass."-id";

	//$pieChartDataId = "three-line-chart-".$threeLineChartNameAsClass."-data-id";
?>
<script>
	
	  am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("<?php echo e($threeLineChartId); ?>", am4charts.XYChart);
		var data = [];
        //
        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = data;

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

        createAxisAndSeries("monthly_expense_value", "<?php echo e(__('Monthly Expense Value')); ?>", false, "circle");
        createAxisAndSeries("growth_rate", "<?php echo e(__('Growth Rate %')); ?>", true, "triangle");
    	 createAxisAndSeries("revenue_percentage", "<?php echo e(__('Revenue %')); ?>", true, "rectangle");

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();



    }); // end am4core.ready()

</script>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 








<script>
    $(document).on('change', 'select[js-refresh-three-line-chart]', function(e) {
		let chartName = $(this).val();
		let chartType = $(this).attr('data-type');
		let chartDataArr = $('.three-line-chart-'+chartType+'-data-class[data-chart-name="'+chartName+'"]').attr('data-chart-data')
		let currentChartId = 'three-line-chart-'+chartType+'-id';
		if(chartDataArr){
			chartDataArr = JSON.parse(chartDataArr);
		}else{
			chartDataArr = {};
		}
	
		console.log('ddd',chartDataArr);
 		  am4core.registry.baseSprites.find(c => c.htmlContainer.id === currentChartId).data = chartDataArr		
    })



</script>
<script>
$(function(){
	    $('select[js-refresh-three-line-chart]').trigger('change')
})
</script>



<!--end::Page Scripts -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/admin/dashboard/expense.blade.php ENDPATH**/ ?>