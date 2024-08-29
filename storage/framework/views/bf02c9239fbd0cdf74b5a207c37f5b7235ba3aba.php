<style>
    .second-sub-text {
        font-size: 15px !important;
        font-weight: 500 !important;
		white-space:nowrap !important;
		font-variant:initial !important;
		color:black !important ;
    }
	.third-sub-text{
	    color: #074FA4 !important;
        font-size: 15px !important;
        font-weight: 400 !important;
	}

</style>
<?php if($navItem['show']): ?>
<li 

class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel " data-ktmenu-submenu-toggle="click" aria-haspopup="true">

<a
<?php if(isset($navItem['attr']) ): ?>
<?php $__currentLoopData = (array) $navItem['attr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($attr.'='.$value . ' '); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>

 href="<?php if(isset($navItem['sub_items']) && count($navItem['sub_items'])): ?>  javascript:; <?php else: ?> <?php echo e($navItem['link']); ?> <?php endif; ?>" class="kt-menu__link  
<?php if(isset($navItem['sub_items']) && count($navItem['sub_items'])): ?>
kt-menu__toggle align-items-center
<?php endif; ?> 

">
<i style="font-size:1.3rem !important" class="kt-menu__ver-arrow  mr-2 text-white d-block <?php echo e($navItem['icon']); ?>"></i>
        <span class="kt-menu__link-text font-size-1-25rem first-sub-text"> <?php echo e($navItem['name']); ?> </span></a>
    <?php if(isset($navItem['sub_items']) && count($navItem['sub_items']) ): ?>
    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
        <ul class="kt-menu__subnav">
            <?php $__currentLoopData = $navItem['sub_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItemOptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $link = $subItemOptions['link'];
            $subItemName = $subItemOptions['name'];
            $showSubItem = $subItemOptions['show'];
            ?>

            <?php if(! (isset($subItemOptions['sub_items']) && count($subItemOptions['sub_items'])) && $showSubItem): ?>
            <li class="kt-menu__item " aria-haspopup="true">
                <a
				<?php if(isset($subItemOptions['attr']) ): ?>
				<?php $__currentLoopData = (array) $subItemOptions['attr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($attr.'='.$value . ' '); ?>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
				<?php endif; ?>

				 href="<?php echo e($link); ?>" class="kt-menu__link ">
                    <i class="kt-menu__link-icon fa fa-crosshairs font-size-15px"></i>
                    <span class="kt-menu__link-text second-sub-text"><?php echo $subItemName; ?></span>
					
                </a>
            </li>
            <?php endif; ?>


            <?php if(isset($subItemOptions['sub_items']) && count($subItemOptions['sub_items']) && $showSubItem): ?>
            <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
                <a href="#" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon fa fa-crosshairs font-size-15px"></i>
                    
                    <span class="kt-menu__link-text second-sub-text"><?php echo $subItemName; ?></span>
                    
                </a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                    <ul class="kt-menu__subnav">
                        <?php $__currentLoopData = $subItemOptions['sub_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link=>$thirdSubOptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($thirdSubOptions['show']): ?>

                        <li class="kt-menu__item " aria-haspopup="true"><a href="<?php echo e($thirdSubOptions['link']); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon fa fa-crosshairs font-size-15px"></i>
                                <span class="kt-menu__link-text third-sub-text"><?php echo e($thirdSubOptions['name']); ?></span>
                            </a></li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>
    </div>
    <?php endif; ?>
</li>
<?php endif; ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/nav-item.blade.php ENDPATH**/ ?>