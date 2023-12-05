@auth('authuser')
@if(Auth::guard('authuser')->user()->role->name === "Customer")
<nav class="navbar navbar-example navbar-expand-lg pt-4 sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home.index') }}">Navbar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-ex-3">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-ex-3">
        <div class="navbar-nav me-auto">
          <a class="nav-item nav-link active" href="{{ route('home.index') }}">Home</a>
          <a class="nav-item nav-link" href="{{ route('shop.index') }}">Shop</a>
        </div>

        <form onsubmit="return false">
            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('store/user/' . Auth::guard('authuser')->user()->photo) }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset('store/user/' . Auth::guard('authuser')->user()->photo) }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block">{{ Auth::guard('authuser')->user()->name }}</span>
                            <small class="text-muted">{{ Auth::guard('authuser')->user()->role->name }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.edit', ['name'=> Auth::guard('authuser')->user()->name]) }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Profile</span>
                      </a>
                    </li>
                    <li>
                    <li>
                      <a class="dropdown-item" href="{{ route('wishlist.index', ['name' => Auth::guard('authuser')->user()->name]) }}">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-cart-download me-2"></i>
                          <span class="flex-grow-1 align-middle ms-1">Keranjang</span>
                          @php
                              $user = Auth::guard('authuser')->user();
                              $cartItemCount = \App\Models\Cart::where('id_user', $user->id_user)->count();
                          @endphp
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">{{ $cartItemCount }}</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
        </form>
      </div>
    </div>
  </nav>
@endif
@else
<nav class="navbar navbar-example navbar-expand-lg pt-4 sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home.index') }}">Navbar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-ex-3">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-ex-3">
        <div class="navbar-nav me-auto">
          <a class="nav-item nav-link active" href="{{ route('home.index') }}">Home</a>
          <a class="nav-item nav-link" href="{{ route('shop.index') }}">Shop</a>
        </div>

        <form onsubmit="return false">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!--/ User -->
                <li class="pr-4 mx-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary" type="button">Login</a>
                </li>
                <li class="pr-4 mx-2">
                    <a href="{{ route('register') }}" class="btn btn-primary text-white" type="button">Register</a>
                </li>
              </ul>
        </form>
      </div>
    </div>
  </nav>
@endauth
