<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
        <ul class="kt-menu__nav ">
			
            <?php $__currentLoopData = getHeaderMenu(isset($company) ? $company : null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $menuArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $hasSubmenu =isset($menuArr['submenu']) && count($menuArr['submenu']);
            ?>
            <?php if($menuArr['show']): ?>
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="<?php if( !$hasSubmenu ): ?> <?php echo e($menuArr['link']); ?> <?php else: ?> javascript:;       <?php endif; ?>" class="kt-menu__link <?php if($hasSubmenu): ?> kt-menu__toggle <?php endif; ?>"><span class="kt-menu__link-text"><?php echo e($menuArr['title']); ?></span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <?php if($hasSubmenu): ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-menu.multi-submenu','data' => ['subItems' => $menuArr['submenu']]]); ?>
<?php $component->withName('nav-menu.multi-submenu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['subItems' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menuArr['submenu'])]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <?php else: ?>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-menu.single-submenu','data' => ['menuArr' => $menuArr]]); ?>
<?php $component->withName('nav-menu.single-submenu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['menuArr' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menuArr)]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </ul>
    </div>
</div>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/layouts/new-topbar.blade.php ENDPATH**/ ?>