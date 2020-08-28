@extends('layout.master')
@section('title','Payment Method')
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
                    <form action="{{url('/')}}/add-paypal-email" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <div class="col-md-6">
                            <input type="email" placeholder="Enter paypal email" required name="pay_pal_email" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                        <button class="button" style="margin-top: 3px;margin-bottom: 5px;margin-right: 14px;">
                            <i class="sl sl-icon-plus"></i> Add new
                        </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">

                    @php 
                    //$payment_method = array(); 
                    @endphp
                    @if(count($payment_method) > 0)

                            <!-- Agents Container -->
                            <?php
//print_r($payment); exit;
?>
                            <div class="agents-grid-container">

                                @foreach($payment_method as $payment)
                                @if($payment->pay_pal_email)
                                <!-- Agent -->
                                <div class="grid-item col-md-6">
                                    <div class="agent">

                                        <div class="agent-content">

                                            <div class="agent-name">
                                                <h4><a href="#">Paypal Email</a></h4>
                                                <span>{{$payment->pay_pal_email}}</span>
                                            </div>


                                            

                                            <ul class="social-icons">
                                                @if($payment->is_default == ZERO)
                                                <button disabled class="button" style="float: right;margin-top: 5px;margin-bottom: 5px;">
                                                    Default
                                                </button>
                                                @else
                                                <button onclick="location.href='{{BASE_URL}}payment-default/{{$payment->id}}';" class="button" style="float: right;margin-top: 5px;margin-bottom: 5px;">
                                                    Make Default
                                                </button>
                                                <button onclick="location.href='{{BASE_URL}}payment-delete/{{$payment->id}}';" class="button" style="float: right;margin-top: 5px;margin-bottom: 5px;">
                                                    Delete
                                                </button>
                                                @endif
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Agent / End -->
                                @endif
                                @endforeach
                            </div>
                            <!-- Agents Container / End -->

                    @endif

                    

 


                </div>
            </div>

        </div>
    </div>


@endsection