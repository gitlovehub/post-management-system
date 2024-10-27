<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        <!-- Chart.js for graphs -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- CK Editor for rich text -->
        <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
        <!-- Simple DataTables styles -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <!-- Font Awesome icons -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Custom admin styles -->
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ms-3 fs-3 fw-semibold text-primary" href="{{ route('dashboard.index') }}">Admin Panel</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 border" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search for..." />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-semibold">Log out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav" class="shadow">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <!-- Dashboard Link -->
                            <a class="nav-link fw-semibold {{ Route::is('dashboard.index') ? 'active shadow' : '' }}" href="{{ route('dashboard.index') }}">
                                Dashboard
                            </a>
                        
                            <!-- Categories Link -->
                            <a class="nav-link fw-semibold {{ Route::is('categories.index') || Route::is('categories.create') ? 'active shadow' : '' }}" href="{{ route('categories.index') }}">
                                Categories
                            </a>

                            <!-- Tags Link -->
                            <a class="nav-link fw-semibold {{ Route::is('tags.index') || Route::is('tags.create') ? 'active shadow' : '' }}" href="{{ route('tags.index') }}">
                                Tags
                            </a>                           
                        
                            <!-- Posts Link -->
                            <a class="nav-link fw-semibold {{ Route::is('posts.index') || Route::is('posts.create') ? 'active shadow' : '' }}" href="{{ route('posts.index') }}">
                                Posts
                            </a>
                        
                            <!-- Users Link -->
                            <a class="nav-link fw-semibold {{ Route::is('users.index') ? 'active shadow' : '' }}" href="{{ route('users.index') }}">
                                Users
                            </a>

                            <!-- Comments Link -->
                            <a class="nav-link fw-semibold {{ Route::is('comments.index') ? 'active shadow' : '' }}" href="{{ route('comments.index') }}">
                                Comments
                            </a>                            

                            <!-- Back to Website -->
                            <a class="nav-link fw-semibold" href="{{ url('/') }}">
                                Go to Website
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main class="container-fluid px-4">
                    <h1 class="text-center my-4">@yield('h1')</h1>
                    @yield('content')
                </main>

                <footer class="py-4 mt-5 bg-light border-top shadow">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; hungtd010302@gmail.com {{ date('Y') }}</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <script src="{{ asset('admin/js/sidebar.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    </body>
</html>
