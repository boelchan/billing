@if($name == '')
    @php
        $name = $label;
    @endphp
@endif
<div class="form-group" id="form_{{ $name }}">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    {{ Form::email($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>