@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
           <li class="breadcrumb-item " aria-current="page">Permission edit</li>
        </ol>
    </nav>

    <h3>{{ $permission->name }}</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route("permissions.update", $permission->id) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $permission->name }}">
        </div>

        <div class="form-group">
            <label for="code">Description:</label>
            <input type="text" name="description" class="form-control" id="code" placeholder="products-create" value="{{ $permission->description }}">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection