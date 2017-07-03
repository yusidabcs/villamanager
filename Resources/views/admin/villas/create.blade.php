@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::villas.title.create villa') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.villamanager.villa.index') }}">{{ trans('villamanager::villas.title.villas') }}</a></li>
        <li class="active">{{ trans('villamanager::villas.title.create villa') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    <link href="{!! Module::asset('media:css/dropzone.css') !!}" rel="stylesheet" type="text/css" />
    <style>
    .dropzone {
        border: 1px dashed #CCC;
        min-height: 227px;
        margin-bottom: 20px;
    }
    #map {
        height: 300px;
        width: 100%;
    }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.villamanager.villa.store'], 'method' => 'post','class' => 'form']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('villamanager::admin.villas.partials.create-nontrans-fields')
                </div>
            </div>
            <div class="box box-info">
                <div class="box-body">
                    <div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#location" aria-controls="home" role="tab" data-toggle="tab">Villa Location</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Villa Facility</a></li>
                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Villa Image</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="location">
                                @include('villamanager::admin.villas.partials.create-location')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile">
                                @include('villamanager::admin.villas.partials.create-facilities')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages">
                                @include('villamanager::admin.villas.partials.create-image')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="settings">...</div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        @include('partials.form-tab-headers')
                        <div class="tab-content">

                            <?php $i = 0; ?>
                            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                <?php $i++; ?>
                                <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                    @if($i > 1)
                                    <button type="button" class="btn btn-small pull-right btn-warning auto-translate" data-target="{{ route('api.villamanager.translate',$locale) }}" data-loading-text="Translating..">Auto Translate</button>
                                    @endif

                                    @include('villamanager::admin.villas.partials.create-fields', ['lang' => $locale])
                                </div>
                            @endforeach

                        </div>
                    </div> {{-- end nav-tabs-custom --}}
                </div>
            </div>


            <div class="box box-primary">
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat" name="button" value="index" >
                        <i class="fa fa-angle-left"></i>
                        {{ trans('villamanager::villas.button.create and back') }}
                    </button>
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.villamanager.villa.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    <script src="{!! Module::asset('media:js/dropzone.js') !!}"></script>
    <script>
        function initMap() {
            var map;
            var marker;
            $('#find-location').on('click',function () {
                //-8.641782883154486;115.23490718261723
                var loc = $('#latlang').val();
                if(loc != ''){
                    loc = loc.split(';');
                    var myLatlng = {lat: parseFloat(loc[0]), lng: parseFloat(loc[1])};
                }else{
                    var myLatlng = {lat: -8.64619538277659, lng: 115.18066218750005};
                }
                marker.setPosition(myLatlng);
                map.setCenter(myLatlng);
            });

            var loc = $('input[name=location]').val();
            if(loc != ''){
                loc = loc.split(';');
                var myLatlng = {lat: parseFloat(loc[0]), lng: parseFloat(loc[1])};
            }else{
                var myLatlng = {lat: -8.64619538277659, lng: 115.18066218750005};
            }

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: myLatlng
            });

            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable:true,
                title:"Drag me!",
            });

            marker.addListener('dragend', function() {
                $('input[name=location]').val(marker.getPosition().lat()+';'+marker.getPosition().lng())
            } );

            map.controls[google.maps.ControlPosition.TOP_CENTER].push($('#area')[0]);
            $('a[href="#location"]').on('shown.bs.tab', function(e)
            {

            });
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlJBFpFe4vT7F5gXvMpMbL8imZETYyh3c&callback=initMap">
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

            $('.auto-translate').on('click',function () {
                var btn = this;
                var target = $(this).attr('data-target');
                $(btn).button('loading');

                $.post(target,{
                    short_description : $('#en_short_description').val(),
                    description : CKEDITOR.instances['en_description'].getData(),
                    tos : CKEDITOR.instances['en_tos'].getData(),
                    meta_title : $('#en_meta_title').val(),
                    meta_description : $('#en_meta_description').val(),
                }, function( data ) {
                    if(window.confirm('Apply this translate?')){
                        $('#'+data.locale+'_short_description').val(data.short_description);

                        CKEDITOR.instances[data.locale+'_description'].setData( data.description );

                        CKEDITOR.instances[data.locale+'_tos'].setData( data.tos);

                        $('#'+data.locale+'_meta_title').val(data.meta_title);
                        $('#'+data.locale+'_meta_description').val(data.meta_description);
                    }

                    $(btn).button('reset');

                });

            });
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone(".dropzone", {
                url: <?php echo "'".route('admin.villamanager.image.store','0')."'"; ?>,
                autoProcessQueue: true,
                maxFilesize: maxFilesize,
                acceptedFiles : acceptedFiles,
                headers: {
                    'X-CSRF-TOKEN': <?php echo "'".csrf_token()."'"; ?>
                }
            });
            myDropzone.on("sending", function(file, xhr, fromData) {
                xhr.setRequestHeader("Authorization", AuthorizationHeaderValue);
                if ($('.alert-danger').length > 0) {
                    $('.alert-danger').remove();
                }
            });
            myDropzone.on("success", function(file, http) {
                $('.jsFileList tbody').append(http);
                myDropzone.removeFile(file);
            });
            myDropzone.on("sending", function(file, fromData) {
                if ($('.alert-danger').length > 0) {
                    $('.alert-danger').remove();
                }
            });
            myDropzone.on("error", function(file, errorMessage) {
                var html = '<div class="alert alert-danger" role="alert">' + errorMessage + '</div>';
                $('.col-md-12').first().prepend(html);
                setTimeout(function() {
                    myDropzone.removeFile(file);
                }, 2000);
            });


        });

    </script>
@stop
