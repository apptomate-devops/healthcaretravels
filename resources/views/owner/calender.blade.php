@extends('layout.master')
@section('title')
    Owner calender | {{APP_BASE_NAME}}
@endsection
@section('main_content')
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 60%;
            background-color: #f2f2f2;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .container {
            padding: 2px 16px;
        }

        td {
            padding-top: .5em;
            padding-bottom: .5em;
        }

        ul.my-account-nav li a {
            font-size: 14px;
            line-height: 34px;
            color: black;
        }
        li.sub-nav-title {
            font-size: 16px;
        }
        #start_date{
            background : yellow !important;
        }

        .price{
            background-color: #0983b8;
        }
    </style>

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
                    center: 'title',
                    left: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: false,
                firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                selectable: false,
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
                selectHelper: false,
                select: function(start, end, allDay) {
                    var check_start=$('#start_date_hidden').val();
                    if(check_start==0)
                    {
                        var s_date=convert(start);
                        $('#start_date_hidden').val(convert(start));
                        $("[data-date='" + s_date + "']").attr("id", "start_date");
                    }

                    if($('#start_date_hidden').val()!=convert(start))
                    {

                        var e_date=convert(end);
                        $("[data-date='" + e_date + "']").attr("id", "start_date");
                        var roomtxt = $('#selector1  option:selected').text();
                        //var title = prompt('Block a Room', roomtxt);
                        var title = prompt('Block a Room', roomtxt);
                        var pro_id = $("#property").val();
                        if(pro_id == 0 || pro_id == " "){
                            alert("Please Select Property");
                            return false;
                        }


                        if (title) {
                            // alert(title);

                            // alert(allDay);
                            var start_date=$('#start_date_hidden').val();
                            var end_date=convert(end);
                            var ajax_url = "{{BASE_URL}}"+"block_booking?title="+title+"&start="+start_date+"&end="+end_date+"&pro_id="+pro_id;
                            $.ajax({
                                url:ajax_url,
                                type:"GET",
                                success: function(data){
                                    window.location.reload();
                                }

                            });

                            calendar.fullCalendar('renderEvent',
                                {
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay,
                                    className: 'reserved',
                                },

                                true // make the event "stick"
                            );
                        }
                    }
                    calendar.fullCalendar('unselect');
                },
                events: [
                    // place the added events
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

                        @for($i=0;$i<count($res);$i++)

                    {
                        title: "${{$res[$i]['price']}}",
                        start: "{{$res[$i]['date']}}",
                        end: "{{$res[$i]['date']}}",
                        className: 'available',
                    },

                    @endfor

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

        function convert(str) {
            var date = new Date(str),
                mnth = ("0" + (date.getMonth()+1)).slice(-2),
                day  = ("0" + date.getDate()).slice(-2);
            return [ date.getFullYear(), mnth, day ].join("-");
        }

    </script>

    <input type="hidden" value="0" id="start_date_hidden"/>
    <div class="container" style="margin-top: 35px;">
        <div class="row">


            <!-- Widget -->
            <div class="col-md-4">
                <div class="sidebar left">

                    <div class="my-account-nav-container">

                        @include('owner.menu')

                    </div>

                </div>
            </div>

            <div class="col-md-8 card">
                <div><br></div>
                <select class="chosen-select" id="property" onchange="property_change();">
                    <option value="0" selected="">Please select a property from the dropdown menu</option>
                    @foreach($properties as $property)
                        <option value="{{$property->id}}" @if($id == $property->id) selected="" @endif>
                            {{$property->title}}
                        </option>
                    @endforeach
                </select>
                <div><br></div>
            </div>

            <div class="col-md-8 card" style="margin-top: 20px;">
                <center><div id='calendar' style="max-width: 600px;margin-top: 15px;margin-bottom: 15px;"></div></center>
            </div>

            <div class="col-md-4"></div>
            <div class="col-md-8 card" style="margin-top: 20px;">
                @if($id != 0)
                    <h4>
                        {{APP_BASE_NAME}} Icalender :
                        <a href="{{BASE_URL}}ical/{{$id}}">
                            {{BASE_URL}}ical/{{$id}}
                        </a>
                    </h4>
                @else
                    <h4>Please select property</h4>
                @endif
            </div>

            @if($id != 0)
                <div class="col-md-4"></div>
                <div class="col-md-8 card" style="margin-top: 20px;">
                    <input type="hidden" id="property_id" name="property_id" value="{{$id}}">
                    <label style="margin-top: 20px;" >Enter Third party Name</label>
                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_name" placeholder="Enter Third party Name" name="ical_name">
                    <label>Enter Third party ICAL URL here</label>
                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_url" placeholder="Enter Third party ICAL URL here" name="ical_url">
                    <center>
                        <button type="button" id="add_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                            Add
                        </button>
                    </center>
                </div>
            @endif

            @foreach($icals as $ical)
                <div class="col-md-4"></div>
                <div class="col-md-8 card" style="margin-top: 20px;">
                    <input type="hidden" id="property_id" name="property_id" value="{{$id}}">
                    <label style="margin-top: 20px;" >Enter Third party Name</label>
                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_name" value="{{$ical->third_party_name}}" name="ical_name">
                    <label>Enter Third party ICAL URL here</label>
                    <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_url" value="{{$ical->third_party_url}}" name="ical_url">

                    <button type="button" id="update_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                        Delete
                    </button>

                    <button type="button" id="update_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                        Update
                    </button>

                </div>
            @endforeach

        </div>
    </div>

    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Modal header</h3>
        </div>
        <div class="modal-body">
            <p>One fine body…</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary">Save changes</button>
        </div>
    </div>


@endsection


@section('custom_script')

    <script type="text/javascript">

        function property_change() {
            // body...
            var id = $("#property").val();

            var url = window.location.protocol + "//" + window.location.host + "/owner/calender?id="+id;
            document.location = url;
        }
        // setInterval(function(){
        //     $(".fc-event-inner").css("background-color", "#ff556a");
        // }, 100);

    </script>

    <script type="text/javascript">
        $("#add_ical").click(function(){

            var property_id = $("#property_id").val();
            var ical_name = $("#ical_name").val();
            var ical_url = $("#ical_url").val();

            if(ical_name == "" || ical_url == "")
            {
                show_snackbar("Please fill all fields");
                setTimeout(function(){ remove_snackbar(); }, 4000);
            }
            var ajax_url = "{{BASE_URL}}"+"add-calender/"+property_id+"?ical_name="+ical_name+"&ical_url="+ical_url;
            $.ajax({
                url:ajax_url,
                type:"get",
                beforeSend: function() {
                    show_snackbar("Loading...");
                },
                success: function(data){
                    show_snackbar("Calender added successfully");
                    $("#ical_name").val("");
                    $("#ical_url").val("");
                    setTimeout(function(){ remove_snackbar(); }, 4000);
                    $("#ical_name").focus();
                },
                error: function(){
                    show_snackbar("Please fill all fields");
                    setTimeout(function(){ remove_snackbar(); }, 4000);
                }
            });

        });
    </script>
@endsection
