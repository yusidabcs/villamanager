<div class='form-group{{ $errors->has('icon') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.key')) !!}
    
    <input type="text" name="key" value="{{ old('key') }}" class="form-control">
    {!! $errors->first('key', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('type') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.type')) !!}
    
    <select class="form-control" required="" name="type">
    	<option ></option>
    	<option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
    	<option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
    	<option value="booelan" {{ old('type') == 'booelan' ? 'selected' : '' }}>Booelan</option>
    </select>
    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
</div>

<div class='form-group{{ $errors->has('icon') ? ' has-error' : '' }}'>
    {!! Form::label('type', trans('villamanager::facilities.form.icon')) !!}
    
    <input type="text" name="icon" value="{{ old('icon') }}" class="form-control">
    {!! $errors->first('icon', '<span class="help-block">:message</span>') !!}
</div>