@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Page " {{ $page->name_en }} "</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('pages.update' , $page->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom01">Name in Arabic</label>
                                    <input type="text" name="name_ar" class="form-control" id="validationCustom01" placeholder="Name in Arabic" value="{{ $page->name_ar }}" required>
                                    @error('name_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validationCustom02">Name in English</label>
                                    <input type="text" name="name_en" class="form-control" id="validationCustom02" placeholder="Name in English" value="{{ $page->name_en }}" required>
                                    @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body_ar">Page content in Arabic</label>
                                    <textarea rows="10" type="text" name="body_ar" class="form-control summernote" id="body_ar" placeholder="Page content in Arabic"required>{{ $page->body_ar }}</textarea>
                                    @error('body_ar')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body_en">Page content in English</label>
                                    <textarea rows="10" type="text" name="body_en" class="form-control summernote" id="body_en" placeholder="Page content in English"required>{{ $page->body_en }}</textarea>
                                    @error('body_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox"
                                           @if($page->active == 1) checked="" @endif
                                           name="active" class="custom-control-input" id="customCheck1" >
                                    <label class="custom-control-label" for="customCheck1">Active</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile" onchange="readURL(this);" >
                                    <label class="custom-file-label" for="customFile">Choose Image</label>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    @if(isset($page->image))
                                        <img id="blah" style="width: 380px;height: 180px;object-fit: cover;" class="mt-3" src="{{ asset('pictures/pages/' . $page->image->file) }}"/>
                                    @else
                                        <img id="blah" style="width: 380px;height: 180px;object-fit: cover;" class="mt-3" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/summernote/summernote-bs4.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-editor.init.js"></script>
@endsection