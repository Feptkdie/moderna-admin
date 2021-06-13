@extends('layouts.app')
@section('content')

<div class="container">

    @include("flash_message")
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    
    
    <form action="{{ route("settings.store") }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ $phone }}">
        </div>

        <div class="form-group">
            <label for="about">About:</label>
            <textarea id="about" name="about" class="form-control">{{ $about }}</textarea>
        </div>

        <home-sliders :data-sliders="{{ json_encode($sliders) }}"></home-sliders>
        
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

@section("javascript")
<script src="https://cdn.tiny.cloud/1/lcidoke8z58yahye4qdipgpqiadzheladm0c6pbea3gt42pc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#about',
        image_class_list: [
            {
                title: 'img-responsive', 
                value: 'img-responsive'
            },
        ],
        height: 500,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
        },
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        image_advtab: true,
        image_title: true,
        // automatic_uploads: true,
        // images_upload_url: '/upload',
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }
    });
</script>
@endsection