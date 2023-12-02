@props([
	'label',
	'type' ,
	'name',
	'required'=>$required??true ,
	'model'=>$model,
	'placeholder'=>$placeholder ?? null,
	'class'=>$class ?? ''
])
<label> {{ $label }} 
@if($required)
<span class="required">*</span>
@endif 
</label>
                                <div class="kt-input-icon">
                                    <input name="{{ $name }}" value="{{ $model ?  $model->{$name} : null  }}" type="{{ $type }}" class="form-control {{ $class }}" placeholder="{{$placeholder}}">
                                </div>
