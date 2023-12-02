     <!-- end:: Brand -->
        @if (!request()->route()->named('viewHomePage'))


        <!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                <ul class="kt-menu__nav ">







                  
                    @foreach ($client_sections as $section)
                    {{-- mr mahmoud temporary condition --}}
                    {{-- --}}

                    @if(! ($section->id == 220) ||(Auth()->check() && ! in_array(Auth()->user()->email , preventUserFromForeCast() )))
                    @if($section->id != 275
                    // || Auth()->check() && Auth()->user()->canViewIncomeStatement()
                    )
                    @if ($section->route != null && count($section->subSections) == 0)
                    <?php $route = isset($section->route) && $section->route !== null ? explode('.', $section->route) : null; ?>
                    {{-- home and financial statement tabs --}}
                    @if($section->id == 2 && $user->can('view home') || $section->id ==280 && $user->can('view financial statement') || ($section->id != 2 && $section->id != 280))

                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel
                                {{ Request::routeIs(@$route[0] . '.*') || Request::routeIs(@$route[0])? 'kt-menu__item--open kt-menu__item--here ': '' }} ">
                        {{-- class="kt-menu__item    kt-menu__item--rel kt-menu__item--open kt-menu__item--here"  > --}}
                        <a href="{{ @$section->route == 'home' ? route(@$section->route) : route(@$section->route, $company) }}" class="kt-menu__link  text-center">
                            <span class="kt-menu__link-text ">{{ __($section->name[$lang]) }}


                            </span><i class="kt-menu__ver-arrow {{ $section->icon }}"></i></a>
                    </li>
                    @endif
                    @elseif (count($section->subSections) > 0)

                    @if ($section->name['en'] == 'Trend Analysis Reports')
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">{{ __($section->name[$lang]) }} ___99</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu  kt-menu__submenu--fixed kt-menu__submenu--left" style="width:1000px">
                            <div class="kt-menu__subnav">
                                <ul class="kt-menu__content">
                                    {{-- ZONES --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Zones Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">

                                            @foreach ($section->subSections()->where('route', 'like', 'zone.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___9


                                                    </span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    {{-- Sales Channels --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Sales Channels Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">

                                            @foreach ($section->subSections()->where('route', 'like', 'salesChannels.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
																
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___10</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    {{-- Categories --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Categories Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">

                                            @foreach ($section->subSections()->where('route', 'like', 'categories.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___111</span></a>

                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @elseif ($section->name['en'] == 'Breakdown Analysis Report')
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">{{ __($section->name[$lang]) }} ___18</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu  kt-menu__submenu--fixed kt-menu__submenu--left" style="width:1000px">
                            <div class="kt-menu__subnav">
                                <ul class="kt-menu__content">
                                    {{-- ZONES --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Zones Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">

                                            @foreach ($section->subSections()->where('route', 'like', 'salesBreakdown.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___12</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    {{-- Sales Channels --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Sales Channels Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">

                                            @foreach ($section->subSections()->where('route', 'like', 'salesChannels.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___13</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    {{-- Categories --}}
                                    <li class="kt-menu__item ">
                                        <h3 class="kt-menu__heading kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('Categories Analysis Reports') }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></h3>
                                        <ul class="kt-menu__inner">
                                            @foreach ($section->subSections()->where('route', 'like', 'categories.' . '%')->get() as $subSection)
                                            <?php
                                                                $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                                ?>
                                            <li class="kt-menu__item " aria-haspopup="true"><a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-icon {{ $subSection->icon }}"></i><span class="kt-menu__link-text wording-nowrap">{{ __($subSection->name[$lang]) }} ___14</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @else
                    @if($section->name['en'] ==='Dashboard')


                    {{-- dashboard tab --}}
                    @if($user->can('view sales dashboard') || $user->can('view breakdown dashboard') || $user->can('view interval comparing dashboard') || $user->can('view income statement'))
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">{{ __($section->name[$lang]) }} </span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>


                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">

                            <ul class="kt-menu__subnav">
                                @foreach ($section->subSections as $subSection)


                                @if(($subSection->name['en'] == 'Sales Person Dashboard' && in_array('Sales Person',$exportables)) )
                                @include('print_sections')
                                @continue

                                @endif
                                @if( ($subSection->name['en'] == 'Customers Dashboard' && in_array('Customer Name',$exportables) ))
                                @include('print_sections')
                                @continue

                                @endif
                                @if($subSection->name['en'] != 'Customers Dashboard' && $subSection->name['en'] != 'Sales Person Dashboard' )



                                @include('print_sections')
                                @endif
                                @endforeach

                            </ul>
                        </div>
                    </li>
                    @endif
                    @else
					@if($user->can('view '.strtolower($section->name['en'])))
					
					
					
					
					
					
					
					
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" 
					@if(strtolower($section->name['en']) == 'sales forecast value base' && !hasUploadData($company->id))
					@elseif(strtolower($section->name['en']) == 'sales forecast quantity base' && !hasUploadData($company->id))
					@else 
					data-ktmenu-submenu-toggle="click"
					
					@endif
					 aria-haspopup="true"><a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                            <span class="kt-menu__link-text">{{ __($section->name[$lang]) }} </span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>

                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left ">
                            <ul class="kt-menu__subnav">
                                @foreach ($section->subSections as $subSection)
                                @if ($subSection->route != null && count($subSection->subSections) == 0)
                                <?php
                                                    $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                    ?>
                                @if ($subSection->id == 222 || $subSection->id == 223 || $subSection->id == 224 || $subSection->id == 225 || $subSection->id == 226)
                                <?php
                                                                $show_route = 0 ;
                                                                $modified_seasonality =  App\Models\ModifiedSeasonality::where('company_id', $company->id)->first();
                                                                if (($subSection->id == 222 || $subSection->id == 226) && isset($modified_seasonality)  ) {
                                                                    $show_route = 1 ;
                                                                }
                                                                elseif ($subSection->id == 223 && isset($modified_seasonality) &&
                                                                (( App\Models\ExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 224) && isset($modified_seasonality) &&
                                                                ((App\Models\SecondExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 225  ) && isset($modified_seasonality) &&
                                                                ((App\Models\CollectionSetting::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }else {
                                                                    $show_route = 0;
                                                                }
                                                            ?>


                                @if ($show_route == 1)
								{{-- @if($user->can('view sales forecast value base')) --}}
                                <li class="kt-menu__item " aria-haspopup="true">
                                    <a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __($subSection->name[$lang]) }}</span></a>
                                </li>
								{{-- @endif --}}
                                @endif
                                @elseif ($subSection->id == 275 || $subSection->id == 276 || $subSection->id == 277 || $subSection->id == 278 || $subSection->id == 279)
                                <?php
                                                                $show_route = 0 ;
                                                                $modified_seasonality =  App\Models\QuantityModifiedSeasonality::where('company_id', $company->id)->first();
                                                                if (($subSection->id == 275 || $subSection->id == 279) && isset($modified_seasonality)  ) {
                                                                    $show_route = 1 ;
                                                                }
                                                                elseif ($subSection->id == 276 && isset($modified_seasonality) &&
                                                                (( App\Models\QuantityExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 277) && isset($modified_seasonality) &&
                                                                ((App\Models\QuantitySecondExistingProductAllocationBase::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }elseif (($subSection->id == 278  ) && isset($modified_seasonality) &&
                                                                ((App\Models\QuantityCollectionSetting::where('company_id', $company->id)->first()) !== null) ) {
                                                                    $show_route = 1 ;
                                                                }else {
                                                                    $show_route = 0;
                                                                }
                                                            ?>


                                @if ($show_route == 1)
                                <li class="kt-menu__item " aria-haspopup="true">
                                    <a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __($subSection->name[$lang]) }} </span></a>
                                </li>
                                @endif

                                @else

                                @if($user->can('view '. strtolower($subSection->name['en'])))
                                @if($section->id == 21)
								@foreach(getUploadParamsFromType() as $elementModelName => $params )
								@can($params['viewPermissionName'])
								<li class="kt-menu__item " aria-haspopup="true">
                                    <a href="{{ route('view.uploading',['company'=>$company->id , 'model'=>$elementModelName]) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ getUploadDataText($params['typePrefixName']) }} </span></a>
                                </li>
								@endcan 
								@endforeach 
								@php
									break;
								@endphp
								@else 
								
								
								<li class="kt-menu__item " aria-haspopup="true">
								
                                    <a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __($subSection->name[$lang]) }} </span></a>
                                </li>
								@endif 
                                @endif

                                @endif
                                @else
                                <?php
                                                        $route = isset($subSection->route) && $subSection->route !== null ? explode('.', $subSection->route) : null;
                                                        ?>

                                @if($user->can('view '.strtolower($subSection->name[$lang])))

                                <li class="kt-menu__item " aria-haspopup="true">
                                    <a href="{{ @$subSection->route == 'home' ? route(@$subSection->route) : route(@$subSection->route, $company) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __($subSection->name[$lang]) }}</span></a>
                                </li>
                                @endif

                                @endif
                                @endforeach

                            </ul>
                        </div>
                    </li>
					@endif 

                    @endif
                    @endif
                    @endif

                    @endif
















                    @endif
                    @endforeach




                </ul>
            </div>
        </div>
        @endif
