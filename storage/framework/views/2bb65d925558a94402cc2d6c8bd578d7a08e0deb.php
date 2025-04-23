<?php
	$user = Auth()->user();
?>
<ul class="kt-menu__nav ">
	<?php if($user->can('view income statement dashboard') && $user->can('view forecast income statement dashboard')): ?>
    <li class="kt-menu__item  kt-menu__item 
        
        <?php if($active == 'breadkdown_dashboard'): ?>
                active-button
                <?php endif; ?> 

        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.breakdown.incomeStatement', ['reportType'=>'forecast','company'=>$company])); ?>" class="kt-menu__link "><span class="kt-menu__link-text
                
                <?php if($active == 'breadkdown_dashboard'): ?>
                active-text
                    <?php endif; ?> 

                "> <?php echo e(__('Income Statement Dashboard')); ?></span></a>
    </li>
	<?php endif; ?> 

	<?php if($user->can('view income statement dashboard') && $user->can('view income statement variance dashboard')): ?>
    <li class="kt-menu__item  kt-menu__item 
	<?php if($active == 'various_incomestatement_dashboard'): ?>
	
			 active-button
			  <?php endif; ?> 

  
  " aria-haspopup="true"><a href="<?php echo e(route('dashboard.various.incomeStatement',['subItemType'=>'forecast','company'=>$company])); ?>" class="kt-menu__link 
		  
		  
		  "><span class="kt-menu__link-text 
			<?php if($active == 'various_incomestatement_dashboard'): ?>
			 active-text
			  <?php endif; ?> 
			  "><?php echo e(__("Variance Comparing")); ?></span></a>
    </li>
	<?php endif; ?> 

	<?php if($user->can('view income statement dashboard') && $user->can('view income statement comparing dashboard')): ?>
    <li class="kt-menu__item  kt-menu__item 
          <?php if($active == 'interval_dashboard'): ?>
                   active-button
                    <?php endif; ?> 

        
        " aria-haspopup="true"><a href="<?php echo e(route('dashboard.intervalComparing.incomeStatement',['subItemType'=>'forecast','company'=>$company])); ?>" class="kt-menu__link 
                
                
                "><span class="kt-menu__link-text 
                  <?php if($active == 'interval_dashboard'): ?>
                   active-text
                    <?php endif; ?> 
                    "><?php echo e(__("Income Statement Comparing")); ?></span></a>
    </li>
	<?php endif; ?> 


</ul>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/client_view/home_dashboard/main_navs-income-statement.blade.php ENDPATH**/ ?>