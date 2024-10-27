@extends('client.master')

@section('titleBar')
    Home
@endsection

@section('content')
    <section class="row">
        <article class="col-md-12 col-lg-7">
            <div class="row">
                @if ($latestPost)
                    <div class="col-12 pb-5">
                        <div class="card bg-light border-0 h-100 shadow-sm">
                            @if ($latestPost->image)
                                <img src="{{ Storage::url($latestPost->image) }}" class="card-img-top" alt="">
                            @else
                                <img src="https://via.placeholder.com/150/aaa/FFF?text=image" class="card-img-top" alt="">
                            @endif
                            <div class="card-body p-4">
                                <a href="{{ url('/cate/' . $latestPost->category_id) }}" class="text-decoration-none fw-semibold text-primary text-uppercase">{{ $latestPost->category_name }}</a>
                                <a href="{{ url('/posts/' . $latestPost->id) }}" class="nav-link">
                                    <h4 class="text-ellipsis my-3">{{ $latestPost->title }}</h4>
                                    <h6 align="justify" class="text-ellipsis text-muted">{{ $latestPost->excerpt }}</h6>
                                </a>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($latestPost->created_at)->format('d M Y') }}</small>
                                    <small class="text-muted">By {{ $latestPost->author }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </article>
        
        <aside class="col-md-12 col-lg-5">
            @foreach ($asidePosts as $item)
                <div class="row g-0 bg-light border-0 shadow-sm mb-4" style="min-height: 200px">
                    <div class="col-md-5">
                        @if ($item->image)
                            <img src="{{ Storage::url($item->image) }}" class="img-fluid h-100" alt="">
                        @else
                            <img src="https://via.placeholder.com/150/aaa/FFF?text=image" class="img-fluid h-100" alt="">
                        @endif
                    </div>
                    <div class="col-md-7 p-3">
                        <a href="{{ url('/cate/' . $item->category_id) }}" class="text-decoration-none fw-semibold text-primary text-uppercase">{{ $item->category_name }}</a>
                        <a href="{{ url('/posts/' . $item->id) }}" class="nav-link mb-4">
                            <h6 class="text-ellipsis my-2">{{ $item->title }}</h6>
                            <p align="justify" class="text-ellipsis text-muted">{{ $item->excerpt }}</p>
                        </a>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                            <small class="text-muted text-truncate">By {{ $item->author }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </aside>
    </section>

    <section class="pt-5">
        <h2>Most Viewed</h2>

        <div class="text-end mb-4">
            <div id="crs-btn-prev" onclick="scrollPrev()" class="btn btn-outline-secondary border"><i class="bi bi-chevron-left"></i></div>
            <div id="crs-btn-next" onclick="scrollNext()" class="btn btn-outline-secondary border"><i class="bi bi-chevron-right"></i></div>
        </div>

        <ul id="crs-slider" class="d-flex gap-4 m-0">
            @foreach ($mostViewed as $item)
                <div class="col-6 col-lg-3">
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
                            <a href="{{ url('/posts/' . $item->id) }}" class="nav-link">
                                <h6 class="text-truncate my-3">{{ $item->title }}</h6>
                                <p align="justify" class="text-truncate text-muted">{{ $item->excerpt }}</p>
                            </a>
                            <hr>
                            <div class="d-flex flex-wrap justify-content-between">
                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                                <small class="text-muted text-truncate">By {{ $item->author }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </section>

@endsection
