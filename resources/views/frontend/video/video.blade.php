@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@section('pageTitle', $video['name_'.$lang])
@section('frontend-main')
    <!-- start videos section  -->
    <section class="web-videos">
        <div class="container">
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
        </div>
    </section>
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
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')

@endsection