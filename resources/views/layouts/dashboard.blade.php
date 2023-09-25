<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../">

    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>VERO ANALYSIS</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{-- <style>

.kt-portlet .kt-portlet__body{
	padding:25px !important;
}
</style> --}}

<style>
#add-row{
	border-color:green;
	background-color:green;
	color:white;
}
.tooltip-inner{
	text-align:left !important;
}
.font-1-5{
	font-size:1.5rem !important;
}
</style>
@if(in_array('Result',Request()->segments()) && in_array('SalesGathering',Request()->segments()))
<style>

tr td:first-of-type{
	white-space:normal !important ;
}
</style>
@endif 
<style>
.max-w-classes
{
	width:350px !important;
	min-width:350px !important;
	max-width:350px !important;
	white-space:normal !important;
}
</style>
	{{-- {{ dd() }} --}}
@if(!in_array('SalesForecastQuantity',Request()->segments()) && !in_array('dashboard',Request()->segments()) && !in_array('SalesReport',Request()->segments())&&!in_array('Comparing',Request()->segments())&&!in_array('SalesBreakdownAnalysis',Request()->segments())&&!in_array('SalesDiscountSalesBreakdownAnalysis',Request()->segments()) && Request()->route()->getName() != 'salesGathering.index')
<style>

.table-active th:first-of-type,
.group-color td:first-of-type
{
	width:350px !important;
	min-width:350px !important;
	max-width:350px !important;
	white-space:normal !important;
}
</style>
@endif 

