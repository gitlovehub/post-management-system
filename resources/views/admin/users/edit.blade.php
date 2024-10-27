@extends('admin.master')

@section('title')
    User | Update
@endsection

@section('h1')
    Update
@endsection

@section('content')
    <div class="col col-md-4 m-auto">
        @if ($errors->any())
            @foreach ($errors->all() as $msg)
                <p class="badge bg-danger">{{ $msg }}</p>
            @endforeach
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <h6 class="form-label">Type</h6>
                <select class="form-select" name="type">
                    <option value="admin"
                    <?= ($user->type == 'admin') ? 'selected' : '' ?>
                    >Admin</option>
                    <option value="member"
                    <?= ($user->type == 'member') ? 'selected' : '' ?>
                    >Member</option>
                </select>
            </div>

            <div class="form-check form-switch mb-5 fs-4">
                <label class="form-check-label" for="is_active">is_active</label>
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" @checked($user->is_active) />
            </div>

            <a href="javascript:history.back()" class="btn btn-dark">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
