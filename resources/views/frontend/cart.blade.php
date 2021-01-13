@extends('frontend.layout.master')
@section('frontend-head')
    <style>
        .cart-page .modal-dialog {
            max-width: 70%;
        }
        .boxed label {
            display: inline-block;
            padding: 10px;
            border: solid 2px #ccc;
            transition: all 0.3s;
            background: white;
            cursor: pointer;
            border-radius: 10px;
        }
        .boxed input[type="radio"] {
            display: none;
        }
        .boxed input[type="radio"]:checked + label {
            border: solid 2px #495057;
            background: #e9ecef;
        }
        .modal form .btn{
            background: #151412;
            border-radius: 0;
            font-family: Barlow-Light;
            color: white;
            padding: 5px 30px;
            transition: 0.5s;
        }
        .modal form .btn:hover {
            background: #FFFFFF;
            color: #151412;
            border-radius: 15px 0 15px 0;
            border: 1px solid black;
        }


        .file-upload {
            background-color: #ffffff;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-btn {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #9ea1a4;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #e9ecef;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .file-upload-btn:hover {
            background: #555555;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .file-upload-btn:active {
            border: 0;
            transition: all .2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            right: 0;
            left: 0;
            top: 0;
            bottom: 0;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #e9ecef;
            position: relative;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #868789;
            border: 4px dashed #ffffff;
        }
        .image-upload-wrap:hover h3{
            color: #ffffff;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #262727;
            padding: 60px 0;
        }

        .file-upload-image {
            max-height: 200px;
            max-width: 200px;
            margin: auto;
            padding: 20px;
        }

        .remove-image {
            width: 200px;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 700;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }
        .banks{
            display: none;
        }
    </style>
@endsection
@if($lang == 'ar')
    @section('pageTitle', 'سلة الشراء')
@else
    @section('pageTitle', 'Shopping Cart')
