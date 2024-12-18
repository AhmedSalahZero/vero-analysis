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
                    <?php $section_key = 0;?>
                    <?php $__currentLoopData = $section->subSections->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             
                        <?php if($section != 'SalesBreakdownAnalysis'): ?>

                            <?php $name = $subSection->name['en'] ;
                            if ($subSection->name['en'] == "Products / Services") {
                                $name = "Product Or Service Name";
                            }   ?>
                        <?php endif; ?>
                       
                        <?php if(($section->name['en'] == 'Sales Breakdown Analysis Report' && $subSection->name['en'] !== "Customers Nature" && $subSection->name['en'] !== "Service Providers" && $subSection->name['en'] !== 'Sales Discounts') ||
                        ($subSection->name['en'] == "Customers Nature" && (false !== $found =  array_search('Customer Name',$viewing_names))) ||
                            ($subSection->name['en'] == "Service Providers" && ( @count(array_intersect(['Service Provider Type','Service Provider Name','Service Provider Birth Year'],$viewing_names)) > 0 ) ||
                            ($subSection->name['en'] == 'Sales Discounts' && (count(array_intersect(['Quantity Discount','Cash Discount','Special Discount'],$viewing_names)) > 0) )) || 
                            ($subSection->name['en'] == INVOICES && (count(array_intersect(['Document Type','Document Number'],$viewing_names)) > 0) )
                        ||(false !== $found = array_search(\Str::singular($name),       $viewing_names) || $subSection->name['en'] == "Average Prices" )): ?>
								<?php if($user->canViewReport(generateReportName($subSection->name['en'])) || $subSection->name['en']=='One Dimension'||$subSection->name['en']=='Two Dimension' ||$subSection->name['en']=='Interval Comparing'  ): ?>
                                <li class="nav-item">

                                    <a class="nav-link <?php echo e($section_key == 0 ? 'active' : ''); ?>" onclick="return false" data-toggle="tab" href="#kt_widget2_tab1_content_<?php echo e($subSection->id); ?>" role="tab">
                                        <i
                                        class="kt-menu__ver-arrow <?php echo e($subSection->icon); ?>"></i><span class="kt-menu__link-text">
                                            <?php echo e(__($subSection->name[lang()])); ?>

											
                                            </span>


                                    </a>
                                </li>
								<?php endif; ?> 
                           <?php $section_key++; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
                <?php $section_key = 0;?>
				
                <?php $__currentLoopData = $section->subSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $mainSubSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             
                
                    <?php if($section != 'SalesBreakdownAnalysis'): ?>


                        <?php $name = $mainSubSection->name['en'] ;

                        if ($mainSubSection->name['en'] == "Products / Services") {
                            $name = "Product Or Service Name";
                        }   ?>
                    <?php endif; ?>
                    <?php if($section->name['en'] == 'Sales Breakdown Analysis Report' ||  (false !== $found =  array_search(\Str::singular($name),$viewing_names) || $mainSubSection->name['en'] == "Average Prices" )
                    || $mainSubSection->name['en'] == 'Invoices'
                    
                    ): ?>
                        

                     
                        <div class="tab-pane <?php echo e($section_key == 0 ? 'active' : ''); ?>" id="kt_widget2_tab1_content_<?php echo e($mainSubSection->id); ?>">
                            <div class="kt-widget2">
                                <div class="row">
								
                                    <?php $__currentLoopData = $mainSubSection->subSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $name_of_section = substr($sub_section->name['en'], strpos($sub_section->name['en'] , "Against")+8 ); ?> 
                                                <?php if($name_of_section == 'Products'): ?>
                                                <?php
                                                    $name_of_section ='Products / Services';
                                                ?>
                                                <?php endif; ?> 
                                        <?php if($section->name['en'] !== 'Sales Breakdown Analysis Report' && $mainSubSection->name['en'] !== "Average Prices" ): ?>
										
                                            <?php if($name_of_section == "Products / Services"): ?>
                                                <?php  $name_of_section = "Product Or Service Names" ?>
                                            <?php elseif($name_of_section == "Products Items"): ?>
                                                <?php  $name_of_section = "Product Items" ?>
                                            <?php endif; ?>
											
											
											

                                            <?php if(
												$sub_section->id == 337||
												$sub_section->id == 338||
												$sub_section->id == 339||
												$sub_section->id == 340||
												$sub_section->id == 343||
												
												 ( false !== $found =  array_search(\Str::singular($name_of_section),$viewing_names)) || 
                                            


                                              str_contains($name_of_section,"es Analysis") 
                                            //   ||   
                                            //   str_contains($name_of_section,"s")  

                                             ||
                                            str_contains($name_of_section,"Sales Analysis")
                                            // ||str_contains($name_of_section,"Sales Breakdown") 
                                            ||(str_contains($name_of_section,"zones") && isset($exportables['zone']))
                                            ||(
                                                str_contains($name_of_section,"Customers")
                                             && (isset($exportables['customer_name']) || isset($exportables['customer_code']))
                                            )
                                            ||
                                             ($name_of_section == 'Sales Discounts' && (count(array_intersect(['Quantity Discount','Cash Discount','Special Discount','zones'],$viewing_names)) > 0) ) ): ?>
                                                <div class="col-md-4">
                                                    <div class="kt-widget2__item kt-widget2__item--primary">
                                                        <div class="kt-widget2__checkbox">
                                                        </div>
                                                        <?php 
                                                            $route = isset($sub_section->route) && $sub_section->route !== null ? explode('.', $sub_section->route) : null;
                                                        ?> 
														
                                                        <div class="kt-widget2__info">
                                                            <a href="<?php echo e(route(@$sub_section->route, $company)); ?>" class="kt-widget2__title">
																<?php echo e(__($sub_section->name[lang()])); ?>

																
                                                            </a>

                                                        </div>
                                                        <div class="kt-widget2__actions">

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif($mainSubSection->name['en'] == "Average Prices" ): ?>
                                            <?php $name_of_section = substr($sub_section->name['en'], strpos($sub_section->name['en'] , "Average Prices Per ")+19  );
                                            ?> 
                                            <?php if(false !== $found =  array_search(\Str::singular($name_of_section),$viewing_names) ): ?>
												<?php if($user->canViewReport($sub_section->name['en'])): ?>
                                                <div class="col-md-4">
                                                    <div class="kt-widget2__item kt-widget2__item--primary">
                                                        <div class="kt-widget2__checkbox">
                                                        </div>
                                                        <?php
                                                            $route = isset($sub_section->route) && $sub_section->route !== null ? explode('.', $sub_section->route) : null;
                                                        ?> 
                                                        <div class="kt-widget2__info">
                                                            <a href="<?php echo e(route(@$sub_section->route, $company)); ?>" class="kt-widget2__title">
                                                                <?php echo e(__($sub_section->name[lang()])); ?>

                                                            </a>

                                                        </div>
                                                        <div class="kt-widget2__actions">

                                                        </div>
                                                    </div>
                                                </div>
												<?php endif; ?> 
                                            <?php endif; ?>
                                        <?php elseif( $section->name['en'] == 'Sales Breakdown Analysis Report'): ?>

                                                <?php if($mainSubSection->name['en'] !== "Customers Nature" ||
                                                ($mainSubSection->name['en'] == "Customers Nature" && false !== $found =  array_search('Customer Name',$viewing_names)) ||
                                                ($mainSubSection->name['en'] == "Service Providers"  && (count(array_intersect(['Service Provider Type','Service Provider Name','Service Provider Birth Year'],$viewing_names)) >0))  ): ?>
                                                    <?php if($mainSubSection->name['en'] == 'One Dimension'): ?>
                                                        <?php $name_of_section = str_replace( " Sales Breakdown Analysis",'',  $sub_section->name['en']     );?>
                                                    <?php elseif($mainSubSection->name['en'] == 'Sales Discounts'): ?>

                                                        <?php $name_of_section = str_replace( " Versus Discounts",'',  $sub_section->name['en']     );?>
                                                    <?php elseif($mainSubSection->name['en'] == 'Customers Nature'): ?>

                                                        <?php $name_of_section = str_replace( " Versus Customers Natures Analysis",'',  $sub_section->name['en']     );?>
                                                    <?php elseif($mainSubSection->name['en'] == 'Interval Comparing'): ?>
                                                        <?php $name_of_section = str_replace( " Sales Interval Comparing Analysis",'',  $sub_section->name['en'] );?>

                                                        <?php if($name_of_section == "Service Provider"): ?>
                                                            <?php  $name_of_section = "Service Provider Name" ?>
                                                        <?php elseif($name_of_section == "Service Provider Age Range"): ?>
                                                            <?php  $name_of_section = "Service Provider Birth Year";  ?>

                                                        <?php endif; ?>


                                                    <?php elseif($mainSubSection->name['en'] == 'Two Dimension'): ?>
                                                        <?php
                                                            $name_of_section = substr($sub_section->name['en'], strpos($sub_section->name['en'] , "Versus ")+7  );
                                                            
                                                            $name_of_second_section = substr($sub_section->name['en'], strpos($sub_section->name['en'] , " Versus ")   );
                                                            $name_of_first_section = str_replace( $name_of_second_section,'',  $sub_section->name['en']     );

                                                         if($name_of_section == "Products Items"){
                                              				   $name_of_section = "Product Items" ;

                                                  	       }
														if($name_of_section === 'Products Items Ranking'){
															$name_of_section = "Product Items"; 
														}
														if($name_of_section === 'Products Ranking'){
															$name_of_section = "Product"; 
														}
													 

                                                        ?>
 
                                                    <?php endif; ?>
                                                    <?php if($name_of_section == "Products / Services" ): ?>
                                                        <?php $name_of_section = "Product Or Service Names"; ?> 
                                                    <?php endif; ?>
                                                    
                                                    <?php if(isset($name_of_first_section) && $name_of_first_section == "Products / Services" ): ?>
                                                        <?php $name_of_first_section = "Product Or Service Names"; ?> 
                                                    <?php endif; ?>

                                                    <?php if(isset($name_of_first_section) && $name_of_first_section == "Products / Services" ): ?>
                                                        <?php $name_of_first_section = "Branch"; ?> 
                                                    <?php endif; ?>

                                                    <?php if($name_of_section == "Product Items Ranking" ): ?>
                                                        <?php $name_of_section = "Product Items Ranking"; ?> 
                                                    <?php endif; ?>
													
													<?php if($name_of_section == "Product Ranking" ): ?>
                                                        <?php $name_of_section = "Product Ranking"; ?> 
                                                    <?php endif; ?>
													

                                                    <?php if((!isset($name_of_first_section) &&  false !== $found =  array_search(\Str::singular($name_of_section),$viewing_names)) ||
                                                        ( isset($name_of_first_section) && (false !== $found =  array_search(\Str::singular($name_of_section),$viewing_names)) && (false !== $found =  array_search(\Str::singular($name_of_first_section),$viewing_names)) ) || ($sub_section->name['en'] =="Discounts Breakdown Analysis") ||
                                                        ($sub_section->name['en'] == "Customers Natures Analysis") || (  ($sub_section->name['en'] == "Discounts Sales Interval Comparing Analysis") && (count(array_intersect(['Quantity Discount','Cash Discount','Special Discount'],$viewing_names)) > 0)) 
                                                        ||  $sub_section->name['en'] == 'Products Items Versus Branches' && isset($exportables['product_item']) && isset($exportables['branch'])
                                                        // ||  $sub_section->name['en'] == 'Business Sectors Versus Customers Natures Analysis'
                                                        || ($mainSubSection->name['en'] == "Service Providers") 
                                                        || ($name_of_section == "Product Items Ranking" && isset($exportables['product_item'] )  && /* not sure salah */  isset($exportables['branch'] ) ) 
                                                        || ($name_of_section == "Product Ranking" && isset($exportables['product_or_service'] )  && /* not sure salah */  isset($exportables['branch'] ) ) 
                                                        || ($name_of_section == "Customers" &&  (isset($exportables['customer_name']) )
														|| $name_of_section == "Days" 
														
														// first if statement
														)  

                                                   
                                                        ): ?>
														
														
														<?php if($name_of_section == "Days" && isset($name_of_first_section) &&
															array_search(\Str::singular($name_of_first_section),$viewing_names) === false
													 ): ?>
