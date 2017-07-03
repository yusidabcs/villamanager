<hr>
<div class="form-group">
{!! Form::label($settingName, trans($moduleInfo['description'])) !!}
<div class="checkbox">
    <?php foreach ($moduleInfo['options'] as $value => $optionName): ?>
        <label for="{{ $optionName }}">
                <input id="{{ $optionName }}"
                        name="{{ $settingName }}"
                        type="radio"
                        class="flat-blue"
                        {{ isset($dbSettings[$settingName]) && $dbSettings[$settingName]->plainValue == $value ? 'checked' : '' }}
                        value="{{ $value }}"
                        {{ isset($moduleInfo['default']) && $moduleInfo['default'] == $value ? 'checked' : '' }}
                />
                {{ trans($optionName) }}
        </label>
    <?php endforeach; ?>
</div>
</div>