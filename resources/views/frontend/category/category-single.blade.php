@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@section('pageTitle', $category['name_'.$lang])
@section('frontend-main')
    <!-- Slider section -->
    <!------------#############  slider ############3----------------->
    <div class="clearfix"></div>
    <section class="category-template">
        <div class="page-banner">
            @if(isset($category->mainImage))
                <img src="{{ asset('pictures/categories/' . $category->mainImage->file) }}"/>
            @else
                <img src="{{ asset('frontend') }}/images/shutterstock_1856891377.jpg"
                     alt="{{ $category['name_'.$lang] }}">
            @endif
            <div class="banner-title">
                <h2>{{ $category['name_'.$lang] }}</h2>
            </div>
        </div>
        @if($products->count() > 0)
            <div class="category-slider">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel owl-theme category_slider">
                                @foreach($products as $product)
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
                                                        <p>SAR {{ $product->price }}</p>
                                                    </span>
                                                @else
                                                    <span class="info">
                                                        <p>{{ $product['name_'.$lang] }}</p>
                                                        <p>SAR {{ $product->discount_price }} <small>SAR {{ $product->price }}</small></p>
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
                                               <a class="btn" href={{ route('login') }}>
                                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                                </a>
                                                    @endauth
                                               
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <div class="clearfix"></div>
    @if($videos->count() > 0)
        <!-- start videos section  -->
        <section class="web-videos">
            <div class="container">
                <div class="owl-carousel owl-theme first">
                    @foreach($videos as $video)
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" data-toggle="modal" data-target="#example{{ $video->id }}"
                                            class="image_section btn">
                                        <div class="arrow">
                                            <i class="fa fa-play fa-5x"></i>
                                        </div>
                                        @if(isset($video->image))
                                            <img class="video-image"
                                                 src="{{ asset('pictures/videos/' . $video->image->file) }}"
                                                 alt="{{ $video['name_'.$lang] }}"/>
                                        @else
                                            <img class="video-image" src="{{ asset('frontend') }}/images/video.jpg"
                                                 alt="{{ $video['name_'.$lang] }}"/>
                                        @endif
                                    </button>
                                </div>
                                <div style="position: relative" class="col-md-6">
                                    <div class="video-content">
                                        <div class="video-title">
                                            {{ $video['name_'.$lang] }}
                                        </div>
                                        <div class="video-desc">
                                            {{ $video['body_'.$lang] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @foreach($videos as $video)
            <!-- Modal -->
            <div class="modal fade" id="example{{ $video->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="{{ $video->id }}Title"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div style="text-align: center;" class="modal-body">
                            <video style="width: 100%;max-height: 70vh" controls>
                                @if(isset($video->video))
                                    <source src="{{ asset('pictures/videos/' . $video->video->file ) }}">
                                @else
                                    <source src="{{ asset('frontend') }}/images/craft.mp4">
                                @endif
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- end videos section -->
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection