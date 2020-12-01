@extends('layout.master')
@section('title','Favourite properties')
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
                        <th><i class="fa fa-file-text"></i> Favorite Properties</th>
                        <th></th>
                        <th class="expire-date"><i class="fa fa-calendar"></i> Action</th>

                    </tr>

                    <!-- Item #1 -->
                    @foreach($properties as $property)
                        <tr>
                            <td class="title-container">

                                @if($property->image_url != null)
                                    <img src="{{$property->image_url}}" alt="">
                                @else
                                    <img src="{{STATIC_IMAGE}}" alt="">
                                @endif
                                <div class="title">
                                    <h4><a href="{{BASE_URL}}property/{{$property->property_id}}">{{$property->title}}</a></h4>
                                    <span>{{$property->description}} </span>
                                </div>
                            </td>

                            <td></td>

                            <td class="action">
                                <button onclick="favourite({{$property->property_id}})" class="button" style="background-color: #0983b8;">
                                    <mark style="color: white;background-color: #0983b8;font-size: 16px;"> &nbsp;Remove&nbsp;</mark>
                                </button>
                            </td>
                        </tr>
                    @endforeach


                </table>
                @if(in_array($role_id, [1, 4]))
                    <a href="{{url('/')}}/owner/add-property" class="margin-top-40 button">Submit New Property</a>
                @endif
            </div>

        </div>
    </div>

<script type="text/javascript">
    function favourite(id) {

        var r = confirm("You are about to remove this listing from your favorites");
        if (r == true) {
            var url = '{{BASE_URL}}property/set-favourite/'+id;
            $.ajax({
                "type": "get",
                "url" : url,
                success: function(data) {
                    console.log("Set favourite success ====:"+data);
                    location.reload();
                }
            });
        }
    }
</script>
@endsection
