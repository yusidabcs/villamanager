<div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
    {!! Form::label('name', trans('villamanager::villas.form.name')) !!}
    {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.name')]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>

<div class="checkbox" style="margin-left: 20px">
    <label>
        <input type="checkbox" value="1" name="featured">
        {{ trans('villamanager::villas.form.featured') }}
    </label>
</div>
{!! $errors->first('featured', '<span class="help-block">:message</span>') !!}