<style>
.table-title{
	color:red;
	
}
.edit-modal-icon{

	color:#046187 !important;
}
.fas.fa-trash-alt{
	color:#ea1b1b !important;
}
</style>

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!--begin::Fonts -->
    <script src="{{ asset('custom/webfont.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script> --}}
    <script>
        var wto;
        const slugify = str =>
            str
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');

        function getNumberOfMillSeconds() {
            return 2000;
        }



        function myNextAllWithNested(e) {
            var parentId = e.getAttribute('data-model-id')
            return document.querySelectorAll('tr.maintable-1-row-class' + parentId + '.is-sub-row')
        }

        function* myNextAll(e, selector) {
            while (e = e.nextElementSibling) {
                if (e.matches(selector)) {
                    yield e;
                }
            }
        }

        function getSubItemsFromString(str) {
            let stringToReplaceEn = "[(] {{ 'Quantity' }} [)]$"
            let stringToReplaceAr = "[(] {{ __('Quantity') }} [)]$"
            let regEn = new RegExp(stringToReplaceEn, "g")
            let regAr = new RegExp(stringToReplaceAr, "g")
            return str.replace ? str.replace(regEn, '').replace(regAr, '').trim() : str

        }

        function isQuantitySubItem(str) {
            return str.endsWith("{{ quantityIdentifier }}") || str.endsWith("{{ __(quantityIdentifier) }}")
        }

        function isLastKey(date, dates) {
            let index = dates.length;
            index = index - 1;
            return date == dates[index]
        }

        function convertStringToClass(str) {
            return str.replace ? str.replace(/[ !\"#$%&'\(\)\*\+,\.\/:;<=>\?\@\[\\\]\^`\{\|\}~]/g, '') : str;
        }

        // window['maxOptions'] = 10 ;
        function reinitializeSelect2() {
            let numberOfMulteSelects = $(document).find('select.select2-select').length;
            let maxOptions = [0];
            if (numberOfMulteSelects == 1) {
                maxOptions[0] = 200;
                maxOptions[1] = 0;
                maxOptions[2] = 0;
                maxOptions[3] = 0;
            }
            if (numberOfMulteSelects == 2) {
                maxOptions[0] = 200;
                maxOptions[1] = 200;
                maxOptions[2] = 0;
                maxOptions[3] = 0;
            }

            if (numberOfMulteSelects == 3) {
                maxOptions[0] = 50;
                maxOptions[1] = 100;
                maxOptions[2] = 200;
                maxOptions[3] = 0;
            }

            if (numberOfMulteSelects == 4) {
                maxOptions[0] = 50;
                maxOptions[1] = 50;
                maxOptions[2] = 100;
                maxOptions[3] = 200;
            }

            $(document).find('select.select2-select').each(function(index, value) {
                let maxOption = maxOptions[index] !== undefined ? maxOptions[index] : 0;
                $(this).selectpicker({
                    maxOptions: maxOption,
                    //   maxOptions: $(this).data('max-options') || $(this).data('max-options') == 0   ? $(this).data('max-options') : window['maxOptions'],
                    buttons: ['selectMax', 'disableAll']
                });
                $(this).data('max-options', maxOption);

                $(this).closest('div[class*="col-md"]').find('.max-options-select').html('[{{ __("Max:") }}' + maxOption + ']');

            })

            $(document).find('select.select2-select.select-all').each(function(index, value) {
                let maxOption = maxOptions[index] !== undefined ? maxOptions[index] : 0;
                $(this).selectpicker({
                    maxOptions: maxOption,
                    //   maxOptions: $(this).data('max-options') || $(this).data('max-options') == 0   ? $(this).data('max-options') : window['maxOptions'],
                    buttons: ['selectMax', 'disableAll']
                });
                $(this).data('max-options', maxOption);

                $(this).closest('div[class*="col-md"]').find('.max-options-select').html('[Max:' + maxOption + ']');

            })


        }

    </script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            }
            , active: function() {
                sessionStorage.fonts = true;
            }
        });

    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">


    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <!--end::Page Vendors Styles -->

    <!--begin:: Global Mandatory Vendors -->
    {{-- <link href="{{url('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" /> --}}

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->
    <link href="{{url('assets/vendors/general/tether/dist/css/tether.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/nouislider/distribute/nouislider.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{url('assets/vendors/general/animate.css/animate.css')}}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{url('assets/vendors/general/socicon/css/socicon.css')}}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{url('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/custom/vendors/flaticon/flaticon.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/custom/vendors/flaticon2/flaticon.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />
    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{url('assets/css/demo4/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('datatable/datatable.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <style>
	
	.bg-green{
		background-color:green;
	}
	.border-green{
		border-color:green;
	}
	
	.bg-red{
		background-color:red;
	}
	.border-red {
		background-color:green ;
	}
        .arrow-nav {
            font-size: 18px;
            color: white !important;
            background-color: #074FA4 !important;
            padding: 20px 9px;
            position: absolute;
            top: 140px;
        }

        .arrow-right {
            right: 0;
        }

        .arrow-left {
            left: 0
        }

        .crusor-pointer {
            cursor: pointer
        }

        .color-red {
            color: red !important;

        }

        .color-green {
            color: green !important;
        }

        .bg-antiquewhite {
            background-color: antiquewhite;

        }

    </style>

    {{-- <style>
        table:not(.exclude-table) tbody tr:not(.table-active):not(.active-style):not(.is-rate):not(.is-sub-row):not(.group-color)>td:not(.dtfc-fixed-left):not(.dtfc-fixed-right):not(.active-style) {
            color: black !important;
            font-weight: bold !important;
        }
	

    </style> --}}

	@if( !in_array('financial-statement',Request()->segments()) )
	<style>
		label{
			font-weight:700 !important ; 
			font-size:1rem !important;
			color:#646c9a !important;  
		}
	</style>
	@endif 
	   <style>
	   
	.flex-center{
		display:flex;
		align-items:center;
		justify-content:center;
		height:100%;
	}
        table:not(.exclude-table) tbody tr:not(.table-active):not(.active-style):not(.is-rate):not(.is-sub-row):not(.group-color)>td:not(.dtfc-fixed-left):not(.active-style) {
            color: black !important;
            font-weight: bold !important;
        }
	

    </style>


    <style>
        .icon-lg {
            font-size: 1.75rem !important;
        }

        .min-height-170px {
            min-height: 170px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .first-subrow-last-td,
        .second-subrow-last-td {
            text-align: right;
        }


        .subtable-2-class {}

        .subtable-1-class {}

        .custom-export {
            z-index: 5;
            border-radius: 6px;
            background-color: #fff;
            position: relative;
            right: 163px;
            position: fixed !important;
            top: 276px;
            box-shadow: 0px 0px 50px 0px rgba(82, 63, 105, 0.1);
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            width: 300px;
            padding-bottom: 20px;


        }

        @media(max-width:767px) {
            .custom-export {
                z-index: 5;
                background-color: #fff;
                right: 30px;
                position: fixed !important;
                top: 215px;
                box-shadow: 0px 0px 50px 0px rgba(82, 63, 105, 0.1);
                width: 300px;
                width: 200px;
            }
        }

        @media (min-width: 768px) {
            .custom-export {
                width: 325px;
            }
        }

    </style>

    <style>
        .sharing-sign {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: auto;
        }

        .active-sharing {
            background: #00ff28;
        }

        .inactive-sharing {
            background: #f00;
        }

        .icon-lg {
            font-size: 1.75rem !important;
        }

        .min-height-170px {
            min-height: 170px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .first-subrow-last-td,
        .second-subrow-last-td {
            text-align: right;
        }


        .w-full {
            width: 100%;
        }

        .btn.dropdown-toggle {
            height: 100%;
        }

        #DataTables_Table_1_info,
        .dataTables_empty,
        #DataTables_Table_1_paginate,
        #DataTables_Table_1_filter,
        #DataTables_Table_1_length {
            display: none !important;
        }

        .dtfc-fixed-right {
            right: 0 !important
        }

        table.dataTable tbody tr.group-color>.dtfc-fixed-right,
        table.dataTable tbody tr.group-color>.dtfc-fixed-right {
            right: 0 !important;
            background-color: #086691 !important;

        }



        .dtfc-fixed-right {}

        #to__left:hover {}

        #scroll-fixed {
            display: none;
        }

        .kt-portlet.kt-portlet--tabs+#scroll-fixed {
            display: block;
        }

        .hide_class {
            display: none
        }

        .remove-item-class {
            cursor: pointer;
        }

        .w-48 {
            width: 48%;
        }

        html body table tbody .bg-red2,
        html body table tbody.bg-red2 * {
            background-color: red !important;
            color: red !important;
        }

        .view-table-th {
            text-align: center !important;
            color: #fff !important;
        }

        .plus-class {
            margin-right: 5px;
            font-size: 20px;
            vertical-align: middle;
            color: #0849A5;
        }

        .header-tr {
            background-color: #074FA4 !important;
            /* cursor: pointer !important; */
            transition: 1s;
        }

        td.editable {
            cursor: pointer;
        }

        .header-tr:hover {
            background-color: #087383 !important;
        }





        .dataTables_scrollBody::-webkit-scrollbar {}

        .dataTables_scrollBody {}




        .dtfc-fixed-right {}

        #to__left:hover {}

        #scroll-fixed {
            display: none;
        }

        .kt-portlet.kt-portlet--tabs+#scroll-fixed {
            display: block;
        }

        .hide_class {
            display: none
        }

        .remove-item-class {
            cursor: pointer;
        }






































        /* 
			#DataTables_Table_1_wrapper #DataTables_Table_1_info , #DataTables_Table_1_wrapper .dataTables_empty
,#DataTables_Table_1_wrapper #DataTables_Table_1_paginate
,#DataTables_Table_1_wrapper #DataTables_Table_1_length
{
	display: none !important;
}
.sorting_disabled.dtfc-fixed-right
{
	right:0 !important;
} */

    </style>
    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{url('assets/media/logos/logo_va.png')}}" />
    @toastr_css
    @livewireStyles
    @yield('css')
    @stack('css')
    <style>
        #loader_id {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99999999999999999;
        }

        .text-center {
            text-align: center
        }

        .please_wait {
            text-transform: capitalize;
            font-size: 1.2rem;
            font-weight: bold;
            color: #085E99;
        }

    </style>
	
	

    <script>
        function array_sum(array) {
            return array.reduce((partialSum, item) => partialSum + item, 0)
        }

        function countHeadersInPage(selector, appendSelector) {

            let elements = document.querySelectorAll(selector);
            document.querySelector(appendSelector).setAttribute('data-value', elements.length);
        }

        function getToken() {
            return document.getElementsByTagName('body')[0].getAttribute('data-token');
        }

    </script>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body data-lang="{{app()->getLocale()}}" data-base-url="{{\Illuminate\Support\Facades\URL::to('/')}}" data-current-company-id="{{ $company->id ?? 0  }}" data-token="{{ csrf_token() }}" style="background-image: url({{url('assets/media/demos/demo4/header.jpg')}}); background-position: center top; background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
    @php
		$user = Auth()->user();
	@endphp
	{{-- <div style="width: 100%;
	height: 100%;
	position: fixed;

	justify-content: center;
	align-items: center;
	background: white;
	z-index: 8888888888888888;
	" class="text-center d-flex" id="full_loader_id">
        <img src="{{ asset('loading.gif') }}">
    <p style="margin-top: 12px;
		margin-left: 10px;" class="please_wait">Please Wait</p>
    </div> --}}

    <div class="text-center hide_class" id="loader_id">
        <img src="{{ asset('loading.gif') }}">
        <p class="please_wait">Please Wait</p>
    </div>
    <!-- begin::Page loader -->

    <!-- end::Page Loader -->

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="#">
                <img height="65px" alt="Logo" src="{{url('assets/media/logos/logo_va.png')}}" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
        </div>
    </div>

    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            {{-- SideBAr --}}
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                <!-- begin:: Header -->
                @include('layouts.topbar')
                <!-- end:: Header -->
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                    <div class="kt-content kt-content--fit-top  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Subheader -->
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title" style="font-variant: small-caps;">
                                        @yield('sub-header')
                                    </h3>
                                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                                    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                                        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-tab ">
                                            @yield('dash_nav')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-grid__item kt-grid__item--fluid">

                            <!--Begin::Dashboard 4-->

                            @yield('content')

                            <!--End::Row-->

                            <!--End::Dashboard 4-->
                        </div>

                        <!-- end:: Content -->
                    </div>
                </div>

                <!-- begin:: Footer -->
                @include('layouts.footer')

                <!-- end:: Footer -->
            </div>



            {{-- @include('layouts.sidebar') --}}



        </div>
    </div>

    <!-- end:: Page -->

    <script src="/custom/sweetalert.js"></script>


    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#366cf3"
                    , "light": "#ffffff"
                    , "dark": "#282a3c"
                    , "primary": "#5867dd"
                    , "success": "#34bfa3"
                    , "info": "#36a3f7"
                    , "warning": "#ffb822"
                    , "danger": "#fd3995"
                }
                , "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"]
                    , "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };

    </script>

    <!-- end::Global Config -->

    <!--begin:: Global Mandatory Vendors -->
    <script src="{{url('assets/vendors/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>

    <script src="{{url('assets/vendors/general/bootstrap/dist/js/bootstrap.bundle.js')}}" type="text/javascript"></script>
    {{-- <script src="{{url('assets/vendors/general/bootstrap/dist/js/bootstrap.js')}}" type="text/javascript"></script> --}}
    {{-- <script src="{{url('assets/vendors/general/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script> --}}
    <script src="{{url('assets/vendors/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
    {{-- <script src="{{url('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}" type="text/javascript"></script> --}}
    {{-- <script src="{{url('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script> --}}
    <script src="{{url('assets/vendors/general/sticky-js/dist/sticky.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/wnumb/wNumb.js')}}" type="text/javascript"></script>

    <!--end:: Global Mandatory Vendors -->
    <!--begin:: Global Optional Vendors -->
    <script src="{{url('assets/vendors/general/jquery-form/dist/jquery.form.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/block-ui/jquery.blockUI.js')}}" type="text/javascript"></script>
    {{-- <script src="{{url('assets/vendors/general/owl.carousel/dist/owl.carousel.js')}}" type="text/javascript"></script> --}}
    <script src="{{url('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js')}}" type="text/javascript"></script>
	
    <script>
        function getKeyByValue(object, value) {
            return Object.keys(object).find(key => object[key] === value);
        }
        var monthsAsNumbers = ["01", "02", "03", "04", "05", "06", "07"
            , "08", "09", "10", "11", "12"
        ];
        var formatDate = function(date, dateSeparator = '/') {
            let month = monthsAsNumbers[date.getMonth()];
            let day = ('0' + date.getDate()).slice(-2)
            // 11
            // 01
            return month + dateSeparator + day + dateSeparator + date.getFullYear();
            //  + " " + ('0' + date.getHours()).slice(-2) + ":" + ('0' + date.getMinutes()).slice(-2) + ":" + ('0' + date.getSeconds()).slice(-2) + ' ' + (date.getHours() < 12 ? 'AM' : 'PM');
        }

        function number_unformat(formattedNumber) {
            return formattedNumber.replace(/(<([^>]+)>)/gi, "").replace(/,/g, "")
        }

        function orderObjectKeys(myObj) {
            var keys = [];
            for (k in myObj) {
                if (myObj.hasOwnProperty(k)) {
                    keys.push(k);
                }
            }
            keys.sort().reverse();

            return keys;
        }

        function getPreviousElementInArray(arr, key) {
            let previous = null;
            arr.forEach((x, i) => {
                let prev = i > 0 ? arr[i - 1] : null;
                let next = i < arr.length ? arr[i + 1] : null;
                if (x == key) {
                    previous = prev;
                    return;
                }
            });

            return previous;

        }

        function get_total_of_object(object, date) {
            let total = 0;
            for (obj of object) {
                if (obj.pivot && obj.pivot.payload) {
                    var valueFormatted = JSON.parse(obj.pivot.payload)[date];
                    if (valueFormatted) {
                        if (typeof valueFormatted === 'string' || valueFormatted instanceof String) {
                            valueFormatted = valueFormatted.replace(/,/g, "");
                        }
                        total = total + parseFloat(valueFormatted);
                    }


                }
            }

            return total;
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number
                , prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
                , sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep
                , dec = (typeof dec_point === 'undefined') ? '.' : dec_point
                , s = ''
                , toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    </script>
    <!--end:: Global Optional Vendors -->


    <!--end::Global Theme Bundle -->



    <!--end::Page Vendors -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="{{url('assets/js/demo4/scripts.bundle.js')}}" type="text/javascript"></script>
    <!--begin::Page Scripts(used by this page) -->
    {{-- <script src="{{url('assets/js/demo4/pages/dashboard.js')}}" type="text/javascript"></script> --}}
    {{-- @jquery --}}
    @toastr_js
    @toastr_render
    @yield('js')

    <script src="{{url('datatable/datatable.js')}}" type="text/javascript"></script>

    @stack('js')

    <script>
        reinitializeSelect2();

    </script>
    <script>
        $(function() {
            $(document).on('change', 'select.select2-select', function(e) {
                let maxOptionsNumber = $(this).data('max-options');
                let currentSelectedOptionsNumber = $(this).find('option:selected').length;
                let labelMaxSelection = currentSelectedOptionsNumber;
                if (maxOptionsNumber) {

                    if (currentSelectedOptionsNumber > maxOptionsNumber) {
                        labelMaxSelection = maxOptionsNumber;

                        $(this).find('option:selected').each((index, value) => {
                            if ((index + 1) > maxOptionsNumber) {
                                $(value).prop('selected', false);
                            }
                        });
                        $(this).selectpicker("refresh");
                    }
                }
                $(this).closest('div[class*="col-md"]').find('.max-options-span').html('[{{ __("Selected:") }}' + labelMaxSelection + ']');

            });
        });

    </script>

    <script>
        $(document).ajaxStart(function() {
            // $('select.select2-select').prop('disabled',true);				
            $('#loader_id').removeClass('hide_class');
        });
        $(document).ajaxComplete(function() {
            $('select.select2-select').prop('disabled', false);
            $('#loader_id').addClass('hide_class');
        })

    </script>

    <script>
        $(function() {
            $('#full_loader_id').addClass('hide_class').removeClass('d-flex')
        })

    </script>

    <script>
        $(function() {
            $('.dtfc-fixed-left').on('click', function(e) {
                $('.kt_table_with_no_pagination').DataTable().columns.adjust();
            });


        })

    </script>
    <script>
        $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            jqXHR.setRequestHeader('X-CSRF-Token', getToken());



        });

    </script>

    @if(session()->has('fail'))
    <script>
        toastr.error('{{ session()->get("fail") }}')

    </script>

    @endif
	
	

	  @if(isset($errors) &&$errors&& count($errors))
				    <script>
        toastr.error('{{ session()->get("errors")->first() }}')

    </script>

    @endif

    <script>
        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }

        function hasAttribute(attr) {
            return typeof attr !== 'undefined' && attr !== false;
        }
		  

        function exportToExcel(xlsx) {



            numberOfRows = 0;
            eachInRow = 0;

            let companyName = "{{ isset($company) && isset($company->name['en']) ? $company->name['en'] : '' }}";
            if (companyName) {
                eachInRow += 1;
            }


            let reportName = $('.kt-subheader__title').html().trim() || $('.kt-portlet__head-title').html().trim();

            if (reportName) {
                companyName += (' (' + reportName + ' )');
            }
            let start_date = "{{ isset($start_date) ? $start_date : '' }}";
            let end_date = "{{ isset($end_date) ? $end_date : '' }}";
            let date = "{{ isset($date) ? $date : '' }}";
            if ((start_date && end_date) || date) {
                eachInRow += 1;
            }

            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            var downrows = eachInRow;
            var clRow = $('row', sheet);

            clRow.each(function() {
                var attr = $(this).attr('r');
                var ind = parseInt(attr);
                ind = ind + downrows;
                $(this).attr("r", ind);
            });


            $('row c ', sheet).each(function() {
                var attr = $(this).attr('r');
                var pre = attr.substring(0, 1);
                var ind = parseInt(attr.substring(1, attr.length));
                ind = ind + downrows;
                $(this).attr("r", pre + ind);
            });

            function Addrow(index, data) {
                msg = '<row  r="' + index + '">'
                for (i = 0; i < data.length; i++) {
                    var key = data[i].k;
                    var value = data[i].v;
                    msg += '<c   t="inlineStr" r="' + key + index + '" s="2">';
                    msg += '<is>';
                    msg += '<t >' + value + '</t>';
                    msg += '</is>';
                    msg += '</c>';
                }
                msg += '</row>';
                return msg;
            }
            // let visiables = [];
            let headers = [];
            currentColumn = 'A'
            currentColumnHeaders = 'A'
            rows = ' ';

            rows += Addrow(1, [{
                k: 'A'
                , v: companyName
            }]);

            if (start_date && end_date) {
                rows += Addrow(2, [{
                        k: 'A'
                        , v: 'Start Date : ' + start_date
                    }
                    , {
                        k: 'B'
                        , v: 'End Date : ' + end_date
                    }
                , ]);

            }
            if (date && !start_date) {
                rows += Addrow(2, [{
                    k: 'A'
                    , v: 'Date : ' + date
                }, ]);
            }



            sheet.childNodes[0].childNodes[1].innerHTML = rows + sheet.childNodes[0].childNodes[1].innerHTML;

        }

    </script>







    @if(isset($company) && $company->id)
    <script>
        $(document).on('click', '.delete-record-btn', function(e) {
            e.preventDefault();
            let modelName = $(this).data('model-name');
            let recordId = $(this).data('record-id');
            let tableId = $(this).data('table-id')

            Swal.fire({
                title: "{{ __('Are you sure?') }}"
                , text: "{{ __('You will not be able to revert this!') }}"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: 'rgb(0, 36, 71)'
                , confirmButtonText: '{{ __("Yes,Delete It") }}'
                , preConfirm: function() {
                    return {
                        'modelName': modelName
                        , 'recordId': recordId
                        , 'tableId': tableId
                    };
                }
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.model',['company'=>$company->id]) }}"
                        , data: {
                            "recordId": result.value.recordId
                            , 'modelName': result.value.modelName
                            , 'tableId': result.value.tableId
                        }
                        , type: "delete"
                        , success: function(response) {
                            $('#' + response.tableId).DataTable().ajax.reload(null, false);
                        }
                    });
                }
            })
        });



        $(document).on('change', '.trigger-update-select-js', function() {
            clearTimeout(wto);
            wto = setTimeout(() => {


                let startDate = $('input[name="start_date"]').val();
                let endDate = $('input[name="end_date"]').val();
                let mainType = $('input[name="main_type"]').val();
                let subType = $('input[name="type"]').val();
                let appendTo = $('#append-to').val();


                $.ajax({
                    url: "{{ route('get.type.based.on.dates',$company->id) }}"
                    , data: {
                        startDate
                        , endDate
                        , mainType
                        , subType
                        , appendTo
                    }
                    , type: "post"
                    , success: function(response) {
                        if (response.status) {
                            var options = '';
                            for (index in response.data) {
                                options += ` <option value="${index}">${response.data[index]}</option>  `
                            }
                            $(response.appendTo).empty().append(options).selectpicker("refresh");

                        }
                    }
                });


            }, getNumberOfMillSeconds());

        });

    </script>
    @endif
	
	<script>
	
	
	</script>
<script src="{{ asset('global.js') }}"></script>

@stack('js_end')
</body>

<!-- end::Body -->
</html>
