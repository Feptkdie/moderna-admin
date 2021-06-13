@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
           <li class="breadcrumb-item " aria-current="page">Permission create</li>
        </ol>
    </nav>

    <h3>Create New Permission</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="products-create">
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Can products create">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection