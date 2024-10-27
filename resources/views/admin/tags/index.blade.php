@extends('admin.master')

@section('title')
    Tag | List
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

    <a href="{{route('tags.create')}}" class="btn btn-primary mb-4">Add new</a>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="text-uppercase">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $tag)
                    <tr>
                        <td>{{$tag->id}}</td>
                        <td>{{$tag->name}}</td>
                        <td>{{$tag->created_at}}</td>
                        <td>{{$tag->updated_at}}</td>
                        <td>
                            <form action="{{route('tags.destroy', $tag)}}" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{route('tags.edit', $tag)}}" class="btn btn-warning">Edit</a>
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
