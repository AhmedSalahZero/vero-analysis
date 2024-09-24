
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
	use App\Models\User;
?>


<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title head-title text-primary">
                        
						<?php echo e(__('Permissions')); ?>

                    </h3>
                </div>
            </div>
        </div>

            <!--begin::Form-->
          
            <form class="kt-form kt-form--label-right" method="POST" 
			
			action="<?php echo e(route('roles.permissions.update',$company ? [$company->id] : [])); ?>"
			 enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo e(isset($role) ?  method_field('POST'): ""); ?>

                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row section">
						   <div class="col-md-4">
                                <label><?php echo e(__('Company')); ?> </label>
                                <select id="company-select-id" update-users-based-on-company-and-role required name="company_id" class="form-control kt-selectpicker" >
                                    <?php $selectedcompanies = isset($user) ?  $user->companies->pluck('id')->toArray() : []; ?>
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(old('company_id') == $item->id || in_array($item->id, $selectedcompanies) ? 'selected' : ''); ?>  value="<?php echo e($item->id); ?>"><?php echo e($item->name[$lang]); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div> 
							
  							<div class="col-md-4">
                                <label><?php echo e(__('Role')); ?> </label>
                                <select  required id="role-select-id" name="role_id" class="form-control kt-selectpicker" update-users-based-on-company-and-role >
	                                    <?php if(auth()->user()->isSuperAdmin() || (isset($user) && $user->hasRole(User::SUPER_ADMIN) )): ?>
										<option   value="<?php echo e(User::SUPER_ADMIN); ?>" <?php if(isset($user) && $user->hasRole(User::SUPER_ADMIN) || old('role_id') ==User::SUPER_ADMIN  ): ?> selected <?php endif; ?> > <?php echo e(__("Super Admin")); ?></option>
										<?php endif; ?> 
										<?php if(auth()->user()->can('create company admin') || (isset($user) && $user->hasRole(User::COMPANY_ADMIN) )): ?>
										<option   value="<?php echo e(User::COMPANY_ADMIN); ?>" <?php if(isset($user) && $user->hasRole(User::COMPANY_ADMIN) || old('role_id') ==User::COMPANY_ADMIN): ?> selected <?php endif; ?> > <?php echo e(__("Company Admin")); ?></option>
										<?php endif; ?>
										<?php if(auth()->user()->can('create manager') || (isset($user) && $user->hasRole(User::MANAGER) )): ?>
										<option   value="<?php echo e(User::MANAGER); ?>" <?php if(isset($user) && $user->hasRole(User::MANAGER) || old('role_id') ==User::MANAGER ): ?> selected <?php endif; ?> > <?php echo e(__("Manager")); ?></option>
										<?php endif; ?>
										<?php if(auth()->user()->can('create user') || (isset($user) && $user->hasRole(User::USER) )): ?>
										<option   value="<?php echo e(User::USER); ?>" <?php if(isset($user) && $user->hasRole(User::USER) || old('role_id') ==User::USER): ?> selected <?php endif; ?> > <?php echo e(__("User")); ?></option>
										<?php endif; ?>
                                </select>

                            </div>
                                    <div class="col-md-4">
                                        <label><?php echo e(__('User')); ?> <span class=""></span> </label>
                                        <div class="kt-input-icon">
                                            <div class="input-group date">
                                                <select
												 id="user-id"  data-current-selected="<?php echo e(isset($model) ? $model->getUserId(): old('user_id')); ?>" name="user_id" class="form-control role-users">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									


                        </div>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title head-title text-primary">
                                <?php echo e(__('Permissions')); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body" id="append-permission-views">
                        
                    </div>
                </div>

                 <?php if (isset($component)) { $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Submitting::class, []); ?>
<?php $component->withName('submitting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34)): ?>
<?php $component = $__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34; ?>
<?php unset($__componentOriginal49acb4be531871427e6da8fc4bf301f11a96ee34); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </form>

            <!--end::Form-->

        <!--end::Portlet-->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!--begin::Page Scripts(used by this page) -->
    <script src="<?php echo e(url('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js')); ?>" type="text/javascript"></script>
    <!--end::Page Scripts -->
    <script>
        $(document).on('change','#select_all',function(e) {
            if ($(this).prop("checked")) {
                $('.view').prop("checked", true);
                $('.create').prop("checked", true);
                $('.edit').prop("checked", true);
                $('.delete').prop("checked", true);
            } else {
                $('.view').prop("checked", false);
                $('.create').prop("checked", false);
                $('.edit').prop("checked", false);
                $('.delete').prop("checked", false);
            }
        });
    </script>
	<script>
	$(document).on('change','[update-users-based-on-company-and-role]',function(e){
		const companyId = $('select#company-select-id').val();
		const roleName = $('select#role-select-id').val();
		const currentUserSelect = $('select#user-id').attr('data-current-selected')
	
		if(roleName && companyId){
			$.ajax({
			url:"<?php echo e(route('update.users.based.on.company.and.role')); ?>",
			data:{
				companyId,
				roleName
			},
			type:"get",
			success:function(res){
				const users = res.users
				let userOptions = '';
				for(var i = 0 ; i <users.length ; i++){
					var selected = currentUserSelect == users[i].id ? 'selected':''
					userOptions =' <option '+ selected +' value="'+users[i].id+'" >'+ users[i].name +'</option>';
				}
				$('select#user-id').empty().append(userOptions).trigger('change')
			}
		})
		}
		
	})
	$(document).on('change','select#user-id',function(){
		const userId = $('select#user-id').val();
		const companyId = $('select#company-select-id').val()
		if(userId){
			$.ajax({
				url:"<?php echo e(route('render.permissions.html.for.user')); ?>",
				data:{
					userId,
					companyId
				},
				success:function(res){
					$('#append-permission-views').empty().append(res.view)
				}
			})
		}else{
			$('#append-permission-views').empty()
		}
	})
	$('[update-users-based-on-company-and-role]:eq(0)').trigger('change');
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/salah/Software/projects/veroo/resources/views/super_admin_view/roles_and_permissions/form.blade.php ENDPATH**/ ?>