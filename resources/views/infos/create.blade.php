@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("infos.index") }}">Products</a></li>
           <li class="breadcrumb-item " aria-current="page">Product create</li>
        </ol>
     </nav>

    <h3>Create Product</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    

    <form action="{{ route("infos.store") }}" method="POST" enctype="multipart/form-data">
        @csrf

        <multi-select data-mode="add" :data-categories="{{ json_encode($categories) }}"></multi-select>
        
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" id="title">
        </div>

        <div class="form-group">
            <label for="subtitle">Sub title:</label>
            <textarea name="subtitle" class="form-control" id="subtitle" rows="3"></textarea>
        </div>

        <info-file-select data-mode="add"></info-file-select>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

@section("javascript")
<script src="https://cdn.tiny.cloud/1/lcidoke8z58yahye4qdipgpqiadzheladm0c6pbea3gt42pc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
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