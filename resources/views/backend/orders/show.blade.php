@extends('backend.layout.master')
@section('backend-head')
    <link href="{{ asset('backend') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order No {{ $order->order_no }}</h4>
                    <p class="card-title-desc"></p>
                    <hr>
                    <div class="table-responsive">
                        <h4>
                            Order Main Informations
                        </h4>
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row" style="width: 400px;">User Name</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone</th>
                                <td>{{ $order->phone }}</td>
                            </tr>
                            @if($order->status == 0 || $order->status == 1 || $order->status == 2)
                                <tr>
                                    <th scope="row">signed</th>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }} / {{ \Carbon\Carbon::parse($order->time)->format('h:i A') }}</td>
                                </tr>
                            @elseif($order->status == 1)
                                <tr>
                                    <th scope="row">Approved</th>
                                </tr>
                            @endif
                            <tr>
                                <th class="text-danger" scope="row">Payment Type</th>
                                <td class="text-danger">
                                    @if($order->paid_type == 1)
                                        Bank transfer
                                    @else
                                        Pay on receipt
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Street Address</th>
                                <td>
                                    {{ $order->street_address }}
                                </td>
                            <tr>
                                <th scope="row">Building No</th>
                                <td>
                                    {{ $order->building_no }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Area</th>
                                <td>
                                    {{ $order->area }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Address Phone</th>
                                <td>
                                    {{ $order->address_phone }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td>
                                    {{ $order->fullname }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-danger" scope="row">Total Price</th>
                                <td class="text-danger">{{ $order->total_price }} SAR</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <h4>
                            Order Products
                        </h4>
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>One Piece Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->pays as $pay)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td width="100" height="100">
                                        @if(isset($pay->product->mainImage))
                                            <img style="width: 100%;border-radius: 10px" src="{{ asset('pictures/products/' . $pay->product->mainImage->file) }}"/>
                                        @else
                                            <img style="width: 100%;border-radius: 10px" src="{{ asset('backend/assets/images/empty.jpg') }}"/>
                                        @endif
                                    </td>
                                    <td>{{ $pay->product->name_ar }} <br> {{ $pay->product->name_en }}</td>
                                    <td>{{ $pay->count }}</td>
                                    <td>
                                        @if(empty($pay->product->discount_price))
                                             {{ $pay->product->price }} SAR
                                        @else
                                            {{ $pay->product->discount_price }} SAR
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    @if($order->paid_type)
                    <div class="table-responsive">
                        <h4>
                            Transform Image
                        </h4>
                        @if(isset($order->image))
                            <a target="_blank" href="{{ asset('pictures/orders/' . $order->image->file) }}">
                                <img style="border-radius: 10px;height: 100vh" src="{{ asset('pictures/orders/' . $order->image->file) }}"/>
                            </a>
                        @else
                            No Transform Image
                        @endif
                    </div>
                    @endif
                    <hr>
                    <form method="post" action="{{ route('orders.update' , $order->id) }}" class="needs-validation" novalidate>
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row">
                            <div class="col-md-12 ml-auto">
                                <div class="mt-4 mt-lg-0">
                                    <h5 class="font-size-14 mb-4">Status</h5>
                                    <div class="custom-control custom-radio mb-3">
                                        <input @if($order->status == 0) checked @endif type="radio" id="customRadio1" name="status" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Signed</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input @if($order->status == 1) checked @endif type="radio" id="customRadio2" name="status" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Approved</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;justify-content: space-between;">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a href="{{ route('order_bill' , $order->id) }}" class="btn btn-success" type="submit">Order Invoice</a>
                        </div>
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
    <script src="{{ asset('backend') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-advanced.init.js"></script>
@endsection
