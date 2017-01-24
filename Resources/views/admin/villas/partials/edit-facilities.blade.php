<div class="box-group" id="accordion">
    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
    <div class="panel box box-primary">
        <div class="box-header">
            <h4 class="box-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    {{ trans('villamanager::villas.title.facility') }}
                </a>
            </h4>
        </div>
        <div style="height: 0px;" id="collapseTwo" class="panel-collapse">
            <div class="box-body">
                <?php foreach ($facilities as $name => $value): ?>
                    <div class="col-md-3 text-center">
                        
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
        </div>
    </div>
</div>