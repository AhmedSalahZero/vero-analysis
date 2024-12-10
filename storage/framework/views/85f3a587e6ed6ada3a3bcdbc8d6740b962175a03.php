                          
  <?php if(isset((get_defined_vars()['start_date_'.$k])) && (get_defined_vars()['start_date_'.$k])): ?>

   <h3 class="kt-portlet__head-title container pt-3 text-center">

                            <b> <?php echo e(__('From : ')); ?> </b>  <?php echo e((\Carbon\Carbon::make(get_defined_vars()['start_date_'.$k])->format('d-m-Y'))); ?>


                            <b> - </b>
                            <b> <?php echo e(__('To : ')); ?></b> 
                            <?php echo e((\Carbon\Carbon::make(get_defined_vars()['end_date_'.$k])->format('d-m-Y'))); ?>

                            
                             
                            <br>
                        </h3>
                        

  <?php endif; ?> 
  

<?php /**PATH /media/salah/Software/projects/veroo/resources/views/interval_date.blade.php ENDPATH**/ ?>