@endif
@section('frontend-main')
    <!-- cart section -->
    <section class="cart-page">
        <div class="container">
            <div class="row">
                <div class="car-col col-sm-8 col-12">
                    <div class="shopping-cart carto">
                        <!-- Title -->
                        <div class="title">
                            <span>@lang('trans.shopping_bag')</span>
                        </div>
                        @if(count(Cart::content()) > 0 )
                            @foreach(Cart::content() as $row)
                            <?php
                                $product = \App\Models\Product::find($row->id);
                            ?>
                        <div class="item item_{{ $row->rowId }}">
                            <div style="font-weight: bolder;width: 20px" class="buttons">
                                {{ $loop->index + 1 }} -
                            </div>
                            <div class="image">
                                @if(isset($product->mainImage))
                                    <img style="height: 100%" src="{{ asset('pictures/products/' . $product->mainImage->file) }}" alt="{{mb_substr($product['name_'.$lang], 0, 15)}}">
                                @else
                                    <img style="height: 100%" src="{{ asset('frontend/images/1.jpg') }}" alt="no image" />
                                @endif
                            </div>
                            <div class="description">
                                <span>
                                    <a style="color: black" href="{{ route('single_product' , $product->slug) }}">{{  mb_substr($product['name_'.$lang], 0, 15) }}</a>
                                </span>
                                <span>
                                    <a style="color: grey" href="{{ route('single_category' , $product->category->slug) }}">{{  mb_substr($product->category['name_'.$lang], 0, 15) }}</a>
                                </span>
                                <span class="countoo"><span>{{ __('trans.qty') }} : {{ $row->qty }}</span></span>
                            </div>
                            <div class="pricoo total-price">
                                <span>@lang('trans.sar') {{ $row->subtotal }}</span>
                            </div>
                            <div class="total-price" style="width: 5em">
                            @if($product->kind == 0)
                                <input min="1" max="10" ad="{{ $row->rowId }}" data-token="{{ csrf_token() }}" style="width: 50px ; height: 30px;border-radius: 3px;border: 1px solid black;padding: 5px;direction: ltr" class="qty" name="qty" type="number" value="<?php echo $row->qty; ?>" onchange="cart()">
                            @endif
                            </div>
                            <div class="buttons">
                                <span data-id="{{ $row->rowId }}" class="delete-btn"></span>
                            </div>
                        </div>
                            @endforeach
                        @else
                            <h3 class="alert alert-warning">
                                @lang('controller.empty_cart_controller')
                            </h3>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-12">
                    <div class="shopping-cart">
                        <!-- Title -->
                        <div style="display: flex;justify-content: space-between"  class="title price-title">
                            <span>@lang('trans.total') : </span>
                            <span> {{ Cart::subtotal() }} @lang('trans.sar')</span>
                        </div>
                        <hr>
                        <div style="height: auto"  class="title">
                            <div style="display: flex;justify-content: space-between;" class="btn_wrapper">
                                @auth()
                                    <a type="button" data-toggle="modal" data-target="#myModal" class="btn btn-green accept">@lang('trans.continue')</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-green accept">@lang('trans.continue')</a>
                                @endauth
                                <a class="btn btn-red cancel clear_cart">@lang('trans.clear_cart')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div  style="background: rgba(255,255,255,0.81)" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('trans.end_pay') }}</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('make_order') }}" class="boxed bank text-center" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-split">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>{{ __('trans.chose_pay') }} : </strong>
                                        <input type="radio" id="customCheck1" name="paid_type" value="0">
                                        <label for="customCheck1">
                                            <strong style="color: #262727">{{ __('trans.hand_pay') }}</strong>
                                        </label>
                                        <input type="radio" id="customCheck2" name="paid_type" value="1">
                                        <label for="customCheck2">
                                            <strong style="color: #262727">{{ __('trans.bank_transfer') }}</strong>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="banks">
                                    <strong>{{ __('trans.chose_bank') }} : </strong>
                                    @foreach(\App\Models\Bank::active()->get() as $bank)
                                        <input type="radio" id="bank{{ $bank->id }}" name="bank_id" value="{{ $bank->id }}">
                                        <label for="bank{{ $bank->id }}">
                                            <strong style="color: #262727">@lang('trans.bank_name') :</strong> {{ $bank['name_'.$lang] }}
                                            <br>
                                            <strong style="color: #262727">@lang('trans.owner_name') :</strong> {{ $bank['owner_'.$lang] }}
                                            <br>
                                            <strong style="color: #262727">@lang('trans.iban') :</strong> {{ $bank->iban }}
                                            <br>
                                            <strong style="color: #262727">@lang('trans.acc_no') :</strong> {{ $bank->account }}
                                        </label>
                                    @endforeach
                                    <br><br>
                                    <div class="file-upload">
                                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">@lang('trans.chose_img')</button>
                                        <div class="image-upload-wrap">
                                            <input class="file-upload-input" type='file' name="image" onchange="readURL(this);" accept="image/*" />
                                            <div class="drag-text">
                                                <h3>@lang('trans.drag_drop')</h3>
                                            </div>
                                        </div>
                                        <div class="file-upload-content">
                                            <img class="file-upload-image" src="#" alt="your image" />
                                            <div class="image-title-wrap">
                                                <button type="button" onclick="removeUpload()" class="remove-image">@lang('trans.remove')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-split">
                                <div class="">
                                    <strong>{{ __('trans.address') }} : </strong>
                                    <div class="form-group">
                                        <label>@lang('trans.full_name')</label>
                                        <input type="text" name="fullname" class="form-control" placeholder="@lang('trans.full_name')" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('trans.street_address')</label>
                                        <input type="text" name="street_address" class="form-control" placeholder="@lang('trans.street_address')" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('trans.building_no')</label>
                                        <input type="text" name="building_no" class="form-control" placeholder="@lang('trans.building_no')" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('trans.area')</label>
                                        <input type="text" name="area" class="form-control" placeholder="@lang('trans.area')" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">@lang('trans.phone')</label>
                                        <input id="phone" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" class="form-control" placeholder="@lang('trans.phone')" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">@lang('trans.city')</label>
                                        <select name="city_id" class="form-control" id="exampleFormControlSelect1" required>
                                            @foreach(\App\Models\City::active()->get() as $city)
                                                <option value="{{ $city->id }}">{{ $city['name_'.$lang] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection
@section('frontend-footer')
    <script>
        $("input[name=paid_type]").click(function () {
            if($('#customCheck1').is(':checked')) {
                $('.banks').hide();
            }else if($('#customCheck2').is(':checked')) {
                $('.banks').show();
            }
        });
    </script>
    <script>
        $('.like-btn').on('click', function() {
            $(this).toggleClass('is-active');
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                    $('.image-title').html(input.files[0].name);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                removeUpload();
            }
        }
        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>
    @if($lang == 'en')
        <script>
            $(document).ready(function() {
                prep_modal();
            });
            function prep_modal()
            {
                $(".modal").each(function() {

                    var element = this;
                    var pages = $(this).find('.modal-split');

                    if (pages.length != 0)
                    {
                        pages.hide();
                        pages.eq(0).show();
                        var b_button = document.createElement("button");
                        b_button.setAttribute("type","button");
                        b_button.setAttribute("class","btn btn-primary");
                        b_button.setAttribute("style","display: none;");
                        b_button.innerHTML = "Back";
                        var n_button = document.createElement("button");
                        n_button.setAttribute("type","button");
                        n_button.setAttribute("class","btn btn-primary");
                        n_button.innerHTML = "Next";
                        $(this).find('.modal-footer').append(b_button).append(n_button);
                        var page_track = 0;
                        $(n_button).click(function() {
                            this.blur();
                            if(page_track == 0)
                            {
                                $(b_button).show();
                            }
                            if(page_track == pages.length-2)
                            {
                                $(n_button).text("Submit");
                            }
                            if(page_track == pages.length-1)
                            {
                                $(element).find("form").submit();
                            }
                            if(page_track < pages.length-1)
                            {
                                page_track++;
                                pages.hide();
                                pages.eq(page_track).show();
                            }
                        });
                        $(b_button).click(function() {
                            if(page_track == 1)
                            {
                                $(b_button).hide();
                            }
                            if(page_track == pages.length-1)
                            {
                                $(n_button).text("Next");
                            }
                            if(page_track > 0)
                            {
                                page_track--;

                                pages.hide();
                                pages.eq(page_track).show();
                            }
                        });
                    }
                });
            }
        </script>
    @else
        <script>
            $(document).ready(function() {
                prep_modal();
            });
            function prep_modal()
            {
                $(".modal").each(function() {
                    var element = this;
                    var pages = $(this).find('.modal-split');
                    if (pages.length != 0)
                    {
                        pages.hide();
                        pages.eq(0).show();
                        var b_button = document.createElement("button");
                        b_button.setAttribute("type","button");
                        b_button.setAttribute("class","btn btn-primary");
                        b_button.setAttribute("style","display: none;");
                        b_button.innerHTML = "السابق";
                        var n_button = document.createElement("button");
                        n_button.setAttribute("type","button");
                        n_button.setAttribute("class","btn btn-primary");
                        n_button.innerHTML = "التالي";
                        $(this).find('.modal-footer').append(b_button).append(n_button);
                        var page_track = 0;
                        $(n_button).click(function() {
                            this.blur();
                            if(page_track == 0)
                            {
                                $(b_button).show();
                            }
                            if(page_track == pages.length-2)
                            {
                                $(n_button).text("ارسال");
                            }
                            if(page_track == pages.length-1)
                            {
                                $(element).find("form").submit();
                            }
                            if(page_track < pages.length-1)
                            {
                                page_track++;
                                pages.hide();
                                pages.eq(page_track).show();
                            }
                        });
                        $(b_button).click(function() {
                            if(page_track == 1)
                            {
                                $(b_button).hide();
                            }
                            if(page_track == pages.length-1)
                            {
                                $(n_button).text("التالي");
                            }
                            if(page_track > 0)
                            {
                                page_track--;

                                pages.hide();
                                pages.eq(page_track).show();
                            }
                        });
                    }
                });
            }
        </script>
    @endif
@endsection