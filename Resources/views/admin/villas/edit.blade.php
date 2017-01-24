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
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.villamanager.villa.update', $villa->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('villamanager::admin.villas.partials.edit-nontrans-fields')
                </div>
            </div>
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('villamanager::admin.villas.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach


                    <div class="box-body">
                        @include('villamanager::admin.villas.partials.edit-facilities')
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}

            <div class="box box-primary">
                <div class="box-body">
                    @include('villamanager::admin.villas.partials.edit-image')
                </div>
            </div>

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
