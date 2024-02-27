@props([
	'label',
	'type' ,
	'name',
	'required'=>$required??true ,
	'model'=>$model,
	'readonly'=>false,
	'placeholder'=>$placeholder ?? null,
	'class'=>$class ?? '',
	'id'=>'',
	'defaultValue'=>''
])
<label> {{ $label }} 
@if($required)
@include('star')
@endif 
</label>
                                <div class="kt-input-icon">
                                    <input @if($readonly) readonly @endif @if($id) id="{{ $id }}" @endif name="{{ $name }}" value="{{ $model ?  $model->{$name} : $defaultValue  }}" type="{{ $type }}" class="form-control {{ $class }}" placeholder="{{$placeholder}}">
                                </div>
