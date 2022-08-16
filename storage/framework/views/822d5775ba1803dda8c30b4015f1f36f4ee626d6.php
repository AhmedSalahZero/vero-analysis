<ul class="kt-menu__nav ">
        <li class="kt-menu__item  kt-menu__item" aria-haspopup="true"><a href="<?php echo e(route('dashboard', $company)); ?>"
                class="kt-menu__link 
                <?php if($active == 'sales_dashboard'): ?>
                active-button
                <?php endif; ?> 
                
                "><span class="kt-menu__link-text 
                     <?php if($active == 'sales_dashboard'): ?>
                active-text
                    <?php endif; ?> 
                
                "><?php echo e(__('Sales Dashboard')); ?></span></a>
        </li>
        <li class="kt-menu__item  kt-menu__item 
        
        <?php if($active == 'breadkdown_dashboard'): ?>
                active-button
                <?php endif; ?> 

        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.breakdown', $company)); ?>"
                class="kt-menu__link "><span class="kt-menu__link-text
                
                <?php if($active == 'breadkdown_dashboard'): ?>
                active-text
                    <?php endif; ?> 

                ">Breakdown Dashboard</span></a>
        </li>
        <?php if(canViewCustomersDashboard($exportables)): ?>
        <li class="kt-menu__item  kt-menu__item 
        <?php if($active == 'customer_dashboard'): ?>
                active-button
                <?php endif; ?> 
        
        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.customers', $company)); ?>"
                class="kt-menu__link "><span class="kt-menu__link-text"><?php echo e(__("Customers Dashboard")); ?></span></a>
        </li>
        <?php endif; ?>
         <?php if(in_array('Sales Person',$exportables)): ?>
        <li class="kt-menu__item  kt-menu__item 
        
           <?php if($active == 'sales_person_dashboard'): ?>
                active-button
                <?php endif; ?> 

        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.salesPerson', $company)); ?>"
                class="kt-menu__link "><span class="kt-menu__link-text
                  <?php if($active == 'sales_person_dashboard'): ?>
                  active-text
                    <?php endif; ?> 


                "><?php echo e(__("Sales Person Dashboard")); ?></span></a>
        </li>
        <?php endif; ?>
        <?php if(in_array('Cash Discount' , $exportables) || in_array('Special Discount' , $exportables) || in_array('Quantity Discount' , $exportables) || in_array('Other Discounts' , $exportables)  ): ?>
        <li class="kt-menu__item  kt-menu__item 
        
         <?php if($active == 'discount_dashboard'): ?>
                   active-button
                    <?php endif; ?> 

        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.salesDiscount', $company)); ?>"
                class="kt-menu__link "><span class="kt-menu__link-text 
                
                 <?php if($active == 'discount_dashboard'): ?>
                   active-text
                    <?php endif; ?> 

                "><?php echo e(__("Sales Discount Dashboard")); ?></span></a>
        </li>
        <?php endif; ?> 
        <li class="kt-menu__item  kt-menu__item 
          <?php if($active == 'interval_dashboard'): ?>
                   active-button
                    <?php endif; ?> 

        
        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.intervalComparing', $company)); ?>"
                class="kt-menu__link 
                
                
                "><span class="kt-menu__link-text 
                
                
                  <?php if($active == 'interval_dashboard'): ?>
                   active-text
                    <?php endif; ?> 
                    "><?php echo e(__("Interval Comparing Dashboard")); ?></span></a>
        </li>

    </ul><?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/client_view/home_dashboard/main_navs.blade.php ENDPATH**/ ?>