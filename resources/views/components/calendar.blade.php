@props([
'label'=>$label ?? '' ,
'id'=>$id ,
'name'=>$name ,
'value'=>$value ?? null
])
@if($label)
<x-form.label :class="'label'" :id="$id"> {{ $label }} </x-form.label>
@endif
<div class="kt-input-icon">
    <div class="input-group date">
        <input type="text" name="{{ $name }}" class="only-month-year-picker datepicker-input date-input form-control recalc-end-date start-date " value="{{$value}} " />
    </div>
</div>
