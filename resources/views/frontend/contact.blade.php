@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'اتصل بنا')
@else
    @section('pageTitle', 'Contact Us')
@endif
@section('frontend-main')
    <section id="contact">
        <div class="contact-wrapper">
            <form class="form-horizontal" role="form" method="post" action="{{ route('send_contact') }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="@lang('trans.name')" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="@lang('trans.email')" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <input type="phone" class="form-control" id="phone" placeholder="@lang('trans.phone')" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="10" placeholder="@lang('trans.message')" name="message" required></textarea>
                </div>
                <button style="color: #ffffff;" class="btn send-button" id="submit" type="submit" value="@lang('trans.send')">
                    <div class="button">
                        <i class="fa fa-paper-plane"></i><span class="send-text">@lang('trans.send')</span>
                    </div>
                </button>
            </form>
            <div class="direct-contact-container">
                <ul class="contact-list">
                    <li class="list-item"><i class="fa fa-phone fa-2x"><span class="contact-text phone"><a
                                        href="tel:1-212-555-5555"
                                        title="Give me a call">{{ \App\Models\Option::find(1)->phone }}</a></span></i>
                    </li>
                    <li class="list-item"><i class="fa fa-envelope fa-2x"><span class="contact-text gmail"><a
                                        href="mailto:#"
                                        title="Send me an email">{{ \App\Models\Option::find(1)->email }}</a></span></i>
                    </li>
                </ul>
                <hr>
                <ul class="social-media-list">
                    <li>
                        <a href="{{ \App\Models\Option::find(1)->insta }}" target="_blank" class="contact-icon">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ \App\Models\Option::find(1)->face }}" target="_blank" class="contact-icon">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li><a href="{{ \App\Models\Option::find(1)->twitter }}" target="_blank" class="contact-icon">
                            <i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="{{ \App\Models\Option::find(1)->youtube }}">
                            <i class="fa fa-youtube" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')

@endsection