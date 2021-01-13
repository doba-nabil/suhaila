@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'نتائج البحث')
@else
    @section('pageTitle', 'Search results')
@endif
@section('frontend-main')
    <div class="page-banner">
        <img src="{{ asset('frontend') }}/images/shutterstock_1856891377.jpg"
             alt="{{ $word }}">
        <div class="banner-title">
            <h2>@lang('trans.results_about') : {{ $word }}</h2>
        </div>
    </div>
    <div class="category-slider">
        <div class="container">
            <div class="row">
                @if($products->count() > 0)
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
                                               <a class="btn" href={{ route('login') }}>
                                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                                </a>
                                                @endauth
                                                </span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                @else
                    <div class="col-md-12">
                        <h3 class="alert alert-warning">
                            @lang('frontend.no_results') " {{ $word }} "
                        </h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection