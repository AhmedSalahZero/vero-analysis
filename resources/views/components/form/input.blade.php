

@props([
	'label',
	'type' ,
	'name',
	'required'=>$required??false ,
	'model'=>$model,
	'readonly'=>false,
	'placeholder'=>$placeholder ?? null,
	'class'=>$class ?? '',
	'id'=>'',
	'defaultValue'=>'',
	'useOldValue'=>false,
	'dataCurrentValue'=>null
])

@php
	$value = $useOldValue && old($name) ? old($name) :  ($model  ?  $model->{$name} : $defaultValue);
@endphp
<label> {{ $label }}
@if($required)
@include('star')
@endif
</label>
                                <div class="kt-input-icon">
                                    <input
									@if($dataCurrentValue!=null)
									data-current-value="{{ $dataCurrentValue }}"
									@endif 
									@if($required)
									required
									@endif
									 @if($readonly) readonly @endif @if($id) id="{{ $id }}" @endif name="{{ $name }}"  value="{{ $value  }}" type="{{ $type }}" class="form-control {{ $class }}" placeholder="{{$placeholder}}">
                                </div>