<?php if($name_of_first_section != 'Product Items' && $name_of_first_section !='Business Unit'): ?>

<?php endif; ?>
														<?php continue; ?>
													<?php endif; ?>
														
														
														
														
														<?php if($user->canViewReport($sub_section->name['en'])
														|| ($name_of_section == "Days" && $name == "One Dimension") // second if statement
														): ?>
                                                        <div class="col-md-4">
                                                            <div class="kt-widget2__item kt-widget2__item--primary">
                                                                <div class="kt-widget2__checkbox">
                                                                </div>
                                                                <?php 
                                                                    $route = isset($sub_section->route) && $sub_section->route !== null ? explode('.', $sub_section->route) : null;
                                                                ?> 


                                                                <div class="kt-widget2__info">
                                                                    <a href="<?php echo e(route(@$sub_section->route, $company)); ?>" class="kt-widget2__title">
	
                                                                        <?php echo e(__($sub_section->name[lang()])); ?>  
                                                                    </a>

                                                                </div>
                                                                <div class="kt-widget2__actions">

                                                                </div>
                                                            </div>
                                                        </div>
														<?php endif; ?> 
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php  !isset($name_of_first_section) ?: $name_of_first_section = null   ; ?> 
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php $section_key++; ?>
                    <?php endif; ?>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/client_view/analysis_reports_lists.blade.php ENDPATH**/ ?>