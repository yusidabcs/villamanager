


$( document ).ready(function() {

    $('#disable-date-form').on('submit',function () {
        var btn = this;
        $(this).find('button[type=submit]').button('loading');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (data) {

                toastr.success(data.message);

                if($('#calendar').length) {
                    $('#calendar').fullCalendar( 'refetchEvents' );
                }
            },
            error : function () {
                toastr.warning('Woops, something error!');
            },
            complete : function () {
                $(btn).find('button[type=submit]').button('reset');
            }

        });
        return false;
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    if($('#calendar').length){
        $('#calendar').fullCalendar({
            customButtons: {
                addButton: {
                    text: 'New Booking',
                    click: function() {
                        $('#add-booking').modal('show');
                    }

                },
                disableButtons : {
                    icon : 'circle-triangle-w',
                    click: function() {
                        if($('input[name=villa_id]').val() != ''){
                            $('#disable-date').modal('show');
                        }else{
                            alert('Select a villa.');
                        }

                    }
                },
                trashButton: {
                    text: 'Delete',
                }
            },
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'addButton,disableButtons,trashButton'
            },
            navLinks: false, // can click day/week names to navigate views
            selectable: false,
            selectHelper: true,
            displayEventTime : false,
            dragRevertDuration : 0,
            select: function(start, end) {

                $('input[name=start_date]').val(start.format('YYYY-MM-D'));
                $('input[name=end_date]').val(end.format('YYYY-MM-D'));

                eventData = {
                    title: 'Not saved yet',
                    start: start,
                    end: end
                };
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? =

                $('#calendar').fullCalendar('unselect');
            },
            eventResize: function(event, delta, revertFunc) {



                $('input[name=start_date]').val(event.start.format('YYYY-MM-D'));
                $('input[name=end_date]').val(event.end.subtract(1, 'seconds').format('YYYY-MM-D'));
                $('input[name=rate]').val(parseInt(event.title));
                $('input[name=id]').val(event.id);

                if (!confirm("is this okay?")) {
                    revertFunc();
                }

            },
            selectOverlap: function(event) {
                return event.rendering === 'background';
            },

            eventOverlap: function(stillEvent, movingEvent) {
                return false;
            },
            eventAfterAllRender : function () {
                $(".fc-disableButtons-button").html("<i class=\"fa fa-calendar-times-o\" aria-hidden=\"true\"></i>");

                $('.fc-disableButtons-button').tooltip({
                    'trigger': 'hover',
                    'title' : 'Disable date for booking'
                });

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
                    if(window.confirm("delete this?")){

                        $('#calendar').fullCalendar('removeEvents', event._id);

                        $.ajax({
                            url : $('#calendar').attr('data-disable')+'/'+event.id,
                            method : 'delete',
                        }).success(function(data){
                            toastr.success(data.message)

                        });
                    }

                }
            },

            eventDrop: function(event, delta, revertFunc) {
                $('input[name=start_date]').val(event.start.format('YYYY-MM-D'));
                $('input[name=end_date]').val(event.end.subtract(1, 'seconds').format('YYYY-MM-D'));
                $('input[name=rate]').val(parseInt(event.title.split(' ~ ')[1]));
                $('input[name=name]').val(event.title.split(' ~ ')[0]);
                $('input[name=id]').val(event.id);
            },

            eventClick: function(event, jsEvent, view) {

                return false;

            },
            eventRender: function(event, element) {
                if(event.type != 'disable_date'){
                    element.qtip({
                        content: {
                            text: '<table class="table table-hover">' +
                            '<tr><td>Check In</td><td>:</td><td>'+event.start.format('DD MMMM YYYY')+' 14:00 pm</td></tr>' +
                            '<tr><td>Check Out</td><td>:</td><td>'+event.end.format('DD MMMM YYYY')+' 12:00 pm</td></tr>' +
                            '<tr><td>Total Guest</td><td>:</td><td>'+event.total_guest+'</td></tr>' +
                            '</table>'+
                            '<center><a href="'+event.url+'" class="btn btn-sm btn-info">Detail</a></center>',
                            title: {
                                text: event.title,
                                button: true
                            }
                        },
                        position: {
                            my: 'bottom center',
                            at: 'top center',
                            target: 'mouse',
                            viewport: $('#calendar'),
                            adjust: {
                                mouse: false,
                                scroll: false
                            }
                        },
                        style: 'qtip-light'
                    }); // end of element.qtip({
                }

            }, // end of eventRender

            events : $('#calendar').attr('data-url')



        });
    }


    $('select').select2({
        theme: "bootstrap"
    });

    $('#select-villa').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    });


    function checkInvalidDate(date) {
        var formattedDate = date.format('YYYY-MM-DD');
        if(disableDays !== undefined){
            var array = JSON.parse("[" + disableDays.booking_date + "]");
            unavailableDates = array[0];
            if ($.inArray(formattedDate.toString(), array[0]) != -1){
                return true;
            }
        }

        return false;

    }

    var startDate = null;
    $('#total_stay').on('focusin', function(){
        $(this).data('val', $(this).val());
    });
    $('#total_stay').on('change',function () {
        if(startDate != null)
        {
            var total_stay = $(this).val();
            var check_in = startDate
            var check_out = moment(startDate ).add(total_stay,'days');
            var s = check_overlaping(check_in.format('YYYY-MM-DD'),check_out.format('YYYY-MM-DD'));
            if(s){
                $('input[name=check_in]').val(check_in.format('YYYY-MM-DD 14:00:00'));
                $('input[name=check_out]').val(check_out.format('YYYY-MM-DD 12:00:00'));
                $('#check_out_text').html(check_out.format('DD MMMM YYYY 12:00'));
            }else{

                $(this).val($(this).data('val'));
                toastr.warning('There is booked date in your booking date range');
                $('#daterange').data('daterangepicker').show();
            }
        }
    });
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {

        var total_stay = $('#total_stay').val();
        var check_in = picker.startDate;
        startDate = check_in;
        var check_out = moment(picker.startDate).add(total_stay,'days');
        var s = check_overlaping(check_in.format('YYYY-MM-DD'),check_out.format('YYYY-MM-DD'));
        if(s){
            $('input[name=check_in]').val(check_in.format('YYYY-MM-DD 14:00:00'));
            $('input[name=check_out]').val(check_out.format('YYYY-MM-DD 12:00:00'));
            $('#check_out_text').html(check_out.format('DD MMMM YYYY 12:00'));
        }else{
            $('#daterange').data('daterangepicker').show();
            toastr.warning('There is booked date in your booking date range');
        }

    }).on('show.daterangepicker',function (e, picker) {
        var total_stay = $('#total_stay').val();
        var check_out = moment(picker.startDate).add(total_stay,'days');
        $('#check_out_text').html(check_out.format('DD MMMM YYYY 12:00'));
    });
    $('#villa_id').on('change',function(){
        var url = $(this).find(':selected').data('url');
        var checkprice = $(this).find(':selected').data('checkprice');
        if(url === undefined)
            return;
        $.ajax({
            method : 'get',
            url : url
        }).success(function(data){
            disableDays = data;
            $('#total_guest').attr('max',data.max_person);
            $('#daterange').daterangepicker({
                locale: {
                    format: 'DD-MMMM-YYYY'
                },
                singleDatePicker : true,
                minDate : moment(),
                startDate: moment(),
                endDate: moment().add(1,'days').format('DD-MM-YYYY'),
                isInvalidDate: checkInvalidDate,
            });
            $('#daterange').data('daterangepicker').show();
        });
    });

    function check_overlaping(start,end){
        var status  = true;
        var array = JSON.parse("[" + disableDays.booking_date + "]");
        var unavailableDates = array[0];

        $.each(unavailableDates, function( index, value ) {
            if(moment(value).isBetween(start,end)){
                status = false;
                return false;
            }
        });
        return status;
    }
    function init_datepicker(){
        var now = new Date();
        var dpOptions = {
            format: 'yyyy-mm-dd',
            startDate: now,
            setDate: now,

        };
        var i = 0;
        var datePicker1 = $("#start_date").
        datepicker(dpOptions).
        on('changeDate', function (e) {
            var d = new Date(e.date.getFullYear(),(e.date.getMonth()),e.date.getDate());
            d.setDate(d.getDate());
            datePicker2.datepicker('setStartDate', d);
            datePicker2.datepicker('setDate', $("#end_date").val());
            datePicker2.datepicker('update');
        });
        var datePicker2 = $("#end_date").
        datepicker({
            format: 'yyyy-mm-dd',
        }).
        on('changeDate', function (e) {
            datePicker1.datepicker('setEndDate', e.date);
            datePicker1.datepicker('update');
        });
    }
    init_datepicker();
});
