@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'الرئيسية')
@else
    @section('pageTitle', 'Home')
@endif
@section('frontend-main')
    <!-- Slider section -->
    <!------------#############  slider ############3----------------->
    <div class="clearfix"></div>
    @if($sliders->count() > 0)
    <section class="slider">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner position-relative">
                @foreach($sliders as $no => $slider)
                <div class="carousel-item @if($no == 0) active @endif">
                    @if(isset($slider->mainImage))
                        <img class="d-block w-100" src="{{ asset('pictures/sliders/' . $slider->mainImage->file) }}" alt="{{$slider['title_'.$lang]}}">
                    @else
                        <img class="d-block w-100" src="{{ asset('frontend') }}/images/slider.jpg" alt="{{$slider['title_'.$lang]}}">
                    @endif
                    <div class="css-typing">
                        <h4>
                            {{ $slider['title_'.$lang] }}
                        </h4>
                        <div>
                            <div>
                                <a class="btn" href="{{ $slider->link }}">
                                    {{ $slider['subtitle_'.$lang] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <i style="font-size: 48px" class="fas fa-angle-left"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <i style="font-size: 48px" class="fas fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <!-- end Slider section -->
    @endif
    <div class="clearfix"></div>
    <!-- start products section  -->
    <section class="products-tabs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($categories as $no => $category)
                            <li class="nav-item">
                                <a class="nav-link @if($no == 0) active @endif" id="cat{{ $category->id }}-tab" data-toggle="tab" href="#cat{{ $category->id }}" role="tab"
                                   aria-controls="{{ $category['name_'.$lang] }}" aria-selected="true">{{ $category['name_'.$lang] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if($categories->count() > 0)
                <div class="col-md-12">
                    <div class="content">
                        <div class="tab-content" id="myTabContent">
                            @foreach($categories as $no => $category)
                            <div class="tab-pane fade @if($no == 0)show active @endif" id="cat{{ $category->id }}" role="tabpanel" aria-labelledby="cat{{ $category->id }}-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if(isset($category->mainImage))
                                            <img src="{{ asset('pictures/categories/' . $category->mainImage->file) }}" alt="{{ $category['name_'.$lang] }}"/>
                                        @else
                                            <img src="{{ asset('frontend') }}/images/il_1588xN.2599953769_s5wj.jpg" alt="{{ $category['name_'.$lang] }}"/>
                                        @endif
                                    </div>
                                    <div style="position: relative" class="col-md-6">
                                        <div class="content-content">
                                            <div class="custom-title">
                                                {{ $category['name_'.$lang] }}
                                            </div>
                                            <div class="custom-subtitle">
                                                @lang('trans.desc_pro') :
                                            </div>
                                            <div class="custom-desc">
                                                {{ $category['body_'.$lang] }}
                                            </div>
                                            <div class="text-center">
                                                <a href="{{ route('single_category' , $category->slug) }}" class="btn mt-4">
                                                    @lang('trans.see_designs')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- end products section -->
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
                                    <img class="video-image" src="{{ asset('pictures/videos/' . $video->image->file) }}" alt="{{ $video['name_'.$lang] }}"/>
                                @else
                                    <img class="video-image" src="{{ asset('frontend') }}/images/video.jpg" alt="{{ $video['name_'.$lang] }}"/>
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
    <div class="modal fade" id="example{{ $video->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $video->id }}Title"
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