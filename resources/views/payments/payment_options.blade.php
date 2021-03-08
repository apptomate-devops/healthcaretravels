@section('title')
    Payment Options | {{APP_BASE_NAME}}
@endsection
@extends('layout.master')
@section('main_content')
    <link rel="stylesheet" href="{{ URL::asset('css/payments.css') }}">

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
                                'button_label' => 'Add a Payment Option',
                                'from_profile' => true,
                            ])
                @endcomponent

                @if(count($all_payments) > 0)
                    <h2 style="margin-top: 50px;">Payment History</h2>
                    <table class="pricing-table responsive-table">
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Payment</th>
                            <th>Booking ID</th>
                            <th>Status</th>
                        </tr>
                        @foreach($all_payments as $payment)
                            <tr>
                                <td>{{$payment['transaction_date']}}</td>
                                <td>{{$payment['name']}}</td>
                                <td>${{$payment['payment']}}</td>
                                <td>{{$payment['booking_id']}}</td>
                                <td>{{$payment['status']}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
