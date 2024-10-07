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


<script>
let pageLoaded = false ;
</script>
    <style>
	.width-9 {
        max-width: initial !important;
        width: 9% !important;
        flex: initial !important;
    }
	.flex-1{
		flex:1;
	}
        #show-notification-here {
            width: 50%;
            background-color: red;

        }
.notification-span{
	background: #ff0000ab;
    color: white;
    font-family: 'Poppins';
    font-weight: bold;
    padding: 1px;
}
    </style>
    <style>
        .w-60-percentage {
            width: 60% !important;
        }
.w-50-percentage {
            width: 50% !important;
        }
        .w-40-percentage {
            width: 40% !important;
        }

        .w-20-percentage {
            width: 20% !important;

        }

        .flex-tabs {
            display: flex;
            gap: 10px;
        }

        .text-green {
            color: green !important;
        }

        .text-red {
            color: red !important;
        }

        .show-class-js {
            display: block !important;
        }

        .table-condensed th {
            background-color: white !important;
        }

        input,
        select,
        .dropdown-toggle.bs-placeholder {
            border: 1px solid #CCE2FD !important;
        }

        .flex-2 {
            flex: 2 !important;
        }

        .text-main-color {
            color: #0742A6 !important
        }

        ::placeholder {
            color: lightgray !important;
            font-weight: 100;
        }

        .visibility-hidden {
            visibility: hidden !important;
        }

        .income-statement-table {}

        .btn-border-radius {
            border-radius: 10px !important;
        }

        .income-statement-table .main-level-tr td,
        .income-statement-table .main-level-tr th {
            background-color: #9FC9FB !important;
            border: 1px solid #fff;

        }

        .income-statement-table .main-level-tr td:first-of-type,
        .income-statement-table .main-level-tr td:nth-of-type(2),
        .income-statement-table .main-level-tr th:first-of-type,
        .income-statement-table .main-level-tr th:nth-of-type(2) {
            background-color: #9FC9FB !important;
        }

        .income-statement-table .sub-level-tr td,
        .income-statement-table .sub-level-tr th {
            background-color: #fff !important;
        }

        input,
        select,
        .filter-option-inner-inner {
            font-weight: 600 !important;
            color: black !important;
        }

        html body tr.all-td-white td {
            background-color: white !important;
        }

        .font-size-1-25rem {
            font-size: 1.25rem !important;
        }

        .font-size-15px {
            font-size: 15px !important
        }

        .label-clr {
            color: #646c9a !important;
        }

        .installment-section {
            background: #F2F2F2 !important;
            padding-top: 10px;
            margin-bottom: 10px !important;
        }

        .label-size {
            font-size: 1.25rem !important;
        }

        .pr-6rem {
            padding-right: 6rem;
        }

        .pointer-events-none {
            pointer-events: none;
        }

        .dtfh-floatingparent.dtfh-floatingparenthead {
            top: 59px !important;
        }

        .table-for-collection-policy tr:nth-child(odd) {
            background-color: white !important;
        }

        .percentage-weight {
            font-weight: bold;
            margin-right: 10px;
        }





        .small-caps {
            font-variant: small-caps;
        }

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

        .w-full {
            width: 100%;
        }

        .btn.dropdown-toggle {
            height: 100%;
        }

        /* .dropdown-toggle{} */

    </style>
    <style>
        .custom--i-class-parent {
            position: relative;
            padding-left: 20px;
            padding-right: 20px;
        }

        .custom--i-class {
            margin-top: 0 !important;
            position: absolute !important;
            top: 50%;
            left: 7px !important;
            transform: rotate(90deg) translateY(-50%) !important;
            float: none !important;
        }

        .custom-i-class {
            position: absolute !important;
            left: -15px !important;
            top: 13px !important;
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

        .font-weight-bold {
            font-weight: bold !important;
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
        .dtfc-right-top-blocker {
            display: none !important;
        }

        #kt_subheader {
            z-index: 1;
        }

        .font-size-1-25rem {
            font-size: 1.3rem !important;
        }

        .border-none {
            border: none !important;
        }

        .font-size-1.6rem {
            font-size: 1.6rem !important;
        }

        thead th {
            text-align: center !important;

        }

        body .kt-subheader {
            padding: 15px 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
        }

    </style>
    <style>
        #add-row {
            border-color: green;
            background-color: green;
            color: white;
        }

        .tooltip-inner {
            text-align: left !important;
        }

        .font-1-5 {
            font-size: 1.5rem !important;
        }

    </style>
    <?php if(in_array('Result',Request()->segments()) && in_array('SalesGathering',Request()->segments())): ?>
    <style>
        tr td:first-of-type {
            white-space: normal !important;
        }

    </style>
    <?php endif; ?>
    <style>
        .max-w-classes {
            width: 350px !important;
            min-width: 350px !important;
            max-width: 350px !important;
            white-space: normal !important;
        }

    </style>
    <?php if(in_array('TwoDimensionalBreakdown',Request()->segments())): ?>
    <style>
        .kt_table_with_no_pagination td {
            width: 110px !important;
            min-width: 110px !important;
            max-width: 110px !important;
            white-space: normal !important;
        }

    </style>

    <?php endif; ?>

    <?php if(
    !in_array('uploading',Request()->segments())&&
    !in_array('salesGatheringImport',Request()->segments())&&
    !in_array('SalesForecastQuantity',Request()->segments()) && !in_array('dashboard',Request()->segments()) && !in_array('SalesReport',Request()->segments())&&!in_array('Comparing',Request()->segments())&&!in_array('SalesBreakdownAnalysis',Request()->segments())&&!in_array('SalesDiscountSalesBreakdownAnalysis',Request()->segments()) && Request()->route()->getName() != 'salesGathering.index' && !in_array('ForecastedSalesValues',Request()->segments())): ?>
    <style>
        .table-active:not(.remove-max-class) th:first-of-type,
        .group-color th:first-of-type,
        .group-color td:first-of-type,
        .kt_table_with_no_pagination th:first-of-type,
        .kt_table_with_no_pagination_no_fixed_right th:first-of-type .kt_table_with_no_pagination_no_fixed_right td:first-of-type {
            width: 350px !important;
            min-width: 350px !important;
            max-width: 350px !important;
            white-space: normal !important;
        }

    </style>
    <?php endif; ?>

    <style>
        .table-title {
            color: red;

        }

        .edit-modal-icon {

            color: #046187 !important;
        }

        .fas.fa-trash-alt {
            color: #ea1b1b !important;
        }

    </style>

    

    <!--begin::Fonts -->
    <script src="<?php echo e(asset('custom/webfont.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/helper.js')); ?>"></script>
    
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
            let stringToReplaceEn = "[(] <?php echo e('Quantity'); ?> [)]$"
            let stringToReplaceAr = "[(] <?php echo e(__('Quantity')); ?> [)]$"
            let regEn = new RegExp(stringToReplaceEn, "g")
            let regAr = new RegExp(stringToReplaceAr, "g")
            return str.replace ? str.replace(regEn, '').replace(regAr, '').trim() : str

        }

        function isQuantitySubItem(str) {
            return str.endsWith("<?php echo e(quantityIdentifier); ?>") || str.endsWith("<?php echo e(__(quantityIdentifier)); ?>")
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

                if ($(this).selectpicker) {

                    $(this).selectpicker({
                        maxOptions: maxOption,
                        //   maxOptions: $(this).data('max-options') || $(this).data('max-options') == 0   ? $(this).data('max-options') : window['maxOptions'],
                        buttons: ['selectMax', 'disableAll']
                    });
                    $(this).data('max-options', maxOption);
                }

                $(this).closest('div[class*="col-md"]').find('.max-options-select').html('[<?php echo e(__("Max:")); ?>' + maxOption + ']');

            })
            $(document).find('select.select2-select2').each(function(index, value) {
                let maxOption = maxOptions[index] !== undefined ? maxOptions[index] : 0;

                if ($(this).selectpicker) {

                    $(this).selectpicker({
                        maxOptions: maxOption,
                        //   maxOptions: $(this).data('max-options') || $(this).data('max-options') == 0   ? $(this).data('max-options') : window['maxOptions'],
                    });
                    $(this).data('max-options', maxOption);
                }


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
    

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->
    <link href="<?php echo e(url('assets/vendors/general/tether/dist/css/tether.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/nouislider/distribute/nouislider.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css')); ?>" rel="stylesheet" type="text/css" />
    
    
    <link href="<?php echo e(url('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/custom/vendors/flaticon/flaticon.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/custom/vendors/flaticon2/flaticon.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="<?php echo e(url('assets/css/demo4/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('datatable/datatable.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <style>	
		.th-main-color{
			        background-color: #0742A6 !important; 
					color:white !important ;
		}
        .bg-green {
            background-color: green;
        }

        .border-green {
            border-color: green;
        }

        .bg-red {
            background-color: red;
        }

        .border-red {
            background-color: green;
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



    <?php if( !in_array('financial-statement',Request()->segments()) ): ?>
    <style>
        label {
            font-weight: 700 !important;
            font-size: 1rem !important;
            color: #646c9a !important;
        }

    </style>
    <?php endif; ?>
    <style>
        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        table:not(.exclude-table) tbody tr:not(.table-active):not(.active-style):not(.is-rate):not(.is-sub-row):not(.group-color)>td:not(.dtfc-fixed-left):not(.active-style):not(.exclude-td):not(.disabled.day) {
            color: black !important;
            font-weight: bold !important;
        }
td{
	vertical-align:middle !important;
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
    <link rel="shortcut icon" href="<?php echo e(url('assets/media/logos/logo_va.png')); ?>" />
    
    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
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
<body data-lang="<?php echo e(app()->getLocale()); ?>" data-base-url="<?php echo e(\Illuminate\Support\Facades\URL::to('/')); ?>" data-current-company-id="<?php echo e($company->id ?? 0); ?>" data-token="<?php echo e(csrf_token()); ?>" style="background-image: url(<?php echo e(url('assets/media/demos/demo4/header.jpg')); ?>); background-position: center top; background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
    <?php
    $user = Auth()->user();
    ?>
    

    <div class="text-center hide_class" id="loader_id">
        <img src="<?php echo e(asset('loading.gif')); ?>">
        <p class="please_wait"><?php echo e(__('Please Wait')); ?></p>
    </div>
    <!-- begin::Page loader -->

    <!-- end::Page Loader -->

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="#">
                <img height="65px" alt="Logo" src="<?php echo e(url('assets/media/logos/logo_va.png')); ?>" />
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
            
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <!-- begin:: Header -->
                <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php if(isset($company)): ?>
				<?php $__currentLoopData = \App\Notification::getAllMainTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificationMainType => $notificationMainTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make('notifications.popup',['notificationMainType'=>$notificationMainType,'notificationMainTitle'=>$notificationMainTitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?> 
                <!-- end:: Header -->
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                    <div class="kt-content kt-content--fit-top  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Subheader -->
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title" style="font-variant: small-caps;">
                                        <?php echo $__env->yieldContent('sub-header'); ?>
                                    </h3>
                                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                                    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                                        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-tab ">
                                            <?php echo $__env->yieldContent('dash_nav'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-grid__item kt-grid__item--fluid">

                            <!--Begin::Dashboard 4-->

                            <?php echo $__env->yieldContent('content'); ?>

                            <!--End::Row-->

                            <!--End::Dashboard 4-->
                        </div>

                        <!-- end:: Content -->
                    </div>
                </div>

                <!-- begin:: Footer -->
                <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <!-- end:: Footer -->
            </div>



            



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
    <script src="<?php echo e(url('assets/vendors/general/jquery/dist/jquery.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/popper.js/dist/umd/popper.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(url('assets/vendors/general/bootstrap/dist/js/bootstrap.bundle.js')); ?>" type="text/javascript"></script>
    
    
    <script src="<?php echo e(url('assets/vendors/general/js-cookie/src/js.cookie.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/moment/min/moment.min.js')); ?>" type="text/javascript"></script>
    
    
    <script src="<?php echo e(url('assets/vendors/general/sticky-js/dist/sticky.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/wnumb/wNumb.js')); ?>" type="text/javascript"></script>

    <!--end:: Global Mandatory Vendors -->
    <!--begin:: Global Optional Vendors -->
    <script src="<?php echo e(url('assets/vendors/general/jquery-form/dist/jquery.form.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/block-ui/jquery.blockUI.js')); ?>" type="text/javascript"></script>
    
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js')); ?>" type="text/javascript"></script>

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
    <script src="<?php echo e(url('assets/js/demo4/scripts.bundle.js')); ?>" type="text/javascript"></script>
    <!--begin::Page Scripts(used by this page) -->
    
    
    
    <?php echo $__env->yieldContent('js'); ?>

    <script src="<?php echo e(url('datatable/datatable.js')); ?>" type="text/javascript"></script>

    <?php echo $__env->yieldPushContent('js'); ?>

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
                $(this).closest('div[class*="col-md"]').find('.max-options-span').html('[<?php echo e(__("Selected:")); ?>' + labelMaxSelection + ']');

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
            if ($('select.select2-select').selectpicker) {
                $('select.select2-select').selectpicker('refresh');

            }
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

    <?php if(session()->has('fail')): ?>
    <script>
        toastr.error('<?php echo e(session()->get("fail")); ?>')

    </script>

    <?php endif; ?>


    <?php if(isset($errors) &&$errors&& count($errors)): ?>
    <script>
        toastr.error('<?php echo e(session()->get("errors")->first()); ?>')

    </script>

    <?php endif; ?>

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

            let companyName = "<?php echo e(isset($company) && isset($company->name['en']) ? $company->name['en'] : ''); ?>";
            if (companyName) {
                eachInRow += 1;
            }



            let reportName = $('.kt-subheader__title').html().trim() || $('.kt-portlet__head-title').html().trim();
            if ($('#report__title_for_labeling').length) {
                companyName += ' (' + $('#report__title_for_labeling').val() + ' )';
            } else if (reportName) {
                companyName += ' (' + reportName + ' )';
            }


            let start_date = "<?php echo e(isset($start_date) ? $start_date : ''); ?>";
            let end_date = "<?php echo e(isset($end_date) ? $end_date : ''); ?>";
            let date = "<?php echo e(isset($date) ? $date : ''); ?>";
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




    <?php if(isset($company) && $company->id): ?>
    <script>
	
		
$(document).on('change','.update-exchange-rate',function(){

	if(!pageLoaded){
		return 
	}
	const fromCurrency = $('select.current-invoice-currency').val()
	let toCurrency = $('input[type="hidden"].to-currency').val() 
	toCurrency = toCurrency ? toCurrency : $('select.receiving-currency-class').val();
	const date = $('.exchange-rate-date').val()
	console.log(fromCurrency,toCurrency,date);
	const companyId = $('body').data('current-company-id')
	const lang = $('body').data('lang')
	const url = '/' + lang + '/' + companyId + '/get-exchange-rate-for-date-and-currencies/'
	if(fromCurrency == toCurrency  ){
		$('.exchange-rate-class').val(1).trigger('change')
		return 
	}

	$.ajax({
		url,
		data:{
			fromCurrency,
			toCurrency,
			date
		},
		success:function(res){
			exchangeRate = res.exchange_rate ;
		
			$('.exchange-rate-class').val(exchangeRate).trigger('change')
		}
	})
})
	





        $(document).on('click', '.js-mark-notifications-as-read', function() {
            $.ajax({
                url: "<?php echo e(route('mark.notifications.as.read',['company'=>$company->id])); ?>"
            , })

        })

    </script>

    <?php endif; ?>
	<?php if(!isset($model) && !isset($singleModel) ): ?>
<script>

	$('select.current-invoice-currency.update-exchange-rate').trigger('change')
</script>	
	<?php endif; ?>
	
	
    <?php if(isset($company) && $company->id): ?>
    <?php if(isset($modelName) && cacheHas(generateCacheFailedName($company->id , auth()->user()->id , $modelName ))): ?>
    <script>
        Swal.fire({
            title: "<?php echo e(__('Error While Importing Excel File')); ?>"
            , text: "<?php echo e(CacheGetAndRemove(generateCacheFailedName($company->id , auth()->user()->id,$modelName ))); ?>"
            , icon: 'error'
        });

    </script>
    <?php endif; ?>
    <script>
        $(document).on('click', '.delete-record-btn', function(e) {
            e.preventDefault();
            let modelName = $(this).data('model-name');
            let recordId = $(this).data('record-id');
            let tableId = $(this).data('table-id')

            Swal.fire({
                title: "<?php echo e(__('Are you sure?')); ?>"
                , text: "<?php echo e(__('You will not be able to revert this!')); ?>"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: 'rgb(0, 36, 71)'
                , confirmButtonText: '<?php echo e(__("Yes,Delete It")); ?>'
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
                        url: "<?php echo e(route('delete.model',['company'=>$company->id])); ?>"
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

                // #FIXME:first start date and and end date , second start end
                let startDate = $('input[name="start_date"]').val();
                let endDate = $('input[name="end_date"]').val();
                let mainType = $('input[name="main_type"]').val();
                let subType = $('input[name="type"]').val();
                let appendTo = $('#append-to').val();
                let isIntervalComarping = $('#report_type').val() === 'comparing'
                if (isIntervalComarping) {
                    let firstStartDate = $('#report_type').closest('.kt-portlet__body').find('input[name="start_date"]').val();
                    let secondStartDate = $('#report_type').closest('.kt-portlet__body').find('input[name="start_date_second"]').val();
                    let firstEndDate = $('#report_type').closest('.kt-portlet__body').find('input[name="end_date"]').val();
                    let secondEndDate = $('#report_type').closest('.kt-portlet__body').find('input[name="end_date_second"]').val();
                    if (Date.parse(firstStartDate) <= Date.parse(secondStartDate)) {
                        startDate = firstStartDate;
                    } else {
                        startDate = secondStartDate;
                    }
                    if (Date.parse(firstEndDate) >= Date.parse(secondEndDate)) {
                        endDate = firstEndDate;
                    } else {
                        endDate = secondEndDate;
                    }


                }


                $.ajax({
                    url: "<?php echo e(route('get.type.based.on.dates',$company->id)); ?>"
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
    <?php endif; ?>


    <script src="<?php echo e(asset('global.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('js_end'); ?>
    <script>
        $('#report_type[name="report_type"]').on('change', function() {
            $('#report_type[name="report_type"]').closest('.kt-portlet').find('input').trigger('change')
        })
        $('#report_type[name="report_type"]').closest('.kt-portlet').find('input').trigger('change')

    </script>

    <script>


    </script>
    <script>
        $(function() {
            $(document).on('click', '.filter-btn-class', function(e) {
                e.preventDefault();
                let datatableInstance = $(this).data('datatable-id');
                $('#' + datatableInstance).DataTable().ajax.reload(null, false);
            });
            $(document).on('click', function(e) {
                // close opened custom modal [for filter and export btn]
                let target = e.target;
                if (!$(target).closest('.close-when-clickaway').length && !$(target).closest('.do-not-close-when-click-away').length) {
                    $('.close-when-clickaway').addClass('d-none');
                }
            });



            $(document).on('click', '.submit-form-btn', function(e) {
                e.preventDefault();

                // Validate form before submit
                form = $(this).closest('form')[0]

                var formData = new FormData(form);

              //  this.disabled = true;
                $.ajax({
                    type: "POST"
                    , url: $(form).attr('action')
                    , data: formData
                    , cache: false
                    , contentType: false
                    , processData: false
                    , success: function(res) {
						console.log('ress')
						console.log(res)
				
                        if (res.reloadCurrentPage) {
                            return window.location.reload()

                        }
                        if (res.redirectTo) {
							console.log('redirect',res.redirectTo)
                            window.location.href = res.redirectTo;
                            return
                        }
                        if (res.status) {
                            if (res.showAlert) {

                                Swal.fire({
                                    icon: 'success'
                                    , title: res.message
                                    , buttonsStyling: false
                                    , customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                    // text: successMessage,
                                }).then(function() {
                                    $('.submit-form-btn').disabled = false;
                                    Swal.fire({
                                        text: "Form has been successfully submitted!"
                                        , icon: "success"
                                        , buttonsStyling: false
                                        , confirmButtonText: "Ok, got it!"
                                        , customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            // Hide modal
                                            // modal.hide();

                                            // Enable submit button after loading
                                            $('.submit-form-btn').prop('disabled', false);

                                            // Redirect to customers list page
                                            // window.location.location = "";
                                        }
                                    })

                                })
                            } else {
                                $('.submit-form.btn').prop('disabled', false);
                                window.location.href = "<?php echo e(route('admin.view.revenue.business.line',getCurrentCompany() ? getCurrentCompany()->getIdentifier( ) : 0 )); ?>"
                            }

                        } else {
                            $('#submit-form-btn').prop('disabled', false)

                            Swal.fire({
                                icon: 'error'
                                , title: res.message,

                            })
                        }
                    }
                    , error: function(res) {
                        let title = '<?php echo e(__("Something Went Wrong")); ?>';
                        if (res.responseJSON && res.responseJSON.message) {
                            title = res.responseJSON.message;
                        }
                        $('.submit-form-btn').prop('disabled', false)
                        let message = null;
                        if (res.responseJSON && res.responseJSON.errors) {
                            message = res.responseJSON.errors[Object.keys(res.responseJSON.errors)[0]][0]
                        }

                        Swal.fire({
                            icon: 'error'
                            , title: title
                            , text: message

                        })


                    }
                })



            });

            $(document).on('change', '.trigger-select-class', handleAddNewField);
            $(document).on('click', '.trigger-select-class + button + .dropdown-menu div.inner', handleAddNewField);

            function handleAddNewField(e) {
                var id = $(this).data('trigger-id') || $(this).closest('.dropdown.trigger-select-class').find('.trigger-select-class').data('trigger-id');
                var optionValue = $(this).val() || $(this).closest('.dropdown.trigger-select-class').find('.trigger-select-class').val();
                if (id == 'child-trigger-1' && optionValue == 'Add New') {
                    $('.child-trigger').removeClass('d-none');
                    $('#' + id).removeClass('d-none');
                } else if (id == 'child-trigger-2' && optionValue == 'Add New') {
                    $('.child-trigger').removeClass('d-none');
                    $('.business_line_name').addClass('d-none');
                } else if (id == 'child-trigger-3' && optionValue == 'Add New') {
                    $('.child-trigger').removeClass('d-none');
                    $('.business_line_name').addClass('d-none');
                    $('.service_category_name').addClass('d-none');
                } else {
                    $('.child-trigger').addClass('d-none');
                }
            }
            $('select.trigger-select-class.revenue_business_line_class').trigger('change');


        });

    </script>

    <script>
        function getDiffBetweenTwoDateInDays(firstDateAsString, secondDateAsString) {
            const date1 = new Date(firstDateAsString);
            const date2 = new Date(secondDateAsString);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays
        }

    </script>

    <?php if($errors->any()): ?>
    <script>
        Swal.fire({
            title: "<?php echo e(__('Error')); ?>"
            , text: "<?php echo e($errors->first()); ?>"
            , icon: 'error'
        });

    </script>

    <?php endif; ?>

    <?php if(session()->has('fail')): ?>
    <script>
        Swal.fire({
            title: "<?php echo e(__('Error')); ?>"
            , text: "<?php echo e(session()->get('fail')); ?>"
            , icon: 'error'
        });

    </script>

    <?php endif; ?>

    <?php if(session()->has('success')): ?>
    <script>
        Swal.fire({
            title: "<?php echo e(__('Success')); ?>"
            , text: "<?php echo e(session()->get('success')); ?>"
            , icon: 'success'
        });

    </script>

    <?php endif; ?>


    <div class="modal fade " id="notifications-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Notification Detail')); ?></h5>
                    <button type="button" class="close" data-dismiss-modal-3="modal3" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " >
                    <h3 class="main-form-title " id="body-for-notification">
						
					</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss-modal-3="modal3"><?php echo e(__('Close')); ?></button>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).on('click','[data-enlarge-content-js]',function(e){
	const id = $(this).attr('data-id')
	const content = $(this).find('[data-notification-content-id="'+id+'"]').text()
	$('#body-for-notification').html(content)
	$('#body-for-notification').closest('.modal').modal('show')
})
$('button[data-dismiss-modal-3="modal3"]').click(function () {

		$(this).closest('#notifications-modal').modal('hide');
	});
</script>
<script>
$(function(){
	$('.trigger-change-after-page-open').trigger('change')
})
</script>
<script>
	$('.inner-modal-class').on('show.bs.modal',function(){
		$('.modal:not(.inner-modal-class)').modal('hide')
	})
</script>

<script>
$(document).on('change','.checkbox-for-row',function(e){
	let isChecked = $(this).is(':checked')
	if(isChecked){
		
		$(this).closest('tr').find('.checkbox-for-permission').prop("checked", true).prop('disabled',false)
	}else{
		$(this).closest('tr').find('.checkbox-for-permission').prop("checked", false).prop('disabled',true)
	}
})
</script>



<script>
$('#kt_datepicker_max_date_is_today').datepicker({
 autoclose: true,
 todayHighlight: true,
   orientation: "bottom left",
// format: 'mm/dd/yyyy',
 endDate: new Date(),
 rtl:false
});

</script>
<script>
$(function(){
	pageLoaded = true;
})
</script>


</body>

<!-- end::Body -->
</html>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/layouts/dashboard.blade.php ENDPATH**/ ?>