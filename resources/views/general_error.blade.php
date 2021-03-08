@section('title')
    Error
@endsection
@extends('layout.master')
@section('main_content')


<div class="container" style="margin-top: 35px;">
	<div class="row">
		<div class="col-md-12" style="font-size: 20px;">
		</div>
		</div>
	<div class="row">
		<div class="col-md-12">
			<link rel="shortcut icon" href="https://healthcaretravels.com/public/favicon.ico" type="image/x-icon">
<style>
    .title-text {
        background: #0983B8;
        box-shadow: 6px 6px 0px #184559;
    }
    .detail-text {
        font-weight: bold;
        font-size: 36px;
        line-height: 32px;
        letter-spacing: 0.025em;
        color: #0983B8;
        margin: 40px 0 20px;
    }
    .error-details {
        font-weight: 500;
        font-size: 17px;
        line-height: 32px;
        letter-spacing: 0.025em;
        color: #333333;
    }
.error-template {padding: 40px 15px;text-align: center;}
.error-template img {
    width: 415px;
    height: 175px;
    object-fit: contain;
}
.error-template a.button {
    width: 260px;
    margin-top: 40px;
    background: #E78016;
}
.error-template a.button:hover {
    color: white;
    text-decoration: none;
}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="error-template">
                @if (empty($hideImage))
                    <img src="/404.png" alt="404 image">
                @endif
                <div class="detail-text">{{$title ?? 'Something’s missing...'}}</div>
                <div class="error-details">
                    {{$message ?? 'We can’t find the page you’re looking for.'}}
                </div>
                <a href="{{$url ?? BASE_URL}}" class="button">
                <div>{{$buttonText ?? 'Go Back'}}</div>
                </a>
                <div class="error-actions" style="height:200px ">

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

