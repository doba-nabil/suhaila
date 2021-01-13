@extends('frontend.layout.master')
@section('frontend-head')
    <style>
        .file-button{
            background-color: #121212;
            height: 8vh;
            width: 90%;
            margin-left: 30px;
            margin-top: 15px;
            padding: 0.5em;
            color: white;
            font-weight: bold;
            font-size: 1em;
            display: inline-block;
            text-align: center;
            border: none;
            border-radius: 5px;
            transition: all .3s ease;
        }
        small {
            text-decoration: line-through;
            color: rgba(149, 0, 0, 0.68);
            font-size: 13px;
        }
    </style>
@endsection
@section('pageTitle', $product['name_'.$lang])
@section('frontend-main')
    <div class="page-banner">
        @if(isset($product->category->mainImage))
            <img src="{{ asset('pictures/categories/' . $product->category->mainImage->file) }}"/>
        @else
            <img src="{{ asset('frontend') }}/images/shutterstock_1856891377.jpg"
                 alt="{{ $product->category['name_'.$lang] }}">
        @endif
        <div class="banner-title">
            <h2>
                <a style="color: #eb5cab" href="{{ route('single_category' , $product->category->slug) }}">
                    {{ $product->category['name_'.$lang] }}
                </a>
               -----
                {{ $product['name_'.$lang] }}</h2>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="main product-single">
                    <div class="left-icon">
                        @if($product->subImages->count() > 0)
                            <div>
                                <img onclick="document.getElementById('img-holder').style.backgroundImage = 'url({{ asset('pictures/products/' . $product->mainImage->file) }})'" src="{{ asset('pictures/products/' . $product->mainImage->file) }}" id="left-circle">
                            </div>
                            @foreach($product->subImages as $no => $image)
                                <div>
                                    <img onclick="document.getElementById('img-holder').style.backgroundImage = 'url({{ asset('pictures/products/' . $image->file) }})'" src="{{ asset('pictures/products/' . $image->file) }}" id="left-circle">
                                </div>
                            @endforeach
                        @else
                            <div>
                                <img onclick="document.getElementById('img-holder').style.backgroundImage = 'url({{ asset('pictures/products/' . $product->mainImage->file) }})'" src="{{ asset('pictures/products/' . $product->mainImage->file) }}" id="left-circle">
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="column">
                            <div style="background-image: url({{ asset('pictures/products/' . $product->mainImage->file) }})" id="img-holder"></div>
                        </div>
                        <div class="column">
                            <button class="top-rate-button">
                                {{ $product['name_'.$lang] }}
                            </button>
                            <br>
                            <p2>
                                <b>@lang('trans.desc') :</b>
                            </p2>
                            <p2 style="margin-left:10px;">
                                {{ $product['body_'.$lang] }}
                            </p2>
                            <br>
                            <p2>
                                <b>@lang('trans.price') :</b>
                            </p2>
                            <p2 style="margin-left:10px;">
                                @if(empty($product->discount_price))
                                <span class="info">
                                    <p>@lang('trans.sar') {{ $product->price }}</p>
                                </span>
                                @else
                                    <span class="info">
                                        @lang('trans.sar') {{ $product->discount_price }}
                                        <small>@lang('trans.sar') {{ $product->price }}</small>
                                    </span>
                                @endif
                            </p2>
                            <br>
                            @if(isset($product->file))
                                @auth()
                                    <?php
                                        $pay = \App\Models\Pay::where('product_id' , $product->id)->where('user_id' , Auth::user()->id)->first();
                                        if(isset($pay)){
                                            $order = \App\Models\Order::find($pay->order_id);
                                        }
                                    ?>
                                @endauth
                            @if(isset($order))
                            @if($order->status == 1 && $product->kind == 1)
                                <a target="_blank" href="{{ asset('pictures/files/' . $product->file->file) }}" class="file-button">
                                    <i class="fas fa-file fa-2x"></i>
                                </a>
                            @elseif($order->status == 0 && $product->kind == 1)
                                        <a class="file-button">
                                            {{ __('trans.wait') }}
                                        </a>
                            @endif
                            @endif
                            @endif
                            @auth
                                <a style="cursor: pointer;color: white" class="favourite_add love-button
                                                    @foreach ($product->wishes as $favourite)
                                @if (isset(Auth::user()->id) && $favourite->user_id == Auth::user()->id)
                                        color55
                                @endif
                                @endforeach"
                                   role="button" product="{{ $product->id }}"
                                   data-token="{{ csrf_token() }}"><i
                                            class="fas fa-heart fa-2x"></i></a>
                          <a id="add" data-id="{{ $product->id }}" class="price-button">
                                <i class="fas fa-cart-plus fa-2x"></i>
                            </a>
                          @else
                          <a href={{ route('login') }} class="price-button">
                                <i class="fas fa-cart-plus fa-2x"></i>
                            </a>
                            @endauth

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($product->video))
    <div class="product-video">
        <div class="container">
            <div class="frame">
                <div class="frame__in">
                    <video style="width: 100%;max-height: 70vh" controls>
                        <source src="{{ asset('pictures/products/' . $product->video->file ) }}">
                    </video>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection