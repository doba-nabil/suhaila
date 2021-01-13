@extends('backend.layout.master')
@section('backend-head')
    <style>

      .main.product-single {
    position: relative;
    display: block;
    margin: 0 auto;

    padding: 10px;
}
.product-single .left-icon {
    display: inline-block;
    float: left;
    height: auto;
    width: 7%;
    padding: 1em;
    margin-right: 10px;
}
.product-single .left-icon>div {
    margin-bottom: 15px;
    border-radius: 50%;
}
.product-single #left-circle {
    height: 40px;
    width: 40px;
    border-radius: 50%;
}
.product-single  #left-circle:hover {
    border: 2px solid #ffc0cb;
}

.product-single .column {
    float: left;
    width: 43%;
    height: 90vh;
    justify-content: center;
    margin-right: 13px;
    margin-top:10px;
}
.product-single .row:after {
    content: "";
    clear:both;
    display: table;
}

.product-single .row:after {
    content: "";
    display: table;
}
.product-single #img-holder {
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    height: 90vh;
}
.product-single .top-rate-button {
    margin-left: 10px;
    background-color:rgb(245,222,210);
    height: 60px;
    padding: 0.5em;
    border: none;
    border-radius: 10px;
    font-weight: 600;
}
.product-single li {
    font-size: 0.7em;
    margin-bottom: 10px;
}
.product-single .price-button {
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
.product-single .price-button:hover {
    background-color: rgba(0,0,0,0.8);
    cursor: pointer;
}
.product-single .love-button {
    background-color: #570000;
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
.product-single .love-button:hover {
    background-color: rgba(180, 0, 0, 0.8);
    cursor: pointer;
}
.product-video{

}
.product-video .container{

    padding: 100px 50px;

}
.product-video .frame{

    border:10px solid #666;
}
.product-video .frame__in{
    width: 100%;

    background: #ccc;
    border-width: 20px;
    border-style: solid;
    border-color:#555 #888 #555 #888;

}
    </style>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Show Product ( {{ $product->name_en }} ) before Post</h4>
                    <p class="card-title-desc"></p>
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
                                {{ $product->name_en }}
                            </button>
                            <br>
                            <p2>
                                <b>description :</b>
                            </p2>
                            <p2 style="margin-left:10px;">
                                {{ $product->body_en }}
                            </p2>
                            <br>
                            <p2>
                                <b>Price :</b>
                            </p2>
                            <p2 style="margin-left:10px;">
                                @if(empty($product->discount_price))
                                <span class="info">
                                    <p>SAR {{ $product->price }}</p>
                                </span>
                                @else
                                    <span class="info">
                                        SAR {{ $product->discount_price }}
                                        <small>SAR {{ $product->price }}</small>
                                    </span>
                                @endif
                            </p2>
                            <br>
                            
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
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div style="display:flex;justify-content: space-between;" class="col-md-12">
                                <a href="{{ route('products.edit' , $product->slug) }}" class="btn btn-warning text-white">Back To Edit</a>
                                @if($product->active == 0)
                                    <a href="{{ route('post_product' , $product->slug) }}" class="btn btn-success text-white">Post The Product</a>
                                @else
                                    <a href="{{ route('post_product' , $product->slug) }}" class="btn btn-danger text-white">Hide from Store</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('backend-footer')

@endsection
