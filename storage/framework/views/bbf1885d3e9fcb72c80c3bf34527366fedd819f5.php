<?php $attributes = $attributes->exceptProps([
'id',
'rounded'=>true ,
'borderRadius'=>'100%',
'label'=>'',
'required'=>true ,
'name',
'readUrlFunctionName'=>'readUrl',
'image'=>'image',
'editable'=>true ,
'clickToEnlarge'=>false 
]); ?>
<?php foreach (array_filter(([
'id',
'rounded'=>true ,
'borderRadius'=>'100%',
'label'=>'',
'required'=>true ,
'name',
'readUrlFunctionName'=>'readUrl',
'image'=>'image',
'editable'=>true ,
'clickToEnlarge'=>false 
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<style>
    .avatar-edit label:hover {
        background-color: #9b8787 !important;
    }

    .edit-icon-color {
        color: white !important;
    }

    .img-label {
        font-size: 1rem;
        line-height: 1.25rem;
        letter-spacing: -0.025em;
        line-height: 1.5rem;
        color: #4B4B4B;
    }

    .avatar-upload {
        position: relative;
        max-width: 205px;
    }

    .avatar-upload .avatar-edit {
        max-width: 175px;
        position: absolute;
		right:0;
        top: 0;
        width: 100%;
    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: flex;
        align-items: center;
        color: black;
        justify-content: center;
        margin-bottom: 0;
        box-sizing: inherit;
        background-color: gray;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.5s ease-in-out;
		
		
		
		position:relative;
		width:35px;
		height:40px;
		z-index:99999;
		border-radius:50%;
    }

    .avatar-upload .avatar-edit input+label:after {
        display: none;
        content: "\f040";
        font-family: "FontAwesome";
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        width: 175px;
        height: 175px;
        position: relative;
    }

    .avatar-upload .avatar-preview>* {
        display:block;
		width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        box-sizing: border-box;
    }

</style>
<div class="file-upload-container row form-group">

    <?php if($label): ?>
    <label class="img-label label-control col-md-3"><?php echo e($label); ?>

	
	<?php if($clickToEnlarge): ?>
	<span class="required">
		(<?php echo e(__('Click To Enlarge')); ?>)
	</span>
	<?php endif; ?> 
	
	<?php if($required): ?>
	<?php echo $__env->make('star', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?> 
	 </label>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="avatar-upload">
				<?php if($editable): ?>
            <div class="avatar-edit">
                <input data-id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" type='file' id="<?php echo e($id .'-upload-id'); ?>" />
                <label for="<?php echo e($id .'-upload-id'); ?>" class="label-control">
                    <i class="fa fa-pen edit-icon-color "></i>
                </label>
            </div>
				<?php endif; ?>
				<?php if($clickToEnlarge): ?> 
            	<div class="avatar-preview">
                <a href="<?php echo e($image); ?>" target="_blank"  id="<?php echo e($id); ?>" style="background-image: url('<?php echo e($image); ?>')">
                </a>
            </div>
			<?php else: ?> 
			<div class="avatar-preview">
                <div  id="<?php echo e($id); ?>" style="background-image: url('<?php echo e($image); ?>')">
                </div>
            </div>
			<?php endif; ?> 
			<?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
			<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</div>
<?php $__env->startPush('js'); ?>
<script>
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + id).css('background-image', 'url(' + e.target.result + ')');
                $('#' + id).hide();
                $('#' + id).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#<?php echo e($id .'-upload-id'); ?>").change(function() {
        const id = $(this).attr('data-id');
        readURL(this, id);
    });

</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/image-uploader.blade.php ENDPATH**/ ?>