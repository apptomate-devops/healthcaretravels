@section('title')
    Change password | {{APP_BASE_NAME}}
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
                <div class="row">


                    <div class="col-md-8 my-profile">


                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <h4 style="text-align:center;">{{ Session::get('success') }}</h4>
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                <h4 style="text-align:center;">{{ Session::get('error') }}</h4>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form name="update_profile" action="change-password" method="post">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            @if($user_detail->password)
                            <label>Old Password :</label>
                            <input type="password" name="old_password" required>
                            @else
                                <p>Set a password for your account :</p>
                            @endif

                            <label>New Password :</label>
                            <input type="password" name="new_password" required>

                            <label>Confirm Password :</label>
                            <input type="password" name="confirm_password" required>

                            <button type="submit" class="button margin-top-20 margin-bottom-20">Update</button>

                        </form>
                    </div>




                </div>
            </div>

        </div>
    </div>


@endsection
