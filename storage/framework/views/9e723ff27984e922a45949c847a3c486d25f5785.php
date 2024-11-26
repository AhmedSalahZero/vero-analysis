
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sub-header'); ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.main-form-title','data' => ['id' => 'main-form-title','class' => '']]); ?>
<?php $component->withName('main-form-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('main-form-title'),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('')]); ?><?php echo e($pageTitle); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
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
                <?php echo $__env->make('admin.financial-statement.view-table' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    $(function() {
        $(document).on('blur', '.editable', function() {
            var columnIndex = this._DT_CellIndex ? this._DT_CellIndex.column : 0;
            var tdData = $(this).closest('table').find('.header-th').eq(columnIndex)[0];
            var dataTableId = $(this).closest('table.main-table-class').attr('id');
            var modelName = $(this).parent().data('model-name') || $(this).data('model-name');
            var modelId = $(this).parent().data('model-id') || $(this).data('model-id');
            var columnName = $(tdData).data('db-column-name') || $(this).data('db-column-name');
            var isRelation = $(tdData).data('is-relation') || $(this).data('is-relation');
            var isCollectionRelation = $(tdData).data('is-collection-relation') || $(this).data('is-collection-relation');
            var collectionItemId = $(tdData).data('collection-item-id') || $(this).data('collection-item-id');
            var isJson = $(tdData).data('is-json');
            var relationName = $(tdData).data('relation-name') || $(this).data('relation-name');
            var data = $(this).text();

            $.ajax({
                url: "<?php echo e(route('admin.edit.table.cell',getCurrentCompanyId())); ?>"
                , data: {
                    "_token": "<?php echo e(csrf_token()); ?>"
                    , "isRelation": isRelation
                    , "columnName": columnName
                    , "relationName": relationName
                    , "data": data
                    , 'modelName': modelName
                    , 'modelId': modelId
                    , 'isJson': isJson
                    , "dataTableId": dataTableId
                    , "isCollectionRelation": isCollectionRelation
                    , "collectionItemId": collectionItemId
                }
                , type: "POST"
                , success: function(response) {
                    $('#' + response.dataTableId).DataTable().ajax.reload(null, false)
                }
            })
        });
    })

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/admin/financial-statement/view.blade.php ENDPATH**/ ?>