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


  		  

		<!--begin::Fonts -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>

			var wto ;

			function getNumberOfMillSeconds()
			{
				return 2000 ;
			}
			// window['maxOptions'] = 10 ;
			function reinitializeSelect2()
			{
				let numberOfMulteSelects  = $(document).find('select.select2-select').length ;
				 let maxOptions = [0];
				  if(numberOfMulteSelects == 1)
				 {
					 maxOptions[0] = 200 ;
					 maxOptions[1] = 0 ;
					 maxOptions[2] = 0 ;
					 maxOptions[3] = 0 ;
				 }
				 if(numberOfMulteSelects == 2)
				 {
					 maxOptions[0] = 100 ;
					 maxOptions[1] = 200 ;
					 maxOptions[2] = 0 ;
					 maxOptions[3] = 0 ;
				 }

				 if(numberOfMulteSelects == 3)
				 {
					 maxOptions[0] = 50 ;
					 maxOptions[1] = 100 ;
					 maxOptions[2] = 200 ;
					 maxOptions[3] = 0 ;
				 }

				  if(numberOfMulteSelects == 4)
				 {
					 maxOptions[0] = 50 ;
					 maxOptions[1] = 50 ;
					 maxOptions[2] = 100 ;
					 maxOptions[3] = 200 ;
				 }

				//    if(numberOfMulteSelects == 1)
				//  {
				// 	 maxOptions[0] = 100 ;
				// 	 maxOptions[1] = 0 ;
				// 	 maxOptions[2] = 0 ;
				// 	 maxOptions[3] = 0 ;
				//  }
				//  if(numberOfMulteSelects == 2)
				//  {
				// 	 maxOptions[0] = 25 ;
				// 	 maxOptions[1] = 50 ;
				// 	 maxOptions[2] = 0 ;
				// 	 maxOptions[3] = 0 ;
				//  }

				//  if(numberOfMulteSelects == 3)
				//  {
				// 	 maxOptions[0] = 25 ;
				// 	 maxOptions[1] = 25 ;
				// 	 maxOptions[2] = 50 ;
				// 	 maxOptions[3] = 0 ;
				//  }

				//   if(numberOfMulteSelects == 4)
				//  {
				// 	 maxOptions[0] = 25 ;
				// 	 maxOptions[1] = 25 ;
				// 	 maxOptions[2] = 50 ;
				// 	 maxOptions[3] = 50 ;
				//  }




	
				$(document).find('select.select2-select').each(function(index,value){
					
					let maxOption = maxOptions[index] !== undefined ? maxOptions[index] : 0 ;
					// alert(maxOption);
						$(this).selectpicker({
							  maxOptions: maxOption ,
							//   maxOptions: $(this).data('max-options') || $(this).data('max-options') == 0   ? $(this).data('max-options') : window['maxOptions'],
							  buttons: ['selectMax', 'disableAll']
						});
						$(this).data('max-options',maxOption);
						
						$(this).closest('div[class*="col-md"]').find('.max-options-select').html('[Maxium:' + maxOption + ']' );
						//  $(this).selectpicker({
         		  		//    maxOptions:maxOption,
         		 		// 	});

				})
				
			}
			
		</script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700"]
				},
				active: function() {
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

		<!--end::Global Theme Styles -->
        <style>
			#DataTables_Table_1_info,
			.dataTables_empty,
			#DataTables_Table_1_paginate,
			#DataTables_Table_1_filter,
			#DataTables_Table_1_length
			{
				display: none !important;
			}
			.dtfc-fixed-right{right:0 !important}
			table.dataTable tbody tr.group-color > .dtfc-fixed-right, table.dataTable tbody tr.group-color > .dtfc-fixed-right{
				right:0 !important;
				background-color:#086691 !important;

			}
			.dataTables_scrollBody::-webkit-scrollbar
			{
/* 				display: none;  */
			}
 			.dataTables_scrollBody 
			 {
    		 /* scrollbar-width: none; */
		 	}
	



/* {} */
			 .dtfc-fixed-right{}
			 /* .dataTable th{
				 white-space: nowrap;
    overflow: hidden;
			 } */
 #to__left:hover{
/* background-color:red */
 }
