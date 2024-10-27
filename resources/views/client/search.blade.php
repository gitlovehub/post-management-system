@extends('client.master')

@section('titleBar')
    Seach
@endsection

@section('content')
    @if (!empty($kw))
        <h2 class="mb-5">Search Results for: {{ $kw }}</h2>
    @endif

    <div class="row">
        @foreach ($data as $item)
            <div class="col-12 col-sm-6 col-lg-3 mb-5">
                <div class="card bg-light border-0 h-100 shadow-sm">
                    @if ($item->image)
                        <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="">
                    @else
                        <img src="https://via.placeholder.com/150/aaa/FFF?text=image" class="card-img-top" alt="">
                    @endif
                    <div class="card-body p-4">
                        <a href="{{ url('/cate/' . $item->category_id) }}" class="text-decoration-none fw-semibold text-primary text-uppercase">{{ $item->category_name }}</a>
                        <a href="{{ url('/posts/' . $item->id) }}" class="nav-link">
                            <h5 class="text-ellipsis my-3">{{ $item->title }}</h5>
                            <h6 align="justify" class="text-ellipsis text-muted">{{ $item->excerpt }}</h6>
                        </a>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                            <small class="text-muted">By {{ $item->author }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
