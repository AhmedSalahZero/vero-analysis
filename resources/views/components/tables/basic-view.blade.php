@props([
'wrapWithForm'=>false ,
'saveAndReturn'=>false ,
'redirectRoute'=>'',
'formAction'=>'#',
'method'=>'post',
'formId'=>''
])
@php
$basicTableClasses = 'table table-striped- table-bordered table-hover table-checkable' ;
@endphp

<input type="hidden" id="no-ajax-loader">
{{ $filter }}
{{ $export }}

@if($wrapWithForm)
<form action="{{ $formAction }}" method="{{$method  }}" id="{{$formId  }}">

    @csrf
    {{-- </form> --}}
    @endif
    <table {{$attributes->merge(['class'=>$basicTableClasses ])}} id="{{ '#'.$attributes->get('id') }}">

        <thead>
            {{ $headerTr }}

        </thead>


    </table>

    @if($wrapWithForm)
    @if(isset($saveAndReturn) && $saveAndReturn)
    <x-submitting-with-return :return-redirect-route="$redirectRoute"></x-submitting-with-return>
    @else
    <x-submitting></x-submitting>
    @endif
</form>
@endif

{{ $js }}
