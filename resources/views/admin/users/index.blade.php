@extends('admin.master')

@section('title')
    User | List
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
                    <th>type</th>
                    <th>is_active</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->type == 'member')
                                <span class="badge bg-primary">Member</span>
                            @else
                                <span class="badge bg-info">Admin</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $user) }}" class="w-100 btn btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $data->links() }}
@endsection
