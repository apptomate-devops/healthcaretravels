@extends('layout.master') @section('title','Profile') @section('main_content')

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
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
            allDaySlot: false,
            selectHelper: true,
            select: function(start, end, allDay) {
                var roomtxt = $('#selector1  option:selected').text();
                var title = prompt('Block a Room', roomtxt);
                if (title) {
                    calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay,
                            className: 'reserved',
                        },

                        false // make the event "stick"
                    );
                    // var room = $('#selector1  option:selected').val();
                    // $.ajax({
                    //     type: "POST",
                    //     url: 'calendarViewAjax',
                    //     data: {date: start , room: room },
                    //     success: function( result ) {
                    //         result = $.parseJSON(result);
                    //         $('#calendar').html('');
                    //         calendar = $("#calendar").fullCalendar({
                    //             events: result
                    //         });
                    //     }
                    // });
                    
                    // $.ajax({
                    //     type: "POST",
                    //     url: 'calendarViewAjax',
                    //     data: {room: room },
                    //     success: function( result ) {
                    //         result = $.parseJSON(result);
                    //         $('#calendar').html('');
                    //         calendar = $("#calendar").fullCalendar({
                    //             events: result
                    //         });
                    //     }
                    // });
                }
                calendar.fullCalendar('unselect');
            },


            events: [
            @foreach($events as $event)
            {
                title: 'Test',
                start: "{{$event->start_date}}",
                end: "{{$event->end_date}}",
                className: 'reserved',
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
    


</script>

    <div class="container" style="margin-top: 35px;">
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

                        <div id='wrap2'>
                           <center><div id='calendar' style="max-width: 600px;margin-top: 15px;"></div></center>
                        </div>

                        <div id="wrap2" style="padding-bottom: 100px;">



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
                                                    <p>Ical URL :  <a href="{{$constants['base_url']}}ical/{{$property_details->id}}">{{$constants['base_url']}}ical/{{$property_details->id}}</a></p>
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

@endsection


@section('custom_script')

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
