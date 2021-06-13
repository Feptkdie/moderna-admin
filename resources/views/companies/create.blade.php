@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("companies.index") }}">Companies</a></li>
           <li class="breadcrumb-item " aria-current="page">Company create</li>
        </ol>
     </nav>

    <h3>Create Company</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("companies.store") }}" method="POST" enctype="multipart/form-data">
        @csrf

        <multi-select data-mode="add" :data-categories="{{ json_encode($categories) }}"></multi-select>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" id="phone">
        </div>

        <div class="form-group">
            <label for="logo">Image:</label> 
            <input class="form-control-file border border-input-color bg-white p-1 rounded" id="logo" name="logo" type="file">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection