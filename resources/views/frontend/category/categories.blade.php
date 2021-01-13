@extends('frontend.layout.master')
@section('frontend-head')
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'التصنيفات')
@else
    @section('pageTitle', 'Categories')
@endif
@section('frontend-main')
    <!-- start categories section -->
    <section class="category-section mt-5">
        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 col-6">
                        <div class="item">
                            <a href="{{ route('single_category' , $category->slug) }}">
                                <div class="box">
                                    @if(isset($category->mainImage))
                                        <img src="{{ asset('pictures/categories/' . $category->mainImage->file) }}" alt="{{ $category['name_'.$lang] }}"/>
                                    @endif
                                    <div class="box-content-before">
                                        <h3 class="name">
                                            {{ $category['name_'.$lang] }}
                                        </h3>
                                    </div>
                                    <div class="box-content">
                                        <h3 class="name">
                                            {{ $category['name_'.$lang] }}
                                        </h3>
                                        <span class="post">
                                            {{ $category['body_'.$lang] }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- end categories section -->
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
@endsection