<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-20">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right  d-flex align-items-center">
                    @php
                    use App\Models\Cart;
                    $total_cart = Cart::count();
                    @endphp
                    @if (Auth::user()->role == 'admin')
                    <a href="{{ route('get.cart') }}">
                        <div class="btn btn-success">
                            <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                            <span class="badge bg-danger">{{ $total_cart }}</span>
                        </div>
                    </a>
                    @endif
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <h6>John Doe</h6>
                                    <div class="image">
                                        <img src="{{ asset('assets/images/profile/profile-image.png') }}" alt="" />
                                        <span class="status"></span>
                                    </div>
                                </div>
                            </div>
                            <i class="lni lni-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        <i class="lni lni-exit"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>