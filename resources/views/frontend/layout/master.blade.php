<!DOCTYPE html>
<html lang="ar">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('frontend.layout.head')
    <title>{{ $option['title_'.$lang] }} - @yield('pageTitle')</title>
</head>
<body>
<!-- end navbar  -->
@include('frontend.layout.header')
<input type="hidden" value="{{ URL::to('/') . \Request()->route()->getPrefix() }}" id="base_url">
<div id="fixed-social">

    <div>
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @if($localeCode != app()->getLocale())
                @if($localeCode == 'ar')
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="fixed-facebook">ع</a>
                @else
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="fixed-facebook">E</a>
                @endif
            @endif
        @endforeach
    </div>
</div>
@section('frontend-main')

@show
@include('frontend.layout.footer')
</body>
</html>