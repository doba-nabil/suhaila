@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('backend') }}/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
          rel="stylesheet"/>
    <link href="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add New Product</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('products.update' , $product->id) }}" class="needs-validation" novalidate
                          enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom01">Name in Arabic</label>
                                    <input type="text" name="name_ar" class="form-control" id="validationCustom01"
                                           placeholder="Name in Arabic" value="{{ $product->name_ar }}" required>
                                    @error('name_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom02">Name in English</label>
                                    <input type="text" name="name_en" class="form-control" id="validationCustom02"
                                           placeholder="Name in English" value="{{ $product->name_en }}" required>
                                    @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price "SAR"</label>
                                    <input min="0" step="0.1" type="number" name="price" class="form-control" id="price"
                                           placeholder="Price" value="{{ $product->price }}" required>
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_price">Price after Discount "SAR" ( Optional ) </label>
                                    <input min="0" step="0.1" type="number" name="discount_price" class="form-control"
                                           id="discount_price" placeholder="Price after Discount ( Optional )"
                                           value="{{ $product->discount_price }}">
                                    @error('discount_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body_ar">Descreption in Arabic</label>
                                    <textarea rows="10" type="text" name="body_ar" class="form-control summernote"
                                              id="body_ar" placeholder="Descreption in Arabic"
                                              required>{{ $product->body_ar }}</textarea>
                                    @error('body_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body_en">Descreption in English</label>
                                    <textarea rows="10" type="text" name="body_en" class="form-control summernote"
                                              id="body_en" placeholder="Descreption in English"
                                              required>{{ $product->body_en }}</textarea>
                                    @error('body_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Select Category</label>
                                    <select name="category_id" class="form-control select2" id="category_id" required>
                                        <option>Select</option>
                                        @foreach($categories as $category)
                                            <option
                                                    @if($category->id == $product->category_id) selected @endif
                                                    value="{{ $category->id }}">{{ $category->name_en }}
                                                / {{ $category->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Select Kind</label>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="radio" value="0" @if($product->kind == 0) checked @endif
                                           name="kind" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Product</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="radio" value="1" @if($product->kind == 1) checked @endif
                                           name="kind" class="custom-control-input" id="customCheck2">
                                    <label class="custom-control-label" for="customCheck2">Design</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Main Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="customFile"
                                               onchange="readURL(this);">
                                        <label class="custom-file-label" for="customFile">Main Image</label>
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        @if(isset($product->mainImage))
                                            <img id="blah" class="mt-3" src="{{ asset('pictures/products/' . $product->mainImage->file) }}"/>
                                        @else
                                            <img id="blah" class="mt-3" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 images mt-3">
                                <div class="form-group">
                                    <label class="control-label">Sub Images</label>
                                    <span class="btn btn-success fileinput-button">
                                <span>Select Images</span>
                                <input type="file" name="images[]" id="files" multiple
                                       accept="image/jpeg, image/png, image/gif,"><br/>
                                </span>
                                    <br>
                                    <output class="mt-3" id="Filelist"></output>
                                    <div class="col-md-12">
                                        @foreach($product->subImages as $image)
                                            <div class="image_class{{ $image->id }}" style="width:102px;display: inline-block">
                                                <img width="100" height="100" src="{{ asset('pictures/products/' . $image->file) }}">
                                                <a  style="width: 100px;border-radius: 0;text-align: center" title="" onclick="return false;" object_id="{{ $image->id }}"
                                                    delete_url="/delete_product_image/" class="btn btn-danger edit-btn-table delete_event_image" href="#">
                                                    Delete
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-lg-12 col-md-12">
                            <fieldset class="form-group">
                                <label for="basicInputFile">Video</label>
                                <div class="custom-file">
                                    <input id="file-input" name="video" type="file" class="custom-file-input"  type="file" accept="video/*">
                                    <label class="custom-file-label" for="file-input">Chose Video</label>
                                </div>
                                @error('video')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <div class="text-center">
                                @if(isset($product->video))
                                    <video id="videoo" width="200" height="200" controls>
                                        <source src="{{ asset('pictures/products/' . $product->video->file ) }}">
                                    </video>
                                    <video id="video" class="video_create" width="200" height="200"
                                           controls></video>
                                @else
                                    <video id="video" class="video_create" width="200" height="200"
                                           controls></video>
                                @endif

                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="col-lg-12 col-md-12 file">
                            <fieldset class="form-group">
                                <label for="basicInputFile">file</label>
                                <div class="custom-file">
                                    <input name="file" type="file" type="file">
                                </div>
                                @error('file')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <br>
                            @if(isset($product->file))
                                <a target="_blank" href="{{ asset('pictures/files/' . $product->file->file) }}" class="file-button">
                                    <i class="fa fa-file fa-2x"></i>
                                </a>
                            @endif
                        </div>
                        <br>
                        <hr>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="{{ asset('backend') }}/image_uploader.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-advanced.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/sweet-alerts.init.js"></script>
    <script src="{{ asset('backend') }}/custom-sweetalert.js"></script>
    <script>
        if($('#customCheck1').is(':checked')) {
            $('.file').hide();
        }else if($('#customCheck2').is(':checked')) {
            $('.file').show();
        }
        $("input[type=radio]").click(function () {
            if($('#customCheck1').is(':checked')) {
                $('.file').hide();
            }else if($('#customCheck2').is(':checked')) {
                $('.file').show();
            }
        });
    </script>
@endsection
