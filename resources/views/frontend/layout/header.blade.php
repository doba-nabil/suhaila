<!-- start header -->
<section class="header">
    <div class="head">
        <nav class="my-nav">
            <ul class="nav-list">
                <li>
                    <a href="/" class="nav-link">@lang('trans.home')</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="nav-link">@lang('trans.about')</a>
                </li>
                <li>
                    <a href="{{ route('all_products') }}" class="nav-link">@lang('trans.products')</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('all_categories') }}">@lang('trans.all_categories')</a>
                </li>
                <li>
                    <a href="{{ route('all_videos') }}" class="nav-link">@lang('trans.edu_videos')</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="nav-link">@lang('trans.contact')</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <header>
                        <div class="menu-toggler">

                        </div>

                    </header>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="logo">
                        <a href="/">
                            <img class="logo-image" src="{{ asset('frontend') }}/images/logo.png" alt="web logo"/>
                        </a>
                    </div>
                </div>
                @if($lang == 'ar') <div class="col-md-1 col-sm-1"></div> @endif
                <div class="col-md-3 col-sm-3 @if($lang == 'en') offset-1 @endif text-center">
                    <ul class="user-options">
                        @guest
                            <li>
                                <a title="login or register" href="{{ route('login') }}">
                                    <i class="far fa-user"></i>
                                </a>
                            </li>
                        @endguest

                        @auth
                                <li>
                                    <a title="@lang('trans.profile')" href="{{ route('profile') }}">
                                        <i class="fas fa-user"></i>
                                    </a>
                                </li>
                            <li>
                                <a title="@lang('trans.orders')" href="{{ route('purchases') }}">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span class="count">{{ \App\Models\Pay::where('user_id' , Auth::user()->id)->count() }}</span>
                                </a>
                            </li>
                            <li>
                                <a title="@lang('trans.wishlist')" href="{{ route('wishlist') }}">
                                    <i class="far fa-heart"></i>
                                    <span class="count wish-count">
                                    <span id="step2Content">
                                        {{ \App\Models\WishList::where('user_id',Auth::user()->id)->count() }}
                                    </span>
                                </span>
                                </a>
                            </li>
                        @endauth
                        <li>
                            <a title="@lang('trans.shoppingcart')" href="{{ route('cart') }}">
                                <i class="fas fa-shopping-bag"></i>
                                <span class="count cart-count">
                                    <span id="step1Content">
                                        {{ Cart::count() }}
                                    </span>
                                </span>
                            </a>
                        </li>
                        @auth
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button title="logout" class="btn">
                                        <i class="fas fa-sign-out-alt"></i></button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                    <div class="header-search">
                        <form action="{{ route('search') }}" method="get">
                            <button class="btn">
                                <i class="fas fa-search"></i>
                            </button>
                            <input name="word" placeholder="@lang('trans.search_placeholder')"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end header -->
<!-- messages -->
<div class="messages">
    @include('common.done_frontend')
    @include('common.errors_frontend')
</div>
<!-- end messages  -->

