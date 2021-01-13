@extends('backend.layout.master')
@section('backend-head')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap');
        .arabic{
            font-family: 'Almarai', sans-serif;
            color: black;
        }
        .english{
            font-family: 'Barlow', sans-serif;
            color: black;
        }
        .body span,.body p{
            font-size: 12px;
            color: #373838;
        }
        .body p.english{
            margin-bottom: 0.5rem;
        }
        .table-bordered ,.table-bordered td, .table-bordered th {
            border: 1px solid black!important;
        }
        .dashed{
            border:2px dashed grey;
        }
        @media print {
            .paper{
                width: 100%;
                height:100%;
                position:absolute;
                top:0px;
                bottom:0px;
                right: 0;
                left: 0;
                margin: auto;
                margin-top: 0px !important;
            }
            .form-row , .btn{
                display: none;
            }
        }
    </style>
@endsection
@section('backend-main')
    <div class="container my-5">
        <div class="row form-row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title-desc"></p>
                        <form method="get" action="{{ route('order_bill',$order->id) }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="received">Received</label>
                                        <input type="text" name="received" class="form-control" id="received" placeholder="received" required>
                                        @error('received')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="att">Att.</label>
                                        <input type="text" name="att" class="form-control" id="att" placeholder="att" required>
                                        @error('att')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bill_no">Bill No.</label>
                                        <input type="text" name="bill_no" class="form-control" id="bill_no" placeholder="bill no" required>
                                        @error('bill_no')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
        @if(isset($received) && isset($att) && isset($bill_no))
            <div class="col-md-12 mb-4">
                <button onclick="window.print()" style="width: 100%" class="btn btn-success">Print</button>
            </div>
        @endif
        <div class="row">
            <div style="background: white" class="paper col-md-12 py-5">
                <div class="row">
                    <div class="col-md-12 text-center my-5">
                        <img style="" src="{{ asset('frontend/images/print-logo.png') }}">
                        <h3 class="mt-4">
                            <span class="arabic">فــاتــورة</span>
                            <br>
                            <span class="english">Invoice</span>
                        </h3>
                    </div>
                    <div class="col-md-12 px-5">
                        <div class="body">
                            <div class="row">
                                <div class="col-md-8 m-0">
                                    <br>
                                    <p class="english">Customer Name : {{ $order->fullname }}</p>
                                    <p class="english">Att. {{ $att }}</p>
                                    <p class="english">Address : <small>street</small> {{ $order->street_address }} / <small>build no.</small> {{ $order->building_no }} / <small>area</small> {{ $order->area }} / <small>city</small> {{ $order->city->name_en }} / <small>country</small> {{ $order->city->country->name_en }} </p>
                                </div>
                                <div class="col-md-4 m-0">
                                    <p>
                                        <span style="display: block" class="arabic">رقم الطلب</span>
                                        <span style="display: block" class="english"> Order Ref. No. : {{ $order->order_no }}</span>
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                        <span>
                                            <span style="display: block" class="arabic">رقم الفاتورة</span>
                                            <span style="display: block" class="english">Invoice No. : {{ $bill_no }}</span>
                                        </span>
                                        </div>
                                        <div class="col-md-6">
                                        <span>
                                            <span style="display: block" class="arabic">التاريخ</span>
                                            <span style="display: block" class="english">Date : {{ \Carbon\Carbon::now()->toDateString() }}</span>
                                        </span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-12 text-center">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>
                                                <span class="arabic">الرقم</span>
                                                <br>
                                                <span class="english">No.</span>
                                            </th>
                                            <th>
                                                <span class="arabic">وصف</span>
                                                <br>
                                                <span class="english">Description</span>
                                            </th>
                                            <th>
                                                <span class="arabic">الكمية</span>
                                                <br>
                                                <span class="english">Quantity</span>
                                            </th>
                                            <th>
                                                <span class="arabic">سعر الوحدة</span>
                                                <br>
                                                <span class="english">Unit Price</span>
                                            </th>
                                            <th>
                                                <span class="arabic">القيمة</span>
                                                <br>
                                                <span class="english">Amount</span>
                                            </th>
                                        </tr>
                                        @foreach($order->pays as $pay)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ mb_substr($pay->product->body_en, 0, 100) }}</td>
                                            <td>{{ $pay->count }}</td>
                                            <td>
                                                @if(empty($pay->product->discount_price))
                                                    {{ $pay->product->price }} SAR
                                                @else
                                                    {{ $pay->product->discount_price }} SAR
                                                @endif
                                            </td>
                                            <td>
                                                @if(empty($pay->product->discount_price))
                                                    {{ $pay->product->price * $pay->count }} SAR
                                                @else
                                                    {{ $pay->product->discount_price * $pay->count }} SAR
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="padding: 0" colspan="4">
                                                <div class="row">
                                                    <div class="col-md-3 text-left">
                                                        <span class="english ml-2">
                                                            In Words
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 style="position: relative;float: left;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                                            <?php
                                                            $numberToWords = new \NumberToWords\NumberToWords();
                                                            $numberTransformer = $numberToWords->getNumberTransformer('en');
                                                            echo $numberTransformer->toWords($order->total_price) .' '. 'Riyals';
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-3 text-right">
                                                        <span class="arabic mr-3">المجموع بالريال السعودي</span>
                                                        <br>
                                                        <span class="english mr-3">Total SR</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $order->total_price }} SAR
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="dashed p-2">
                                                <strong class="english">
                                                    Payment Transfer Details :
                                                </strong>
                                                <div>
                                                    <strong class="english">
                                                        Name Of Bank :
                                                    </strong>
                                                    <span class="english">
                                                        Saudi Bank Hollandi Bank
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="english">
                                                        Account Holder Name :
                                                    </strong>
                                                    <span class="arabic">
                                                        سهيلة فايق أحمد حافظ
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="english">
                                                        Account No :
                                                    </strong>
                                                    <span class="english">
                                                        010-531-866-008
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="english">
                                                        Branch :
                                                    </strong>
                                                    <span class="arabic">
                                                        فرع مكة المكرمة - المنظقة الغربية - 356
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="english">
                                                        IBAN No :
                                                    </strong>
                                                    <span class="english">
                                                        SA31 5000 0000 0105 3186 6008
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-4">
                                            <div style="position: relative;float: left;top: 50%;left: 50%;transform: translate(-50%, -50%);" class="">
                                                <div>
                                                    <span style="font-size: 15px" class="english">
                                                        Received by : {{ $received }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span style="font-size: 15px" class="english">
                                                        Signature :
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-5">
                                    <span class="english pr-3">
                                        <strong>
                                            CR.
                                        </strong>
                                         4031244770
                                    </span>
                                    <span class="english pr-3">
                                        <i class="fas fa-mobile-alt"></i>
                                         +966556522025
                                    </span>
                                    <span class="english pr-3">
                                        <i class="far fa-envelope"></i>
                                         info@suhailacreation.com
                                    </span>
                                    <br>
                                    <strong style="font-size: 13px" class="english">
                                        suhailacreation.com
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute;bottom: 0" class="col-md-12 mt-2">
                        <img style="width: 100%;" src="{{ asset('frontend/images/footer-shape.png') }}" alt="footer image">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('backend-footer')
    <script src="{{ asset('backend') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('backend') }}/assets/libs/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/pages/form-element.init.js"></script>
@endsection