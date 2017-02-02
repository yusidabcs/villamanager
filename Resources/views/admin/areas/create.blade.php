@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::areas.title.create area') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.villamanager.area.index') }}">{{ trans('villamanager::areas.title.areas') }}</a></li>
        <li class="active">{{ trans('villamanager::areas.title.create area') }}</li>
    </ol>
@stop

@section('styles')

    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.villamanager.area.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
                                {!! Form::label('name', trans('villamanager::areas.form.name')) !!}
                                {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => trans('villamanager::areas.form.name')]) !!}

                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class='form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}'>
                                {!! Form::label('parent_id', trans('villamanager::areas.form.parent')) !!}
                                <select name="parent_id" class="form-control">
                                    <option value="">Main Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                </select>
                                {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
                            </div>

                            @include('media::admin.fields.new-file-link-single', [
    'zone' => 'area_image'
])

                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="location" value="{{ old('location','-8.64619538277659;115.18066218750005') }}">
                            {!! Form::label('location', trans('villamanager::areas.form.location')) !!}
                            <div id="map"></div>
                        </div>
                    </div>

                </div>
            </div>



            <div class="box box-primary">
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.villamanager.area.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('villamanager::admin.villas.partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlJBFpFe4vT7F5gXvMpMbL8imZETYyh3c&callback=initMap">
    </script>
    <script>
        function initMap() {

                var loc = $('input[name=location]').val();
                if(loc != ''){
                    loc = loc.split(';');
                    var myLatlng = {lat: parseFloat(loc[0]), lng: parseFloat(loc[1])};
                }else{
                    var myLatlng = {lat: -8.64619538277659, lng: 115.18066218750005};
                }

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: myLatlng
                });

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    draggable:true,
                    title:"Drag me!",
                });

                marker.addListener('dragend', function() {
                    console.log(marker.getPosition().lng());
                    console.log(marker.getPosition().lat());
                    $('input[name=location]').val(marker.getPosition().lat()+';'+marker.getPosition().lng())
                } );

                map.controls[google.maps.ControlPosition.TOP_CENTER].push($('#area')[0]);

        }
    </script>


    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.villamanager.villa.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>

    <?php $config = config('asgard.media.config'); ?>
    <script>
        var maxFilesize = '<?php echo $config['max-file-size'] ?>',
                acceptedFiles = '<?php echo $config['allowed-types'] ?>';
    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
        });

    </script>
@stop
