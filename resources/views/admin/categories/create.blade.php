@extends('admin.master')

@section('title')
    Category | Create
@endsection

@section('h1')
    Create
@endsection

@section('content')
    <div class="col col-md-4 m-auto">
        @if ($errors->any())
            @foreach ($errors->all() as $msg)
                <p class="badge bg-danger">{{$msg}}</p>
            @endforeach
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
    
            <div class="mb-3">
                <h6 class="form-label">Name</h6>
                <input type="text" name="name" id="name" class="form-control" autofocus />
            </div>
    
            <a href="javascript:history.back()" class="btn btn-dark">Back</a>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
