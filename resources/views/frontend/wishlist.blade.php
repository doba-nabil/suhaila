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
    </style>
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'المفضلة')
@else
    @section('pageTitle', 'Wish List')
@endif
@section('frontend-main')
    <!-- cart section -->
    <div class="profile">
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
                            <div class="col-md-4 col-sm-6 col-12">

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

@endsection