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
                        title: "{{$property_title}} booked by {{Helper::get_user_display_name($event)}} from {{date("F d, Y", strtotime($event->start_date))}} to {{date("F d, Y", strtotime($event->end_date))}}",
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
                    @component('components.upload-add-ical', ['property_id' => $id,])
                    @endcomponent
                </div>

            @endif

            <div class="col-md-4"></div>
            <div class="col-md-8 card" style="margin-top: 20px;margin-bottom: 20px;">
                @if($id != 0)
                    <?php $ical_url = BASE_URL . 'ical/' . $id; ?>
                    <h4>
                        {{APP_BASE_NAME}} Icalender :
                        <a id="my_ical_url_text" href="{{$ical_url}}">{{$ical_url}}</a>
                        <span id="my_ical_url_copy" style="color: #b0b0b0; cursor: pointer;">&nbsp;(click here to copy)</span>
                    </h4>
                @else
                    <h4>Please select property</h4>
                @endif
            </div>
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
        $('#my_ical_url_copy').click(function (e) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#my_ical_url_text').text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('#my_ical_url_copy').text('(copied!)');
            $('#my_ical_url_copy').css({color: 'green'});
        });
    </script>
@endsection
