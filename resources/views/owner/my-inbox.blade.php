@section('title')
    Inbox | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')


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

        <div class="col-md-8">
            <table class="manage-table responsive-table">

                <tr>
                    <th><i class="fa fa-inbox"></i> My Inbox</th>
                    {{-- <th class="expire-date"><i class="fa fa-calendar"></i> Status</th> --}}
                    <th></th>
                </tr>

                <!-- Item #1 -->
                @foreach($properties[0] as $property)
                @if(isset($property->traveller) != 0)
                <tr>
                    <td class="title-container" style="position: relative;">

                        @if($property->traveller->profile_image != null)
                        <img class="rounded" src="{{$property->traveller->profile_image}}" onerror="this.onerror=null;this.src='/user_profile_default.png';" alt="">
                        @else
                        <img class="rounded" src="/user_profile_default.png" alt="">
                        @endif
                        @if(isset($property->has_unread_message) && $property->has_unread_message)
                        <span class="unread_message_badge"></span>
                        @endif
                        <div class="title">
                            <h4><a href="{{BASE_URL}}owner-profile/{{$property->traveller->id}}">{{Helper::get_user_display_name($property->traveller)}}</a></h4>
                            <span>
                             User Name: {{$property->last_message->message}} </span><br/>
                            <span> {{$property->last_message->status}} {{Helper::get_local_date_time(\Carbon\Carbon::parse($property->last_message->date . ' ' . $property->last_message->time), 'H:i a m-d-Y')}} </span>
                        </div>
                    </td>


                    <td class="action">
                        <button class="button mb-10" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';"><i class="fa fa-reply"></i> Reply</button>
                        {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                        <button class="button" onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" style="background-color: #e78016;" class="delete"><i class="fa fa-remove"></i> Delete</button>
                    </td>
                </tr>
                @endif
                @endforeach

                @foreach($properties[1] as $property)
                @if(isset($property->traveller) != 0)
                <tr>
                    <td class="title-container" style="position: relative;">

                        @if($property->traveller->profile_image != null)
                        <img class="rounded" src="{{$property->traveller->profile_image}}" onerror="this.onerror=null;this.src='/user_profile_default.png';" alt="">
                        @else
                        <img class="rounded" src="/user_profile_default.png" alt="">
                        @endif
                        @if(isset($property->has_unread_message) && $property->has_unread_message)
                        <span class="unread_message_badge"></span>
                        @endif
                        <div class="title">
                            <h4><a  href="{{BASE_URL}}owner-profile/{{$property->traveller->id}}">{{Helper::get_user_display_name($property->traveller)}}</a></h4>
                            <span> 
                            User Name : {{$property->last_message->message}} </span><br/>
                            <span> {{$property->last_message->status}} {{Helper::get_local_date_time(\Carbon\Carbon::parse($property->last_message->date . ' ' . $property->last_message->time), 'H:i a m-d-Y')}} </span>
                        </div>
                    </td>


                    <td class="action">
                        <button class="button mb-10" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';"><i class="fa fa-reply"></i> Reply</button>
                        {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                        <button class="button" style="background-color: #e78016;" onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" class="delete"><i class="fa fa-remove"></i> Delete</button>
                    </td>
                </tr>
                @endif
                @endforeach

                @foreach($properties[2] as $property)
                @if(isset($property->traveller) != 0)
                <tr>
                    <td class="title-container" style="position: relative;">

                        @if($property->traveller->profile_image != null)
                        <img class="rounded" src="{{$property->traveller->profile_image}}" onerror="this.onerror=null;this.src='/user_profile_default.png';" alt="">
                        @else
                        <img class="rounded" src="/user_profile_default.png" alt="">
                        @endif
                        @if(isset($property->has_unread_message) && $property->has_unread_message)
                        <span class="unread_message_badge"></span>
                        @endif
                        <div class="title">
                            <h4><a href="{{BASE_URL}}owner-profile/{{$property->traveller->id}}">{{Helper::get_user_display_name($property->traveller)}}</a></h4>
                            <span>
                            User Name : {{$property->last_message->message}} </span><br/>
                            <span> {{$property->last_message->status}} {{Helper::get_local_date_time(\Carbon\Carbon::parse($property->last_message->date . ' ' . $property->last_message->time), 'H:i a m-d-Y')}} </span>
                        </div>
                    </td>


                    <td class="action">
                        <button class="button mb-10" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';"><i class="fa fa-reply"></i> Reply</button>
                        {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                        <button class="button" style="background-color: #e78016;" onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" class="delete"><i class="fa fa-remove"></i> Delete</button>
                    </td>
                </tr>
                @endif
                @endforeach


            </table>
            {{-- <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a> --}}
        </div>

    </div>
</div>

<style>
    .unread_message_badge {
        position: absolute;
        bottom: 47px;
        height: 10px;
        background-color: red;
        width: 10px;
        left: 100px;
        border-radius: 50%;
    }

    .mb-10 {
        margin-bottom: 10;
    }
</style>
@endsection
