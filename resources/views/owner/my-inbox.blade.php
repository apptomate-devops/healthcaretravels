@extends('layout.master')
@section('title','Inbox')
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
                    <th></th>
                </tr>

                <!-- Item #1 -->
                @foreach($properties[0] as $property)
                <?php if (count($property->traveller) != 0) { ?>
                    <tr>
                        <td class="title-container">

                            @if($property->traveller->profile_image != null)
                            <img style="border-radius: 11px;" src="{{$property->traveller->profile_image}}" alt="">
                            @else
                            <img style="border-radius: 11px;" src="http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg" alt="">
                            @endif
                            <div class="title">
                                <h4><a href="#">{{$property->traveller->first_name}} {{$property->traveller->last_name}}</a></h4>
                                <span> {{$property->last_message}} </span>

                                <span class="table-property-price"></span>

                            </div>
                        </td>
                        <td>{{--<h4>Subject:</h4><h5>Message from keepers</h5>--}}</td>


              <td class="action">
                        <button class="button" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';" ><i class="fa fa-reply"></i> Reply</button>
                        {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                        <button class="button"  onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" style="background-color: #e78016;"  class="delete"><i class="fa fa-remove"></i> Delete</button>
                    </td>
                    </tr>
                <?php } ?>
                @endforeach

                @foreach($properties[1] as $property)
                <?php if (count($property->traveller) != 0) { ?>
                    <tr>
                        <td class="title-container">

                            @if($property->traveller->profile_image != null)
                            <img style="border-radius: 11px;" src="{{$property->traveller->profile_image}}" alt="">
                            @else
                            <img style="border-radius: 11px;" src="http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg" alt="">
                            @endif
                            <div class="title">
                                <h4><a href="#">{{$property->traveller->first_name}} {{$property->traveller->last_name}}</a></h4>
                                <span> {{$property->last_message}} </span>

                                <span class="table-property-price"></span>

                            </div>
                        </td>
                        <td>{{--<h4>Subject:</h4><h5>Message from keepers</h5>--}}</td>


                        <td clas                s="action">
                            <button class="button" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';" ><i class="fa fa-reply"></i> Reply</button>
                            {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                            <button class="button" style="background-color: #e78016;" onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" class="delete"><i class="fa fa-remove"></i> Delete</button>
                        </td>
                    </tr>
                <?php } ?>
                @endforeach

                @foreach($properties[2] as $property)
                <?php if (count($property->traveller) != 0) { ?>
                    <tr>
                        <td class="title-container">

                            @if($property->traveller->profile_image != null)
                            <img style="border-radius: 11px;" src="{{$property->traveller->profile_image}}" alt="">
                            @else
                            <img style="border-radius: 11px;" src="http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg" alt="">
                            @endif
                            <div class="title">
                                <h4><a href="#">{{$property->traveller->first_name}} {{$property->traveller->last_name}}</a></h4>
                                <span> {{$property->last_message}} </span>

                                <span class="table-property-price"></span>

                            </div>
                        </td>
                        <td>{{--<h4>Subject:</h4><h5>Message from keepers</h5>--}}</td>


                        <td class="action">
                            <button class="button" onclick="location.href ='{{url('/')}}/owner/chat/{{$property->id}}?fb-key={{$property->chat_key}}&fbkey={{$property->chat_key}}';" ><i class="fa fa-reply"></i> Reply</button>
                            {{--<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>--}}
                            <button class="button" style="background-color: #e78016;" onclick="location.href ='{{url('/')}}/delete_chat/{{$property->id}}';" class="delete"><i class="fa fa-remove"></i> Delete</button>
                        </td>
                    </tr>
                <?php } ?>
                @endforeach


            </table>
            {{-- <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a> --}}
        </div>

    </div>
</div>


@endsection