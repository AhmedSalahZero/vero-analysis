<?php $attributes = $attributes->exceptProps([
'label' , 'name' , 'labelClass'=>'' , 'inputClass'=>''  , 'id'=>'' , 'placeHolder' ,'type'=>'text' ,'required'=>false
,'model'=>false,
'inputAttributes'=>'' ,
'json'=>false ,
'jsonLang',
'json2'=>false ,
'json3'=>false ,
'index'=>-1,
'title'=>'',
'idSuffix'=>'',
'parentClass'=>'',
"defaultValue"=>"",
"withoutLabel"=>'',
'attrName'=>'',
'updateDefaultValue'=>'',
'parentStyle'=>'',
'fullWidth'=>'',
'resetMargin'=>'',
'smallBox'=>''
]); ?>
<?php foreach (array_filter(([
'label' , 'name' , 'labelClass'=>'' , 'inputClass'=>''  , 'id'=>'' , 'placeHolder' ,'type'=>'text' ,'required'=>false
,'model'=>false,
'inputAttributes'=>'' ,
'json'=>false ,
'jsonLang',
'json2'=>false ,
'json3'=>false ,
'index'=>-1,
'title'=>'',
'idSuffix'=>'',
'parentClass'=>'',
"defaultValue"=>"",
"withoutLabel"=>'',
'attrName'=>'',
'updateDefaultValue'=>'',
'parentStyle'=>'',
'fullWidth'=>'',
'resetMargin'=>'',
'smallBox'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
    <?php if(! $withoutLabel): ?>
    <label title="<?php echo e($title); ?>" class=" fw-bold fs-6 mb-2 <?php echo e($labelClass); ?> " for="<?php echo e($id); ?>"><?php echo e($label); ?>

        <?php if($required): ?>
    <span style="color:red">*</span>
            <?php endif; ?>
    </label>
    <?php endif; ?>
    <input id="<?php echo e(isset($idSuffix) && $idSuffix ? $id . $idSuffix : $id); ?>" title="<?php echo e($title); ?>" <?php echo e($attributes); ?> type="<?php echo e($type); ?>" class="form-control  form-control-solid mb-3 mb-lg-0 <?php echo e($inputClass); ?>"

           <?php if($json): ?>
           name="<?php echo e($name . '[' .  $jsonLang . ']'); ?>" id="<?php echo e($id."-" . $jsonLang); ?>"
           value="<?php echo e(old($name .'.'.$jsonLang) ?? ( $model ?  ((array)json_decode(@$model->getRawOriginal($name)))[$jsonLang] : null )); ?>"
           <?php elseif($json2): ?>
           name="<?php echo e($name . '[' .  $index . ']'.'[' . $jsonLang . ']'); ?>" id="<?php echo e($id."-" . $index . '-' .  $jsonLang); ?>"
           value="<?php echo e(old($name .'.'. $index .'.'.$jsonLang) ?? ( $model ?  ((array)json_decode(@$model->getRawOriginal($name)))[$jsonLang] : null )); ?>"
           <?php elseif($json3): ?>
           name="<?php echo e($name . '[' .  $index . ']'); ?>" id="<?php echo e($id."-" . $index); ?>"
           value="<?php echo e(old($name .'.'. $index ) ?? ( $model ?  ((@$model->{$name})) : null )); ?>"
           <?php else: ?>

           name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
           value="<?php echo e(old($name) ?? ( @$model->{$attrName?:$name}) ?: $defaultValue); ?>"
           <?php endif; ?>
           placeholder="<?php echo e($placeHolder??''); ?>" />
<?php /**PATH /media/salah/Software/projects/veroo/resources/views/components/form/text.blade.php ENDPATH**/ ?>