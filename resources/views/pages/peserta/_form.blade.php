<div class="fv-row mb-7">
    <x-custom.input-label value="No Reg"/>
    <x-custom.input-form name="no_reg" placeholder="Enter a no reg"/>
</div>

<div class="fv-row mb-7">
    <x-custom.input-label value="Name"/>
    <x-custom.input-form name="name" placeholder="Enter a name"/>
</div>

<div class="fv-row mb-7">
    <x-custom.input-label value="Regional"/>
    <x-custom.input-form name="origin" placeholder="Enter a regional"/>
</div>

<div class="fv-row mb-7">
    <x-custom.input-label value="Event Title"/>
    {!! Form::textarea('event_title', null, ['cols' => 30, 'rows' => 10, 'class' => 'form-control form-control-solid']) !!}
    <x-validation-error name="event_title"></x-validation-error>
</div>