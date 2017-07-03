<div class='form-group{{ $errors->has('icon') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.key')) !!}
    
    <input type="text" name="key" value="{{ $facility->key }}" class="form-control">
    {!! $errors->first('key', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('type') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.type')) !!}
    
    <select class="form-control" required="" name="type">
    	<option ></option>
    	<option value="number" {{ $facility->type == 'number' ? 'selected' : '' }}>Number</option>
    	<option value="text" {{ $facility->type == 'text' ? 'selected' : '' }}>Text</option>
    	<option value="booelan" {{ $facility->type == 'booelan' ? 'selected' : '' }}>Booelan</option>
    </select>
    {!! $errors->first('Value', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('icon') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.icon')) !!}
    
    <input type="text" name="icon" value="{{ $facility->icon }}" class="form-control">
    {!! $errors->first('Value', '<span class="help-block">:message</span>') !!}
</div>