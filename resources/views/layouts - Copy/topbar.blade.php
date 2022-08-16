    <!-- begin:: Header -->
    <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

        <!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="fh-fixedHeader kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-tab ">
                @yield('dash_nav')
            </div>
        </div>

        <!-- end: Header Menu -->

        <!-- begin:: Header Topbar -->
        <div class="kt-header__topbar">

            {{-- <!--begin: Search --> --}}
            {{-- <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                    <span class="kt-header__topbar-icon"><i class="flaticon2-search-1"></i></span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-top-unround dropdown-menu-anim dropdown-menu-lg">
                    <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
                        <form method="get" class="kt-quick-search__form">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                            </div>
                        </form>
                        <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                        </div>
                    </div>
                </div>
            </div> --}}
            <!--end: Search -->

            {{-- <!--begin: Notifications --> --}}
            {{-- <div class="kt-header__topbar-item dropdown">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                    <span class="kt-header__topbar-icon"><i class="flaticon2-bell-alarm-symbol"></i></span>
                    <span class="kt-hidden kt-badge kt-badge--dot kt-badge--notify kt-badge--sm"></span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
                    <form>

                        <!--begin: Head -->
                        <div class="kt-head kt-head--skin-light kt-head--fit-x kt-head--fit-b">
                            <h3 class="kt-head__title">
                                User Notifications
                                &nbsp;
                                <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 new</span>
                            </h3>
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false">Events</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false">Logs</a>
                                </li>
                            </ul>
                        </div>

                        <!--end: Head -->
                        <div class="tab-content">
                            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-line-chart kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New order has been received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                2 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-box-1 kt-font-brand"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer is registered
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-chart2 kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Application has been approved
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-image-file kt-font-warning"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New file has been uploaded
                                            </div>
                                            <div class="kt-notification__item-time">
                                                5 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-bar-chart kt-font-info"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New user feedback received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                8 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-pie-chart-2 kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                System reboot has been successfully completed
                                            </div>
                                            <div class="kt-notification__item-time">
                                                12 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-favourite kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New order has been placed
                                            </div>
                                            <div class="kt-notification__item-time">
                                                15 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item kt-notification__item--read">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-safe kt-font-primary"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Company meeting canceled
                                            </div>
                                            <div class="kt-notification__item-time">
                                                19 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-psd kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New report has been received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                23 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon-download-1 kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Finance report has been generated
                                            </div>
                                            <div class="kt-notification__item-time">
                                                25 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon-security kt-font-warning"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer comment recieved
                                            </div>
                                            <div class="kt-notification__item-time">
                                                2 days ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-pie-chart kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer is registered
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 days ago
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-psd kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New report has been received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                23 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon-download-1 kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Finance report has been generated
                                            </div>
                                            <div class="kt-notification__item-time">
                                                25 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-line-chart kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New order has been received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                2 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-box-1 kt-font-brand"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer is registered
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-chart2 kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Application has been approved
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-image-file kt-font-warning"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New file has been uploaded
                                            </div>
                                            <div class="kt-notification__item-time">
                                                5 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-bar-chart kt-font-info"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New user feedback received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                8 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-pie-chart-2 kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                System reboot has been successfully completed
                                            </div>
                                            <div class="kt-notification__item-time">
                                                12 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-favourite kt-font-brand"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New order has been placed
                                            </div>
                                            <div class="kt-notification__item-time">
                                                15 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item kt-notification__item--read">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-safe kt-font-primary"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Company meeting canceled
                                            </div>
                                            <div class="kt-notification__item-time">
                                                19 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-psd kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New report has been received
                                            </div>
                                            <div class="kt-notification__item-time">
                                                23 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon-download-1 kt-font-danger"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                Finance report has been generated
                                            </div>
                                            <div class="kt-notification__item-time">
                                                25 hrs ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon-security kt-font-warning"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer comment recieved
                                            </div>
                                            <div class="kt-notification__item-time">
                                                2 days ago
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-pie-chart kt-font-success"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title">
                                                New customer is registered
                                            </div>
                                            <div class="kt-notification__item-time">
                                                3 days ago
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                    <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                        <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                            All caught up!
                                            <br>No new notifications.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <!--end: Notifications -->

            {{-- SUPER ADMIN SECTIONS --}}

            @role('super-admin')
                <!--begin: Quick Actions -->
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px"
                        aria-expanded="true">
                        <span class="kt-header__topbar-icon"><i class="flaticon2-gear"></i></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl"
                        style="
                                height:400px;
                                overflow-y: scroll;">
                        <form>

                            <!--begin: Head -->
                            <div class="kt-head kt-head--skin-dark"
                                style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                                <h3 class="kt-head__title">
                                    Super Admin Features
                                    <span class="kt-space-15"></span>
                                </h3>
                            </div>

                            <!--end: Head -->






                            <div class="kt-grid-nav kt-grid-nav--skin-light">
                                <?php $counter = 0; ?>
                                @foreach ($super_admin_sections as $section)
                                    <?php $counter++; ?>
                                    @if ($counter == 1)<div class="kt-grid-nav__row">@endif
                                    <a href="{{ $section->route == 'roles.permissions.index' ? route($section->route,'admin') :  route($section->route) }}" class="kt-grid-nav__item">
                                            <span class="kt-grid-nav__icon">
                                                @if ($section->name[$lang] == 'Admin Users')
                                                    <svg aria-hidden="true" style="height: 32;" focusable="false"
                                                        data-prefix="fas" data-icon="users-crown" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                        class="svg-inline--fa fa-users-crown fa-w-20 fa-9x">
                                                        <path fill="currentColor"
                                                            d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z"
                                                            class=""></path>
                                                    </svg>
                                                @else
                                                        <i class="{{ $section->icon }}"></i>
                                                </span>
                                            @endif
                                        <span class="kt-grid-nav__title">{{ __($section->name[$lang]) }}</span>
                                        <span class="kt-grid-nav__desc">{{ __('Admin Side') }}</span>
                                    </a>
                                    @if ($counter == 2)</div> <?php $counter = 0; ?>@endif
                                @endforeach
                                @if ($counter == 1)</div>@endif


                            </div>
                            <!--end: Grid Nav -->
                        </form>
                    </div>
                </div>
            @endrole
            <!--end: Quick Actions -->



            <!--end: Quick panel -->

            <!--begin: Language bar -->
            {{-- <div class="kt-header__topbar-item kt-header__topbar-item--langs">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                    <span class="kt-header__topbar-icon">
                        <img class="" src="./assets/media/flags/012-uk.svg" alt="" />
                    </span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
                    <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                        <li class="kt-nav__item kt-nav__item--active">
                            <a href="#" class="kt-nav__link">
                                <span class="kt-nav__link-icon"><img src="./assets/media/flags/020-flag.svg" alt="" /></span>
                                <span class="kt-nav__link-text">English</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a href="#" class="kt-nav__link">
                                <span class="kt-nav__link-icon"><img src="./assets/media/flags/016-spain.svg" alt="" /></span>
                                <span class="kt-nav__link-text">Spanish</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a href="#" class="kt-nav__link">
                                <span class="kt-nav__link-icon"><img src="./assets/media/flags/017-germany.svg" alt="" /></span>
                                <span class="kt-nav__link-text">German</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> --}}

            <!--end: Language bar -->

            <!--begin: User Bar -->
            <?php $user = Auth::user(); $first_letter = substr($user->name, 0, 1)  ?>
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                    <div class="kt-header__topbar-user">
                        <span class="kt-hidden kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                        <span class="kt-hidden kt-header__topbar-username kt-hidden-mobile">{{$user->name}}</span>
                        <img class="kt-hidden" alt="Pic" src="{{ url('assets/media/users/300_25.jpg') }}" />

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span
                            class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bolder">{{$first_letter}}</span>
                    </div>
                </div>
                <div
                    class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                    <!--begin: Head -->
                    <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                        style="background-image: url({{ url('assets/media/misc/bg-1.jpg') }}">
                        <div class="kt-user-card__avatar">
                            <img class="kt-hidden" alt="Pic" src="{{ url('assets/media/users/300_25.jpg') }}" />

                            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                            <span
                                class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{$first_letter}}</span>
                        </div>
                        <div class="kt-user-card__name">
                            {{$user->name}}
                        </div>
                        <div class="kt-user-card__badge">
                            {{-- <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> --}}
                        </div>
                    </div>

                    <!--end: Head -->

                    <!--begin: Navigation -->
                    <div class="kt-notification">
                        {{-- <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Profile
                                </div>
                                <div class="kt-notification__item-time">
                                    Account settings and more
                                </div>
                            </div>
                        </a>
                        <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-mail kt-font-warning"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Messages
                                </div>
                                <div class="kt-notification__item-time">
                                    Inbox and tasks
                                </div>
                            </div>
                        </a>
                        <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-rocket-1 kt-font-danger"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Activities
                                </div>
                                <div class="kt-notification__item-time">
                                    Logs and notifications
                                </div>
                            </div>
                        </a>
                        <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-hourglass kt-font-brand"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Tasks
                                </div>
                                <div class="kt-notification__item-time">
                                    latest tasks and projects
                                </div>
                            </div>
                        </a>
                        <a href="#" class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-cardiogram kt-font-warning"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    Billing
                                </div>
                                <div class="kt-notification__item-time">
                                    billing & statements <span
                                        class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2
                                        pending</span>
                                </div>
                            </div>
                        </a> --}}
                        <div class="kt-notification__custom kt-space-between">
                            <a class="btn btn-label btn-label-brand btn-sm btn-bold"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">{{__('Sign Out')}}</a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

















                            <a href="demo3/custom/user/login-v2.html" target="_blank"
                                class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>
                        </div>
                    </div>

                    <!--end: Navigation -->
                </div>
            </div>

            <!--end: User Bar -->
        </div>

        <!-- end:: Header Topbar -->
    </div>
    <!-- end:: Header -->
