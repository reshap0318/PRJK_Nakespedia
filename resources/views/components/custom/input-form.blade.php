@props(['name'])

{!! Form::text($name, null, ['class' => 'form-control form-control-solid', 'id' => $name]) !!}
<x-validation-error name="{{ $name }}"></x-validation-error>