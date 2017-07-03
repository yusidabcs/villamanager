<div class='form-group row' >
    <div class="col-md-4">
        {!! Form::label($settingName, $moduleInfo['description']) !!}
        <?php if (isset($dbSettings[$settingName])): ?>
        <div class="input-group">
            {!! Form::input('number', $settingName, old($settingName, $dbSettings[$settingName]->plainValue), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description']),'min' => 0]) !!}
            <span class="input-group-addon">%</span>
        </div>
        <?php else: ?>
        <div class="input-group">
            {!! Form::input('number', $settingName, old($settingName), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description']),'min' => 0]) !!}
            <span class="input-group-addon">%</span>
        </div>

        <?php endif; ?>
    </div>
</div>
