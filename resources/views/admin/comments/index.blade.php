@extends('admin.master')

@section('title')
    Comment | List
@endsection

@section('h1')
    List
@endsection

@section('content')
    <div class="text-center">
        @if (session('msg'))
            <p class="badge rounded-pill text-bg-success">{{ session('msg') }}</p>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="text-uppercase">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>comment</th>
                    <th>status</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->name }}</td>
                        <td>{{ $comment->email }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>
                            @if ($comment->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-success">Published</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at }}</td>
                        <td>{{ $comment->updated_at }}</td>
                        <td>
                            <form action="{{route('comments.destroy', $comment)}}" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('DELETE')
                                
                                <a href="{{route('comments.show', $comment)}}" class="btn btn-success">View</a>
                                <a href="{{ route('comments.edit', $comment) }}" class="btn btn-warning">Edit</a>
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $data->links() }}
@endsection
