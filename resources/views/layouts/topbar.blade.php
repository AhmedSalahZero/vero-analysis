<!-- begin:: Header -->
<div id="kt_header" class="kt-header  kt-header--fixed fh-fixedHeader" data-ktheader-minimize="on">


    <div class="kt-container ">

        <!-- begin:: Brand -->
        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
            <a class="kt-header__brand-logo" href="{{ route('home') }}">
                <img alt="Logo" src="{{ url('assets/media/logos/logo_va.png') }}" class="kt-header__brand-logo-default" />
                <img alt="Logo" src="{{ url('assets/media/logos/vero analysis blue logo.png') }}" width="25%" class="kt-header__brand-logo-sticky" />
            </a>
        </div>
		
		@if(true)
		@include('layouts.new-topbar')

@else 
		@include('layouts.old-topbar')
@endif 
        <!-- end: Header Menu -->

        <!-- begin:: Header Topbar -->
		
		
        <div class="kt-header__topbar kt-grid__item">



	<!--begin: Notifications -->
	<div class="kt-header__topbar kt-grid__item ">
								<div class="kt-header__topbar-item dropdown">
									<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
										<span class="kt-header__topbar-icon kt-pulse kt-pulse--light">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon js-mark-notifications-as-read">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect id="bound" x="0" y="0" width="24" height="24" />
													<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
													<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000" />
												</g>
											</svg>

											<!--<i class="flaticon2-bell-alarm-symbol"></i>-->
											{{-- <span class="kt-pulse__ring"></span> --}}
										</span>

										<!--<span class="kt-badge kt-badge--light"></span>-->
									</div>
									<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
										<form>

											<!--begin: Head -->
											<div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
												<h3 class="kt-head__title">
													{{ __('Notifications') }}
													&nbsp;
													<span class="btn btn-success btn-sm btn-bold btn-font-md">{{ $company->unreadNotifications->count() . ' '.__(' new') }}</span>
												</h3>
												<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x" role="tablist">
													<li class="nav-item">
														<a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">{{ __('Past') }}</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false">{{ __('Now') }}</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false">{{ __('Next') }}</a>
													</li>
												</ul>
											</div>

											<!--end: Head -->
											<div class="tab-content">
												<div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
													<div  class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll overflow-auto" data-scroll="true" data-height="300" data-mobile-height="200">
														@foreach($company->notifications as $notification)
														<a href="#" class="kt-notification__item @if($notification->read()) kt-notification__item--read @endif">
															<div class="kt-notification__item-icon">
																<i class="flaticon2-favourite kt-font-danger"></i>
															</div>
															<div class="kt-notification__item-details">
																<div class="kt-notification__item-title">
																	{{ $notification->data['message_'.app()->getLocale()] }}
																</div>
																<div class="kt-notification__item-time">
																	{{ $notification->created_at->diffForHumans() }}
																</div>
															</div>
														</a>
														@endforeach 
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
														
													</div>
												</div>
												
											</div>
										</form>
									</div>
								</div>
								</div>

								<!--end: Notifications -->

            <div class="kt-header__topbar-item dropdown">
			
			
			
			
            @role('super-admin')
            <!--begin: Quick Actions -->
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                    <span class="kt-header__topbar-icon"><i class="flaticon2-gear"></i></span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl" style="
                                                    height:400px;
                                                    overflow-y: scroll;">
                    <form>

                        <!--begin: Head -->
                        <div class="kt-head kt-head--skin-dark" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
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
                            @if ($counter == 1)
                            <div class="kt-grid-nav__row">
                                @endif
                                <a href="{{ $section->route == 'roles.permissions.index' ? route($section->route, 'admin') : route($section->route) }}" class="kt-grid-nav__item">
                                    <span class="kt-grid-nav__icon">
                                        @if ($section->name[$lang] == 'Admin Users')
                                        <svg aria-hidden="true" style="height: 32;" focusable="false" data-prefix="fas" data-icon="users-crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users-crown fa-w-20 fa-9x">
                                            <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                                        </svg>
                                        @else
                                        <i class="{{ $section->icon }}"></i>
                                    </span>
                                    @endif
                                    <span class="kt-grid-nav__title">{{ __($section->name[$lang]) }}</span>
                                    <span class="kt-grid-nav__desc">{{ __('Admin Side') }}</span>
                                </a>
                                @if ($counter == 2)
                            </div> <?php $counter = 0; ?>
                            @endif
                            @endforeach
                            @if ($counter == 1)
                        </div>
                        @endif


                </div>
                <!--end: Grid Nav -->
                </form>
            </div>
            @elserole('company-admin')

                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
                    <span class="kt-header__topbar-icon"><i class="flaticon2-gear"></i></span>
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl" style="
                                                    height:400px;
                                                    overflow-y: scroll;">
                    <form>

                        <!--begin: Head -->
                        <div class="kt-head kt-head--skin-dark" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                            <h3 class="kt-head__title">
                                Admin Features
                                <span class="kt-space-15"></span>
                            </h3>
                        </div>

                        <!--end: Head -->






                        <div class="kt-grid-nav kt-grid-nav--skin-light">
                            <?php $counter = 0; ?>
                            @foreach ($super_admin_sections as $section)
                            <?php $counter++; ?>
                            @if ($counter == 1)
                            <div class="kt-grid-nav__row">
                                @endif
                                <a href="{{ $section->route == 'roles.permissions.index' ? route($section->route, 'admin') : route($section->route) }}" class="kt-grid-nav__item">
                                    <span class="kt-grid-nav__icon">
                                        @if ($section->name[$lang] == 'Admin Users')
                                        <svg aria-hidden="true" style="height: 32;" focusable="false" data-prefix="fas" data-icon="users-crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users-crown fa-w-20 fa-9x">
                                            <path fill="currentColor" d="M96 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm224 32c53.02 0 96-42.98 96-96v-16H224v16c0 53.02 42.98 96 96 96zm256 0h-64c-17.59 0-33.5 7.11-45.07 18.59 40.27 22.06 68.86 62.03 75.13 109.41H608c17.67 0 32-14.33 32-32v-32c0-35.35-28.65-64-64-64zm-402.93 18.59C161.5 263.11 145.59 256 128 256H64c-35.35 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h65.94c6.27-47.38 34.85-87.34 75.13-109.41zM544 224c35.35 0 64-28.65 64-64s-28.65-64-64-64-64 28.65-64 64 28.65 64 64 64zm-147.2 64h-8.31c-20.84 9.96-43.89 16-68.49 16s-47.64-6.04-68.49-16h-8.31C179.58 288 128 339.58 128 403.2V432c0 26.51 21.49 48 48 48h288c26.51 0 48-21.49 48-48v-28.8c0-63.62-51.58-115.2-115.2-115.2zM416 32l-48 24-48-24-48 24-48-24v80h192V32z" class=""></path>
                                        </svg>
                                        @else
                                        <i class="{{ $section->icon }}"></i>
                                    </span>
                                    @endif
                                    <span class="kt-grid-nav__title">{{ __($section->name[$lang]) }}</span>
                                    <span class="kt-grid-nav__desc">{{ __('Admin Side') }}</span>
                                </a>
                                @if ($counter == 2)
                            </div> <?php $counter = 0; ?>
                            @endif
                            @endforeach
                            @if ($counter == 1)
                        </div>
                        @endif


                </div>
                <!--end: Grid Nav -->
                </form>
            </div>
            @endrole
        </div>
        <!--end: Quick actions -->


        <!--begin: Language bar -->


        <!--end: Language bar -->

        <!--begin: User bar -->
        <?php $user = Auth::user();
    $first_letter = substr($user->name, 0, 1); ?>
        <div class="kt-header__topbar-item kt-header__topbar-item--user ">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown">
                @if (isset($company) && !request()->route()->named('home'))
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        @endif
                        <span class="kt-header__topbar-welcome">Hi,</span>
                        <span class="kt-header__topbar-username ">{{ $user->name }} </span>
                        <span class="kt-header__topbar-icon"><b>{{ $first_letter }}</b></span> &nbsp;
    	                    @php
				            $days = $user->getExpirationDaysLeft();
            				@endphp 
                        @if ($user->subscription == 'free_trial')
                        <span class="kt-header__topbar-username "><b>{{ $days . __(' Days Left') }}</b></span>
                        @endif
                        @if (isset($company) && !request()->route()->named('home'))
                    </div>
                    <h6><span class="kt-header__topbar text-center p-2" style="color: white;white-space: nowrap;">{{ $company->name[lang()] . ' ' . __('Company') }}</span>
                    </h6>
                </div>
                @endif
                <img alt="Pic" src="{{ url('assets/media/users/300_21.jpg') }}" class="kt-hidden" />

            </div>
            <br>

            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(./assets/media/misc/bg-1.jpg)">
                    <div class="kt-user-card__avatar">
                        <img class="kt-hidden" alt="Pic" src="{{ url('assets/media/users/300_25.jpg') }}" />

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ $first_letter }}</span>
                    </div>
                    <div class="kt-user-card__name text-dark">
                        {{ $user->name }}
                    </div>

                </div>

                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <div class="kt-notification__custom kt-space-between">
                        <a class="btn btn-label btn-label-brand btn-sm btn-bold" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">{{ __('Sign Out') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
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
