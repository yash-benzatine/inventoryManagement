<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Inventory Management</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'customer') == true ? 'active' : '' }}" href="{{ route('customer.index') }}">

                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-user text-primary fa-solid text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'suppliers') == true ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-truck text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'tax') == true ? 'active' : '' }}" href="{{ route('tax.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-percent text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tax</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'users') == true ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'roles') == true ? 'active' : '' }}" href="{{ route('roles.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Roles</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#navbar-maps" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-maps">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-product-hunt text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Product Manage</span>
                </a>
                <div class="collapse" id="navbar-maps" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'category') == true ? 'active' : '' }}" href="{{ route('category.index') }}">
                                {{--
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Category</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'sub-category') == true ? 'active' : '' }}" href="{{ route('sub-category.index') }}">

                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Sub Category</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'product') == true ? 'active' : '' }}" href="{{ route('product.index') }}">

                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Product</span>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="../pages/maps/google.html" class="nav-link">
                                <span class="sidenav-mini-icon"> G </span>
                                <span class="sidenav-normal"> Google </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/maps/vector.html" class="nav-link">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal"> Vector </span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#navbar-purchases" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-maps">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-shopping-basket text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Purchases</span>
                </a>
                <div class="collapse" id="navbar-purchases" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'manage-purchase') == true ? 'active' : '' }}" href="{{ route('manage-purchase.index') }}">

                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">New Purchase</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'purchase') == true ? 'active' : '' }}" href="{{ route('purchase.index') }}">
                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Purchase History</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#navbar-sale" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-maps">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-credit-card text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Sales</span>
                </a>
                <div class="collapse" id="navbar-sale" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'manage-sale') == true ? 'active' : '' }}" href="{{ route('manage-sale.index') }}">
                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">New Sale</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'sale') == true ? 'active' : '' }}" href="{{ route('sale.index') }}">
                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Sale History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#navbar-report" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-maps">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-bug text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Report</span>
                </a>
                <div class="collapse" id="navbar-report" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'purchase-index-report') == true ? 'active' : '' }}" href="{{ route('purchaseReport.index') }}">
                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Purchase Report</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ str_contains(request()->url(), 'sale-index-report') == true ? 'active' : '' }}" href="{{ route('saleReport.index') }}">
                                {{-- <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                                </div> --}}
                                <span class="nav-link-text ms-1">Sales Report</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'setting') == true ? 'active' : '' }}" href="{{ route('setting.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni fa fa-cog text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Setting</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
