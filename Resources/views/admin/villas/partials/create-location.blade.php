
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">

                <div style="width: 50%;margin: 10px" id="area" class="form-inline">
                    <select name="area_id" class="form-control " >
                        <option value="">Select area</option>
                        @if(@$areas)
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ $area->id == old('area_id',@$villa->area_id) ? 'selected' : ( $area->id == @$villa->area_id ? 'selected' : '' ) }}>{{ $area->name }}</option>
                        @endforeach
                            @endif
                    </select>
                    <input type="text" id="latlang" class="form-control" name="location" placeholder="latitude & longitude" value="{{ old('location') ? old('location') : (@$villa ? $villa->location : setting('villamanager::default_location')) }}">
                    <button type="button" class="btn btn-default" id="find-location">Find</button>

                </div>
                <div id="map">
                </div>
            </div>
        </div>
    </div>