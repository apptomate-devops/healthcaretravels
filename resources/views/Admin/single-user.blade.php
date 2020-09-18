@extends('Admin.Layout.master')
<style>
    .user-profile {
        height: 150px;
        width: 150px;
        border-radius: 50%;
        border: 1px solid #e08716;
        object-fit: contain;
    }
    .remove-profile-image {
        position: absolute; height: 30px; width: 30px; top: 0; right: 0; background: red
    }
</style>
@section('title') Rentals Slew Admin @endsection

@section('content')
    <div class="card">
        <div class="text-center">
            <div class="card-body">
                <img
                    src="@if($data->profile_image!=' ' &&  $data->profile_image!='0'){{$data->profile_image}}@else https://image.flaticon.com/icons/png/512/73/73199.png @endif"
                    alt="{{$data->username}} image"
                    class="user-profile">
            </div>
            @if($data->profile_image!=' ' &&  $data->profile_image!='0')
                <a class="btn btn-default btn-danger"
                   href="{{BASE_URL}}admin/remove_profile_image/{{$data->id}}"><span style="height:29px">Click here to Remove Profile Image</span></a>
            @endif
            <div class="card-body">
                <h4 class="card-title"><span class="field-label">Username:</span>{{$data->username}}</h4>
                <h6 class="card-subtitle text-muted"><span class="field-label">Name:</span>{{$data->first_name ?? ''}} {{$data->last_name ?? ''}}</h6>
                <br>
                <h6 class="card-subtitle text-muted"><span class="field-label">Type:</span>
                @if(strtolower($data->role) == 'co-host') 
                    Co-Host
                @else
                    {{ucwords(strtolower($data->role))}}
                @endif
                </h6>
                <br>
                <h6 class="card-subtitle text-muted"><span class="field-label">Phone:</span><span class="masked_phone_us_text">{{$data->phone ?? '-'}}</span></h6>
                <br>
                <h6 class="card-subtitle text-muted"><span class="field-label">Email:</span>{{$data->email ?? '-'}}</h6>
                <br>
                @if(strtolower($data->role) != 'co-host' && strtolower($data->role) != 'property owner')
                    <h6 class="card-subtitle text-muted"><span class="field-label">Name of Agency:</span>{{$data->other_agency ?? $data->name_of_agency ?? ""}}</h6>
                @endif
                <br>
                <div class="text-center">
                    @if($data->facebook_url!='0' && strlen($data->facebook_url) > 0)
                        <a href="{{$data->facebook_url}}" data-href="{{$data->facebook_url}}" target="_blank"
                           class="btn btn-social-icon parse-link-href mr-1 mb-1 btn-outline-facebook">
                            <span class="la la-facebook"></span>
                        </a>
                    @endif
                    @if($data->linkedin_url!='0' && strlen($data->linkedin_url) > 0)
                        <a href="{{$data->linkedin_url}}" data-href="{{$data->linkedin_url}}" target="_blank"
                           class="btn btn-social-icon parse-link-href mb-1 btn-outline-linkedin">
                            <span class="la la-linkedin font-medium-4"></span>
                        </a>
                    @endif
                    @if($data->instagram_url!='0' && strlen($data->instagram_url) > 0)
                        <a href="{{$data->instagram_url}}" data-href="{{$data->instagram_url}}" target="_blank"
                           class="btn btn-social-icon parse-link-href mb-1 btn-outline-linkedin">
                            <span class="la la-instagram font-medium-4"></span>
                        </a>
                    @endif
                    @if($data->twitter_url!='0' && strlen($data->twitter_url) > 0)
                        <a href="{{$data->twitter_url}}" data-href="{{$data->twitter_url}}" target="_blank"
                           class="btn btn-social-icon parse-link-href mb-1 btn-outline-linkedin">
                            <span class="la la-twitter font-medium-4"></span>
                        </a>
                    @endif
                </div>
                @if ($data->is_verified==1)
                    <span class="btn btn-default btn-success btn-block" style="background-color: green">Verified</span>
                @elseif ($data->is_verified==-1)
                    <span class="btn btn-default btn-danger btn-block">Denied</span>
                @endif
                @if($data->is_verified!=1)
                    <a
                        style="float:right" class="btn btn-default btn-primary btn-block"
                        href="{{BASE_URL}}admin/verify_profile/{{$data->id}}"
                    >
                        <span style="height:29px">
                            Click here to verify this {{strtolower($data->role)}}
                        </span>
                    </a>
                @endif
                {{-- Disabling main deny button --}}
                {{-- @if($data->is_verified!=-1)
                    <a
                        style="float:right" class="btn btn-default btn-danger btn-block"
                        href="{{BASE_URL}}admin/verify_profile/{{$data->id}}/true"
                        >
                        <span style="height:29px">
                            Click here to deny this @if($data->role_id==0) traveler @elseif($data->role_id==1) owner @else  travel agency @endif
                        </span>
                    </a>
                @endif --}}
                <br>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="phone-wrapper">
                <h4 class="card-title"> Verification Mobile Number
                    : @if($data->phone) 
                        <span class="masked_phone_us_text">
                            {{$data->phone}}
                        </span>
                      @else 
                        <span>Not Added</span> 
                      @endif
                </h4>
                @if ($data->otp_verified == 1)
                    <span class="btn btn-default btn-success" style="background-color: green">Verified</span>
                @else
                    <span class="btn btn-default btn-danger">Unverified</span>
                @endif
            </div>
            <br>
            @if(isset($data->phone))
                @if($data->otp_verified == 0)
                    <a style="float:left" class="btn btn-default btn-success"
                       href="{{BASE_URL}}admin/verify_mobile/{{$data->id}}/1"><span
                            style="height:29px;width: 10px">Click here to Verify Phone Number</span></a>
                @elseif($data->otp_verified == 1)
                    <a style="float:left" class="btn btn-default btn-danger"
                       href="{{BASE_URL}}admin/verify_mobile/{{$data->id}}/0"><span style="height:29px">Click here to Unverify Phone Number</span></a>
                @endif
            @endif
        </div>
        @php
            $linksDataCount = 0;
            foreach($user_links as $link => $link_name) {
                if($data->$link) {
                    $linksDataCount++;
                }
            }
        @endphp
        @if ($linksDataCount > 0)
            <div class="card-header">
                <h4 class="card-title">Links shared by user</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @foreach($user_links as $link => $link_name)
                        @if($data->$link)<h5>{{$link_name.": "}}<a class="parse-link-href" target="_blank" href="{{$data->$link}}" data-href="{{$data->$link}}">{{$data->$link}}</a></h5>@endif
                    @endforeach
                </div>
            </div>
        @endif
        <div class="card-header">
            <h4 class="card-title">About</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a id="about-toggler" data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse">
            <div class="card-body">
                @foreach ($data->getAttributes() as $key => $value)
                    @if(!in_array($key, $fields_to_omit))
                        <h5>{{ucfirst(str_replace("_"," ",$key))}}: {{($value == 1 ? 'Yes' : $value) ?: '-'}}</h5>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Property Details</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <h3>Total Property Published : {{$total_posted}} </h3> <br><br>
                <h3>Total Property Booked : {{$total_booking}} </h3><br>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Verification Documents</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
                <div class="card-deck-wrapper">
                    <div class="card-deck">
                        @if(count($document)==0)
                            <div class="col-md-12">
                                <center><h4>No Documents Uploaded yet.</h4></center>
                            </div>
                        @else
                            @foreach($document as $d)
                                <div class="col-md-4">
                                    <figure class="card card-img-top border-grey border-lighten-2"
                                            itemprop="associatedMedia" itemscope=""
                                            itemtype="http://schema.org/ImageObject">
                                        <div class="card-body px-0">
                                            <h4 class="card-title">   {{ucfirst(str_replace("_"," ",$d->document_type))}}</h4>
                                        </div>
                                        {{-- <a href="{{$d->document_url}}" target="_blank" itemprop="contentUrl"
                                           data-size="480x360">
                                            <img data-enlargable class="gallery-thumbnail card-img-top" src="{{$d->document_url}}"
                                                 itemprop="thumbnail" alt="Image description">
                                        </a> --}}
                                        @if (\Illuminate\Support\Str::endsWith(strtolower($d->document_url), '.pdf'))
                                            {{-- <span>Render PDF</span> --}}
                                            <div class="pdf-wrapper">
                                                <canvas data-enlargable class="pdf-links" data-pdf="{{$d->document_url}}" style="direction: ltr;"></canvas>
                                            </div>
                                        @elseif (\Illuminate\Support\Str::endsWith(strtolower($d->document_url), '.heic'))
                                            <span class="file-loading">Loading...</span>
                                            <img data-enlargable class="gallery-thumbnail card-img-top heic-image" src="{{$d->document_url}}"
                                                 itemprop="thumbnail" alt="Image description">
                                        @else
                                            <img data-enlargable class="gallery-thumbnail card-img-top" src="{{$d->document_url}}"
                                                 itemprop="thumbnail" alt="Image description">
                                        @endif
                                        <div class="card-body px-0">
                                            @if($d->status == 0)
                                                <a class="verification-response verification-approved btn btn-default btn-success btn-block"
                                                   
                                                   data-id="{{$d->id}}" data-status="1" data-title="{{ucfirst(str_replace("_"," ",$d->document_type))}}">
                                                    <span style="height:30px">Approve This Document</span>
                                                </a>
                                                <a class="verification-response verification-denied btn btn-default btn-danger btn-block"
                                                   
                                                   data-id="{{$d->id}}" data-status="-1" data-title="{{ucfirst(str_replace("_"," ",$d->document_type))}}">
                                                    <span style="height:30px">Deny This Document</span>
                                                </a>
                                                <div class="form-group">
                                                    <input type="text" class="denial-reason form-control" style="margin-top: 10px; display: none;" name="reason-{{$d->id}}" id="reason-{{$d->id}}" data-id="{{$d->id}}" placeholder="specify reason for denial">
                                                </div>
                                            @elseif($d->status == 1)
                                                <span class="btn btn-default btn-success btn-block"
                                                      style="background-color: green">Verified</span>
                                            @else
                                                <span class="btn btn-default btn-danger btn-block">Unverified</span>
                                            @endif
                                        </div>
                                    </figure>
                                </div><br>
                            @endforeach
                        @endif
                        <div class="col-md-12 submit-block-wrapper">
                            <div class="alert alert-danger" style="display: none">
                                <h4>An Error occured</h4>
                            </div>
                            <button id="btn-submit-verification" class="btn btn-default btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Root element of PhotoSwipe. Must have class pswp. -->
        </div>
        <!--/ PhotoSwipe -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var totalDocs = "{{count($document)}}";
        var userId = "{{$data->id}}";
        var responses = {};
        function parseUrl(url) {
            if (isValidUrl(url)) {
                return url;
            }
            return 'https://' + url;
        }
        function isValidUrl(string) {
            try {
                new URL(string);
            } catch (_) {
                return false;
            }
            return true;
        }
        $(document).on('click', 'a.parse-link-href', function(event) {
            event.preventDefault();
            event.stopPropagation();
            var URL = parseUrl(event.currentTarget.dataset.href);
            window.open(URL, '_blank');
        });
        $(document).on('click', 'a.verification-response', function(event) {
            event.preventDefault();
            event.stopPropagation();
            var doc = event.currentTarget.dataset;
            responses[doc.id] = {
                id: doc.id,
                status: doc.status,
                title: doc.title,
                reason: responses[doc.id] ? responses[doc.id].reason : ''
            };
            var currentNode = $(event.currentTarget);
            var reasonInput = currentNode.parent().find('.denial-reason');
            var approveNode = currentNode.parent().find('.verification-approved');
            var denyNode = currentNode.parent().find('.verification-denied');
            if (doc.status == 1) {
                // Hide reason and remove it from data
                approveNode.find('span').html('Document will be verified');
                denyNode.find('span').html('Deny This Document');
                reasonInput.fadeOut();
            } else {
                // Show reason box and add to data;
                reasonInput.fadeIn();
                denyNode.find('span').html('Document will be denied');
                approveNode.find('span').html('Approve This Document');
            }
        });
        $(document).on('change', '.denial-reason', function (event) {
            var reason = event.currentTarget.value;
            var id = event.currentTarget.dataset.id;
            if (responses[id]) {
                responses[id].reason = reason;
            } else {
                responses[id] = { reason: reason };
            }
        });

        $(function () {
            var heicImages = $('.heic-image');
            if (heicImages.length) {
                $.each(heicImages, function(index, item) {
                    var $item = $(item);
                    $item.fadeOut();
                    $item.parent().find('.file-loading').fadeIn();
                    fetch(item.src)
                        .then((res) => res.blob())
                        .then((blob) => heic2any({ blob }))
                        .then((conversionResult) => {
                            item.src = URL.createObjectURL(conversionResult);
                            $item.addClass('file-converted');
                            $item.parent().find('.file-loading').fadeOut();
                        })
                        .catch((e) => {
                            console.error('Error in coverting heic image');
                        });
                });
            }
            var pdfs = $('.pdf-links');
            if (pdfs.length) {
                $.each(pdfs, function(index, canvas) {
                    renderPDFonCanvas(canvas.dataset.pdf, canvas);
                });
            }
        });
        $(document).on('click', '#btn-submit-verification', function (event) {
            event.preventDefault();
            var alertNode = $(event.currentTarget).siblings('.alert-danger');
            var formData = {
                responses: [],
                _token: '{{ csrf_token() }}'
            };
            function setError(message) {
                if (message) {
                    alertNode.find('h4').html(message);
                    alertNode.fadeIn();
                } else {
                    alertNode.hide();
                }
            }
            var responsesLength = 0;
            var deniedLength = 0;
            var isValid = true;
            for (var k in responses) {
                if (responses.hasOwnProperty(k)) {
                    var resp = responses[k];
                    if (resp.status == -1) {
                        deniedLength++;
                        if (!resp.reason) {
                            $('#reason-' + k).parent().addClass('has-error');
                            isValid = false;
                        }
                    } else {
                        $('#reason-' + k).parent().removeClass('has-error');
                    }
                    formData.responses.push(resp);
                    responsesLength++;
                }
            }
            if (responsesLength != totalDocs) {
                setError('All docuemnts should be responded to submit data');
            } else if(!isValid) {
                setError('Some denied docuemnts are missing reasons.');
                $('html, body').animate({
                    scrollTop: $('.has-error:first').offset().top - 50
                }, 1000);
            } else if (isValid) {
                setError();

                $.ajax({
                    url: "/admin/verify_all_documents/" + userId,
                    type: "POST",
                    data: formData,
                    json: true,
                    success: function(data, textStatus, jqXHR) {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            console.log(data);
                            setError('An error occured');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        setError('An error occured');
                    }
                });
            }
        });
    </script>
@endsection
