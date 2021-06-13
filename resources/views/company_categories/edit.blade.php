@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("company-categories.index") }}">Category companies</a></li>
           <li class="breadcrumb-item " aria-current="page">Category edit</li>
        </ol>
     </nav>

    <h3>{{ $category->name }}</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("company-categories.update", $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $category->name }}">
        </div>

        <div class="form-group">
            <label for="image">Image:</label> 
            <input class="form-control-file border border-input-color bg-white p-1 rounded" id="image" name="image" type="file">
            @if(Storage::disk("s3")->exists(parse_url($category->image)["path"])) 
                <img src="{{ $category->image }}" class="img-fluid mt-3" style="max-width: 100px;"/>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection