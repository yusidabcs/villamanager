@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::rates.title.create rate') }} : {{$villa->name}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.villamanager.rate.index') }}">{{ trans('villamanager::rates.title.rates') }}</a></li>
        <li class="active">{{ trans('villamanager::rates.title.create rate') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.print.css" rel="stylesheet" media='print' />

    <style type="text/css">
        #calendar {
        max-width: 900px;
        margin: 0 auto;
    }

    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    @include('villamanager::admin.rates.partials.create-fields')
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.villamanager.rate.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {


            var eventx = {};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                }
            });

            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            var start_resize;

            $('#calendar').fullCalendar({
                customButtons: {
                    trashButton: {
                        text: 'Drop Rate Here to Delete',
                    }
                },
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'trashButton'
                },
                navLinks: false, // can click day/week names to navigate views
                selectable: true,
                selectHelper: true,
                select: function(start, end) {

                    var temp = end;
                    $('input[name=start_date]').val(start.format('YYYY-MM-DD'));
                    $('input[name=end_date]').val(temp.subtract(1,'day').format('YYYY-MM-DD'));

                    eventData = {
                        title: 'Not saved yet',
                        start: start,
                        end: end.add(1,'day')
                    };
                    $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? =

                    $('#calendar').fullCalendar('unselect');
                },
                eventResizeStart : function (event, jsEvent, ui, view) {
                    start_resize = event.end;
                },
                eventResize: function(event, delta, revertFunc) {
                    var temp = event;
                    if(start_resize.isBefore(temp.end))
                        event.end.add(24, 'h')

                    $('input[name=start_date]').val(event.start.format('YYYY-MM-DD'));
                    $('input[name=end_date]').val(temp.end.subtract(1, 'seconds').format('YYYY-MM-DD'));
                    $('input[name=rate]').val(parseInt(event.title.split(' ~ ')[1]));
                    $('input[name=name]').val(event.title.split(' ~ ')[0]);
                    $('input[name=id]').val(event.id);

                    if (!confirm("is this okay?")) {
                        revertFunc();
                    }

                },
                editable: true,
                eventDurationEditable : true,
                eventLimit: true, // allow "more" link when too many events
                selectOverlap: function(event) {
                    return event.rendering === 'background';
                },
                eventOverlap: function(stillEvent, movingEvent) {
                    return false;
                },

                eventDragStop: function(event,jsEvent) {
                    var trashEl = jQuery('.fc-trashButton-button');
                    var ofs = trashEl.offset();

                    var x1 = ofs.left;
                    var x2 = ofs.left + trashEl.outerWidth(true);
                    var y1 = ofs.top;
                    var y2 = ofs.top + trashEl.outerHeight(true);

                    if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                        jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                        if(window.confirm("delete this rate?")){
                            console.log(event);
                            $('#calendar').fullCalendar('removeEvents', event._id);
                            $('input[name=start_date]').val("");
                            $('input[name=end_date]').val("");
                            $('input[name=rate]').val("");
                            $('input[name=id]').val("");
                            $('input[name=name]').val("");

                            if(event.id != undefined){
                                $.ajax({
                                    url : $('#calendar').attr('data-delete')+'/'+event.id,
                                    method : 'delete',
                                }).success(function(data){
                                    console.log(data);
                                });
                            }
                        }

                    }
                },

                eventDrop: function(event, delta, revertFunc) {

                    $('input[name=start_date]').val(event.start.format('YYYY-MM-DD'));
                    $('input[name=end_date]').val(event.end.subtract(1, 'seconds').format('YYYY-MM-DD'));
                    $('input[name=rate]').val(parseInt(event.title.split(' ~ ')[1]));
                    $('input[name=name]').val(event.title.split(' ~ ')[0]);
                    $('input[name=id]').val(event.id);

                },

                eventClick: function(event, jsEvent, view) {

                    $('input[name=start_date]').val(event.start.format('YYYY-MM-DD'));
                    $('input[name=end_date]').val(event.end.subtract(1, 'seconds').format('YYYY-MM-DD'));
                    $('input[name=rate]').val(parseInt(event.title.split(' ~ ')[1]));
                    $('input[name=name]').val(event.title.split(' ~ ')[0]);
                    $('input[name=id]').val(event.id);

                    eventx = event;
                    $('#start_date').datepicker('setStartDate', event.start.format('YYYY-MM-DD'));
                    $('#start_date').datepicker('setEndDate', event.end.subtract(1, 'seconds').format('YYYY-MM-DD'));

                    $('#end_date').datepicker('setStartDate', event.start.format('YYYY-MM-DD'));
                },

                dragRevertDuration : 0,

                dayClick: function(date, allDay, jsEvent, view) {
                    var now = new Date();
                    if (date.setHours(0,0,0,0) < now.setHours(0,0,0,0)){
                        alert('test');
                    }
                    else{
                         return;
                    }
                },

        
                events : <?php echo json_encode($rates);?>
            });
            var start, end = null;
            $("#start_date").datepicker({
                autoclose: true,
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#end_date').datepicker('setStartDate', minDate);
                start = minDate;
                s = moment(start);

                if(end!=null)
                    check_overlaping(s,end);

                if(eventx.id !== undefined){
                    eventx.start = new Date(minDate.getTime() + 1380*60000);
                    $('#calendar').fullCalendar('updateEvent', eventx);
                }
            });
            $("#end_date").datepicker()
                    .on('changeDate', function (selected) {
                        var minDate = new Date(selected.date.valueOf());
                        end = moment(minDate);
                        start = moment(start);
                        $('#start_date').datepicker('setEndDate', minDate);

                        check_overlaping(start,end);

                    });

            function check_overlaping(start,end){
                var allEvents = [];
                allEvents = $('#calendar').fullCalendar('clientEvents');
                var status = true;
                start.add(1,'day');
                end.subtract(1,'day');
                allEvents.forEach(function (e) {
                    console.log(eventx.id);
                    if(e.id != eventx.id){
                        if(e.start.format('YYYY-MM-DD') <= start.format('YYYY-MM-DD') && end.format('YYYY-MM-DD') <= e.end.format('YYYY-MM-DD')){
                            status = false;
                            return;
                        }
                        // Range intersects with other start ?
                        if((start.format('YYYY-MM-DD') <= e.start.format('YYYY-MM-DD') ) && (end.format('YYYY-MM-DD') <= e.end.format('YYYY-MM-DD') && end.format('YYYY-MM-DD') >= e.start.format('YYYY-MM-DD'))) {
                            status = false;
                            return ;
                        }
                        // Range intersects with other end ?

                        if((start.format('YYYY-MM-DD') >= e.start.format('YYYY-MM-DD') && start.format('YYYY-MM-DD') <= e.end.format('YYYY-MM-DD')) && (end.format('YYYY-MM-DD') >= e.end.format('YYYY-MM-DD'))) {
                            status = false;
                            return ;
                        }
                    }

                });
                if(status == false){
                    alert('Rate overlapping with other.');
                    return;
                }

                start.subtract(1,'day');
                end.add(2,'day');
                if(eventx.id === undefined){
                    var event = {};
                    event.id = 'new_rate';
                    event.title = 'new rate';
                    event.start = start;
                    event.end = end;
                    event.allDay = 'allDay';

                    $('#calendar').fullCalendar( 'removeEvents', event.id);
                    $('#calendar').fullCalendar( 'renderEvent', event,true);

                }else{
                    eventx.end = end.add(1,'d');
                    $('#calendar').fullCalendar('updateEvent', eventx);
                }
            }

        });


    </script>
@stop