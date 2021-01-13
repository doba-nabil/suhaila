@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@section('pageTitle', $page['name_'.$lang])
@section('frontend-main')
    <!-- Slider section -->
    <!------------#############  slider ############3----------------->
    <div class="clearfix"></div>
    <section class="category-template">
        <div class="page-banner">
            @if(isset($page->image))
                <img src="{{ asset('pictures/pages/' . $page->image->file) }}"/>
            @else
                <img src="{{ asset('frontend') }}/images/shutterstock_1856891377.jpg"
                     alt="{{ $page['name_'.$lang] }}">
            @endif
            <div class="banner-title">
                <h2>{{ $page['name_'.$lang] }}</h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div style="position: relative" class="offset-2 col-md-8">
                    <div style="position: relative;transform: none;left: auto;top: auto" class="about-content py-5">
                        <div class="about-title">
                            {{ $page['name_'.$lang] }}
                        </div>
                        <div class="about-desc">
                           {{ $page['body_'.$lang] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection