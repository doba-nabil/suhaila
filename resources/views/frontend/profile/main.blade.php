@extends('frontend.layout.master')
@section('frontend-head')
    <style>
        .profile .container {
            width: auto;
            padding: 25px;
            margin: 100px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .profile hr {
            margin: 20px 0;
            border: 1px solid #ddd;
        }

        .profile .row {
            display: flex;
        }

        .profile .col-4 {
            /* border-right: 1px solid #ddd; */
        }

        .profile .col-6 {
            position: relative;

        }

        .profile ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .profile li a {
            display: block;
            text-align: center;
            width: 100%;
            padding: 5px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            color: #333;
        }

        .profile .content__block {

            top: 0;
            left: 0;
            width: 100%;
            padding: 15px;

            background-color: #f1f1f1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: slide 0.8s;
        }

        @keyframes slide {
            from {
                opacity: 0;
                transform: translateX(-15%);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }

        .profile form .btn {
            background: #151412;
            border-radius: 0;
            font-family: Barlow-Light;
            color: white;
            padding: 5px 30px;
            transition: 0.5s;
        }

        .profile form .btn:hover {
            background: #FFFFFF;
            color: #151412;
            border-radius: 15px 0 15px 0;
            border: 1px solid black;
        }
    </style>
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'الصفحة الشخصية')
@else
    @section('pageTitle', 'Profile')
@endif
@section('frontend-main')
    <!-- cart section -->
    <div class="profile">
        <div class="container">
            <h1>@lang('trans.profile')</h1>
            <hr>
            <section class="row">
                <div class="col-12 col-md-4" id="link">
                    <ul>
                        <li><a href="#" data-target='.info'>@lang('trans.my_informations')</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-12" id="content">
                    <div class="content__block info" style="display:block">
                        <form class="form-horizontal" role="form" method="post" action="{{ route('edit_profile') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="@lang('trans.name')"
                                       name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" placeholder="@lang('trans.email')"
                                       name="email" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="form-group">
                                <input type="phone" class="form-control" id="phone" placeholder="@lang('trans.email')"
                                       name="phone" value="{{ Auth::user()->phone }}" required>
                            </div>
                            <button class="btn send-button" id="submit" type="submit" value="@lang('trans.send')">
                                <div class="button">
                                    <span class="send-text">@lang('trans.send')</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                <section>
        </div>
        @if($products->count() > 0)
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>@lang('trans.wishlist')</h3>
                    </div>
                </div>
            </div>
            <div class="category-slider">
                <div class="container">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4">

                                <div class="item">
                                    <a href="{{ route('single_product' , $product->slug) }}">
                                        @if(isset($product->mainImage))
                                            <img alt="{{ $product['name_'.$lang] }}"
                                                 src="{{ asset('pictures/products/' . $product->mainImage->file) }}"/>
                                        @endif
                                        <div class="item-info">
                                            @if(empty($product->discount_price))
                                                <span class="info">
                                                        <p>{{ $product['name_'.$lang] }}</p>
                                                        <p>@lang('trans.sar') {{ $product->price }}</p>
                                                    </span>
                                            @else
                                                <span class="info">
                                                        <p>{{ $product['name_'.$lang] }}</p>
                                                        <p>@lang('trans.sar') {{ $product->discount_price }}
                                                            <small>@lang('trans.sar') {{ $product->price }}</small></p>
                                                    </span>
                                            @endif
                                            <span class="cart-button">
                                                 @auth
                                                    <a style="cursor: pointer;color: black" class="favourite_add
                                                    @foreach ($product->wishes as $favourite)
                                                    @if (isset(Auth::user()->id) && $favourite->user_id == Auth::user()->id)
                                                            color55
                                                        @endif
                                                    @endforeach"
                                                       role="button" product="{{ $product->id }}"
                                                       data-token="{{ csrf_token() }}"><i
                                                                class="fas fa-heart fa-2x"></i></a>
                                              <a id="add" class="btn" data-id="{{ $product->id }}">
                                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                                </a>
                                              @else
                                               <a href={{ route('login') }} data-id="{{ $product->id }}">
                                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                                </a>
                                                @endauth
                                              
                                                </span>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
    <script>
        // some js for tabs
        const links = document.querySelectorAll('.profile a');
        const content = document.querySelector('.profile #content');

        links.forEach((link) => {
            link.addEventListener('click', loadTabs)
        });

        // load tabs function
        function loadTabs(e) {
            console.log(this.getAttribute('data-target'));
            e.preventDefault();
            Array.from(content.children).forEach((cont) => {
                console.log(cont);
                cont.style.display = 'none';
            });
            console.log(e.target);
            console.log(this.getAttribute('data-target'));
            document.querySelector(this.getAttribute('data-target')).style.display = 'block';
        }
    </script>
@endsection