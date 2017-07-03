<div class="box-body">
    <?php foreach ($facilities as $name => $value): ?>
    <div class="col-md-4 text-center">

        <div class="checkbox">
            <label>
                <input type="checkbox" value="1" name="facility[{{$value->id}}][status]" {{ $villa->facilities->where('facility_id',$value->id)->first() ? ($villa->facilities->where('facility_id',$value->id)->first()->pivot->status == 1 ? 'checked' : '') : ''}}> {{$value->name}}
            </label>
        </div>
        <div class="form-group">

            @if($value->type  == 'text')

                <input type="text" name="facility[{{$value->id}}][value]" value="{{ $villa->facilities->where('facility_id',$value->id)->first()? $villa->facilities->where('facility_id',$value->id)->first()->pivot->value : ''}}" class="form-control">

            @elseif($value->type == 'number')

                <input type="number" name="facility[{{$value->id}}][value]" value="{{$villa->facilities->where('facility_id',$value->id)->first() ? $villa->facilities->where('facility_id',$value->id)->first()->pivot->value : ''}}" class="form-control">

            @elseif($value->type == 'booelan')

                <select class="form-control" name="facility[{{$value->id}}][value]">
                    <option value="true"  {{ $villa->facilities->where('facility_id',$value->id)->first()?  $villa->facilities->where('facility_id',$value->id)->first()->pivot->value == 'true' ? 'selected' : '' : ''}} >Yes</option>
                    <option value="false" {{ $villa->facilities->where('facility_id',$value->id)->first() ? $villa->facilities->where('facility_id',$value->id)->first()->pivot->value == 'false' ? 'selected' : '' : ''}}>No</option>
                </select>
            @endif

        </div>

    </div>
    <?php endforeach; ?>
</div>