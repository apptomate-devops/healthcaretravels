@extends('layout.master') @section('title') FAQ | {{APP_BASE_NAME}} @section('main_content')

    <style type="text/css">
        .border {
            border: 1px solid lightgrey;
            padding: 10px;
            margin-bottom: 20px;

        }

        .new_card {
            /*font-weight: bold;*/
            padding: 10px;
            margin-left: 5px;
            background-color: white;
            width: 80%;

        }

        .border_new {
            font-size: 20px;

        }
    </style>
    <div class="container" style="margin-top: 35px;">
        <form action="{{BASE_URL}}faq-filter" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <label>Search</label>
            <input type="text" placeholder="Search here" list="states-2" id="search-2"
                   data-list='{"valueCompletion": true, "highlight": true}' name="faq">
            <datalist id="states-2">
                <select class="input-text validate">
                    @foreach($data as $faq)
                        <option value="{{$faq->question}}">{{$faq->question}}</option>
                    @endforeach
                </select>
            </datalist>
            <center>
                <button class="button" style="height: 58px;width: 150px;" type="submit">
                    <i class="fa fa-search">&nbsp;SEARCH</i>
                </button>
            </center>
            <br><br>
        </form>
        @if(count($data) > 0)
            <p>
                <!-- <h3>FAQ</h3> -->
            @foreach($data as $faq)
                <div class="border">
                    <span class="border_new">{{$faq->question}} <a data-toggle="collapse" href="#{{$faq->id}}"
                                                                   role="button" aria-expanded="false"
                                                                   aria-controls="{{$faq->id}}"><i
                                class="fa fa-plus-square"></i></a></span>

                </p>

                <div class="row">
                    <div class="col border_new">
                        <div class="collapse multi-collapse" id="{{$faq->id}}">
                            <div class="new_card">
                                <h4>{{$faq->answer}}</h4>
                            </div>
                        </div>
                    </div>
                </div>

    </div>

    @endforeach
    <div style="height:200px;">
    </div>
    @else
        <center><h2>No Records Found</h2></center>
    @endif

    <script>
        // $(document).ready(function(){
        //     $("i").click(function(){
        //         $("i").toggleClass("fa fa-minus-square-o");
        //     });
        // });


        if (window.webshims) {
            webshims.setOptions('forms', {
                customDatalist: true
            });
            webshims.polyfill('forms');
        }
    </script>
@endsection
