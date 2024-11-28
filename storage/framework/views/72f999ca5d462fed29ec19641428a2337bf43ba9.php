
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
     <?php if (isset($component)) { $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Table::class, ['href' => route('companySection.create'),'tableTitle' => __('Companies Table')]); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        
        <?php $__env->slot('table_header'); ?>
            <tr class="table-standard-color">
                <th><?php echo e(__('Company')); ?></th>
                <th><?php echo e(__('Company Name')); ?> </th>
                <th><?php echo e(__('Controll')); ?></th>
            </tr>
        <?php $__env->endSlot(); ?>

        
        <?php $__env->slot('table_body'); ?>
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-center">
                    <td>
                        <img class="index-img" width="100" height="100" src="<?php echo e($item->getFirstMediaUrl()); ?>" alt="image">
                        <?php if($item->getFirstMediaUrl() ): ?>
<br>

                          <a href="<?php echo e(route('remove.company.image' , [App()->getLocale()   , $item->id])); ?>" class="btn btn-secondary btn-outline-hover-danger btn-icon remove-item-class " title="Delete" s><i
                                    class="fa fa-trash"></i>
                                </a>
<?php endif; ?> 
                    </td>
                    <td><?php echo e($item->name[lang()]); ?></td>


                    <td class="kt-datatable__cell--left kt-datatable__cell " data-field="Actions" data-autohide-disabled="false">
                        <span style="overflow: visible; position: relative; width: 110px;">
                            <a type="button" class="btn btn-secondary btn-outline-hover-brand btn-icon" title="Edit" href="<?php echo e(route('companySection.edit', [$item])); ?>"><i
                                   class="fa fa-pen-alt"></i></a>

                                  

                                   <a  class="btn btn-secondary btn-outline-hover-danger btn-icon remove-item-class remove-user-class" data-id="<?php echo e($item->id); ?>" title="Delete" ><i
                                    class="fa fa-trash-alt"></i>
                                </a>


                            
                        </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__env->endSlot(); ?>
     <?php if (isset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6)): ?>
<?php $component = $__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6; ?>
<?php unset($__componentOriginale53a9d2e6d6c51019138cc2fcd3ba8ac893391c6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 




<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(url('assets/vendors/custom/datatables/datatables.bundle.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/datatables/basic/paginations.js')); ?>" type="text/javascript">
    </script>

    
    <script>
        $('.remove-user-class').on('click' , function(e){
            e.preventDefault();

            Swal.fire({
  icon: 'warning',
  title: '<?php echo e(__("Warning")); ?>',
  showConfirmButton:true,
  showCancelButton:true,
  cancelButtonText:'<?php echo e(__("Cancel")); ?>',
  text: '<?php echo e(__("Are You Sure To Delete This Company")); ?>',
}).then(()=>{
     let company_id = $(this).data('id');
            $.ajax({
                        type: 'post',
                        url: "<?php echo e(route('remove.company')); ?>",
                        data: {
                            '_token':"<?php echo e(csrf_token()); ?>",
                            'company_id':company_id,
                        },
                        success: function (data) {
                            if(data.status)
                            {
                                Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: "<?php echo e(__('Company Has Been Removed Successfully')); ?>",
                                        showConfirmButton: false,
                                        timer: 1500
                                        }).then(function(){
                                            window.location.reload();
                                            
                                        })
                            }
                        }, error: function (reject) {
                        }
                    });

})

           
        });
        
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/super_admin_view/companies/index.blade.php ENDPATH**/ ?>