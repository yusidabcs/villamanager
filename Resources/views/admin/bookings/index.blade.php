@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::bookings.title.bookings') }} <a href="{{ route('admin.villamanager.booking.index') }}?view=calendar"><i class="fa fa-calendar"></i></a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('villamanager::bookings.title.bookings') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>{{ trans('villamanager::bookings.table.name') }}</th>
                            <th>Status</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#<a href="{{ route('admin.villamanager.booking.edit',$booking->id) }}">{{ $booking->booking_number }}</a></td>
                            <td>
                            <a href="{{ route('admin.villamanager.booking.edit',$booking->id) }}">
                                    {{ $booking->villa ? $booking->villa->name : 'No villa in this booking' }}
                                    </a>
                            </td>
                            <td>
                                @if($booking->status == 0)
                                  <span class="label label-warning">Pending</span>
                                  @elseif($booking->status == 1)
                                  <span class="label label-success">Paid</span>
                                  @else
                                  <span class="label label-primary">Cancel</span>
                                  @endif

                            </td>
                            <td>
                                <a href="{{ route('admin.villamanager.booking.edit',$booking->id) }}">
                                    {{ $booking->created_at }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">

                                    <a href="{{ route('admin.villamanager.booking.edit',$booking->id) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>

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
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
