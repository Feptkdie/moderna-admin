@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("notes.index") }}">List of SOS</a></li>
           <li class="breadcrumb-item " aria-current="page">SOS create</li>
        </ol>
     </nav>

    <h3>Create SOS</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    

    <form action="{{ route("notes.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Category:</label>
            <select class="form-control" name="category_id">
                <option value="">-- Select category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" id="title">
        </div>

        <div class="form-group">
            <label for="image">Image:</label> 
            <input class="form-control-file border border-input-color bg-white p-1 rounded" id="image" name="image" type="file">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" id="phone">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection