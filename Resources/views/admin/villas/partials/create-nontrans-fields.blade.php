<<<<<<< HEAD
<div class='form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12'>
=======
<div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
>>>>>>> 7847ce95a8b9d64e254c1d30b972dcdff6324ba2
    {!! Form::label('name', trans('villamanager::villas.form.name')) !!}
    {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.name')]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>
<<<<<<< HEAD
<div class='form-group{{ $errors->has('villa_category') ? ' has-error' : '' }} col-md-4'>
    {!! Form::label('villa_category', trans('villamanager::villas.form.category')) !!}
    <select name="category_id" class="form-control">
        <option>No Category</option>
        @if(@$categories)
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        @endif
    </select>
    {!! $errors->first('villa_category', '<span class="help-block">:message</span>') !!}
</div>
<div class="clearfix"></div>

<div class="checkbox col-md-4" style="margin-left: 20px">
=======

<div class="checkbox" style="margin-left: 20px">
>>>>>>> 7847ce95a8b9d64e254c1d30b972dcdff6324ba2
    <label>
        <input type="checkbox" value="1" name="featured">
        {{ trans('villamanager::villas.form.featured') }}
    </label>
</div>
{!! $errors->first('featured', '<span class="help-block">:message</span>') !!}
<<<<<<< HEAD

=======
>>>>>>> 7847ce95a8b9d64e254c1d30b972dcdff6324ba2
