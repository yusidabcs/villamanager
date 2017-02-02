<div class="box-header">
    <h4 class="box-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#location">
            Villa Location
        </a>
    </h4>
</div>
<div style="height: 0px;" id="location" class="panel-collapse collapse">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="location" value="{{ old('location') ? old('location') : (@$villa ? $villa->location : setting('villamanager::default_location')) }}">
                <div style="width: 30%;margin: 10px" id="area" >
                    <select name="area_id" class="form-control" >
                        <option value="">Select area</option>
                        @if(@$areas)
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ $area->id == old('area_id') ? 'selected' : ( $area->id == @$villa->area_id ? 'selected' : '' ) }}>{{ $area->name }}</option>
                        @endforeach
                            @endif
                    </select>
                </div>
                <div id="map">
                </div>
            </div>
        </div>
    </div>
</div>