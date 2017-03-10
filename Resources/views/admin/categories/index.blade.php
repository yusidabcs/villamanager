@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::categories.title.categories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('villamanager::categories.title.categories') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>

                            <th>{{ trans('villamanager::categories.table.categories') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <a data-remote="{{ route('admin.villamanager.category.edit', [$category->id]) }}" type="button" data-toggle="modal" data-target="#edit-category">
                                    {{ $category->name }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button data-remote="{{ route('admin.villamanager.category.edit', [$category->id]) }}" type="button" data-toggle="modal" data-target="#edit-category" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></button>

                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.villamanager.category.destroy', [$category->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <div class="col-sm-4">
            {!! Form::open(['route' => ['admin.villamanager.category.store'], 'method' => 'post']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">

                            <h4>Create new category</h4>
                        </div>
                        <div class="box-body">

                            <div class="nav-tabs-custom">

                                @include('partials.form-tab-headers')
                                <div class="tab-content">

                                    <?php $i = 0; ?>
                                    @foreach (LaravelLocalization::getSupportedLocales() as $lang => $language)
                                        <?php $i++; ?>
                                        <div class="tab-pane {{ locale() == $lang ? 'active' : '' }}" id="tab_{{ $i }}">
                                            <div class='form-group{{ $errors->has('name') ? ' has-error' : '' }}'>
                                                {!! Form::label("{$lang}[name]", trans('villamanager::categories.form.name')) !!}
                                                {!! Form::text("{$lang}[name]", old("$lang.name"), ['class' => "form-control", 'placeholder' => trans('villamanager::categories.form.name')]) !!}
                                                {!! $errors->first("{$lang}.name", '<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class='form-group{{ $errors->has('description') ? ' has-error' : '' }}'>
                                                {!! Form::label("{$lang}[description]", trans('villamanager::categories.form.description')) !!}
                                                {!! Form::textarea("{$lang}[description]", old("$lang.description"), ['class' => "form-control", 'placeholder' => trans('villamanager::categories.form.description')]) !!}
                                                {!! $errors->first("{$lang}.description", '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div> {{-- end nav-tabs-custom --}}


                            @include('media::admin.fields.new-file-link-single', [
                                'zone' => 'villa_category_image'
                            ])

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                            <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        </div>
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('core::partials.delete-modal')
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="edit-category">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('villamanager::areas.title.create area') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.villamanager.area.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
