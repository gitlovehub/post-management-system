@extends('client.master')

@section('titleBar')
    Post – Details
@endsection

@section('content')
    <div class="col col-md-8 m-auto pb-5">
        @if ($post->image)
            <img src="{{Storage::url($post->image)}}" alt="" class="card-img" height="500px">
        @else
            <img src="https://via.placeholder.com/150/aaa/FFF?text=image" class="card-img" alt="">
        @endif
        <p class="my-4">
            <span class="text-muted">
                <label class="text-dark fw-semibold">By</label>
                {{ $post->author }},
            </span>
            <span class="text-muted">
                <label class="text-dark fw-semibold">at</label>
                {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}
            </span>
        </p>
        <h2 class="mb-4">{{ $post->title }}</h2>
        <p align="justify">{!! $post->description !!}</p>
    </div>

    <div class="col col-md-10 m-auto">
        <h2 class="my-5">Comments</h2>
    
        @if($comments->count() > 0)
            @foreach($comments as $comment)
                <div class="comment-box d-flex flex-wrap mb-5">
                    <div class="author-thumb me-3">
                        <img src="https://www.gravatar.com/avatar/?d=mp" alt="" class="rounded-circle" style="width: 85px;">
                    </div>
                    <div class="comment-info">
                        <h5><a href="javascript:void(0);" class="text-decoration-none">{{ $comment->name }}</a></h5>
                        <p>{{ $comment->comment }}</p>
                        <div class="reply">
                            <a href="javascript:void(0);" class="text-decoration-none">
                                <ion-icon name="arrow-redo-outline" style="transform: rotateY(-180deg);"></ion-icon>
                                Reply
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{$comments->links()}}
        @else
            <h6 class="text-muted">0 comments yet, be the first to comment!</h6>
        @endif
    </div>

    <div class="col col-md-10 m-auto border-top">
        <h2 class="mt-5 mb-4">Post a comment</h2>
    
        <form id="comment-form" action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf

            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <div class="mb-3">
                <div class="row">
                    @if (Auth::check())  <!-- Kiểm tra nếu người dùng đã đăng nhập -->
                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                    @else
                        <div class="col-md-6 mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <textarea name="comment" class="form-control" placeholder="Write a comment..." rows="4" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary text-uppercase px-4"><span>Send</span></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#comment-form').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn việc tải lại trang

                $.ajax({
                    url: $(this).attr('action'), // Địa chỉ gửi yêu cầu
                    type: 'POST',
                    data: $(this).serialize(), // Lấy dữ liệu từ form
                    success: function(response) {
                        // Xử lý khi gửi thành công
                        $('.message-success').text(response.msg); // Hiển thị thông điệp thành công
                        $('.toast-success').addClass('show');
                        $('.toast-progress').addClass('run');

                        setTimeout(function() {
                            $('.toast-success').removeClass('show');
                        }, 5000);

                        setTimeout(function() {
                            $('.toast-progress').removeClass('run');
                        }, 6000);

                        // Làm sạch form
                        $('#comment-form')[0].reset();
                    },
                    error: function(xhr) {
                        // Xử lý khi gửi bị lỗi
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = Object.values(errors).flat().join('\n');
                        alert(errorMessage); // Hiển thị lỗi cho người dùng
                    }
                });
            });
        });
    </script>
@endsection
