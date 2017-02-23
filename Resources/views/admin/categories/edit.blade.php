{!! Form::open(['route' => ['admin.villamanager.category.update',$category->id], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">

                <h4>Edit Villa Category</h4>
            </div>
            <div class="box-body">

                <div class="nav-tabs-custom">

                    <style>
                        li.error {
                            border-top-color: #dd4b39 !important;
                        }
                    </style>

                    <?php $prefix = isset($prefix) ? $prefix."_" : ""; ?>

                    <?php if (count(LaravelLocalization::getSupportedLocales()) > 1): ?>
                    <ul class="nav nav-tabs">
                        <?php $i = 0; ?>
                        <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                        <?php $i ++; ?>
                        <?php $class = ''; ?>
                        <?php foreach ($errors->getMessages() as $field => $messages): ?>
                            <?php if (substr($field, 0, strpos($field, ".")) == $locale) $class = 'error' ?>
                        <?php endforeach ?>
                        <li class="{{ App::getLocale() == $locale ? 'active' : '' }} {{ $class }}">
                            <a href="#tab_{{ $prefix.$i }}_edit" data-toggle="tab">{{ trans('core::core.tab.'. strtolower($language['name'])) }}</a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <div class="tab-content">

                        <?php $i = 0; ?>
                        @foreach (LaravelLocalization::getSupportedLocales() as $lang => $language)
                            <?php $i++; ?>
                            <div class="tab-pane {{ locale() == $lang ? 'active' : '' }}" id="tab_{{ $i }}_edit">
                                <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[name]", trans('villamanager::categories.form.name')) !!}
                                    {!! Form::text("{$lang}[name]", old("$lang.name",$category->translate($lang) ? $category->translate($lang)->name : ''), ['class' => "form-control", 'placeholder' => trans('villamanager::categories.form.name')]) !!}
                                    {!! $errors->first("{$lang}.name", '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class='form-group{{ $errors->has('description') ? ' has-error' : '' }}'>
                                    {!! Form::label("{$lang}[description]", trans('villamanager::categories.form.description')) !!}
                                    {!! Form::textarea("{$lang}[description]", old("$lang.description",$category->translate($lang) ? $category->translate($lang)->description : ''), ['class' => "form-control", 'placeholder' => trans('villamanager::categories.form.description')]) !!}
                                    {!! $errors->first("{$lang}.description", '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> {{-- end nav-tabs-custom --}}

                @include('media::admin.fields.file-link', [
                    'entityClass' => 'Modules\\\\Villamanager\\\\Entities\\\\VillaCategory',
                    'entityId' => $category->id,
                    'zone' => 'thumbnail'
                ])

            </div>
            <div class="box-footer pull-right">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}