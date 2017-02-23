@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::villas.title.villas') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('villamanager::villas.title.villas') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.villamanager.villa.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('villamanager::villas.button.create villa') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>

                            <th>{{ trans('villamanager::villas.table.name') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($villas)): ?>
                        <?php foreach ($villas as $villa): ?>
                        <tr>
                            <td>
                            <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    {{ $villa->name }}
                                    </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    {{ $villa->created_at }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">

                                    @if($user->hasAccess('villamanager.rates.index'))
                                    <a href="{{ route('admin.villamanager.rate.create', [$villa->id]) }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Villa Rates"><i class="fa fa-usd"></i></a>
                                    @endif

                                        @if($user->hasAccess('villamanager.bookings.index'))
                                    <a href="{{ route('admin.villamanager.booking.index').'?view=calendar&villa='.$villa->id }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Villa Bookings"><i class="fa fa-calendar"></i></a>
                                        @endif
                                    <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                    
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.villamanager.villa.destroy', [$villa->id]) }}"><i class="fa fa-trash"></i></button>
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
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('villamanager::villas.title.create villa') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.villamanager.villa.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
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
