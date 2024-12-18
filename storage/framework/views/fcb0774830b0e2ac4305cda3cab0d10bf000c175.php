
<div id="kt_header" class="kt-header  kt-header--fixed fh-fixedHeader" data-ktheader-minimize="on">


    <div class="kt-container ">

        <!-- begin:: Brand -->
        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
            <a class="kt-header__brand-logo" href="<?php echo e(route('home')); ?>">
                <img alt="Logo" src="<?php echo e(url('assets/media/logos/logo_va.png')); ?>" class="kt-header__brand-logo-default" />
                <img alt="Logo" src="<?php echo e(url('assets/media/logos/vero analysis blue logo.png')); ?>" width="25%" class="kt-header__brand-logo-sticky" />
            </a>
        </div> 
        <?php echo $__env->make('layouts.new-topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- end: Header Menu -->

        <!-- begin:: Header Topbar -->


        <div class="kt-header__topbar kt-grid__item">


            <!--begin: Notifications -->
            

            <!--end: Notifications -->

            <div class="kt-header__topbar-item dropdown">




                <?php if(auth()->check() && auth()->user()->hasRole('super-admin')): ?>
                <!--begin: Quick Actions -->
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                    <span class="kt-header__topbar-icon"><i class="flaticon2-gear"></i></span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl" style="
                                                    height:400px;
                                                    overflow-y: scroll;">
                    <form>

                        <!--begin: Head -->
                        <div class="kt-head kt-head--skin-dark" style="background-image: url(<?php echo e(asset('assets/media/misc/bg-1.jpg')); ?>)">
                            <h3 class="kt-head__title">
                                Super Admin Features
                                <span class="kt-space-15"></span>
                            </h3>
                        </div>

                        <!--end: Head -->






                        <div class="kt-grid-nav kt-grid-nav--skin-light">
                            <?php $counter = 0; ?>
                            <?php $__currentLoopData = $super_admin_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $counter++; ?>
                            <?php if($counter == 1): ?>
                            <div class="kt-grid-nav__row">
                                <?php endif; ?>
                                <a href="<?php echo e($section->route == 'roles.permissions.index' ? route('roles.permissions.edit') : route($section->route)); ?>" class="kt-grid-nav__item">
                                    <span class="kt-grid-nav__icon">
                                        <?php if($section->name[$lang] == 'Admin Users'): ?>
                                        <svg aria-hidden="true" style="height: 32;" focusable="false" data-prefix="fas" data-icon="users-crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users-crown fa-w-20 fa-9x">
                                            <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                                        </svg>
                                        <?php else: ?>
                                        <i class="<?php echo e($section->icon); ?>"></i>
                                    </span>
                                    <?php endif; ?>
                                    <span class="kt-grid-nav__title"><?php echo e(__($section->name[$lang])); ?></span>
                                    <span class="kt-grid-nav__desc"><?php echo e(__('Admin Side')); ?></span>
                                </a>
								
								
								
                                <?php if($counter == 2): ?>
                            </div> <?php $counter = 0; ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($counter == 1): ?>
                        </div>
                        <?php endif; ?>


                </div>
                <!--end: Grid Nav -->
                </form>
            </div>

            <?php elseif(auth()->check() && auth()->user()->hasRole('company-admin')): ?>

            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                <span class="kt-header__topbar-icon"><i class="flaticon2-gear"></i></span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl" style="
                                                    height:400px;
                                                    overflow-y: scroll;">
                <form>

                    <!--begin: Head -->
                    <div class="kt-head kt-head--skin-dark" style="background-image: url(<?php echo e(asset('assets/media/misc/bg-1.jpg')); ?>)">
                        <h3 class="kt-head__title">
                            Admin Features
                            <span class="kt-space-15"></span>
                        </h3>
                    </div>

                    <!--end: Head -->






                    <div class="kt-grid-nav kt-grid-nav--skin-light">
                        <?php $counter = 0; ?>
                        <?php $__currentLoopData = $super_admin_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $counter++; ?>
                        <?php if($counter == 1): ?>
                        <div class="kt-grid-nav__row">
                            <?php endif; ?>
                            <a href="<?php echo e($section->route == 'roles.permissions.index' ? route('roles.permissions.edit') : route($section->route)); ?>" class="kt-grid-nav__item">
                                <span class="kt-grid-nav__icon">
                                    <?php if($section->name[$lang] == 'Admin Users'): ?>
                                    <svg aria-hidden="true" style="height: 32;" focusable="false" data-prefix="fas" data-icon="users-crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users-crown fa-w-20 fa-9x">
                                        <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                                    </svg>
                                    <?php else: ?>
                                    <i class="<?php echo e($section->icon); ?>"></i>
                                </span>
                                <?php endif; ?>
                                <span class="kt-grid-nav__title"><?php echo e(__($section->name[$lang])); ?></span>
                                <span class="kt-grid-nav__desc"><?php echo e(__('Admin Side')); ?></span>
                            </a>
                            <?php if($counter == 2): ?>
                        </div> <?php $counter = 0; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($counter == 1): ?>
                    </div>
                    <?php endif; ?>


            </div>
            <!--end: Grid Nav -->
            </form>
        </div>
        <?php endif; ?>
    </div>
    <!--end: Quick actions -->


    <!--begin: Language bar -->


    <!--end: Language bar -->

    <!--begin: User bar -->
    <?php $user = Auth::user();
    $first_letter = substr($user->name, 0, 1); ?>
    <div class="kt-header__topbar-item kt-header__topbar-item--user ">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown">
            <?php if(isset($company) && !request()->route()->named('home')): ?>
            <div class="d-flex flex-column">
                <div class="d-flex">
                    <?php endif; ?>
                    <span class="kt-header__topbar-welcome">Hi,</span>
                    <span class="kt-header__topbar-username "><?php echo e($user->name); ?> </span>
                    <span class="kt-header__topbar-icon"><b><?php echo e($first_letter); ?></b></span> &nbsp;
                    <?php
                    $days = $user->getExpirationDaysLeft();
                    ?>
                    <?php if($user->subscription == 'free_trial'): ?>
                    <span class="kt-header__topbar-username "><b><?php echo e($days . __(' Days Left')); ?></b></span>
                    <?php endif; ?>
                    <?php if(isset($company) && !request()->route()->named('home')): ?>
                </div>
                <h6><span class="kt-header__topbar text-center p-2" style="color: white;white-space: nowrap;"><?php echo e($company->name[lang()] . ' ' . __('Company')); ?></span>
                </h6>
            </div>
            <?php endif; ?>
            <img alt="Pic" src="<?php echo e(url('assets/media/users/300_21.jpg')); ?>" class="kt-hidden" />

        </div>
        <br>

        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

            <!--begin: Head -->
            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(./assets/media/misc/bg-1.jpg)">
                <div class="kt-user-card__avatar">
                    <img class="kt-hidden" alt="Pic" src="<?php echo e(url('assets/media/users/300_25.jpg')); ?>" />

                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"><?php echo e($first_letter); ?></span>
                </div>
                <div class="kt-user-card__name text-dark">
                    <?php echo e($user->name); ?>

                </div>

            </div>

            <!--end: Head -->

            <!--begin: Navigation -->
            <div class="kt-notification">
                <div class="kt-notification__custom kt-space-between">
                    <a class="btn btn-label btn-label-brand btn-sm btn-bold" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><?php echo e(__('Sign Out')); ?></a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>


                </div>
            </div>

            <!--end: Navigation -->
        </div>
    </div>

    <!--end: User bar -->
</div>

<!-- end:: Header Topbar -->
</div>
</div>
<?php /**PATH E:\projects\veroo\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>