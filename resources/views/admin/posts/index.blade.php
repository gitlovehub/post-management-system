@extends('admin.master')

@section('title')
    Post | List
@endsection

@section('h1')
    List
@endsection

@section('content')
    <div class="text-center">
        @if (session('msg'))
            <p class="badge rounded-pill text-bg-success">{{session('msg')}}</p>
        @endif
    </div>

    <a href="{{route('posts.create')}}" class="btn btn-primary mb-4">Add new</a>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="text-uppercase">
                <tr>
                    <th>id</th>
                    <th>image</th>
                    <th>title</th>
                    <th>view</th>
                    <th>tag</th>
                    <th>status</th>
                    <th>author</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>
                            @if ($post->image)
                                <img src="{{Storage::url($post->image)}}" alt="" width="100px">
                            @endif
                        </td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->view}}</td>
                        <td>{{$post->tag_name}}</td>
                        <td>
                            @if ($post->status == 'draft')
                                <span class="badge bg-secondary">draft</span>
                            @else
                                <span class="badge bg-success">Published</span>
                            @endif
                        </td>
                        <td>{{$post->author_name}}</td>
                        <td>{{$post->created_at}}</td>
                        <td>{{$post->updated_at}}</td>
                        <td class="text-center">
                            <form action="{{route('posts.destroy', $post->id)}}" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{route('posts.show', $post->id)}}" class="btn btn-success">View</a>
                                <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning">Edit</a>
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{$data->links()}}
@endsection
