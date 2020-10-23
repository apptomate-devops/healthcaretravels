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
            /* initialize the external events
            -----------------------------------------------------------------*/

            $('#external-events div.external-event').each(function() {

                var eventObject = {
                    title: $.trim($(this).text())
                };
                $(this).data('eventObject', eventObject);
                $(this).draggable({
                    zIndex: 999,
                    revert: true,
                    revertDuration: 0
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
                events: [
                    // place the added events
                        @foreach($booked_events as $event)
                    {
                        title: "{{$property_title}} booked by {{$event->username}} from {{date("F d, Y", strtotime($event->start_date))}} to {{date("F d, Y", strtotime($event->end_date))}}",
                        start: "{{$event->start_date}}",
                        end: get_end_date("{{$event->start_date}}", "{{$event->end_date}}"),
                        className: 'booked',
                    },
                        @endforeach
                        @foreach($block_events as $eve)
                    {
                        title: "{{$eve->booked_on}}",
                        start: "{{$eve->start_date}}",
                        end: get_end_date("{{$eve->start_date}}", "{{$eve->end_date}}"),
                        className: 'blocked',
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

        function get_end_date(start_date, end_date) {
            if(start_date == end_date) { return end_date; }
            return moment(end_date, "YYYY-MM_DD").add(1, 'days'); // full day calendar end date display issue
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
                <label for="property" style="margin-top: 10px;">Select a property:</label>
                <select class="chosen-select" id="property" onchange="property_change();">
                    <option value="0" selected style="display: none;">Please select a property from the dropdown menu</option>
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

            @if($id != 0)
                    <div class="col-md-4"></div>
                    <div class="col-md-8 card" style="margin-top: 20px;">
                        <label style="margin-top: 20px;">Upload an iCalendar from another booking site</label>
                        <div class="alert alert-info">
                            <span>
                                If your property is listed on another website like Airbnb, you can upload an iCalendar (.ics) file from that website to automatically block out dates that your property is not available.
                                Please be sure that the calendar you add only has events for stays at your property that were booked through alternate services. Any day with an event will be considered unavailable.
                            </span>
                        </div>
                        <form class="dropzone property-calender" id="upload_ical_form" method="post" action="{{url('/')}}/owner/upload-calender">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" id="property_id" name="property_id" value="{{$id}}">
                            <input type="hidden" id="calender_file" type="file" name="calender_file">
                            <div  class="dz-default dz-message">
                                <span>
                                    <i class="sl sl-icon-plus"></i> Click here or drop files to upload
                                </span>
                            </div>
                        </form>
                        <div class="calender-upload-alerts">
                            <div class="alert alert-danger" style="display: none">
                            <span>
                                Error in uploading calender events
                            </span>
                        </div>
                        <div class="alert alert-success" style="display: none">
                            <span>
                                Calender events are added successfully
                            </span>
                        </div>
                        </div>
                        <button type="submit" disabled id="upload_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                            Upload
                        </button>
                    </div>
                    <div id="calenderLoadingProgress" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>

            @endif

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
                <form method="get" action="{{url('/')}}/delete-calender/{{$ical->id}}">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 card" style="margin-top: 20px;">
                        <input type="hidden" id="property_id" name="property_id" value="{{$id}}">
                        <label style="margin-top: 20px;" >Enter Third party Name</label>
                        <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_name_{{$ical->id}}" value="{{$ical->third_party_name}}" name="ical_name">
                        <label>Enter Third party ICAL URL here</label>
                        <input style="margin-left: 10px;max-width: 518px;" type="text" id="ical_url_{{$ical->id}}" value="{{$ical->third_party_url}}" name="ical_url">

                        <button type="submit" id="delete_ical" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                            Delete
                        </button>

                        <button type="button" id="update_ical" data-id="{{$ical->id}}" class="button preview margin-top-5" style="margin-bottom: 20px;float: right;">
                            Update
                        </button>
                    </div>
                </form>
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
            var id = $("#property").val();
            var url = window.location.protocol + "//" + window.location.host + "/owner/calender?id="+id;
            document.location = url;
        }
    </script>

    <script type="text/javascript">
        function show_alert_message(msg = "Please fill all fields") {
            show_snackbar(msg);
            setTimeout(function(){ remove_snackbar(); }, 4000);
        };

        $("#add_ical").click(function(){

            var property_id = $("#property_id").val();
            var ical_name = $("#ical_name").val();
            var ical_url = $("#ical_url").val();

            if(ical_name == "" || ical_url == "") {
                show_alert_message();
                return;
            }
            var ajax_url = "{{BASE_URL}}"+"add-calender/"+property_id+"?ical_name="+ical_name+"&ical_url="+ical_url;
            $.ajax({
                url:ajax_url,
                type:"get",
                success: function(data){
                    if(data.status === 'SUCCESS') {
                        location.reload();
                    } else {
                        show_alert_message();
                    }
                },
                error: function(){ show_alert_message(); }
            });

        });
        $("#update_ical").click(function(){

            var id = $(this).data("id");
            var ical_name = $(`#ical_name_${id}`).val();
            var ical_url = $(`#ical_url_${id}`).val();
            if(ical_name == "" || ical_url == "" || !id) {
                show_alert_message();
                return;
            }

            var ajax_url = "{{BASE_URL}}"+"update-calender/"+id+"?ical_name="+ical_name+"&ical_url="+ical_url;
            $.ajax({
                url:ajax_url,
                type:"get",
                beforeSend: function() {
                    show_snackbar("Loading...");
                },
                success: function(data){
                    if(data.status === 'SUCCESS') {
                        show_alert_message("Calender updated successfully");
                    } else {
                        show_alert_message();
                    }
                },
                error: function(){
                    show_alert_message();
                }
            });

        });
    </script>
@endsection
