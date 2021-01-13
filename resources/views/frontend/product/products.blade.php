@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'المتجات')
@else
    @section('pageTitle', 'Products')
@endif
@section('frontend-main')
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
                                                            <small>@lang('trans.sar')R {{ $product->price }}</small></p>
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
                                               role="button" product="{{ $product->id }}" data-token="{{ csrf_token() }}"><i class="fas fa-heart fa-2x"></i></a>
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
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection