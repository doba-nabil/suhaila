@extends('backend.layout.master')
@section('backend-head')
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Address " {{ $address->street_address }} "</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ route('edit_form' , $address->id) }}" class="needs-validation" novalidate>
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom01">Full Name</label>
                                    <input type="text" name="fullname" class="form-control" id="validationCustom01" placeholder="Full Name" value="{{ $address->fullname }}" required>
                                    @error('fullname')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom02">Street Address</label>
                                    <input type="text" name="street_address" class="form-control" id="validationCustom02" placeholder="Street Address" value="{{ $address->street_address }}" required>
                                    @error('street_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom03">building no</label>
                                    <input type="number" name="building_no" class="form-control" id="validationCustom03" placeholder="building no" value="{{ $address->building_no }}" required>
                                    @error('building_no')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Area</label>
                                    <input type="text" name="area" class="form-control" id="validationCustom04" placeholder="Area" value="{{ $address->area }}" required>
                                    @error('area')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom05">phone</label>
                                    <input type="text" name="phone" class="form-control" id="validationCustom05" placeholder="phone" value="{{ $address->phone }}" required>
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom03">City</label>
                                    <select name="city_id" class="form-control" id="validationCustom03" required>
                                        <option selected disabled hidden value="">---- Select City ----</option>
                                        @foreach($cities as $city)
                                            <option
                                                    @if($city->id == $address->city_id) selected @endif
                                                    value="{{ $city->id }}">{{ $city->name_ar }} / {{ $city->name_en }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" name="active" class="custom-control-input" id="customCheck1"
                                           @if( $address->active == 1 ) checked="" @endif>
                                    <label class="custom-control-label" for="customCheck1">Selected a Main Address</label>
                                </div>
                            </div>
                        </div>
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
    <script src="{{ asset('backend') }}/mine.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
@endsection
