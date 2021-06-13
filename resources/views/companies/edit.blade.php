@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("companies.index") }}">Companies</a></li>
           <li class="breadcrumb-item " aria-current="page">Company edit</li>
        </ol>
     </nav>

    <h3>{{ $company->name }}</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("companies.update", $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <multi-select data-mode="edit" :data-selected-categories="{{ json_encode($company->categories->pluck("id")) }}" :data-categories="{{ json_encode($categories) }}"></multi-select>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $company->name }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ $company->phone }}">
        </div>

        <div class="form-group">
            <label for="logo">Image:</label> 
            <input class="form-control-file border border-input-color bg-white p-1 rounded" id="logo" name="logo" type="file">
            @if(Storage::disk("s3")->exists(parse_url($company->logo)["path"])) 
                <img src="{{ $company->logo }}" class="img-fluid mt-3" style="max-width: 100px;"/>
            @endif
        </div>

        <company-additions :data-company="{{ json_encode($company) }}"></company-additions>

        <location-map data-name="{{ $company->name }}" data-coord-x="{{ $company->coord_x }}" data-coord-y="{{ $company->coord_y }}"></location-map>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection