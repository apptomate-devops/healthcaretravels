@extends('Admin.Layout.master')

@section('title') {{APP_BASE_NAME}} - Admin @endsection

@section('content')

    <div class="content-header row">
    </div>
    <div class="content-body">
        <section class="chat-app-window">
            <div class="badge badge-default mb-1">Chat History</div>
            <div class="chats">
                <div class="chats">
                    <div class="chat">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>How can we help? We're here for you!</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat chat-left">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>Hey John, I am looking for the best admin template.</p>
                                <p>Could you please help me to find it out?</p>
                            </div>
                            <div class="chat-content">
                                <p>It should be Bootstrap 4 compatible.</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>Absolutely!</p>
                            </div>
                            <div class="chat-content">
                                <p>Modern admin is the responsive bootstrap 4 admin template.</p>
                            </div>
                        </div>
                    </div>
                    <p class="time">1 hours ago</p>
                    <div class="chat chat-left">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>Looks clean and fresh UI.</p>
                            </div>
                            <div class="chat-content">
                                <p>It's perfect for my next project.</p>
                            </div>
                            <div class="chat-content">
                                <p>How can I purchase it?</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>Thanks, from ThemeForest.</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat chat-left">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>I will purchase it for sure.</p>
                            </div>
                            <div class="chat-content">
                                <p>Thanks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                               data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                                />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>Great, Feel free to get in touch on</p>
                            </div>
                            <div class="chat-content">
                                <p>https://pixinvent.ticksy.com/</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="chat-app-form">
            <form class="chat-app-input d-flex">
                <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                    <div class="form-control-position">
                        <i class="icon-emoticon-smile"></i>
                    </div>
                    <input type="text" class="form-control" id="iconLeft4" placeholder="Type your message">
                    <div class="form-control-position control-position-right">
                        <i class="ft-image"></i>
                    </div>
                </fieldset>
                <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                    <button type="button" class="btn btn-info"><i class="la la-paper-plane-o d-lg-none"></i>
                        <span class="d-none d-lg-block">Send</span>
                    </button>
                </fieldset>
            </form>
        </section>
    </div>


    </div>
    </div>

@endsection
