<header class="d-none d-sm-block bg-light border shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <a href="{{ url('/') }}" class="navbar-brand text-white">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/01/Icon-VPBank.png" alt="" id="logo" height="60">
            </a>
            
            @if (Auth::check())
                <div class="dropdown" style="z-index: 1021;">
                    <button class="btn shadow-sm fw-semibold dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hello, {{ Auth::user()->name }}
                    </button>
                
                    <ul class="dropdown-menu">
                        @if (Auth::check())
                            <li>
                                <a class="dropdown-item" href="{{ route('client.profile') }}">Your profile</a>
                            </li>
                            @if (Auth::user()->type == 'admin')
                                <li>
                                    <a class="dropdown-item text-primary" href="{{ route('dashboard.index') }}">Admin Panel</a>
                                </li>
                            @endif

                            <hr class="dropdown-divider">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-semibold">Log out</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            @else
                <div>
                    <a href="{{ route('login') }}" class="btn shadow-sm fw-semibold">Log in</a>
                    <a href="{{ route('register') }}" class="btn border border-2 fw-semibold">Register</a>
                </div>
            @endif
        </div>
    </div>
</header>

<!-- Mobile search box -->
<form id="mobile-search" action="{{ route('search') }}" method="GET" class="d-flex d-sm-none bg-dark text-white px-4 shadow" style="z-index: 1021;">
    <input type="text" class="form-control bg-dark text-white border-0 rounded-0" name="search" placeholder="Search" value="{{ request('search') }}" required>
    <button type="submit" class="btn btn-dark fs-3 rounded-0">GO</button>
    <span><i class="bi bi-x fs-1" onclick="closeMobileSearch()"></i></span>
</form>

<nav class="bg-light sticky-top">
    <div class="container">
        <div class="d-none d-sm-flex align-items-center justify-content-between py-3 sticky-top">
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ url('/') }}" class="btn fw-semibold {{ request()->is('/') ? 'text-primary fw-bold' : '' }}">Home</a>
                @php
                    $categories = DB::table('categories')
                        ->select('*')
                        ->orderBy('id', 'asc')
                        ->get();
                @endphp

                @foreach ($categories as $category)
                    <a href="{{ url('/cate/' . $category->id) }}" class="btn fw-semibold {{ request()->is('cate/' . $category->id) ? 'text-primary fw-bold' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <form action="{{ route('search') }}" method="GET" class="d-flex">
                <input type="text" class="form-control" name="search" placeholder="What are u looking for?" value="{{ request('search') }}" required>
                <button type="submit" class="btn btn-success px-3 ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="d-flex d-sm-none align-items-center justify-content-between py-3">
            <div class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-expanded="false" aria-controls="mobileMenu">
                <i class="bi bi-list"></i>
            </div>
            <a href="{{ url('/') }}" class="navbar-brand text-white">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/01/Icon-VPBank.png" alt="" id="logo" height="45">
            </a>
            <div class="d-flex">
                @if (Auth::check())
                    <div class="dropdown" style="z-index: 1021;">
                        <button class="btn border fw-semibold dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </button>
                    
                        <ul class="dropdown-menu">
                            @if (Auth::check())
                                <li>
                                    <a class="dropdown-item" href="{{ route('client.profile') }}">Your profile</a>
                                </li>
                                @if (Auth::user()->type == 'admin')
                                    <li>
                                        <a class="dropdown-item text-primary" href="{{ route('dashboard.index') }}">Admin Panel</a>
                                    </li>
                                @endif

                                <hr class="dropdown-divider">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-semibold">Log out</button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                @else
                    <div>
                        <a href="{{ route('login') }}" class="btn fw-semibold">Log in</a>
                        <a href="{{ route('register') }}" class="btn fw-semibold">Register</a>
                    </div>
                @endif
                <div class="btn border ms-2" onclick="toggleMobileSearch()">
                    <i class="bi bi-search"></i>
                </div>
            </div>
        </div>

        <div class="collapse d-sm-none" id="mobileMenu">
            <div class="card card-body rounded-0">
                <a href="{{ url('/') }}" class="btn fw-semibold {{ request()->is('/') ? 'text-primary fw-bold' : '' }}">Home</a>
                @php
                    $categories = DB::table('categories')
                        ->select('*')
                        ->orderBy('id', 'asc')
                        ->get();
                @endphp
    
                @foreach ($categories as $category)
                    <a href="{{ url('/cate/' . $category->id) }}" class="btn fw-semibold {{ request()->is('cate/' . $category->id) ? 'text-primary fw-bold' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</nav>