
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-6" id="LoginForm">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger errorMessage">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
        <div class="float-right" >
            
        </div>
        <div class="intro-banner-search-form margin-top-49" style="background-color:none">
            <form class="login100-form validate-form flex-sb flex-w" method="POST"
            action="<?php echo e(route('login')); ?>">
            <!-- Search Field -->
            <?php echo e(csrf_field()); ?>


                <div class="intro-search-field with-autocomplete">
                    <div class="input-with-icon">
                        <input class="input100" style="color:white" type="email" name="email"
                            placeholder="Username" value="" required="" />
                        <i class="icon-material-outline-location-on"></i>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- Search Field -->
                <div class="intro-search-field">
                    <input class="input100" style="color:white" type="password" name="password"
                        placeholder="Password" value="" required="" />
                </div>
                <div class="clearfix"></div>

                <!-- Button -->
                <div style="width: 100%;">
                    <div style="float:left">
                        <button type="submit" style="color:white;" class="btn btn-link"><b>Let's
                                GO</b></button>
                    </div>
                    <div style="float:right">
                        <a type="submit"
                            style="color:white;font-family:  nunito,helveticaneue,helvetica neue,Helvetica,Arial,sans-serif"
                            href="<?php echo e(route('password.request')); ?>" class="btn btn-link"><b> Forget
                                Password / Change Password</b></a>
                    </div>
                </div>

            </form>
        </div>
    </div>
	<div class="col-12 mt-4">
	
				<?php if(session()->has('expired-login')): ?>
				<div class="row " style="justify-content:center">
					<div class="col-6">
					<div class="alert alert-danger">
					<?php echo e(session()->get('expired-login')); ?>

				</div>
					</div>
				</div>
				<?php endif; ?> 
	
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.LoginDashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\veroo\resources\views/auth/login.blade.php ENDPATH**/ ?>