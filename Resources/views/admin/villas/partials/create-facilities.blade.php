
    <div class="box-body">
        <?php foreach ($facilities as $name => $value): ?>
            <div class="col-md-4 text-center">

              <div class="checkbox">
                <label>
                  <input type="checkbox" value="1" name="facility[{{$value->id}}][status]"> {{$value->name}}
              </label>
          </div>
          <div class="form-group">
            @if($value->type  == 'text')

            <input type="text" name="facility[{{$value->id}}][value]" value="{{ old('facility[$value->id][value]') }}" class="form-control">

            @elseif($value->type == 'number')

            <input type="number" name="facility[{{$value->id}}][value]" value="{{ old('facility[$value->id][value]') }}" class="form-control">

            @elseif($value->type == 'booelan')

            <select class="form-control" name="facility[{{$value->id}}][value]">
                <option value="true"  {{ old('facility[$value->id][value]') == 'true' ? 'selected' : '' }} >Yes</option>
                <option value="false" {{ old('facility[$value->id][value]') == 'false' ? 'selected' : '' }}>No</option>
            </select>

            @endif

        </div>

    </div>
<?php endforeach; ?>
</div>