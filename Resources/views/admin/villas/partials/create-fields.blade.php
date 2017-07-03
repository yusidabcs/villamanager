<div class="box-body">
    <div class="box-body">
        
        <div class='{{ $errors->has("{$lang}.short_description") ? ' has-error' : '' }}'>
            
            {!! Form::label("{$lang}[short_description]", trans('villamanager::villas.form.short_description')) !!}
            <textarea class="form-control" id="{{$lang}}_short_description" name="{{$lang}}[short_description]" >{{ old("{$lang}.short_description") }}</textarea>

            {!! $errors->first("{$lang}.short_description", '<span class="help-block">:message</span>') !!}

        </div>

        <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
            <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
                @include($partial)
            <?php endforeach; ?>
        <?php endif; ?>


        <div class='{{ $errors->has("{$lang}.description") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[description]", trans('villamanager::villas.form.description')) !!}
            <textarea class="ckeditor" name="{{$lang}}[description]" id="{{$lang}}_description" >{{ old("{$lang}.description") }}</textarea>
            {!! $errors->first("{$lang}.description", '<span class="help-block">:message</span>') !!}
        </div>
        <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
            <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
                @include($partial)
            <?php endforeach; ?>
        <?php endif; ?>


        <div class='{{ $errors->has("{$lang}.tos") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[tos]", trans('villamanager::villas.form.tos')) !!}
            <textarea class="ckeditor" name="{{$lang}}[tos]" id="{{$lang}}_tos" >{{ old("{$lang}.tos") }}</textarea>
            {!! $errors->first("{$lang}.tos", '<span class="help-block">:message</span>') !!}
        </div>
        <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
            <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
                @include($partial)
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="box-group" id="accordion">
        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
        <div class="panel box box-primary">
            <div class="box-header">
                <h4 class="box-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                        {{ trans('page::pages.form.meta_data') }}
                    </a>
                </h4>
            </div>
            <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("{$lang}[meta_title]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[meta_title]", trans('villamanager::villas.form.meta_title')) !!}

                        {!! Form::text("{$lang}[meta_title]", old("$lang.meta_title"), ['id'=>"{$lang}_meta_title",'class' => "form-control", 'placeholder' => trans('villamanager::villas.form.meta_title')]) !!}

                        {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class='form-group{{ $errors->has("{$lang}[meta_keyword]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[meta_keyword]", trans('villamanager::villas.form.meta_keyword')) !!}

                        {!! Form::text("{$lang}[meta_keyword]", old("$lang.meta_keyword"), ['id'=>"{$lang}_meta_keyword",'class' => "form-control", 'placeholder' => trans('villamanager::villas.form.meta_keyword')]) !!}

                        {!! $errors->first("{$lang}[meta_keyword]", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[meta_description]", trans('villamanager::villas.form.meta_description')) !!}

                        <textarea class="form-control" name="{{$lang}}[meta_description]" id="{{$lang}}_meta_description" rows="10" cols="80">{{ old("$lang.meta_description") }}</textarea>

                        {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
