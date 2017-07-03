<div class="box-body">
    <div class="box-body">
        
        <div class='{{ $errors->has("{$lang}.name") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[name]", trans('villamanager::facilities.form.name')) !!}
            <input type="text" class="form-control" name="{{$lang}}[name]" value="{{ old("{$lang}.name") }}">
            {!! $errors->first("{$lang}.name", '<span class="help-block">:message</span>') !!}
        </div>
        <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
            <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
                @include($partial)
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