#scroll-fixed{
	display:none ; 
}
 .kt-portlet.kt-portlet--tabs+#scroll-fixed{
	 display:block ;
 }
 .hide_class{display:none}
			/* .dataTables_scrollHeadInner {
				padding-right:17px !important;
			} */
            /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */
            /* .dataTables_wrapper{max-width: 100%;  padding-bottom: 50px !important;overflow-x: overlay;max-height: 4000px;} */

			.remove-item-class
			{
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
        <?php echo toastr_css(); ?>
        <?php echo \Livewire\Livewire::styles(); ?>

        <?php echo $__env->yieldContent('css'); ?>
		<?php echo $__env->yieldPushContent('css'); ?>
		<style>
			#loader_id{
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50% , -50%);
				z-index: 10;
			}
			.text-center{text-align:center}
			.please_wait{text-transform:capitalize;font-size:1.2rem;font-weight:bold;color:#085E99;}
		</style>

		<script>
			function getToken()
			{
				return document.getElementsByTagName('body')[0].getAttribute('data-token');
			}
			
		</script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body data-token="<?php echo e(csrf_token()); ?>" style="background-image: url(<?php echo e(url('assets/media/demos/demo4/header.jpg')); ?>); background-position: center top; background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
	<div class="text-center hide_class" id="loader_id" >
		<img src="<?php echo e(asset('loading.gif')); ?>">
		<p class="please_wait">Please Wait</p>
	</div>
		<!-- begin::Page loader -->

		<!-- end::Page Loader -->

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="demo4/index.html">
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
                                        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                                            class="la la-close"></i></button>
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


  			  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#366cf3",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin:: Global Mandatory Vendors -->
		<script src="<?php echo e(url('assets/vendors/general/jquery/dist/jquery.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/popper.js/dist/umd/popper.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/bootstrap/dist/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/js-cookie/src/js.cookie.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/moment/min/moment.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/sticky-js/dist/sticky.min.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(url('assets/vendors/general/wnumb/wNumb.js')); ?>" type="text/javascript"></script>

		<!--end:: Global Mandatory Vendors -->
        <!--begin:: Global Optional Vendors -->
        <script src="<?php echo e(url('assets/vendors/general/jquery-form/dist/jquery.form.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/block-ui/jquery.blockUI.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/owl.carousel/dist/owl.carousel.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(url('assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js')); ?>" type="text/javascript"></script>


		<!--end:: Global Optional Vendors -->


		<!--end::Global Theme Bundle -->



		<!--end::Page Vendors -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="<?php echo e(url('assets/js/demo4/scripts.bundle.js')); ?>" type="text/javascript"></script>
		<!--begin::Page Scripts(used by this page) -->
		<script src="<?php echo e(url('assets/js/demo4/pages/dashboard.js')); ?>" type="text/javascript"></script>
        
        <?php echo toastr_js(); ?>
        <?php echo app('toastr')->render(); ?>
        <?php echo $__env->yieldContent('js'); ?>
		<?php echo $__env->yieldPushContent('js'); ?>

		<script>
			reinitializeSelect2();
			
		</script>
		<script>
			$(function(){
				$(document).on('change','select.select2-select', function (e) {
					let maxOptionsNumber = $(this).data('max-options') ;
					let currentSelectedOptionsNumber = $(this).find('option:selected').length;
					let labelMaxSelection = currentSelectedOptionsNumber ;
					if(maxOptionsNumber)
					{

						if(currentSelectedOptionsNumber > maxOptionsNumber )
						{
							labelMaxSelection = maxOptionsNumber ;

							$(this).find('option:selected').each((index,value)=>{
								if((index+1) > maxOptionsNumber )
								{
									$(value).prop('selected',false);
								}
							});
							$(this).selectpicker("refresh");
						}
					}
					$(this).closest('div[class*="col-md"]').find('.max-options-span').html('[Selected:' +labelMaxSelection + ']');

					}	);
			});

		</script>

		<script>
			$(document).ajaxStart(function(){
				$('select.select2-select').prop('disabled',true);				
				$('#loader_id').removeClass('hide_class');
			});
			$(document).ajaxComplete(function(){
				$('select.select2-select').prop('disabled',false);
					$('#loader_id').addClass('hide_class');
			})


			
		</script>

		<script>
			$(function(){
				$('.dtfc-fixed-left').on('click',function(e){
					$('.kt_table_with_no_pagination').DataTable().columns.adjust();
				})
			})
		</script>
		<script>
				$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
						  jqXHR.setRequestHeader('X-CSRF-Token', getToken());
					});
		</script>

<?php if(session()->has('fail')): ?>
		<script>
toastr.error('<?php echo e(session()->get("fail")); ?>')
		</script>

		<?php endif; ?> 

		<script>
			
		</script>
	</body>

	<!-- end::Body -->
</html>
<?php /**PATH C:\laragon\www\VeroAnalysis\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>