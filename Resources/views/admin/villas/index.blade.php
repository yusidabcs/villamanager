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
                            <th>{{ trans('villamanager::villas.table.name') }}</th>
                            <th>Status</th>
                            <th>Owner</th>
                            <th>Area</th>
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
                                    {{ $villa->slug }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    @if($villa->status == 0)
                                        <span class="label bg-red">
                                        Draf
                                    </span>
                                    @elseif($villa->status == 1)
                                        <span class="label bg-orange">
                                        Draf Review
                                    </span>
                                    @elseif($villa->status == 2)
                                        <span class="label bg-green">
                                        Published
                                    </span>
                                    @elseif($villa->status == 3)
                                        <span class="label bg-purple">
                                        Unpublished
                                    </span>
                                    @endif
                                    @if($villa->approved)
                                        <span class="label bg-green">
                                            Approved
                                        </span>
                                    @else
                                        <span class="label bg-blue">
                                            Unapproved
                                        </span>

                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    {{ $villa->user ? $villa->user->first_name.' '.$villa->user->last_name : '' }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    {{ $villa->area ? $villa->area->name : '' }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}">
                                    {{ $villa->created_at }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">

                                    @if($currentUser->hasAccess('villamanager.rates.index'))
                                    <a href="{{ route('admin.villamanager.rate.create', [$villa->id]) }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Villa Rates"><i class="fa fa-usd"></i></a>
                                    @endif

                                        @if($currentUser->hasAccess('villamanager.bookings.index'))
                                    <a href="{{ route('admin.villamanager.booking.index').'?view=calendar&villa='.$villa->id }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Villa Bookings"><i class="fa fa-calendar"></i></a>
                                        @endif
                                    <a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Edit Villa"><i class="fa fa-pencil"></i></a>

                                        <a href="{{ route('admin.villamanager.villa.copy', [$villa->id]) }}" class="btn btn-default btn-flat" data-toggle="tooltip" title="Duplicate Villa"><i class="fa fa-copy"></i></a>
                                    
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
    <div id="area-html" style="display: none;">
        <div class='form-group{{ $errors->has('villa_category') ? ' has-error' : '' }}'>
            {!! Form::label('area', 'Select Area') !!}
            <select id="area" class="form-control" onchange="if (this.value) window.location.href=this.value">
                <option value="{{ route('admin.villamanager.villa.index') }}">All Area</option>

                @foreach(villa_areas(true) as $area)
                    <option value="{{ route('admin.villamanager.villa.index').'?area='.$area->id }}" {{ $area->id == request('area') ? 'selected' : '' }}>{{ $area->name }}</option>
                    @foreach($area->childs as $area2)
                        <option value="{{ route('admin.villamanager.villa.index').'?area='.$area2->id }}" {{ $area2->id == request('area') ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;{{ $area2->name }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
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
                },
                "dom" : "<'row'<'col-sm-4'l><'col-sm-4 select-area form-inline'><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                initComplete: function () {
                    $('.select-area').html($('#area-html').html());
                }
            });
        });
    </script>
@stop
