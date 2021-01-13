@extends('backend.layout.master')
@section('backend-head')
@endsection
@section('backend-main')
    <div class="row">
        <div class="col-12">
            @include('common.done')
            @include('common.errors')
        </div>
    </div>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Suhaila</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Number of Products</p>
                                    <h4 class="mb-0">{{ App\Models\Product::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-boxes font-size-24"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="text-muted ml-2">
                                    <a href="{{ route('products.index') }}">
                                          Show Products
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Main Categories</p>
                                    <h4 class="mb-0">{{ App\Models\Category::whereNull('parent_id')->count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-folder-open font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <span class="text-muted ml-2">
                                    <a href="{{ route('categories.index') }}">
                                          Show Categories
                                    </a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Countires</p>
                                    <h4 class="mb-0">{{ App\Models\Country::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-globe font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <span class="text-muted ml-2">
                                    <a href="{{ route('countries.index') }}">
                                          Show Countries
                                    </a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Cities</p>
                                    <h4 class="mb-0">{{ App\Models\City::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-city font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <span class="text-muted ml-2">
                                    <a href="{{ route('cities.index') }}">
                                          Show Cities
                                    </a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Currencies</p>
                                    <h4 class="mb-0">{{ App\Models\Currency::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-dollar-sign font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <span class="text-muted ml-2">
                                    <a href="{{ route('currencies.index') }}">
                                          Show Currencies
                                    </a>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Subscribers</p>
                                    <h4 class="mb-0">{{ App\Models\Subscribe::count() }}</h4>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-mail-bulk font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <span class="text-muted ml-2">
                                    <a href="{{ route('subscribers.index') }}">
                                          Show Subscribers
                                    </a>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body overflow-hidden">
                            <p class="text-truncate font-size-14 mb-2">Orders</p>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-shopping-cart font-size-24"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i style="color: #33AFFF" class="mdi mdi-circle font-size-10 mr-1"></i>New Orders</p>
                                <h5>{{ \App\Models\Order::where('status' , 0)->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i style="color: #9333FF" class="mdi mdi-circle font-size-10 mr-1"></i>Approved Orders</p>
                                <h5>{{ \App\Models\Order::where('status' , 1)->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mt-4">
                                <p class="mb-2 text-truncate"><i style="color: #FF33FC" class="mdi mdi-circle font-size-10 mr-1"></i>Refused Orders</p>
                                <h5>{{ \App\Models\Order::where('status' , 2)->count() }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Recent Registed Users</h4>
                    <div data-simplebar style="max-height: 330px;">
                        <ul class="list-unstyled activity-wid">
                            @foreach(\App\User::orderBy('id' ,'desc')->paginate(6) as $user)
                                <li class="activity-list">
                                    <div class="activity-icon avatar-xs">
                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                        <i class="ri-user-2-fill"></i>
                                    </span>
                                    </div>
                                    <div>
                                        <div>
                                            <h5 class="font-size-13">{{ $user->created_at->format('d M Y') }} <small class="text-muted">{{ $user->created_at->format('H:i A') }}</small></h5>
                                        </div>

                                        <div>
                                            <p class="text-muted mb-0">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('backend-footer')

@endsection