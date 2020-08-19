<?php date_default_timezone_set(TIMEZONE); ?>
@extends('layout.master')
@section('title')
{{APP_BASE_NAME}} Chat
@endsection

@section('main_content')

<style type="text/css">
        .chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message>li {
            background: #0983b8 !important;
        }
        .chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message>li:first-child:before {
            border-left-color: #0983b8 !important;
        }
        .md-user-image {
            width: 34px !important;
            height: 33px !important;
            border-radius: 50%;
        }
        ul.my-account-nav li a {
            font-size: 14px;
            line-height: 34px;
            color: black;
        }
        li.sub-nav-title {
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="{{ URL::asset('assets/icons/flags/flags.min.css') }}" media="all">
    <!-- style switcher -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style_switcher.min.css') }}" media="all">
    <!-- altair admin -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.min.css') }}" media="all">
    <!-- themes -->
    {{--   <link rel="stylesheet" href="{{ URL::asset('assets/css/themes/themes_combined.min.css') }}" media="all"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
    <script src="https://code.angularjs.org/1.4.4/angular-route.min.js"></script>

    <!-- Firebase -->
    <script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>

    <!-- AngularFire -->
    <script src="https://cdn.firebase.com/libs/angularfire/1.1.2/angularfire.min.js"></script>
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




            <div class="col-md-8" ng-app="myApp">
                <!--  <div id="page_content"><div id="page_content_inner"> -->
                <!-- <div class="uk-width-medium-8-10 uk-container-center"> -->
                <!--   <div class="uk-grid uk-grid-collapse" data-uk-grid-margin><div class="uk-width-large-7-10"> -->
                <div class="md-card md-card-single" ng-controller="ListController">
                    <div class="md-card-toolbar">
                        <div class="md-card-toolbar-actions hidden-print">
                            <!--  <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}"><i class="md-icon material-icons">&#xE3B7;</i><div class="uk-dropdown"><ul class="uk-nav" id="chat_colors"><li class="uk-nav-header">Message Colors</li><li class="uk-active"><a href="#" data-chat-color="chat_box_colors_a">Grey/Green</a></li><li><a href="#" data-chat-color="chat_box_colors_b">Blue/Dark Blue</a></li><li><a href="#" data-chat-color="chat_box_colors_c">Orange/Light Gray</a></li><li><a href="#" data-chat-color="chat_box_colors_d">Deep Purple/Light Grey</a></li></ul></div></div> -->
                            <i class="material-icons">&#xE314;</i>
                        </div>
                        <h3 class="md-card-toolbar-heading-text large">
                            <span class="uk-text-muted">Chat with</span>
                            <a href="#">{{$owner->first_name}} {{$owner->last_name}}</a>

                        </h3>
                    </div>
                    <div class="md-card-content padding-reset">
                        <div class="chat_box_wrapper">
                            <div class="chat_box touchscroll chat_box_colors_a" id="chat" >

                                <div ng-if="loader">

                                </div>
                                <img ng-hide="loader == 'yes'" src="http://52.14.214.241/public/loader.gif" style="height: 100px;margin-left: 300px;margin-top: 20px;">

                                <div ng-repeat="message in messages" ng-hide="header == 1">
                                    <div ng-show="message.id == 'start'"><%message.start_date%></div>
                                <input type="hidden" name="" value="{{$traveller_id}}" ng-model="userid">
                                <div class="chat_message_wrapper" ng-show="message.sent_by != userid">
                                    <div class="chat_user_avatar">
                                        @if($owner->profile_image != " ")
                                            <img class="md-user-image" src="{{$owner->profile_image}}" alt=""/>
                                        @else
                                            <img class="md-user-image" src="https://cdn1.iconfinder.com/data/icons/flat-business-icons/128/user-512.png" alt=""/>
                                        @endif
                                    </div>
                                    <ul class="chat_message">
                                        <li>
                                            <p>
                                                <%message.message%>
                                                <span class="chat_message_time"><%message.date%></span>
                                            </p>
                                        </li>

                                    </ul>
                                </div>

                                <div class="chat_message_wrapper chat_message_right" ng-show="message.sent_by == userid">
                                    <div class="chat_user_avatar">
                                        @if($traveller->profile_image != " ")
                                            <img class="md-user-image" src="{{$traveller->profile_image}}" alt=""/>
                                        @else
                                            <img class="md-user-image" src="https://cdn1.iconfinder.com/data/icons/flat-business-icons/128/user-512.png" alt=""/>
                                        @endif

                                    </div>
                                    <ul class="chat_message">
                                        <li>
                                            <p>
                                                <%message.message%>
                                                <span class="chat_message_time"><%message.date%></span>

                                            </p>

                                        </li>

                                    </ul>
                                </div>

                                </div>


                            </div>
                            <div class="chat_submit_box" id="chat_submit_box">
                                <div class="uk-input-group">

                                    <input type="text" class="md-input" ng-model="messageSend" name="submit_message" id="submit_message" placeholder="Send message" onchange="youFunction(this.value);" onkeyup="youFunction(this.value);" >
                                    <span style="cursor: pointer;"  id="send_msg" class="uk-input-group-addon" ng-click="addMessage()">

																											<i class="material-icons md-24">&#xE163;</i>

																									</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  </div></div> -->
                <!-- </div> -->
                <!-- /div></div> -->
            </div>



        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel"><span style="color:red">Warning</span></h4>
          </div>
          <div class="modal-body">
            You are receiving this message either because you are attempting to send information that is either NOT allowed by Health Care Travels Terms of Use and Polices or in error. If you feel this message is in error contact <a href="mailto:support@healthcaretravels.com">support@healthcaretravels.com</a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- common functions -->
    <script src="{{ URL::asset('bower_components/common.min.js') }}"></script>
    <!-- uikit functions -->
    <script src="{{ URL::asset('bower_components/uikit_custom.min.js') }}"></script>
    <!-- altair common functions/helpers -->
    <script src="{{ URL::asset('bower_components/altair_admin_common.min.js') }}"></script>
    <!-- page specific plugins -->
    <!--  chat functions -->
    <script src="{{ URL::asset('bower_components/page_chat.min.js') }}"></script>
     <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Contact
================================================== -->
    <!-- Footer
================================================== -->
    @include('includes.footer')
    <!-- Footer / End -->
    <!-- Back To Top Button -->
    <div id="backtotop">
        <a href="#"></a>
    </div>
    <!-- Scripts
================================================== -->
    <script type="text/javascript">

        function youFunction(msg){

            var matches = msg.match(/\d+/g);
            if(matches == null){
                var str = msg;
                var arr = ['@','#','My phone number','Your phone number','Email','E-mail','Phone number','Paypal','Facebook','facebook.com','Instagram','Cash app','App','Gmail.com','Gmail','Yahoo.com','Yahoo.com','Hotmail.com','Hotmail ','Aol.com','Msn.com','Comcast.net','Live.com','Ymail.com','Outlook.com','Sbcglobal.net','Net ','.com','.net','Dot','Version.net','Att.net','Bellsouth.net','Airbnb','Airbnb.com','Mac.cm','icould.com ','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Address ','Street','Western union','Wire','Bank','Money','Text '];

                var isEvery = checkInput(str,arr);
                console.log(isEvery);

                if(isEvery == true){
                    $("#send_msg").hide();
                    $('#myModal').modal();
                    // alert('You are receiving this message either because you are attempting to send information that is either NOT allowed by Health Care Travels Terms of Use and Polices or in error. If you feel this message is in error contact support@healthcaretravels.com');
                }else{
                    $("#send_msg").show();
                }
            }else{

                $("#send_msg").hide();
                $('#myModal').modal();
                // alert('You are receiving this message either because you are attempting to send information that is either NOT allowed by Health Care Travels Terms of Use and Polices or in error. If you feel this message is in error contact support@healthcaretravels.com');
            }


        }

        function checkInput(input, words) {
            return words.some(word => input.toLowerCase().includes(word.toLowerCase()));
        }
        // function checkIfEmailInString(text) {
        //     var re = /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;
        //     return re.test(text);
        // }




        var app = angular.module('myApp', ['firebase'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        app.constant('FBURL',
            '{{FB_URL}}'
            //Use the URL of your project here with the trailing slash
        );

        app.controller('ListController', ['$scope', '$firebaseArray', '$firebaseObject', 'FBURL', function($scope,$firebaseArray, $firebaseObject, FBURL){

            var request_id = {{$id}};
            var current_date = "{{date('m/d/Y H:i A')}}";
            //current_date = current_date.toString();
            var url_string = window.location.href; //window.location.href
            var url = new URL(url_string);
            var node_name = url.searchParams.get("fb-key");

            //var node_name = 'instant_chat';
            var chats = new Firebase('{{FB_URL}}'+node_name+'/'+request_id);
            $scope.messages = $firebaseArray(chats);
            console.log($scope.messages);
            if ($scope.messages) {
                $scope.loader = 'yes';
            }
            //alert($scope.loader);

            $scope.userid = {{$traveller_id}};
            $scope.removeProduct = function(id) {
                var ref = new Firebase('{{FB_URL}}'+node_name+'/'+request_id+'/' + id);
                var product = $firebaseObject(ref)
                product.$remove();
            };

            $scope.addMessage = function() {
                var ref = new Firebase('{{FB_URL}}'+node_name+'/'+request_id);
            // {"date":"13/03/2018 10:33:38","message":"Hi bubblu Enquiry sent for Sunset Cave Hosue 2guests,
                // -","owner_id":73,"property_id":"2","sent_by":"37","traveller_id":"37"}
                var product = $firebaseArray(ref);
                product.$add({
                    message: $scope.messageSend,
                    sent_by: $scope.userid,
                    owner_id: $scope.userid,
                    traveller_id: 1,
                    property_id: 1,
                    date: current_date
                });

                delete $scope.messageSend;

            };



        }]);

        app.controller('AddController', ['$scope', '$firebaseArray', '$location', 'FBURL', function($scope, $firebaseArray, $location, FBURL){

            $scope.addProduct = function() {
                var ref = new Firebase(FBURL);
                var product = $firebaseArray(ref);
                product.$add({
                    sku: $scope.product.sku,
                    description: $scope.product.description,
                    price: $scope.product.price
                });
            };

        }]);

    </script>



    <!-- DropZone | Documentation: http://dropzonejs.com -->







    </script>
    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/4.8.0/firebase.js"></script>
    <!-- GeoFire -->
    <script src="https://cdn.firebase.com/libs/geofire/4.1.2/geofire.min.js"></script>
    <script>

        // Initialize Firebase
        var config = {
        apiKey: "AIzaSyAqC-P0TVmYIKwa9YfzWqlCJO0ojrdKwiY",
        authDomain: "rental-slew.firebaseapp.com",
        databaseURL: "https://rental-slew.firebaseio.com",
        projectId: "rental-slew",
        storageBucket: "rental-slew.appspot.com",
        messagingSenderId: "386426447902"
      };
        firebase.initializeApp(config);

        // Create a Firebase reference where GeoFire will store its information
        var firebaseRef = firebase.database().ref();

        // Create a GeoFire index
        var geoFire = new GeoFire(firebaseRef);

        var ref = geoFire.ref();  // ref === firebaseRef
        geoFire.set("test", [10.48, 2.41]).then(function() {
            console.log("Provided key has been added to GeoFire");
        }, function(error) {
            console.log("Error: " + error);
        });

        var geoQuery = geoFire.query({
            center: [10.38, 2.41],
            radius: 100.5
        });

        var onKeyEnteredRegistration = geoQuery.on("key_entered", function(key, location, distance) {
            console.log(key + " entered query at " + location + " (" + distance + " km from center)");
        });

        var onKeyExitedRegistration = geoQuery.on("key_exited", function(key, location, distance) {
            console.log(key + " exited query to " + location + " (" + distance + " km from center)");

            // Cancel the "key_entered" callback
            onKeyEnteredRegistration.cancel();
        });

        function file_upload() {
            $("#upload_button").hide();
            var up = '<p  class="alert alert-success" style="margin-top: 5px;text-align:  center;">Uploading...</p>';
            document.getElementById("uploading").innerHTML = up;
            var file_data = $('#profile_image').prop('files')[0];
            var form_data = new FormData();
            form_data.append('profile_image', file_data);
            form_data.append('_token', "{{csrf_token()}}");
            $.ajax({
                url: '/update-profile-picture', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    //alert(php_script_response); // display response from the PHP script, if any
                    var data = '<img src="'+php_script_response+'" alt="profile picture">'
                    //$("#profileImage").html(data);
                    document.getElementById("profileImage").innerHTML = data;
                    document.getElementById("header_profile_image").innerHTML = data;
                    document.getElementById("uploading").innerHTML = '';
                    $("#upload_button").show();

                }
            });
        }


    </script>
    <script>

        function onLoad() {
            gapi.load('auth2', function() {
                gapi.auth2.init();
            });
        }
    </script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    <script type="text/javascript">
        $('#button').click(function (e) {
            var isvalid = true;
            var checki=true;
            $(".validate").each(function () {
                if ($.trim($(this).val()) == '') {
                    isValid = false;
                    $(this).css({
                        "border-color": "1px solid red",
                        "background": ""
                    });
                    //alert("Please fill all required fields");
                    if (isValid == false)
                        e.preventDefault();
                }
                else {
                    $(this).css({
                        "border": "2px solid green",
                        "background": ""
                    });

                }
            });

        });
    </script>
@endsection