@extends('layout.master')
@section('title')
    {{APP_BASE_NAME}} | Payment Options
@endsection
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/reservations.css') }}">

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
                @component('components.funding-source', [
                                'funding_sources' => $funding_sources,
                                 'user' => $user,
                                 'label' => 'Select an Option',
                                 'button_label' => 'Add a Payment Option'
                                 ])
                @endcomponent
            </div>

        </div>
    </div>
@endsection
