@extends('admin.master')

@section('title')
    Post | Update
@endsection

@section('h1')
    Update
@endsection

@section('content')
    <div class="col col-md-6 m-auto">
        @if ($errors->any())
            @foreach ($errors->all() as $msg)
                <p class="badge bg-danger">{{ $msg }}</p>
            @endforeach
        @endif

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <h6 class="form-label">Category</h6>
                <select class="form-select" name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <h6 class="form-label">Title</h6>
                <input type="text" name="title" id="title" class="form-control" value="{{$post->title}}" />
            </div>
            <div class="mb-3">
                <h6 class="form-label">Excerpt</h6>
                <input type="text" name="excerpt" id="excerpt" class="form-control" value="{{$post->excerpt}}" />
            </div>
            <div class="mb-3">
                <h6 class="form-label">Description</h6>
                <textarea name="description" id="editor" rows="5">{{$post->description}}</textarea>
            </div>
            <div class="mb-3">
                <h6 class="form-label">Tags</h6>
                <div class="d-flex flex-wrap border rounded">
                    @foreach ($tags as $tag)
                        <div class="form-check m-3">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="tags[]" 
                                id="tag_{{ $tag->id }}" 
                                value="{{ $tag->id }}"
                                @if($post->tags->contains($tag->id)) checked @endif
                            >
                            <label class="form-check-label" for="tag_{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>            
            <div class="mb-3">
                <h6 class="form-label">Status</h6>
                <div class="d-flex border rounded p-3">
                    <div class="col form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" 
                        <?= ($post->status == 'draft') ? 'checked' : '' ?> />
                        <label class="form-check-label badge bg-secondary" for="statusDraft">
                            Draft
                        </label>
                    </div>
                    <div class="col form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusPublished" value="published" 
                        <?= ($post->status == 'published') ? 'checked' : '' ?> />
                        <label class="form-check-label badge bg-success" for="statusPublished">
                            Published
                        </label>
                    </div>
                </div>
            </div>            
            <div class="mb-3">
                <h6 class="form-label">Image</h6>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)" />
                <div class="d-inline-flex align-items-start mt-2">
                    @if ($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="" id="imagePreview" width="200px">
                        <span class="btn delete-file" onclick="deleteFile()">✖</span>
                    @endif
                </div>
            </div>            
            <div class="mb-3">
                <a href="javascript:history.back()" class="btn btn-dark">Back</a>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        ClassicEditor.create(document.querySelector('#editor')).catch( error => {
            console.error(error);
        });

        const imagePreview = document.getElementById('imagePreview');
        const deleteFileButton = document.querySelector('.delete-file');

        function previewImage(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    deleteFileButton.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                deleteFileButton.style.display = 'none';
            }
        }
    
        function deleteFile() {
            const imageInput = document.getElementById('image');

            imageInput.value = "";
            imagePreview.src = "#";
            imagePreview.style.display = 'none'; // Hide the image
            deleteFileButton.style.display = 'none'; // Hide delete button
        }
    </script>
@endsection