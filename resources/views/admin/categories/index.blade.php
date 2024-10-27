@extends('admin.master')

@section('title')
    Category | List
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

    <a href="{{route('categories.create')}}" class="btn btn-primary mb-4">Add new</a>

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
                @foreach ($data as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>{{$category->updated_at}}</td>
                        <td>
                            <form action="{{route('categories.destroy', $category)}}" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{route('categories.edit', $category)}}" class="btn btn-warning">Edit</a>
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
