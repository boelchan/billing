@if($name == '')
    @php
        $name = $label;
    @endphp
@endif
<div class="form-group">
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>