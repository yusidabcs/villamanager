<div class='form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12'>
    {!! Form::label('name', trans('villamanager::villas.form.name')) !!}
    {!! Form::text('name', Input::old('name',$villa->name), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.name')]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>
<div class='form-group{{ $errors->has('slug') ? ' has-error' : '' }} col-md-12'>
    {!! Form::label('slug', trans('villamanager::villas.form.slug')) !!}
    {!! Form::text('slug', Input::old('slug',$villa->slug), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.slug')]) !!}
    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
</div>
<div class='form-group{{ $errors->has('villa_category') ? ' has-error' : '' }} col-md-4'>
    {!! Form::label('villa_category', trans('villamanager::villas.form.category')) !!}
    <select name="category_id" class="form-control">
        <option>No Category</option>
        @if(@$categories)
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $villa->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        @endif
    </select>
    {!! $errors->first('villa_category', '<span class="help-block">:message</span>') !!}
</div>

<div class="clearfix"></div>


<div class="form-group col-md-2">
    {!! Form::label("status", 'Villa status:') !!}
    <select name="status" id="status" class="form-control">
        <?php foreach ($statuses as $id => $status): ?>
        <option value="{{ $id }}" {{ old('status', $villa->status) == $id ? 'selected' : '' }}>{{ $status }}</option>
        <?php endforeach; ?>
    </select>
</div>

<div class="clearfix"></div>
<div class="checkbox col-md-4" style="margin-left: 20px">
    <label>
        <input type="checkbox" value="1" name="featured" {{ $villa->featured == 1 ? 'checked' : '' }}>
        {{ trans('villamanager::villas.form.featured') }}
    </label>
</div>
{!! $errors->first('featured', '<span class="help-block">:message</span>') !!}
<div class="clearfix"></div>

