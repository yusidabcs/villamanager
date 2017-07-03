<div class="row">
    <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12'>
        {!! Form::label('name', trans('villamanager::villas.form.name')) !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.name'),'required']) !!}
        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('villa_category') ? ' has-error' : '' }}'>
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
    </div>
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('max_person') ? ' has-error' : '' }}'>
            {!! Form::label('max_person', trans('villamanager::villas.form.max_person')) !!}
            {!! Form::number('max_person', old('max_person'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.max_person')]) !!}
            {!! $errors->first('max_person', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('bedroom_number') ? ' has-error' : '' }}'>
            {!! Form::label('bedroom_number', trans('villamanager::villas.form.bedroom_number')) !!}
            {!! Form::number('bedroom_number', old('bedroom_number'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.bedroom_number')]) !!}
            {!! $errors->first('bedroom_number', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('minimum_stay') ? ' has-error' : '' }}'>
            {!! Form::label('minimum_stay', trans('villamanager::villas.form.minimum_stay')) !!}
            {!! Form::number('minimum_stay', old('minimum_stay'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.minimum_stay')]) !!}
            {!! $errors->first('minimum_stay', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
@if($currentUser->hasRoleName('Admin'))
<div class="row">
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('agent_price') ? ' has-error' : '' }}'>
            {!! Form::label('agent_price', trans('villamanager::villas.form.agent_price')) !!}<a href="#" class="btn btn-link" id="change_agent_price_type"> [nominal] </a>
            <div class="input-group">
                <div class="input-group-addon" id="agent_nominal" style="display: none;">USD</div>
                {!! Form::number('agent_price', old('agent_price'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.agent_price')]) !!}
                <div class="input-group-addon" id="agent_percent">%</div>
            </div>
            <input type="hidden" value="1" name="agent_price_type" id="agent_price_type">
            {!! $errors->first('agent_price', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class='form-group{{ $errors->has('publish_price') ? ' has-error' : '' }}'>
            {!! Form::label('publish_price', trans('villamanager::villas.form.publish_price')) !!} <a href="#" class="btn btn-link" id="change_publish_price_type"> [nominal] </a>
            <div class="input-group" >
                <div class="input-group-addon" id="nominal" style="display: none;">USD</div>
                {!! Form::number('publish_price', old('publish_price'), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.publish_price')]) !!}
                <div class="input-group-addon" id="percent">%</div>
            </div>
            <input type="hidden" value="1" name="publish_price_type" id="publish_price_type">
            {!! $errors->first('publish_price', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label("status", 'Villa status:') !!}
            <select name="status" id="status" class="form-control">
                <?php foreach ($statuses as $id => $status): ?>
                <option value="{{ $id }}" {{ old('status', 0) == $id ? 'selected' : '' }}>{{ $status }}</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-9">

        <div style="padding-top: 20px">
            <div class="row">
                <div class="col-md-4">
                    <div class="checkbox" style="margin-left: 20px">
                        <label>
                            <input type="checkbox" value="1" name="featured">
                            {{ trans('villamanager::villas.form.featured') }}
                        </label>
                    </div>
                    {!! $errors->first('featured', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="col-md-4">
                    <div class="checkbox" style="margin-left: 20px">
                        <label>
                            <input type="checkbox" value="1" name="best_seller">
                            {{ trans('villamanager::villas.form.best_seller') }}
                        </label>
                    </div>
                    {!! $errors->first('best_seller', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="col-md-4">
                    <div class="checkbox" style="margin-left: 20px">
                        <label>
                            <input type="checkbox" value="1" name="approved">
                            {{ trans('villamanager::villas.form.approved') }}
                        </label>
                    </div>

                    {!! $errors->first('approved', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif