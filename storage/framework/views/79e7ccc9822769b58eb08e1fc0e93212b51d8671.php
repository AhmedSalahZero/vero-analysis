        
        <form <?php echo e($attributes->merge(['class'=>'kt-form kt-form--label-right'])); ?>  enctype="multipart/form-data" >
        <?php echo csrf_field(); ?> 
        <?php echo $slot; ?>

        
        </form>

        <?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/body.blade.php ENDPATH**/ ?>