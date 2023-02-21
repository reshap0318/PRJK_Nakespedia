@props(['name'])

{!! Form::password($name, ['class' => 'form-control form-control-solid', 'id' => $name]) !!}
<x-validation-error name="{{ $name }}"></x-validation-error>