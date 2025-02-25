<?php
use App\Models\NonBankingService\LeasingCategory;
?>
<?php $__env->startSection('css'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.styles.commons','data' => []]); ?>
<?php $component->withName('styles.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<link rel="stylesheet" href="/custom/css/non-banking-services/common.css">
<link rel="stylesheet" href="/custom/css/non-banking-services/leasing-revenue-stream-breakdown.css">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($title); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 



<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">



        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="d-flex align-items-center ">
                            <h3 class="font-weight-bold form-label kt-subheader__title small-caps mr-5" style=""> <?php echo e($title); ?> </h3>
                        </div>
                    </div>
                    <div class="col-md-2 text-right">
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.show-hide-btn','data' => ['query' => '.leasing-revenue-stream-category']]); ?>
<?php $component->withName('show-hide-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('.leasing-revenue-stream-category')]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                    </div>
                </div>
                <div class="row">
                    <hr style="flex:1;background-color:lightgray">
                </div>
                <div class="row leasing-revenue-stream-category">

                    <div class="form-group row" style="flex:1;">
                        <div class="col-md-12 mt-3" data-repeater-row=".leasing-revenue-stream-category">

                            <form id="<?php echo e(LeasingCategory::LEASING_CATEGORY_FORM_ID); ?>" class="kt-form kt-form--label-right" method="POST" enctype="multipart/form-data" action="<?php echo e(isset($disabled) && $disabled ? '#' :  $storeRoute); ?>">

                                <input type="hidden" name="company_id" value="<?php echo e(getCurrentCompanyId()); ?>">
                                <input type="hidden" name="creator_id" value="<?php echo e(\Auth::id()); ?>">

                                <div id="leasingCategories" class="leasing-repeater-parent">
                                    <div class="form-group2  m-form__group2 row">
                                        <div data-repeater-list="leasingCategories" class="col-lg-12">

                                            <?php echo $__env->make('non_banking_services.leasing-categories._repeater' , [

                                            'tableId'=>'leasingCategories',
                                            'isRepeater'=>true ,
                                            'canAddNewItem'=>true ,
                                            'model'=>$model


                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 text-right">
                                        <input type="submit" name="save-and-continue" class="btn active-style save-form" value="<?php echo e(__('Save & Continue')); ?>">
                                    </div>
                                </div>
                            </form>

                        </div>


                    </div>

                </div>
            </div>

        </div>



    </div>
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('js'); ?>
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.js.commons','data' => []]); ?>
<?php $component->withName('js.commons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

    <script>


    </script>

    <script>
        $(document).on('click', '.save-form', function(e) {
            e.preventDefault(); {

                const hasSalesChannel = $('#add-sales-channels-share-discount-id:checked').length

                let canSubmitForm = true;
                let errorMessage = '';
                let messageTitle = 'Oops...';



                if (!canSubmitForm) {
                    Swal.fire({
                        icon: "warning"
                        , title: messageTitle
                        , text: errorMessage
                    , })

                    return;
                }

                let formId = $(this).closest('form').attr('id')

                let form = document.getElementById(formId);
                var formData = new FormData(form);
                formData.append('submitBtnType', formId)

                $('.save-form').prop('disabled', true);


                $.ajax({
                    cache: false
                    , contentType: false
                    , processData: false
                    , url: form.getAttribute('action')
                    , data: formData
                    , type: form.getAttribute('method')
                    , success: function(res) {
                        $('.save-form').prop('disabled', false)

                        Swal.fire({
                            icon: 'success'
                            , title: res.message,

                        });

                        window.location.href = res.redirectTo;




                    }
                    , complete: function() {
                        $('#enter-name').modal('hide');
                        $('#name-for-calculator').val('');

                    }
                    , error: function(res) {
                        $('.save-form').prop('disabled', false);
                        $('.submit-form-btn-new').prop('disabled', false)
                        Swal.fire({
                            icon: 'error'
                            , title: res.responseJSON.message
                        , });
                    }
                });
            }
        })

    </script>

    <script>
        $('.use-rooms:checked').trigger('change');

    </script>

    <script>
        $(document).find('.datepicker-input').datepicker({
            dateFormat: 'mm-dd-yy'
            , autoclose: true
        })
        $(document).on('change', '.can-not-be-removed-checkbox', function() {
            $(this).prop('checked', true)
        })

        $(document).on('click', '.show-hide-repeater', function() {
            const query = this.getAttribute('data-query')
            $(query).fadeToggle(300)

        })
        $(document).on('change', '.not-allowed-duplication-in-selection-inside-repeater', function() {
            const val = $(this).val()
            const currentSelect = this
            const currentSelectedOption = $(currentSelect).find('option[value="' + val + '"]')
            const commonParent = $(this).closest('[data-repeater-list]')
            // let selectItems = []
            // $(commonParent).find('select').each(function(index,select){
            // 	selectItems.push($(select).val())
            // })
            $(commonParent).find('select').each(function(index, select) {
                if (select != currentSelect) {
                    if ($(select).find('option[value="' + val + '"]:selected').length) {
                        alert('This Item has been choosen before')
                        $(currentSelect).val('').trigger('change')

                    }

                    //.prop('disabled',true).attr('title','This Item has been choosen before')
                } else {}
            })
        })

        $(document).on('change', '.can-be-toggle-show-repeater-btn', function() {
            let val = $(this).is(':checked')
            let repeaterQuery = $(this).attr('data-repeater-query')
            if (!val) {
                $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').addClass('disabled');
                $('[data-repeater-row="' + repeaterQuery + '"]').fadeOut(300)
                $(this).val(0)
            } else {
                $('.show-hide-repeater[data-query="' + repeaterQuery + '"]').removeClass('disabled');
                $('[data-repeater-row="' + repeaterQuery + '"]').fadeIn(300)
                $(this).val(1)

            }

        })
        $('.can-be-toggle-show-repeater-btn').trigger('change')

    </script>

    <script src="/custom/js/non-banking-services/common.js"></script>
    <script src="/custom/js/non-banking-services/revenue-stream-breakdown.js"></script>
    
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/non_banking_services/leasing-categories/form.blade.php ENDPATH**/ ?>