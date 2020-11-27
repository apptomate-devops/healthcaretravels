@extends('layout.master') @section('title','Profile') @section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/property.css') }}">
    <input type="hidden" value="0" id="start_date_hidden"/>
    <div class="container add-calendar">
        <div class="row">

            <div class="col-md-12">

                <hr>
                <div class="style-1">

                    <div class="dashboard-header">

                        <div class=" user_dashboard_panel_guide">

                            @include('owner.add-property.menu')

                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div class="tabs-container">
                        <div id='wrap1'>
                            <label style="margin-top: 30px;">Select and drag to block out dates for this listing:</label>
                        </div>
                        <center><div id='calendar' style="max-width: 600px;margin-top: 15px;margin-bottom: 15px;"></div></center>
                    </div>

                    <div id="wrap2">


                            <div class="col-md-3"></div>
                            <div class="col-md-6" style="padding-bottom: 50px;padding-top: 15px;">

                                <div class="style-2">
                                    <!-- Tabs Navigation -->
                                    <ul class="tabs-nav">
                                        <li class="active">
                                            <a href="#tab1a">
                                                <i class="sl sl-icon-pin"></i>
                                                My iCal Link
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab2a">
                                                <i class="sl sl-icon-pin"></i>
                                                Add Another iCal
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tabs Content -->
                                    <div class="tabs-container">
                                        <div class="tab-content" id="tab1a">
                                            <center>
                                                <?php $ical_url = BASE_URL . 'ical/' . $property_details->id; ?>
                                                <p style="margin-bottom: 0;">My iCal Link :  <a id="my_ical_url_text" href="{{$ical_url}}">{{$ical_url}}</a></p>
                                                <div id="my_ical_url_copy" style="color: #b0b0b0; cursor: pointer;">click here to copy</div>
                                                <br>
                                            </center>
                                        </div>

                                        <div class="tab-content" id="tab2a" style="padding: 30px;">
                                            @component('components.upload-add-ical', ['property_id' => $property_details->id])
                                            @endcomponent
                                        </div>


                                    </div>

                                </div>
                                <form action="{{url('/')}}/owner/add-new-property/7" method="post" name="form-add-new" style="margin-top: 30px">
                                    <input type="hidden" name="property_id" value="{{$property_details->id}}">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <button type="submit" style="margin-bottom: 20px;float: right;" class="button preview margin-top-5" value="NEXT">FINISH</button>
                                </form>
                            </div>

                        <div class="modal fade in" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            Are you sure you want to delete blocking for these dates?
                                        </h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-default" id="btnDeleteEvent">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <div id="calendar_blocking_loading" class="loading style-2" style="display: none;"><div class="loading-wheel"></div></div>
    <script type="text/javascript">

        $(document).ready(function() {

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
                allDay: false,
                displayEventTime: false,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var check_start=$('#start_date_hidden').val();
                    var start_date=convert(start);

                    if(check_start==0)
                    {
                        $('#start_date_hidden').val(start_date);
                        $("[data-date='" + start_date + "']").attr("id", "start_date");
                    }

                    var title = 'Manual Dates - Property Not Available';
                    var pro_id = $("#property_id").val();
                    if(!pro_id){
                        alert("Please Select Property");
                        return false;
                    }
                    if (title) {
                        // var start_date=$('#start_date_hidden').val();
                        var end_date=convert(end, 1);
                        $('#calendar_blocking_loading').show();
                        var ajax_url = "{{BASE_URL}}"+"block_booking?title="+title+"&start="+start_date+"&end="+end_date+"&pro_id="+pro_id;
                        $.ajax({
                            url:ajax_url,
                            type:"GET",
                            success: function(data){
                                $('#calendar_blocking_loading').hide();
                                if (data.status === 'SUCCESS' && data.event_id) {
                                    calendar.fullCalendar('renderEvent', { title, start, end: get_end_date(start_date, end_date), allDay, className: 'blocked', id: data.event_id});
                                } else {
                                    alert('Error while blocking date')
                                }
                            },
                            error: function (error) {
                                $('#calendar_blocking_loading').hide();
                                console.log('Error adding block dates: ', error);
                            }
                        });
                    }
                },
                eventClick: function(info) {
                    var eventId = info.id;
                    if (eventId) {
                        $('#btnDeleteEvent').data({eventId});
                        $('#confirmationModal').modal('show');
                    }
                },
                selectOverlap: function(event) {
                    return event.rendering === 'background';
                },
                events: [
                        @foreach($booked_events as $event)
                    {
                        title: "{{$property_details->title}} booked by {{Helper::get_user_display_name($event)}} from {{date("F d, Y", strtotime($event->start_date))}} to {{date("F d, Y", strtotime($event->end_date))}}",
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
                        id: "{{$eve->id}}"
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

            $('#btnDeleteEvent').click(function () {
                var btnData = $('#btnDeleteEvent').data();
                $('#confirmationModal').modal('hide');
                if(btnData.eventId) {
                    var pro_id = $("#property_id").val();

                    var ajax_url = `{{BASE_URL}}delete_block_booking?id=${btnData.eventId}&property_id=${pro_id}`;
                    $('#calendar_blocking_loading').show();
                    $.ajax({
                        url:ajax_url,
                        type:"GET",
                        success: function(data){
                            $('#calendar_blocking_loading').hide();
                            if (data.status === 'SUCCESS') {
                                calendar.fullCalendar('removeEvents', btnData.eventId);
                            } else {
                                alert('Error while blocking date')
                            }
                        },
                        error: function (error) {
                            $('#calendar_blocking_loading').hide();
                            console.log('Error adding block dates: ', error);
                        }
                    });
                }
            })
            $("#confirmationModal").on("hidden.bs.modal", function () {
                $('#btnDeleteEvent').data();
            });
        });

        function convert(dateObj, day = 0) {
            return dateObj.subtract(day, "days").format('YYYY-MM-DD'); // full day calendar end date display issue
        }
        function get_end_date(start_date, end_date) {
            if(start_date == end_date) { return end_date; }
            return moment(end_date, "YYYY-MM_DD").add(1, 'days'); // full day calendar end date display issue
        }

        $('#my_ical_url_copy').click(function (e) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#my_ical_url_text').text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('#my_ical_url_copy').text('copied!');
            $('#my_ical_url_copy').css({color: 'green'});
        });
    </script>

@endsection

