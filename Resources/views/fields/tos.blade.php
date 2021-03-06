
<div class='form-group'>
    {!! Form::label($settingName . "[$lang]", trans($moduleInfo['description'])) !!}
    <?php if (isset($dbSettings[$settingName])): ?>
        <?php $value = $dbSettings[$settingName]->hasTranslation($lang) ? $dbSettings[$settingName]->translate($lang)->value : ''; ?>
        {!! Form::textarea($settingName . "[$lang]", Input::old($settingName . "[$lang]", $value), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::textarea($settingName . "[$lang]", Input::old($settingName . "[$lang]"), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>