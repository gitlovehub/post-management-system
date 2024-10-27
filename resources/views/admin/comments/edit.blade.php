@extends('admin.master')

@section('title')
    Comment | Update
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

        <form action="{{ route('comments.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <h6 class="form-label">Status</h6>
                <div class="d-flex border rounded p-3">
                    <div class="col form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusPending" value="pending" 
                        <?= ($comment->status == 'pending') ? 'checked' : '' ?> />
                        <label class="form-check-label badge bg-warning" for="statusPending">
                            Pending
                        </label>
                    </div>
                    <div class="col form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusPublished" value="published" 
                        <?= ($comment->status == 'published') ? 'checked' : '' ?> />
                        <label class="form-check-label badge bg-success" for="statusPublished">
                            Published
                        </label>
                    </div>
                </div>
            </div>

            <a href="javascript:history.back()" class="btn btn-dark">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
