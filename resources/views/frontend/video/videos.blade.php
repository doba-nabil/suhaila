@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'الفيديوهات التعليمية')
@else
    @section('pageTitle', 'Educational Videos')
@endif
@section('frontend-main')
    @if($videos->count() > 0)
        <!-- start videos section  -->
        <section class="web-videos">
            <div class="container">
                <div class="row">
                    @foreach($videos as $key => $video)
                        @if($key / 2 == 0)
                            <div class="col-md-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a type="button" href="{{ route('single_video' , $video->slug) }}" class="image_section btn">
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

                                            </a>
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
                            </div>
                            <br>
                        @else
                            <div class="col-md-12">
                                <div class="item">
                                    <div class="row">
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
                                        <div class="col-md-6">
                                            <a type="button" href="{{ route('single_video' , $video->slug) }}" class="image_section btn">
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

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endif
                    @endforeach
                </div>

            </div>
        </section>
    @endif
@endsection
@section('frontend-footer')

@endsection