<br>
<div class="row">
    <div class="col-md-8">
        <div class='form-group{{ $errors->has('tripadvisor_url') ? ' has-error' : '' }}'>
            <label>Tripadvisor URl</label>
            {!! Form::text('tripadvisor_url', old('tripadvisor_url',@$villa->tripadvisor->url), ['class' => 'form-control', 'placeholder' => trans('villamanager::villas.form.name')]) !!}
            {!! $errors->first('tripadvisor_url', '<span class="help-block">:message</span>') !!}
        </div>
        <button type="button" class="btn btn-primary btn-flat" id="get_review" name="button" value="index" >
            get review
        </button>
    </div>
</div>