@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::villas.title.edit villa') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.villamanager.villa.index') }}">{{ trans('villamanager::villas.title.villas') }}</a></li>
        <li class="active">{{ trans('villamanager::villas.title.edit villa') }}</li>
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

    .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 13px;
        line-height: 29px;
    }
    .dd-list {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .dd-list .dd-list {
        padding-left: 30px;
    }
    .dd-collapsed .dd-list {
        display: none;
    }
    .dd-item,
    .dd-item-root,
    .dd-empty,
    .dd-placeholder {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 20px;
        font-size: 13px;
        line-height: 20px;
    }
    .dd-handle-root,
    .dd-handle {
        display: block;
        margin: 5px 0;
        padding: 4px 10px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .dd-handle:hover {
        color: #2ea8e5;
        background: #fff;
        cursor: move;
    }
    .dd-item-root > .btn {
        display: none;
    }
    .dd-item-root > button,
    .dd-item > button {
        display: block;
        position: relative;
        cursor: pointer;
        float: right;
        width: 25px;
        height: 20px;
        margin: 5px 0;
        padding: 0;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 0;
        background: transparent;
        font-size: 12px;
        line-height: 1;
        text-align: center;
        font-weight: bold;
    }
    .dd-item-root > button:before,
    .dd-item > button:before {
        content: '+';
        display: block;
        position: absolute;
        width: 100%;
        text-align: center;
        text-indent: 0;
        font-size: 20px;
        line-height: 9px;
    }
    .dd-item-root > button[data-action="collapse"]:before,
    .dd-item > button[data-action="collapse"]:before {
        content: '-';
        font-size: 20px;
        line-height: 9px;
    }
    .dd-placeholder,
    .dd-empty {
        margin: 5px 0;
        padding: 0;
        min-height: 30px;
        background: #f2fbff;
        border: 1px dashed #b6bcbf;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .dd-empty {
        border: 1px dashed #bbb;
        min-height: 100px;
        background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), -webkit-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
        background-image: -moz-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), -moz-linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
        background-image: linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff), linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%, #ffffff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }
    .dd-dragel {
        position: absolute;
        pointer-events: none;
        z-index: 9999;
    }
    .dd-dragel > .dd-item .dd-handle {
        margin-top: 0;
    }
    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
        box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, 0.1);
    }
    /**
     * Nestable Extras
     */
    .nestable-lists {
        display: block;
        clear: both;
        padding: 30px 0;
        width: 100%;
        border: 0;
        border-top: 2px solid #ddd;
        border-bottom: 2px solid #ddd;
    }
    #nestable-menu {
        padding: 0;
        margin: 20px 0;
    }
    #nestable-output,
    #nestable2-output {
        width: 100%;
        height: 7em;
        font-size: 0.75em;
        line-height: 1.333333em;
        font-family: Consolas, monospace;
        padding: 5px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    #nestable2 .dd-handle {
        color: #fff;
        border: 1px solid #999;
        background: #bbb;
        background: -webkit-linear-gradient(top, #bbbbbb 0%, #999999 100%);
        background: -moz-linear-gradient(top, #bbbbbb 0%, #999999 100%);
        background: linear-gradient(top, #bbbbbb 0%, #999999 100%);
    }
    #nestable2 .dd-handle:hover {
        background: #bbb;
    }
    #nestable2 .dd-item > button:before {
        color: #fff;
    }
    @media only screen and (min-width: 700px) {
        .dd {
            float: left;
            width: 100%;
        }
        .dd + .dd {
            margin-left: 2%;
        }
    }
    .dd-hover > .dd-handle {
        background: #2ea8e5 !important;
    }

    </style>

@stop

@section('content')
    {!! Form::open(['route' => ['admin.villamanager.villa.update', $villa->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">

            @if($currentUser->hasAccess('villamanager.rates.index'))
                <a href="{{ route('admin.villamanager.rate.create', [$villa->id]) }}" class="btn btn-success btn-flat" data-toggle="tooltip" title="Villa Rates">
                    <i class="fa fa-calendar"></i> Rate
                </a>
            @endif

            @if($currentUser->hasAccess('villamanager.bookings.index'))
                <a href="{{ route('admin.villamanager.booking.index').'?view=calendar&villa='.$villa->id }}" class="btn btn-warning btn-flat" data-toggle="tooltip" title="Villa Bookings">

                    <i class="fa fa-usd"></i> Booking
                </a>
            @endif

            <a href="{{ villa_url($villa) }}" class="btn btn-primary btn-flat" target="_blank">
                <i class="fa fa-eye"></i> Preview
            </a>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('villamanager::admin.villas.partials.edit-nontrans-fields')
                </div>
            </div>
            <div class="box box-info">
                <div class="box-body">
                    <div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#location" aria-controls="home" role="tab" data-toggle="tab">Villa Location</a></li>
                            <li role="presentation" ><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Villa Image</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Villa Facility</a></li>
                            <li role="presentation"><a href="#trip" aria-controls="trip" role="tab" data-toggle="tab">Tripadvisor</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="location">
                                @include('villamanager::admin.villas.partials.create-location')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile">
                                @include('villamanager::admin.villas.partials.edit-facilities')
                            </div>
                            <div role="tabpanel" class="tab-pane " id="messages">
                                @include('villamanager::admin.villas.partials.edit-image')
                            </div>
                            <div role="tabpanel" class="tab-pane " id="trip">
                                @include('villamanager::admin.villas.partials.trip')
                            </div>
                        </div>

                    </div>


                </div>
            </div>
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
                            @include('villamanager::admin.villas.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                </div>
            </div> {{-- end nav-tabs-custom --}}

            <div class="box box-primary">
                <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat" name="button" value="index" >
                            <i class="fa fa-angle-left"></i>
                            {{ trans('core::core.button.update and back') }}
                        </button>
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
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
    <script src="{!! Module::asset('menu:js/jquery.nestable.js') !!}"></script>
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
    <script>
        $( document ).ready(function() {
            $('.dd').nestable();
            $('.dd').on('change', function() {
                var data = $('.dd').nestable('serialize');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.villamanager.image.update',$villa->id) }}',
                    data: {'menu': JSON.stringify(data), '_token': '<?php echo csrf_token(); ?>'},
                    dataType: 'json',
                    success: function(data) {

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                    }
                });
            });

            $('#get_review').on('click',function () {
                var btn = this;
                $(btn).button('loading');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.tripadvisor.grab',$villa->id) }}',
                    data: { '_token': '<?php echo csrf_token(); ?>'},
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $(btn).button('reset');
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                    }
                });
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
                url: <?php echo "'".route('admin.villamanager.image.store',$villa->id)."'"; ?>,
                autoProcessQueue: true,
                maxFilesize: maxFilesize,
                acceptedFiles : acceptedFiles,
                headers: {
                    'X-CSRF-TOKEN': <?php echo "'".csrf_token()."'"; ?>
                }
            });
            myDropzone.on("success", function(file, http) {
                $('.dd-list').append(http);
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

            var checkedValues = [];
            $('#delete_checkbox').on('change',function () {
                if($(this).is(':checked'))
                    $('.delete_checkbox').prop('checked', true);
                else
                    $('.delete_checkbox').prop('checked', false);

                checkedValues = $('.delete_checkbox:checkbox:checked').map(function() {
                    return this.value;
                }).get();
            });

            $('.delete_checkbox').on('change',function () {
                checkedValues = $('.delete_checkbox:checkbox:checked').map(function() {
                    return this.value;
                }).get();

            });

            $('#delete_all').on('click',function(){
                var btn = this;
                if(checkedValues.length == 0)
                    return;

                if(window.confirm('Delete checked images?')){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                        }
                    });
                    $(btn).button('loading');
                    $.ajax({
                        url : $('#delete_all').attr('data-action-target'),
                        method : 'post',
                        data : {
                            'files' : checkedValues
                        }
                    }).success(function(data){
                        checkedValues.forEach(function (id) {
                            $('#'+id).remove();
                        })
                        $(btn).button('reset');
                    }).complete(function () {
                        $(btn).button('reset');
                    });
                }
            });
        });

    </script>
@stop
