@extends('admin.master')

@section('title')
    Post | Detail
@endsection

@section('h1')
    Detail
@endsection

@section('content')
    <div class="col col-md-10 m-auto">
        <div class="card border-0">
            <div class="card-body">
                <a href="javascript:history.back()" class="btn btn-dark mb-2">Back</a>

                <h4 class="card-title">
                    <label class="text-primary">Category:</label>
                    <span>{{ $category->name }}</span>
                </h4>
                <h4 class="card-title">
                    <label class="text-primary">Title:</label>
                    <span>{{ $post->title }}</span>
                </h4>
                <h4 class="card-title">
                    <label class="text-primary">Excerpt:</label>
                    <span class="text-muted">{{ $post->excerpt }}</span>
                </h4>
                <h4 class="card-title">
                    <label class="text-primary">Descriptions:</label>
                </h4>
                <p align="justify" class="text-muted">{!! $post->description !!}</p>
            </div>
        </div>
    </div>
@endsection
