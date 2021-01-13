@if (!\Request::is('en/login') && !\Request::is('ar/login') && !\Request::is('en/rigister') && !\Request::is('ar/rigister')
   && !\Request::is('en/about-us') && !\Request::is('ar/about-us') && !\Request::is('ar/contact') && !\Request::is('en/contact')
)
    <!-- start about section -->
    <section class="about">
        <a href="{{ route('about') }}">
            <div class="container">
                <div class="row">
                    <div style="position: relative" class="col-md-6">
                        <div class="about-content">
                            <div class="about-title">
                                {{ \App\Models\Page::find(1)['name_'.$lang] }}
                            </div>
                            <div class="about-desc">
                                {{ \App\Models\Page::find(1)['body_'.$lang] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-4">
                        @if(isset(\App\Models\Page::find(1)->image))
                            <img class="mt-3" src="{{ asset('pictures/pages/' . \App\Models\Page::find(1)->image->file) }}" alt="{{ \App\Models\Page::find(1)['name_'.$lang] }}"/>
                        @else
                            <img src="{{ asset('frontend') }}/images/about-image.jpg" alt="{{ \App\Models\Page::find(1)['name_'.$lang] }}">
                        @endif
                    </div>
                    <span>
                        @lang('trans.a_day')
                </span>
                </div>
            </div>
        </a>
    </section>
    <!-- end about section -->
    <div class="clearfix"></div>
@endif
<!-- start footer  -->
<footer>
    <!--first footer-->
    <div class="top-footer text-center">
        <div class="back"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <p class="footer-subscribe-header">@lang('trans.join_our_list')</p>
                    <p class="footer-subscribe-footer">
                        @lang('trans.sign_up_to_be')
                    </p>
                    <div class="footer-subscribe">
                        <div class="center">
                            <input name="email" type="email" class="search-box" id="kk" value="" required placeholder="@lang('trans.your_email')">
                            <button type="submit" data-token="{{ csrf_token() }}" class="sub-submit">@lang('trans.subscribe')</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
    <!--second footer-->
    <div class="center-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12  col-12 web-links-col text-center">
                    <ul class="web-links">
                        <li>
                            <a href="/">
                                @lang('trans.home')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">
                                @lang('trans.about')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('all_products') }}">
                                @lang('trans.products')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('all_categories') }}">
                                @lang('trans.all_categories')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('all_videos') }}">
                                @lang('trans.edu_videos')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">
                                @lang('trans.contact')
                            </a>
                        </li>
                        <br>
                        @foreach(\App\Models\Page::active()->where('id' ,'>' ,2)->orderBy('id' ,'desc')->get() as $page)
                            <li>
                                <a href="{{ route('page' , $page->slug) }}">
                                    {{ $page['name_'.$lang] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row footer-row">
                <div class="col-md-2">
                    <div class="footer-about">
                        <div class="row">
                            <div class="col-md-12 col-sm">
                                <img src="{{ asset('frontend') }}/images/footer-logo.png" alt="footer logo"/>
                            </div>
                            <div class="col-md-12 col-sm">
                                <ul class="footer-contact-info">
                                    <li class="mail">{{ \App\Models\Option::find(1)->email }}</li>
                                    <li class="phone">{{ \App\Models\Option::find(1)->phone }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <p class="footer-social-header">@lang('trans.lets_connect')</p>
                    <ul class="footer-social">
                        <li>
                            <a href="{{ \App\Models\Option::find(1)->face }}">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ \App\Models\Option::find(1)->twitter }}">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ \App\Models\Option::find(1)->youtube }}">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ \App\Models\Option::find(1)->insta }}">
                                <img src="{{ asset('frontend/images/insta.png') }}" alt="insta">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-shape">
        <div class="back"></div>
        <img style="width: 100%" src="{{ asset('frontend') }}/images/footer-shape.png" alt="footer shape"/>
    </div>
    <!--third footer-->
    <div class="bottom-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12">
                    <span>
                        @lang('trans.copy_rights')
                        <a href="https://7loll.net/">@lang('trans.7loll')</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--Increases-->
<a id="button">
    <i class="fa fa-arrow-circle-up hvr-icon-up"></i>
</a>
<div class="se-pre-con"></div>
<!-- end footer  -->

<!--------------------------------------->
<script src="{{ asset('frontend') }}/js/jquery-3.3.1.min.js"></script>
<script src="https://use.fontawesome.com/5ac93d4ca8.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script src="{{ asset('frontend') }}/sweetalert.js"></script>
<script src="{{ asset('frontend') }}/js/owl.carousel.min.js"></script>
<script src="{{ asset('frontend') }}/js/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{ asset('frontend') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('frontend') }}/js/bootstrap4-rating-input.js"></script>
<script src="{{ asset('frontend') }}/js/main.js"></script>
<script src="{{ asset('frontend') }}/js/custom.js"></script>

<script>
    $(document).ready(function () {
        $('.menu-toggler').on('click', function () {
            $(this).toggleClass('open');
            $('nav').toggleClass('open');
        });
        $('nav .nav-link').on('click', function () {
            $('.menu-toggler').removeClass('open');
            $('nav').removeClass('open');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.messages').fadeIn('fast').delay(2000).fadeOut('slow');
    });
</script>
@section('frontend-footer')

@show

