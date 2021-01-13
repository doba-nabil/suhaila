<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="/" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        {{--<span class="badge badge-pill badge-success float-right">3</span>--}}
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cart-plus"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('orders.index') }}">All Orders</a></li>
                        <li class="{{ Request::is('new/orders')? 'mm-active': '' }}">
                            <a href="{{ route('new_orders') }}">
                                <span class="badge badge-pill badge-danger float-right">{{ \App\Models\Order::where('new' , 1)->count() }}</span>
                                Unshown Orders
                            </a>
                        </li>
                        <li class="{{ Request::is('old/orders')? 'mm-active': '' }}">
                            <a href="{{ route('old_orders') }}">
                                <span class="badge badge-pill badge-soft-danger float-right">{{ \App\Models\Order::where('new' , 0)->count() }}</span>
                                Shown Orders
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="waves-effect">
                        <i class="fas fa-align-left"></i>
                        <span>Categories</span>
                    </a>
                  
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-earth"></i>
                        <span>Locations</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('countries.index') }}">Countries</a></li>
                        <li><a href="{{ route('cities.index') }}">Cities</a></li>
                        <li><a href="{{ route('currencies.index') }}">Currencies</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">All Users</a></li>
                        <li><a href="{{ route('blocked') }}">Blocked Users</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('pages.index') }}" class="waves-effect">
                        <i class="far fa-file-alt"></i>
                        <span>Pages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pages.edit',\App\Models\Page::find(1)->slug) }}" class="waves-effect">
                        <i class="fas fa-puzzle-piece"></i>
                        <span>About Section in home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders.index') }}" class="waves-effect">
                        <i class="fas fa-images"></i>
                        <span>Ad banners ( Slider )</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('banks.index') }}" class="waves-effect">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Bank Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('videos.index') }}" class="waves-effect">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Educational Videos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacts.index') }}" class="waves-effect">
                        <i class="fas fa-envelope"></i>
                        <span>User Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('send_form') }}" class="waves-effect">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Email Message</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->