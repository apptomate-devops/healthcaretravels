@extends('layout.master') @section('title','Profile') @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">
    <input type="hidden" value="0" id="start_date_hidden"/>
    <div class="container add-calendar">
        <div class="row">

            <div class="col-md-12">

                <div class="style-1">

                    <div class="dashboard-header">

                        <div class=" user_dashboard_panel_guide">

                            @include('owner.add-property.menu')

                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div class="tabs-container">
                        <div id='wrap1'>
                            <label style="margin-top: 30px;">Select and drag to block out dates for this listing:</div>
                            <center><div id='calendar' style="max-width: 600px;margin-top: 15px;margin-bottom: 15px;"></div></center>
                        </div>

                        <div id="wrap2">

                            <form action="{{url('/')}}/owner/add-new-property/7" method="post" name="form-add-new">

                                <div class="col-md-3"></div>
                                <div class="col-md-6" style="padding-bottom: 50px;padding-top: 15px;">

                                    <div class="style-2">
                                        <!-- Tabs Navigation -->
                                        <ul class="tabs-nav">
                                            <li class="active">
                                                <a href="#tab1a">
                                                    <i class="sl sl-icon-pin"></i>
                                                    Keepers ICAL URL
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab2a">
                                                    <i class="sl sl-icon-pin"></i>
                                                    Add other ICAL URL
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tabs Content -->
                                        <div class="tabs-container">
                                            <div class="tab-content" id="tab1a">
                                                <center>
                                                    <p>Ical URL :  <a href="{{BASE_URL}}ical/{{$property_details->id}}">{{BASE_URL}}ical/{{$property_details->id}}</a></p>
                                                    <br>
                                                    <input type="hidden" name="id" value="{{$property_details->id}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                </center>
                                            </div>

                                            <div class="tab-content" id="tab2a">
                                                <form name="test" method="get" action="{{BASE_URL}}add-ical-url">
                                                    <input type="hidden" id="property_id" name="property_id" value="{{$property_details->id}}">
                                                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_name" placeholder="Enter Third party Name" name="ical_name">
                                                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_url" placeholder="Enter Third party ICAL URL here" name="ical_url">
                                                    <center>
                                                        <button type="button" id="add_ical" class="button preview margin-top-5" style="margin-bottom: 20px;">
                                                            Add
                                                        </button>
                                                    </center>
                                                </form>
                                            </div>


                                        </div>

                                        <button type="submit" style="margin-bottom: 20px;float: right;" class="button preview margin-top-5" value="NEXT">FINISH</button>
                                    </div>

                                </div>


                            </form>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function() {
            //$('#cale').hide();
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            /*  className colors

            className: default(transparent), important(red), chill(pink), success(green), info(blue)

            */


            /* initialize the external events
            -----------------------------------------------------------------*/

            $('#external-events div.external-event').each(function() {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });

            var calendar =  $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: false,
                firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                selectable: true,
                defaultView: 'month',

                axisFormat: 'h:mm',
                columnFormat: {
                    month: 'ddd',    // Mon
                    week: 'ddd d', // Mon 7
                    day: 'dddd M/d',  // Monday 9/7
                    agendaDay: 'dddd d'
                },
                titleFormat: 'MMM - YYYY',
                allDaySlot: false,
                selectHelper: true,
                // select: function(start, end, allDay) {
                //     var roomtxt = $('#selector1  option:selected').text();
                //     var title = prompt('Block a Room', roomtxt);
                //     if (title) {
                //         calendar.fullCalendar('renderEvent',
                //             {
                //                 title: title,
                //                 start: start,
                //                 end: end,
                //                 allDay: allDay,
                //                 className: 'reserved',
                //             },
                //
                //             false // make the event "stick"
                //         );
                //         // var room = $('#selector1  option:selected').val();
                //         // $.ajax({
                //         //     type: "POST",
                //         //     url: 'calendarViewAjax',
                //         //     data: {date: start , room: room },
                //         //     success: function( result ) {
                //         //         result = $.parseJSON(result);
                //         //         $('#calendar').html('');
                //         //         calendar = $("#calendar").fullCalendar({
                //         //             events: result
                //         //         });
                //         //     }
                //         // });
                //
                //         // $.ajax({
                //         //     type: "POST",
                //         //     url: 'calendarViewAjax',
                //         //     data: {room: room },
                //         //     success: function( result ) {
                //         //         result = $.parseJSON(result);
                //         //         $('#calendar').html('');
                //         //         calendar = $("#calendar").fullCalendar({
                //         //             events: result
                //         //         });
                //         //     }
                //         // });
                //     }
                //     calendar.fullCalendar('unselect');
                // },
                select: function(start, end, allDay) {
                    var check_start=$('#start_date_hidden').val();
                    var start_date=convert(start);

                    if(check_start==0)
                    {
                        $('#start_date_hidden').val(start_date);
                        $("[data-date='" + start_date + "']").attr("id", "start_date");
                    }

                    // var e_date=convert(end);
                    // $("[data-date='" + e_date + "']").attr("id", "start_date");
                    var roomtxt = $('#selector1  option:selected').text();
                    //var title = prompt('Block a Room', roomtxt);
                    var title = 'Manual Dates - Property Not Available';
                    var pro_id = $("#property_id").val();
                    if(!pro_id){
                        alert("Please Select Property");
                        return false;
                    }
                    if (title) {
                        // var start_date=$('#start_date_hidden').val();
                        var end_date=convert(end);
                        var ajax_url = "{{BASE_URL}}"+"block_booking?title="+title+"&start="+start_date+"&end="+end_date+"&pro_id="+pro_id;
                        $.ajax({
                            url:ajax_url,
                            type:"GET",
                            success: function(data){
                                calendar.fullCalendar('renderEvent',
                                    { title, start, end, allDay: allDay, className: 'booked',},
                                    true // make the event "stick"
                                );
                                // window.location.reload();
                            },
                            error: function (error) {
                                console.log('Error adding block dates: ', error);
                            }
                        });
                    }
                    // calendar.fullCalendar('unselect');
                },


                events: [
                        @foreach($events as $event)
                    {
                        title: "{{$event->booked_on}}",
                        start: "{{$event->start_date}}",
                        end: "{{$event->end_date}}",
                        className: 'blocked',
                    },
                        @endforeach
                        @foreach($block_events as $eve)
                    {
                        title: "{{$eve->booked_on}}",
                        start: "{{$eve->start_date}}",
                        end: "{{$eve->end_date}}",
                        className: 'booked',
                    },
                    @endforeach

                ],

                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                }
            });

        });

        function convert(dateObj) {
            return new Date(dateObj).toISOString().split('T')[0];
        }

    </script>

@endsection


@section('custom_script')

    <script type="text/javascript">
        function show_alert_message(msg = "Please fill all fields") {
            show_snackbar(msg);
            setTimeout(function(){ remove_snackbar(); }, 4000);
            return false;
        };

        $("#add_ical").click(function(){

            var property_id = $("#property_id").val();
            var ical_name = $("#ical_name").val();
            var ical_url = $("#ical_url").val();

            if(ical_name == "" || ical_url == "") { show_alert_message(); }
            var ajax_url = "{{BASE_URL}}"+"add-calender/"+property_id+"?ical_name="+ical_name+"&ical_url="+ical_url;
            $.ajax({
                url:ajax_url,
                type:"get",
                beforeSend: function() {
                    show_snackbar("Loading...");
                },
                success: function(data){
                    if(data.status === 'SUCCESS') {
                        $("#ical_name").val("");
                        $("#ical_url").val("");
                        $("#ical_name").focus();
                        show_alert_message("Calender added successfully");
                    } else {
                        show_alert_message();
                    }
                },
                error: function(){ show_alert_message(); }
            });

        });
    </script>
@endsection
