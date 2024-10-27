<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- CK Editor for rich text -->
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    
    <!-- Custom admin styles -->    
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    
    <title>
        {{$user->name}} – Profile
    </title>
</head>

<body>
    <div class="container pt-5" style="min-height: 100vh">
        <div class="row flex-lg-nowrap">
            <div class="d-none d-lg-block col-lg-auto mb-3" style="width: 250px;">
                <div class="border rounded p-3">
                    <div class="mb-2">
                        <h6 class="form-label">Current Password</h6>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <h6 class="form-label">New Password</h6>
                        <input type="password" name="newPassword" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <h6 class="form-label">Confirm Password</h6>
                        <input type="password" name="confirmPassword" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-12 col-sm-auto mb-3">
                                            @if ($user->avatar)
                                                <img src="{{Storage::url($user->avatar)}}" class="object-fit-cover rounded" width="140px" height="140px" alt="">
                                            @else
                                                <img src="https://via.placeholder.com/150" class="object-fit-cover width="150px" height="150px" rounded" alt="">
                                            @endif
                                        </div>
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-center text-sm-start mb-2 mb-sm-0">
                                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name}}</h4>
                                                
                                                <div class="text-muted pt-3">
                                                    @if(Cache::has('user-is-online-' . $user->id))
                                                        <span class="badge badge-pill bg-success fw-bold">Online</span>
                                                    @else
                                                        <small>Last seen {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</small>
                                                    @endif
                                                </div>
                                                <div class="pt-2">
                                                    <label for="file-upload" class="btn btn-outline-primary">
                                                        <i class="bi bi-camera"></i>
                                                        <span>Change Avatar</span>
                                                    </label>
                                                    <input type="file" name="avatar" id="file-upload" style="display:none;">
                                                </div>
                                            </div>
                                            <div class="text-end text-sm-right">
                                                <span class="badge bg-info">admin</span>
                                                <div class="text-muted fw-semibold">
                                                    <small>
                                                        Joined
                                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                                    </small>
                                                </div>
                                                <div class="text-center">
                                                    @if (session('msg'))
                                                        <p class="badge rounded-pill text-bg-success">{{session('msg')}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <a href="" class="btn btn-primary">
                                            <i class="bi bi-plus-lg"></i>
                                            New Post
                                        </a>
                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="#info" class="nav-link fw-semibold" data-bs-toggle="tab">
                                                <i class="bi bi-pencil"></i>
                                                Info
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#manage-posts" class="nav-link fw-semibold active" data-bs-toggle="tab">
                                                <i class="fa fa-cog fa-spin"></i>
                                                Manage Posts
                                            </a>
                                        </li>
                                    </ul>
                                    
                                    <!-- Tab Content -->
                                    <div class="tab-content pt-5">
                                        <!-- Info Content -->
                                        <div class="tab-pane" id="info">
                                            <form class="form" novalidate="">
                                                <div class="row">
                                                    <div class="col">
                                                        @if ($errors->any())
                                                            @foreach ($errors->all() as $msg)
                                                                <p class="badge bg-danger">{{$msg}}</p>
                                                            @endforeach
                                                        @endif
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <h6 class="form-label">Full Name</h6>
                                                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <h6 class="form-label">Email</h6>
                                                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    
                                        <!-- Manage Posts Content -->
                                        <div class="tab-pane active" id="manage-posts">
                                            @foreach ($posts as $item)
                                                <div class="col col-md-10 mb-5 m-auto">
                                                    <div class="card bg-light border-0 h-100 shadow-sm">
                                                        @if ($item->image)
                                                            <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="">
                                                        @else
                                                            <img src="https://via.placeholder.com/150/aaa/FFF?text=image" class="card-img-top" alt="">
                                                        @endif
                                                        <div class="card-body p-4">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <a href="{{ url('/cate/' . $item->category_id) }}" class="text-decoration-none fw-semibold text-primary text-uppercase">{{ $item->category_name }}</a>
                                                                <small class="text-muted">
                                                                    {{$item->view}}
                                                                    <i class="bi bi-eye"></i>
                                                                </small>
                                                            </div>
                                                            @if ($item->status == 'draft')
                                                                <h4 class="title my-2">{{ $item->title }}</h4>
                                                                <h6 align="justify" class="excerpt text-muted">{{ $item->excerpt }}</h6>
                                                            @else
                                                                <a href="{{ url('/post/' . $item->id) }}" class="nav-link">
                                                                    <h4 class="title my-2">{{ $item->title }}</h4>
                                                                    <h6 align="justify" class="excerpt text-muted">{{ $item->excerpt }}</h6>
                                                                </a>
                                                            @endif
                                                            <hr class="my-2">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex flex-column gap-1">
                                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                                                    @if ($item->status == 'draft')
                                                                        <span class="badge bg-secondary">Draft</span>
                                                                    @else
                                                                        <span class="badge bg-success">Published</span>
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex gap-1">
                                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update-post-modal">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <form action="{{route('posts.destroy', $item->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="row">
                            <div class="col d-block d-lg-none">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <h6 class="form-label">Current Password</h6>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="form-label">New Password</h6>
                                        <input type="password" name="newPassword" class="form-control" required>
                                    </div>
                                    <div class="mb-4">
                                        <h6 class="form-label">Confirm Password</h6>
                                        <input type="password" name="confirmPassword" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-body mb-4">
                                    <h6 class="card-title font-weight-bold">Support</h6>
                                    <p class="card-text">Get fast, free help from our friendly assistants.</p>
                                    <button type="button" class="btn btn-primary">Contact Us</button>
                                </div>
                                <div class="card card-body">
                                    <a href="/" class="btn text-success w-100 border fw-semibold text-start mb-2">
                                        Go Home
                                    </a>
                                    <a href="{{ route('dashboard.index') }}" class="btn text-primary w-100 border fw-semibold text-start mb-2">
                                        Admin Panel
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn text-danger w-100 border fw-semibold text-start">
                                            Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('client.partials.footer')

    @include('client.partials.modal')

    <!-- Bootstrap JavaScript for Tab Navigation -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="{{asset('js/script.js')}}"></script>
</body>

</html>
