<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
        <ul class="kt-menu__nav ">
		{{-- {{ dd(getHeaderMenu() ) }} --}}
            @foreach(getHeaderMenu(isset($company) ? $company : null) as $id => $menuArr)
            @php
            $hasSubmenu =isset($menuArr['submenu']) && count($menuArr['submenu']);
            @endphp
            @if($menuArr['show'])
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true"><a href="@if( !$hasSubmenu ) {{ $menuArr['link'] }} @else javascript:;       @endif" class="kt-menu__link @if($hasSubmenu) kt-menu__toggle @endif"><span class="kt-menu__link-text">{{ $menuArr['title'] }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        @if($hasSubmenu)
                        <x-nav-menu.multi-submenu :subItems="$menuArr['submenu']"></x-nav-menu.multi-submenu>
                        @else
                        <x-nav-menu.single-submenu :menuArr="$menuArr"></x-nav-menu.single-submenu>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @endforeach


        </ul>
    </div>
</div>
